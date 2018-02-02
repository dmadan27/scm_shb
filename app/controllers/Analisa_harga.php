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
		// get jenis kir
		$jenis = get_jenis_kir($koneksi, $idKir);
		$dataKir = ($jenis['jenis_bahan_baku'] == "K") ? get_kir_kopi_by_id($koneksi, $idKir) : get_kir_lada_by_id($koneksi, $idKir);

		echo json_encode($dataKir);
	}