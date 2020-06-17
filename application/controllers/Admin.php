<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the user model
        $this->load->model('authModel');
    }

    public function dashboard()
    {
        $this->load->view('admin/overview');
    }

    public function login()
	{
		$this->load->view('login');
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

            //strutured data
            $finalResult = array(
                'id'            => (int) $result['idUsers'],
                'username'      => $result['Username'],
                'email'         => $result['Email'],
                'role'          => $result['Role'],
                'device'        => (int)$result['Device'],
                'status'        => $result['Status'] == 0 ? 'deactivate' : 'active',
                'create_time'   => $result['create_time'],
                'update_time'   => $result['update_time']
            );
            
            // Set the response and exit
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => TRUE,
                'message' => 'User login successful.',
                'result' => $finalResult
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => FALSE,
                'message' => 'Wrong email or password.'
            ]);
        }
    }

}

/* End of file Admin.php */
