<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp extends AUTH_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_whatsapp');
	}
	
	public function index()
	{
		$data = array(
			'active'		=> 'whatsapp',
			'headerTitle'	=> 'Daftar Whatsapp',
			'data'			=> $this->M_whatsapp->select()->result(),
		);

		$this->backend->views('admin/whatsapp/list', $data);
	}

	public function checkAPI()
	{
		$data = $this->input->post();

		$result = NULL;
		if ($data['whatsapp_vendor'] == "fonnte"){
			$result = json_decode($this->api->CallAPI('POST', fonnteUrl('/device'), false, ['Authorization:'. $data['whatsapp_authorized']]));
		}
		echo json_encode($result);
	}

	public function getQR()
	{
		$data = $this->input->post();

		$result = NULL;
		$getData = $this->M_whatsapp->select(['whatsapp_authorized' => $data['whatsapp_authorized']])->row();
		if (@$getData->whatsapp_vendor == "fonnte"){
			$result = json_decode($this->api->CallAPI('POST', fonnteUrl('/qr'), false, ['Authorization:'. $data['whatsapp_authorized']]));
		}
		
		echo json_encode($result);
	}

	public function disconnect()
	{
		$data = $this->input->get();
		$result = NULL;
		$getData = $this->M_whatsapp->select(['whatsapp_authorized' => base64_decode($data['whatsapp_authorized'])])->row();
		if (@$getData->whatsapp_vendor == "fonnte"){
			$result = json_decode($this->api->CallAPI('POST', fonnteUrl('/disconnect'), false, ['Authorization:'. base64_decode($data['whatsapp_authorized'])]));
			if ($result){
				$this->session->set_flashdata('msg', swal("succ", "Whatsapp berhasil disconnect."));
			}else{
				$this->session->set_flashdata('msg', swal("err", "Whatsapp gagal disconnect."));
			}
		}else{
			$this->session->set_flashdata('msg', swal("err", "Data tidak ditemukan."));
		}
		
		redirect('admin/whatsapp');
	}

	public function add()
	{
		$data = array(
			'active'		=> 'whatsapp',
			'headerTitle'	=> 'Tambah Whatsapp',
		);

		$this->backend->views('admin/whatsapp/add', $data);
	}

	public function addProccess()
	{
		$data = $this->input->post();

		$result = $this->M_whatsapp->save($data);
		if ($result){
			$this->session->set_flashdata('msg', swal("succ", "Data berhasil ditambahkan."));
			redirect('admin/whatsapp');
		}else{
			$this->session->set_flashdata('msg', swal("err", "Data gagal ditambahkan."));
			redirect('admin/whatsapp');
		}

	}

	public function edit($id = '')
	{
		$data = array(
			'active'		=> 'whatsapp',
			'headerTitle'	=> 'Ubah Whatsapp',
			'id'			=> $id,
			'data'			=> $this->M_whatsapp->select(['whatsapp_id' => $id], ['whatsapp_id', 'desc'])->row(),
		);

		$this->backend->views('admin/whatsapp/update', $data);
	}

	public function editProccess($id = '')
	{
		$data = $this->input->post();
		$data['whatsapp_id'] = $id;

		$result = $this->M_whatsapp->update($data);
		if ($result){
			$this->session->set_flashdata('msg', swal("succ", "Data berhasil diubah."));
		}else{
			$this->session->set_flashdata('msg', swal("err", "Data gagal diubah."));
		}

		redirect('admin/whatsapp');
	}

	public function delete($id = '')
	{
		$result = $this->M_whatsapp->delete(['whatsapp_id' => $id]);
		if ($result){
			$this->session->set_flashdata('msg', swal("succ", "Data berhasil dihapus"));
		}else{
			$this->session->set_flashdata('msg', swal("err", "Data gagal dihapus"));
		}

		redirect('admin/whatsapp');
	}

    public function generateCode()
    {
        $count = $this->M_whatsapp->select()->num_rows();
        $data = $this->M_whatsapp->select('', ['id', 'DESC'])->row();

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
