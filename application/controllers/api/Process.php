<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Rakit\Validation\Validator;

require APPPATH . '/libraries/REST_Controller.php';

class Process extends REST_Controller {

    public function submit_post()
    {
        $this->response($this->post());
    }

}

/* End of file Process.php */
