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
        $data['title'] = "Dashboard";
        $data['subtitle'] = "";   
        $this->load->view('admin/overview', $data);
    }

    public function list_course() 
    {
        $data['title'] = "ListCourse";
        $data['subtitle'] = "";   
        $this->load->view('admin/Course/show', $data);
    }

    // admin menu 

    public function admin_dash() 
    {
        $data['title'] = "Dashboard Admin";
        $data['subtitle'] = "";   
        $this->load->view('admin/AdminMenu/overview', $data);
    }

    public function add_user() 
    {
        $data['title'] = "Tambah Pengguna";
        $data['subtitle'] = "";
        $data['status'] = TRUE;   
        $this->load->view('admin/AdminMenu/adduser', $data);
    }

    public function list_user($role=null) 
    {
        $class = (int) $this->input->get('class');
        if (!empty($class)) {
            $data['class'] = $class;
        }
        if(empty($role)) {
            if ($this->session->userdata('user_data')['role'] == 'guru') { redirect('dashboard/list_user/murid'); 
            }
            redirect('dashboard/admin_dash'); 
        };
        $data['title'] = $role=='murid'?"Daftar Murid":"Daftar Guru dan Admin";
        $data['subtitle'] = "list";
        $data['status'] = TRUE;   
        $this->load->view('admin/AdminMenu/listuser', $data);
    }

    // teacher menu
    public function pretestexam()
    {
        $data['title'] = "List Exam";  
        $data['subtitle'] = "pretest"; 
        $this->load->view('admin/Exam/ListExamPreTest', $data);
    }

    public function dailyexam()
    {
        $data['title'] = "List Exam";  
        $data['subtitle'] = "daily"; 
        $this->load->view('admin/Exam/ListExamDaily', $data);
    }

    public function finalexam()
    {
        $data['title'] = "List Exam";  
        $data['subtitle'] = "final"; 
        $this->load->view('admin/Exam/ListExamFinal', $data);
    }
}

/* End of file Dashboard.php */
