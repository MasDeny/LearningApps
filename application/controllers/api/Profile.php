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

    // fungsi untuk menambahkan user pada aplikasi
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
            'username'              => 'required|min:3',
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
            $upload = $this->do_upload();

            $userData = array(
                'username' => strip_tags($this->post('username')),
                'email' => $email,
                'password' => md5($this->post('password')),
                'role' => strip_tags($this->post('role')),
            );

            if ($upload['status']) {
                $insert = $this->authModel->insert($userData);
                $profile = $this->add_profile($insert, $upload['message']);
            } else {
                @unlink($_FILES[$upload['message']]);
                $this->response([
                    'status' => $upload['status'],
                    'message' => $upload['message']
                ], REST_Controller::HTTP_BAD_REQUEST);
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
                @unlink($_FILES[$upload['message']]);
                // Set the response and exit
                $this->response([
                    'status' => False,
                    'message' => 'Some problems occurred, please try again.'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    // fungsi untuk memperbaharui data profile pengguna
    public function update_post()
    {
        // $this->response($_FILES["file"]['name']);
        // var_dump($_FILES["file"]['name']);
        // die();
        // put method harus menggunakan x-www-form-urlencode
        $id = $this->post('id');
        $role = $this->post('role') == 'murid' ? "students/" : "staff/";
        $dir = "upload/profile/" . $role;
        if (!empty($this->post('username'))) {
            $validator = new Validator;
            $this->profile_validate($validator, $type = 'update');
        }

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

        if (!empty($_FILES["file"]['name'])) {
            $data = $this->do_upload();
            if (!$data['status']) {

                // Set the response and exit
                $this->response([
                    'status' => $data['status'],
                    'message' => $data['message']
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            if (!empty($photo)) {
                unlink($photo);
            }
            $photo = $data['message'];
        }

        $profileData = $this->profile_data($result);

        if (!empty($id)) {

            // Update user's account data
            if ($this->post('role') == 'murid') {

                $student = array(
                    'idStudents'    => strip_tags($this->post('id')),
                    'class'         => empty($this->post('class')) ? $result['class'] : strip_tags($this->post('class')),
                    'schoolYear'         => empty($this->post('years')) ? $result['schoolYear'] : strip_tags($this->post('years')),
                    'profilePhoto'  => $photo
                );

                $data = array_merge($student, $profileData);
                $update = $this->studentModel->update($data, $id);
            } else {
                $teacher = array(
                    'idTeachers' => strip_tags($this->post('id')),
                    'position' => empty($this->post('position')) ? $result['position'] : strip_tags($this->post('position')),
                    'profilePhoto'  => $photo
                );

                $data = array_merge($teacher, $profileData);
                $update = $this->teacherModel->update($data, $id);
            }

            // Check if the user data is updated
            if ($update) {
                $this->post('role') == 'murid' ? $con['joinData'] = 'murid' : false;
                $this->post('role') == 'guru' ? $con['joinData'] = 'guru' : false;

                $con['id'] = $result['idUsers'];

                $data = $this->authModel->getRows($con);
                $result = $this->get_data($data, $this->post('role'));
                // Set the response and exit
                $this->response([
                    'status'    => TRUE,
                    'message'   => 'Pengguna berhasil diperbaharui',
                    'result'    => $result
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

    // fungsi untuk menampilkan pengguna yang terdaftar
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

    // fungsi untuk edit data pada tabel users
    public function user_post()
    {
        $id = $this->post('id');
        $banned = $this->input->get('ban');

        $con['returnType'] = 'single';
        $con['id'] = $id;

        $result = $this->authModel->getRows($con);

        if (empty($result)) {
            $this->response([
                'status' => false,
                'message' => 'Data Not Found'
            ], REST_Controller::HTTP_BAD_REQUEST);
        };

        $data = array();

        if (!empty($banned)) {
            if ($banned == 'true') {
                $data['status'] = 0;
                $edited = $this->authModel->update($data, $id);
                if ($edited) {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Pengguna Berhasil Dinonaktifkan'
                    ], REST_Controller::HTTP_OK);
                } else {
                    // Set the response and exit
                    //BAD_REQUEST (400) being the HTTP response code
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Gagal Menonaktifkan Pengguna'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $data['status'] = $result['Role'] == 'murid' ? 1 : 2;
                $edited = $this->authModel->update($data, $id);
                if ($edited) {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Pengguna Berhasil Di Aktifkan'
                    ], REST_Controller::HTTP_OK);
                } else {
                    // Set the response and exit
                    //BAD_REQUEST (400) being the HTTP response code
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Gagal Mengaktifkan Pengguna'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        } else {
            $data = array(
                'email' => empty($this->post('email')) ? $result['Email'] : strip_tags($this->post('email')),
                'username' => empty($this->post('username')) ? $result['Username'] : strip_tags($this->post('username')),
                'password' => empty($this->post('password')) ? $result['Password'] : md5($this->post('password')),
                'role' => empty($this->post('role')) ? $result['Role'] : strip_tags($this->post('role')),
                'device' => empty($this->post('device')) ? $result['Device'] : strip_tags($this->post('device'))
            );

            $this->check_email();

            $validator = new Validator;

            $validator->setMessages([
                'email' => ':email tidak valid',
                'same' => 'Silahkan masukkan ulang password dengan benar dan sama',
                'min' => 'Panjang :attribute minimal sepanjang :min karakter'
                // etc
            ]);

            // make role validation
            $validate = $validator->make($this->post(), [
                //validasi user
                'email'                 => 'email',
                'username'              => 'min:3',
                'password'              => 'min:6',
                'password_confirm'      => 'same:password'
            ]);

            // then validate
            $validate->validate();

            if ($validate->fails()) {

                $this->response([
                    'status' => FALSE,
                    'message' => $validate->errors()->firstOfAll()
                ], REST_Controller::HTTP_FORBIDDEN);
            }

            $edited = $this->authModel->update($data, $id);
            if ($edited) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Data Pengguna Berhasil Diperbaharui'
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                //BAD_REQUEST (400) being the HTTP response code
                $this->response([
                    'status' => FALSE,
                    'message' => 'Gagal Memperbaharui Data Pengguna'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    // check password process saat register maupun update
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

    // fungsi untuk menambahkan profile setelah register user
    protected function add_profile($userId, $photo)
    {
        $profileData = $this->profile_data($data = null);
        $thirdData = array(
            'idUsers' => $userId,
            'profilePhoto' => $photo
        );

        if ($this->post('role') == 'murid') {

            $student = array(
                'idStudents' => strip_tags($this->post('id')),
                'class' => strip_tags($this->post('class')),
                'schoolYear' => strip_tags($this->post('years'))
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

    // fungsi untuk melakukan upload foto profile
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

    // fungsi untuk validasi data pada profile
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

        if ($type == 'register') {
            $photo = $validator->make($_FILES, [
                'file'      => 'required|uploaded_file|max:1M|mimes:jpg,jpeg,png,bmp',
            ]);
            $photo->validate();
        }

        // then validate
        if ($type == 'register' ? $photo->fails() : false) {
            // handling errors
            $this->response([
                'status' => FALSE,
                'message' => $data->fails() ? $data->errors()->firstOfAll() : $photo->errors()->firstOfAll()
            ], REST_Controller::HTTP_FORBIDDEN);
        }

        if ($data->fails()) {
            // handling errors
            $this->response([
                'status' => FALSE,
                'message' => $data->fails() ? $data->errors()->firstOfAll() : $photo->errors()->firstOfAll()
            ], REST_Controller::HTTP_FORBIDDEN);
        }
    }

    // fungsi untuk mengambil data post
    private function profile_data($data)
    {
        $j_adrs = json_decode($data['address']);
        $address = json_encode([
            'address' => empty($this->post('address')) ? $j_adrs->{'address'} : strip_tags($this->post('address')),
            'city' => empty($this->post('city')) ? $j_adrs->{'city'} : strip_tags($this->post('city')),
            'state' => empty($this->post('state')) ? $j_adrs->{'state'} : strip_tags($this->post('state')),
            'zip' => empty($this->post('zip')) ? $j_adrs->{'zip'} : strip_tags($this->post('zip'))
        ]);

        $bod = explode(', ', $data['bornOfDate']);

        $bornofDate = array(
            'place' => empty($this->post('place')) ? $bod[0] : strip_tags($this->post('place')),
            'date' => empty($this->post('date')) ? $bod[1] : strip_tags($this->post('date'))
        );

        $profileData = array(
            'name' => empty($this->post('fullname')) ? $data['name'] : strip_tags($this->post('fullname')),
            'bornOfDate' => empty($this->post('place') || $this->post('date')) ? $data['bornOfDate'] : $bornofDate['place'] . ', ' . $bornofDate['date'],
            'gender' => empty($this->post('gender')) ? $data['gender'] : strip_tags($this->post('gender')),
            'religion' => empty($this->post('religion')) ? $data['religion'] : strip_tags($this->post('religion')),
            'address' => $address,
            'phone' => empty($this->post('phone')) ? $data['phone'] : strip_tags($this->post('phone'))
        );

        return $profileData;
    }

    // fungsi untuk menampilkan data pada saat get 
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
            'level'             => $role == 'murid' ? (int) $row['level'] : 0,
            'status'            => $row['Status'] == 0 ? 'deactivate' : 'active',
            'create_time'   => $row['create_time'],
            'update_time'   => $row['update_time']
        );

        if ($role == 'murid') {
            $profile_data['class'] = $row['class'];
            $profile_data['schoolYear'] = $row['schoolYear'];
        } else {
            $profile_data['position'] = $row['position'];
        }

        return $profile_data;
    }

    // fungsi untuk menampilkan pagination
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