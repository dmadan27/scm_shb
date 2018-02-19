<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Kir_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listKir($koneksi);
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

			case 'get_kd_kir':
				get_kd_kir($koneksi);
				break;

			default:
				# code...
				break;
		}
	}

	// function list
	function listKir($koneksi){
		$config_db = array(
			'tabel' => 'v_kir',
			'kolomOrder' => array(null, 'tgl', 'kd_kir', 'nama_supplier', 'jenis_bahan_baku', 'status', null),
			'kolomCari' => array('tgl', 'kd_kir', 'nama_supplier', 'jenis_bahan_baku', 'status'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_kir = get_datatable_kir($koneksi, $config_db);

		session_start();

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_kir as $row){
			$no_urut++;
			
			$btnAksi = array(
				'view' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>',
				'edit' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>',
				'hapus' => '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["id"]."'".')"><i class="ti-trash"></i></button>',
			);
			$aksi = get_btn_aksi('kir', $_SESSION['sess_akses_menu'], $btnAksi);

			$supplier = $row['npwp'].' - '.$row['nama_supplier'];
			if(empty($row['npwp'])){ // jika nik kosong
				// jika npwp ada
				$supplier = (!empty($row['nik'])) ? $row['nik'].' (NIK) - '.$row['nama_supplier'] : $row['nama_supplier'];
			}

			$status = strtolower($row['status'])=='sesuai standar' ? '<span class="label label-success label-rouded">'.$row['status'].'</span>' : '<span class="label label-info label-rouded">'.$row['status'].'</span>';

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = cetakTgl($row['tgl'], 'full');
			$dataRow[] = $row['kd_kir'];
			$dataRow[] = $supplier;
			$dataRow[] = $row['jenis_bahan_baku'];
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
		$dataKir = isset($_POST['dataKir']) ? json_decode($_POST['dataKir'],true) : false;
		$dataKir_kopi = isset($_POST['dataKir_kopi']) ? json_decode($_POST['dataKir_kopi'],true) : false;
		$dataKir_lada = isset($_POST['dataKir_lada']) ? json_decode($_POST['dataKir_lada'],true) : false;

		$status = $errorDb = false;
		$cekKir = $cek_kirKopi = $cek_kirLada = false;
		$setError_kir_lada = $setValue_kir_lada = "";
		$setError_kir_kopi = $setValue_kir_kopi = "";

		// validasi
			$configData = setRule_validasi($dataKir);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];

			// validasi kir kopi - lada
			if($dataKir['jenis_bahan_baku'] == "K"){
				// validasi kir kopi
				$cek_kirKopi = true;
				$cek_kirLada = false;

				$configData = setRule_validasi_kopi($dataKir_kopi);
				$validasi = set_validasi($configData);
				$cekKir = $validasi['cek'];
				$setError_kir_kopi = $validasi['setError'];
				$setValue_kir_kopi = $validasi['setValue'];

				$setError_kir_lada = $setValue_kir_lada = "";
			}
			else if($dataKir['jenis_bahan_baku'] == "L"){
				// validasi kir lada
				$cek_kirLada = true;
				$cek_kirKopi = false;

				$configData = setRule_validasi_lada($dataKir_lada);
				$validasi = set_validasi($configData);
				$cekKir = $validasi['cek'];
				$setError_kir_lada = $validasi['setError'];
				$setValue_kir_lada = $validasi['setValue'];

				$setError_kir_kopi = $setValue_kir_kopi = "";
			}
		// ============================= //

		if($cek==true && $cekKir==true){
			$dataKir = array(
				'id_kir' => validInputan($dataKir['id_kir'], false, false),
				'tgl' => validInputan($dataKir['tgl'], false, false),
				'kd_kir' => validInputan($dataKir['kd_kir'], false, false),
				'id_supplier' => validInputan($dataKir['id_supplier'], false, false),
				'jenis_bahan_baku' => validInputan($dataKir['jenis_bahan_baku'], false, false),
				'status' => validInputan($dataKir['status'], false, false),
			);

			// insert kir
			if(insertKir($koneksi, $dataKir)){
				if($cek_kirKopi==true && $cek_kirLada==false){
					insertKir_kopi($koneksi, $dataKir_kopi);
				}
				else if($cek_kirKopi==false && $cek_kirLada==true){
					insertKir_lada($koneksi, $dataKir_lada);
				}
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
			'cekKir' => $cekKir,
			'errorDb' => $errorDb,
			'setError' => $setError,
			'setError_kir_kopi' => $setError_kir_kopi,
			'setError_kir_lada' => $setError_kir_lada,
		);

		echo json_encode($output);
	}

	// function get kd kir
	function get_kd_kir($koneksi){
		$dataJenis = isset($_POST['jenis']) ? $_POST['jenis'] : false;
		$jenis = ($dataJenis == "K") ? "KP" : "LD";
		$kd_kir = get_inc_kd_kir($koneksi, $jenis);

		echo json_encode($kd_kir);
	}

	function getHapus($koneksi, $id){
		$hapus = deleteKir($koneksi, $id);

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
			// kd_kir
			array(
				'field' => $data['kd_kir'], 'label' => 'Kode KIR', 'error' => 'kd_kirError',
				'value' => 'kd_kir', 'rule' => 'string | 1 | 50 | required',
			),
			// supplier
			array(
				'field' => $data['id_supplier'], 'label' => 'Supplier', 'error' => 'supplierError',
				'value' => 'supplier', 'rule' => 'angka | 1 | 999 | required',
			),
			// status
			array(
				'field' => $data['status'], 'label' => 'Status KIR', 'error' => 'statusError',
				'value' => 'status', 'rule' => 'angka | 1 | 1 | required',
			),
			// jenis bahan baku
			array(
				'field' => $data['jenis_bahan_baku'], 'label' => 'Jenis Bahan Baku', 'error' => 'jenisError',
				'value' => 'jenis', 'rule' => 'string | 1 | 10 | required',
			),
		);

		return $ruleData;
	}

	function setRule_validasi_kopi($data){
		$ruleData = array(
			// trase
			array(
				'field' => $data['trase'], 'label' => 'Trase', 'error' => 'traseError',
				'value' => 'trase', 'rule' => 'nilai | 0.01 | 999 | required',
			),
			// gelondong
			array(
				'field' => $data['gelondong'], 'label' => 'Gelondong', 'error' => 'gelondongError',
				'value' => 'gelondong', 'rule' => 'nilai | 0.01 | 999 | required',
			),
			// air_kopi
			array(
				'field' => $data['air'], 'label' => 'Air', 'error' => 'air_kopiError',
				'value' => 'air_kopi', 'rule' => 'nilai | 0.01 | 999 | required',
			),
			// ayakan
			array(
				'field' => $data['ayakan'], 'label' => 'Ayakan', 'error' => 'ayakanError',
				'value' => 'ayakan', 'rule' => 'nilai | 0.01 | 999 | required',
			),
			// kulit
			array(
				'field' => $data['kulit'], 'label' => 'Kulit', 'error' => 'kulitError',
				'value' => 'kulit', 'rule' => 'nilai | 0.01 | 999 | required',
			),
			// rendemen
			array(
				'field' => $data['rendemen'], 'label' => 'Rendemen', 'error' => 'rendemenError',
				'value' => 'rendemen', 'rule' => 'nilai | 1 | 100 | required',
			),
		);

		return $ruleData;
	}

	function setRule_validasi_lada($data){
		$ruleData = array(
			// air_lada
			array(
				'field' => $data['air'], 'label' => 'Air', 'error' => 'air_ladaError',
				'value' => 'air_lada', 'rule' => 'nilai | 1 | 999 | required',
			),
			// berat
			array(
				'field' => $data['berat'], 'label' => 'Berat', 'error' => 'beratError',
				'value' => 'berat', 'rule' => 'nilai | 1 | 99999 | required',
			),
			// abu
			array(
				'field' => $data['abu'], 'label' => 'Abu', 'error' => 'abuError',
				'value' => 'abu', 'rule' => 'nilai | 1 | 999 | required',
			),
		);

		return $ruleData;
	}