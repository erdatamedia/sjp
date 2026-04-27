<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Polosan extends MY_Controller
{
	public $module = 'polosan';
	public $assets 	=  './assets/uploads/barang/';

	function __construct() {
		parent::__construct();
		$this->load->library('pusher_library');
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Pekerjaan Polosan';
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}

	/**
	 * AJAX endpoint: cek kapasitas produksi di tanggal tertentu.
	 * GET /polosan/cek_kapasitas?tgl=YYYY-MM-DD
	 */
	function cek_kapasitas() {
		if (!$this->input->is_ajax_request()) {
			show_404();
			return;
		}
		$tgl = $this->input->get('tgl');
		if (!$tgl || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
			echo json_encode(['error' => 'Tanggal tidak valid']);
			return;
		}
		$today     = date('Y-m-d');
		$min_date  = date('Y-m-d', strtotime('+2 days'));
		if ($tgl <= $today) {
			echo json_encode([
				'error'   => 'Tanggal tidak boleh hari ini atau sebelumnya.',
				'min_date'=> $min_date,
			]);
			return;
		}
		echo json_encode($this->Spk_model->get_kapasitas_info($tgl));
	}


	function form($id='') {
		
		$module = $this->module;

		$data['pekerjaan'] 		= $this->getPekerjaan($id);
		$data['produk']		= $this->getProduct();
		$x 					= $data['pekerjaan'];
		$data['x'] 			= $x;
		$data['module'] = $module;
		$data['title'] = 'Plain Work Form';
		$page = $module.'/v_form';
		$js = $module.'/js_form';

		echo modules::run('template/loadview', $data, $page, $js);
	}

	function view($id) {
		$module = $this->module;
		$pekerjaan 				= $this->getPekerjaan($id);
		if (!$pekerjaan) {
			redirect(base_url($module));
		}
		
		$data['pekerjaan'] 		= $pekerjaan;
		$data['note']		= $this->getOneNote($id);
		$x 					= $data['pekerjaan'];
		$data['x'] 			= $x;
		$data['statusChange'] = $this->statusChange($pekerjaan['status']);
		$data['statusRibbon'] = $this->statusRibbon($pekerjaan['status']);
		$data['bg']			= $this->bgRibbon($pekerjaan['status']);
		$data['kalimat']	= $this->kalimat($pekerjaan['status'], $pekerjaan['id_pesanan']);
		$data['status']		= $this->status();
		if ($x) {
			$data['prev'] 	= $this->prevRow($x['id'], 'id', 'pekerjaan', 'polosan', TRUE);
			$data['next'] 	= $this->nextRow($x['id'], 'id', 'pekerjaan', 'polosan', TRUE);
			$data['i'] 		= $this->indexRow($x['id'], 'id', 'pekerjaan', 'polosan', TRUE);
			$data['j'] 		= $this->numRows('pekerjaan', 'polosan');
		}
		$data['module'] = $module;
		$data['title'] = 'Plain Work View';
		$page = $module.'/v_view';
		$js = $module.'/js_view';

		
		echo modules::run('template/loadview', $data, $page, $js);
	}


	function save(){
		$id          = $this->input->post('id');
		$data        = $this->input->post();
		$lines       = isset($data['kt_docs_repeater_basic']) ? $data['kt_docs_repeater_basic'] : [];
		$jenis_order = $data['jenis_order'];
		$id_pesanan  = $data['id_pesanan'];
		unset($data['kt_docs_repeater_basic']);

		if (empty($id_pesanan)) {
			return redirect(base_url('polosan'));
		}

		// ── Validasi Delivery Date: minimal H+1 ──
		if (!$id) {
			$tgl = $this->input->post('tgl_pengiriman');
			if ($tgl && $tgl <= date('Y-m-d')) {
				$this->session->set_flashdata('error',
					'Delivery Date minimal ' . date('d/m/Y', strtotime('+1 day')) . '.');
				redirect(current_url());
				return;
			}
		}

		$pekerjaan_lama = $this->getPekerjaan($id);
		$pekerjaan = $pekerjaan_lama;
		// Due date dihitung otomatis — tidak lagi dari input form
		unset($data['due_date']);
		$tgl_pengiriman = $this->input->post('tgl_pengiriman');

		if ($jenis_order == 'repeat-order') {
			$data['durasi']   = 6;
			$data['due_date'] = $this->estimasiWaktu(6, $pekerjaan ? $pekerjaan['created_at'] : null);
		}
		if ($jenis_order == 'new-order') {
			$data['durasi']   = 14;
			$data['due_date'] = $this->estimasiWaktu(14, $pekerjaan ? $pekerjaan['created_at'] : null);
		}
		if ($jenis_order == 'lainnya') {
			// Tanpa field due_date di form, gunakan tgl_pengiriman sebagai acuan
			$data['durasi']   = $this->hitung_selisih_tanggal(date('Y-m-d'), $tgl_pengiriman);
			$data['due_date'] = $tgl_pengiriman;
		}

		$data['tgl_pengiriman']  = $this->input->post('tgl_pengiriman');
		$data['status']          = 'desain';
		$data['jenis_pekerjaan'] = 'polosan';
		$data['created_at']      = date('Y-m-d');

		if ($id) {
			$result = $this->db->where('id', $id)->update('pekerjaan', $data);
		} else {
			$result = $this->db->insert('pekerjaan', $data);
			$id     = $this->db->insert_id();
			$this->pusherActivity();
			$this->pusherProses();
		}

		if ($result) {
			foreach ($lines as $line) {
				$id_detail              = $line['id_detail'] ?: null;
				$detail['id_pekerjaan'] = $id;
				$detail['id_barang']    = $line['id_barang'];
				$detail['qty']          = intval($line['qty']);
				$detail['deskripsi']    = $line['deskripsi'];
				$this->saveDetail($detail, $id_detail);
			}
			$this->notifikasi($id);
			$this->saveNotification(3, $id, $data['id_user'], 'desain');
			$this->pusher($id_pesanan . '-Polosan-Baru', 1);
			redirect(base_url('polosan'));
		}
	}

	function upload($id, $id_pekerjaan) {
		$module = $this->module;
		$data['produk']    = $this->getOneProduk($id);
		$data['pekerjaan'] = $this->getPekerjaan($id_pekerjaan);
		$x = $data['produk'];
		$data['x'] = $x;
		$data['blank_product'] = base_url('assets/media/svg/files/blank-image.svg');
		$data['module'] = $module;
		$data['title']  = 'Plain Work Upload';
		$page = $module . '/v_upload';
		$js   = $module . '/js_upload';
		echo modules::run('template/loadview', $data, $page, $js);
	}

	function saveGambar() {
		$id           = $this->input->post('id');
		$id_pekerjaan = $this->input->post('id_pekerjaan');
		$old          = $this->getOneProduk($id);

		$this->upload_file_configs($this->assets);
		$data = [];

		if (!empty($_FILES['outside']['name'])) {
			if ($this->upload->do_upload('outside')) {
				$uploaded = $this->upload->data();
				$data['outside'] = $uploaded['file_name'];
				if ($old && !empty($old['outside'])) {
					$f = $this->assets . $old['outside'];
					if (is_file($f)) unlink($f);
				}
			} else {
				redirect(base_url('polosan/view/') . $id_pekerjaan);
				return;
			}
		}
		if (!empty($_FILES['inside']['name'])) {
			if ($this->upload->do_upload('inside')) {
				$uploaded = $this->upload->data();
				$data['inside'] = $uploaded['file_name'];
				if ($old && !empty($old['inside'])) {
					$f = $this->assets . $old['inside'];
					if (is_file($f)) unlink($f);
				}
			} else {
				redirect(base_url('polosan/view/') . $id_pekerjaan);
				return;
			}
		}

		if (!empty($data)) {
			$this->db->where('id', $id)->update('barang', $data);
		}
		redirect(base_url('polosan/view/') . $id_pekerjaan);
	}

	/**
	 * Trigger notifikasi ke Kabag Gudang (id_role=10) untuk SPK stiker yang selesai.
	 * Dipanggil saat status SPK stiker berubah ke 'done'.
	 */
	private function triggerStikerKeGudang($spk_id, $id_user) {
		$spk = $this->getPekerjaan($spk_id);
		if (!$spk || $spk['design_type'] !== 'stiker') {
			return;
		}
		$this->saveNotification(10, $spk_id, $id_user, 'done');
		$this->pusher($spk['id_pesanan'] . '-Stiker-SelesaiKeProduksi', 10);
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

	private function getDetailPekerjaan($id) {
		$data = $this->db->where('id', $id)->get('d_pekerjaan')->row_array();
		return $data['id_barang'];
	}

	private function getOneStokBarang($id) {
		$data = $this->db->where('id', $id)->get('barang')->row_array();
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

	private function countDetailPekerjaan($id) {
		$data = $this->db->where('id_pekerjaan', $id)->get('d_pekerjaan')->result_array();
		return $data;
	}

	private function saveDetail($line, $id) {
		if ($id) {
			$this->db->where('id', $id)
			->update('d_pekerjaan', $line);
		} else {
			$this->db->insert('d_pekerjaan', $line);
		}
	}


	private function getProduct() {
		$data = $this->db->order_by('created_at', 'DESC')->get('barang')->result_array();
		return $data;
	}


	private function getOneProduk($id) {
		return $this->db->where('id', $id)->get('barang')->row_array();
	}

	private function getPekerjaan($id) {
		$result = $this->db->select('pekerjaan.id, pekerjaan.id_user, pekerjaan.created_at, pekerjaan.due_date, pekerjaan.tgl_pengiriman, pekerjaan.id_pesanan, pekerjaan.jenis_order, pekerjaan.durasi, pekerjaan.status, pekerjaan.design_type, pekerjaan.design_attachment, user.name, user.image')->join('user', 'user.id=pekerjaan.id_user', 'left')->where('pekerjaan.id', $id)->get('pekerjaan')->row_array();
		if ($result) {
			$result['detail'] = $this->db->where('id_pekerjaan', $result['id'])->get('d_pekerjaan')->result_array();
			foreach ($result['detail'] as $key => $value) {
				$result['detail'][$key]['barang'] = $this->getBarang($value['id_barang']);
			}
		}
		return $result;
		
	}

	private function getBarang($id) {
		$data = $this->db->select('barang.no_mc, barang.id, barang.deskripsi, barang.size, barang.stok, barang.item_box, barang.substance, barang.inside, barang.outside, barang.id_joint, barang.id_box, barang.id_papan_pisau, box.name as name_box, joint.name as name_joint, CONCAT(papan_pisau.no_mp," ", papan_pisau.name_size," ", papan_pisau.spesifikasi_mp) as name_papan')->join('box', 'box.id=barang.id_box', 'left')->join('joint', 'joint.id=barang.id_joint', 'left')->join('papan_pisau', 'papan_pisau.id=barang.id_papan_pisau', 'left')->where('barang.id', $id)->get('barang')->row_array();
		return $data;
	}

	private function getOneNote($id) {
		$data = $this->db->select('text')->where('id_pekerjaan', $id)->get('note')->row_array();
		return $data;
	}

	private function notifikasi($id) {
		$this->db->where('id_pekerjaan', $id)->delete('notifikasi');
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

	private function hitung_selisih_tanggal($tanggal_awal, $tanggal_akhir) {
		$start = strtotime($tanggal_awal);
		$end = strtotime($tanggal_akhir);

		$count = 0;
		while ($start < $end) {
			if (date("N", $start) < 6) {
				$count++;
			}
			$start = strtotime("+1 day", $start);
		}

		return $count;
	}

	private function statusChange($status) {
		if ($status == 'waiting') {
			return 'desain';
		}
		if ($status == 'desain') {
			return 'cutting';
		}
		if ($status == 'cutting') {
			return 'packing';
		}
		if ($status == 'packing') {
			return 'done';
		}
		if ($status == 'done') {
			return 'approved';
		}
		if ($status == 'approved') {
			return 'approved-shipping';
		}
		if ($status == 'approved-shipping') {
			return 'approved-customer';
		}
	}

	private function statusRibbon($status) {
		if ($status == 'waiting') {
			return 'Menunggu Material/Alat';
		}
		if ($status == 'desain') {
			return 'Desain';
		}
		if ($status == 'cutting') {
			return 'Cutting';
		}
		if ($status == 'packing') {
			return 'Finishing';
		}
		if ($status == 'done') {
			return 'Selesai';
		}
		if ($status == 'approved') {
			return 'Disetujui Kualitas';
		}
		if ($status == 'approved-shipping') {
			return 'Disetujui Logistik';
		}
		if ($status == 'approved-customer') {
			return 'Dikirim';
		}
	}

	private function bgRibbon($status) {
		if ($status == 'waiting') {
			return 'orange';
		}
		if ($status == 'desain') {
			return 'red';
		}
		if ($status == 'cutting') {
			return 'black';
		}
		if ($status == 'packing') {
			return '#ff1493';
		}
		if ($status == 'done') {
			return 'blue';
		}
		if ($status == 'approved') {
			return 'yellow';
		}
		if ($status == 'approved-shipping') {
			return '#402f1d';
		}
		if ($status == 'approved-customer') {
			return '#228f15';
		}
	}

	private function kalimat($status, $id_pesanan) {
		if ($status == 'waiting') {
			return 'Harap pastikan bahwa Material/Tool sudah ada sebelum menekan tombol <span class="badge badge-info">Ok</span>  untuk pekerjaan ' . $id_pesanan;
		}
		if ($status == 'desain') {
			return 'Harap pastikan bahwa dokumen desain sudah diupload sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan ' . $id_pesanan;
		}
		if ($status == 'cutting') {
			return 'Harap pastikan bahwa semua pekerjaan telah selesai dengan benar sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan cutting ' . $id_pesanan;

		}
		if ($status == 'packing') {
			return 'Harap pastikan bahwa Qty Masuk ' . $id_pesanan . ' sudah benar sebelum menekan tombol <span class="badge badge-info">Ok</span>';
		}
		if ($status == 'done') {
			return 'Harap pastikan bahwa semua pekerjaan telah selesai dengan benar sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan ' . $id_pesanan;
		}
		if ($status == 'approved') {
			return 'Harap pastikan bahwa Qty Keluar ' . $id_pesanan . ' sudah benar sebelum menekan tombol <span class="badge badge-info">Ok</span>';
		}
		if ($status == 'approved-shipping') {
			return 'Harap pastikan bahwa Ordering ID ' . $id_pesanan . ' sudah terkirim sebelum menekan tombol <span class="badge badge-info">Ok</span>';
		}
	}

	private function status() {
		$session 				= $this->session->userdata(COOKIE_USER);
		$user 		= $this->getUser($session['id']);
		if ($user) {
			if ($user['id_role'] == 7) {
				return 'approved';
			} elseif ($user['id_role'] == 6) {
				return 'packing';
			} else if ($user['id_role'] == 5) {
				return 'cutting';
			}else if ($user['id_role'] == 4) {
				return 'printing';
			}else if ($user['id_role'] == 3) {
				return 'desain';
			}else if ($user['id_role'] == 1) {
				return 'waiting';
			} else if ($user['id_role'] == 10) {
				return 'done';
			}  else {
				return '';
			}
		} else {
			return '';
		}
		
	}


	private function getUser($id) {
		$res = $this->db->select('user.name, user.id, user.email, role.name as role, role.id as id_role')->join('role', 'user.id_role=role.id')->where('user.id',$id)->get('user')->row_array();
		unset($res['password']);
		return $res ? $res : '';
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