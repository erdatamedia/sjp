<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Polosan extends RestController
{
	function __construct() {
		parent::__construct();
		$this->checkUserLog();
		$this->load->library('pusher_library');
	}

	// ── Status yang boleh DILIHAT per role ────────────────────────────────
	// null  = tidak dibatasi (admin/kabag)
	// array = hanya status dalam list ini
	private static $ROLE_VIEW_STATUS = [
		1  => ['waiting', 'desain', 'cutting', 'packing', 'done'],
		3  => ['desain', 'cutting'],
		5  => ['cutting', 'packing'],
		6  => ['packing', 'done'],
		7  => ['approved', 'approved-shipping', 'approved-customer'],
		10 => ['done', 'approved', 'approved-shipping', 'approved-customer'],
	];

	// ── Status yang boleh DI-SET per role ─────────────────────────────────
	private static $ROLE_CHANGE_STATUS = [
		'desain'            => [3, 11, 8],
		'cutting'           => [1, 3, 8],
		'packing'           => [5, 8],
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

        // Role 2 (Marketing) selalu pakai endpoint sales — filter per id_user dari sesi
        if ($id_role === 2) {
            $this->sales_get();
            return;
        }

        $draw    = (int) $this->get('draw');
        $limit   = (int) $this->get('length');
        $offset  = (int) $this->get('start');
        $keyword = $this->get('search');
        $order   = $this->get('order');
        $column  = $this->get('columns');

        $allowed = isset(self::$ROLE_VIEW_STATUS[$id_role])
            ? self::$ROLE_VIEW_STATUS[$id_role]
            : null;

        // ── Count total ───────────────────────────────────────────────────
        $this->db->where('jenis_pekerjaan', 'polosan');
        if ($allowed !== null) {
            $this->db->where_in('status', $allowed);
        }
        $total = $this->db->count_all_results('pekerjaan');
        $recordsFiltered = $total;

        if (!empty($column[5]['search']['value'])) {
            $this->db->where('jenis_pekerjaan', 'polosan');
            if ($allowed !== null) {
                $this->db->where_in('status', $allowed);
            }
            $this->db->where('status', $column[5]['search']['value']);
            $recordsFiltered = $this->db->count_all_results('pekerjaan');
        }

        // ── Query data ────────────────────────────────────────────────────
        $columns = ['pekerjaan.id_pesanan', 'pekerjaan.created_at', 'pekerjaan.due_date', 'pekerjaan.status', 'user.name'];

        $this->db->select('pekerjaan.id, pekerjaan.due_date, pekerjaan.id_pesanan, pekerjaan.status, pekerjaan.created_at, pekerjaan.jenis_order, user.name');
        $this->db->join('user', 'user.id = pekerjaan.id_user', 'left');
        $this->db->where('pekerjaan.jenis_pekerjaan', 'polosan');
        if ($allowed !== null) {
            $this->db->where_in('pekerjaan.status', $allowed);
        }

        if (!empty($column[5]['search']['value'])) {
            $this->db->where('pekerjaan.status', $column[5]['search']['value']);
        }

        if (!empty($keyword['value'])) {
            $this->db->like('pekerjaan.id_pesanan', $keyword['value']);
        }

        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        if (!empty($order) && isset($columns[$order[0]['column']])) {
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
        } else {
            $this->db->order_by('pekerjaan.id', 'desc');
        }

        $data = $this->db->get('pekerjaan')->result_array();
        foreach ($data as &$item) {
            $item['detail'] = $this->getDetailPekerjaanPesanan($item['id']);
        }

        $this->response([
            'draw'            => $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
            'count'           => $this->get_count(0, $allowed),
        ], 200);
    }

    function sales_get() {
        // id_user selalu dari sesi — tidak bisa ditamper via query string
        $user_id = $this->_session_user_id();
        if (!$user_id) {
            $this->response(['status' => false, 'msg' => 'Unauthorized'], 401);
            return;
        }

        $draw    = (int) $this->get('draw');
        $limit   = (int) $this->get('length');
        $offset  = (int) $this->get('start');
        $keyword = $this->get('search');
        $order   = $this->get('order');
        $column  = $this->get('columns');

        // ── Count total ───────────────────────────────────────────────────
        $this->db->where('jenis_pekerjaan', 'polosan');
        $this->db->where('id_user', $user_id);
        $total = $this->db->count_all_results('pekerjaan');
        $recordsFiltered = $total;

        if (!empty($column[5]['search']['value'])) {
            $this->db->where('jenis_pekerjaan', 'polosan');
            $this->db->where('status', $column[5]['search']['value']);
            $this->db->where('id_user', $user_id);
            $recordsFiltered = $this->db->count_all_results('pekerjaan');
        }

        // ── Query data ────────────────────────────────────────────────────
        $columns = ['pekerjaan.id_pesanan', 'pekerjaan.created_at', 'pekerjaan.due_date', 'pekerjaan.status', 'user.name'];

        $this->db->select('pekerjaan.id, pekerjaan.due_date, pekerjaan.id_pesanan, pekerjaan.status, pekerjaan.created_at, pekerjaan.jenis_order, user.name');
        $this->db->join('user', 'user.id = pekerjaan.id_user', 'left');
        $this->db->where('pekerjaan.jenis_pekerjaan', 'polosan');
        $this->db->where('pekerjaan.id_user', $user_id);

        if (!empty($column[5]['search']['value'])) {
            $this->db->where('pekerjaan.status', $column[5]['search']['value']);
        }

        if (!empty($keyword['value'])) {
            $this->db->like('pekerjaan.id_pesanan', $keyword['value']);
        }

        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        if (!empty($order) && isset($columns[$order[0]['column']])) {
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
        } else {
            $this->db->order_by('pekerjaan.id', 'desc');
        }

        $data = $this->db->get('pekerjaan')->result_array();
        foreach ($data as &$item) {
            $item['detail'] = $this->getDetailPekerjaanPesanan($item['id']);
        }

        $this->response([
            'draw'            => $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
            'count'           => $this->get_count($user_id),
        ], 200);
    }



	function view_get(){

		$id= $this->get('id');
		$result = $this->db->select('pekerjaan.id, pekerjaan.id_user, pekerjaan.created_at, pekerjaan.due_date, pekerjaan.id_pesanan, pekerjaan.durasi, pekerjaan.status, user.name')->join('user', 'user.id=pekerjaan.id_user', 'left')->where('pekerjaan.id', $id)->get('pekerjaan')->row_array();
		$result['note'] = $this->getOneNote($result['id']);
		$result['detail'] = $this->db->where('id_pekerjaan', $result['id'])->get('d_pekerjaan')->result_array();
		foreach ($result['detail'] as $key => $value) {
			$result['detail'][$key]['barang'] = $this->getBarang($value['id_barang']);
		}
		$this->response($result);
	}

	function barang_get() {
		$id = $this->input->get('id');
		$data = $this->db->select('barang.no_mc, barang.id, barang.deskripsi, barang.size, barang.stok, barang.item_box, barang.substance, barang.id_joint, barang.id_box, barang.id_papan_pisau, box.name as name_box, joint.name as name_joint, CONCAT(papan_pisau.no_mp," ", papan_pisau.name_size," ", papan_pisau.spesifikasi_mp) as name_papan')->join('box', 'box.id=barang.id_box', 'left')->join('joint', 'joint.id=barang.id_joint', 'left')->join('papan_pisau', 'papan_pisau.id=barang.id_papan_pisau', 'left')->where('barang.id', $id)->get('barang')->row_array();
		$this->response($data);
	}

	function delete_post() {
		$id_role = $this->_session_role();
		if (!in_array($id_role, [2, 8])) {
			$this->response(['status' => false, 'msg' => 'Tidak diizinkan'], 403);
			return;
		}

		$id = $this->input->post('id');
		$result = $this->db->where('id', $id)->delete('pekerjaan');
		if ($result) {
			$this->detailPekerjaan($id);
			$this->notifikasi($id);
			$this->response([
				'status' 	=> 1,
				'msg' 		=> 'Deleted',
			], 200);
		}else{
			$this->response($this->db->error(), 400);
		}
	}

	function changeStatus_post() {
		$id_role = $this->_session_role();
		$status  = $this->input->post('status');
		$id      = $this->input->post('id');

		// Validasi role vs status yang diminta
		if (!isset(self::$ROLE_CHANGE_STATUS[$status])
			|| !in_array($id_role, self::$ROLE_CHANGE_STATUS[$status])) {
			$this->response(['status' => false, 'msg' => 'Tidak diizinkan'], 403);
			return;
		}

		$result = true;
		if ($status == 'cutting') {
			$result = true;
			$this->delNotifikasi($id);
			$this->updateStatusPekerjaan($id, $status);
			$pekerjaan = $this->getPekerjaan($id);
			$act = $pekerjaan['id_pesanan'] . "-" . "Polosan" . "-".  "Cutting";
			$this->pusher($act, 5);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification(5, $id, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail') ?? [];
			$deskripsi           = $this->input->post('deskripsi') ?? [];
			if (empty($id_detail_pekerjaan)) {
				$this->response(['status' => false, 'msg' => 'Detail pekerjaan tidak ditemukan'], 400);
				return;
			}
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}

		}
		if ($status == 'packing') {
			$result = true;
			$this->delNotifikasi($id);
			$this->updateStatusPekerjaan($id, $status);
			$pekerjaan = $this->getPekerjaan($id);
			$act = $pekerjaan['id_pesanan'] . "-" . "Polosan" . "-".  "Packing";
			$this->pusher($act, 6);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification(6, $id, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail') ?? [];
			$deskripsi           = $this->input->post('deskripsi') ?? [];
			if (empty($id_detail_pekerjaan)) {
				$this->response(['status' => false, 'msg' => 'Detail pekerjaan tidak ditemukan'], 400);
				return;
			}
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}
		if ($status == 'done') {
			$result = true;
			$this->delNotifikasi($id);
			$result = $this->updateStatusPekerjaan($id, $status);
			// 3C: catat timestamp selesai produksi
			if (!isset($this->Spk_model)) $this->load->model('Spk_model');
			$this->Spk_model->set_completed_at($id);
			$pekerjaan = $this->getPekerjaan($id);
			$act = $pekerjaan['id_pesanan'] . "-" . "Polosan" . "-".  "Selesai";
			$this->pusher($act, 1);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification(1, $id, $pekerjaan['id_user'], $status);
			// 2D: Stiker selesai → otomatis notifikasi Kabag Gudang (id_role=10)
			if (!empty($pekerjaan['design_type']) && $pekerjaan['design_type'] === 'stiker') {
				$this->saveNotification(10, $id, $pekerjaan['id_user'], $status);
				$this->pusher($pekerjaan['id_pesanan'] . '-Stiker-KeGudang', 10);
			}
			$id_detail_pekerjaan = $this->input->post('id_detail') ?? [];
			$qty_masuk           = $this->input->post('qty_masuk') ?? [];
			$deskripsi           = $this->input->post('deskripsi') ?? [];
			if (empty($id_detail_pekerjaan)) {
				$this->response(['status' => false, 'msg' => 'Detail pekerjaan tidak ditemukan'], 400);
				return;
			}
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
		if ($status == 'approved') {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$act = $pekerjaan['id_pesanan'] . "-" . "Polosan" . "-".  "Approved QC";
			$this->pusher($act, 7);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification(7, $id, $pekerjaan['id_user'], $status);
			$this->updateStatusPekerjaan($id, $status);
			$id_detail_pekerjaan = $this->input->post('id_detail') ?? [];
			$deskripsi           = $this->input->post('deskripsi') ?? [];
			if (empty($id_detail_pekerjaan)) {
				$this->response(['status' => false, 'msg' => 'Detail pekerjaan tidak ditemukan'], 400);
				return;
			}
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}
		if ($status == 'approved-shipping') {
			$id_detail_pekerjaan = $this->input->post('id_detail') ?? [];
			$qty_keluar          = $this->input->post('qty_keluar') ?? [];
			$deskripsi           = $this->input->post('deskripsi') ?? [];
			if (empty($id_detail_pekerjaan)) {
				$this->response(['status' => false, 'msg' => 'Detail pekerjaan tidak ditemukan'], 400);
				return;
			}
			foreach ($id_detail_pekerjaan as $key => $value) {
				$id_barang = $this->getDetailPekerjaan($value);
				$barang =  $this->getOneStokBarang($id_barang);
				if ($barang['stok'] < intval($qty_keluar[$key])) {
					$this->response([
						'status' 	=> false,
						'msg' 		=> 'Stok Barang No. Mc: '. $barang['no_mc'] .' Tersisa '  . $barang['stok'],
					], 200);
					return;
				}
				if ($barang['stok'] == 0 && intval($qty_keluar[$key]) > 0) {
					$this->response([
						'status' 	=> false,
						'msg' 		=> 'Stok Barang No. Mc:'. $barang['no_mc'] .' Kosong',
					], 200);
					return;
				}
			}
			$this->delNotifikasi($id);
			$this->updateStatusPekerjaan($id, $status);
			$pekerjaan = $this->getPekerjaan($id);
			$act = $pekerjaan['id_pesanan'] . "-" . "Polosan" . "-".  "Approved Logistics";
			$this->pusher($act, 7);
			$this->pusherActivity();
			$this->pusherProses();
			$this->saveNotification(7, $id, $pekerjaan['id_user'], $status);
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
		if ($status == 'approved-customer') {
			$result = true;
			$this->delNotifikasi($id);
			$this->updateStatusPekerjaan($id, $status);
			// 3C: catat timestamp dikirim ke customer
			if (!isset($this->Spk_model)) $this->load->model('Spk_model');
			$this->Spk_model->set_shipped_at($id);
			$id_detail_pekerjaan = $this->input->post('id_detail') ?? [];
			$deskripsi           = $this->input->post('deskripsi') ?? [];
			if (empty($id_detail_pekerjaan)) {
				$this->response(['status' => false, 'msg' => 'Detail pekerjaan tidak ditemukan'], 400);
				return;
			}
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan', $update);
			}
		}
		if ($result) {
			$this->response([
				'status' 	=> true,
				'msg' 		=> 'Saved',
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

	private function get_count($id_user = 0, $allowed = null)
	{
		$this->db->where('jenis_pekerjaan', 'polosan');
		if ($id_user) {
			$this->db->where('id_user', $id_user);
		}
		if ($allowed !== null) {
			$this->db->where_in('status', $allowed);
		}
		$lines = $this->db->get('pekerjaan')->result_array();

		$arr = [];
		foreach ($lines as $key => $item) {
			$arr[$item['status']][$key] = $item;
		}

		ksort($arr, SORT_NUMERIC);

		foreach ($arr as $key => $value) {
			$arr[$key == '' ? 'design' : $key] = count($value);
		}

		return $arr;
	}

	private function getDetailPekerjaanPesanan($id_pekerjaan) {
		$data = $this->db->select('barang.item_box, barang.deskripsi, barang.no_mc, d_pekerjaan.qty')->join('barang', 'barang.id=d_pekerjaan.id_barang', 'left')->where('d_pekerjaan.id_pekerjaan', $id_pekerjaan)->get('d_pekerjaan')->result_array();
		return $data;
	}

	private function updateStokBarang($id, $stok) {
		$data['stok'] = $stok;
		$this->db->where('id', $id)->update('barang', $data);
	}

	private function delNotifikasi($id) {
		$this->db->where('id_pekerjaan', $id)->delete('notifikasi');
	}

	private function updateStatusPekerjaan($id, $status) {
		$data['status'] = $status;
		if ($status == 'approved') {
			$data['due_date'] = date('Y-m-d');
		}
		if ($status == 'approved-shipping') {
			$data['approve_shipping'] = date('Y-m-d');
		}
		$callback = $this->db->where('id', $id)->update('pekerjaan', $data);
		return $callback;
	}

	private function getUser($id) {
		$data = $this->db->where('id', $id)->get('user')->row_array();
		return $data;
	}

	private function getRole($id) {
		$data = $this->db->where('id', $id)->get('role')->row_array();
		return $data;
	}

	private function getPekerjaan($id) {
		$data = $this->db->select('*, design_type, design_attachment')
		                 ->where('id', $id)->get('pekerjaan')->row_array();
		return $data;
	}

	private function getDetailPekerjaan($id) {
		$data = $this->db->where('id', $id)->get('d_pekerjaan')->row_array();
		return $data['id_barang'];
	}

	private function saveNotification($id_role, $id, $id_user, $status) {
		$data['id_role'] = $id_role;
		$data['jenis_kegiatan'] = 'polosan';
		$data['id_pekerjaan'] = $id;
		$data['id_user'] = $id_user;
		$data['status'] = $status;
		$data['count_barang'] = count($this->countDetailPekerjaan($id));
		$data['created_at']	= date('Y-m-d H:i:s');
		$this->db->insert('notifikasi', $data);
	}

	private function detailPekerjaan($id) {
		$this->db->where('id_pekerjaan', $id)->delete('d_pekerjaan');
	}

	private function notifikasi($id) {
		$this->db->where('id_pekerjaan', $id)->delete('notifikasi');
	}

	private function countDetailPekerjaan($id) {
		$data = $this->db->where('id_pekerjaan', $id)->get('d_pekerjaan')->result_array();
		return $data;
	}

	private function getBarang($id) {
		$data = $this->db->select('barang.no_mc, barang.id, barang.size, barang.stok, barang.item_box, barang.substance, barang.id_joint, barang.id_box, barang.id_papan_pisau, box.name as name_box, joint.name as name_joint, CONCAT(papan_pisau.no_mp," ", papan_pisau.name_size," ", papan_pisau.spesifikasi_mp) as name_papan')->join('box', 'box.id=barang.id_box', 'left')->join('joint', 'joint.id=barang.id_joint')->join('papan_pisau', 'papan_pisau.id=barang.id_papan_pisau', 'left')->where('barang.id', $id)->get('barang')->row_array();
		return $data;
	}

	private function getOneStokBarang($id) {
		$data = $this->db->where('id', $id)->get('barang')->row_array();
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
        $event = 'polosan';
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
