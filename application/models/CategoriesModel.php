<?php

defined('BASEPATH') or exit('No direct script access allowed');

class categoriesModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        // Load the database library
        $this->load->database();

        $this->userTbl = 'Category';
    }

    /*
     * Get rows from the users table
     */
    function getRows($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->userTbl);
        $this->db->order_by("idCategory", "asc");
        //fetch data by conditions
        if (array_key_exists("conditions", $params)) {
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }
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

        //return fetched data
        return $result;
    }

    /*
     * Insert user data
     */
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
     * Update user data
     */
    public function update($data, $id)
    {
        //add modified date if not exists
        if (!array_key_exists('update_time', $data)) {
            $data['update_time'] = date("Y-m-d H:i:s");
        }

        //update user data in users table
        $update = $this->db->update($this->userTbl, $data, array('idUsers' => $id));

        //return the status
        return $update ? true : false;
    }

    public function delete($id)
    {
        //update user from users table
        $delete = $this->db->delete('idUsers', array('id' => $id));
        //return the status
        return $delete ? true : false;
    }
}

/* End of file categoriesModel.php */
