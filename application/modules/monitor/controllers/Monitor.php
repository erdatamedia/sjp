<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitor extends MY_Controller
{
	public $module = 'monitor';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$session = $this->session->userdata(COOKIE_USER);
		if (!$session) {
			redirect(base_url('auth'));
		}

		$id_role   = isset($session['id_role']) ? (int) $session['id_role'] : 0;
		$dark_mode = $this->session->userdata('dark_mode');

		$data['dark_mode'] = $dark_mode ? true : false;
		$data['id_role']   = $id_role;
		$data['module']    = $this->module;
		$data['title']     = 'Monitoring';

		$this->load->view('monitor/v_index', $data);
	}
	
	
}