<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Kendaraan_model.php");
	include_once("../models/Karyawan_model.php");

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

			case 'gethapus':
				getHapus($koneksi, $id);
				break;

			case 'getselect_supir':
				getSelect_supir($koneksi);
				break;

			default:
				# code...
				break;
		}
	}

	// fungsi list kendaraan
	function listKendaraan($koneksi){
		$config_db = array(
			'tabel' => 'v_kendaraan',
			'kolomOrder' => array(null, 'no_polis', 'tahun', 'supir', 'pendamping', 'jenis', 'muatan', 'status', null),
			'kolomCari' => array('no_polis', 'tahun', 'supir', 'pendamping', 'jenis', 'muatan', 'status'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_kendaraan = get_datatable_kendaraan($koneksi, $config_db);

		session_start();

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_kendaraan as $row){
			$no_urut++;
			$status = strtolower($row['status'])=='tersedia' ? '<span class="label label-success label-rouded">'.$row['status'].'</span>' : '<span class="label label-danger label-rouded">'.$row['status'].'</span>';
			
			$btnAksi = array(
				'view' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>',
				'edit' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>',
				'hapus' => '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["id"]."'".')"><i class="ti-trash"></i></button>',
			);

			$aksi = get_btn_aksi('kendaraan', $_SESSION['sess_akses_menu'], $btnAksi);

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['no_polis'];
			$dataRow[] = gantiKosong($row['tahun']);
			$dataRow[] = $row['supir'];
			$dataRow[] = gantiKosong($row['pendamping']);
			$dataRow[] = $row['jenis'];
			$dataRow[] = cetakAngka($row['muatan']).' KG';
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
		$foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;

		// validasi
			$cekFoto = true;
			$status = $errorDB = false;

			$configData = setRule_validasi($dataForm);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];

			// jika terdeteksi ada input foto
			if($foto){
				$configFoto = array(
					'error' => $foto['error'],
					'size' => $foto['size'],
					'name' => $foto['name'],
					'tmp_name' => $foto['tmp_name'],
					'max' => 2*1048576,
				);
				$valid_foto = validFoto($configFoto);
				if(!$valid_foto['cek']){
					$cek = false;
					$setError['fotoError'] = $valid_foto['error'];
				}
				else $valueFoto = 'kendaraan/'.$valid_foto['namaFile'];
			}
			else $valueFoto = NULL;
		// ================================= //

		if($cek){
			$dataForm = array(
				'id_kendaraan' => validInputan($dataForm['id_kendaraan'], false, false),
				'no_polis' => validInputan($dataForm['no_polis'], false, false),
				'id_supir' => validInputan($dataForm['id_supir'], false, false),
				'pendamping' => (empty($dataForm['pendamping'])) ? NULL : validInputan($dataForm['pendamping'], false, false),
				'status' => validInputan($dataForm['status'], false, false),
				'tahun' => (empty($dataForm['tahun'])) ? NULL : validInputan($dataForm['tahun'], false, false),
				'jenis' => validInputan($dataForm['jenis'], false, false),
				'muatan' => validInputan($dataForm['muatan'], false, false),
				'foto' => (empty($valueFoto)) ? $valueFoto : validInputan($valueFoto, false, true),
			);

			// jika upload foto
			if($foto){
				$path = "../../assets/images/$valueFoto";
				if(!move_uploaded_file($foto['tmp_name'], $path)){
					$pesanError['fotoError'] = "Upload Foto Gagal";
					$status = $cekFoto = false;
				}
			}

			if($cekFoto){
				// lakukan insert
				if(insertKendaraan($koneksi, $dataForm)) $status = true;
				else{
					$status = false;
					$errorDB = true;
				}
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

	function getEdit($koneksi, $id){
		$data_kendaraan = empty(getKendaraan_by_id($koneksi, $id)) ? false : getKendaraan_by_id($koneksi, $id);

		echo json_encode($data_kendaraan);
	}

	function actionEdit($koneksi){
		$dataForm = isset($_POST) ? $_POST : false;

		// validasi
			$status = $errorDB = false;

			$configData = setRule_validasi($dataForm);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];
		// ======================== //

		if($cek){
			$dataForm = array(
				'id_kendaraan' => validInputan($dataForm['id_kendaraan'], false, false),
				'no_polis' => validInputan($dataForm['no_polis'], false, false),
				'id_supir' => validInputan($dataForm['id_supir'], false, false),
				'pendamping' => (empty($dataForm['pendamping'])) ? NULL : validInputan($dataForm['pendamping'], false, false),
				'status' => validInputan($dataForm['status'], false, false),
				'tahun' => (empty($dataForm['tahun'])) ? NULL : validInputan($dataForm['tahun'], false, false),
				'jenis' => validInputan($dataForm['jenis'], false, false),
				'muatan' => validInputan($dataForm['muatan'], false, false),
			);

			if(updateKendaraan($koneksi, $dataForm)) $status = true;
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

	function getView($koneksi, $id){

	}

	function getHapus($koneksi, $id){
		$hapus = deleteKendaraan($koneksi, $id);

		if($hapus) $status = true;
		else $status = false;

		echo json_encode($status);
	}
	
	function getSelect_supir($koneksi){
		$data_supir = get_data_supir($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Supir --",
			),
		);
		foreach ($data_supir as $row) {
			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $row['nama'];

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	function setRule_validasi($data){
		$ruleData = array(
			// no_polis
			array(
				'field' => $data['no_polis'], 'label' => 'No. Polisi Kendaraan', 'error' => 'no_polisError',
				'value' => 'no_polis', 'rule' => 'string | 1 | 15 | required',
			),
			// id_supir
			array(
				'field' => $data['id_supir'], 'label' => 'Supir', 'error' => 'id_supirError',
				'value' => 'id_supir', 'rule' => 'angka | 1 | 9999 | required',
			),
			// pendamping
			array(
				'field' => $data['pendamping'], 'label' => 'Pendamping', 'error' => 'pendampingError',
				'value' => 'pendamping', 'rule' => 'string | 1 | 255 | not_required',
			),
			// status
			array(
				'field' => $data['status'], 'label' => 'Status Kendaraan', 'error' => 'statusError',
				'value' => 'status', 'rule' => 'angka | 1 | 1 | required',
			),
			// tahun
			array(
				'field' => $data['tahun'], 'label' => 'Tahun Kendaraan', 'error' => 'tahunError',
				'value' => 'tahun', 'rule' => 'angka | 1 | 4 | not_required',
			),
			// jenis
			array(
				'field' => $data['jenis'], 'label' => 'Jenis Kendaraan', 'error' => 'jenisError',
				'value' => 'jenis', 'rule' => 'huruf | 1 | 1 | required',
			),
			// muatan
			array(
				'field' => $data['muatan'], 'label' => 'Muatan Kendaraan', 'error' => 'muatanError',
				'value' => 'muatan', 'rule' => 'nilai | 1 | 999999 | required',
			),
		);

		return $ruleData;
	}