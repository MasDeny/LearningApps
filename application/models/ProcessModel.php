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

    /*
     * Get rows from the users table
     */
    function getRows($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->userTbl);
        $this->db->order_by("create_time", "desc");
        
        //fetch data by conditions
        if (array_key_exists("conditions", $params)) {
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }


        if (array_key_exists("id", $params)) {
            $this->db->where('idStudents', $params['id']);
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
            } else {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0) ? $query->result_array() : false;
            }
        }

        //return fetched data
        return $result;
    }


}

/* End of file processModel.php */
