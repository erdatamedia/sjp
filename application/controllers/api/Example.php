<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Example extends RestController
{
    public function index_get()
    {
        $this->response([
            'nama' => 'HELLO DUNIA'
        ]);
    }
}