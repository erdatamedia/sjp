<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Papanpisau extends RestController
{

	public $assets 	=  './assets/document/';

	function __construct() {
		parent::__construct();
		$this->checkUserLog();
	}
	
	function index_get() {

		$draw       = (int) $this->get('draw');
		$limit      = (int) $this->get('length');
		$offset     = (int) $this->get('start');
		$keyword    = $this->get('search');
		$order      = $this->get('order');

		$recordsTotal = $this->db->count_all('papan_pisau');
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('papan_pisau.no_mp', $keyword['value']);
			$recordsFiltered = $this->db->count_all_results('papan_pisau');
		}

		$columns = ['id','no_mp', 'name_size', 'spesifikasi_mp', 'id_box', 'id_uom'];
		$this->db->select('papan_pisau.id, papan_pisau.id_box, papan_pisau.no_mp, papan_pisau.spesifikasi_mp, papan_pisau.name_size, papan_pisau.id_uom, uom.name as uom_name, box.name as box_name');
		$this->db->join('box', 'box.id=papan_pisau.id_box', 'left');
		$this->db->join('uom', 'uom.id=papan_pisau.id_uom', 'left');
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('papan_pisau.no_mp', $keyword['value']);
		}
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->or_like('name_size', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}
		$data = $this->db->get('papan_pisau')->result_array();
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function save_post() {
		$no_mp = $this->input->post('no_mp');
		$model_box =  $this->input->post('model_mp');
		$name_size =  $this->input->post('name_size');
		$id_uom = $this->input->post('id_uom');
		$id_box = $this->input->post('id_box');
		$data['no_mp']           = $no_mp;
		$data['name_size']       = $name_size;
		$data['id_box']		 	 = $id_box;
		$data['id_uom']		 	 = $id_uom;
		$data['spesifikasi_mp']  = $this->getBox($id_box) . ', '. $name_size. ' '. $this->getUom($id_uom);
		$result = $this->db->insert('papan_pisau', $data);
		if ($result) {
			$this->response([
				'status'    => $result,
				'msg'       => 'Saved',
			], 200);
		}else{
			$this->response($this->db->error(), 400);
		}
	}

	function edit_get() {
		$id = $this->get('id');
		$result = $this->db->select('papan_pisau.id, papan_pisau.no_mp, papan_pisau.name_size, papan_pisau.id_uom, papan_pisau.id_box, box.name as box_name, uom.name as uom_name')
		->join('uom', 'uom.id=papan_pisau.id_uom', 'left')
		->join('box', 'box.id=papan_pisau.id_box', 'left')
		->where('papan_pisau.id', $id)->get('papan_pisau')->row_array();
		$this->response($result);
	}

	function update_post() {
		$id = $this->input->post('id');
		$no_mp = $this->input->post('no_mp');
		$model_box =  $this->input->post('model_mp');
		$name_size =  $this->input->post('name_size');
		$id_uom = $this->input->post('id_uom');
		$id_box = $this->input->post('id_box');
		$data['no_mp']           = $no_mp;
		$data['name_size']       = $name_size;
		$data['id_box']		 	 = $id_box;
		$data['id_uom']		 	 = $id_uom;
		$data['spesifikasi_mp']  = $this->getBox($id_box) . ', '. $name_size. ' '. $this->getUom($id_uom);
		$result = $this->db->where('id', $id)->update('papan_pisau', $data);
		$this->response([
			'status' => $result,
			'msg'    => 'Updated'
		]);
	}

	function import_post() {
		$path 		= $this->assets;
		$desain = $_FILES['file'];
		$this->upload_config($path);
		$_FILES['file']['name']     = $desain['name'];
		$_FILES['file']['type']     = $desain['type'];
		$_FILES['file']['tmp_name'] = $desain['tmp_name'];
		$_FILES['file']['error']    = $desain['error'];
		$_FILES['file']['size']     = $desain['size'];
		$this->upload->do_upload('file');
		$file_data 	= $this->upload->data();
		$file_name 	= $file_data['file_name'];
		
		$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet 	= $reader->load($path.$file_name);
		$sheet_data 	= $spreadsheet->getActiveSheet()->toArray();
		$start_row = 1;
		$list 			= [];
		foreach($sheet_data as $key => $val) {
			if ($key < $start_row || empty($val[0])) {
				continue;
			}

			$no_mp_exists = $this->db->get_where('papan_pisau', ['no_mp' => $val[0]])->row_array();
			if ($no_mp_exists) {
				continue; 
			}
			$uom = $this->getUomData($val[3]);
			$box = $this->getBoxData($val[2]);
			$list [] = [
				'no_mp'			=> $val[0],
				'name_size' 			=> $val[1],
				'id_box'		=> $box,
				'id_uom'		=> $uom,
				'spesifikasi_mp'		=> $val[2] . ", " . $val[1] . " " . $val[3],
			];
		}
		if (!empty($list)) {
			$result = $this->db->insert_batch('papan_pisau', $list);

			if ($result) {
				$old_file = $path.$file_name;
				if (is_file($old_file) && file_exists($old_file)) {
					unlink($old_file);
				}

				$this->response([
					'status' => true
				]);
			} else {
				$this->response($this->db->error(), 400);
			}
		} else {
			$this->response([
				'status' => true,
			]);
		}
		
	}

	function delete_post() {
		$id = $this->input->post('id');
		$barang = $this->checkBarang($id);
		if ($barang) {
			$this->response([
				'status'    => 2,
				'msg'       => 'Papan Pisau masih digunakan',
			], 200);
		}
		$result = $this->db->where('id', $id)->delete('papan_pisau');
		if ($result) {
			$this->response([
				'status'    => 1,
				'msg'       => 'Deleted',
			], 200);
		}else{
			$this->response($this->db->error(), 400);
		}
	}

	public function select2_get() {
		$table = 'papan_pisau';
		$q = $this->get('q');
		$page = (int) $this->get('page');

		$recordsFiltered = $this->db->count_all($table);
		if(isset($q) && $q != '') {
			$this->db->like('no_mp', $q);
			$recordsFiltered = $this->db->count_all_results($table);
		}

		$this->db->select('id, CONCAT(no_mp," ",spesifikasi_mp) as name');
		if(isset($q) && $q != '') {
			$this->db->like('no_mp', $q);
			$this->db->or_like('spesifikasi_mp', $q);
		}
		if(isset($page) && $page > 1) {
			$this->db->limit(10, ($page*10)-10);
		}
		$this->db->order_by('no_mp','desc');
		$data = $this->db->get($table)->result();
		$this->response(array(
			'incomplete_results' =>  false,
			'total_count' => $recordsFiltered,
			'items' => $data,
		), 200);
	}

	private function upload_config($path) {		
		$config['upload_path'] 		= $path;		
		$config['allowed_types'] 	= 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename']	 	= '255';
		$config['encrypt_name'] 	= TRUE;
		$config['max_size'] 		= 4096; 
		$this->load->library('upload', $config);
	}

	private function checkBarang($id) {
		$data = $this->db->where('id_papan_pisau', $id)->get('barang')->row_array();
		return $data;
	}

	private function getUom($id) {
		$data = $this->db->select('name')->where('id', $id)->get('uom')->row_array();
		return $data['name'];
	}

	private function getBox($id) {
		$data = $this->db->select('name')->where('id', $id)->get('box')->row_array();
		return $data['name'];
	}

	private function getUomData($name) {
		$data = $this->db->where('name', $name)->get('uom')->row_array();
		return $data['id'] ? $data['id'] : '' ;
	}

	private function getBoxData($name) {
		$data = $this->db->where('name', $name)->get('box')->row_array();
		return $data['id'] ? $data['id'] : '' ;
	}
}
