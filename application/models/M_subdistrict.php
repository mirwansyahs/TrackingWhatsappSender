<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_subdistrict extends CI_Model {

	public function select($where = ''){
		if ($where != ''){
			$this->db->where($where);
		}
					$this->db->from('tbl_subdistrict');
					$this->db->join('tbl_city', 'tbl_city.city_id = tbl_subdistrict.city_id');
					$this->db->join('tbl_provinsi', 'tbl_provinsi.province_id = tbl_city.province_id');
		$response = $this->db->get();
		return $response;
	}

	public function save($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'subdistrict_id'	=> $data['subdistrict_id'],
			'subdistrict_name'	=> $data['subdistrict_name'],
			'city_id'			=> $data['city_id'],
		);

		$this->db->insert('tbl_subdistrict', $arr);
		$response = $this->db->insert_id();
		return $response;
	}

	public function update($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'subdistrict_name'	=> $data['subdistrict_name'],
			'city_id'			=> $data['city_id'],
		);

		$response = $this->db->insert('tbl_subdistrict', $arr, ['subdistrict_id' => $data['subdistrict_id']]);
		return $response;
	}

	public function delete($arr){
		return $this->db->delete('tbl_subdistrict', $arr);
	}

}

/* End of file M_admin.php */
/* Location: ./application/models/M_admin.php */