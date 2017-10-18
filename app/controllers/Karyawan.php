<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Karyawan_model.php");

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

		$data_karyawan = get_all_karyawan($koneksi, $config_db);

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
			$duplikat = array(
				'no_induk' => false,
				'nik' => false,
				'npwp' => false,
				'email' => false,
			);

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
			else $valueFoto = "";
		// ================================== //

		if($cek){
			$dataForm = array(
				'id_karyawan' => validInputan($dataForm['id_karyawan'], false, false),
				'no_induk' => validInputan($dataForm['no_induk'], false, false),
				'nik' => validInputan($dataForm['nik'], false, false),
				'npwp' => validInputan($dataForm['npwp'], false, false),
				'nama' => validInputan($dataForm['nama'], false, false),
				'tempat_lahir' => validInputan($dataForm['tempat_lahir'], false, false),
				'tgl_lahir' => validInputan($dataForm['tgl_lahir'], false, false),
				'jk' => validInputan($dataForm['jk'], false, false),
				'alamat' => validInputan($dataForm['alamat'], false, false),
				'telp' => validInputan($dataForm['telp'], false, false),
				'email' => validInputan($dataForm['email'], false, true),
				'jabatan' => validInputan($dataForm['jabatan'], false, false),
				'status' => validInputan($dataForm['status'], false, false),
				'foto' => validInputan($valueFoto, false, true),
			);

			// cek duplikat
			$config_duplikat = array(
				'no_induk' => array(
					'tabel' => 'karyawan',
					'field' => 'no_induk',
					'value' => $dataForm['no_induk'],
				),
				'nik' => array(
					'tabel' => 'karyawan',
					'field' => 'nik',
					'value' => $dataForm['nik'],
				),
				'npwp' => array(
					'tabel' => 'karyawan',
					'field' => 'npwp',
					'value' => $dataForm['npwp'],
				),
				'email' => array(
					'tabel' => 'karyawan',
					'field' => 'email',
					'value' => $dataForm['email'],
				),
			);

			$duplikat = array(
				'no_induk' => cekDuplikat($koneksi, $config_duplikat['no_induk']) ? 
					array('duplikat'=> true, 'error' => 'No. Induk Karyawan Sudah Ada, Harap Diganti !') : array('duplikat'=> false, 'error' => ''),
				'nik' => cekDuplikat($koneksi, $config_duplikat['nik']) ? 
					array('duplikat'=> true, 'error' => 'NIK Sudah Ada, Harap Diganti !') : array('duplikat'=> false, 'error' => ''),
				'npwp' => cekDuplikat($koneksi, $config_duplikat['npwp']) ? 
					array('duplikat'=> true, 'error' => 'NPWP Sudah Ada, Harap Diganti !') : array('duplikat'=> false, 'error' => ''),
				'email' => cekDuplikat($koneksi, $config_duplikat['email']) ? 
					array('duplikat'=> true, 'error' => 'Email Sudah Ada, Harap Diganti !') : array('duplikat'=> false, 'error' => ''),
			);

			if($duplikat['no_induk']['duplikat'] == true || $duplikat['nik']['duplikat'] == true 
				|| $duplikat['npwp']['duplikat'] == true || $duplikat['email']['duplikat'] == true){
				$status = false;
				$setError['no_indukError'] = $duplikat['no_induk']['error'];
				$setError['nikError'] = $duplikat['nik']['error'];
				$setError['npwpError'] = $duplikat['npwp']['error'];
				$setError['emailError'] = $duplikat['email']['error'];
			}
			else{
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
					if(insertKaryawan($koneksi, $dataForm)) $status = true;
					else{
						$status = false;
						$errorDB = true;
					}
				}
			}
		}
		else $status = false;

		$output = array(
			'status' => $status,
			'errorDB' => $errorDB,
			'duplikat' => $duplikat,
			'setError' => $setError,
			'setValue' => $setValue,
		);

		echo json_encode($output);
	}

	// function get data edit
	function getEdit($koneksi, $id){
		$data_karyawan = empty(get_data_by_id($koneksi, $id)) ? false : get_data_by_id($koneksi, $id);
		echo json_encode($data_karyawan);
	}

	// function action edit
	function actionEdit($koneksi){
		$dataForm = isset($_POST) ? $_POST : false;

		// validasi
			$cekFoto = true;
			$status = $errorDB = false;
			$duplikat = array(
				'no_induk' => false,
				'nik' => false,
				'npwp' => false,
				'email' => false,
			);

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
				'nik' => validInputan($dataForm['nik'], false, false),
				'npwp' => validInputan($dataForm['npwp'], false, false),
				'nama' => validInputan($dataForm['nama'], false, false),
				'tempat_lahir' => validInputan($dataForm['tempat_lahir'], false, false),
				'tgl_lahir' => validInputan($dataForm['tgl_lahir'], false, false),
				'jk' => validInputan($dataForm['jk'], false, false),
				'alamat' => validInputan($dataForm['alamat'], false, false),
				'telp' => validInputan($dataForm['telp'], false, false),
				'email' => validInputan($dataForm['email'], false, true),
				'jabatan' => validInputan($dataForm['jabatan'], false, false),
				'status' => validInputan($dataForm['status'], false, false),
			);

			// lakukan insert
			if(updateKaryawan($koneksi, $dataForm)) $status = true;
			else{
				$status = false;
				$errorDB = true;
			}
		}
		else $status = false;

		$output = array(
			'status' => $status,
			'errorDB' => $errorDB,
			'duplikat' => $duplikat,
			'setError' => $setError,
			'setValue' => $setValue,
		);

		echo json_encode($output);
	}

	// function get data view
	function getView($koneksi, $id){

	}

	// function edit foto
	function EditFoto($koneksi, $id){

	}

	// function hapus foto
	function hapusFoto($koneksi, $id){

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
			// jabatan
			array(
				'field' => $data['jabatan'], 'label' => 'Jabatan', 'error' => 'jabatanError',
				'value' => 'jabatan', 'rule' => 'angka | 1 | 99999 | required',
			),
			// status
			array(
				'field' => $data['status'], 'label' => 'Status Supplier', 'error' => 'statusError',
				'value' => 'status', 'rule' => 'angka | 1 | 1 | required',
			),
		);

		return $ruleData;
	}