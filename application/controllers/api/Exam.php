<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Rakit\Validation\Validator;

require APPPATH . '/libraries/REST_Controller.php';

class Exam extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load the user model
        $this->load->model('examModel');
        $this->load->library('upload');
        $this->load->library('pagination');
    }

    public function index_get($id = null)
    {
        $con['returnType'] = 'getall';
        $con['joinData'] = 'all';
        $page = $this->pagination($id);
        $con['conditions'] = array(
            'Exam.idType' => $id,
        );
        $con['limit'] = $page['per_page'];
        $con['start'] = $page['start'];
        $get = $this->examModel->getRows($con);
        if (!$get) {
            $this->response([
                'status' => False,
                'message' => 'Data not found, please try again'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $data = array();
        foreach ($get as $row) {
            // if this is the first clip of a new sheet, make a new entry for it
            $exam_data = $this->do_list($row);
            // add the current clip to the sheet
            array_push($data, $exam_data);
        }
        $result['pagination'] = $this->pagination->create_links();
        $result['result'] = $data;

        $this->response([
            'status' => True,
            'result' => $result
        ], REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $type = $this->post('type');
        $class = $this->post('class');
        $level = $this->post('level');
        $con['returnType'] = 'getall';
        $con['joinData'] = 'all';
        $con['conditions'] = array(
            'Exam.idType' => $type,
            'Exam.idClass'=> $class
        );
        if ($level!=null) {
           $con['conditions'] = array(
            'Exam.idType'   => $type,
            'Exam.idClass'  => $class,
            'Exam.idLevel'  => $level
        );
        }
        $this->response($con);
        $get = $this->examModel->getRows($con);
        if (!$get) {
            $this->response([
                'status' => False,
                'message' => 'Data not found, please try again'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $data = array();
        foreach ($get as $row) {
            // if this is the first clip of a new sheet, make a new entry for it
            $exam_data = $this->do_list($row);
            // add the current clip to the sheet
            array_push($data, $exam_data);
        }

        $this->response([
            'status' => True,
            'result' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function add_post()
    {
        $this->do_validation();

        if (!empty($_FILES["images"]['name'])) {
            $content = $this->do_upload();
        }

        $choice = json_encode([
            'A' => $this->post('A'),
            'B' => $this->post('B'),
            'C' => $this->post('C'),
            'D' => $this->post('D')
        ]);

        $userData = array(
            'idType'        => strip_tags($this->post('type')),
            'idClass'       => strip_tags($this->post('kelas')),
            'idLevels'      => strip_tags($this->post('level')),
            'question'      => $this->post('question'),
            'multipleChoice' => $choice,
            'answer'        => $this->post('answer'),
            'idTeachers'    => $this->session->userdata('user_data')['numberIdentity'],
            'point'         => strip_tags($this->post('nilai')),
        );

        if ($this->post('type') == '3') {
            $userData['category'] = $this->post('kategori');
            $userData['subCategory'] = $this->post('subkategori');
        }

        if (!empty($_FILES["images"]['name'])) {
            if ($content['status']) {
                $userData['images'] = $content['message'];
                $insert = $this->examModel->insert($userData);
            } else {
                @unlink($_FILES[$content['message']]);
                $this->response([
                    'status' => $content['status'],
                    'message' => $content['message']
                ], REST_Controller::HTTP_FORBIDDEN);
            }
        } else {
            $insert = $this->examModel->insert($userData);
        }

        if ($insert) {
            $this->response([
                'status' => TRUE,
                'message' => 'Berhasil Menambahkan Soal Pelajaran Baru'
            ], REST_Controller::HTTP_OK);
        } else {
            // Set the response and exit
            //BAD_REQUEST (400) being the HTTP response code
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal Menambahkan Soal Pelajaran'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // fungsi untuk melakukan upload foto soal
    protected function do_upload()
    {
        $dir = "upload/exam/";
        $name = date("d-m-Y") . "-" . str_replace(' ', '_type-', $this->post('type') . "-" . $_FILES["images"]['name']);
        $config['upload_path'] = $dir;
        $config['allowed_types'] = 'jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = 1024;
        $config['file_name'] = $name;

        if (file_exists($dir . $name)) {
            unlink($dir . $name);
        }

        $this->upload->initialize($config);
        if ($this->upload->do_upload('images')) {

            return array('status' => TRUE, 'message' => $dir . $name);
        } else {

            return array('status' => FALSE, 'message' => "Gagal Upload, pastikan file sebesar 1MB dan berformat jpg|png|jpeg");
        }
    }

    protected function do_validation()
    {
        $validator = new Validator;

        $validator->setMessages([
            'required' => ':attribute harap untuk diisi',
            'min' => 'Panjang :attribute minimal sepanjang :min karakter',
            'uploaded_file' => 'pastikan file materi maksimal sebesar 12MB dan berformat jpeg | jpg | png | bmp',
            'numeric' => 'Input harus berupa angka'
            // etc
        ]);

        $validate = $validator->make($this->post(), [
            //validasi user
            'type'      => 'required',
            'question'  => 'required',
            'kelas'     => 'required',
            'level'     => 'required',
            'answer'    => 'required',
            'nilai'     => 'required|numeric',
            'A'         => 'required',
            'B'         => 'required',
            'C'         => 'required',
            'D'         => 'required',

        ]);

        if (!empty($_FILES["images"]['name'])) {

            $file = $validator->make($_FILES, [
                'images'      => 'uploaded_file|max:1M|mimes:jpg,jpeg,png,bmp',
            ]);

            $file->validate();

            if ($file->fails()) {

                $this->response([
                    'status' => FALSE,
                    'message' => $file->errors()->firstOfAll()
                ], REST_Controller::HTTP_FORBIDDEN);
            }
        }

        if ($this->post('type') == 3) {

            $validate = $validator->make($this->post(), [
                //validasi user
                'kategori'      => 'required',
                'subkategori'   => 'required',
            ]);

            $validate->validate();

            if ($validate->fails()) {

                $this->response([
                    'status' => FALSE,
                    'message' => $validate->errors()->firstOfAll()
                ], REST_Controller::HTTP_FORBIDDEN);
            }
        }

        $validate->validate();

        if ($validate->fails()) {

            $this->response([
                'status' => FALSE,
                'message' => $validate->errors()->firstOfAll()
            ], REST_Controller::HTTP_FORBIDDEN);
        }
    }

    private function pagination($type)
    {
        $cnt['returnType'] = 'count';
        if (!empty($class)) {
            $con['conditions'] = array(
                'Exam.idType' => $type,
            );
            $cnt['joinData'] = 'all';
        }

        $config = array();
        $config["base_url"] = base_url() . "api/exam/".$type;
        $config['reuse_query_string'] = true;
        $config["total_rows"] = $this->examModel->getRows($cnt);
        $config["per_page"] = 5;
        $config["uri_segment"] = 5;
        $config['attributes'] = array('class' => 'page-link');
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li class="page-item">';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"]  = '<li class="page-item">';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = 'Next';
        $config["next_tag_open"] = '<li class="page-item">';
        $config["next_tag_close"] = '</li>';
        $config['prev_link'] = 'Previous';
        $config["prev_tag_open"] = '<li>';
        $config["prev_tag_close"] = '</li>';
        $config["cur_tag_open"] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config["last_link"] = "Last";
        $config["first_link"] = "First";
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);

        $page =  $this->uri->segment(4);

        $this->pagination->initialize($config);
        $start = ($page - 1) * $config["per_page"];

        return array(
            'start' => $start,
            'per_page'  => $config["per_page"]
        );
    }

    protected function do_list($row)
    {
        $profile_data = array(
            'id'            => (int) $row['idExam'],
            'jenis_soal'    => $row['typeName'],
            'class'         => $row['nameClass'],
            'level'         => $row['nameLevel'],
            'category'      => $row['category'],
            'subcategory'   => $row['subCategory'],
            'question'      => $row['question'],
            'images'        => empty($row['images']) ? null : base_url() . $row['images'],
            'choice'        => json_decode($row['multipleChoice']),
            'answer'        => $row['answer'],
            'point'         => $row['point'],
            'nama_guru'     => $row['name'],
            'status'        => $row['status'],
            'create_time'   => $row['create_time'],
            'update_time'   => $row['update_time']
        );

        return $profile_data;
    }
}

/* End of file Exam.php */
