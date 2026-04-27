<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tender extends MY_Controller
{
	public $module = 'tender';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Tender';
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}


	function view($id) {
		$module = $this->module;
		$x =  $this->getUser($id);
		if (!$x) {
			redirect(base_url($module));
		}
		
		$data['module'] = $module;
		$data['title'] 	= 'Tender '. $x['name'];
		$data['x'] = $x;
		$data['year'] = date('Y');
		if ($x) {
			$data['prev'] 	= $this->prevRow($x['id'], 'id', 'user', 2, TRUE);
			$data['next'] 	= $this->nextRow($x['id'], 'id', 'user', 2, TRUE);
			$data['i'] 		= $this->indexRow($x['id'], 'id', 'user', 2, TRUE);
			$data['j'] 		= $this->numRows('user', 2);
		}
		$page = $module.'/v_view';
		$js = $module.'/js_view';
		echo modules::run('template/loadview', $data, $page, $js);
	}


	private function getUser($id) {
		$data = $this->db->where('id', $id)->get('user')->row_array();
		return $data;
	}
	
	
}
