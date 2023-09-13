<?php
    define('DEV', 'http://localhost/spt/backend-api/bff/');
    define('PROD', 'https://api.solidproject.id/bff/');
    
	function getEnvirontment()
    {
        $ci =& get_instance();

        return $ci->config->item('env');
    }

    function apiUrl($string = '')
    {
        if (getEnvirontment() == 'development'){
		    $base = DEV.@$string."?apikey=".sha1("unclemuthu");
        }else{
            $base = PROD.@$string."?apikey=".sha1("unclemuthu");
        }
		
		return $base;
	}

    function fonnteUrl($string = '')
    {
		$base = "https://api.fonnte.com".@$string;

		return $base;
	}

    function localUrl($string = '')
    {
		$base = "http://wa.omahawan.com:50000".@$string;

		return $base;
	}

	function base_name(){
		$name = "DEWASPRAY STORE";
		return $name;
	}

	function no(){
		$_ci = &get_instance();

		$noHP = $_ci->db->get_where('tbl_user', ['role' => 'admin'])->row()->no_hp;
		return $noHP;
	}

	function sendWa($target = null, $message = null, $token = null) 
    {

		$_ci = &get_instance();

		if (substr($target, 0, 1) == "0"){
			$target = "62".substr($target, 1);
		}

		$getData = $_ci->db->get_where('tbl_whatsapp', ['whatsapp_authorized' => $token])->row();
		if ($getData->whatsapp_vendor == "fonnte"){
			$customRequest = "POST";
			$url = "https://api.fonnte.com/send";
			$postFields = array(
                'target' => $target,
                'message' => $message,
                'countryCode' => '62',
            );
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => $customRequest,
				CURLOPT_POSTFIELDS => $postFields,
				CURLOPT_HTTPHEADER => [
					'Authorization: '.$token
				],
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

		}else{
			$customRequest = "POST";
			$url = "http://wa.omahawan.com:50000/sendMessage";
			$postFields = array(
                'no_hp' => $target,
                'pesan' => $message,
            );

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => $customRequest,
				CURLOPT_POSTFIELDS => json_encode($postFields),
                CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen(json_encode($postFields)),
                    )
			));

			$response = curl_exec($curl);

			var_dump($postFields);

			curl_close($curl);
			return $response;

		}
        
    }

	function expedisi($ex = null){
        $Expedisi = [
            'jne' => 'JNE',
            'jnt' => 'JNT',
            'sap' => 'SAP Express',
            'sicepat' => 'SICEPAT',
            // 'pos' => 'POS',
            // 'ninja' => 'NINJA',
            // 'anteraja' => 'Anteraja',
            // 'spx' => 'Shopee Express',
            // 'lion' => 'LION',
            // 'tiki' => 'Tiki',
            // 'jet' => 'JET Express',
            // 'ide' => 'ID Express',
            // 'wahana' => 'Wahana',
            // 'rpx' => 'RPX',
            // 'rex' => 'REX Express',
            // 'first' => 'FIRST Logitics',
        ];

        // jne, pos, tiki, rpx, wahana, sicepat, jnt, sap, jet,
        // first, ninja, lion, rex, ide, anteraja,

        if($ex == null){
            return $Expedisi;
        } else {
            return $Expedisi[$ex];
        }

    }

    function cek_expedisi($ex = null){
        $Expedisi = [
            'jne' => 'JNE',
            'jnt' => 'JNT',
            'sap' => 'SAP Express',
            'sicepat' => 'SICEPAT',
            // 'pos' => 'POS',
            // 'ninja' => 'NINJA',
            // 'anteraja' => 'Anteraja',
            // 'lion' => 'LION',
            // 'tiki' => 'Tiki',
            // 'jet' => 'JET Express',
            // 'ide' => 'ID Express',
            // 'wahana' => 'Wahana',
            // 'rpx' => 'RPX',
            // 'rex' => 'REX Express',
            // 'first' => 'FIRST Logitics',
        ];

        // jne, pos, tiki, rpx, wahana, sicepat, jnt, sap, jet,
        // first, ninja, lion, rex, ide, anteraja,

        if($ex == null){
            return $Expedisi;
        } else {
            return $Expedisi[$ex];
        }

    }

	function swal($type = "succ", $content = ''){
		if ($type == "succ")
		{
			$text = "Yeayyyyy!";
			$icon = "success";
		}
		else
		{
			$text = "Oooppssss!";
			$icon = "error";
		}
		$html = "<script>swal.fire('".$text."', '".$content."', '".$icon."');</script>";
		return $html;
	}

	// MSG
	function show_msg($content='', $type='success', $icon='fa-info-circle', $size='14px', $col = "col-md-12") {
		if ($content != '') {
			return  '<p class="box-msg">
						<div class="small-box bg-' .$type .' '.$col.'">
							<div class="inner" style="font-size:' .$size .'">
								<i class="fa ' .$icon .'"></i>
								' .$content. '
							</div>
						</div>
				    </p>';
		}
	}

	function show_succ_msg($content='', $size='14px') {
		if ($content != '') {
			return   '<p class="box-msg">
				      <div class="info-box alert-success">
					      <div class="info-box-icon">
					      	<i class="fa fa-check-circle"></i>
					      </div>
					      <div class="info-box-content" style="font-size:' .$size .'">
				        	' .$content
				      	.'</div>
					  </div>
				    </p>';
		}
	}

	function show_err_msg($content='', $size='14px') {
		if ($content != '') {
			return   '<p class="box-msg">
				      <div class="info-box alert-error">
					      <div class="info-box-icon">
					      	<i class="fa fa-warning"></i>
					      </div>
					      <div class="info-box-content" style="font-size:' .$size .'">
				        	' .$content
				      	.'</div>
					  </div>
				    </p>';
		}
	}

	//Modal
	function show_my_modal($content='', $id='', $data='', $size='md') {
		$_ci = &get_instance();

		if ($content != '') {
			$view_content = $_ci->load->view($content, $data, TRUE);

			return '<div class="modal fade" id="' .$id .'" role="dialog">
					  <div class="modal-dialog modal-' .$size .'" role="document">
					    <div class="modal-content">
					        ' .$view_content .'
					    </div>
					  </div>
					</div>';
		}
	}

	function show_my_confirm($id='', $class='', $title='Konfirmasi', $yes = 'Ya', $no = 'Tidak') {
		$_ci = &get_instance();

		if ($id != '') {
			echo   '<div class="modal fade" id="' .$id .'" role="dialog">
					  <div class="modal-dialog modal-md" role="document">
					    <div class="modal-content">
					        <div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
						      <h3 style="display:block; text-align:center;">' .$title .'</h3>
						      
						      <div class="col-md-6">
						        <button class="form-control btn btn-primary ' .$class .'"> <i class="glyphicon glyphicon-ok-sign"></i> ' .$yes .'</button>
						      </div>
						      <div class="col-md-6">
						        <button class="form-control btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> ' .$no .'</button>
						      </div>
						    </div>
					    </div>
					  </div>
					</div>';
		}
	}
?>