<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';



class Dashboard extends RestController
{

	public $assets = './assets/uploads/barang/';

	function __construct() {
		parent::__construct();
		$this->checkUserLog();
	}

	function waiting_get($id='') {
		$draw 		= (int) $this->get('draw');
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');

		if ($id) {
			$recordsTotal = $this->db->where('id_user', $id)->where('status', 'waiting')->count_all_results('pekerjaan');
		} else {
			$recordsTotal = $this->db->where('status', 'waiting')->count_all_results('pekerjaan');
		}
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
			if ($id) {
				$recordsTotal = count($this->db->where('id_user', $id)->get('pekerjaan')->result_array());
			} else {
				$recordsFiltered = $this->db->count_all_results('pekerjaan');
			}
			
		}

		$columns = ['id','name'];
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}else {
		    $this->db->order_by('id', 'desc');    
		}
		
		if ($id) {
			$data = $this->db->where('status', 'waiting')->where('id_user', $id)->get('pekerjaan')->result_array();
		}else {
			$data = $this->db->where('status', 'waiting')->get('pekerjaan')->result_array();
		}
		
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function done_get($id='') {
		$draw 		= (int) $this->get('draw');
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');

		if ($id) {
			$recordsTotal = $this->db->where('id_user', $id)->where('status', 'done')->count_all_results('pekerjaan');
		} else {
			$recordsTotal = $this->db->where('status', 'done')->count_all_results('pekerjaan');
		}
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
			if ($id) {
				$recordsTotal = count($this->db->where('id_user', $id)->get('pekerjaan')->result_array());
			} else {
				$recordsFiltered = $this->db->count_all_results('pekerjaan');
			}
			
		}

		$columns = ['id','name'];
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}else {
		    $this->db->order_by('id', 'desc');    
		}
		
		if ($id) {
			$data = $this->db->where('status', 'done')->where('id_user', $id)->get('pekerjaan')->result_array();
		} else {
			$data = $this->db->where('status', 'done')->get('pekerjaan')->result_array();
		}
		
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function approved_get($id='') {
		$draw 		= (int) $this->get('draw');
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');

		if ($id) {
			$recordsTotal = $this->db->where('id_user', $id)->where('status', 'approved')->count_all_results('pekerjaan');
		} else {
			$recordsTotal = $this->db->where('status', 'approved')->count_all_results('pekerjaan');
		}
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
			if ($id) {
				$recordsTotal = count($this->db->where('id_user', $id)->get('pekerjaan')->result_array());
			} else {
				$recordsFiltered = $this->db->count_all_results('pekerjaan');
			}
			
		}

		$columns = ['id','name'];
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}else {
		    $this->db->order_by('id', 'desc');    
		}
		
		if ($id) {
			$data = $this->db->where('status', 'approved')->where('id_user', $id)->get('pekerjaan')->result_array();
		} else {
			$data = $this->db->where('status', 'approved')->get('pekerjaan')->result_array();
		}
		
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function logistik_get() {
		$draw 		= (int) $this->get('draw');
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');

		$recordsTotal = $this->db->count_all('pekerjaan');
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
			$recordsFiltered = $this->db->count_all_results('pekerjaan');
		}

		$columns = ['id','name'];
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}else {
		    $this->db->order_by('id', desc);    
		}
		
		$data = $this->db->where('status', 'approved-shipping')->get('pekerjaan')->result_array();
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function cutting_get($id='') {
		$draw 		= (int) $this->get('draw');
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');

		if ($id) {
			$recordsTotal = $this->db->where('id_user', $id)->where('status', 'cutting')->count_all_results('pekerjaan');
		} else {
			$recordsTotal = $this->db->where('status', 'cutting')->count_all_results('pekerjaan');
		}
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
			if ($id) {
				$recordsTotal = count($this->db->where('id_user', $id)->get('pekerjaan')->result_array());
			} else {
				$recordsFiltered = $this->db->count_all_results('pekerjaan');
			}
			
		}

		$columns = ['id','name'];
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		} else {
		    $this->db->order_by('id', 'desc');
		}
		
		if ($id) {
			$data = $this->db->where('status', 'cutting')->where('id_user', $id)->get('pekerjaan')->result_array();
		} else {
			$data = $this->db->where('status', 'cutting')->get('pekerjaan')->result_array();
		}
		
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function desain_get($id='') {
		$draw 		= (int) $this->get('draw');
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');

		if ($id) {
			$recordsTotal = $this->db->where('id_user', $id)->where('status', 'desain')->count_all_results('pekerjaan');
		} else {
			$recordsTotal = $this->db->where('status', 'desain')->count_all_results('pekerjaan');
		}
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
			if ($id) {
				$recordsTotal = count($this->db->where('id_user', $id)->get('pekerjaan')->result_array());
			} else {
				$recordsFiltered = $this->db->count_all_results('pekerjaan');
			}
			
		}

		$columns = ['id','name'];
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}else {
		    $this->db->order_by('id', 'desc');    
		}
		
		if ($id) {
			$data = $this->db->where('status', 'desain')->where('id_user', $id)->get('pekerjaan')->result_array();
		} else {
			$data = $this->db->where('status', 'desain')->get('pekerjaan')->result_array();
		}
		
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
			$data[$key]['detail'] =  $this->getDetailPekerjaan($value['id']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function printing_get($id='') {
		$draw 		= (int) $this->get('draw');
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');

		if ($id) {
			$recordsTotal = $this->db->where('id_user', $id)->where('status', 'printing')->count_all_results('pekerjaan');
		} else {
			$recordsTotal = $this->db->where('status', 'printing')->count_all_results('pekerjaan');
		}
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
			if ($id) {
				$recordsTotal = count($this->db->where('id_user', $id)->get('pekerjaan')->result_array());
			} else {
				$recordsFiltered = $this->db->count_all_results('pekerjaan');
			}
			
		}

		$columns = ['id','name'];
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}else {
		    $this->db->order_by('id', 'desc');
		}
		if ($id) {
			$data = $this->db->where('status', 'printing')->where('id_user', $id)->get('pekerjaan')->result_array();
		} else {
			$data = $this->db->where('status', 'printing')->get('pekerjaan')->result_array();
		}
		
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function packing_get($id='') {
		$draw 		= (int) $this->get('draw');
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');

		if ($id) {
			$recordsTotal = $this->db->where('id_user', $id)->where('status', 'packing')->count_all_results('pekerjaan');
		} else {
			$recordsTotal = $this->db->where('status', 'packing')->count_all_results('pekerjaan');
		}
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
			if ($id) {
				$recordsTotal = count($this->db->where('id_user', $id)->get('pekerjaan')->result_array());
			} else {
				$recordsFiltered = $this->db->count_all_results('pekerjaan');
			}
			
		}

		$columns = ['id','name'];
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
		}
		if(isset($offset) && $limit != '-1') {
			$this->db->limit($limit, $offset);
		}
		if(isset($order)) {
			$this->db->order_by($columns[$order[0]['column']],$order[0]['dir']);
		}else {
		    $this->db->order_by('id', 'desc');
		}
		if ($id) {
			$data = $this->db->where('status', 'packing')->where('id_user', $id)->get('pekerjaan')->result_array();
		} else {
			$data = $this->db->where('status', 'packing')->get('pekerjaan')->result_array();
		}
		
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

    function all_get($id = '') {
        $draw      = (int) $this->get('draw');
        $limit     = (int) $this->get('length');
        $offset    = (int) $this->get('start');
        $keyword   = $this->get('search');
        $order     = $this->get('order');
    
        if ($id) {
            $recordsTotal = $this->db->where('id_user', $id)
                ->where('status !=', 'approved-shipping')
                ->where('status !=', 'approved-customer')
                ->count_all_results('pekerjaan');
        } else {
            $recordsTotal = $this->db->where('status !=', 'approved-shipping')
                ->where('status !=', 'approved-customer')
                ->count_all_results('pekerjaan');;
        }
    
        $recordsFiltered = $recordsTotal;
        $columns = ['id', 'id_pesanan', 'status', 'due_date', 'created_at'];
    
        // Pagination
        if (isset($offset) && $limit != '-1') {
            $this->db->limit($limit, $offset);
        }
    
        // Order By - Default Descending jika tidak ada request sorting
        if (isset($order) && !empty($order)) {
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    
        // Query utama
        $this->db->where('status !=', 'approved-shipping')
            ->where('status !=', 'approved-customer');
        
    
        if ($id) {
            $this->db->where('id_user', $id);
        }
    
        $data = $this->db->get('pekerjaan')->result_array();
    
        // Tambahkan data user
        foreach ($data as $key => $value) {
            $data[$key]['user'] = $this->getUser($value['id_user']);
        }
    
        // Kirim response
        $this->response(array(
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ), 200);
    }


	function countProses_get($id='') {
		$status = array('cutting', 'desain', 'printing', 'packing', 'done', 'approved', 'waiting', 'waiting-marketing');
		$data['all']		= $this->getPekerjaanAll($id, $status);
		$data['waiting']	= $this->getPekerjaan($id, 'waiting');
		$data['cutting']	= $this->getPekerjaan($id, 'cutting');
		$data['desain']		= $this->getPekerjaan($id, 'desain');
		$data['printing']	= $this->getPekerjaan($id, 'printing');
		$data['packing']	= $this->getPekerjaan($id, 'packing');
		$data['done']		= $this->getPekerjaan($id, 'done');
		$data['approved']	= $this->getPekerjaan($id, 'approved');
		$data['approved_shipping'] = $this->getPekerjaan($id, 'approved-shipping');
		$this->response($data,200);
	}

	private function getPekerjaanAll($id_user, $status) {
		if ($id_user) {
			$data = $this->db->where_in('status', $status)->where('id_user', $id_user)->get('pekerjaan')->result_array(); 
			return count($data);
		} else {
			$data = $this->db->where_in('status', $status)->get('pekerjaan')->result_array();
			return  count($data);
		}
	}

	private function getPekerjaan($id_user, $status) {
		if ($id_user) {
			$data = $this->db->where('status', $status)->where('id_user', $id_user)->get('pekerjaan')->result_array(); 
			return count($data);
		} else {
			$data = $this->db->where('status', $status)->get('pekerjaan')->result_array();
			return  count($data);
		}
	}


	function countJenisPekerjaan_get() {
		$data_polosan = $this->db->where('jenis_pekerjaan', 'polosan')->get('pekerjaan')->result_array();
		$data_custom = $this->db->where('jenis_pekerjaan', 'custom-desain')->get('pekerjaan')->result_array();
		$data_digital = $this->db->get('pekerjaan_digital')->result_array();
		$dataProduk = $this->db->get('barang')->result_array();
		$dataDgp = $this->db->get('barang_dgp')->result_array();

		$data['polosan'] = count($data_polosan);
		$data['custom']	 = count($data_custom);
		$data['digital'] = count($data_digital);
		$data['box'] = count($dataProduk);
		$data['dgp'] = count($dataDgp);


		$this->response($data, 200);
	}

	function countStok_get() {
		$dataStokTersedia = $this->db->where('stok >', 0)->get('barang')->result_array();
		$dataStokHabis = $this->db->where('stok', 0)->get('barang')->result_array();
		$total = $this->db->select('SUM(stok) as total')->get('barang')->row_array();
		$data['stok_ada'] = count($dataStokTersedia);
		$data['stok_habis'] = count($dataStokHabis);
		$data['total'] = intval($total['total']);
		$this->response($data, 200);
	}

	// ──────────────────────────────────────────────────────────────────────────
	// Endpoints untuk monitor role-based (Sprint 2A / 2B)
	// ──────────────────────────────────────────────────────────────────────────

	/**
	 * Kabag Produksi tab "Menunggu" — status sedang dikerjakan
	 * status IN ('cutting', 'printing', 'packing')
	 */
	function menunggu_get() {
		$statuses = ['cutting', 'printing', 'packing'];
		$this->_list_by_statuses($statuses);
	}

	/**
	 * Kabag Produksi tab "Selesai" — sudah selesai produksi
	 * status IN ('done', 'approved', 'approved-customer')
	 */
	function selesai_kabag_get() {
		$statuses = ['done', 'approved', 'approved-customer'];
		$this->_list_by_statuses($statuses);
	}

	/**
	 * Kabag Gudang tab "Dikirim" — sudah dikirim ke customer
	 * status = 'approved-customer'
	 */
	function dikirim_get() {
		$statuses = ['approved-customer'];
		$this->_list_by_statuses($statuses);
	}

	/**
	 * Hitung badge count untuk 2 tab Kabag Produksi
	 */
	function countKabagProduksi_get() {
		$data['menunggu'] = $this->db->where_in('status', ['cutting', 'printing', 'packing'])
		                             ->count_all_results('pekerjaan');
		$data['selesai']  = $this->db->where_in('status', ['done', 'approved', 'approved-customer'])
		                             ->count_all_results('pekerjaan');
		$this->response($data, 200);
	}

	/**
	 * Hitung badge count untuk 2 tab Kabag Gudang
	 */
	function countKabagGudang_get() {
		$data['disetujui'] = $this->db->where('status', 'approved')
		                              ->count_all_results('pekerjaan');
		$data['dikirim']   = $this->db->where('status', 'approved-customer')
		                              ->count_all_results('pekerjaan');
		$this->response($data, 200);
	}

	/**
	 * Shared: ambil list pekerjaan + user berdasarkan array status, dengan DataTables support.
	 */
	private function _list_by_statuses(array $statuses) {
		$draw    = (int) $this->get('draw');
		$limit   = (int) $this->get('length');
		$offset  = (int) $this->get('start');
		$keyword = $this->get('search');

		$total = $this->db->where_in('status', $statuses)->count_all_results('pekerjaan');
		$recordsFiltered = $total;

		if (!empty($keyword['value'])) {
			$this->db->where_in('status', $statuses)->like('id_pesanan', $keyword['value']);
			$recordsFiltered = $this->db->count_all_results('pekerjaan');
		}

		$this->db->select('pekerjaan.id, pekerjaan.id_pesanan, pekerjaan.status, pekerjaan.created_at, pekerjaan.due_date, pekerjaan.durasi, pekerjaan.id_user, pekerjaan.jenis_pekerjaan, pekerjaan.completed_at, pekerjaan.shipped_at');
		$this->db->where_in('pekerjaan.status', $statuses);
		if (!empty($keyword['value'])) {
			$this->db->like('pekerjaan.id_pesanan', $keyword['value']);
		}
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('pekerjaan.id', 'desc');
		$data = $this->db->get('pekerjaan')->result_array();

		foreach ($data as &$item) {
			$item['user'] = $this->getUser($item['id_user']);
		}

		$this->response([
			'draw'            => $draw,
			'recordsTotal'    => $total,
			'recordsFiltered' => $recordsFiltered,
			'data'            => $data,
		], 200);
	}

	private function getUser($id) {
		$data = $this->db->select('name')->where('id', $id)->get('user')->row_array();
		return $data;
	}
	private function getDetailPekerjaan($id) {
		$data = $this->db->select('barang.item_box, barang.no_mc, barang.deskripsi, inside, outside, color, CONCAT("'.base_url($this->assets).'",outside) as outside, CONCAT("'.base_url($this->assets).'",inside) as inside, CONCAT("'.base_url($this->assets).'",color) as color ')->join('barang', 'barang.id=d_pekerjaan.id_barang')->where('d_pekerjaan.id_pekerjaan', $id)->get('d_pekerjaan')->result_array();
		return $data;
		
	}


	private function getBarang($id) {
		$data = $this->db->select('color, inside, outside')->where('id', $id)->get('barang')->row_array();
		return $data;
	}

}
