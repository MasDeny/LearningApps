<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Rakit\Validation\Validator;

require APPPATH . '/libraries/REST_Controller.php';

class Profile extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load the user model
        $this->load->model('authModel');
        $this->load->model('teacherModel');
        $this->load->model('studentModel');
        $this->load->library('upload');
        $this->load->library('pagination');
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

            $this->profile_validate($validator, $type = 'register');
            $data = $this->do_upload();

            $userData = array(
                'username' => strip_tags($this->post('username')),
                'email' => $email,
                'password' => md5($this->post('password')),
                'role' => strip_tags($this->post('role')),
            );



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
                'class' => strip_tags($this->post('class'))
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
        $name = date("d-m-Y") . "-" . str_replace(' ', '_', $this->post('username') . "-" . $_FILES["file"]['name']);
        $config['upload_path'] = $dir;
        $config['allowed_types'] = 'jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = 1024;
        $config['file_name'] = $name;

        if (file_exists($dir . $name)) {
            unlink($dir . $name);
        }

        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {

            return array('status' => TRUE, 'message' => $dir . $name);

        } else {

            return array('status' => FALSE, 'message' => "Gagal Upload, pastikan file sebesar 1MB dan berformat jpg|png|jpeg");
        }
    }

    public function update_post()
    {
        // put method harus menggunakan x-www-form-urlencode

        $id = $this->post('id');
        $role = $this->post('role') == 'murid' ? "students/" : "staff/";
        $dir = "upload/profile/" . $role;
        $validator = new Validator;
        $this->profile_validate($validator, $type = 'update');

        $con['returnType'] = 'single';
        $con['id'] = $id;


        $this->post('role') == 'murid' ? $result = $this->studentModel->getRows($con) : $result = $this->teacherModel->getRows($con);

        if (empty($result)) {
            $this->response([
                'status' => false,
                'message' => 'Data Not Found'
            ], REST_Controller::HTTP_BAD_REQUEST);
        };

        $photo = $result['profilePhoto'];

        // $this->response(!empty($_FILES["file"]['name']));

        if (!empty($_FILES["file"]['name'])) {
            $data = $this->do_upload();
            if (!$data['status']) {
                
                // Set the response and exit
                $this->response([
                    'status' => $data['status'],
                    'message' => $data['message']
                ], REST_Controller::HTTP_FORBIDDEN);
            }
            unlink($photo);
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
                    'status' => false,
                    'message' => 'Some problems occurred, please try again.'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Provide at least one user info to update.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    private function profile_validate($validator, $type)
    {

        $validator->setMessages([
            'required' => ':attribute harap untuk diisi',
            'uploaded_file' => 'pastikan file sebesar 1MB dan berformat jpg|png|jpeg',
            'numeric' => 'Input harus berupa angka'
            // etc
        ]);

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

        $data->validate();

        if ($type=='register') {
            $photo = $validator->make($_FILES, [
                'file'      => 'required|uploaded_file|max:1M|mimes:jpg,jpeg,png,bmp',
            ]);
            $photo->validate();
        }

        // then validate

        if ($data->fails() || $type=='register' ? $photo->fails() : false) {

            // handling errors
            $this->response([
                'status' => FALSE,
                'message' => $data->errors()->firstOfAll()
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

    public function show_get($role = null)
    {

        $id = (int) $this->input->get('id');
        $class = (int) $this->input->get('class');

        $con['returnType'] = 'getall';
        $con['conditions'] = array(
            'role' => $role,
            // 'status' => 1
        );

        $role == 'murid' ? $con['joinData'] = 'murid' : false;
        $role == 'guru' ? $con['joinData'] = 'guru' : false;

        if ($id != null) $con['id'] = $id;

        $page = $this->pagination($role, $class);

        if (empty($id)) {

            if (!empty($class) && $role == 'murid') {
                $con['conditions'] = array(
                    'Students.class' => $class,
                );
            }

            $con['limit'] = $page['per_page'];
            $con['start'] = $page['start'];
        }

        $result = $this->authModel->getRows($con);

        if ($result) {
            $data = array();
            if (empty($id)) {
                foreach ($result as $row) {
                    // if this is the first clip of a new sheet, make a new entry for it
                    $profile_data = empty($con['limit']) ? $this->get_data($row, $role) : $this->get_data($row, $role);

                    // add the current clip to the sheet
                    array_push($data, $profile_data);
                }
                $result_all['pagination'] = $this->pagination->create_links();
                $result_all['result'] = $data;
            } else {
                $result_all = $this->get_data($result, $role);
            }

            $this->response([
                'status' => TRUE,
                'message' => $result_all
            ], REST_Controller::HTTP_OK);
        } else {
            // Set the response and exit
            //BAD_REQUEST (400) being the HTTP response code
            $this->response([
                'status' => FALSE,
                'message' => 'Data Tidak Ditemukan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    private function get_data($row, $role)
    {
        $profile_data = array(
            'id'                => (int) $row['idUsers'],
            'username'          => $row['Username'],
            'email'             => $row['Email'],
            'role'              => $row['Role'],
            'numberIdentity'    => $role == 'murid' ? $row['idStudents'] : $row['idTeachers'],
            'fullname'          => $row['name'],
            'bornOfDate'        => $row['bornOfDate'],
            'gender'            => $row['gender'],
            'religion'          => $row['religion'],
            'address'           => json_decode($row['address']),
            'phone'             => (int) $row['phone'],
            'profilePhoto'      => base_url() . $row['profilePhoto'],
            'device'            => (int) $row['Device'],
            'status'            => $row['Status'] == 0 ? 'deactivate' : 'active',
            'create_time'   => $row['create_time'],
            'update_time'   => $row['update_time']
        );

        $role == 'murid' ? $profile_data['class'] = (int) $row['class'] : $profile_data['position'] = $row['position'];

        return $profile_data;
    }

    private function pagination($role, $class)
    {
        $cnt['returnType'] = 'count';
        $cnt['conditions'] = array(
            'role' => $role,
            // 'status' => 1
        );
        if (!empty($class) && $role == 'murid') {
            $cnt['conditions'] = array(
                'Students.class' => $class,
            );
        }
        $role == 'murid' ? $cnt['joinData'] = 'murid' : false;
        $role == 'guru' ? $cnt['joinData'] = 'guru' : false;

        $config = array();
        $config["base_url"] = base_url() . "profile/" . $role;
        $config["total_rows"] = $this->authModel->getRows($cnt);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['attributes'] = array('class' => 'page-link');
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li class="page-item">';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"]  = '<li class="page-item">';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = 'Next';
        $config["next_tag_open"] = '<li class="page-item">';
        $config["next_tag_close"] = '</li>';
        $config['prev_link'] = 'Previous';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';
        $config["cur_tag_open"] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //$config['display_pages'] = FALSE;
        $config["last_link"] = "Last";
        $config["first_link"] = "First";
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);

        $page =  $this->uri->segment(3);

        $this->pagination->initialize($config);
        $start = ($page - 1) * $config["per_page"];

        return array(
            'start' => $start,
            'per_page'  => $config["per_page"]
        );
    }
}

/* End of file Profile.php */