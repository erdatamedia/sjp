<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';



class Digital extends RestController
{
	public $assets 	=  './assets/uploads/digital/';

	function __construct() {
		parent::__construct();
		$this->checkUserLog();
		$this->load->library('pusher_library');
	}

	private static $ROLE_VIEW_STATUS = [
		1  => ['waiting', 'cutting', 'printing', 'packing', 'done'],
		4  => ['desain', 'printing', 'packing'],
		9  => ['desain', 'printing', 'packing'],
		6  => ['packing', 'done'],
		7  => ['approved-shipping', 'approved-customer'],
		10 => ['packing', 'done', 'approved', 'approved-shipping', 'approved-customer'],
		3  => ['desain'],
		11 => ['desain'],
	];

	private static $ROLE_CHANGE_STATUS = [
		'desain'            => [9, 8],
		'printing'          => [9, 8],
		'packing'           => [6, 9, 10, 8],
		'done'              => [6, 10, 8],
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

        $draw    = (int) $this->get('draw');
        $limit   = (int) $this->get('length');
        $offset  = (int) $this->get('start');
        $keyword = $this->get('search');
        $order   = $this->get('order');
        $column  = $this->get('columns');
    
        $this->db->from('pekerjaan_digital');
        if ($allowed !== null) $this->db->where_in('status', $allowed);
        $recordsTotal = $this->db->count_all_results();
        $recordsFiltered = $recordsTotal;

        if (!empty($column[5]['search']['value'])) {
            $this->db->where('pekerjaan_digital.status', $column[5]['search']['value']);
            if ($allowed !== null) $this->db->where_in('pekerjaan_digital.status', $allowed);
            $recordsFiltered = $this->db->count_all_results('pekerjaan_digital');
        }

        $columns = ['pekerjaan_digital.id_pesanan', 'pekerjaan_digital.created_at', 'pekerjaan_digital.due_date', 'pekerjaan_digital.status', 'user.name'];

        $this->db->select('pekerjaan_digital.id, pekerjaan_digital.due_date, pekerjaan_digital.id_pesanan, pekerjaan_digital.status, pekerjaan_digital.created_at, pekerjaan_digital.jenis_order, user.name');
        $this->db->join('user', 'user.id = pekerjaan_digital.id_user', 'left');
        if ($allowed !== null) $this->db->where_in('pekerjaan_digital.status', $allowed);

        if (!empty($column[5]['search']['value'])) {
            $this->db->where('pekerjaan_digital.status', $column[5]['search']['value']);
        }
        
        if (!empty($keyword['value'])) {
            $this->db->like('pekerjaan_digital.id_pesanan', $keyword['value']);
        }
        
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        
        if (!empty($order) && isset($columns[$order[0]['column']])) {
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
        } else {
            $this->db->order_by('pekerjaan_digital.id', 'desc');
        }
        
        $data = $this->db->get('pekerjaan_digital')->result_array();
        foreach ($data as &$item) {
            if (is_null($item['name'])) $item['name'] = '-';
            $item['detail'] = $this->getDetailPekerjaanPesanan($item['id']);
        }

        $this->response([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'count' => $this->get_count(0, $allowed),
        ], 200);
    }
    
