<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Note extends RestController
{
	function __construct() {
		parent::__construct();
		$this->checkUserLog();
	}

	function save_post() {
		$data['id_pekerjaan']		 = $this->input->post('id_pekerjaan');
		$data['text']				 = $this->input->post('note');
		$result = $this->db->insert('note', $data);
		if ($result) {
			$this->response([
				'status' 	=> $result,
				'code'		=> 201,
				'msg' 		=> 'Saved',
			], 200);
		}else{
			$this->response($this->db->error(), 400);
		}
	}
}
