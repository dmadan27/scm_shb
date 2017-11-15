<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Kendaraan_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listKendaraan($koneksi);
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

			default:
				# code...
				break;
		}
	}

	// fungsi list kendaraan
	function listKendaraan($koneksi){
		$config_db = array(
			'tabel' => 'v_transportasi',
			'kolomOrder' => array(null, 'no_polis', 'tahun', 'supir', 'pendamping', 'jenis', 'muatan', 'status', null),
			'kolomCari' => array('no_polis', 'tahun', 'supir', 'pendamping', 'jenis', 'muatan', 'status'),
			'orderBy' => array('id' => 'asc'),
			'kondisi' => false,
		);

		$data_kendaraan = get_all_kendaraan($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_kendaraan as $row){
			$no_urut++;
			$status = strtolower($row['status'])=='tersedia' ? '<span class="label label-success label-rouded">'.$row['status'].'</span>' : '<span class="label label-danger label-rouded">'.$row['status'].'</span>';
			
			// view
			$aksi = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>';			
			// edit
			$aksi .= '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>';

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['no_polis'];
			$dataRow[] = $row['tahun'];
			$dataRow[] = $row['supir'];
			$dataRow[] = gantiKosong($row['pendamping']);
			$dataRow[] = $row['jenis'];
			$dataRow[] = $row['muatan'].' KG';
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