<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public $module = 'auth';

	function __construct() {
		parent::__construct();
	}

	function index() {
		if ($this->session->userdata(COOKIE_USER)) {
			redirect(base_url());
		}
		$page = 'auth/v_index';
		$this->load->view($page);
	}

	function login() {
		$email =htmlspecialchars($this->input->post('email',TRUE),ENT_QUOTES);
		$password=htmlspecialchars($this->input->post('password',TRUE),ENT_QUOTES);


		$auth = $this->auth($email,$password);

		if($auth){
			$this->session->set_userdata(COOKIE_USER,$auth);
			redirect(base_url());
		} else {
			$this->session->set_flashdata('error_msg', 'email atau password salah');
			redirect(base_url('auth'));
		}

	}

	function logout() {
		$this->session->unset_userdata(COOKIE_USER);
		session_destroy();
		redirect(base_url('auth'));
	}

	function auth($email,$password) {
		$this->db->select('user.id, user.id_role');
		$this->db->where('user.email', $email);
		$this->db->where('user.password', md5($password));
		$this->db->join('role', 'role.id=user.id_role', 'left');
		return $this->db->get('user')->row_array();
	}
	
}
