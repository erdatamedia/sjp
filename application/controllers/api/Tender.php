<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Tender extends RestController
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

		$record = $this->db->where('id_role', 2)->get('user')->result_array();
		$recordsTotal = count($record);
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('user.name', $keyword['value']);
			$recordFil = $this->db->where('id_role', 2)->get('user')->result_array();
			$recordsFiltered = count($recordFil);
		}

		$columns = ['id','name', 'email', 'role'];
		$this->db->select('id,name, email,  CONCAT("'.base_url($this->assets).'",image) as image');
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}
		$data = $this->db->where('id_role', 2)->get('user')->result_array();
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function tender_get($id, $bulan) {
		$year		= date('Y');
		$draw 		= (int) $this->get('draw'); 
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');
		$column 	= $this->get('columns');

		$total = $this->db->where('id_user',  $id)->where('MONTH(created_at)',  $bulan)->where('YEAR(created_at)',  $column[1]['search']['value'])->get('pekerjaan')->result_array();
		$recordsTotal = count($total);
		$recordsFiltered = $recordsTotal;
		if (!empty($column[1]['search']['value'])) {
			$this->db->where('id_user', $id);
			$this->db->where('MONTH(created_at)',  $bulan);
			$this->db->where('YEAR(created_at)', $column[1]['search']['value']);
			
			$recordsFiltered = $this->db->count_all_results('pekerjaan');
		}
		$columns = ['pekerjaan.id_pesanan', 'pekerjaan.created_at', 'pekerjaan.due_date', 'pekerjaan.status', 'user.name'];
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->where('id_user', $id);
			$this->db->like('id_pesanan', $keyword['value']);
		}

		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}
		if (!empty($column[1]['search']['value'])) {
			$this->db->where('id_user', $id);
			$this->db->where('MONTH(created_at)',  $bulan);
			$this->db->where('YEAR(created_at)', $column[1]['search']['value']);
			$data = $this->db->where('id_user', $id)->order_by('id', 'desc')->get('pekerjaan')->result_array();
		} else {
			$data = $this->db->where('id_user', $id)->where('MONTH(created_at)',  $bulan)->where('YEAR(created_at)',  $year)->order_by('id', 'desc')->get('pekerjaan')->result_array();
		}
		
		foreach ($data as $key => $item) {
			$detail = $this->getDetailPekerjaan($item['id']);
			$data[$key]['total_barang'] = array_sum(array_column($detail,'qty'));
		}
		$this->response(array(
			'year' => $column[1]['search']['value'],
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function chart_get($id, $year) {
		$res = [];
		foreach (range(1, 12) as $month) {
			$sale = $this->db
			->select('SUM(d_pekerjaan.qty) as total')
			->join('d_pekerjaan', 'd_pekerjaan.id_pekerjaan=pekerjaan.id', 'left')
			->where('MONTH(pekerjaan.created_at)', $month)
			->where('YEAR(pekerjaan.created_at)', $year)
			->where('id_user', $id)
			->group_by('pekerjaan.id')
			->get('pekerjaan')
			->result_array();

			$res[] = array_sum(array_column($sale, 'total'));
		}
		
		$this->response($res, 200);
	}

	private function getDetailPekerjaan($id) {
		$data = $this->db->where('id_pekerjaan', $id)->get('d_pekerjaan')->result_array();
		return $data;
	}

	private function getUser($id) {
		$data = $this->db->select('name, email, CONCAT("'.base_url($this->assets).'",image) as image')->where('id', $id)->get('user')->row_array();
		return $data;
	}
	

}
