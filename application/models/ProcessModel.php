<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class processModel extends CI_Model {

    /*
     * Insert user data
     */

    public function __construct()
    {
        parent::__construct();

        // Load the database library
        $this->load->database();

        $this->userTbl = 'TransactionScores';
    }

    public function insert($data)
    {
        //add created and modified date if not exists
        if (!array_key_exists("create_time", $data)) {
            $data['create_time'] = date("Y-m-d H:i:s");
        }
        if (!array_key_exists("update_time", $data)) {
            $data['update_time'] = date("Y-m-d H:i:s");
        }

        //insert user data to users table
        $insert = $this->db->insert($this->userTbl, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

}

/* End of file processModel.php */
