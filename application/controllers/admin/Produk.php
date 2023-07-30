<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends AUTH_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_produk');
	}
	
	public function index()
	{
		$data = array(
			'active'		=> 'produk',
			'headerTitle'	=> 'Daftar Produk',
			'data'		=> $this->M_produk->select(null, null, 'tbl_produk.kode_barang')->result(),
		);

		$this->backend->views('admin/produk/list', $data);
	}

	public function add()
	{
		$data = array(
			'active'		=> 'produk',
			'headerTitle'	=> 'Tambah Produk',
		);

		$this->backend->views('admin/produk/add', $data);
	}

	public function addProccess()
	{
		$data = $this->input->post();
		$data['kode_barang']	= $this->generateCode();

		$result = $this->M_produk->insert($data);
		if ($result){
			$id = $this->db->insert_id();
			$data['nama_variasi']	= 'Standard';
			$data['harga']			= 0;
			$addVariasi = $this->M_produk->insertVariasi($data);
			$this->session->set_flashdata('msg', swal("succ", "Data berhasil ditambahkan."));
			redirect('admin/produk/edit/'.$id);
		}else{
			$this->session->set_flashdata('msg', swal("err", "Data gagal ditambahkan."));
			redirect('admin/produk/add');
		}

	}

	public function createvariasi()
	{
		$data = $this->input->post();

		$cekDB = $this->db->get_where('tbl_produk_variasi', ['produk_variasi_id' => $data['produk_variasi_id']])->row();
        if ($cekDB != null){
            $dataDB = array(
                'nama_variasi'  => $data['nama_variasi'],
                'harga'         => $data['harga']
            );
            $result = $this->db->update('tbl_produk_variasi', $dataDB, ['produk_variasi_id' => $cekDB->produk_variasi_id]);
        }else{
            $dataDB = array(
                'kode_barang'   => $data['kode_barang'],
                'nama_variasi'  => $data['nama_variasi'],
                'harga'         => $data['harga']
            );
            $result = $this->db->insert('tbl_produk_variasi', $dataDB);
        }

        if ($result){
            echo "Data berhasil disimpan";
        }else{
            echo "Data gagal disimpan";
        }

	}
	public function edit($id = '')
	{
		$data = array(
			'active'		=> 'produk',
			'headerTitle'	=> 'Ubah Produk',
			'id'			=> $id,
			'Produk'			=> $this->M_produk->select(['id' => $id], ['id', 'desc'])->row(),
		);

        $data['variasi'] = $this->M_produk->select(['tbl_produk.kode_barang' => $data['Produk']->kode_barang])->result();

		$this->backend->views('admin/produk/update', $data);
	}

	public function editProccess($id = '')
	{
		$data = $this->input->post();
		$data['kode_barang'] = $id;

		$result = $this->M_produk->update($data);
		if ($result){
			$this->session->set_flashdata('msg', swal("succ", "Data berhasil diubah."));
		}else{
			$this->session->set_flashdata('msg', swal("err", "Data gagal diubah."));
		}

		redirect('admin/produk');
	}

	public function delete($id = '')
	{
		$result = $this->M_produk->delete($id);
		if ($result){
			$this->session->set_flashdata('msg', swal("succ", "Data berhasil dihapus"));
		}else{
			$this->session->set_flashdata('msg', swal("err", "Data gagal dihapus"));
		}

		redirect('admin/produk');
	}

    public function generateCode()
    {
        $count = $this->M_produk->select()->num_rows();
        $data = $this->M_produk->select('', ['id', 'DESC'])->row();

        if ($count > 0) {
            $code = substr($data->kode_barang, 4);
            $code = $code + 1;
            $code = 'BRG' . sprintf("%04s", $code);
        } else {
            $code = 'BRG0001';
        }

        return $code;
    }
}
