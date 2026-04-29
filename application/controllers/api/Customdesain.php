<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';



class Customdesain extends RestController
{
	public $assets 	=  './assets/uploads/barang/';

	function __construct() {
		parent::__construct();
		$this->checkUserLog();
		$this->load->library('pusher_library');
	}

	private static $ROLE_VIEW_STATUS = [
		1  => ['waiting', 'cutting', 'printing', 'packing', 'done'],
		5  => ['cutting'],
		6  => ['packing', 'done'],
		7  => ['approved', 'approved-shipping', 'approved-customer'],
		10 => ['done', 'approved', 'approved-shipping', 'approved-customer'],
		4  => ['printing'],
		3  => ['desain'],
		11 => ['desain'],
	];

	private static $ROLE_CHANGE_STATUS = [
		'desain'            => [1, 3, 11, 8],
		'cutting'           => [1, 3, 8],
		'printing'          => [4, 8],
		'packing'           => [4, 5, 8],
		'done'              => [6, 8],
		'approved'          => [1, 10, 8],
		'approved-shipping' => [7, 8],
		'approved-customer' => [7, 8],
	];

	private function _session_role() {
		$s = $this->session->userdata('sbki');
		return $s ? (int) $s['id_role'] : 0;
	}

	private function _session_user_id() {
		$s = $this->session->userdata('sbki');
		return $s ? (int) $s['id'] : 0;
	}

	function index_get() {
        $id_role = $this->_session_role();
        if ($id_role === 2) {
            $this->sales_get();
            return;
        }
        $allowed = isset(self::$ROLE_VIEW_STATUS[$id_role])
            ? self::$ROLE_VIEW_STATUS[$id_role]
            : null;

        $draw     = (int) $this->get('draw');
        $limit    = (int) $this->get('length');
        $offset   = (int) $this->get('start');
        $keyword  = $this->get('search');
        $order    = $this->get('order');
        $column   = $this->get('columns');
    
        // Total semua data sebelum filter
        $this->db->where('jenis_pekerjaan', 'custom-desain');
        if ($allowed !== null) $this->db->where_in('status', $allowed);
        $recordsTotal = $this->db->count_all_results('pekerjaan');

        $this->db->from('pekerjaan')
                 ->join('user', 'user.id = pekerjaan.id_user', 'left')
                 ->where('pekerjaan.jenis_pekerjaan', 'custom-desain');
        if ($allowed !== null) $this->db->where_in('pekerjaan.status', $allowed);
    
        // Filter berdasarkan status
        if (!empty($column[5]['search']['value'])) {
            $this->db->where('pekerjaan.status', $column[5]['search']['value']);
        }
    
        // Filter berdasarkan keyword
        if (!empty($keyword['value'])) {
            $this->db->group_start()
                     ->like('pekerjaan.id_pesanan', $keyword['value'])
                     ->group_end();
        }
    
        // Hitung recordsFiltered setelah filter
        $recordsFiltered = $this->db->count_all_results('', false);
    
        // Pagination
        if ($limit != '-1') {
            $this->db->limit($limit, $offset);
        }
    
        // Sorting
        $columns = ['pekerjaan.id_pesanan', 'pekerjaan.created_at', 'pekerjaan.due_date', 'pekerjaan.status', 'user.name'];
        if (!empty($order) && isset($columns[$order[0]['column']])) {
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
        } else {
            $this->db->order_by('pekerjaan.id', 'desc');
        }
    
        // Ambil data setelah filter, limit, dan sorting
        $data = $this->db->select('pekerjaan.id, pekerjaan.due_date, pekerjaan.id_pesanan, pekerjaan.status, pekerjaan.created_at, pekerjaan.jenis_order, user.name')
                         ->get()
                         ->result_array();
    
        // Tambahkan detail pekerjaan
        foreach ($data as $key => $item) {
            $data[$key]['detail'] = $this->getDetailPekerjaanPesanan($item['id']);
        }
    
        // Response JSON
        $this->response([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
            'count'           => $this->get_count(0, $allowed),
        ], 200);
    }


