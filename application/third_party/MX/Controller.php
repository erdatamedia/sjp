<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

require dirname(__FILE__).'/Base.php';

class MX_Controller 
{
	public $autoload = array();
	
	public function __construct() 
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);

		$this->load->library('image_lib');
	}
	
	public function __get($class) 
	{
		return CI::$APP->$class;
	}

	public function upload_file_configs($path='') {
		$config['upload_path'] = $path;
		$config['allowed_types'] = '*';
		$config['max_size'] = '20480';
		$config['max_width']  = '10576';
		$config['max_height'] = '10576';
		$config['overwrite'] = true;
		$config['encrypt_name'] = TRUE;


		$this->load->library('upload', $config);
	}

	public function resizeImage($path, $filename) {
		$source_path = $path.$filename;
		$target_path = $path;
		$config_manip = array(
			'image_library' => 'gd2',
			'source_image' => $source_path,
			'new_image' => $target_path,
			'quality' => '60%',
			'maintain_ratio' => FALSE,
			'create_thumb' => FALSE,
			'width' => 500,
			'height' => 500,
		);

		$this->image_lib->clear();
		$this->image_lib->initialize($config_manip);
		$this->image_lib->resize();
	}


	public function prevRow($id='', $id_column='', $table='', $kegiatan='',$reverse=FALSE) {
		$jenis = '';
		if ($table == 'user') {
			$jenis = 'id_role';
		}elseif ($table == 'pekerjaan') {
			$jenis = 'jenis_pekerjaan';
		} else {
			$jenis = 'jenis_stok';
		}
		
		if ($reverse) {
			$this->db->where($id_column.' >', $id);
			if ($kegiatan != null) {
				$this->db->where($jenis, $kegiatan);
			}
			$this->db->order_by($id_column,'ASC');
		} else {
			$this->db->where($id_column.' <', $id);
			if ($kegiatan != null) {
				$this->db->where($jenis, $kegiatan);
			}
			$this->db->order_by($id_column,'DESC');
		}
		$this->db->limit(1);
		$res = $this->db->get($table)->row_array();
		return $res ? $res[$id_column] : FALSE;
	}

	public function nextRow($id='', $id_column='', $table='', $kegiatan='',$reverse=FALSE) {
		$jenis = '';
		if ($table == 'user') {
			$jenis = 'id_role';
		} elseif ($table == 'pekerjaan') {
			$jenis = 'jenis_pekerjaan';
		} else {
			$jenis = '';
		}
		if ($reverse) {
			$this->db->where($id_column.' <', $id);
			if ($kegiatan != null) {
				$this->db->where($jenis, $kegiatan);
			}
			$this->db->order_by($id_column,'DESC');
		} else {
			$this->db->where($id_column.' >', $id);
			if ($kegiatan != null) {
				$this->db->where($jenis, $kegiatan);
			}
			$this->db->order_by($id_column,'ASC');
		}

		$this->db->limit(1);
		$res = $this->db->get($table)->row_array();
		return $res ? $res[$id_column] : FALSE;
	}

	public function indexRow($id=',',$id_column='',$table='', $kegiatan='',$reverse=FALSE) {
		$jenis = '';
		if ($table == 'user') {
			$jenis = 'id_role';
		}elseif($table == 'pekerjaan') {
			$jenis = 'jenis_pekerjaan';
		} else {
			$jenis = 'jenis_stok';
		}
		if ($reverse) {
			$this->db->where($id_column.' >=', $id);
			if ($kegiatan != null) {
				$this->db->where($jenis, $kegiatan);
			}
			$this->db->order_by($id_column, 'DESC');
		} else {
			$this->db->where($id_column.' <=', $id);
			if ($kegiatan != null) {
				$this->db->where($jenis, $kegiatan);
			}
			$this->db->order_by($id_column, 'ASC');
		}
		return $this->db->get($table)->num_rows();
	}

	public function numRows($table='', $kegiatan='') {
		$jenis = '';
		if ($table == 'user') {
			$jenis = 'id_role';
		}elseif ($table == 'pekerjaan') {
			$jenis = 'jenis_pekerjaan';
		} else {
			$jenis = 'jenis_stok';
		}
		if ($kegiatan != null) {
			return $this->db->where($jenis, $kegiatan)->get($table)->num_rows();
		} else {
			return $this->db->get($table)->num_rows();
		}
		
	}
}