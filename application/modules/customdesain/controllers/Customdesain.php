<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customdesain extends MY_Controller
{
	public $module = 'customdesain';
	public $assets 	=  './assets/uploads/barang/';

	function __construct() {
		parent::__construct();
		$this->load->library('pusher_library');
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Design Work';
		$data['sub_title'] = "Production";
		$data['sub']	= "Custom design";
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}

	function form($id='') {
		
		$module = $this->module;

		$data['pekerjaan'] 		= $this->getPekerjaan($id);
		$data['produk']		= $this->getProduct();
		$x 					= $data['pekerjaan'];
		$data['x'] 			= $x;
		$data['module'] = $module;
		$data['title'] = 'Design Work Form';
		$page = $module.'/v_form';
		$js = $module.'/js_form';

		echo modules::run('template/loadview', $data, $page, $js);
	}

	function save(){
		$id 	= $this->input->post('id');
		$data = $this->input->post();
		$lines = (isset($data['kt_docs_repeater_basic'])) ? $data['kt_docs_repeater_basic'] : [];
		unset($data['kt_docs_repeater_basic']);

		$data['design_type'] = $this->input->post('design_type') ?: null;
		$jenis_order = $data['jenis_order'];
		$id_pesanan = $data['id_pesanan'];
		if(empty($id_pesanan)) {
		    return redirect(base_url('customdesain'));
		}
		$pekerjaan = $this->getPekerjaan($id);
		if ($jenis_order != 'lainnya') {
			unset($data['due_date']);
		}
		if ($jenis_order == 'repeat-order') {
			$repeat = 6;
			$data['durasi'] = $repeat;
			$data['due_date'] = $this->estimasiWaktu($repeat, $pekerjaan? $pekerjaan['created_at'] : null);
		} else if ($jenis_order == 'new-order') {
			$new = 14;
			$data['durasi'] = $new;
			$data['due_date'] = $this->estimasiWaktu($new,  $pekerjaan? $pekerjaan['created_at'] : null);
		} else if ($jenis_order == 'lainnya') {
			$data['durasi'] = $this->hitung_selisih_tanggal(date('Y-m-d'), $data['due_date']);
			$data['due_date'] = $this->input->post('due_date');
		}
		$data['tgl_pengiriman'] = $this->input->post('tgl_pengiriman');
		$data['status'] = 'waiting';
		$data['jenis_pekerjaan'] = 'custom-desain';
		$data['created_at'] =  date('Y-m-d');
		if ($id) {
			$result = $this->db->where('id', $id)->update('pekerjaan', $data);
		}else {
			$result = $this->db->insert('pekerjaan', $data);
			$id = $this->db->insert_id();
			$this->pusherActivity();
			$this->pusherProses();
		}
		if ($result) {
			foreach ($lines as $key => $line) {
				$id_detail = $line['id_detail'] ? $line['id_detail'] : null;
				$detail['id_pekerjaan'] = $id;
				$detail['id_barang'] = $line['id_barang'];
				$detail['qty'] = intval($line['qty']);
				$detail['deskripsi'] = $line['deskripsi'];
				$this->saveDetail($detail, $id_detail);
			}
			$this->notifikasi($id);
			$this->saveNotification(1, $id, $data['id_user'], 'waiting');
			$act = $id_pesanan . "-" . "Polosan" . "-".  "Waiting Material/Tools"; 
			$this->pusher($act, 1);
			redirect(base_url('customdesain'));
		} 
	}


	function view($id) {
		$module = $this->module;
		$pekerjaan 			= $this->getPekerjaan($id);
		if (!$pekerjaan) {
			redirect(base_url($module));
		}
		
		$data['pekerjaan'] 		= $pekerjaan;
		$data['produk']		= $this->getProduct();
		$data['note']		= $this->getOneNote($id);
		$x 					= $data['pekerjaan'];
		$data['x'] 			= $x;
		$data['statusChange'] = $this->statusChange($pekerjaan['status'], $pekerjaan['id_rule']);
		$data['statusRibbon'] = $this->statusRibbon($pekerjaan['status']);
		$data['bg']			= $this->bgRibbon($pekerjaan['status']);
		$data['kalimat']	= $this->kalimat($pekerjaan['status'], $pekerjaan['id_pesanan']);
		$data['status']		= $this->status();
		if ($x) {
			$data['prev'] 	= $this->prevRow($x['id'], 'id', 'pekerjaan', 'custom-desain', TRUE);
			$data['next'] 	= $this->nextRow($x['id'], 'id', 'pekerjaan', 'custom-desain', TRUE);
			$data['i'] 		= $this->indexRow($x['id'], 'id', 'pekerjaan', 'custom-desain', TRUE);
			$data['j'] 		= $this->numRows('pekerjaan', 'custom-desain');
		}
		$data['module'] = $module;
		$data['title'] = 'Design Work View';
		$page = $module.'/v_view';
		$js = $module.'/js_view';
		echo modules::run('template/loadview', $data, $page, $js);
	}

	function upload($id, $id_pekerjaan) {
		$module = $this->module;
		$data['produk']		= $this->getOneProduk($id);
		$data['pekerjaan']	= $this->getPekerjaan($id_pekerjaan);
		$x 					= $data['produk'];
		$data['x'] 			= $x;
		$data['module'] = $module;
		$data['title'] = 'Upload '. $x['no_mc'] . " " . $x['item_box'];
		$page = $module.'/v_upload';
		$js = $module.'/js_upload';
		echo modules::run('template/loadview', $data, $page, $js);
	}

	function saveGambar() {
		
		$id = $this->input->post('id');
		$id_pekerjaan = $this->input->post('id_pekerjaan');
		$old = $this->getOneProduk($id);

		$this->upload_file_configs($this->assets);
		if (!empty($_FILES['outside']['name'])) {
			if ($this->upload->do_upload('outside')) {
				$uploaded = $this->upload->data();
				$data['outside'] = $uploaded['file_name'];
				if ($old && !empty($old['outside'])) {
					$old_file = $this->assets . $old['outside'];
					if (is_file($old_file) && file_exists($old_file)) {
						unlink($old_file);
					}
				}
			} else {
				redirect(base_url('customdesain/view/') . $id_pekerjaan);
			}
		}
		if (!empty($_FILES['inside']['name'])) {
			if ($this->upload->do_upload('inside')) {
				$uploaded = $this->upload->data();
				$data['inside'] = $uploaded['file_name'];
				if ($old && !empty($old['inside'])) {
					$old_file = $this->assets . $old['inside'];
					if (is_file($old_file) && file_exists($old_file)) {
						unlink($old_file);
					}
				}
			} else {
				redirect(base_url('customdesain/view/') . $id_pekerjaan);
			}
		}

		if (!empty($_FILES['color']['name'])) {
			if ($this->upload->do_upload('color')) {
				$uploaded = $this->upload->data();
				$data['color'] = $uploaded['file_name'];
				if ($old && !empty($old['color'])) {
					$old_file = $this->assets . $old['color'];
					if (is_file($old_file) && file_exists($old_file)) {
						unlink($old_file);
					}
				}
			} else {
				redirect(base_url('customdesain/view/') . $id_pekerjaan);
			}
		}

		if (!empty($data['outside']) || !empty($data['inside']) || !empty($data['color'])) {
			$this->db->where('id', $id)->update('barang', $data);
		}

		redirect(base_url('customdesain/view/') . $id_pekerjaan);

		
	}

	private function getOneNote($id) {
		$data = $this->db->select('text')->where('id_pekerjaan', $id)->get('note')->row_array();
		return $data;
	}

	private function getProduct() {
		$data = $this->db->order_by('created_at', 'DESC')->get('barang')->result_array();
		return $data;
	}

	private function getOneProduk($id) {
		$data = $this->db->where('id', $id)->get('barang')->row_array();
		return $data;
	}

	private function getPekerjaan($id) {
		$result = $this->db->select('pekerjaan.id, pekerjaan.id_user, pekerjaan.created_at, pekerjaan.due_date, pekerjaan.tgl_pengiriman, pekerjaan.id_pesanan, pekerjaan.id_rule, pekerjaan.jenis_order, pekerjaan.durasi, pekerjaan.jenis_order, pekerjaan.status, pekerjaan.completed_at, pekerjaan.shipped_at, user.name')->join('user', 'user.id=pekerjaan.id_user', 'left')->where('pekerjaan.id', $id)->get('pekerjaan')->row_array();
		if ($result) {
			$result['detail'] = $this->db->where('id_pekerjaan', $result['id'])->get('d_pekerjaan')->result_array();
			foreach ($result['detail'] as $key => $value) {
				$result['detail'][$key]['barang'] = $this->getBarang($value['id_barang']);
			}
		}
		return $result;
		
	}

	private function getBarang($id) {
		$data = $this->db->select('barang.no_mc, barang.color, barang.id, barang.outside, barang.inside, barang.deskripsi, barang.size, barang.stok, barang.item_box, barang.substance, barang.id_joint, barang.id_box, barang.id_papan_pisau, box.name as name_box, joint.name as name_joint, CONCAT(papan_pisau.no_mp," ", papan_pisau.name_size," ", papan_pisau.spesifikasi_mp) as name_papan')->join('box', 'box.id=barang.id_box', 'left')->join('joint', 'joint.id=barang.id_joint', 'left')->join('papan_pisau', 'papan_pisau.id=barang.id_papan_pisau', 'left')->where('barang.id', $id)->get('barang')->row_array();
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

	private function saveNotification($id_role, $id, $id_user, $status) {
		$data['id_role'] = $id_role;
		$data['jenis_kegiatan'] = 'custom-desain';
		$data['id_pekerjaan'] = $id;
		$data['id_user'] = $id_user;
		$data['status'] = $status;
		$data['count_barang'] = count($this->countDetailPekerjaan($id));
		$data['created_at']	= date('Y-m-d H:i:s');
		$this->db->insert('notifikasi', $data);
	}

	private function notifikasi($id) {
		$this->db->where('id_pekerjaan', $id)->delete('notifikasi');
	}

	private function countDetailPekerjaan($id) {
		$data = $this->db->where('id_pekerjaan', $id)->get('d_pekerjaan')->result_array();
		return $data;
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

	private function statusChange($status, $id_rule) {
		if ($status == 'desain' && $id_rule == 1) {
			return 'cutting';
		}
		if ($status == 'cutting' && $id_rule == 1) {
			return  'printing';
		}
		if ($status == 'printing' && $id_rule == 1) {
			return 'packing';
		}

		if ($status == 'cutting' && $id_rule == 2) {
			return 'desain';
		}
		if ($status == 'desain' && $id_rule == 2) {
			return 'printing';
		}
		if ($status == 'printing' && $id_rule == 2) {
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
			return 'Waiting Material/Tool';
		}
		if ($status == 'desain') {
			return 'Design';
		}
		if ($status == 'cutting') {
			return 'Cutting';
		}
		if ($status == 'printing') {
			return 'Printing';
		}
		if ($status == 'packing') {
			return 'Packing';
		}
		if ($status == 'done') {
			return 'Completed';
		}
		if ($status == 'approved') {
			return 'Approved QC';
		}
		if ($status == 'approved-shipping') {
			return 'Approved Logistics';
		}
		if ($status == 'approved-customer') {
			return 'Order Shipped';
		}
	}

	private function bgRibbon($status) {
		if ($status == 'waiting') {
			return 'orange';
		}
		if ($status == 'cutting') {
			return 'black';
		}
		if ($status == 'desain') {
			return 'red';
		}
		if ($status == 'printing') {
			return '#0b1abd';
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
		if ($status == 'cutting') {
			return 'Harap pastikan bahwa semua pekerjaan telah selesai dengan benar sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan cutting ' . $id_pesanan;

		}
		if ($status == 'desain') {
			return 'Harap pastikan bahwa semua pekerjaan telah selesai dengan benar sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan desain ' . $id_pesanan;

		}
		if ($status == 'printing') {
			return 'Harap pastikan bahwa semua pekerjaan telah selesai dengan benar sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan printing ' . $id_pesanan;

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
			}else if ($user['id_role'] == 10) {
				return 'done';
			} else {
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
