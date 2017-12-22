<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Bahan_baku_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listBahanBaku($koneksi);
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

			default:
				# code...
				break;
		}
	}

	// fungsi list bahan baku
	function listBahanBaku($koneksi){
		$config_db = array(
			'tabel' => 'bahan_baku',
			'kolomOrder' => array(null, 'kd_bahan_baku', 'nama', 'satuan', 'ket', 'stok', null),
			'kolomCari' => array('kd_bahan_baku', 'nama', 'satuan', 'ket', 'stok'),
			'orderBy' => array('id' => 'asc'),
			'kondisi' => false,
		);

		$data_bahan_baku = get_datatable_bahan_baku($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_bahan_baku as $row){
			$no_urut++;
			
			// view
			$aksi = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>';			
			// edit
			$aksi .= '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>';

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['kd_bahan_baku'];
			$dataRow[] = $row['nama'];
			$dataRow[] = $row['satuan'];
			$dataRow[] = gantiKosong($row['ket']);
			$dataRow[] = $row['stok'];
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