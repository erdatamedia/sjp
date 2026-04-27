<?php
class Template extends MY_Controller
{
	function __construct() {
		parent::__construct();
		if (!$this->session->userdata(COOKIE_USER)) {
			redirect(base_url('auth'));
		}
	}

	function dark() {
		$dark_mode = $this->session->userdata('dark_mode');
		$this->session->set_userdata('dark_mode', !$dark_mode);
		redirect($_SERVER['HTTP_REFERER']);
	}

	function loadview($data=NULL,$page=NULL,$jscript=NULL) {
		$dark_mode = $this->session->userdata('dark_mode');
		$data['dark_mode'] 	= $dark_mode ? true : false;
		$user 				= $this->session->userdata(COOKIE_USER);
		$data['user'] 		= $this->getUser($user['id']);
		$data['setting_template']	= $this->getSetting();
		$data['blank_user'] 	= base_url('assets/media/svg/avatars/'.($dark_mode ? 'blank-dark.svg' : 'blank.svg'));
		$data['blank_product'] 	= base_url('assets/media/svg/files/'.($dark_mode ? 'blank-image-dark.svg' : 'blank-image.svg'));

		$this->load->view('v_header',$data);
		$this->load->view('v_content',$data);
		if($page != NULL){
			$this->load->view($page,$data);
		} else {
			$this->load->view('v_content',$data);
		}
		$this->load->view('v_footer',$data);
		if($jscript != NULL){
			$this->load->view($jscript,$data);
		}
		$this->load->view('v_closing',$data);
	}

	private function getUser($id) {
		$res = $this->db->select('user.name, user.image, user.id, user.email, role.name as role, role.id as id_role')->join('role', 'user.id_role=role.id')->where('user.id',$id)->get('user')->row_array();
		unset($res['password']);
		return $res;
	}

	private function getSetting() {
		return $this->db->order_by('id','desc')->get('setting')->row_array();
	}
}
?>
