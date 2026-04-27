<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Barang extends RestController
{

	public $assets 	=  './assets/document/';
	public $assets_img = './assets/uploads/barang/';

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
    
        // Total semua data tanpa filter
        $recordsTotal = $this->db->count_all('barang');
    
        // Mulai query utama untuk filtering
        $this->db->from('barang');
    
        // Filter stok jika ada
        if (!empty($column[8]['search']['value'])) {
            switch ($column[8]['search']['value']) {
                case 'stok_tersisa':
                case 'stok_total':
                    $this->db->where('barang.stok >', 0);
                    break;
                case 'stok_habis':
                    $this->db->where('barang.stok', 0);
                    break;
            }
        }
    
        // Pencarian berdasarkan keyword
        if (!empty($keyword['value'])) {
            $this->db->group_start()
                     ->like('barang.no_mc', $keyword['value'])
                     ->or_like('barang.item_box', $keyword['value'])
                     ->group_end();
        }
    
        // Hitung recordsFiltered setelah filtering dilakukan
        $recordsFiltered = $this->db->count_all_results('', false);
    
        // Kolom yang bisa diurutkan
        $columns = ['barang.id', 'barang.no_mc', 'barang.item_box', 'barang.box', 'barang.size'];
    
        // Pagination
        if ($limit != '-1') {
            $this->db->limit($limit, $offset);
        }
    
        // Pengurutan data
        if (!empty($order) && isset($columns[$order[0]['column']])) {
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
        }
    
        // Ambil data hasil filtering
        $data = $this->db->get()->result_array();
    
        // Memproses data tambahan
        foreach ($data as $key => $item) {
            $data[$key]['box']         = $this->getBoxData($item['id_box']);
            $data[$key]['joint']       = $this->getJointData($item['id_joint']);
            $data[$key]['papan_pisau'] = $this->getPapanPisau($item['id_papan_pisau']);
        }
    
        // Response JSON
        $this->response([
            'draw'             => $draw,
            'recordsTotal'     => $recordsTotal,
            'recordsFiltered'  => $recordsFiltered,
            'data'             => $data,
            'count'            => $this->countStok(),
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
		    d_pekerjaan.id_barang, 
		    COUNT(DISTINCT d_pekerjaan.id_pekerjaan) as total_repeate')
		    ->from('d_pekerjaan')
		    ->join('pekerjaan', 'pekerjaan.id = d_pekerjaan.id_pekerjaan', 'left')
		    ->group_by('d_pekerjaan.id_barang')
		    ->order_by('total_repeate', 'desc');

		$query = $this->db->get();
		$data = $query->result_array();

		if (empty($data)) {
		    $this->response([
		        'draw'             => $draw,
		        'recordsTotal'     => 0,
		        'recordsFiltered'  => 0,
		        'data'             => [],
		        'message'          => 'Data tidak ditemukan'
		    ], 200);
		}

		$barang_ids = array_column($data, 'id_barang');

		$barang_list = (!empty($barang_ids)) 
		    ? $this->db->select('id, no_mc, item_box')->where_in('id', $barang_ids)->get('barang')->result_array() 
		    : [];

		if (empty($barang_list)) {
		    $this->response([
		        'draw'             => $draw,
		        'recordsTotal'     => 0,
		        'recordsFiltered'  => 0,
		        'data'             => [],
		        'message'          => 'Barang tidak ditemukan berdasarkan ID'
		    ], 200);
		}

		$barang_map = [];
		foreach ($barang_list as $barang) {
		    $barang_map[$barang['id']] = $barang;
		}

		$this->db->select('d_pekerjaan.id_barang, pekerjaan.created_at, pekerjaan.id, pekerjaan.id_pesanan, user.name, pekerjaan.created_at, pekerjaan.jenis_pekerjaan')
		    ->from('d_pekerjaan')
		    ->join('pekerjaan', 'pekerjaan.id = d_pekerjaan.id_pekerjaan', 'left')
		    ->join('user', 'user.id=pekerjaan.id_user', 'left');

		$pesanan_query = $this->db->get();
		$pesanan_list = $pesanan_query->result_array();

		$pesanan_map = [];
		foreach ($pesanan_list as $pesanan) {
		    $pesanan_map[$pesanan['id_barang']][] = [
		    	'id'		 => $pesanan['id'],
		        'id_pesanan' => $pesanan['id_pesanan'],
		        'nama_sales' => $pesanan['name'],
		        'date'		=> $pesanan['created_at'],
		        'jenis_pekerjaan' => $pesanan['jenis_pekerjaan']
		    ];
		}

		foreach ($data as $key => $item) {
		    $data[$key]['barang'] = $barang_map[$item['id_barang']] ?? null;
		    $data[$key]['pesanan_repeater'] = $pesanan_map[$item['id_barang']] ?? [];
		}

		$data = array_filter($data, function ($item) {
		    return $item['barang'] !== null;
		});

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
		        return stripos($item['barang']['no_mc'], $keyword['value']) !== false;
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
		$no_mc = $this->input->post('no_mc');
		$size = $this->input->post('size');
		$id_box = $this->input->post('id_box');
		$substance = $this->input->post('substance');
		$id_joint = $this->input->post('id_joint');
		$size = $this->input->post('size');
		$barang = $this->getProductByMc($no_mc);
		if ($barang) {
			$valid = false;
			$this->response([
				'status' 	=> 208,
				'msg' 		=> 'Product Sudah Tersedia',
			], 200);
		}
		if ($valid) {
			$box = $this->getBoxData($id_box);
			$joint = $this->getJointData($id_joint);
			$data['no_mc']		 	 = $no_mc;
			$data['item_box']		 = $this->input->post('item_box');
			$data['id_joint']	 	 = $id_joint;
			$data['id_box']	 		 = $id_box;
			$data['substance']	 = $substance;
			$data['created_at'] 	 = Date('Y-m-d H:i:s');
			$data['size']			 = $size;
			$data['id_papan_pisau']	 = $this->input->post('id_papan_pisau');
			$data['deskripsi']		 = $size .", " . $box['name'] . ", " . $substance . ", " . $joint['name'];
			$result =$this->db->insert('barang', $data);
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
		$result = $this->db->select('barang.no_mc, barang.id, barang.size, barang.item_box, barang.substance, barang.id_joint, barang.id_box, barang.id_papan_pisau, box.name as name_box, joint.name as name_joint, CONCAT(papan_pisau.no_mp," ", papan_pisau.name_size," ", papan_pisau.spesifikasi_mp) as name_papan, barang.deskripsi')->join('box', 'box.id=barang.id_box', 'left')->join('joint', 'joint.id=barang.id_joint', 'left')->join('papan_pisau', 'papan_pisau.id=barang.id_papan_pisau', 'left')->where('barang.id', $id)->get('barang')->row_array();
		$this->response($result);
	}

	function update_post() {
		$id = $this->input->post('id');
		$size = $this->input->post('size');
		$id_box = $this->input->post('id_box');
		$spek = $this->input->post('substance');
		$id_joint = $this->input->post('id_joint');
		$size = $this->input->post('size');
		$box = $this->getBoxData($id_box);
		$joint = $this->getJointData($id_joint);
		$data['no_mc']		 	 = $this->input->post('no_mc');
		$data['item_box']		 = $this->input->post('item_box');
		$data['id_joint']	 	 = $id_joint;
		$data['id_box']	 		 = $id_box;
		$data['substance']	 = $spek;
		$data['created_at'] 	 = Date('Y-m-d H:i:s');
		$data['size']			 = $size;
		$data['id_papan_pisau']	 = $this->input->post('id_papan_pisau');
		$data['deskripsi']		 = $size .", " . $box['name'] . ", " . $spek . ", " . $joint['name'];
		$result = $this->db->where('id', $id)->update('barang', $data);
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
			$no_mc_exists = $this->db->get_where('barang', ['no_mc' => $val[0]])->row_array();
			if ($no_mc_exists) {
				continue; 
			}
			$box = $this->getBox($val[3]);
			$joint = $this->getJoint($val[5]);
			$list [] = [
				'no_mc'			=> $val[0],
				'item_box'		=> $val[1],
				'size' 			=> $val[2],
				'id_box'		=> $box,
				'substance'		=> $val[4],
				'id_joint'		=> $joint,
				'deskripsi'		=> $val[2] . ", " . $val[3] . ", " . $val[4] . ", " . $val[5],
				'created_at'	=> date('Y-m-d H:i:s'),
			];
		}
		if (!empty($list)) {
			$result = $this->db->insert_batch('barang', $list);

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
		$table = 'barang';
		$q = $this->get('q');
		$page = (int) $this->get('page');

		$recordsFiltered = $this->db->count_all($table);
		if(isset($q) && $q != '') {
			$this->db->like('no_mc', $q);
			$recordsFiltered = $this->db->count_all_results($table);
		}

		$this->db->select('id, CONCAT(no_mc," ",item_box) as name');
		if(isset($q) && $q != '') {
			$this->db->like('no_mc', $q);
		}
		if(isset($page) && $page > 1) {
			$this->db->limit(10, ($page*10)-10);
		}
		$this->db->order_by('no_mc','asc');
		$data = $this->db->get($table)->result();
		$this->response(array(
			'incomplete_results' =>  true,
			'total_count' => $recordsFiltered,
			'items' => $data,
		), 200);
	}

	public function repeate_get() {
		$data = $this->db->select('
		    d_pekerjaan.id_barang, 
		    COUNT(DISTINCT d_pekerjaan.id_pekerjaan) as total_repeate')
		    ->join('pekerjaan', 'pekerjaan.id = d_pekerjaan.id_pekerjaan', 'left')
		    ->group_by('d_pekerjaan.id_barang')
		    ->order_by('total_repeate', 'desc')
		    ->get('d_pekerjaan')
		    ->result_array();

		// Jika tidak ada data, langsung kirim respons tanpa lanjut query barang
		if (empty($data)) {
		    $this->response([
		        'message' => 'Data tidak ada'
		    ], 200);
		}

		// Ambil semua id_barang untuk query barang
		$barang_ids = array_column($data, 'id_barang');

		// Pastikan $barang_ids tidak kosong sebelum query untuk mencegah error
		$barang_list = [];
		if (!empty($barang_ids)) {
		    $barang_list = $this->db->where_in('id', $barang_ids)->get('barang')->result_array();
		}

		// Buat mapping barang untuk efisiensi pencarian
		$barang_map = [];
		foreach ($barang_list as $barang) {
		    $barang_map[$barang['id']] = $barang;
		}

		// Format ulang data untuk output JSON
		$formatted_data = [];
		foreach ($data as $item) {
		    if (isset($barang_map[$item['id_barang']])) {
		        $formatted_data[] = [
		            'x' => (int) $item['total_repeate'],
		            'y' => $barang_map[$item['id_barang']]['no_mc'],
		        ];
		    }
		}

		// Ambil hanya 5 data teratas jika ada isi
		if (!empty($formatted_data)) {
		    $formatted_data = array_slice($formatted_data, 0, 5);
		    $this->response($formatted_data, 200);
		} else {
		    $this->response([
		        'message' => 'Data tidak ada setelah filtering'
		    ], 200);
		}

	}

	public function neworder_get() {
		$data = $this->db->select('d_pekerjaan.id_barang, COUNT(d_pekerjaan.id) as total_repeate')
		    ->join('pekerjaan', 'pekerjaan.id = d_pekerjaan.id_pekerjaan', 'left')
		    ->where('pekerjaan.jenis_order', 'new-order')
		    ->group_by('d_pekerjaan.id_barang')
		    ->order_by('total_repeate', 'desc')
		    ->get('d_pekerjaan')
		    ->result_array();

		$barang_ids = array_column($data, 'id_barang');
		$barang_list = $this->db->where_in('id', $barang_ids)->get('barang')->result_array();
		$barang_map = [];
		foreach ($barang_list as $barang) {
		    $barang_map[$barang['id']] = $barang;
		}
		foreach ($data as $key => $item) {
		    $data[$key]['barang'] = $barang_map[$item['id_barang']]['item_box'] ?? null;
		}
		$data = array_filter($data, function ($item) {
		    return $item['barang'] !== null;
		});
		$data = array_values($data);
		$this->response($data);
	}


	public function lainnya_get() {
		$data = $this->db->select('d_pekerjaan.id_barang, COUNT(d_pekerjaan.id) as total_repeate')
		    ->join('pekerjaan', 'pekerjaan.id = d_pekerjaan.id_pekerjaan', 'left')
		    ->where('pekerjaan.jenis_order', 'lainnya')
		    ->group_by('d_pekerjaan.id_barang')
		    ->order_by('total_repeate', 'desc')
		    ->get('d_pekerjaan')
		    ->result_array();

		$barang_ids = array_column($data, 'id_barang');
		$barang_list = $this->db->where_in('id', $barang_ids)->get('barang')->result_array();
		$barang_map = [];
		foreach ($barang_list as $barang) {
		    $barang_map[$barang['id']] = $barang;
		}
		foreach ($data as $key => $item) {
		    $data[$key]['barang'] = $barang_map[$item['id_barang']]['item_box'] ?? null;
		}
		$data = array_filter($data, function ($item) {
		    return $item['barang'] !== null;
		});
		$data = array_values($data);
		$this->response($data);
	}


	private function getOne($id) {
		$data = $this->db->where('id', $id)->get('barang')->row_array();
		return $data;
	}

	private function getOneBarangByName($id) {
		$data = $this->db->select('item_box')->where('id', $id)->get('barang')->row_array();
		return $data;
	}


	private function getOneDetailPekerjaan($id) {
		$data = $this->db->where('id_barang', $id)->get('d_pekerjaan')->row_array();
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


	private function getBox($name) {
		$data = $this->db->where('name', $name)->get('box')->row_array();
		return $data? $data['id'] : '';
	}

	private function getProductByMc($mc) {
		$data = $this->db->where('no_mc', $mc)->get('barang')->row_array();
		return $data;
	}

	private function getJoint($name) {
		$data = $this->db->where('name', $name)->get('joint')->row_array();
		return $data? $data['id'] : '';
	}

	private function getBoxData($id) {
		$data = $this->db->where('id', $id)->get('box')->row_array();
		return $data;
	}

	private function getJointData($id) {
		$data = $this->db->where('id', $id)->get('joint')->row_array();
		return $data;
	}

	private function getPapanPisau($id) {
		$data = $this->db->select('id, CONCAT(no_mp," ",name_size," ",spesifikasi_mp) as name')->where('id', $id)->get('papan_pisau')->row_array();
		return $data;
	}

}
