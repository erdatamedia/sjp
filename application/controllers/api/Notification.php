<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Notification extends RestController
{
	
	function notifPolosan_get() {
		$id_role = $this->input->get('id');
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
		}
		if ($id_role == 1) {
			$status = array('done', 'waiting');
		} elseif($id_role == 10) {
			$status = array('done');
		}else if ($id_role == 7) {
			$status = array('approved', 'approved-shipping');
		}else {
			$status = array('cutting', 'packing');
		}

		$data = $this->db->where('id_role', $id_role)->where('jenis_kegiatan', 'polosan')->where_in('status', $status)->get('notifikasi')->result_array();
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
			$data[$key]['pekerjaan'] = $this->getPekerjaan($value['id_pekerjaan']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}


	function notifDigital_get() {
		$id_role = $this->input->get('id');
		$draw 		= (int) $this->get('draw');
		$limit 		= (int) $this->get('length');
		$offset 	= (int) $this->get('start');
		$keyword 	= $this->get('search');
		$order 		= $this->get('order');

		$recordsTotal = $this->db->count_all('pekerjaan_digital');
		$recordsFiltered = $recordsTotal;
		if(isset($keyword) && $keyword['value'] != '') {
			$this->db->like('name', $keyword['value']);
			$recordsFiltered = $this->db->count_all_results('pekerjaan_digital');
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
		}
		if ($id_role == 9) {
			$status = array('desain', 'printing');
		}elseif ($id_role == 10) {
			$status = array('packing');
		} elseif ($id_role == 7) {
			$status = array('approved-shipping');
		} else {
			$this->response(['draw' => $draw, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => []], 200);
			return;
		}

		$data = $this->db->where('id_role', $id_role)->where('jenis_kegiatan', 'digital-printing')->where_in('status', $status)->get('notifikasi')->result_array();
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
			$data[$key]['pekerjaan'] = $this->getPekerjaanDigital($value['id_pekerjaan']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}

	function countNotif_get() {
		$id_role = $this->input->get('id');
		if ($id_role == 1) {
			$status = array('waiting');
		} elseif ($id_role == 10) {
			$status = array('done', 'packing');
		} else if ($id_role == 7) {
			$status = array('approved', 'approved-shipping');
		} elseif($id_role == 2) {
			$status = array('waiting-marketing', 'approved-shipping');
		} elseif($id_role == 9) {
			$status = array('desain', 'printing');
			$this->db->where('jenis_kegiatan', 'digital-printing');
		} elseif($id_role == 6) {
			$status = array('packing');
		}elseif($id_role == 5) {
			$status = array('cutting');
		}elseif($id_role == 3) {
			$status = array('desain');
		} elseif ($id_role == 4) {
			$status = array('printing');
		} else {
			$res = ['count' => 0];
			return $this->response($res);
		}

		if ($id_role == 9) {
			$data = $this->db->where('id_role', $id_role)->where_in('status', $status)->get('notifikasi')->result_array();
		}else {
			$data = $this->db->where('id_role', $id_role)->where_in('status', $status)->get('notifikasi')->result_array();
		}
		
		$res['count'] = count($data);
		return $this->response($res);
	}

	function notifCustomDesain_get() {
		$id_role = $this->input->get('id');
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
		}
		if ($id_role == 1) {
			$status = array('done');
		} elseif($id_role == 10) {
			$status = array('done');
		} elseif ($id_role == 3) {
			$status = array('desain');
		} else if ($id_role == 7) {
			$status = array('approved', 'approved-shipping');
		} elseif($id_role == 2){
			$status = array('waiting-marketing');
		} else {
			$status = array('cutting', 'packing', 'desain', 'printing');
		}

		$data = $this->db->where('id_role', $id_role)->where('jenis_kegiatan', 'custom-desain')->where_in('status', $status)->get('notifikasi')->result_array();
		foreach ($data as $key => $value) {
			$data[$key]['user'] = $this->getUser($value['id_user']);
			$data[$key]['pekerjaan'] = $this->getPekerjaan($value['id_pekerjaan']);
		}
		$this->response(array(
			'draw' => $draw,
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsFiltered,
			'data' => $data,
		), 200);
	}


	private function getUser($id) {
		$data = $this->db->select('name')->where('id', $id)->get('user')->row_array();
		return $data;
	}

	private function getPekerjaan($id) {
		$data = $this->db->select('id_pesanan, jenis_pekerjaan, status, durasi')->where('id', $id)->get('pekerjaan')->row_array();
		return $data;
	}

	private function getPekerjaanDigital($id) {
		$data = $this->db->select('id_pesanan, status, durasi')->where('id', $id)->get('pekerjaan_digital')->row_array();
		return $data;
	}

}
