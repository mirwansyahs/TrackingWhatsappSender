<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produk extends CI_Model {
	
	public function select($arr = null, $orderby = null, $groupby = null){
        if ($arr != null){
            $this->db->where($arr);
        }
        if ($orderby != null){
            $this->db->order_by($orderby[0], $orderby[1]);
        }else{
            $this->db->join('tbl_produk_variasi', 'tbl_produk_variasi.kode_barang = tbl_produk.kode_barang');
        }
        if ($groupby != null){
            $this->db->group_by($groupby);
        }
				$this->db->select('*');
				$this->db->from('tbl_produk');
		$data = $this->db->get();
		return $data;
	}

    public function insert($data){
        date_default_timezone_set('asia/jakarta');
        $arr = array(
            'kode_barang'       => $data['kode_barang'],
            'kelompok_barang'   => $data['kelompok_barang'],
            'nama_barang'       => $data['nama_barang'],
            'berat'             => $data['berat'],
            'admin_id'          => $this->userdata->admin_id,
        );

        $response = $this->db->insert('tbl_produk', $arr);

        return $response;
    }
	
    public function insertVariasi($data){
        date_default_timezone_set('asia/jakarta');
        $arr = array(
            'kode_barang'   => $data['kode_barang'],
            'nama_variasi'  => $data['nama_variasi'],
            'harga'         => $data['harga'],
        );

        $response = $this->db->insert('tbl_produk_variasi', $arr);

        return $response;
    }
	
    public function update($data){
        date_default_timezone_set('asia/jakarta');
        $arr = array(
            'kelompok_barang'   => $data['kelompok_barang'],
            'nama_barang'       => $data['nama_barang'],
            'berat'             => $data['berat'],
            'admin_id'          => $this->userdata->admin_id,
        );

        $response = $this->db->update('tbl_produk', $arr, ['kode_barang' => $data['kode_barang']]);

        return $response;
    }
	
    function delete($kode_barang = '')
    {
        $arr = array(
            'kode_barang' => $kode_barang
        );

        $response = $this->db->delete('tbl_produk', $arr);
        return $response;
    }

}

?>
