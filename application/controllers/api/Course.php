<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Rakit\Validation\Validator;

require APPPATH . '/libraries/REST_Controller.php';

class Course extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the user model
        $this->load->model('courseModel');
        $this->load->model('studentModel');
        $this->load->library('upload');
        $this->load->library('pagination');
    }

    public function add_post()
    {
        $this->do_validation();
        $content = $this->do_upload();

        $userData = array(
            'idCategory'    => strip_tags($this->post('kategori')),
            'idClass'       => strip_tags($this->post('level')),
            'idLevels'      => strip_tags($this->post('kelas')),
            'chapter'       => 'Bab ' . strip_tags($this->post('kategori')),
            'title'         => strip_tags($this->post('judul')),
            'content'       => $content['message'],
            'note'         => strip_tags($this->post('note')),
            'point'         => strip_tags($this->post('nilai')),
        );

        if ($content['status']) {
            $insert = $this->courseModel->insert($userData);
        } else {
            @unlink($_FILES[$content['message']]);
            $this->response([
                'status' => $content['status'],
                'message' => $content['message']
            ], REST_Controller::HTTP_FORBIDDEN);
        }

        if ($insert) {
            $this->response([
                'status' => TRUE,
                'message' => 'Berhasil Menambahkan Materi Pelajaran Baru'
            ], REST_Controller::HTTP_OK);
        } else {
            // Set the response and exit
            //BAD_REQUEST (400) being the HTTP response code
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal Menambahkan Materi Pelajaran'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_get()
    {
        $id = (int) $this->input->get('id');
        $class = (int) $this->input->get('class');

        $con['returnType'] = 'getall';
        $con['joinData'] = 'all';

        if ($id != null) {
            $con['id'] = $id;
            $data = $this->courseModel->getRows($con);
            if (!$data) {
                $this->response([
                    'status' => False,
                    'message' => 'Data not found, please try again'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $result = $this->do_list($data);
        } else {
            $page = $this->pagination($class);
            $con['conditions'] = array(
                'Courses.idClass' => $class
            );
            $con['limit'] = $page['per_page'];
            $con['start'] = $page['start'];
            $get = $this->courseModel->getRows($con);
            if (!$get) {
                $this->response([
                    'status' => False,
                    'message' => 'Data not found, please try again'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $data = array();
            foreach ($get as $row) {
                // if this is the first clip of a new sheet, make a new entry for it
                $course_data = $this->do_list($row);
                // add the current clip to the sheet
                array_push($data, $course_data);
            }
            $result['pagination'] = $this->pagination->create_links();
            $result['response'] = $data;
        }
        $this->response($result);
    }

    public function index_post()
    {
        $id = (int) strip_tags($this->post('id'));
        $con['returnType'] = 'getall';
        $con['joinData'] = 'all';

        if (empty($id)|| $id==0) {
            $get = $this->courseModel->getRows($con);
            if (!$get) {
                $this->response([
                    'status' => False,
                    'message' => 'Data not found, please try again'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $data = array();
            foreach ($get as $row) {
                // if this is the first clip of a new sheet, make a new entry for it
                $course_data = $this->do_list($row);
                // add the current clip to the sheet
                array_push($data, $course_data);
            }
            $result = $data;
        } else {
            $class = $this->do_student($id);
            $con['conditions'] = array(
            'Courses.idClass <=' => $class['class']
            );
            $get = $this->courseModel->getRows($con);
            if (!$get) {
                $this->response([
                    'status' => False,
                    'message' => 'Data not found, please try again'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $data = array();
            foreach ($get as $row) {
                // if this is the first clip of a new sheet, make a new entry for it
                $course_data = $this->do_list($row);
                // add the current clip to the sheet
                array_push($data, $course_data);
            }
            $result = $data;
        }
        $this->response($result);
    }

    protected function do_upload()
    {
        $dir = "upload/course/kelas_" . $this->post('kelas') . "/";
        $name = date("d-m-Y") . "-" . str_replace(' ', '_', $this->post('judul') . "-" . $_FILES["materi"]['name']);
        $config['upload_path'] = $dir;
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = 12288;
        $config['file_name'] = $name;

        if (file_exists($dir . $name)) {
            unlink($dir . $name);
        }

        $this->upload->initialize($config);
        if ($this->upload->do_upload('materi')) {

            return array('status' => TRUE, 'message' => $dir . $name);
        } else {
            $error = array('error' => $this->upload->display_errors());
            return array('status' => FALSE, 'message' => $error);
        }
    }

    protected function do_validation()
    {
        $validator = new Validator;

        $validator->setMessages([
            'required' => ':attribute harap untuk diisi',
            'min' => 'Panjang :attribute minimal sepanjang :min karakter',
            'uploaded_file' => 'pastikan file materi maksimal sebesar 12MB dan berformat pdf',
            'numeric' => 'Input harus berupa angka'
            // etc
        ]);

        $validate = $validator->make($this->post(), [
            //validasi user
            'kategori'      => 'required',
            'level'         => 'required',
            'kelas'         => 'required',
            'judul'         => 'required|min:5',
            'nilai'         => 'required|numeric'
        ]);

        $file = $validator->make($_FILES, [
            'materi'      => 'required|uploaded_file|max:12M|mimes:pdf',
        ]);

        $file->validate();

        $validate->validate();

        if ($validate->fails() && $file->fails()) {

            $this->response([
                'status' => FALSE,
                'message' => $validate->fails() ? $validate->errors()->firstOfAll() : $file->errors()->firstOfAll()
            ], REST_Controller::HTTP_FORBIDDEN);
        }
    }

    protected function do_list($row)
    {
        $profile_data = array(
            'id'            => (int) $row['idCourses'],
            'class'         => $row['nameClass'],
            'level'         => $row['nameLevel'],
            'category'      => $row['categoryname'],
            'chapter'       => $row['chapter'],
            'title'         => $row['title'],
            'content'       => base_url() . $row['content'],
            'point'         => $row['point'],
            'note'          => $row['note'],
            'create_time'   => $row['create_time'],
            'update_time'   => $row['update_time']
        );

        return $profile_data;
    }

    private function pagination($class)
    {
        $cnt['returnType'] = 'count';
        if (!empty($class)) {
            $cnt['conditions'] = array(
                'Courses.idClass' => $class,
            );
            $cnt['joinData'] = 'all';
        }

        $config = array();
        $config["base_url"] = base_url() . "api/course/";
        $config["total_rows"] = $this->courseModel->getRows($cnt);
        $config["per_page"] = 2;
        $config["uri_segment"] = 3;
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
        //$config['display_pages'] = FALSE;
        $config["last_link"] = "Last";
        $config["first_link"] = "First";
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);

        $page =  $this->uri->segment(3);

        $this->pagination->initialize($config);
        $start = ($page - 1) * $config["per_page"];

        return array(
            'start' => $start,
            'per_page'  => $config["per_page"]
        );
    }

    protected function do_student($idUsers)
    {
        $sdt['returnType'] = 'single';
        $sdt['conditions'] = array(
            'idUsers' => $idUsers
        );
        $student = $this->studentModel->getRows($sdt);
        if ($student) {
            // Set the response and exit
            return $student;
        } else {
            // Set the response and exit
            $this->response([
                'status' => False,
                'message' => 'Data not found, please try again'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
