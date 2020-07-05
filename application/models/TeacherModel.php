<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TeacherModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->userTbl = 'Teachers';
    }

    /*
     * Get rows from the users table
     */
    function getRows($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->userTbl);

        //fetch data by conditions
        if (array_key_exists("conditions", $params)) {
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }


        if (array_key_exists("id", $params)) {
            $this->db->where('idTeachers', $params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        } else {
            //set start and limit
            if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit'], $params['start']);
            } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit']);
            }

            if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
                $result = $this->db->count_all_results();
            } elseif (array_key_exists("returnType", $params) && $params['returnType'] == 'single') {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0) ? $query->row_array() : false;
            // } elseif (array_key_exists("returnType", $params) && $params['returnType'] == 'login') {
            //     $query = $this->db->get();
            //     $result = ($query->num_rows() > 0) ? $query->row_array() : false;
            } else {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0) ? $query->result_array() : false;
            }
        }

        //return fetched data
        return $result;
    }

    /*
     * Insert user data
     */
    public function insert($data)
    {
        $insert = $this->db->insert($this->userTbl, $data);
        //return the status
        return $insert ? true : false;
    }

    /*
     * Update user data
     */
    public function update($data, $id)
    {
        //update user data in users table
        $update = $this->db->update($this->userTbl, $data, array('idTeachers' => $id));

        //return the status
        return $update ? true : false;
    }

}

/* End of file TeacherModel.php */
