<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Subcategories extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model categories
        $this->load->model('subcategoriesModel');
    }

    public function index_get($id=null)
    {
        $con['returnType'] = 'getall';
        $con['conditions'] = array(
            'idCategory' => $id
        );
        $result = $this->subcategoriesModel->getRows($con);
        if ($result) {
            $this->response([
                'status' => TRUE,
                'message' => $result
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
