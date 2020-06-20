<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login');
        if (!is_logged_in()) {
            redirect('admin/login');
        }
    }

    public function index()
    {
        $this->load->view('admin/overview');
    }
}

/* End of file Dashboard.php */
