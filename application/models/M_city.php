<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_city extends CI_Model {

	public function select($where = ''){
		if ($where != ''){
			$this->db->where($where);
		}

					$this->db->from('tbl_city');
					$this->db->join('tbl_provinsi', 'tbl_provinsi.province_id = tbl_city.province_id');
		$response = $this->db->get();
		return $response;
	}

	public function save($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'city_id'		=> $data['city_id'],
			'city_name'		=> $data['city_name'],
			'postal_code'	=> $data['postal_code'],
			'province_id'	=> $data['province_id'],
			'type'			=> $data['type'],
		);

		$this->db->insert('tbl_city', $arr);
		$response = $this->db->insert_id();
		return $response;
	}

	public function update($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'city_name'		=> $data['city_name'],
			'postal_code'	=> $data['postal_code'],
			'province_id'	=> $data['province_id'],
			'type'			=> $data['type'],
		);

		$response = $this->db->insert('tbl_city', $arr, ['city_id' => $data['city_id']]);
		return $response;
	}

	public function delete($arr){
		return $this->db->delete('tbl_city', $arr);
	}

}

/* End of file M_admin.php */
/* Location: ./application/models/M_admin.php */