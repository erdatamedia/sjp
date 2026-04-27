<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material extends MY_Controller
{
	public $module = 'material';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Material';
		$data['sub_title'] = "Master";
		$data['sub']	= "Material";
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}
	
	
}