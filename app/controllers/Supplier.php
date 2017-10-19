<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Supplier_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listSupplier($koneksi);
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

			case 'get_supplierutama':
				get_supplierUtama($koneksi);
				break;

			case 'getview':
				getView($koneksi, $id);
				break;

			default:
				# code...
				break;
		}
	}

	// fungsi list supplier
	function listSupplier($koneksi){
		$config_db = array(
			'tabel' => 'v_supplier',
			'kolomOrder' => array(null, 'nik', 'npwp', 'nama', 'status', null),
			'kolomCari' => array('nik', 'npwp', 'nama', 'telp', 'alamat', 'status'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_supplier = get_all_supplier($koneksi, $config_db);

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

		// validasi
			$status = $errorDB = false;
			$duplikat = array(
				'nik' => false,
				'npwp' => false,
			);

			$configData = setRule_validasi($dataForm);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];
		// ================================== //

		if($cek){
			$dataForm = array(
				'id_supplier' => validInputan($dataForm['id_supplier'], false, false),
				'nik' => validInputan($dataForm['nik'], false, false),
				'npwp' => validInputan($dataForm['npwp'], false, false),
				'nama' => validInputan($dataForm['nama'], false, false),
				'telp' => validInputan($dataForm['telp'], false, false),
				'alamat' => validInputan($dataForm['alamat'], false, false),
				'status' => validInputan($dataForm['status'], false, false),
				'supplier_utama' => validInputan($dataForm['supplier_utama'], false, false),
			);

			// cek duplikat
			$config_duplikat = array(
				'nik' => array(
					'tabel' => 'supplier',
					'field' => 'nik',
					'value' => $dataForm['nik'],
				),
				'npwp' => array(
					'tabel' => 'supplier',
					'field' => 'npwp',
					'value' => $dataForm['npwp'],
				),
			);

			$duplikat = array(
				'nik' => cekDuplikat($koneksi, $config_duplikat['nik']) ? 
					array('duplikat'=> true, 'error' => 'NIK Sudah Ada, Harap Diganti !') : array('duplikat'=> false, 'error' => ''),
				'npwp' => cekDuplikat($koneksi, $config_duplikat['npwp']) ? 
					array('duplikat'=> true, 'error' => 'NPWP Sudah Ada, Harap Diganti !') : array('duplikat'=> false, 'error' => ''),
			);

			if($duplikat['nik']['duplikat'] == true || $duplikat['npwp']['duplikat'] == true){
				$status = false;
				$setError['nikError'] = $duplikat['nik']['error'];
				$setError['npwpError'] = $duplikat['npwp']['error'];
			}
			else{
				// lakukan insert
				if(insertSupplier($koneksi, $dataForm)) $status = true;
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
			'duplikat' => $duplikat,
			'setError' => $setError,
			'setValue' => $setValue,
		);

		echo json_encode($output);
	}

	// funsi get data edit
	function getEdit($koneksi, $id){
		$data_supplier = empty(get_data_by_id($koneksi, $id)) ? false : get_data_by_id($koneksi, $id);

		// if(empty($data_supplier)) $data_supplier = false;
		// else{
		// 	$data_supplier['supplier_inti'] = ($data_supplier['id']==$data_supplier['supplier_inti']) 
		// 		? "" : $data_supplier['supplier_inti']; 
		// }

		echo json_encode($data_supplier);
	}

	// fungsi action edit
	function actionEdit($koneksi){
		$dataForm = isset($_POST) ? $_POST : false;

		// validasi
			$status = $errorDB = false;
			$duplikat = array(
				'nik' => false,
				'npwp' => false,
			);

			$configData = setRule_validasi($dataForm);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];
		// ================================== //

		if($cek){
			$dataForm = array(
				'id_supplier' => validInputan($dataForm['id_supplier'], false, false),
				'nik' => validInputan($dataForm['nik'], false, false),
				'npwp' => validInputan($dataForm['npwp'], false, false),
				'nama' => validInputan($dataForm['nama'], false, false),
				'telp' => validInputan($dataForm['telp'], false, false),
				'alamat' => validInputan($dataForm['alamat'], false, false),
				'status' => validInputan($dataForm['status'], false, false),
				'supplier_utama' => validInputan($dataForm['supplier_utama'], false, false),
			);

			// lakukan update
			if(updateSupplier($koneksi, $dataForm)) $status = true;
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

	// fungsi get view
	function getView($koneksi, $id){
		// $data_supplier = 

		// echo json_encode($data_supplier);
	}

	// function get data supplier utama
	function get_supplierUtama($koneksi){
		$data_supplierUtama = get_data_supplierUtama($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Supplier Utama --",
			),
		);
		foreach ($data_supplierUtama as $row) {
			$text = $row['npwp'].' - '.$row['nama'];

			if(empty($row['npwp'])){ // jika nik kosong
				// jika npwp ada
				$text = (!empty($row['nik'])) ? $row['nik'].' (NIK) - '.$row['nama']; : $row['nama'];
			}
			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $text;

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	// set rule validasi
	function setRule_validasi($data){
		$required_supplierUtama = $data['status']==='0' ? 'required' : 'not_required'; 

		$ruleData = array(
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
			// telp
			array(
				'field' => $data['telp'], 'label' => 'telp', 'error' => 'telpError',
				'value' => 'telp', 'rule' => 'string | 1 | 20 | not_required',
			),
			// alamat
			array(
				'field' => $data['alamat'], 'label' => 'Alamat', 'error' => 'alamatError',
				'value' => 'alamat', 'rule' => 'string | 1 | 255 | not_required',
			),
			// status
			array(
				'field' => $data['status'], 'label' => 'Status Supplier', 'error' => 'statusError',
				'value' => 'status', 'rule' => 'angka | 1 | 1 | required',
			),
			// supplier utama
			array(
				'field' => $data['supplier_utama'], 'label' => 'Supplier Utama', 'error' => 'supplierUtamaError',
				'value' => 'supplier_utama', 'rule' => 'angka | 1 | 1000 | '.$required_supplierUtama,
			),
		);

		return $ruleData;
	}