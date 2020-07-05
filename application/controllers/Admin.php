<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load the user model
        $this->load->model('authModel');
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
            }else{
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
            //strutured data
            $finalResult = array(
                'id'            => (int) $result['idUsers'],
                'username'      => $result['Username'],
                'email'         => $result['Email'],
                'role'          => $result['Role'],
                'device'        => (int) $result['Device'],
                'status'        => $result['Status'] == 0 ? 'deactivate' : 'active',
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
}

/* End of file Admin.php */
