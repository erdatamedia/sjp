<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public $module = 'dashboard';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Dashboard';
		$data['sub_title'] = "Dashboard";
		$data['sub']	= null;
		$page = $module.'/v_index';
		$js = $module.'/js_index';

		echo modules::run('template/loadview', $data, $page, $js);
	}

	function design($id) {
		$module = $this->module;
		$x = $this->getPekerjaan($id);
		$data['x'] 		= $x;
		$data['module'] = $module;
		$data['title'] = 'Draf Design View';
		$page = $module.'/v_design';
		$js = $module.'/js_design';
		echo modules::run('template/loadview', $data, $page, $js);
	}


	private function getPekerjaan($id) {
		$data = $this->db->select('id_pesanan, tgl_pengiriman, approve_shipping, id_user, created_at, durasi, due_date')->where('id', $id)->get('pekerjaan')->row_array();
		$data['detail_pekerjaan'] = $this->getDetailPekerjaan($id);
		return $data;
	}

	private function getDetailPekerjaan($id) {
		$data = $this->db->select('qty, qty_masuk, id_barang')->where('id_pekerjaan', $id)->get('d_pekerjaan')->result_array();
		foreach ($data as $key => $value) {
			$data[$key]['barang'] = $this->getBarang($value['id_barang']);
		}
		return $data;
	}

	private function getBarang($id) {
		$data = $this->db->select('barang.no_mc, barang.color, barang.inside, barang.outside, barang.id, barang.size, barang.stok, barang.item_box, barang.substance, barang.id_joint, barang.id_box, barang.id_papan_pisau, box.name as name_box, joint.name as name_joint, CONCAT(papan_pisau.no_mp," ", papan_pisau.name_size," ", papan_pisau.spesifikasi_mp) as name_papan, barang.deskripsi')->join('box', 'box.id=barang.id_box', 'left')->join('joint', 'joint.id=barang.id_joint')->join('papan_pisau', 'papan_pisau.id=barang.id_papan_pisau', 'left')->where('barang.id', $id)->get('barang')->row_array();
		return $data;
	}
	
	
}