	function sales_get() {
        $user_id  = $this->input->get('id_user');
        $draw     = (int) $this->get('draw');
        $limit    = (int) $this->get('length');
        $offset   = (int) $this->get('start');
        $keyword  = $this->get('search');
        $order    = $this->get('order');
        $column   = $this->get('columns');
    
        // Total semua data sebelum filter
        $recordsTotal = $this->db->where('jenis_pekerjaan', 'custom-desain')
                                 ->where('id_user', $user_id)
                                 ->count_all_results('pekerjaan');
    
        // Query utama untuk filtering dan pagination
        $this->db->from('pekerjaan')
                 ->join('user', 'user.id = pekerjaan.id_user', 'left')
                 ->where('pekerjaan.jenis_pekerjaan', 'custom-desain')
                 ->where('id_user', $user_id);
    
        // Filter berdasarkan status
        if (!empty($column[5]['search']['value'])) {
            $this->db->where('pekerjaan.status', $column[5]['search']['value']);
        }
    
        // Filter berdasarkan keyword
        if (!empty($keyword['value'])) {
            $this->db->group_start()
                     ->like('pekerjaan.id_pesanan', $keyword['value'])
                     ->group_end();
        }
    
        // Hitung recordsFiltered setelah filter
        $recordsFiltered = $this->db->count_all_results('', false);
    
        // Pagination
        if ($limit != '-1') {
            $this->db->limit($limit, $offset);
        }
    
        // Sorting
        $columns = ['pekerjaan.id_pesanan', 'pekerjaan.created_at', 'pekerjaan.due_date', 'pekerjaan.status', 'user.name'];
        if (!empty($order) && isset($columns[$order[0]['column']])) {
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
        } else {
            $this->db->order_by('pekerjaan.id', 'desc');
        }
    
        // Ambil data setelah filter, limit, dan sorting
        $data = $this->db->select('pekerjaan.id, pekerjaan.due_date, pekerjaan.id_pesanan, pekerjaan.status, pekerjaan.created_at, pekerjaan.jenis_order, user.name')
                         ->get()
                         ->result_array();
    
        // Tambahkan detail pekerjaan
        foreach ($data as $key => $item) {
            $data[$key]['detail'] = $this->getDetailPekerjaanPesanan($item['id']);
        }
    
        // Response JSON
        $this->response([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
            'count'           => $this->get_count($user_id),
        ], 200);
    }


	function save_post()
	{
		$now = date('Y-m-d');
		$user_id = $this->input->post('id_user');
		$durasi = $this->input->post('durasi');
		$jenis_order = $this->input->post('jenis_order');
		$data['id_user'] = $user_id;
		$data['created_at'] = $now;
		$data['jenis_order'] = $jenis_order;
		if ($jenis_order == "repeat-order") {
			$repeat = 6;
			$data['durasi'] = $repeat;
			$data['due_date'] = $this->estimasiWaktu($repeat, null);
		} else if ($jenis_order == "new-order") {
			$new = 14;
			$data['durasi'] = $new;
			$data['due_date'] = $this->estimasiWaktu($new, null);
		} elseif ($jenis_order == "lainnya") {
			$data['durasi'] = 0;
			$data['due_date'] = $this->input->post('tanggal');
		}
		$data['status'] = $this->input->post('status');
		$data['id_pesanan'] = $this->input->post('id_pesanan');
		$data['jenis_pekerjaan'] = 'custom-desain';

		$result = $this->db->insert('pekerjaan', $data);
		$id = $this->db->insert_id();
		if ($result) {
			$id_barang 	= $this->input->post('id_barang[]');
			$qty 		= $this->input->post('qty[]');
			foreach ($id_barang as $key => $value) {
				$detail['id_pekerjaan'] = $id;
				$detail['id_barang'] = $value;
				$detail['qty'] = intval($qty[$key]);
				$this->db->insert('d_pekerjaan',$detail);
			}
			$notif['id_role'] = 1; 
			$notif['jenis_kegiatan'] = 'custom-desain';
			$notif['id_pekerjaan'] = $id;
			$notif['id_user'] = $user_id;
			$notif['status'] = 'waiting';
			$notif['count_barang'] = count($id_barang);
			$notif['created_at']	= date('Y-m-d H:i:s');
			$this->db->insert('notifikasi', $notif);
			$this->response([
				'result' => $result,
				'msg' => 'saved',
			], 200);
		} else {
			$this->response($this->db->error(), 400);
		}
	}

