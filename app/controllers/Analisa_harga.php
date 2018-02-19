<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Analisa_harga_model.php");
	include_once("../models/Harga_basis_model.php");
	include_once("../models/Kir_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listAnalisaHarga($koneksi);
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
				getHapus($koneksi, $id);
				break;

			case 'get_select_basis':
				get_select_basis($koneksi);
				break;

			case 'get_select_kir_analisa_harga':
				get_select_kir($koneksi);
				break;

			case 'get_kir_analisa_harga':
				get_dataKir_analisaHarga($koneksi, $id);
				break;

			default:
				# code...
				break;
		}
	}

	function listAnalisaHarga($koneksi){
		$config_db = array(
			'tabel' => 'v_analisa_harga',
			'kolomOrder' => array(null, 'tgl_analisa', 'kd_kir', 'nama_supplier', 'harga_basis', 'harga_beli', 'status_analisa', null),
			'kolomCari' => array('tgl_analisa', 'nama_supplier', 'kd_kir', 'jenis_kir', 'nik', 'npwp', 'harga_basis', 'harga_beli', 'status_analisa'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_analisa_harga = get_datatable_analisa_harga($koneksi, $config_db);

		session_start();

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_analisa_harga as $row){
			$no_urut++;
			
			$btnAksi = array(
				'view' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id_analisa_harga"]."'".')"><i class="ti-zoom-in"></i></button>',
				'edit' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id_analisa_harga"]."'".')"><i class="ti-pencil-alt"></i></button>',
				'hapus' => '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["id_analisa_harga"]."'".')"><i class="ti-trash"></i></button>',
			);

			// fungsi get aksi
			$aksi = get_btn_aksi('analisa_harga', $_SESSION['sess_akses_menu'], $btnAksi);
			$supplier = $row['npwp'].' - '.$row['nama_supplier'];
			if(empty($row['npwp'])){ // jika nik kosong
				// jika npwp ada
				$supplier = (!empty($row['nik'])) ? $row['nik'].' (NIK) - '.$row['nama_supplier'] : $row['nama_supplier'];
			}
			$status = strtolower($row['status_analisa'])=='sudah dibayar' ? '<span class="label label-success label-rouded">'.$row['status_analisa'].'</span>' : '<span class="label label-danger label-rouded">'.$row['status_analisa'].'</span>';

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = cetakTgl($row['tgl_analisa'], 'full');
			$dataRow[] = $row['kd_kir'];
			$dataRow[] = $supplier;
			$dataRow[] = rupiah($row['harga_basis']);
			$dataRow[] = rupiah($row['harga_beli']);
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
		$dataForm = isset($_POST) ? $_POST : false;

		// validasi
			$status = $errorDB = false;

			$configData = setRule_validasi($dataForm);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];
		// ================================== //
		if($cek){
			$dataForm = array(
				'id_analisa_harga' => validInputan($dataForm['id_analisa_harga'], false, false),
				'tgl' => validInputan($dataForm['tgl'], false, false),
				'id_basis' => validInputan($dataForm['id_basis'], false, false),
				'kd_kir' => validInputan($dataForm['kd_kir'], false, false),
				'harga_basis' => validInputan($dataForm['harga_basis'], false, false),
				'harga_beli' => validInputan($dataForm['harga_beli'], false, false),
			);

			// lakukan insert
			if(insertAnalisa_harga($koneksi, $dataForm)){
				$status = true;
				session_start();
				$_SESSION['notif'] = "Tambah Data Berhasil";
			}
			else{
				$status = false;
				$errorDB = true;
			}
		}
		else $status = false;

		$output = array(
			'status' => $status,
			'errorDB' => $errorDB,
			'setError' => $setError,
			'setValue' => $setValue,
		);

		echo json_encode($output);
	}

	function get_select_basis($koneksi){
		$data_basis = getHarga_basis_select($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Harga Basis --",
			),
		);
		foreach ($data_basis as $row) {
			$jenis = $row['jenis']=="K" ? "KOPI" : "LADA";
			// $text = $jenis." - ".rupiah($row['harga_basis']);
			$text = $jenis." - ".$row['harga_basis'];

			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $text;

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	function get_select_kir($koneksi){
		$data_kir = get_kir_analisa_harga($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Kir --",
			),
		);
		foreach ($data_kir as $row) {
			$dataRow = array();
			$dataRow['value'] = $row['id_kir'];
			$dataRow['text'] = $row['kd_kir']." - ".$row['nama_supplier'];

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	function get_dataKir_analisaHarga($koneksi, $idKir){ 
		$jenis = get_jenis_kir($koneksi, $idKir);
		$supplier = get_supplier_kir($koneksi, $idKir);
		$dataKir = ($jenis['jenis_bahan_baku'] == "K") ? get_kir_kopi_by_id($koneksi, $idKir) : get_kir_lada_by_id($koneksi, $idKir);

		$output = array(
			'jenis' =>	$jenis['jenis_bahan_baku'],
			'supplier' => $supplier,
			'dataKir' => $dataKir,
		);
		echo json_encode($output);
	}

	function getHapus($koneksi, $id){
		$hapus = deleteAnalisa_harga($koneksi, $id);

		if($hapus) $status = true;
		else $status = false;

		echo json_encode($status);
	}

	function setRule_validasi($data){
		$ruleData = array(
			// tgl
			array(
				'field' => $data['tgl'], 'label' => 'Tanggal', 'error' => 'tglError',
				'value' => 'tgl', 'rule' => 'string | 1 | 25 | required',
			),
			// id basis
			array(
				'field' => $data['id_basis'], 'label' => 'Basis', 'error' => 'id_basisError',
				'value' => 'id_basis', 'rule' => 'angka | 1 | 50 | required',
			),
			// harga basis
			array(
				'field' => $data['harga_basis'], 'label' => 'Harga Basis', 'error' => 'harga_basisError',
				'value' => 'harga_basis', 'rule' => 'nilai | 1 | 9999999 | required',
			),
			// kd kir
			array(
				'field' => $data['kd_kir'], 'label' => 'Kode Kir', 'error' => 'kd_kirError',
				'value' => 'Kode Kir', 'rule' => 'angka | 1 | 255 | required',
			),
			// harga beli
			array(
				'field' => $data['harga_beli'], 'label' => 'Harga Beli', 'error' => 'harga_beliError',
				'value' => 'harga_beli', 'rule' => 'nilai | 1 | 9999999999 | required',
			),
		);

		return $ruleData;
	}