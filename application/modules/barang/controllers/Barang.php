<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends MY_Controller
{
	public $module = 'barang';
	public $id_column 	= 'id';

	function __construct() {
		parent::__construct();
		$this->load->library('Pusher_library');
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Product';
		$data['barang'] = $this->countStok();
		$data['sub_title'] = "Product";
		$data['sub']	= null;
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}

	private function send($message, $channel) {
        $data['message'] = $message;
        $this->pusher_library->trigger($channel . '-role', 'my-event', $data);

    }

	function repeat() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Product Repeat';
		$data['sub_title'] = "Product Repeat";
		$data['sub']	= null;
		$page = $module.'/v_repeat';
		$js = $module.'/js_repeat';
		echo modules::run('template/loadview', $data, $page, $js);
	}


	function view($id='') {
		$t = $this->input->get('t');
		$module = $this->module;
		$x = $this->getData($id);
		$data['x'] 			= $x;
		$data['id_column'] 	= $this->id_column;
		$data['prev'] 	= $this->prevRow($x['id'], 'id', $this->module, NULL);
		$data['next'] 	= $this->nextRow($x['id'], 'id', $this->module, NULL);
		$data['i'] 		= $this->indexRow($x['id'], 'id', $this->module, NULL);
		$data['j'] 		= $this->numRows($this->module, NULL);


		$data['t'] 		= $t;
		$data['module'] = $module;
		$data['title'] = 'View Product '. $x['item_box'];
		$page = 'barang/v_view';
		$js = 'barang/js_view';

		echo modules::run('template/loadview', $data, $page, $js);
	}

	private function getData($id) {
		$data = $this->db
		->select('barang.id, barang.no_mc, barang.substance, barang.item_box, barang.size, barang.deskripsi, barang.stok, barang.inside, barang.outside, barang.color, CONCAT(papan_pisau.no_mp," ",papan_pisau.name_size," ",papan_pisau.spesifikasi_mp) as papan_pisau, box.name as box, joint.name as joint')
		->join('box', 'box.id=barang.id_box', 'left')
		->join('papan_pisau', 'papan_pisau.id=barang.id_papan_pisau', 'left')
		->join('joint', 'joint.id=barang.id_joint', 'left')->where('barang.id', $id)->get('barang')
		->row_array();
		return $data;
	}

	private function countStok() {
		$dataStokTersedia = $this->db->where('stok >', 0)->get('barang')->result_array();
		$dataStokHabis = $this->db->where('stok', 0)->get('barang')->result_array();
		$total = $this->db->select('SUM(stok) as total')->get('barang')->row_array();
		$data['stok_ada'] = count($dataStokTersedia);
		$data['stok_habis'] = count($dataStokHabis);
		$data['total'] = intval($total['total']);
		return $data;
	}
	
	
}