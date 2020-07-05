<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Rakit\Validation\Validator;

require APPPATH . '/libraries/REST_Controller.php';

class Profile extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load the user model
        $this->load->model('authModel');
        $this->load->model('teacherModel');
        $this->load->model('studentModel');
        $this->load->library('upload');

    }

    // check password process
    private function check_email()
    {
        $email = strip_tags($this->post('email'));
        $con['returnType'] = 'count';
        $con['conditions'] = array(
            'email' => $email,
        );
        $userCount = $this->authModel->getRows($con);

        if ($userCount > 0) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Email duplicate, please use another email'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function register_post()
    {
        // check duplicate email on database
        $email = strip_tags($this->post('email'));

        $this->check_email();

        $validator = new Validator;

        $validator->setMessages([
            'required' => ':attribute harap untuk diisi',
            'email' => ':email tidak valid',
            'same' => 'Silahkan masukkan ulang password dengan benar dan sama',
            'min' => 'Panjang :attribute minimal sepanjang :min karakter'
            // etc
        ]);

        // make role validation
        $data = $validator->make($this->post(), [
            //validasi user
            'email'                 => 'required|email',
            'username'              => 'required|min:5',
            'password'              => 'required|min:6',
            'password_confirm'      => 'required|same:password',
            'role'                  => 'required'
        ]);

        // then validate
        $data->validate();

        if ($data->fails()) {

            $this->response([
                'status' => FALSE,
                'message' => $data->errors()->firstOfAll()
            ], REST_Controller::HTTP_FORBIDDEN);
        } else {

            if ($this->post('check') != 'on') {

                $this->profile_validate($validator);
            }

            $userData = array(
                'username' => strip_tags($this->post('username')),
                'email' => $email,
                'password' => md5($this->post('password')),
                'role' => strip_tags($this->post('role')),
            );

            
            $data = $this->do_upload();
            
            if ($data['status']) {
                $insert = $this->authModel->insert($userData);
                $profile = $this->add_profile($insert, $data['message']);
            } else {
                @unlink($_FILES[$data['message']]);
                $this->response([
                    'status' => $data['status'],
                    'message' => $data['message']
                ], REST_Controller::HTTP_FORBIDDEN);
            }

            // Check if the user data is inserted
            if ($insert && $profile) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'Pengguna berhasil ditambahkan'
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->authModel->delete($insert);
                @unlink($_FILES[$data['message']]);
                // Set the response and exit
                $this->response([
                    'status' => False,
                    'message' => 'Some problems occurred, please try again.'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    // fungsi untuk menambahkan profile setelah register user
    protected function add_profile($userId, $photo)
    {
        $profileData = $this->profile_data();
        $thirdData = array(
            'idUsers' => $userId,
            'profilePhoto' => $photo
        );

        if ($this->post('role') == 'murid') {

            $student = array(
                'idStudents' => strip_tags($this->post('id')),
                'class' => strip_tags($this->post('class')),
            );
            $data = array_merge($student, $thirdData, $profileData);

            $insert = $this->studentModel->insert($data);
            return $insert;
        } else {
            $teacher = array(
                'idTeachers' => strip_tags($this->post('id')),
                'position' => strip_tags($this->post('position'))
            );

            $data = array_merge($teacher, $thirdData, $profileData);

            $insert = $this->teacherModel->insert($data);
            return $insert;
        }
    }

    protected function do_upload()
    {
        $role = $this->post('role') == 'murid' ? "students/" : "staff/";
        $dir = "upload/profile/" . $role;
        $name = str_replace(' ', '_', $this->post('username') . "-" . $_FILES["file"]['name']); //. date.now());
        $config['upload_path'] = $dir;
        $config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = 1024;
        $config['file_name'] = $name;

        if (file_exists($dir . $name)) {
            unlink($dir . $name);
        }

        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {

            return array('status' => TRUE, 'message' => $dir . $name);
        } else {

            return array('status' => FALSE, 'message' => "Gagal Upload Silahkan Ulangi");
        }
    }

    public function update_post()
    {
        // put method harus menggunakan x-www-form-urlencode

        $id = $this->post('id');
        $role = $this->post('role') == 'murid' ? "students/" : "staff/";
        $dir = "upload/profile/" . $role;
        $validator = new Validator;
        $this->profile_validate($validator);

        $con['returnType'] = 'single';
        $con['id'] = $id;
        
        $this->post('role')=='murid' ? $result = $this->studentModel->getRows($con) : $result = $this->teacherModel->getRows($con);

        $photo = $result['profilePhoto'];

        if ($result['profilePhoto'] != $dir . $_FILES["file"]['name']) {
            $data = $this->do_upload();
            if (!$data['status']) {
                @unlink($_FILES[$data['message']]);
                // Set the response and exit
                $this->response([
                    'status' => $data['status'],
                    'message' => $data['message']
                ], REST_Controller::HTTP_FORBIDDEN);
            }
            // @unlink($result['profilePhoto']);
            $photo = $data['message'];
        }

        $profileData = $this->profile_data();

        if (!empty($id)) {

            // Update user's account data
            if ($this->post('role') == 'murid') {

                $student = array(
                    'idStudents'    => strip_tags($this->post('id')),
                    'class'         => strip_tags($this->post('class')),
                    'profilePhoto'  => $photo
                );
                $data = array_merge($student, $profileData);
    
                $update = $this->studentModel->update($data, $id);
            } else {
                $teacher = array(
                    'idTeachers' => strip_tags($this->post('id')),
                    'position' => strip_tags($this->post('position')),
                    'profilePhoto'  => $photo
                );
    
                $data = array_merge($teacher, $profileData);
    
                $update = $this->teacherModel->update($data, $id);
            }

            // Check if the user data is updated
            if ($update) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'The user info has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'Some problems occurred, please try again.'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'message' => 'Provide at least one user info to update.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    private function profile_validate($validator)
    {
        $data = $validator->make($this->post(), [
            // validasi profile
            'id'        => 'required|min:3',
            'fullname'  => 'required|min:3',
            'place'     => 'required',
            'date'      => 'required',
            'gender'    => 'required',
            'religion'  => 'required',
            'phone'     => 'required|numeric',
            'address'   => 'required',
            'city'      => 'required',
            'state'     => 'required',
            'zip'       => 'required|numeric',
        ]);

        $photo = $validator->make($_FILES, [
            'file'      => 'required|uploaded_file|max:2M|mimes:jpg,jpeg,png',
        ]);

        // then validate
        $data->validate();
        $photo->validate();

        if ($data->fails() || $photo->fails()) {

            // handling errors
            $this->response([
                'status' => FALSE,
                'message' => $data->fails()?$data->errors()->firstOfAll():$photo->errors()->firstOfAll()
            ], REST_Controller::HTTP_FORBIDDEN);
        }
    }

    private function profile_data()
    {
        $address = json_encode([
            'address' => strip_tags($this->post('address')),
            'city' => strip_tags($this->post('city')),
            'state' => strip_tags($this->post('state')),
            'zip' => strip_tags($this->post('zip'))
        ]);

        $profileData = array(
            'name' => strip_tags($this->post('fullname')),
            'bornOfDate' => $this->post('place') . ', ' . $this->post('date'),
            'gender' => strip_tags($this->post('gender')),
            'religion' => strip_tags($this->post('religion')),
            'address' => $address,
            'phone' => strip_tags($this->post('phone'))
        );

        return $profileData;
    }

}

/* End of file Profile.php */
