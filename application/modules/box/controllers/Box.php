<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Box extends MY_Controller
{
	public $module = 'box';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Box';
		$data['sub_title'] = "Master";
		$data['sub']	= "Box";
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}
	
	
}