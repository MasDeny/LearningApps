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
            'answer'        => $this->post('level'),
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

    // fungsi untuk melakukan upload foto profile
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
}

/* End of file Exam.php */
