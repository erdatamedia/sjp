<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Joint extends RestController
{
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

		$recordsTotal = $this->db->count_all('joint');
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
			$recordsFiltered = $this->db->count_all_results('joint');
		}

		$columns = ['id','name'];
		$this->db->select('id,name');
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}
		$data = $this->db->get('joint')->result_array();
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function save_post() {
		$data['name']		 = $this->input->post('name');
		$result = $this->db->insert('joint', $data);
		if ($result) {
			$this->response([
				'status' 	=> $result,
				'msg' 		=> 'Saved',
			], 200);
		}else{
			$this->response($this->db->error(), 400);
		}
	}

	function edit_post() {
		$id = $this->input->post('id');
		$result = $this->db->where('id', $id)->get('joint')->row_array();
		$this->response($result);
	}

	function update_post() {
		$id = $this->input->post('id');
		$data['name']		= $this->input->post('name');
		$result = $this->db->where('id', $id)->update('joint', $data);
		$this->response([
			'status' => $result,
			'msg'	 => 'Updated'
		]);
	}

	function delete_post() {
		$id = $this->input->post('id');
		$user = $this->checkBarang($id);
		if ($user) {
			$this->response([
				'status' 	=> 2,
				'msg' 		=> 'Data masih digunakan',
			], 200);
		}
		if (!$user) {
			$result = $this->db->where('id', $id)->delete('joint');
			if ($result) {
				$this->response([
					'status' 	=> 1,
					'msg' 		=> 'Deleted',
				], 200);
			}else{
				$this->response($this->db->error(), 400);
			}
		}
		
		
	}

	public function select2_get() {
		$table = 'joint';
		$q = $this->get('q');
		$page = (int) $this->get('page');

		$recordsFiltered = $this->db->count_all($table);
		if(isset($q) && $q != '') {
			$this->db->like('name', $q);
			$recordsFiltered = $this->db->count_all_results($table);
		}

		$this->db->select('id, name');
		if(isset($q) && $q != '') {
			$this->db->like('name', $q);
		}
		if(isset($page) && $page > 1) {
			$this->db->limit(10, ($page*10)-10);
		}
		$this->db->order_by('name','asc');
		$data = $this->db->get($table)->result();
		$this->response(array(
			'incomplete_results' =>  false,
			'total_count' => $recordsFiltered,
			'items' => $data,
		), 200);
	}

	private function checkBarang($id) {
		$data = $this->db->where('id_joint', $id)->get('barang')->row_array();
		return $data;
	}
}