    function sales_get() {
        $user_id = (int) $this->input->get('id_user');
        $draw    = (int) $this->get('draw');
        $limit   = (int) $this->get('length');
        $offset  = (int) $this->get('start');
        $keyword = $this->get('search');
        $order   = $this->get('order');
        $column  = $this->get('columns');
    
        $this->db->from('pekerjaan_digital');
        $this->db->where('id_user', $user_id);
        $recordsTotal = $this->db->count_all_results();
        $recordsFiltered = $recordsTotal;
    
        if (!empty($column[5]['search']['value'])) {
            $this->db->where('pekerjaan_digital.status', $column[5]['search']['value']);
            $recordsFiltered = $this->db->count_all_results('pekerjaan_digital');
        }
    
        $columns = ['pekerjaan_digital.id_pesanan', 'pekerjaan_digital.created_at', 'pekerjaan_digital.due_date', 'pekerjaan_digital.status', 'user.name'];
        
        $this->db->select('pekerjaan_digital.id, pekerjaan_digital.due_date, pekerjaan_digital.id_pesanan, pekerjaan_digital.status, pekerjaan_digital.created_at, pekerjaan_digital.jenis_order, user.name');
        $this->db->join('user', 'user.id = pekerjaan_digital.id_user', 'left');
        $this->db->where('pekerjaan_digital.id_user', $user_id);
        
        if (!empty($column[5]['search']['value'])) {
            $this->db->where('pekerjaan_digital.status', $column[5]['search']['value']);
        }
        
        if (!empty($keyword['value'])) {
            $this->db->like('pekerjaan_digital.id_pesanan', $keyword['value']);
        }
        
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        
        if (!empty($order) && isset($columns[$order[0]['column']])) {
            $this->db->order_by($columns[$order[0]['column']], $order[0]['dir']);
        } else {
            $this->db->order_by('pekerjaan_digital.id', 'desc');
        }
        
        $data = $this->db->get('pekerjaan_digital')->result_array();
        foreach ($data as &$item) {
            if (is_null($item['name'])) $item['name'] = '-';
            $item['detail'] = $this->getDetailPekerjaanPesanan($item['id']);
        }

        $this->response([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'count' => $this->get_count($user_id),
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


	function delete_post() {
		$id = $this->input->post('id');
		$result = $this->db->where('id', $id)->delete('pekerjaan_digital');
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

		if ($status == 'printing') {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$this->updateStatusPekerjaan($id, $status);
			$act = $pekerjaan['id_pesanan'] . "-" . "Digital printing" . "-".  "Printing"; 
			$this->pusher($act, 9);
			$this->pusherProses();
			$this->saveNotification($id, 9, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan_digital', $update);
			}
		}

		if ($status == 'packing') {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$this->updateStatusPekerjaan($id, $status);
			$act = $pekerjaan['id_pesanan'] . "-" . "Digital printing" . "-".  "Packing";
			$this->pusher($act, 10);
			$this->pusherProses();
			$this->saveNotification($id, 10, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan_digital', $update);
			}
		}

		if ($status == 'done') {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$this->updateStatusPekerjaan($id, $status);
			if (!isset($this->Spk_model)) $this->load->model('Spk_model');
			$this->Spk_model->set_completed_at($id);
			$act = $pekerjaan['id_pesanan'] . "-" . "Digital printing" . "-". "Selesai";
			$this->pusher($act, 10);
			$this->pusherProses();
			$this->saveNotification($id, 10, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]') ?? [];
			$deskripsi           = $this->input->post('deskripsi[]') ?? [];
			$pcs                 = $this->input->post('qty_object[]') ?? [];
			$reject_pcs          = $this->input->post('reject_object[]') ?? [];
			if (!empty($id_detail_pekerjaan)) {
				foreach ($id_detail_pekerjaan as $key => $value) {
					$detailPekerjaan = $this->getDetailPekerjaan($value);
					$update['deskripsi'] = $deskripsi[$key] ?? '';
					if (!empty($pcs[$key])) {
						$update['qty_total']     = $pcs[$key] * $detailPekerjaan['qty'];
						$update['qty_object']    = $pcs[$key];
						$update['reject_object'] = $reject_pcs[$key] ?? 0;
					}
					$this->db->where('id', $value)->update('d_pekerjaan_digital', $update);
				}
			}
		}

		if ($status == 'approved-shipping') {
			$result = true;
			$this->delNotifikasi($id);
			$pekerjaan = $this->getPekerjaan($id);
			$this->updateStatusPekerjaan($id, $status);
			$act = $pekerjaan['id_pesanan'] . "-" . "Digital printing" . "-".  "Shipping"; 
			$this->pusher($act, 7);
			$this->pusherProses();
			$this->saveNotification($id, 7, $pekerjaan['id_user'], $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			$pcs = $this->input->post('qty_object[]');
			$reject_pcs = $this->input->post('reject_object[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$detailPekerjaan = $this->getDetailPekerjaan($value);
				$update['qty_total'] = $pcs[$key] * $detailPekerjaan['qty'];
				$update['deskripsi'] = $deskripsi[$key];
				$update['qty_object'] = $pcs[$key];
				$update['reject_object'] = $reject_pcs[$key] ? $reject_pcs[$key] : 0;
				$this->db->where('id', $value)->update('d_pekerjaan_digital', $update);
			}
		}

		if ($status == 'approved-customer') {
			$result = true;
			$this->delNotifikasi($id);
			$this->updateStatusPekerjaan($id, $status);
			$id_detail_pekerjaan = $this->input->post('id_detail[]');
			$deskripsi = $this->input->post('deskripsi[]');
			foreach ($id_detail_pekerjaan as $key => $value) {
				$update['deskripsi'] = $deskripsi[$key];
				$this->db->where('id', $value)->update('d_pekerjaan_digital', $update);
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

	function info_get() {
		$id = intval($this->input->get('id'));
		$data = $this->db->select('barang_dgp.no_mc_label, barang_dgp.image, barang_dgp.id, barang_dgp.nama_dgp, material.name, barang_dgp.size')->join('material', 'material.id = barang_dgp.id_material', 'left')->where('barang_dgp.id', $id)->get('barang_dgp')->row_array();
		$this->response($data, 200);
	}


	private function get_count($id_user = '', $allowed = null)
	{
		if(empty($id_user)){
			if ($allowed !== null) $this->db->where_in('status', $allowed);
			$lines = $this->db->get('pekerjaan_digital')->result_array();
		} else {
			$lines = $this->db->where('id_user', $id_user)
			->get('pekerjaan_digital')->result_array();
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
		$this->db->where('id_pekerjaan', $id)->where('jenis_kegiatan', 'digital-printing')->delete('notifikasi');
	}
	private function updateStatusPekerjaan($id, $status) {
		$data['status'] = $status;
		if ($status == 'approved-shipping') {
			$data['due_date'] = date('Y-m-d');
		}
		$callback = $this->db->where('id', $id)->update('pekerjaan_digital', $data);
		return $callback;
	}
	private function getRole($id) {
		$data = $this->db->where('id', $id)->get('role')->row_array();
		return $data;
	}
	private function getPekerjaan($id) {
		$data = $this->db->where('id', $id)->get('pekerjaan_digital')->row_array();
		return $data;
	}

	private function getDetailPekerjaan($id) {
		$data = $this->db->where('id', $id)->get('d_pekerjaan_digital')->row_array();
		return $data;
	}

	private function getDetailPekerjaanPesanan($id_pekerjaan) {
		$data = $this->db->select('
			barang_dgp.no_mc_label, 
			barang_dgp.nama_dgp, 
			barang_dgp.size,
			barang_dgp.id_material,
			IF(barang_dgp.image IS NOT NULL AND barang_dgp.image != "", CONCAT("'.base_url($this->assets).'", barang_dgp.image), NULL) as image, 
			d_pekerjaan_digital.qty, 
			d_pekerjaan_digital.finishing'
		)->join('barang_dgp', 'barang_dgp.id=d_pekerjaan_digital.id_produk', 'left')->where('d_pekerjaan_digital.id_pekerjaan', $id_pekerjaan)->get('d_pekerjaan_digital')->result_array();
		foreach ($data as $key => $item) {
			$data[$key]['material'] = $this->getOneMaterial($item['id_material']);
		}
		return $data;
	}


	private function saveNotification($id, $id_role, $id_user, $status) {
		$data['id_role'] = $id_role;
		$data['jenis_kegiatan'] = 'digital-printing';
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


	private function countDetailPekerjaan($id) {
		$data = $this->db->where('id_pekerjaan', $id)->get('d_pekerjaan_digital')->result_array();
		return $data;
	}

	private function detailPekerjaan($id) {
		$this->db->where('id_pekerjaan', $id)->delete('d_pekerjaan_digital');
	}

	private function getOneMaterial($id) {
		if (!$id) return null;
		$data = $this->db->select('name')->where('id', $id)->get('material')->row_array();
		return $data ?: null;
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
        $event = 'digital';
        $data['message'] = $text;
        $this->pusher_library->trigger($channel, $event, $data);
	}

	function pusherProses() {
		$channel =  'real-dashboard';
        $event = 'proses';
        $data['message'] = "proses";
        $this->pusher_library->trigger($channel, $event, $data);
	}


}
