<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/User_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listUser($koneksi);
				break;
			
			case 'tambah':
				action($koneksi, $action);
				break;

			case 'getedit':
				getEdit($koneksi, $id);
				break;

			case 'edit':
				action($koneksi, $action);
				break;

			case 'getview':
				getView($koneksi, $id);
				break;

			case 'get_select_hak_akses':
				get_select_hak_akses();
				break;

			case 'getexcel':

				break;

			case 'getpdf':
				$jenis = isset($_POST['jenis']) ? $_POST['jenis'] : false;
				getPdf($koneksi, $jenis, $id);
				break;

			default:
				die();
				break;
		}
	}

	function listUser($koneksi){
		$config_db = array(
			'tabel' => 'v_user',
			'kolomOrder' => array(null, 'username', 'nama', 'jenis', null, 'status', null),
			'kolomCari' => array('username', 'nama', 'jenis', 'status'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_user = get_datatable_user($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_user as $row){
			$no_urut++;
			$status = strtolower($row['status'])=='aktif' ? '<span class="label label-success label-rouded">'.$row['status'].'</span>' : '<span class="label label-info label-rouded">'.$row['status'].'</span>';
			
			// view
			$aksi = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["username"]."'".')"><i class="ti-zoom-in"></i></button>';			
			// edit
			$aksi .= '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["username"]."'".')"><i class="ti-pencil-alt"></i></button>';

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['username'];
			$dataRow[] = $row['nama'];
			$dataRow[] = $row['jenis'];
			$dataRow[] = cetakListItem($row['hak_akses']);
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

	

	function get_select_hak_akses(){
		$data = array();
		foreach(base_hak_akses as $key => $value){
			$text = "MENU ".strtoupper($key);
			$dataRow = array();
			$dataRow['value'] = $key;
			$dataRow['text'] = $text;

			$data[] = $dataRow; 
		}

		echo json_encode($data);
	}

