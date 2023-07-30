<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_provinsi extends CI_Model {

	public function select($where = ''){
		if ($where != ''){
			$this->db->where($where);
		}

					$this->db->from('tbl_provinsi');
		$response = $this->db->get();
		return $response;
	}

	public function save($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'province_id'		=> $data['province_id'],
			'province'		=> $data['province'],
		);

		$this->db->insert('tbl_provinsi', $arr);
		$response = $this->db->insert_id();
		return $response;
	}

	public function update($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'province'		=> $data['province'],
		);

		$response = $this->db->insert('tbl_provinsi', $arr, ['province_id' => $data['province_id']]);
		return $response;
	}

	public function delete($arr){
		return $this->db->delete('tbl_provinsi', $arr);
	}

}

/* End of file M_admin.php */
/* Location: ./application/models/M_admin.php */