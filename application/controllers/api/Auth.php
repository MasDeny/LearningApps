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
        $this->load->model('studentModel');
        $this->load->library('upload');
    }

    public function index_get()
    {
        $this->response([
            'status' => true,
            'message' => 'API Server For E-Learning'
        ], REST_Controller::HTTP_FORBIDDEN);
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

            // check multiple device
            if ($result['Device'] == 1) {
                $this->response([
                    'status' => true,
                    'message' => 'Device has been login another device, please logout first'
                ], REST_Controller::HTTP_FORBIDDEN);
            }

            $device['id'] = (int) $result['idUsers'];
            $data['device'] = 1;
            $devicesUpdate = $this->authModel->device($data, $device);

            // validasi login
            if ($result) {

                // show profile

                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'idUsers' => $result['idUsers'],
                    // 'status' => 1
                );
                $profile = $this->studentModel->getRows($con);

                //strutured data
                $finalResult = array(
                    'id'                => (int) $result['idUsers'],
                    'username'          => $result['Username'],
                    'email'             => $result['Email'],
                    'role'              => $result['Role'],
                    'numberIdentity'    => $profile['idStudents'],
                    'fullname'          => $profile['name'],
                    'class'             => (int) $profile['class'],
                    'bornOfDate'        => $profile['bornOfDate'],
                    'gender'            => $profile['gender'],
                    'religion'          => $profile['religion'],
                    'address'           => json_decode($profile['address']),
                    'phone'             => $profile['phone'],
                    'profilePhoto'      => base_url().$profile['profilePhoto'],
                    'device'            => (int) $devicesUpdate['Device'],
                    'status'            => $result['Status'] == 0 ? 'deactivate' : 'active',
                    'create_time'   => $result['create_time'],
                    'update_time'   => $result['update_time']
                );

                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User login successful.',
                    'result' => $finalResult
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                //BAD_REQUEST (400) being the HTTP response code
                $this->response([
                    'status' => FALSE,
                    'message' => 'Wrong email or password.'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Provide email and password.'
            ], REST_Controller::HTTP_BAD_REQUEST);
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
            // $userData['status'] = 1;

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

                $this->response([
                    'status' => TRUE,
                    'message' => 'Some problems occurred, please try again.'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    // logout
    public function logout_post()
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
            // check multiple device
            $device['returnType'] = 'login';
            $device['id'] = (int) $result['idUsers'];
            $data['device'] = 0;
            $devicesUpdate = $this->authModel->device($data, $device);

            if ($devicesUpdate['Device'] == 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Device has been logout'
                ], REST_Controller::HTTP_OK);
            }
        } else {
            // Set the response and exit
            $this->response([
                'status' => true,
                'message' => 'Provide email and password.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}

/* End of file Controllername.php */
