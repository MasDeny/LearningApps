<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Title extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load model exam
        $this->load->model('examModel');
    }

    public function index_post()
    {
        $level = $this->post('level');
        $type = $this->post('type');
        $class = $this->post('class');
        $con['returnType'] = 'getall';
        $con['conditions'] = array(
            'idType'    => $type,
            'idClass'   => $class,
            'idLevels'  => $level
        );

        $con['returnType'] = 'getall';
        $con['groupby'] = 'true';
        $result = $this->examModel->getRows($con);

        if ($result) {
            $data = array();
            foreach ($result as $row) {
                // if this is the first clip of a new sheet, make a new entry for it
                $profile_data = array(
                    'type'          => $row['idType'],
                    'class'         => $row['idClass'],
                    'level'         => $row['idLevels'],
                    'title'         => $row['titleExam'],
                );
                // add the current clip to the sheet
                array_push($data, $profile_data);
            }
            $this->response([
                'status' => TRUE,
                'result' => $data
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
}

/* End of file Subcategories.php */
