<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TeacherModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->userTbl = 'Teachers';
    }

}

/* End of file TeacherModel.php */
