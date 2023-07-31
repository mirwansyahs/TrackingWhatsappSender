<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_resi extends CI_Model {

	public function select($where = ''){
		if ($where != ''){
			$this->db->where($where);
		}

					$this->db->from('tbl_resi');
					$this->db->join('tbl_produk_variasi', 'tbl_produk_variasi.produk_variasi_id = tbl_resi.produk_variasi_id');
					$this->db->join('tbl_produk', 'tbl_produk.kode_barang = tbl_produk_variasi.kode_barang');
					$this->db->order_by('tanggal_pencatatan', 'DESC');
		$response = $this->db->get();
		return $response;
	}

	public function save($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'nama_customer'			=> $data['nama_customer'],
			'no_telp'				=> $data['no_telp'],
			'no_resi'				=> $data['no_resi'],
			'produk_variasi_id'		=> $data['produk_variasi_id'],
			'ekspedisi'				=> $data['ekspedisi'],
			'harga'					=> $data['harga'],
			'tanggal_pencatatan'	=> $data['tanggal_pencatatan']." ".date('H:i:s'),
			'whatsapp_label'	=> $data['whatsapp_label'],
			'admin_id'				=> $this->userdata->admin_id,
		);

		$this->db->insert('tbl_resi', $arr);
		$response = $this->db->insert_id();
		return $response;
	}

	public function update($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'nama_customer'			=> $data['nama_customer'],
			'no_telp'				=> $data['no_telp'],
			'produk_variasi_id'		=> $data['produk_variasi_id'],
			'ekspedisi'				=> $data['ekspedisi'],
			'harga'					=> $data['harga'],
			'tanggal_pencatatan'	=> $data['tanggal_pencatatan']." ".date('H:i:s'),
		);

		$response = $this->db->update('tbl_resi', $arr, ['resi_id' => $data['resi_id']]);
		return $response;
	}

	public function delete($arr){
		return $this->db->delete('tbl_resi', $arr);
	}

}

/* End of file M_admin.php */
/* Location: ./application/models/M_admin.php */