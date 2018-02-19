<?php
	date_default_timezone_set('Asia/Jakarta');

	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Pengiriman_model.php");
	include_once("../models/Pemesanan_model.php");
	include_once("../models/Kendaraan_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listPengiriman($koneksi);
				break;
			
			case 'tambah':
				actionAdd($koneksi);
				break;

			case 'getedit':
				getEdit($koneksi, $id);
				break;

			case 'edit':
				actionEdit($koneksi);
				break;

			case 'getview':
				getView($koneksi, $id);
				break;

			case 'gethapus':
				$id_pemesanan = isset($_POST['id_pemesanan']) ? $_POST['id_pemesanan'] : false;
				getHapus($koneksi, $id, $id_pemesanan);
				break;

			case 'get_select_kontrak':
				get_select_kontrak($koneksi);
				break;

			case 'get_info_kontrak':
				$no_kontrak = isset($_POST['no_kontrak']) ? $_POST['no_kontrak'] : false;
				get_info_kontrak($koneksi, $no_kontrak);
				break;			

			case 'get_select_kendaraan':
				get_select_kendaraan($koneksi);
				break;

			default:
				# code...
				break;
		}
	}

	function listPengiriman($koneksi){
		$config_db = array(
			'tabel' => 'v_pengiriman',
			'kolomOrder' => array(null, 'tgl_pengiriman', 'no_kontrak', 'nama_buyer', 'nama_produk', 'no_polis', 'colly', 'jumlah', 'status', null),
			'kolomCari' => array('tgl_pengiriman', 'no_kontrak', 'nama_buyer', 'nama_produk', 'no_polis', 'colly', 'jumlah', 'status', 'kd_produk'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_pengiriman = get_datatable_pengiriman($koneksi, $config_db);

		session_start();

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_pengiriman as $row){
			$no_urut++;
			
			if(strtolower($row['status']) == "proses") $status ='<span class="label label-primary label-rouded">'.$row['status'].'</span>';
			else if(strtolower($row['status']) == "dalam perjalanan") $status ='<span class="label label-info label-rouded">'.$row['status'].'</span>';
			else $status ='<span class="label label-success label-rouded">'.$row['status'].'</span>';

			$btnAksi = array(
				'view' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>',
				'edit' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>',
				'hapus' => '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["id"]."'".','."'".$row["id_pemesanan"]."'".')"><i class="ti-trash"></i></button>',
				'status' => '<button type="button" class="btn btn-primary btn-outline btn-circle m-r-5" title="Ubah Status" onclick="getStatus('."'".$row["id"]."'".')"><i class="ti-check-box"></i></button>',
			);

			// fungsi get aksi
			$aksi = get_btn_aksi('pengiriman', $_SESSION['sess_akses_menu'], $btnAksi);
	
			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = cetakTgl($row['tgl_pengiriman'], 'full');
			$dataRow[] = $row['no_polis'];
			$dataRow[] = gantikosong($row['no_kontrak']);
			$dataRow[] = $row['nama_buyer'];
			$dataRow[] = $row['nama_produk'];
			$dataRow[] = $row['colly']." PCS";
			$dataRow[] = cetakAngka($row['jumlah'])." KG";
			$dataRow[] = $status;
			$dataRow[] = $aksi;

			$data[] = $dataRow;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' => recordTotal($koneksi, $config_db),
			'recordsFiltered' => recordFilter($koneksi, $config_db),
			'data' => $data,
		);

		echo json_encode($output);
	}

	function actionAdd($koneksi){
		$dataPengiriman = isset($_POST['dataPengiriman']) ? json_decode($_POST['dataPengiriman'],true) : false;

		foreach($dataPengiriman as $index => $array){
			// insert hanya yg statusnya bukan hapus
			if($dataPengiriman[$index]['status'] != "hapus"){
				// get data list item
				foreach ($dataPengiriman[$index] as $key => $value) {
					$dataInsert[$key] = $value;
				}
				insertPengiriman($koneksi, $dataInsert);
			}
			$status = true;
			session_start();
			$_SESSION['notif'] = "Tambah Data Berhasil";
		}

		$output = array(
			'status' => $status,
		);

		echo json_encode($output);
	}

	function getHapus($koneksi, $id, $id_pemesanan){
		$hapus = deletePengiriman($koneksi, $id, $id_pemesanan);

		if($hapus) $status = true;
		else $status = false;

		echo json_encode($status);
	}

	// function get select kontrak
	function get_select_kontrak($koneksi){
		$data_kontrak = get_all_kontrak_proses($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih No. Kontrak --",
			),
		);
		foreach ($data_kontrak as $row) {
			$dataRow = array();
			$dataRow['value'] = $row['id_pemesanan'];
			$dataRow['text'] = $row['no_kontrak']." - ".$row['nama_buyer'];

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	// function get info kontrak
	function get_info_kontrak($koneksi, $no_kontrak){
		$data_kontrak = get_kontrak_byId($koneksi, $no_kontrak);

		$data_kontrak['produk'] = $data_kontrak['kd_produk']." - ".$data_kontrak['nama_produk'];
		$data_kontrak['waktu'] = cetakTgl($data_kontrak['waktu_pengiriman'], 'full')." s.d ".cetakTgl($data_kontrak['batas_waktu_pengiriman'], 'full');

		$tgl_awal = new DateTime($data_kontrak['waktu_pengiriman']);
		$tgl_akhir = new DateTime($data_kontrak['batas_waktu_pengiriman']);
		$selisih = $tgl_awal->diff($tgl_akhir);

		$data_kontrak['jumlah_hari'] = $selisih->d." Hari";

		echo json_encode($data_kontrak);
	}

	// function get select kendaraan
	function get_select_kendaraan($koneksi){
		$data_kendaraan = get_all_kendaraan($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Kendaraan --",
			),
		);
		foreach ($data_kendaraan as $row) {
			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $row['no_polis']." - ".$row['supir']." | ".$row['muatan']." KG";

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}