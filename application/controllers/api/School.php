<?php


defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class School extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load the user model
        $this->load->model('schoolModel');
    }

    public function index_post()
    {
        
    }

    public function add_post()
    {

    }

    public function update_put()
    {

    }

}

/* End of file School.php */
