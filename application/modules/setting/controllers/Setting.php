<?php 
class Setting extends MY_Controller 
{
	public $module = 'setting';
	public $assets = './assets/uploads/company/';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$module = $this->module;

		$data['setting'] 	= $this->getSetting();

		$data['module'] = $module;
		$data['title'] = 'Setting';
		$page = $module.'/v_index';
		$js = $module.'/js_index';

		echo modules::run('template/loadview', $data, $page, $js);
	}

	function save() {
		$id = $this->input->post('id');
		$data['company'] 	= $this->input->post('company');
		$data['phone'] 		= $this->input->post('phone');
		$data['email'] 		= $this->input->post('email');
		$data['website'] 	= $this->input->post('website');
		$data['address'] 	= $this->input->post('address');

		$this->upload_file_configs($this->assets);
		if ($this->upload->do_upload('avatar')){
			$uploaded = $this->upload->data();
			$this->resizeImage($this->assets, $uploaded['file_name']);
			$data['logo'] = $uploaded['file_name'];
			$data['thumb'] = str_replace('.', '_thumb.', $uploaded['file_name']);

			$old = $this->getSetting();
			if ($old) {
				$old_file = $this->assets.$old['logo'];
				$old_thumb = $this->assets.'/thumb/'.$old['thumb'];
				if (is_file($old_file) && file_exists($old_file)) {
					unlink($old_file);
				}
				if (is_file($old_thumb) && file_exists($old_thumb)) {
					unlink($old_thumb);
				}
			}
		}

		if ($id) {
			$this->db->where('id', $id);
			$this->db->update('setting', $data);
		} else {
			$this->db->insert('setting', $data);
		}

		redirect(base_url('setting'));
	}

	function style() {
		$id = $this->input->post('id');
		$data['color_navbar'] 	= $this->input->post('color_navbar');
		$data['color_text'] 	= $this->input->post('color_text');
		$data['color_icon'] 	= $this->input->post('color_icon');
		$this->db->where('id', $id);
		$this->db->update('setting', $data);

		redirect(base_url('setting'));
	}

	function spkSetting() {
		$id = $this->input->post('id');
		$data['nama_dibuat'] 	= $this->input->post('nama_dibuat');
		$data['nama_periksa'] 	= $this->input->post('nama_periksa');
		$data['nama_disetujui'] 	= $this->input->post('nama_disetujui');
		$data['nama_diterima'] 	= $this->input->post('nama_diterima');
		$data['nama_pengawas'] = $this->input->post('nama_pengawas');
		$this->db->where('id', $id);
		$this->db->update('setting', $data);

		redirect(base_url('setting'));
	}


	private function getSetting(){
		return $this->db->order_by('id','desc')->get('setting')->row_array();
	}

}