	function edit_get() {
		$id = $this->get('id');
		$result = $this->db->select('pekerjaan.id, pekerjaan.id_user, pekerjaan.created_at, pekerjaan.jenis_order,, pekerjaan.due_date, pekerjaan.id_pesanan, pekerjaan.status, user.name')->join('user', 'user.id=pekerjaan.id_user', 'left')->where('pekerjaan.id', $id)->get('pekerjaan')->row_array();
		$result['detail'] = $this->db->select('d_pekerjaan.id, d_pekerjaan.id_barang, d_pekerjaan.qty,  CONCAT(barang.no_mc," ",barang.item_box) as name')->join('barang', 'barang.id=d_pekerjaan.id_barang', 'left')->where('d_pekerjaan.id_pekerjaan', $result['id'])->get('d_pekerjaan')->result_array();
		$this->response($result);
	}


	function view_get(){
		$id= $this->get('id');
		$result = $this->db->select('pekerjaan.id, pekerjaan.id_user, pekerjaan.id_rule, pekerjaan.created_at, pekerjaan.due_date, pekerjaan.id_pesanan, pekerjaan.durasi, pekerjaan.status, user.name')->join('user', 'user.id=pekerjaan.id_user', 'left')->where('pekerjaan.id', $id)->get('pekerjaan')->row_array();
		$result['note'] = $this->getOneNote($result['id']);
		$result['detail'] = $this->db->where('id_pekerjaan', $result['id'])->get('d_pekerjaan')->result_array();
		foreach ($result['detail'] as $key => $value) {
			$result['detail'][$key]['barang'] = $this->getBarang($value['id_barang']);
			$result['detail'][$key]['desain'] = $this->getDesain($value['id']);
		}
		$this->response($result);
	}

	function delete_post() {
		$id = $this->input->post('id');
		$result = $this->db->where('id', $id)->delete('pekerjaan');
		if ($result) {
			$this->detailPekerjaan($id);
			$this->delNotifikasi($id);
			$this->response([
				'status' 	=> 1,
				'msg' 		=> 'Deleted',
			], 200);
		}else{
			$this->response($this->db->error(), 400);
		}
		
		
	}


	function barang_get() {
		$id = $this->input->get('id');
		$data = $this->db->select('barang.no_mc, barang.id, barang.deskripsi, barang.size, barang.stok, barang.item_box, barang.substance, barang.id_joint, barang.id_box, barang.id_papan_pisau, box.name as name_box, joint.name as name_joint, CONCAT(papan_pisau.no_mp," ", papan_pisau.name_size," ", papan_pisau.spesifikasi_mp) as name_papan')->join('box', 'box.id=barang.id_box', 'left')->join('joint', 'joint.id=barang.id_joint', 'left')->join('papan_pisau', 'papan_pisau.id=barang.id_papan_pisau', 'left')->where('barang.id', $id)->get('barang')->row_array();
		$this->response($data);
	}

