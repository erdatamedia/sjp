<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends MY_Controller
{
	public $module = 'role';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Role';
		$data['sub_title'] = "Master";
		$data['sub']	= "Role";
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}
	
	
}
