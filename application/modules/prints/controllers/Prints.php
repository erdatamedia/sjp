<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prints extends MY_Controller
{
	public $module = 'prints';

	function __construct() {
		parent::__construct();
	}

	function suratJalan($id='') {
		$data['title']  = 'Surat Jalan';
		$data['x'] = $this->getPekerjaan($id);
		$this->load->view('surat-jalan', $data);
	}

	function spkPolosan($id) {
		$data['title']  = 'SPK POLOSAN';
		$data['x'] = $this->getPekerjaan($id);
		$data['note']		= $this->getOneNote($id);
		$data['setting'] = $this->getOneSetting();
		$this->load->view('spk-polosan', $data);
	}

	function design($id='') {
		$x = $this->getPekerjaan($id);
		$data['x'] 		= $x;
		$data['title'] = 'Draf Design';
		$this->load->view('draft_design', $data);
	}

	function designDigital($id='') {
		$x = $this->getPekerjaanDigital($id);
		$data['x'] 		= $x;
		$data['title'] = 'Draf Design Digital Printing';
		$this->load->view('draft_design_digital', $data);
	}

	function color($id='') {
		$x = $this->getPekerjaan($id);
		$data['x'] 		= $x;
		$data['title'] = 'Draf Color';
		$this->load->view('draft_color', $data);
	}

	function colorDigital($id='') {
		$x = $this->getPekerjaanDigital($id);
		$data['x'] 		= $x;
		$data['title'] = 'Draf Color Digital Printing';
		$this->load->view('draft_color_digital', $data);
	}

	function designStok($id='') {
		$x = $this->getStok($id);
		$data['x'] 		= $x;
		$data['title'] = 'Draf Design';
		$this->load->view('draft_design_stok', $data);
	}

	function spkDigital($id) {
		$data['title']  = 'SPK DIGITAL PRINTING';
		$data['x'] = $this->getPekerjaanDigital($id);
		$data['note']		= $this->getOneNote($id);
		$data['setting'] = $this->getOneSetting();
		$this->load->view('spk-digital', $data);
	}

	function spkCustomDesain($id) {
		$data['title']  = 'SPK CUSTOM DESAIN';
		$data['x'] = $this->getPekerjaan($id);
		$data['note']		= $this->getOneNote($id);
		$data['setting'] = $this->getOneSetting();
		$this->load->view('spk-custom', $data);
	}

	function spkStok($id, $id_role) {
		$data['title']  = 'SPK STOK';
		$data['x'] = $this->getStok($id);
		$data['role'] = $this->getRole($id_role);
		$this->load->view('spk-stok', $data);
	}

	private function getStok($id) {
		$data = $this->db->select('id_spk, id_user, created_at, durasi, due_date')->where('id', $id)->get('stok')->row_array();
		$data['detail_stok'] = $this->getDetailStok($id);
		$data['user'] = $this->getUser($data['id_user']);
		return $data;
	}


	private function getPekerjaan($id) {
		$data = $this->db->select('id_pesanan, id, approve_shipping, id_user, created_at, durasi, due_date, tgl_pengiriman')->where('id', $id)->get('pekerjaan')->row_array();
		$data['detail_pekerjaan'] = $this->getDetailPekerjaan($id);
		$data['user'] = $this->getUser($data['id_user']);
		return $data;
	}

	private function getPekerjaanDigital($id) {
		$data = $this->db->select('id_pesanan, id, id_user, created_at, durasi, due_date, tgl_pengiriman')->where('id', $id)->get('pekerjaan_digital')->row_array();
		$data['detail_pekerjaan'] = $this->getDetailPekerjaanDigital($id);
		$data['user'] = $this->getUser($data['id_user']);
		return $data;
	}

	private function getDetailPekerjaan($id) {
		$data = $this->db->select('qty, qty_masuk, id_barang, deskripsi')->where('id_pekerjaan', $id)->get('d_pekerjaan')->result_array();
		foreach ($data as $key => $value) {
			$data[$key]['barang'] = $this->getBarang($value['id_barang']);
		}
		return $data;
	}

	private function getDetailPekerjaanDigital($id) {
		$data = $this->db->select('qty, qty_object, deskripsi, id_produk, qty_total, finishing')->where('id_pekerjaan', $id)->get('d_pekerjaan_digital')->result_array();
		foreach ($data as $key => $value) {
			$data[$key]['barang'] = $this->getBarangDgp($value['id_produk']);
		}
		return $data;
	}

	private function getDetailStok($id){
		$data = $this->db->select('qty, id_barang')->where('id_stok', $id)->get('d_stok')->result_array();
		foreach ($data as $key => $value) {
			$data[$key]['barang'] = $this->getBarang($value['id_barang']);
		}
		return $data;
	}

	private function getOneNote($id) {
		$data = $this->db->select('text')->where('id_pekerjaan', $id)->get('note')->row_array();
		return $data;
	}

	private function getRole($id) {
		$data = $this->db->where('id', $id)->get('role')->row_array();
		if (empty($data)) {
			return '';
		}
		return get_role_label($data['name']);
	}

	private function getUser($id) {
		$data = $this->db->where('id', $id)->get('user')->row_array();
		return $data;
	}

	private function getBarang($id) {
		$data = $this->db->select('barang.no_mc, barang.color, barang.inside, barang.outside, barang.id, barang.size, barang.stok, barang.item_box, barang.substance, barang.id_joint, barang.id_box, barang.id_papan_pisau, box.name as name_box, joint.name as name_joint, CONCAT(papan_pisau.no_mp," ", papan_pisau.name_size," ", box.name) as name_papan, barang.deskripsi')->join('box', 'box.id=barang.id_box', 'left')->join('joint', 'joint.id=barang.id_joint', 'left')->join('papan_pisau', 'papan_pisau.id=barang.id_papan_pisau', 'left')->where('barang.id', $id)->get('barang')->row_array();
		return $data;
	}

	private function getBarangDgp($id) {
		$data = $this->db->select('barang_dgp.no_mc_label, barang_dgp.image, barang_dgp.id, barang_dgp.nama_dgp, material.name, barang_dgp.size')->join('material', 'material.id = barang_dgp.id_material', 'left')->where('barang_dgp.id', $id)->get('barang_dgp')->row_array();
		return $data;
	}

	private function getOneSetting() {
		return $this->db->order_by('id','desc')->get('setting')->row_array();
	}

}