	function changeStatus_post() {
		$id_role = $this->_session_role();
		$status  = $this->input->post('status');
		$id      = $this->input->post('id');

		if (!isset(self::$ROLE_CHANGE_STATUS[$status])
			|| !in_array($id_role, self::$ROLE_CHANGE_STATUS[$status])) {
			$this->response(['status' => false, 'msg' => 'Tidak diizinkan'], 403);
			return;
		}

		$result = true;
		$id_rule = $this->input->post('id_rule');
		$id_barang = $this->input->post('id_barang[]');

		if ($status == 'desain' && $id_rule == 1) {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$this->updateStatusPekerjaan($id, $status, $id_rule);
			$act = $pekerjaan['id_pesanan'] . "-" . "Custom Design" . "-".  "Design"; 
			$this->pusher($act, 3);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification($id, 3, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}

		if ($status == 'cutting' && $id_rule == 1) {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$act = $pekerjaan['id_pesanan'] . "-" . "Custom Design" . "-".  "Cutting"; 
			$this->pusher($act, 5);
			$this->pusherActivity();
			$this->pusherProses();
			$this->updateStatusPekerjaan($id, $status, $id_rule);
			$this->saveNotification($id, 5, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}

		if ($status == 'printing' && $id_rule == 1) {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$this->updateStatusPekerjaan($id, $status, $id_rule);
			$act = $pekerjaan['id_pesanan'] . "-" . "Custom Design" . "-".  "Printing"; 
			$this->pusher($act, 4);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification($id, 4, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}
	

		// rules 2
		if ($status == 'desain' && $id_rule == 2) {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$this->updateStatusPekerjaan($id, $status, $id_rule);
			$act = $pekerjaan['id_pesanan'] . "-" . "Custom Design" . "-".  "Design"; 
			$this->pusher($act, 3);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification($id, 3, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}
		if ($status == 'cutting' && $id_rule == 2) {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$this->updateStatusPekerjaan($id, $status, $id_rule);
			$act = $pekerjaan['id_pesanan'] . "-" . "Custom Design" . "-".  "Cutting"; 
			$this->pusher($act, 5);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification($id, 5, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}
		if ($status == 'printing' && $id_rule == 2) {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$this->updateStatusPekerjaan($id, $status, $id_rule);
			$act = $pekerjaan['id_pesanan'] . "-" . "Custom Design" . "-".  "Printing"; 
			$this->pusher($act, 4);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification($id, 4, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}

		if ($status == 'packing') {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$this->updateStatusPekerjaan($id, $status, $id_rule);
			$act = $pekerjaan['id_pesanan'] . "-" . "Custom Design" . "-".  "Packing"; 
			$this->pusher($act, 6);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification($id, 6, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}
		if ($status == 'done') {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$result = $this->updateStatusPekerjaan($id, $status, $id_rule);
			// 3C: catat timestamp selesai produksi
			$this->Spk_model->set_completed_at($id);
			$act = $pekerjaan['id_pesanan'] . "-" . "Custom Design" . "-".  "Selesai";
			$this->pusher($act, 10);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification($id, 10, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$qty_masuk = $this->input->post('qty_masuk[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['id'] = $value;
				$update['qty_masuk'] = $qty_masuk[$key];
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
				$id_barang = $this->getDetailPekerjaan($value);
				$barang =  $this->getOneStokBarang($id_barang);
				$stok = $barang['stok'] + intval($qty_masuk[$key]);
				$this->updateStokBarang($id_barang, $stok);
			}

		}
		if ($status == 'approved-shipping') {
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$qty_keluar = $this->input->post('qty_keluar[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$id_barang = $this->getDetailPekerjaan($value);
				$barang =  $this->getOneStokBarang($id_barang);
				if ($barang['stok'] < intval($qty_keluar[$key])) {
					$result = false;
					$this->response([
						'status' 	=> false,
						'msg' 		=> 'Stok Barang No. Mc: '. $barang['no_mc'] .' Tersisa '  . $barang['stok'],
					], 200);
				}
				if ($barang['stok'] == null && intval($qty_keluar[$key]) > 0) {
					$result = false;
					$this->response([
						'status' 	=> false,
						'msg' 		=> 'Stok Barang No. Mc:'. $barang['no_mc'] .'Kosong',
					], 200);
				}


			}
			if ($result) {
				$this->delNotifikasi($id);
				$pekerjaan = $this->getPekerjaan($id);
				$act = $pekerjaan['id_pesanan'] . "-" . "Custom Design" . "-".  "Approved Logistics"; 
				$this->pusher($act, 7);
				$this->pusherActivity();
				$this->pusherProses();
				$this->saveNotification($id, 7, $pekerjaan['id_user'], $status);
				$this->updateStatusPekerjaan($id, $status, $id_rule);
				$deskripsi = $this->input->post('deskripsi[]');
				foreach ($id_detail_pekerjaan as $key => $value) {
					$update['id'] = $value;
					$update['qty_keluar'] = $qty_keluar[$key];
					$update['deskripsi'] = $deskripsi[$key];
					$this->db->where('id', $value)->update('d_pekerjaan', $update);
					$id_barang = $this->getDetailPekerjaan($value);
					$barang =  $this->getOneStokBarang($id_barang);
					$stok = $barang['stok'] - intval($qty_keluar[$key]);
					$this->updateStokBarang($id_barang, $stok);
				}
			}
		}
		if ($status == 'approved') {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$act = $pekerjaan['id_pesanan'] . "-" . "Custom Design" . "-".  "Approved QC"; 
			$this->pusher($act, 7);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification($id, 7, $pekerjaan['id_user'], $status);
			$this->updateStatusPekerjaan($id, $status, $id_rule);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}
		if ($status == 'approved-customer') {
			$result = true;
			$this->delNotifikasi($id);
			$this->updateStatusPekerjaan($id, $status, $id_rule);
			// 3C: catat timestamp dikirim ke customer
			$this->Spk_model->set_shipped_at($id);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}
		if ($result) {
			$this->response([
				'status' 	=> true,
				'msg' 		=> 'saved',
			], 200);
		}else{
			$this->response($this->db->error(), 400);
		}
	}

	public function select2_get() {
		$table = 'box';
		$q = $this->get('q');
		$page = (int) $this->get('page');

		$recordsFiltered = $this->db->count_all($table);
		if(isset($q) && $q != '') {
			$this->db->like('name', $q);
			$recordsFiltered = $this->db->count_all_results($table);
		}

		$this->db->select('id, name');
		if(isset($q) && $q != '') {
			$this->db->like('name', $q);
		}
		if(isset($page) && $page > 1) {
			$this->db->limit(10, ($page*10)-10);
		}
		$this->db->order_by('name','asc');
		$data = $this->db->get($table)->result();
		$this->response(array(
			'incomplete_results' =>  false,
			'total_count' => $recordsFiltered,
			'items' => $data,
		), 200);
	}

	private function get_count($id_user = '', $allowed = null)
	{
		if(empty($id_user)){
			$this->db->where('jenis_pekerjaan', 'custom-desain');
			if ($allowed !== null) $this->db->where_in('status', $allowed);
			$lines = $this->db->get('pekerjaan')->result_array();
		} else {
			$lines = $this->db->where('jenis_pekerjaan', 'custom-desain')->where('id_user', $id_user)
			->get('pekerjaan')->result_array();
		}
		

		$arr = array();

		foreach ($lines as $key => $item) {
			$arr[$item['status']][$key] = $item;
		}

		ksort($arr, SORT_NUMERIC);

		foreach ($arr as $key => $value) {
			$arr[$key == '' ? 'design' : $key] = count($value);
		}

		return $arr;
	}

	private function delNotifikasi($id) {
		$this->db->where('id_pekerjaan', $id)->delete('notifikasi');
	}
	private function updateStatusPekerjaan($id, $status, $id_rule) {
		$data['status'] = $status;
		$data['id_rule'] = $id_rule;
		if ($status == 'approved-shipping') {
			$data['approve_shipping'] = date('Y-m-d');
		}
		if ($status == 'approved') {
			$data['due_date'] = date('Y-m-d');
		}
		$callback = $this->db->where('id', $id)->update('pekerjaan', $data);
		return $callback;
	}
	private function getRole($id) {
		$data = $this->db->where('id', $id)->get('role')->row_array();
		return $data;
	}
	private function getPekerjaan($id) {
		$data = $this->db->where('id', $id)->get('pekerjaan')->row_array();
		return $data;
	}
	private function getDetailPekerjaan($id) {
		$data = $this->db->where('id', $id)->get('d_pekerjaan')->row_array();
		return $data['id_barang'];
	}

    private function getDetailPekerjaanPesanan($id_pekerjaan) {
        $data = $this->db->select('
                barang.item_box, 
                barang.deskripsi, 
                barang.no_mc, 
                d_pekerjaan.qty, 
                IF(barang.outside IS NOT NULL AND barang.outside != "", CONCAT("'.base_url($this->assets).'", barang.outside), NULL) as outside, 
                IF(barang.inside IS NOT NULL AND barang.inside != "", CONCAT("'.base_url($this->assets).'", barang.inside), NULL) as inside
            ')
            ->join('barang', 'barang.id = d_pekerjaan.id_barang', 'left')
            ->where('d_pekerjaan.id_pekerjaan', $id_pekerjaan)
            ->get('d_pekerjaan')
            ->result_array();
        
        return $data;
    }



	private function saveNotification($id, $id_role, $id_user, $status) {
		$data['id_role'] = $id_role;
		$data['jenis_kegiatan'] = 'custom-desain';
		$data['id_pekerjaan'] = $id;
		$data['id_user'] = $id_user;
		$data['status'] = $status;
		$data['count_barang'] = count($this->countDetailPekerjaan($id));
		$data['created_at']	= date('Y-m-d H:i:s');
		$this->db->insert('notifikasi', $data);
	}

	private function upload_file_config($assets) {
		$config['upload_path'] = $assets;
		$config['allowed_types'] = '*';
		$config['max_size'] = '20480';
		$config['max_width']  = '10576';
		$config['max_height'] = '10576';
		$config['overwrite'] = true;
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
	}

	private function updateStokBarang($id, $stok) {
		$data['stok'] = $stok;
		$this->db->where('id', $id)->update('barang', $data);
	}

	private function countDetailPekerjaan($id) {
		$data = $this->db->where('id_pekerjaan', $id)->get('d_pekerjaan')->result_array();
		return $data;
	}

	private function detailPekerjaan($id) {
		$this->db->where('id_pekerjaan', $id)->delete('d_pekerjaan');
	}

	private function getBarang($id) {
		$data = $this->db->select('barang.no_mc, barang.id, barang.size, barang.stok, barang.item_box, barang.spesifikasi_mc, barang.id_joint, barang.id_box, barang.id_papan_pisau, box.name as name_box, joint.name as name_joint, CONCAT(papan_pisau.no_mp," ", papan_pisau.name_size," ", papan_pisau.spesifikasi_mp) as name_papan')->join('box', 'box.id=barang.id_box', 'left')->join('joint', 'joint.id=barang.id_joint', 'left')->join('papan_pisau', 'papan_pisau.id=barang.id_papan_pisau', 'left')->where('barang.id', $id)->get('barang')->row_array();
		return $data;
	}

	private function getOneStokBarang($id) {
		$data = $this->db->where('id', $id)->get('barang')->row_array();
		return $data;
	}

	private function getBox($id) {
		$data = $this->db->where('id', $id)->get('box')->row_array();
		return $data;
	}

	private function getPapanPisau($id) {
		$data = $this->db->where('id', $id)->get('papan_pisau')->row_array();
		return $data;
	}

	private function getDesain($id) {
		$data = $this->db->where('id_d_pekerjaan', $id)->get('desain')->row_array();
		return $data;
	}

	private function getOneNote($id) {
		$data = $this->db->select('text')->where('id_pekerjaan', $id)->get('note')->row_array();
		return $data;
	}


	private function estimasiWaktu($durasi, $tanggal) {
		$now = $tanggal ? $tanggal : date('Y-m-d');
		$due_date = date('Y-m-d', strtotime($now . '+' . $durasi . ' weekdays'));
		$due_date_obj = new DateTime($due_date);
		if ($due_date_obj->format('N') >= 6) {
			$additional_days = 8 - $due_date_obj->format('N');
			$due_date_obj->modify('+' . $additional_days . ' weekdays');
		}
		return $due_date_obj->format('Y-m-d');
	}


	function pusher($text, $role) {
		$channel =  $role .'-role';
        $event = 'custom';
        $data['message'] = $text;
        $this->pusher_library->trigger($channel, $event, $data);
	}

	function pusherActivity() {
		$channel =  'real-dashboard';
        $event = 'acttivity';
        $data['message'] = "activity";
        $this->pusher_library->trigger($channel, $event, $data);
	}

	function pusherProses() {
		$channel =  'real-dashboard';
        $event = 'proses';
        $data['message'] = "proses";
        $this->pusher_library->trigger($channel, $event, $data);
	}



}
