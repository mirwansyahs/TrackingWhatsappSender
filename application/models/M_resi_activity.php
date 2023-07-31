<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_resi_activity extends CI_Model {

	public function select($where = ''){
		if ($where != ''){
			$this->db->where($where);
		}

					$this->db->from('tbl_resi_activity');
					$this->db->join('tbl_resi', 'tbl_resi.no_resi = tbl_resi_activity.no_resi');
					$this->db->join('tbl_produk_variasi', 'tbl_produk_variasi.produk_variasi_id = tbl_resi.produk_variasi_id');
					$this->db->join('tbl_produk', 'tbl_produk.kode_barang = tbl_produk_variasi.kode_barang');
					$this->db->order_by('tanggal_pencatatan', 'DESC');
		$response = $this->db->get();
		return $response;
	}

	public function save($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'no_resi'		=> $data['no_resi'],
			'date'			=> $data['date'],
			'description'	=> $data['description'],
			'location'		=> $data['location'],
			'sendWhatsapp'	=> $data['sendWhatsapp'],
		);

		$this->db->insert('tbl_resi_activity', $arr);
		$response = $this->db->insert_id();
		return $response;
	}

	public function update($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'description'	=> $data['description'],
			'date'			=> $data['date'],
			'location'		=> $data['location'],
			'sendWhatsapp'	=> $data['sendWhatsapp'],
		);

		$response = $this->db->update('tbl_resi_activity', $arr, ['resi_activity_id' => $data['resi_activity_id']]);
		return $response;
	}

	public function delete($arr){
		return $this->db->delete('tbl_resi_activity', $arr);
	}

}

/* End of file M_admin.php */
/* Location: ./application/models/M_admin.php */