<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resi extends AUTH_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->model('M_resi');
		$this->load->model('M_produk');
	}
	
	public function index()
	{
		$data = array(
			'active'		=> 'resi',
			'headerTitle'	=> 'Daftar Resi',
			'data'		=> $this->M_resi->select()->result(),
		);

		$this->backend->views('admin/resi/list', $data);
	}

	public function add()
	{
		$data = array(
			'active'		=> 'resi',
			'headerTitle'	=> 'Tambah Resi',
			'Produk'		=> $this->M_produk->select()->result()
		);

		$this->backend->views('admin/resi/add', $data);
	}

	public function addProccess()
	{
		$data = $this->input->post();

		$result = $this->M_resi->save($data);

		if ($result){
			$message = "Hallo Kak 👋\r\nberikut rincian pembelian di *Dewa Store* yaa\r\n";
            $message .= "\r\n*Nama : " . trim($data['nama_customer']) . "*";
            $message .= "\r\n*No resi : " . $data['no_resi'] . "*";
            $message .= "\r\n*Barang : " . $this->M_produk->select(['tbl_produk.kode_barang' => $data['kode_barang']])->row()->nama_barang . "*";
            $message .= "\r\n*Status Resi : Aktif*";
            $message .= "\r\n*Update Resi : -*";
            $message .= "\r\n\r\n*Dan untuk estimasi paket akan datang 2-3 hari pulau jawa dan 3-5 hari Untuk Luar pulau Jawa kak*, *Pengirimannya JNT EXPRES  ya kakak*";
            $message .= "\r\n*";
            $message .= "\r\n*No Resinya bisa digunakan untuk cek dan melacak pakatnya sudah sampai mana*";
            $message .= "\r\n*";
            $message .= "\r\n*Jika mungkin ada telpon dari nomor tidak dikenal, mohon dijawab, karena itu mungkin telpon dari kurir pengiriman*";
            $message .= "\r\n*";
            $message .= "\r\n\r\n*agar jika ada problem atau pemesanan selanjutnya kakak bisa langsung hubungi Admin Yang kaka Pesan Barangnya Karna Whatsapp ini Hanya untuk Tracking Resi* 🤗🤗";
            $message .= "\r\n\r\n*Terimakasi* 😊";
            $message .= "\r\n\r\n_Ini adalah pesan otomatis, tolong jangan balas pesan ini, jika ada pertanyaan langsung tanyakan ke admin yaa :))_";
            
            sendWa($data['no_telp'], $message);
			$this->session->set_flashdata('msg', swal("succ", "Data berhasil ditambahkan."));
		}else{
			$this->session->set_flashdata('msg', swal("err", "Data gagal ditambahkan."));
		}

		redirect('admin/resi');
	}

	public function edit($id = '')
	{
		$data = array(
			'active'		=> 'resi',
			'headerTitle'	=> 'Ubah Resi',
			'id'			=> $id,
            'Produk' 		=> $this->M_produk->select()->result(),
            'Resi' 			=> $this->M_resi->select(['resi_id' => $id])->row(),
		);

		$this->backend->views('admin/resi/update', $data);
	}

	public function editProccess($id = '')
	{
		$data = $this->input->post();
		$data['resi_id']	= $id;

		$result = $this->M_resi->update($data);
		if ($result){
			$this->session->set_flashdata('msg', swal("succ", "Data berhasil diubah."));
		}else{
			$this->session->set_flashdata('msg', swal("err", "Data gagal diubah."));
		}

		redirect('admin/resi');
	}

	public function delete($id = '')
	{
		$result = $this->M_resi->delete(['resi_id' => $id]);
		if ($result){
			$this->session->set_flashdata('msg', swal("succ", "Data berhasil dihapus"));
		}else{
			$this->session->set_flashdata('msg', swal("err", "Data gagal dihapus"));
		}

		redirect('admin/resi');
	}

	public function import()
		{
			$data = $this->input->post();
			$config['upload_path']		= './assets/berkas/'; //path folder
			$config['allowed_types']	= 'xlsx|xls'; //type yang dapat diakses bisa anda sesuaikan
			$config['encrypt_name']		= TRUE; //nama yang terupload nantinya

			$this->upload->initialize($config);
				
			if($this->upload->do_upload("berkas")){

            	$image = $this->upload->data();
				$ext = $image['file_ext'];
				// var_dump($image);

				// $file_excel = $this->request->getFile('berkas');
				// $ext = $file_excel->getClientExtension();

				if($ext == '.xls') {
					$render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}

				$spreadsheet = $render->load($image['full_path']);
		
				$data = $spreadsheet->getActiveSheet()->toArray();
				// var_dump($data);
				$rows = [];
				$no = 0;
				foreach($data as $x => $row) {
					if ($x == 0) {
						continue;
					}
					
					$cekResi = $this->M_resi->select(['no_resi' => $row[2]]);

					if ($cekResi->num_rows() == 0){
						$getProduct = $this->M_resi->select(['nama_barang' => $row[3], 'nama_variasi' => $row[4]])->row();

						$rows[$no] = array(
							'nama_customer' => $row[0],
							'no_telp'       => $row[1],
							'no_resi'       => $row[2],
							'produk_variasi_id'   => $getProduct->produk_variasi_id,
							'ekspedisi'     => $row[5],
							'harga'         => $row[6],
							'tanggal_pencatatan'=> date('Y-m-d H:i:s'),
							'sendWhatsapp'  => '0'
						);
					}

					$no++;

				}
				// var_dump($rows);
				if (!empty($rows)){
					$this->db->insert_batch('tbl_resi', $rows);
					$this->session->set_flashdata('message', 'Import Data Berhasil');
				} else {
					$this->session->set_flashdata('error', 'Import Data Tidak Berhasil');
				}
				return redirect('admin/resi');
			}else{
				echo $this->upload->display_errors();
			}
		}
}
