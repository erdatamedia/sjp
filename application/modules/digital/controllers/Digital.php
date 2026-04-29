<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Digital extends MY_Controller
{
	public $module = 'digital';
	public $assets 	=  './assets/uploads/digital/';

	function __construct() {
		parent::__construct();
	}

	function index() {
		$module = $this->module;
		$data['module'] = $module;
		$data['title'] 	= 'Digital Printing Work';
		$data['sub_title'] = "Production";
		$data['sub']	= "Digital Printing";
		$page = $module.'/v_index';
		$js = $module.'/js_index';
		echo modules::run('template/loadview', $data, $page, $js);
	}

	function form($id='') {
		
		$module = $this->module;

		$data['pekerjaan'] 		= $this->getPekerjaan($id);
		$data['produk']		= $this->getProduk();
		$x 					= $data['pekerjaan'];
		$data['x'] 			= $x;
		$data['module'] = $module;
		$data['title'] = 'Digital Printing Work Form';
		$page = $module.'/v_form';
		$js = $module.'/js_form';

		echo modules::run('template/loadview', $data, $page, $js);
	}

	function save(){
		$id 	= $this->input->post('id');
		$data = $this->input->post();
		$lines = (isset($data['kt_docs_repeater_basic'])) ? $data['kt_docs_repeater_basic'] : [];
		unset($data['kt_docs_repeater_basic']);
		$jenis_order = $data['jenis_order'];
		$id_pesanan = $data['id_pesanan'];
		if(empty($id_pesanan)) {
		    return redirect(base_url('digital'));
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
		$data['status'] = 'desain';
		$data['created_at'] =  date('Y-m-d');
		if ($id) {
			$result = $this->db->where('id', $id)->update('pekerjaan_digital', $data);
		}else {
			$result = $this->db->insert('pekerjaan_digital', $data);
			$id = $this->db->insert_id();
			$this->pusherProses();
		}
		if ($result) {
			foreach ($lines as $key => $line) {
				$id_detail = $line['id_detail'] ? $line['id_detail'] : null;
				$detail['id_pekerjaan'] = $id;
				$detail['id_produk'] = $line['id_produk'];
				$detail['finishing'] = $line['finishing'];
				$detail['qty'] = intval($line['qty']);
				$detail['deskripsi'] = $line['deskripsi'];
				$this->saveDetail($detail, $id_detail);
			}
			$this->notifikasi($id);
			$act = $id_pesanan . "-" . "Digital Printing" . "-".  "Design"; 
			$this->pusher($act, 9);
			$this->saveNotification(9, $id, $data['id_user'], 'desain');
			redirect(base_url('digital'));
		} 
	}


	function view($id) {
		$module = $this->module;
		$pekerjaan 			= $this->getPekerjaan($id);
		if (!$pekerjaan) {
			redirect(base_url($module));
		}
		
		$data['pekerjaan'] 		= $pekerjaan;
		$data['produk']		= $this->getProduk();
		$data['note']		= $this->getOneNote($id);
		$x 					= $data['pekerjaan'];
		$data['x'] 			= $x;
		$data['statusChange'] = $this->statusChange($pekerjaan['status']);
		$data['statusRibbon'] = $this->statusRibbon($pekerjaan['status']);
		$data['bg']			= $this->bgRibbon($pekerjaan['status']);
		$data['kalimat']	= $this->kalimat($pekerjaan['status'], $pekerjaan['id_pesanan']);
		$data['status']		= $this->status();
		if ($x) {
			$data['prev'] 	= $this->prevRow($x['id'], 'id', 'pekerjaan_digital', null,  TRUE);
			$data['next'] 	= $this->nextRow($x['id'], 'id', 'pekerjaan_digital', null, TRUE);
			$data['i'] 		= $this->indexRow($x['id'], 'id', 'pekerjaan_digital', null, TRUE);
			$data['j'] 		= $this->numRows('pekerjaan_digital', null);
		}
		$data['module'] = $module;
		$data['title'] = 'Design Work View';
		$page = $module.'/v_view';
		$js = $module.'/js_view';
		echo modules::run('template/loadview', $data, $page, $js);
	}

	function upload($id_produk, $id_pekerjaan) {
		$module = $this->module;
		$data['pekerjaan']	= $this->getPekerjaan($id_pekerjaan);
		$x 					= $this->getProdukOne($id_produk);
		$data['x'] 			= $x;
		$data['module'] = $module;
		$data['title'] = 'Upload ' . $x['no_mc_label'] . " " . $x['nama_dgp'];
		$page = $module.'/v_upload';
		$js = $module.'/js_upload';
		echo modules::run('template/loadview', $data, $page, $js);

	}

	function saveGambar() {
		
		$id = $this->input->post('id');
		$id_pekerjaan = $this->input->post('id_pekerjaan');
		$old = $this->getProdukOne($id);

		$this->upload_file_configs($this->assets);
		if (!empty($_FILES['image']['name'])) {
			if ($this->upload->do_upload('image')) {
				$uploaded = $this->upload->data();
				$data['image'] = $uploaded['file_name'];
				if ($old && !empty($old['image'])) {
					$old_file = $this->assets . $old['image'];
					if (is_file($old_file) && file_exists($old_file)) {
						unlink($old_file);
					}
				}
			} else {
				redirect(base_url('digital/view/') . $id_pekerjaan);
			}
		}

		if (!empty($data['image'])) {
			$this->db->where('id', $id)->update('barang_dgp', $data);
		}

		redirect(base_url('digital/view/') . $id_pekerjaan);

		
	}

	private function getOneNote($id) {
		$data = $this->db->select('text')->where('id_pekerjaan', $id)->get('note')->row_array();
		return $data;
	}

	private function getProduk() {
		$data = $this->db->select(' barang_dgp.no_mc_label, barang_dgp.id, barang_dgp.nama_dgp, material.name as material, barang_dgp.size')->join('material', 'material.id = barang_dgp.id_material', 'left')->get('barang_dgp')->result_array();
		return $data;
	}

	private function getOneDigital($id) {
		$data = $this->db->where('id', $id)->get('d_pekerjaan_digital')->row_array();
		return $data;
	}

	private function getPekerjaan($id) {
		$result = $this->db->select('pekerjaan_digital.id, pekerjaan_digital.id_user, pekerjaan_digital.created_at, pekerjaan_digital.due_date, pekerjaan_digital.id_pesanan, pekerjaan_digital.tgl_pengiriman, pekerjaan_digital.jenis_order, pekerjaan_digital.durasi, pekerjaan_digital.jenis_order, pekerjaan_digital.status, pekerjaan_digital.completed_at, pekerjaan_digital.shipped_at, user.name')->join('user', 'user.id=pekerjaan_digital.id_user', 'left')->where('pekerjaan_digital.id', $id)->get('pekerjaan_digital')->row_array();
		if ($result) {
			$result['detail'] = $this->db->where('id_pekerjaan', $result['id'])->get('d_pekerjaan_digital')->result_array();
			foreach ($result['detail'] as $key => $value) {
				$result['detail'][$key]['barang'] = $this->getProdukOne($value['id_produk']);
			}
		}
		return $result;
		
	}

	private function getDetailPekerjaan($id) {
		$result = $this->db->select('d_pekerjaan_digital.id as id, pekerjaan_digital.id as id_pekerjaan, pekerjaan_digital.status, pekerjaan_digital.id_pesanan, d_pekerjaan_digital.id')->join('pekerjaan_digital', 'pekerjaan_digital.id=d_pekerjaan_digital.id_pekerjaan', 'left')->where('d_pekerjaan_digital.id', $id)->get('d_pekerjaan_digital')->row_array();
		return $result;
	}

	private function getProdukOne($id) {
		$data = $this->db->select('barang_dgp.no_mc_label, barang_dgp.image, barang_dgp.id, barang_dgp.nama_dgp, material.name, barang_dgp.size')->join('material', 'material.id = barang_dgp.id_material', 'left')->where('barang_dgp.id', $id)->get('barang_dgp')->row_array();
		return $data;
	}

	private function saveDetail($line, $id) {
		if ($id) {
			$this->db->where('id', $id)
			->update('d_pekerjaan_digital', $line);
		} else {
			$this->db->insert('d_pekerjaan_digital', $line);
		}
	}

	private function saveNotification($id_role, $id, $id_user, $status) {
		$data['id_role'] = $id_role;
		$data['jenis_kegiatan'] = 'digital-printing';
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
		$data = $this->db->where('id_pekerjaan', $id)->get('d_pekerjaan_digital')->result_array();
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

	private function statusChange($status) {
		if ($status == 'desain') {
			return 'printing';
		}
		if ($status == 'printing') {
			return  'packing';
		}

		if ($status == 'packing') {
			return 'approved-shipping';
		}

		if ($status == 'approved-shipping') {
			return 'approved-customer';
		}
	}

	private function statusRibbon($status) {
		if ($status == 'desain') {
			return 'Design';
		}
		if ($status == 'printing') {
			return 'Printing';
		}
		if ($status == 'packing') {
			return 'Packing';
		}
		if ($status == 'confirm') {
			return 'Confirmation';
		}
		if ($status == 'approved-shipping') {
			return 'Approved Shipped';
		}
		if ($status == 'approved-customer') {
			return 'Order Shipped';
		}
	}

	private function bgRibbon($status) {
		if ($status == 'desain') {
			return 'red';
		}
		if ($status == 'printing') {
			return '#0b1abd';
		}
		if ($status == 'packing') {
			return '#ff1493';
		}

		if ($status == 'confirm') {
			return '#3461eb';
		}
		if ($status == 'approved-shipping') {
			return '#402f1d';
		}
		if ($status == 'approved-customer') {
			return '#228f15';
		}
	}

	private function kalimat($status, $id_pesanan) {
		if ($status == 'desain') {
			return 'Harap pastikan bahwa semua pekerjaan telah selesai dengan benar sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan Digital Printing ' . $id_pesanan;

		}
		if ($status == 'printing') {
			return 'Harap pastikan bahwa semua pekerjaan telah selesai dengan benar sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan Digital Printing ' . $id_pesanan;

		}

		if ($status == 'confirm') {
			return 'Harap pastikan bahwa semua pekerjaan telah selesai dengan benar sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan Digital Printing ' . $id_pesanan;
		}
		if ($status == 'packing') {
			return 'Harap pastikan bahwa semua pekerjaan telah selesai dengan benar sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan Digital Printing ' . $id_pesanan;
		}
		if ($status == 'approved-shipping') {
			return 'Harap pastikan bahwa semua pekerjaan telah selesai dengan benar sebelum menekan tombol <span class="badge badge-info">Ok</span> untuk pekerjaan Digital Printing ' . $id_pesanan;
		}
	}

	private function status() {
		$session 				= $this->session->userdata(COOKIE_USER);
		$user 		= $this->getUser($session['id']);
		if ($user) {
			if ($user['id_role'] == 9) {
				return array('desain', 'printing');
			}else if ($user['id_role'] == 10) {
				return array('packing');
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
