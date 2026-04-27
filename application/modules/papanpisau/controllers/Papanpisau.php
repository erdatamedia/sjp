<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Papanpisau extends MY_Controller
{
	public $module = 'papanpisau';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Cutting Board';
		$data['sub_title'] = "Cutting Board";
		$data['sub']	= null;
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}
	
	
}