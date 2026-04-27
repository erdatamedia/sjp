<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Barangdgp extends RestController
{

	public $assets 	=  './assets/document/';
	public $assets_img = './assets/uploads/digital/';

	function __construct() {
		parent::__construct();
		$this->checkUserLog();
	}

    function index_get() {
        $draw     = (int) $this->get('draw');
        $limit    = (int) $this->get('length');
        $offset   = (int) $this->get('start');
        $keyword  = $this->get('search');
        $order    = $this->get('order');
        $column   = $this->get('columns');

        $recordsTotal = $this->db->count_all('barang_dgp');
    
        $this->db->from('barang_dgp');
    
        if (!empty($keyword['value'])) {
            $this->db->group_start()
                     ->like('barang_dgp.no_mc_label', $keyword['value'])
                     ->or_like('barang_dgp.nama_dgp', $keyword['value'])
                     ->group_end();
        }
    
        $recordsFiltered = $this->db->count_all_results('', false);
    
        $columns = ['id', 'no_mc_label', 'material', 'size'];
    
        if ($limit != '-1') {
            $this->db->limit($limit, $offset);
        }
    
        if (!empty($order) && isset($columns[$order[0]['column']])) {
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
        }
        $data = $this->db->get()->result_array();
 
        foreach ($data as $key => $item) {
            $data[$key]['material'] = $this->getMaterial($item['id_material']);
        }
    
        $this->response([
            'draw'             => $draw,
            'recordsTotal'     => $recordsTotal,
            'recordsFiltered'  => $recordsFiltered,
            'data'             => $data,
        ], 200);
    }

    function allRepeat_get() {
		$draw     = (int) $this->get('draw');
		$limit    = (int) $this->get('length');
		$offset   = (int) $this->get('start');
		$keyword  = $this->get('search');
		$order    = $this->get('order');
		$column   = $this->get('columns');

		$this->db->select('
		    d_pekerjaan_digital.id_produk, 
		    COUNT(DISTINCT d_pekerjaan_digital.id_pekerjaan) as total_repeate
		')
		->from('d_pekerjaan_digital')
		->group_by('d_pekerjaan_digital.id_produk')
		->order_by('total_repeate', 'desc');

		$query = $this->db->get();
		$data = $query->result_array();

		// Jika tidak ada data awal, kirim response kosong dalam format DataTables
		if (empty($data)) {
		    $this->response([
		        'draw'             => $draw,
		        'recordsTotal'     => 0,
		        'recordsFiltered'  => 0,
		        'data'             => [],
		        'message'          => 'Data tidak ditemukan'
		    ], 200);
		}

		// Ambil semua id_produk untuk query barang
		$barang_ids = array_column($data, 'id_produk');

		// Query barang jika ada ID yang ditemukan
		$barang_list = (!empty($barang_ids)) 
		    ? $this->db->select('no_mc_label, nama_dgp, id')->where_in('id', $barang_ids)->get('barang_dgp')->result_array() 
		    : [];

		// Jika barang tidak ditemukan, tetap kembalikan response kosong
		if (empty($barang_list)) {
		    $this->response([
		        'draw'             => $draw,
		        'recordsTotal'     => 0,
		        'recordsFiltered'  => 0,
		        'data'             => [],
		        'message'          => 'Barang tidak ditemukan berdasarkan ID'
		    ], 200);
		}

		// Buat mapping barang untuk pencocokan cepat
		$barang_map = [];
		foreach ($barang_list as $barang) {
		    $barang_map[$barang['id']] = $barang;
		}

		// Ambil daftar pesanan (id_pesanan) dan nama sales yang terkait
		$this->db->select('
		    d_pekerjaan_digital.id_produk, 
		    pekerjaan_digital.id_pesanan, 
		    user.name as nama_sales, 
		    pekerjaan_digital.created_at
		')
		->from('d_pekerjaan_digital')
		->join('pekerjaan_digital', 'pekerjaan_digital.id = d_pekerjaan_digital.id_pekerjaan', 'left')
		->join('user', 'user.id = pekerjaan_digital.id_user', 'left');

		$pesanan_query = $this->db->get();
		$pesanan_list = $pesanan_query->result_array();

		// Buat mapping pesanan berdasarkan id_produk
		$pesanan_map = [];
		foreach ($pesanan_list as $pesanan) {
		    $pesanan_map[$pesanan['id_produk']][] = [
		        'id_pesanan' => $pesanan['id_pesanan'],
		        'nama_sales' => $pesanan['nama_sales'],
		        'date'       => $pesanan['created_at']
		    ];
		}

		// Gabungkan data pekerjaan dengan data barang dan pesanan
		foreach ($data as $key => $item) {
		    $data[$key]['barang'] = $barang_map[$item['id_produk']] ?? null;
		    $data[$key]['pesanan_repeater'] = $pesanan_map[$item['id_produk']] ?? [];
		}

		// Filter data yang tidak memiliki barang
		$data = array_filter($data, function ($item) {
		    return $item['barang'] !== null;
		});

		// Jika setelah filter data kosong, kembalikan response kosong
		if (empty($data)) {
		    $this->response([
		        'draw'             => $draw,
		        'recordsTotal'     => 0,
		        'recordsFiltered'  => 0,
		        'data'             => [],
		        'message'          => 'Semua data terfilter karena barang = null'
		    ], 200);
		}

		// Jika ada pencarian, filter data berdasarkan kata kunci
		if (!empty($keyword['value'])) {
		    $data = array_filter($data, function ($item) use ($keyword) {
		        return stripos($item['barang']['no_mc_label'], $keyword['value']) !== false;
		    });
		}

		// Hitung total data setelah filtering
		$recordsTotal = count($data);
		$recordsFiltered = $recordsTotal;

		// Reset index array setelah filtering
		$data = array_values($data);

		// Batasi data sesuai pagination DataTables
		$data = array_slice($data, $offset, $limit);

		// Kirim response dalam format DataTables
		$this->response([
		    'draw'             => $draw,
		    'recordsTotal'     => $recordsTotal,
		    'recordsFiltered'  => $recordsFiltered,
		    'data'             => $data,
		], 200);


    }



	function save_post() {
		$valid = true;
		$no_mc_label = $this->input->post('no_mc_label');
		$size = $this->input->post('size');
		$id_material = $this->input->post('id_material');
		$name_dgp = $this->input->post('name_dgp');
		$barangdgp = $this->getProductDgpByMc($no_mc_label);
		if ($barangdgp) {
			$valid = false;
			$this->response([
				'status' 	=> 208,
				'msg' 		=> 'Product Sudah Tersedia',
			], 200);
		}
		if ($valid) {
			$data['no_mc_label']	 = $no_mc_label;
			$data['nama_dgp']		 = $name_dgp;
			$data['id_material']	 = intval($id_material);
			$data['size']			 = $size;
			$result =$this->db->insert('barang_dgp', $data);
			if ($result) {
				$this->response([
					'status' 	=> 209,
					'msg' 		=> 'Saved',
				], 200);
			}else{
				$this->response($this->db->error(), 400);
			}
		}
		
	}

	function edit_get() {
		$id = $this->get('id');
		$result = $this->db->select('barang_dgp.no_mc_label, barang_dgp.id, barang_dgp.size, barang_dgp.nama_dgp, barang_dgp.id_material, material.name as name_material')->join('material', 'material.id=barang_dgp.id_material', 'left')->where('barang_dgp.id', $id)->get('barang_dgp')->row_array();
		$this->response($result);
	}

	function view_get() {
		$id = $this->get('id');
		$result = $this->db->select('barang_dgp.no_mc_label, barang_dgp.id, barang_dgp.size, barang_dgp.nama_dgp, barang_dgp.id_material, material.name as name_material, CONCAT("'.base_url($this->assets_img).'",image) as image')->join('material', 'material.id=barang_dgp.id_material', 'left')->where('barang_dgp.id', $id)->get('barang_dgp')->row_array();
		$this->response($result);
	}



	function update_post() {
		$id = $this->input->post('id');
		$no_mc_label = $this->input->post('no_mc_label');
		$size = $this->input->post('size');
		$id_material = $this->input->post('id_material');
		$name_dgp = $this->input->post('name_dgp');
		$data['no_mc_label']	 = $no_mc_label;
		$data['nama_dgp']		 = $name_dgp;
		$data['id_material']	 = intval($id_material);
		$data['size']			 = $size;
		$result = $this->db->where('id', $id)->update('barang_dgp', $data);
		$this->response([
			'status' => $result,
			'msg'	 => 'Updated'
		]);
	}

	function delete_post() {
		$id = $this->input->post('id');
		$pekerjaan = $this->getOneDetailPekerjaan($id);
		if ($pekerjaan) {
			$this->response([
				'status' 	=> 1,
				'msg' 		=> 'Data masih digunakan',
			], 200);
		}
		$exits = $this->getOne($id);
		if ($exits) {
			$this->db->where('id', $id)->delete('barang');
			$old_img_inside = $this->assets_img.$exits['inside'];
			$old_img_outside = $this->assets_img.$exits['outside'];
			if (is_file($old_img_inside) && file_exists($old_img_inside)) {
				unlink($old_img_inside);
			}
			if (is_file($old_img_outside) && file_exists($old_img_outside)) {
				unlink($old_img_outside);
			}
			$this->response([
				'status' 	=> 2,
				'msg' 		=> 'Deleted',
			], 200);
		} else {
			$this->response([
				'status' 	=> 3,
				'msg' 		=> 'Error',
			], 200);
		}
	}

	function import_post() {
		$path 		= $this->assets;
		$desain = $_FILES['file'];
		$this->upload_config($path);
		$_FILES['file']['name']     = $desain['name'];
		$_FILES['file']['type']     = $desain['type'];
		$_FILES['file']['tmp_name'] = $desain['tmp_name'];
		$_FILES['file']['error']    = $desain['error'];
		$_FILES['file']['size']     = $desain['size'];
		$this->upload->do_upload('file');
		$file_data 	= $this->upload->data();
		$file_name 	= $file_data['file_name'];
		
		$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet 	= $reader->load($path.$file_name);
		$sheet_data 	= $spreadsheet->getActiveSheet()->toArray();
		$start_row = 1;
		$list 			= [];
		foreach($sheet_data as $key => $val) {
			if ($key < $start_row || empty($val[0])) {
				continue;
			}
			$no_mc_exists = $this->db->get_where('barang_dgp', ['no_mc_label' => $val[0]])->row_array();
			if ($no_mc_exists) {
				continue; 
			}
			$material = $this->getMaterialId($val[1]);
			$list [] = [
				'no_mc_label'	=> $val[0],
				'nama_dgp'		=> $val[2],
				'id_material'	=> $material ? $material['id'] : '',
				'created_at'	=> date('Y-m-d H:i:s'),
			];
		}
		if (!empty($list)) {
			$result = $this->db->insert_batch('barang_dgp', $list);

			if ($result) {
				$old_file = $path.$file_name;
				if (is_file($old_file) && file_exists($old_file)) {
					unlink($old_file);
				}

				$this->response([
					'status' => true
				]);
			} else {
				$this->response($this->db->error(), 400);
			}
		} else {
			$this->response([
				'status' => true,
			]);
		}

	}

	public function select2_get() {
		$table = 'barang_dgp';
		$q = $this->get('q');
		$page = (int) $this->get('page');

		$recordsFiltered = $this->db->count_all($table);
		if(isset($q) && $q != '') {
			$this->db->like('no_mc', $q);
			$recordsFiltered = $this->db->count_all_results($table);
		}

		$this->db->select('id, CONCAT(no_mc_label," ",nama_dgp) as name');
		if(isset($q) && $q != '') {
			$this->db->like('no_mc_label', $q);
			$this->db->or_like('nama_dgp', $q);
		}
		if(isset($page) && $page > 1) {
			$this->db->limit(10, ($page*10)-10);
		}
		$this->db->order_by('no_mc_label','asc');
		$data = $this->db->get($table)->result();
		$this->response(array(
			'incomplete_results' =>  true,
			'total_count' => $recordsFiltered,
			'items' => $data,
		), 200);
	}


	public function repeate_get() {
		$data = $this->db->select('d_pekerjaan_digital.id_produk, COUNT(pekerjaan_digital.id) as total_repeate')
            ->join('pekerjaan_digital', 'pekerjaan_digital.id = d_pekerjaan_digital.id_pekerjaan', 'left')
            ->group_by('d_pekerjaan_digital.id_produk')
            ->order_by('total_repeate', 'desc')
            ->get('d_pekerjaan_digital')
            ->result_array();
        
        // Jika tidak ada data, langsung kirim respons dengan HTTP 200
        if (empty($data)) {
            $this->response([
                'message' => 'Data tidak ada'
            ], 200);
        }
        
        // Ambil semua id_produk untuk query barang
        $barang_ids = array_column($data, 'id_produk');
        
        // Pastikan barang_ids tidak kosong sebelum query
        $barang_list = [];
        if (!empty($barang_ids)) {
            $barang_list = $this->db->where_in('id', $barang_ids)->get('barang_dgp')->result_array();
        }
        
        // Buat mapping barang
        $barang_map = [];
        foreach ($barang_list as $barang) {
            $barang_map[$barang['id']] = $barang;
        }
        
        // Format ulang data
        $formatted_data = [];
        foreach ($data as $item) {
            if (isset($barang_map[$item['id_produk']])) {
                $formatted_data[] = [
                    'x' => (int) $item['total_repeate'],
                    'y' => $barang_map[$item['id_produk']]['no_mc_label'],
                ];
            }
        }
        
        // Ambil hanya 5 data teratas
        $formatted_data = array_slice($formatted_data, 0, 5);
        
        // Jika masih kosong setelah filtering, kirim respons
        if (empty($formatted_data)) {
            $this->response([
                'message' => 'Data tidak ada setelah filtering'
            ], 200);
        }
        
        // Kirim data yang telah diformat
        $this->response($formatted_data, 200);

	
	}

	private function getOne($id) {
		$data = $this->db->where('id', $id)->get('barang')->row_array();
		return $data;
	}


	private function getOneDetailPekerjaan($id) {
		$data = $this->db->where('id_barang', $id)->get('d_pekerjaan_digital')->row_array();
		return $data;
	}

	private function countStok() {
		$dataStokTersedia = $this->db->where('stok >', 0)->get('barang')->result_array();
		$dataStokHabis = $this->db->where('stok', 0)->get('barang')->result_array();
		$total = $this->db->select('SUM(stok) as total')->get('barang')->row_array();
		$data['stok_ada'] = count($dataStokTersedia);
		$data['stok_habis'] = count($dataStokHabis);
		$data['total'] = intval($total['total']);
		$data['total_barang'] = count($this->db->get('barang')->result_array());
		return $data;
	}

	private function upload_config($path) {		
		$config['upload_path'] 		= $path;		
		$config['allowed_types'] 	= 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename']	 	= '255';
		$config['encrypt_name'] 	= TRUE;
		$config['max_size'] 		= 4096; 
		$this->load->library('upload', $config);
	}


	private function getProductDgpByMc($mc) {
		$data = $this->db->where('no_mc_label', $mc)->get('barang_dgp')->row_array();
		return $data;
	}

	private function getBoxData($id) {
		$data = $this->db->where('id', $id)->get('box')->row_array();
		return $data;
	}

	private function getJointData($id) {
		$data = $this->db->where('id', $id)->get('joint')->row_array();
		return $data;
	}

	private function getMaterial($id) {
		$data = $this->db->select('name')->where('id', $id)->get('material')->row_array();
		return $data;
	}
	
	private function getMaterialId($name) {
		$data = $this->db->select('id')->where('name', $name)->get('material')->row_array();
		return $data;
	}

}
