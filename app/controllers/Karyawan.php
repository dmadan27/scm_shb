<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Karyawan_model.php");
	include_once("../models/Pekerjaan_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listKaryawan($koneksi);
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

			case 'get_select_karyawan':
				get_select_karyawan($koneksi);
				break;

			case 'getselect_pekerjaan':
				getSelect_pekerjaan($koneksi);
				break;

			default:
				# code...
				break;
		}
	}

	// fungsi list karyawan
	function listKaryawan($koneksi){
		$config_db = array(
			'tabel' => 'v_karyawan',
			'kolomOrder' => array(null, 'no_induk', 'npwp', 'nama', 'jabatan', 'status', null),
			'kolomCari' => array('no_induk', 'nik', 'npwp', 'nama', 'tempat_lahir', 'tgl_lahir', 'jk', 'alamat', 'telp', 'email', 'jabatan', 'status'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_karyawan = get_datatable_karyawan($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_karyawan as $row){
			$no_urut++;
			$status = strtolower($row['status'])=='aktif' ? '<span class="label label-success label-rouded">'.$row['status'].'</span>' : '<span class="label label-danger label-rouded">'.$row['status'].'</span>';

			// view
			$aksi = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>';			
			// edit
			$aksi .= '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>';

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['no_induk'];
			$dataRow[] = gantiKosong($row['npwp']);
			$dataRow[] = $row['nama'];
			$dataRow[] = $row['jabatan'];
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

	// fungsi action add
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
				else $valueFoto = 'karyawan/'.$valid_foto['namaFile'];
			}
			else $valueFoto = NULL;
		// ================================== //

		if($cek){
			$dataForm = array(
				'id_karyawan' => validInputan($dataForm['id_karyawan'], false, false),
				'no_induk' => validInputan($dataForm['no_induk'], false, false),
				'nik' => (empty($dataForm['nik'])) ? NULL : validInputan($dataForm['nik'], false, false),
				'npwp' => (empty($dataForm['npwp'])) ? NULL : validInputan($dataForm['npwp'], false, false),
				'nama' => (empty($dataForm['nama'])) ? NULL : validInputan($dataForm['nama'], false, false),
				'tempat_lahir' => (empty($dataForm['tempat_lahir'])) ? NULL : validInputan($dataForm['tempat_lahir'], false, false),
				'tgl_lahir' => (empty($dataForm['tgl_lahir'])) ? NULL : validInputan($dataForm['tgl_lahir'], false, false),
				'jk' => (empty($dataForm['jk'])) ? NULL : validInputan($dataForm['jk'], false, false),
				'alamat' => (empty($dataForm['alamat'])) ? NULL : validInputan($dataForm['alamat'], false, false),
				'telp' => (empty($dataForm['telp'])) ? NULL : validInputan($dataForm['telp'], false, false),
				'email' => (empty($dataForm['email'])) ? NULL : validInputan($dataForm['email'], false, true),
				'tgl_masuk' => (empty($dataForm['tgl_masuk'])) ? NULL : validInputan($dataForm['tgl_masuk'], false, false),
				'id_pekerjaan' => (empty($dataForm['id_pekerjaan'])) ? NULL : validInputan($dataForm['id_pekerjaan'], false, false),
				'status' => validInputan($dataForm['status'], false, false),
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
				if(insertKaryawan($koneksi, $dataForm)) {
					$status = true;
					session_start();
					$_SESSION['notif'] = "Tambah Data Berhasil";
				}
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

	// function get data edit
	function getEdit($koneksi, $id){
		$data_karyawan = empty(getKaryawan_by_id($koneksi, $id)) ? false : getKaryawan_by_id($koneksi, $id);
		echo json_encode($data_karyawan);
	}

	// function action edit
	function actionEdit($koneksi){
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
				'id_karyawan' => validInputan($dataForm['id_karyawan'], false, false),
				'no_induk' => validInputan($dataForm['no_induk'], false, false),
				'nik' => (empty($dataForm['nik'])) ? NULL : validInputan($dataForm['nik'], false, false),
				'npwp' => (empty($dataForm['npwp'])) ? NULL : validInputan($dataForm['npwp'], false, false),
				'nama' => (empty($dataForm['nama'])) ? NULL : validInputan($dataForm['nama'], false, false),
				'tempat_lahir' => (empty($dataForm['tempat_lahir'])) ? NULL : validInputan($dataForm['tempat_lahir'], false, false),
				'tgl_lahir' => (empty($dataForm['tgl_lahir'])) ? NULL : validInputan($dataForm['tgl_lahir'], false, false),
				'jk' => (empty($dataForm['jk'])) ? NULL : validInputan($dataForm['jk'], false, false),
				'alamat' => (empty($dataForm['alamat'])) ? NULL : validInputan($dataForm['alamat'], false, false),
				'telp' => (empty($dataForm['telp'])) ? NULL : validInputan($dataForm['telp'], false, false),
				'email' => (empty($dataForm['email'])) ? NULL : validInputan($dataForm['email'], false, true),
				'tgl_masuk' => (empty($dataForm['tgl_masuk'])) ? NULL : validInputan($dataForm['tgl_masuk'], false, false),
				'id_pekerjaan' => (empty($dataForm['id_pekerjaan'])) ? NULL : validInputan($dataForm['id_pekerjaan'], false, false),
				'status' => validInputan($dataForm['status'], false, false),
			);

			// lakukan insert
			if(updateKaryawan($koneksi, $dataForm)) {
				$status = true;
				session_start();
				$_SESSION['notif'] = "Ubah Data Berhasil";
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

	// function get data view
	function getView($koneksi, $id){

	}

	// function edit foto
	function editFoto($koneksi, $id){

	}

	// function hapus foto
	function hapusFoto($koneksi, $id){

	}

	// function get data select
	function getSelect_pekerjaan($koneksi){
		$data_pekerjaan = getPekerjaan_select($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Jabatan/Pekerjaan --",
			),
		);
		foreach ($data_pekerjaan as $row) {
			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $row['nama'];

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	// fungsi get select karyawan
	function get_select_karyawan($koneksi){
		$data_karyawan = get_data_select_karyawan($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Karyawan --",
			),
		);
		foreach($data_karyawan as $row){
			$text = $row['nama'].' - '.$row['jabatan'];

			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $text;

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	// set rule validasi
	function setRule_validasi($data){
		$ruleData = array(
			// no induk
			array(
				'field' => $data['no_induk'], 'label' => 'No. Induk Karyawan', 'error' => 'no_indukError',
				'value' => 'no_induk', 'rule' => 'angka | 10 | 10 | required',
			),
			// nik
			array(
				'field' => $data['nik'], 'label' => 'NIK', 'error' => 'nikError',
				'value' => 'nik', 'rule' => 'angka | 16 | 16 | not_required',
			),
			// npwp
			array(
				'field' => $data['npwp'], 'label' => 'NPWP', 'error' => 'npwpError',
				'value' => 'npwp', 'rule' => 'string | 20 | 20 | not_required',
			),
			// nama
			array(
				'field' => $data['nama'], 'label' => 'Nama', 'error' => 'namaError',
				'value' => 'nama', 'rule' => 'string | 1 | 255 | required',
			),
			// tempat lahir
			array(
				'field' => $data['tempat_lahir'], 'label' => 'Tempat Lahir', 'error' => 'tempat_lahirError',
				'value' => 'tempat_lahir', 'rule' => 'string | 1 | 255 | not_required',
			),
			// tgl_lahir
			array(
				'field' => $data['tgl_lahir'], 'label' => 'Tanggal Lahir', 'error' => 'tgl_lahirError',
				'value' => 'tgl_lahir', 'rule' => 'string | 1 | 255 | not_required',
			),
			// jk
			array(
				'field' => $data['jk'], 'label' => 'Jenis Kelamin', 'error' => 'jkError',
				'value' => 'jk', 'rule' => 'huruf | 1 | 1 | not_required',
			),
			// alamat
			array(
				'field' => $data['alamat'], 'label' => 'Alamat', 'error' => 'alamatError',
				'value' => 'alamat', 'rule' => 'string | 1 | 255 | not_required',
			),
			// telp
			array(
				'field' => $data['telp'], 'label' => 'telp', 'error' => 'telpError',
				'value' => 'telp', 'rule' => 'string | 1 | 20 | not_required',
			),
			// email
			array(
				'field' => $data['email'], 'label' => 'email', 'error' => 'emailError',
				'value' => 'email', 'rule' => 'email | 1 | 50 | not_required',
			),
			// tgl_masuk
			array(
				'field' => $data['tgl_masuk'], 'label' => 'Tanggal Masuk', 'error' => 'tgl_masukError',
				'value' => 'tgl_masuk', 'rule' => 'string | 1 | 255 | not_required',
			),
			// id_pekerjaan
			array(
				'field' => $data['id_pekerjaan'], 'label' => 'Jabatan', 'error' => 'id_pekerjaanError',
				'value' => 'id_pekerjaan', 'rule' => 'angka | 1 | 99999 | required',
			),
			// status
			array(
				'field' => $data['status'], 'label' => 'Status Supplier', 'error' => 'statusError',
				'value' => 'status', 'rule' => 'angka | 1 | 1 | required',
			),
		);

		return $ruleData;
	}