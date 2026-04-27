<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uom extends MY_Controller
{
	public $module = 'uom';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Unit of Measure';
		$data['sub_title'] = "Master";
		$data['sub']	= "Unit of Measure";
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}
	
	
}
