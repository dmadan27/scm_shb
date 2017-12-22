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
	function listSupplier($koneksi){
		$config_db = array(
			'tabel' => 'bahan_baku',
			'kolomOrder' => array(null, 'kd_bahan_baku', 'nama', 'satuan', 'alamat', 'telp', 'status', null),
			'kolomCari' => array('nik', 'npwp', 'nama', 'alamat', 'telp', 'status'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_supplier = get_datatable_supplier($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_supplier as $row){
			$no_urut++;
			$status = strtolower($row['status'])=='utama' ? '<span class="label label-success label-rouded">'.$row['status'].'</span>' : '<span class="label label-info label-rouded">'.$row['status'].'</span>';
			
			// view
			$aksi = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>';			
			// edit
			$aksi .= '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>';

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = gantiKosong($row['nik']);
			$dataRow[] = gantiKosong($row['npwp']);
			$dataRow[] = $row['nama'];
			$dataRow[] = gantiKosong($row['alamat']);
			$dataRow[] = gantiKosong($row['telp']);
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