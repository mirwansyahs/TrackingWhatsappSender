<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_produk');
		$this->load->model('M_provinsi');
		$this->load->model('M_city');
		$this->load->model('M_subdistrict');
	}
	
    protected $raja_key = "a87a0e777f90d2db9a47f194006dc2ea";

	public function index()
	{
        $data = [
            'Produk' 	=> $this->M_produk->select()->result(),
            'Provinsi' 	=> $this->M_provinsi->select()->result(),
            'title' 	=> 'Cek Ongkir',
            'sub_title' => 'Cek Ongkir'
        ];

		$this->load->view('home', $data);
	}

    public function getProvince(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: " . $this->raja_key
        ),
        ));

        $json = curl_exec($curl);
        $err = curl_error($curl);

		foreach (json_decode($json)->rajaongkir->results as $key) {
			var_dump($key);

			$this->M_provinsi->save((array) $key);
		} 

    }

    public function getcity($provinceId = null){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=" . $provinceId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: " . $this->raja_key
        ),
        ));

        $json = curl_exec($curl);
        $err = curl_error($curl);

		foreach (json_decode($json)->rajaongkir->results as $key) {
			var_dump($key);

			$this->M_city->save((array) $key);
		} 

    }

    public function getsubdis($city = null){
		
        $curl = curl_init();

		foreach ($this->M_city->select()->result() as $key) {
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=" . $key->city_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: " . $this->raja_key
        ),
        ));

        $json = curl_exec($curl);
        $err = curl_error($curl);

		foreach (json_decode($json)->rajaongkir->results as $key) {
			var_dump($key);

			$this->M_subdistrict->save((array) $key);
		} 

		}
    }

	public function city($provinsi_id){
		$data = $this->M_city->select(['tbl_city.province_id' => $provinsi_id])->result();
		echo json_encode($data);
	}

	public function subdis($city_id){
		$data = $this->M_subdistrict->select(['tbl_subdistrict.city_id' => $city_id])->result();
		echo json_encode($data);
	}

    public function cek($origin= null, $destination = null, $weight = null, $courier = null, $qty = null, $kode_barang = null){
        $produk = $this->M_produk->select(['kode_barang' => $kode_barang])->row();

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=". $origin ."&originType=subdistrict&destination=" . $destination . "&destinationType=subdistrict&weight=" . $weight . "&courier=" . $courier,
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: " . $this->raja_key
        ),
        ));

        $json = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $response = (object) json_decode($json);
        $html     = "";
        $copy_text   = "";
        $copy_alamat = "";

        if(count($response->rajaongkir->results[0]->costs) > 0){
            $no = 1;
            foreach ($response->rajaongkir->results[0]->costs as $key => $value) {
                
                $html .= "<tr>
                        <td>". $response->rajaongkir->results[0]->name . " - ". $value-> service ."</td>        
                        <td>". $value->cost[0]->etd ." Hari</td>        
                        <td>Rp. ". number_format($value->cost[0]->value, 2, ',','.') ."</td>        
                        <td>". $value->description ."</td>        
                </tr>";

                $cod = (2 * $produk->harga) / 100;
                $total_harga =  ($qty * $produk->harga) + $value->cost[0]->value;

                $copy_text .= "<div class='mb-3'>";
                $copy_text .= "<textarea rows='8' id='copy_text".$no."' name='copy_text".$no."' class='form-control' readonly>";
                $copy_text .= "Nama Produk  : " . $produk->nama_barang; 
                $copy_text .= "\r\nHarga Produk  : " . $qty . " x Rp. " . number_format($produk->harga, 2, ',','.') . " = Rp. " . number_format($qty * $produk->harga, 2, ',','.'); 
                $copy_text .= "\r\nEkspedisi  : " . $response->rajaongkir->results[0]->name . " - ". $value-> service;
                $copy_text .= "\r\nOngkir  : " . $qty . " x " . $weight . "(g) = Rp. " . number_format($value->cost[0]->value, 2, ',','.');
                $copy_text .= "\r\nCOD  : Rp. " . number_format($cod, 2, ',','.');
                $copy_text .= "\r\nTotal Harga : Rp. " . number_format($total_harga+$cod, 2, ',','.') ; 
                $copy_text .= "</textarea>";
                $copy_text .= "<button type='button' onclick=\"copyToClipboard('#copy_text".$no."')\" class='btn btn-success btn_copy mt-2'>Copy Text</button>";
                $copy_text .= "</div>";

                $result_text[] = $copy_text;

                $copy_text     = "";
                $no++;
            }
        }

        $data = [
            "result" => $html,
            "copy_alamat" => $copy_alamat,
            "copy_text" => $result_text,
        ];
        
        echo json_encode($data);
    }

    public function cekExpired()
    {
        date_default_timezone_set("asia/jakarta");
        $Resi = $this->db->where('status', 'DELIVERED')->where('datediff(now(), tanggal_pencatatan) >= 2')->from('tbl_resi')->get();

        $no = 0;
        foreach ($Resi->result() as $key) {
            $resiDump = $this->db->insert('tbl_resi_clear', $key);
            $deleteResi = $this->M_resi->delete(['resi_id' => $key->resi_id]);
            $no++;
        }

        $this->createLog("logExpired.txt", "[".date("Y/m/d H:i:s")."] Telah terhapus $no data.\r\n");
        echo "[".date("Y/m/d H:i:s")."] logExpired.txt updated.";
    }

    function createLog($nameFile = "logDelete.txt", $textFile = "Telah terhapus 1 data.\r\n"){
        $text = "";

        if (file_exists($nameFile) && filesize($nameFile) > 0){
            $fw = fopen($nameFile, "r");  
            $text .= fread($fw, filesize($nameFile));
            fclose($fw);
        }

        $fp = fopen($nameFile, "wb");  
        $text .= $textFile;
        fwrite($fp, $text);
        fclose($fp);
    }

}
