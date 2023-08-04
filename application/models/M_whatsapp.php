<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_whatsapp extends CI_Model {

	public function select($where = ''){
		if ($where != ''){
			$this->db->where($where);
		}

					$this->db->from('tbl_whatsapp');
		$response = $this->db->get();
		return $response;
	}

	public function save($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'whatsapp_vendor'		=> $data['whatsapp_vendor'],
			'whatsapp_label'		=> $data['whatsapp_label'],
			'whatsapp_authorized'		=> $data['whatsapp_authorized'],
		);

		$this->db->insert('tbl_whatsapp', $arr);
		$response = $this->db->insert_id();
		return $response;
	}

	public function update($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'whatsapp_vendor'		=> $data['whatsapp_vendor'],
			'whatsapp_label'		=> $data['whatsapp_label'],
			'whatsapp_authorized'		=> $data['whatsapp_authorized'],
		);

		$response = $this->db->update('tbl_whatsapp', $arr, ['whatsapp_id' => $data['whatsapp_id']]);
		return $response;
	}

	public function delete($arr){
		return $this->db->delete('tbl_whatsapp', $arr);
	}

}

/* End of file M_admin.php */
/* Location: ./application/models/M_admin.php */