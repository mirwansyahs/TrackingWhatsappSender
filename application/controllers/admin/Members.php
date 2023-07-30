<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends AUTH_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_admin');
	}

	public function index()
	{
		$data = array(
			'active'		=> 'users',
			'headerTitle'	=> 'Pengguna',
			'data'	=> $this->M_admin->select()
		);

		$this->backend->views('admin/members/list', $data);
	}
	
	public function getData()
	{
		// $fetch = $this->api->CallAPI('POST', base_api('/api/v1/_getMembers?act=selectAll&filter=agency_name'), ['email' => $this->userdata->email, 'AgencyName' => 'universitas kuningan']);
		
		// $fetch = json_decode($fetch);

		$fetch = $this->M_admin->select()->result();

		if ($fetch != null){
			$data = array(
				'active'		=> 'members',
				'headerTitle'	=> 'Pengguna',
				'data'			=> $fetch
			);
			if ($data['data'] != null){
				$arr = array(
					'succ'	=> 1,
					'data'	=> $this->load->view('admin/members/listMembers', $data, true),
					'message'=> 'Data berhasil diambil.'
				);
			}else{
				$arr = array(
					'succ'	=> 0,
					'data'	=> '',
					'message'=> 'Data gagal diambil.'
				);
			}
		}else{
			$arr = array(
				'succ'	=> 0,
				'data'	=> '',
				'message'=> 'Data gagal diambil.'
			);
		}

		echo json_encode($arr);
	}

	public function add()
	{
		$data = array(
			'active'		=> 'members',
			'headerTitle'	=> 'Pengguna',
		);
		$this->backend->views('admin/members/add', $data);
	}

	public function addProccess()
	{
		$data = $this->input->post();
		$response 				= $this->M_admin->insert($data);
		
		if ($response)
		{
			$this->session->set_flashdata("msg", swal("succ", "Data berhasil ditambahkan."));
			redirect('admin/members');
		}
		else
		{
			$this->session->set_flashdata('msg', swal("err", "Data gagal ditambahkan."));
			redirect('admin/members/add');
		}
	}

	public function edit()
	{
		$data = array(
			'active'		=> 'members',
			'headerTitle'	=> 'Profile',
			'id'			=> $this->userdata->admin_id
		);
		$data['data']	= $this->M_admin->select($data['id']);
		$this->backend->views('admin/members/edit', $data);
	}

	public function update($id)
	{
		$data = array(
			'active'		=> 'members',
			'headerTitle'	=> 'Profile',
			'id'			=> $id
		);
		$data['data']	= $this->M_admin->select($data['id']);
		$this->backend->views('admin/members/edit', $data);
	}

	public function editProccess($admin_id = null, $role = 'Manager')
	{
		$data = $this->input->post();
		$data['admin_id'] 	= $admin_id;
		$data['role']		= ($data['role'] == null) ? $this->userdata->role : $data['role'];
		if ($data['password']==""){
			unset($data['password']);
		}else{
			$data['password'] = md5($data['password']);
		}

		$response = $this->M_admin->update($data);

		if ($response)
		{
			$this->session->set_flashdata('msg', swal("succ", "Data berhasil diubah."));
			redirect('admin/members');
		}
		else
		{
			$this->session->set_flashdata('msg', swal("err", "Data gagal diubah."));
			redirect('admin/members');
		}
	}


	public function delete($members_id = null)
	{
		$response = $this->M_admin->delete($members_id);

		if ($response)
		{

			$this->session->set_flashdata('msg', swal("succ", "Data berhasil dihapus."));
		}
		else
		{
			$this->session->set_flashdata('msg', swal("err", "Data gagal dihapus."));
		}
		
		redirect('admin/members');
	}

}
