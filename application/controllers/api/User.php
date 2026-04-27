<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends RestController
{
	public $assets 	=  './assets/uploads/profil/';


	function __construct() {
		parent::__construct();
		$this->checkUserLog();
	}
	
	function index_get() {

		$draw 		= (int) $this->get('draw');
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');

		$recordsTotal = $this->db->count_all('user');
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('user.name', $keyword['value']);
			$recordsFiltered = $this->db->count_all_results('user');
		}

		$columns = ['id','name', 'email', 'role'];
		$this->db->select('user.id as id,user.name as name, user.email as email, role.name as role, CONCAT("'.base_url($this->assets).'",image) as image');
		$this->db->join('role', 'role.id= user.id_role', 'left');
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('user.name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}
		$data = $this->db->get('user')->result_array();
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function save_post() {
		$data['name']		 = $this->input->post('name');
		$data['email']		 = $this->input->post('email');
		$data['id_role']	 = $this->input->post('role');
		$data['password']	 = md5($this->input->post('password'));
		$result = $this->db->insert('user', $data);
		if ($result) {
			$this->response([
				'status' 	=> $result,
				'msg' 		=> 'Saved',
			], 200);
		}else{
			$this->response($this->db->error(), 400);
		}
	}

	function edit_get() {
		$id = $this->get('id');
		$result = $this->db->select('user.id, user.name as name, user.id_role as id_role, user.email as email, role.name as role_name')
		->join('role', 'role.id=user.id_role', 'left')
		->where('user.id', $id)->get('user')->row_array();
		$this->response($result);
	}

	function update_post() {
		$id = $this->input->post('id');
		$password = $this->input->post('password');
		$data['name']		 = $this->input->post('name');
		$data['email']		 = $this->input->post('email');
		$data['id_role']	 = $this->input->post('role');
		if ($password != null) {
			$data['password']	 = md5($this->input->post('password'));
		}
		$result = $this->db->where('id', $id)->update('user', $data);
		$this->response([
			'status' => $result,
			'msg'	 => 'Updated'
		]);
	}

	function delete_post() {
		$id = $this->input->post('id');
		$result = $this->db->where('id', $id)->delete('user');
		if ($result) {
			$this->response([
				'status' 	=> $result,
				'msg' 		=> 'Deleted',
			], 200);
		}else{
			$this->response($this->db->error(), 400);
		}
	}

	function delPhoto_post() {
		$valid = true;
		$id = $this->input->post('id');
		$old = $this->db->where('id', $id)->get('user')->row_array();
		if ($old && !empty($old['image'])) {
			$old_file = $this->assets . $old['image'];
			if (is_file($old_file) && file_exists($old_file)) {
				unlink($old_file);
			}
			$data['image']	 = null;
			$result = $this->db->where('id', $id)->update('user', $data);
			$valid = true;
		}
		if (!$old['image']) {
			$valid = false;
		}
		if ($valid) {
			$this->response([
				'status' 	=> $result,
				'msg' 		=> 'Photo Berhasil di Hapus',
			], 200);
		}
	}

}
