<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
	public $module = 'user';
	public $assets 	=  './assets/uploads/profil/';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'User';
		$data['sub_title'] = "User";
		$data['sub']	= null;
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}


	function profil($id) {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Profil';
		$data['x']	= $this->getOneUser($id);
		$data['role'] = $this->role();
		$page = $module.'/v_profil';
		$js = $module.'/js_profil';
		echo modules::run('template/loadview', $data, $page, $js);
	}

	function view($id) {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'View User';
		$x 			=  $this->getOneUser($id);
		if ($x) {
			$data['prev'] 	= $this->prevRowUser($x['id'], 'id', 'user', TRUE);
			$data['next'] 	= $this->nextRowUser($x['id'], 'id', 'user', TRUE);
			$data['i'] 		= $this->indexRowUser($x['id'], 'id', 'user', TRUE);
			$data['j'] 		= $this->numRowsUser('user');
		}
		$data['x']	= $x;
		$data['role'] = $this->role();
		$page = $module.'/v_view';
		$js = $module.'/js_view';
		echo modules::run('template/loadview', $data, $page, $js);
	}

	function update($id) {
		$password 			 = $this->input->post('password');
		$data['name']		 = $this->input->post('name');
		$data['id_role']	 = $this->input->post('id_role');
		$data['email']		 = $this->input->post('email');
		if ($password) {
			$data['password'] = md5($password);
		}
		$this->upload_file_configs($this->assets);
		$old = $this->getOneUser($id);
		if (!empty($_FILES['image']['name'])) {
			if ($this->upload->do_upload('image')) {
				$uploaded = $this->upload->data();
				if ($uploaded['file_size'] > 4096) {
					$this->resizeImage($this->assets, $uploaded['file_name']);
				}
				$data['image'] = $uploaded['file_name'];
				if ($old && !empty($old['image'])) {
					$old_file = $this->assets . $old['image'];
					if (is_file($old_file) && file_exists($old_file)) {
						unlink($old_file);
					}
				}
			} else {
				redirect(base_url('user/profil/'.$id));
			}
		}
		$this->db->where('id', $id)->update('user', $data);
		redirect(base_url('user/profil/'.$id));

	}

	function updateUser($id) {
		$password 			 = $this->input->post('password');
		$data['name']		 = $this->input->post('name');
		$data['id_role']	 = $this->input->post('id_role');
		$data['email']		 = $this->input->post('email');
		if ($password) {
			$data['password'] = md5($password);
		}
		$this->upload_file_configs($this->assets);
		$old = $this->getOneUser($id);
		if (!empty($_FILES['image']['name'])) {
			if ($this->upload->do_upload('image')) {
				$uploaded = $this->upload->data();
				if ($uploaded['file_size'] > 4096) {
					$this->resizeImage($this->assets, $uploaded['file_name']);
				}
				
				$data['image'] = $uploaded['file_name'];
				if ($old && !empty($old['image'])) {
					$old_file = $this->assets . $old['image'];
					if (is_file($old_file) && file_exists($old_file)) {
						unlink($old_file);
					}
				}
			} else {
				redirect(base_url('user/profil/'.$id));
			}
		}
		$this->db->where('id', $id)->update('user', $data);
		redirect(base_url('user/view/'.$id));
	}

	private function prevRowUser($id='', $id_column='', $table='',$reverse=FALSE) {
		if ($reverse) {
			$this->db->where($id_column.' >', $id);
			$this->db->order_by($id_column,'ASC');
		} else {
			$this->db->where($id_column.' <', $id);
			$this->db->order_by($id_column,'DESC');
		}
		$this->db->limit(1);
		$res = $this->db->get($table)->row_array();
		return $res ? $res[$id_column] : FALSE;
	}

	private function nextRowUser($id='', $id_column='', $table='',$reverse=FALSE) {
		if ($reverse) {
			$this->db->where($id_column.' <', $id);
			$this->db->order_by($id_column,'DESC');
		} else {
			$this->db->where($id_column.' >', $id);
			$this->db->order_by($id_column,'ASC');
		}
		$this->db->limit(1);
		$res = $this->db->get($table)->row_array();
		return $res ? $res[$id_column] : FALSE;
	}

	private function indexRowUser($id=',',$id_column='',$table='',$reverse=FALSE) {
		if ($reverse) {
			$this->db->where($id_column.' >=', $id);
			$this->db->order_by($id_column, 'DESC');
		} else {
			$this->db->where($id_column.' <=', $id);
			$this->db->order_by($id_column, 'ASC');
		}
		return $this->db->get($table)->num_rows();
	}

	private function numRowsUser($table='') {
		return $this->db->get($table)->num_rows();
		
	}

	private function getOneUser($id) {
		$data = $this->db->select('user.id, user.name, user.id_role, user.email, user.password, user.image, role.name as role, user.id_role')->join('role', 'user.id_role=role.id', 'left')->where('user.id', $id)->get('user')->row_array();
		return $data;
	}

	private function role() {
		$data = $this->db->get('role')->result_array();
		return $data;
	}
	
	
}