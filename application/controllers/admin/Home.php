<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends AUTH_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_resi');
		$this->load->model('M_produk');
		$this->load->model('M_admin');
	}
	
	public function index()
	{
		$data = array(
			'active'		=> 'home',
			'headerTitle'	=> 'Halaman Awal',
		);

		$this->backend->views('admin/home', $data);
	}

	public function getRealTime()
	{

		if (@$this->input->get('GPS')){
			$data['dataDevices'] = $this->M_device->select()->result();
			$data['dataResponseDevicess'] = $this->M_device_response->select()->result();
		}else{
			$data['dataDevices'] = $this->M_device->select(null, null, ['device_type' => 'GPS'])->result();
			$data['dataResponseDevicess'] = $this->M_device_response->select(null, null, ['device_type' => 'GPS'])->result();
		}
		// $data['dataResponseDevices']	= $this->M_device_response->select()->result();
		$data['dataResponseDevices'] = "";
		foreach ($data['dataResponseDevicess'] as $key) {
			$data['dataResponseDevices'] .= ' 
				<tr>
                    <td>
                        <label class="badge badge-info">'.$key->device_type.'</label>
                        <label class="badge badge-success">'.$key->device_code.'</label>
                        <br />
                        '.$key->device_name.'
                    </td>
                    <td>
                        '.$key->response_date.'
                    </td>
                    <td>
                        '.$key->response_value.'
                    </td>
                </tr>';
		}

		$data['dataRealTime'] = null;
		$i = 0;
		foreach ($data['dataDevices'] as $key) {
			$dataResponse = $this->M_device_response->select(['tbl_device_response.device_code' => $key->device_code], false)->result();
			$data['dataRealTime'][$key->device_code]['labels'][0] = "0";
			$j = 1;
			foreach ($dataResponse as $value) {
				$data['dataRealTime'][$key->device_code]['labels'][$j] = $value->response_date;
				$data['dataRealTime'][$key->device_code]['datasets'][0] = array(
					'type' 					=> 'line',
					'data'					=> [0],
					'borderColor' 			=> '#007bff',
                    'pointBorderColor' 		=> '#007bff',
                    'pointBackgroundColor' 	=> '#007bff'
				);

				$j++;
			}

			foreach ($dataResponse as $value) {
				array_push($data['dataRealTime'][$key->device_code]['datasets'][0]['data'], (int)$value->response_value);
			}
			
			$i++;
		}

		$msgSampah = "";
		$cekFullLogam = $this->db->order_by('response_date', 'DESC')->get_where('tbl_device_response', ['device_code' => 'ts_logam'])->row();
		$cekFullNonLogam = $this->db->order_by('response_date', 'DESC')->get_where('tbl_device_response', ['device_code' => 'ts_nonlogam'])->row();

		if ($cekFullLogam->response_value >= 18){
			$msgSampah .= "Sampah Logam";
		}

		if ($msgSampah != ""){
			$msgSampah .= " dan ";
		}

		if ($cekFullNonLogam->response_value >= 18){
			$msgSampah .= "Sampah Non Logam";
		}

		if ($msgSampah != ""){
			$msgSampah .= " sudah penuh. Segera kosongkan!";
		}

		$data['notificationFull'] = $msgSampah;

		echo json_encode($data);
	}

	public function sendWhatsapp()
	{

		$msgSampah = "";
		$cekFullLogam = $this->db->order_by('response_date', 'DESC')->get_where('tbl_device_response', ['device_code' => 'ts_logam'])->row();
		$cekFullNonLogam = $this->db->order_by('response_date', 'DESC')->get_where('tbl_device_response', ['device_code' => 'ts_nonlogam'])->row();

		if ($cekFullLogam->response_value >= 18){
			$msgSampah .= "Sampah Logam";
		}

		if ($msgSampah != ""){
			$msgSampah .= " dan ";
		}

		if ($cekFullNonLogam->response_value >= 18){
			$msgSampah .= "Sampah Non Logam";
		}

		if ($msgSampah != ""){
			$msgSampah .= " sudah penuh. Segera kosongkan!";
		}

		$data['notificationFull'] = $msgSampah;

		if ($data['notificationFull'] != ""){
			foreach ($this->M_admin->select()->result() as $key){
				sendWa($key->no_hp, $msgSampah);
			}
		}
	}
}
