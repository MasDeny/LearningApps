<?php

defined('BASEPATH') or exit('No direct script access allowed');

// use chriskacerguis\RestServer\RestController;
use Rakit\Validation\Validator;

require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load the user model
        $this->load->model('authModel');
    }

    // check password process
    private function check_email($email)
    {
        $con['returnType'] = 'count';
        $con['conditions'] = array(
            'email' => $email,
        );
        $userCount = $this->authModel->getRows($con);

        if ($userCount > 0) {
            $this->response([
                'status' => FALSE,
                'message' => 'Email duplicate, please use another email'
            ], REST_Controller::HTTP_FORBIDDEN);
        }
    }

    public function index_get()
    {
        $this->response( [
            'status' => true,
            'message' => 'API Server For E-Learning'
        ], REST_Controller::HTTP_FORBIDDEN );
    }

    // login process 
    public function login_post()
    {
        // Get the post data
        $email = strip_tags($this->post('email'));
        $password = $this->post('password');

        // Validate the post data
        if (!empty($email) && !empty($password)) {

            // Check if any user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'email' => $email,
                'password' => md5($password),
                // 'status' => 1
            );
            $result = $this->authModel->getRows($con);

            $finalResult = array(
                'id'            => $result['idUsers'],
                'username'      => $result['Username'],
                'email'         => $result['Email'],
                'role'          => $result['Role'],
                'status'        => $result['Status'] == 0 ? 'deactivate' : 'active',
                'create_time'   => $result['create_time'],
                'update_time'   => $result['update_time']
            );

            if ($result) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User login successful.',
                    'result' => $finalResult
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                //BAD_REQUEST (400) being the HTTP response code
                $this->response("Wrong email or password.", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response("Provide email and password.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // register process
    public function register_post()
    {
        // return $this->response($this->post());
        // $schoolID = strip_tags($this->post('idSekolah'));

        // check duplicate email on database
        $email = strip_tags($this->post('email'));
        $this->check_email($email);

        $validator = new Validator;

        // make role validation
        $data = $validator->make($this->post(), [
            'email'                 => 'required|email',
            'username'              => 'required|min:5',
            'password'              => 'required|min:6',
            'password_confirm'      => 'required|same:password',
            'role'                  => 'required'
        ]);

        // then validate
        $data->validate();

        if ($data->fails()) {

            // handling errors
            $errors = $data->errors();
            $this->response([
                'status' => FALSE,
                'message' => $errors->firstOfAll()
            ], REST_Controller::HTTP_FORBIDDEN);
        } else {

            $userData = array(
                'username' => strip_tags($this->post('username')),
                'email' => $email,
                'password' => md5($this->post('password')),
                'role' => strip_tags($this->post('role')),
            );

            $insert = $this->authModel->insert($userData);

            // Check if the user data is inserted
            if ($insert) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'The user has been added successfully.'
                ], REST_Controller::HTTP_CREATED);
            } else {
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function update_put()
    {
        // put method harus menggunakan x-www-form-urlencode

        $id = $this->put('id');

        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'idUsers' => $id
        );
        $result = $this->authModel->getRows($con);

        // check duplicate email
        $email = strip_tags($this->post('email'));
        $this->check_email($email);

        // Get the post data
        $username = strip_tags($this->put('username'));
        $email = strip_tags($this->put('email'));
        $password = $this->put('password');
        $role = strip_tags($this->put('role'));
        $status = strip_tags($this->put('status'));

        // Validate the post data
        if (!empty($id) && (!empty($username) || !empty($status) || !empty($email) || !empty($password) || !empty($role))) {
            // Update user's account data
            $userData = array();

            !empty($username) ? $userData['username'] = $username : $userData['username'] = $result['Username'];

            !empty($password) ? $userData['password'] = md5($password) : $userData['password'] = $result['Password'];

            !empty($email) ? $userData['email'] = $email : $userData['email'] = $result['Email'];

            !empty($role) ? $userData['role'] = $role : $userData['role'] = $result['Role'];

            !empty($status) ? $userData['status'] = $status : $userData['status'] = $result['Status'];

            $update = $this->authModel->update($userData, $id);

            // Check if the user data is updated
            if ($update) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'The user info has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response("Provide at least one user info to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // change password
    public function change_put()
    {
    
        $email = strip_tags($this->put('email'));
        $oldPassword = $this->put('old_password');
        // Check if any user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'email' => $email,
            'password' => md5($oldPassword)
        );
        $result = $this->authModel->getRows($con);

        if (!$result > 0) {
            // handling errors
            $this->response([
                'status' => FALSE,
                'message' => 'wrong old password'
            ], REST_Controller::HTTP_FORBIDDEN);
        }

        $id = $result['idUsers'];

        $validator = new Validator;
        $data = $validator->make($this->put(), [
            'new_password'              => 'required|min:6',
            'password_confirm'          => 'required|same:new_password'
        ]);

        // then validate
        $data->validate();

        if ($data->fails()) {

            // handling errors
            $errors = $data->errors();
            $this->response([
                'status' => FALSE,
                'message' => $errors->firstOfAll()
            ], REST_Controller::HTTP_FORBIDDEN);
        } else {
            $newPassword = $this->put('new_password');
            $userData = array();
            $userData['password'] = md5($newPassword);
            $userData['status'] = 1;
            
            $update = $this->authModel->update($userData, $id);

            // Check if the user data is updated
            if ($update) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'Password has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

}

/* End of file Controllername.php */
