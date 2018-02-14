<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Mutasi_persediaan_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list_mutasi_bahan_baku':
				listMutasi_bahan_baku($koneksi);
				break;

			case 'list_mutasi_produk':
				listMutasi_produk($koneksi);
				break;

			default:
				die("error");
				break;
		}
	}

	function listMutasi_bahan_baku($koneksi){
		$config_db = array(
			'tabel' => 'v_mutasi_bahan_baku',
			'kolomOrder' => array(null, 'tgl', 'kd_bahan_baku', 'nama_bahan_baku', 'brg_masuk', 'brg_keluar'),
			'kolomCari' => array('tgl', 'kd_bahan_baku', 'nama_bahan_baku', 'brg_masuk', 'brg_keluar'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_mutasi = get_datatable_mutasi_bahan_baku($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_mutasi as $row){
			$no_urut++;

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = cetakTgl($row['tgl'], 'full');
			$dataRow[] = $row['kd_bahan_baku'];
			$dataRow[] = $row['nama_bahan_baku'];
			$dataRow[] = $row['brg_masuk']." ".$row['satuan'];
			$dataRow[] = $row['brg_keluar']." ".$row['satuan'];
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

	function listMutasi_produk($koneksi){
		$config_db = array(
			'tabel' => 'v_mutasi_produk',
			'kolomOrder' => array(null, 'tgl', 'kd_produk', 'nama_produk', 'brg_masuk', 'brg_keluar'),
			'kolomCari' => array('tgl', 'kd_bahan_baku', 'nama_bahan_baku', 'brg_masuk', 'brg_keluar'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_mutasi = get_datatable_mutasi_produk($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_mutasi as $row){
			$no_urut++;

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = cetakTgl($row['tgl'], 'full');
			$dataRow[] = $row['kd_produk'];
			$dataRow[] = $row['nama_produk'];
			$dataRow[] = $row['brg_masuk']." ".$row['satuan'];
			$dataRow[] = $row['brg_keluar']." ".$row['satuan'];
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