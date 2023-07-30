<?php
	class Backend {
		protected $_ci;

		function __construct() {
			$this->_ci = &get_instance(); //Untuk Memanggil function load, dll dari CI. ex: $this->load, $this->model, dll
		}

		function views($template = NULL, $data = NULL) {
			if ($template != NULL) {
				$data['_header'] 				= $this->_ci->load->view('layout/header', $data, TRUE);
				//Menu
				$data['_menu'] 					= $this->_ci->load->view('layout/menu', $data, TRUE);
				//Sidebar
				$data['_sidebar'] 				= $this->_ci->load->view('layout/sidebar', $data, TRUE);
				// Content
				$data['_mainContent'] 			= $this->_ci->load->view($template, $data, TRUE);
				$data['_content'] 				= $this->_ci->load->view('layout/content', $data, TRUE);
				// Footer
				$data['_footer'] 				= $this->_ci->load->view('layout/footer', $data, TRUE);

				echo $data['_template'] 		= $this->_ci->load->view('layout/template', $data, TRUE);
			}
		}
		
        public function DateEnToIn($tanggal){
            $pecah = explode('-', $tanggal);
            $tahun = $pecah[0];
            $bulan = $pecah[1];
            $tanggal = $pecah[2];
            $pecahs = explode(' ', $tanggal);

            return $pecahs[0] . '-' . $bulan . '-' . $tahun . " " . $pecahs[1];
        }

        public function dateIn($tanggal){
            $duaBagian = explode(' ', $tanggal);
            $new = $this->DateEnToIn($duaBagian[0]);
            return $new . ' ' . $duaBagian[1];
        }
	}
	
?>