<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Supplier_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listSupplier($koneksi);
				break;
			
			case 'tambah':
				actionAdd($koneksi);
				break;

			case 'get_supplierinti':
				get_supplierInti($koneksi);
				break;

			default:
				# code...
				break;
		}
	}

	// fungsi list supplier
	function listSupplier($koneksi){
		$config_db = array(
			'tabel' => 'supplier',
			'kolomOrder' => array(null, 'nik', 'npwp', 'nama', 'status', null),
			'kolomCari' => array('nik', 'npwp', 'nama', 'status'),
			'orderBy' => array('id' => 'asc'),
			'kondisi' => false,
		);

		$data_supplier = get_all_supplier($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_supplier as $row){
			$status = (strtolower($row['status'])==='1') ? 'INTI' : "PENGGANTI";
			$no_urut++;
			
			// view
			$aksi = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>';			
			// edit
			$aksi .= '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>';

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['nik'];
			$dataRow[] = $row['npwp'];
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
		$foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;

		// validasi
			$cekFoto = true;
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

			// cek upload foto
			if($foto){
				$configFoto = array(
					'error' => $foto['error'],
					'size' => $foto['size'],
					'name' => $foto['name'],
					'tmp_name' => $foto['tmp_name'],
					'max' => 2*1048576,
				);
				$validFoto = validFoto($configFoto);
				if(!$validFoto['cek']){
					$cek = false;
					$setError['fotoError'] = $validFoto['error'];
				}
				else $valueFoto = $validFoto['namaFile'];
			}
			else $valueFoto = "";
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
				'supplier_inti' => validInputan($dataForm['supplier_inti'], false, false),
				'foto' => validInputan($valueFoto, false, false),
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
					array('duplikat'=> true, 'error' => 'NPWP Sudah Ada, Harap Diganti !') : array('duplikat'=> true, 'error' => ''),
			);

			if($duplikat['nik'] == true || $duplikat['npwp'] == true){
				$status = false;
				$setError['nikError'] = $duplikat['nik']['error'];
				$setError['npwpError'] = $duplikat['npwp']['error'];
			}
			else{
				// jika upload foto
				if($foto){
					$path = "../../assets/images/$valueFoto";
					if(!move_uploaded_file($foto['tmp_name'], $path)){
						$setError['fotoError'] = "Upload Foto Gagal";
						$status = $cekFoto = false;
					}
				}

				if($cekFoto){
					// lakukan query
					if(insertSupplier($koneksi, $dataForm)) $status = true;
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

	// function get data supplier inti
	function get_supplierInti($koneksi){
		$data_supplierInti = get_data_supplierInti($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Supplier Inti --",
			),
		);
		foreach ($data_supplierInti as $row) {
			$text = (empty($row['nik'])) ? $row['npwp'].' - '.$row['nama'] : $row['nik'].' - '.$row['nama'];
			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $text;

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	// set rule validasi
	function setRule_validasi($data){
		$required_supplierInti = $data['status']==='0' ? 'required' : 'not_required'; 

		$ruleData = array(
			// nik
			array(
				'field' => $data['nik'], 'label' => 'NIK', 'error' => 'nikError',
				'value' => 'nik', 'rule' => 'angka | 16 | 16 | required',
			),
			// npwp
			array(
				'field' => $data['npwp'], 'label' => 'NPWP', 'error' => 'npwpError',
				'value' => 'npwp', 'rule' => 'string | 20 | 20 | required',
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
			// supplier inti
			array(
				'field' => $data['supplier_inti'], 'label' => 'Supplier Inti', 'error' => 'supplierIntiError',
				'value' => 'supplier_inti', 'rule' => 'angka | 1 | 1000 | '.$required_supplierInti,
			),
		);

		return $ruleData;
	}
