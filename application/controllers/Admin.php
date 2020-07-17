<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Rakit\Validation\Validator;

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load the user model
        $this->load->model('authModel');
        $this->load->model('teacherModel');
        $this->load->helper('login');
    }

    public function index()
    {
        echo json_encode(true);
    }

    public function login()
    {
        if (is_logged_in()) {
            if ($this->session->userdata('user_data')['role'] == 'administrator') {
                redirect('dashboard/admin_dash');
            } else {
                redirect('dashboard');
            }
        }
        $this->load->view('login');
    }

    public function logout()
    {
        $this->session->set_userdata('user_data');
        // destory session
        $this->session->sess_destroy();

        redirect('admin/login');
    }

    public function cek_login()
    {
        // Get the post data
        $email = strip_tags($this->input->post('email'));
        $password = $this->input->post('password');
        // Check if any user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'email' => $email,
            'password' => md5($password),
            // 'status' => 1
        );

        $result = $this->authModel->getRows($con);

        if ($result) {

            if ($result['Role'] == 'murid') {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => FALSE,
                    'message' => 'Anda tidak di ijinkan untuk mengakses halaman dashboard'
                ]);
                return true;
            }

            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'idUsers' => $result['idUsers'],
                // 'status' => 1
            );
            $profile = $this->teacherModel->getRows($con);

            //strutured data
            $finalResult = array(
                'id'                => (int) $result['idUsers'],
                'username'          => $result['Username'],
                'email'             => $result['Email'],
                'role'              => $result['Role'],
                'numberIdentity'    => $profile['idTeachers'],
                'fullname'          => $profile['name'],
                'position'          => $profile['position'],
                'bornOfDate'        => $profile['bornOfDate'],
                'gender'            => $profile['gender'],
                'religion'          => $profile['religion'],
                'address'           => json_decode($profile['address']),
                'phone'             => $profile['phone'],
                'profilePhoto'      => base_url() . $profile['profilePhoto'],
                'status'            => $result['Status'] == 0 ? 'deactivate' : 'active',
                'create_time'   => $result['create_time'],
                'update_time'   => $result['update_time']
            );

            $this->session->set_userdata('user_data', $finalResult);

            // echo "Interest (Array Example): " . $this->session->userdata('user_data')['id'];

            // Set the response and exit
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => TRUE,
                'message' => 'Login Berhasil',
                'result' => $finalResult
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => FALSE,
                'message' => 'Email atau password salah'
            ]);
        }
    }

    public function update_password()
    {
        if ($this->session->userdata('user_data')['role'] == 'administrator') {
            $id = $this->input->post('id');
            $validator = new Validator;
            $data = $validator->make($this->input->post(), [
                'new_password'              => 'required|min:6',
                'password_confirm'          => 'required|same:new_password'
            ]);

            // then validate
            $data->validate();

            if ($data->fails()) {

                // handling errors
                $errors = $data->errors();

                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => FALSE,
                    'message' => $errors->firstOfAll()
                ]);
            } else {
                $newPassword = $this->input->post()('new_password');
                $userData = array();
                $userData['password'] = md5($newPassword);
                // $userData['status'] = 1;

                $update = $this->authModel->update($userData, $id);

                // Check if the user data is updated
                if ($update) {
                    // Set the response and exit
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => true,
                        'message' => 'Password Berhasil Diperbaharui'
                    ]);
                } else {
                    // Set the response and exit
                    http_response_code(400);
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => FALSE,
                        'message' => 'Proses gagal, silahkan refresh halaman'
                    ]);
                }
            }
        } else {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => FALSE,
                'message' => "You Don't Have access in Here"
            ]);
        }
    }
}

/* End of file Admin.php */
