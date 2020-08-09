<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Rakit\Validation\Validator;

require APPPATH . '/libraries/REST_Controller.php';

class Process extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the user model
        $this->load->model('examModel');
        $this->load->model('processModel');
        $this->load->model('studentModel');
        $this->load->model('authModel');
    }

    public function submit_post()
    {
        $type = $this->post('type');
        $nis = $this->post('nis');
        $class = $this->post('class');
        $value = $this->post('value');
        $value_str = json_decode($value, true);

        $data = array();
        foreach ($value_str as $key => $value) {
            $id = $value['id'];
            $con['returnType'] = 'single';
            $con['joinData'] = 'all';
            $con['conditions'] = array(
                'Exam.idExam' => $id
            );
            $get = $this->examModel->getRows($con);
            $check = $get['answer'] == $value['jawaban'];
            if ($check) {
                array_push($data, $check);
            }
        }

        $cdu['returnType'] = 'single';
        $cdu['conditions'] = array(
            'Students.idStudents' => $nis,
            // 'status' => 1
        );
        $cdu['joinData'] = 'murid';
        $row = $this->authModel->getRows($cdu);
        
        $correct = count($data) / count($value_str);

        $this->response($correct);

        $this->save_log($correct);
        $this->update_level($correct, $nis);
        $this->update_status($row, $type);
        $finalResult = $this->data_list($nis);
        // Set the response and exit
        $this->response([
            'status' => TRUE,
            'message' => 'User login successful.',
            'result' => $finalResult,
            'points' => (double) $correct
        ], REST_Controller::HTTP_OK);
    }

    protected function save_log($correct)
    {
        $userData = array(
            'typeExam'          => strip_tags($this->post('type')),
            'class'             => strip_tags($this->post('class')),
            'studentScore'      => $correct,
            'idStudent'         => $this->post('nis')
        );

        $insert = $this->processModel->insert($userData);

        if (!$insert) {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal Menginputkan data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    protected function update_level($correct, $id)
    {
        if ($correct > 0.2) {

            if ($correct <= 0.3 && $correct < 0.5) {
                $profileData = array();
                $profileData['level'] = '2';
                $update = $this->studentModel->update($profileData, $id);
            } else {
                $profileData = array();
                $profileData['level'] = '3';
                $update = $this->studentModel->update($profileData, $id);
            }
        } else {
            $profileData = array();
            $profileData['level'] = '1';
            $update = $this->studentModel->update($profileData, $id);
        }

        if (!$update) {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal Mengganti Level'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    protected function update_status($row, $type)
    {
        $userData = array();
        $userData['status'] = '1';
        $updateUser = $this->authModel->update($userData, $row['idUsers']);
        if (!$updateUser) {
            if ($type=='1') {
            $profileData['level'] = '0';
            $this->studentModel->update($profileData, $row['idStudents']);
            }
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal Mengganti Level'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    protected function data_list($nis)
    {
        $cdu['returnType'] = 'single';
        $cdu['conditions'] = array(
            'Students.idStudents' => $nis
        );
        $cdu['joinData'] = 'murid';
        $row = $this->authModel->getRows($cdu);

        $profile_data = array(
            'id'                => (int) $row['idUsers'],
            'username'          => $row['Username'],
            'email'             => $row['Email'],
            'role'              => $row['Role'],
            'numberIdentity'    => $row['idStudents'],
            'fullname'          => $row['name'],
            'bornOfDate'        => $row['bornOfDate'],
            'gender'            => $row['gender'],
            'religion'          => $row['religion'],
            'address'           => json_decode($row['address']),
            'phone'             => $row['phone'],
            'profilePhoto'      => base_url() . $row['profilePhoto'],
            'device'            => (int) $row['Device'],
            'class'             => (int) $row['class'],
            'schoolYear'        => $row['schoolYear'],
            'level'             => (int) $row['level'],
            'status'            => $row['Status'] == 0 ? 'deactivate' : 'active',
            'create_time'       => $row['create_time'],
            'update_time'       => $row['update_time']
        );
        return $profile_data;
    }
}

/* End of file Process.php */
