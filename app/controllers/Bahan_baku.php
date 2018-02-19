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

			case 'gethapus':
				getHapus($koneksi, $id);
				break;

			case 'get_select_bahanbaku':
				get_select_bahanBaku($koneksi);
				break;

			case 'get_satuan_bahanbaku':
				get_satuan_bahanbaku($koneksi, $id);
				break;

			default:
				# code...
				break;
		}
	}

	// fungsi list bahan baku
	function listBahanBaku($koneksi){
		$config_db = array(
			'tabel' => 'bahan_baku',
			'kolomOrder' => array(null, 'kd_bahan_baku', 'nama', 'satuan', 'ket', 'stok_akhir', null),
			'kolomCari' => array('kd_bahan_baku', 'nama', 'satuan', 'ket', 'stok_akhir'),
			'orderBy' => array('id' => 'asc'),
			'kondisi' => false,
		);

		$data_bahan_baku = get_datatable_bahan_baku($koneksi, $config_db);

		session_start();

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_bahan_baku as $row){
			$no_urut++;
			
			$btnAksi = array(
				'view' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>',
				'edit' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>',
				'hapus' => '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["id"]."'".')"><i class="ti-trash"></i></button>',
			);

			// fungsi get aksi
			$aksi = get_btn_aksi('bahan_baku', $_SESSION['sess_akses_menu'], $btnAksi);

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['kd_bahan_baku'];
			$dataRow[] = $row['nama'];
			$dataRow[] = $row['satuan'];
			$dataRow[] = gantiKosong($row['ket']);
			$dataRow[] = cetakAngka($row['stok_akhir'])." ".$row['satuan'];
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

	// function action add
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
				else $valueFoto = 'barang/'.$valid_foto['namaFile'];
			}
			else $valueFoto = NULL;
		// ================================== //

		if($cek){
			$dataForm = array(
				'id_bahan_baku' => validInputan($dataForm['id_bahan_baku'], false, false),
				'kd_bahan_baku' => validInputan($dataForm['kd_bahan_baku'], false, false),
				'nama' => (empty($dataForm['nama'])) ? NULL : validInputan($dataForm['nama'], false, false),
				'satuan' => (empty($dataForm['satuan'])) ? NULL : validInputan($dataForm['satuan'], false, false),
				'ket' => (empty($dataForm['ket'])) ? NULL : validInputan($dataForm['ket'], false, false),
				'foto' => (empty($valueFoto)) ? $valueFoto : validInputan($valueFoto, false, true),
				'stok' => validInputan($dataForm['stok'], false, false),
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
				if(insertBahan_baku($koneksi, $dataForm)) $status = true;
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

	// function get edit
	function getEdit($koneksi, $id){
		$data_bahan_baku = empty(getBahanBaku_by_id($koneksi, $id)) ? false : getBahanBaku_by_id($koneksi, $id);

		echo json_encode($data_bahan_baku);
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
				'id_bahan_baku' => validInputan($dataForm['id_bahan_baku'], false, false),
				'kd_bahan_baku' => validInputan($dataForm['kd_bahan_baku'], false, false),
				'nama' => (empty($dataForm['nama'])) ? NULL : validInputan($dataForm['nama'], false, false),
				'satuan' => (empty($dataForm['satuan'])) ? NULL : validInputan($dataForm['satuan'], false, false),
				'ket' => (empty($dataForm['ket'])) ? NULL : validInputan($dataForm['ket'], false, false),
			);

			// lakukan update
			if(updateBahan_baku($koneksi, $dataForm)) $status = true;
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

	// function get view
	function getView($koneksi, $id){

	}

	function getHapus($koneksi, $id){
		$hapus = deleteBahanBaku($koneksi, $id);

		if($hapus) $status = true;
		else $status = false;

		echo json_encode($status);
	}

	// function edit foto
	function editFoto($koneksi, $id){

	}

	// function hapus foto
	function hapusFoto($koneksi, $id){

	}

	// function get select bahan baku
	function get_select_bahanBaku($koneksi){
		$data_bahan_baku = get_all_bahan_baku($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Bahan Baku --",
			),
		);
		foreach ($data_bahan_baku as $row) {
			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $row['kd_bahan_baku']." - ".$row['nama'];

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	function get_satuan_bahanbaku($koneksi, $id){
		$data_satuan = getBahanBaku_by_id($koneksi, $id);

		echo json_encode($data_satuan['satuan']);
	}

	// function set rule
	function setRule_validasi($data){
		$required = $_POST['action'] == "edit" ? "not_required" : "required";

		$ruleData = array(
			// kd_bahan baku
			array(
				'field' => $data['kd_bahan_baku'], 'label' => 'Kode Bahan Baku', 'error' => 'kd_bahan_bakuError',
				'value' => 'kd_bahan_baku', 'rule' => 'string | 1 | 25 | required',
			),
			// nama
			array(
				'field' => $data['nama'], 'label' => 'Nama Bahan Baku', 'error' => 'namaError',
				'value' => 'nama', 'rule' => 'string | 1 | 50 | required',
			),
			// satuan
			array(
				'field' => $data['satuan'], 'label' => 'Satuan Bahan Baku', 'error' => 'satuanError',
				'value' => 'satuan', 'rule' => 'string | 2 | 10 | required',
			),
			// ket
			array(
				'field' => $data['ket'], 'label' => 'Keterangan', 'error' => 'ketError',
				'value' => 'ket', 'rule' => 'string | 1 | 255 | not_required',
			),
			// stok
			array(
				'field' => $data['stok'], 'label' => 'Stok Awal', 'error' => 'stokError',
				'value' => 'stok', 'rule' => 'nilai | 1 | 999999999999 | '.$required,
			),
		);

		return $ruleData;
	}