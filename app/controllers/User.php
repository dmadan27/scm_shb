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
				actionAdd($koneksi, $action);
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

				break;

			default:
				die();
				break;
		}
	}

	function listUser($koneksi){
		$config_db = array(
			'tabel' => 'v_user',
			'kolomOrder' => array(null, 'username', 'nama', 'jabatan', null, 'status', null),
			'kolomCari' => array('username', 'nama', 'jabatan', 'status'),
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
			$aksiView = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["username"]."'".')"><i class="ti-zoom-in"></i></button>';	
			// edit
			$aksiEdit = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["username"]."'".')"><i class="ti-pencil-alt"></i></button>';
			// hapus
			$aksiHapus = '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["username"]."'".')"><i class="ti-trash"></i></button>';

			$aksi = $aksiView.$aksiEdit.$aksiHapus;

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['username'];
			$dataRow[] = $row['nama'];
			$dataRow[] = $row['jabatan'];
			$dataRow[] = $row['hak_akses'];
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

			$validPassword = validPassword("Password", $dataForm['password'], $dataForm['konf_password'], 10, 50);
			if(!$validPassword['cek']) $cek = false;
			$setError['passwordError'] = $validPassword['error']['password'];
			$setError['konf_passwordError'] = $validPassword['error']['confirm'];
			$setValue['password'] = $validPassword['value']['password'];
			$setValue['konf_password'] = $validPassword['value']['confirm'];
		// ====================== //

		if($cek){
			$dataForm = array(
				'id_user' => validInputan($dataForm['id_user'], false, true),
				'username' => validInputan($dataForm['username'], false, true),
				'password' => password_hash($dataForm['password'], PASSWORD_BCRYPT),
				'konf_password' => validInputan($dataForm['konf_password'], false, true),
				// 'jenis' => validInputan($dataForm['jenis'], false, false),
				'pengguna' => validInputan($dataForm['pengguna'], false, false),
				'hak_akses' => validInputan($dataForm['hak_akses'], false, false),
				'status' => validInputan($dataForm['status'], false, false),
			);

			if(insertUser($koneksi, $dataForm)) $status = true;
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

	function setRule_validasi($data){
		$ruleData = array(
			// username
			array(
				'field' => $data['username'], 'label' => 'Username', 'error' => 'usernameError',
				'value' => 'username', 'rule' => 'huruf | 6 | 10 | required',
			),
			// status
			array(
				'field' => $data['status'], 'label' => 'Status', 'error' => 'statusError',
				'value' => 'status', 'rule' => 'angka | 1 | 1 | required',
			),
			// jenis
			// array(
			// 	'field' => $data['jenis'], 'label' => 'Jenis User', 'error' => 'jenisError',
			// 	'value' => 'jenis', 'rule' => 'huruf | 1 | 1 | required',
			// ),
			// pengguna
			array(
				'field' => $data['pengguna'], 'label' => 'Pengguna', 'error' => 'penggunaError',
				'value' => 'pengguna', 'rule' => 'angka | 1 | 9999 | required',
			),
			// hak akses
			array(
				'field' => $data['hak_akses'], 'label' => 'Hak Akses', 'error' => 'hak_aksesError',
				'value' => 'hak_akses', 'rule' => 'huruf | 1 | 255 | required',
			),
		);

		return $ruleData;
	}

