<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

	public function select($id = '', $username = '', $role = ''){
		if ($id != ''){
			$this->db->where('admin_id', $id);
		}

		if ($username != ''){
			$this->db->where('username', $username);
		}
		if ($role != ''){
			$this->db->where('role', $role);
		}
		
					$this->db->from('tbl_admin');
		$response = $this->db->get();
		return $response;
	}

	public function insert($data){
		date_default_timezone_set('asia/jakarta');
		$arr = array(
			'username'				=> $data['username'],
			'password'			=> md5($data['password']),
			'role'			=> $data['role'],
		);

		$response = $this->db->insert('tbl_admin', $arr);
		return $response;
	}

	public function update($data){
		date_default_timezone_set('asia/jakarta');

		$response = $this->db->update('tbl_admin', $data, ['admin_id' => $data['admin_id']]);
		return $response;
	}

	public function delete($admin_id){
        $arr = array(
            'admin_id' => $admin_id
        );

		return $this->db->delete('tbl_admin', $arr);
	}
}

/* End of file M_admin.php */
/* Location: ./application/models/M_admin.php */