<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Produk_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listProduk($koneksi);
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

			case 'get_select_produk':
				get_select_produk($koneksi);
				break;

			case 'get_satuan_produk':
				get_satuan_produk($koneksi, $id);
				break;

			case 'get_komposisi_produk':
				get_komposisi_produk($koneksi, $id);
				break;

			default:
				# code...
				break;
		}
	}

	// fungsi list produk
	function listProduk($koneksi){
		$config_db = array(
			'tabel' => 'v_produk',
			'kolomOrder' => array(null, 'kd_produk', 'nama', 'satuan', 'ket', 'komposisi', 'stok_akhir', null),
			'kolomCari' => array('kd_produk', 'nama', 'satuan', 'ket', 'komposisi', 'stok_akhir'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_produk = get_datatable_produk($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_produk as $row){
			$no_urut++;
			
			// view
			$aksiView = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>';
			// edit
			$aksiEdit = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>';
			// hapus
			$aksiHapus = '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["id"]."'".')"><i class="ti-trash"></i></button>';

			$aksi = $aksiView.$aksiEdit.$aksiHapus;

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['kd_produk'];
			$dataRow[] = $row['nama'];
			$dataRow[] = $row['satuan'];
			$dataRow[] = gantiKosong($row['ket']);
			$dataRow[] = cetakListItem($row['komposisi']);
			$dataRow[] = $row['stok_akhir']." ".$row['satuan'];
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
		$dataProduk = isset($_POST['dataProduk']) ? json_decode($_POST['dataProduk'],true) : false;
		$dataKomposisi = isset($_POST['dataKomposisi']) ? json_decode($_POST['dataKomposisi'],true) : false;
		$foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;

		// validasi
			$cekFoto = true;
			$status = $errorDB = $cekArray = false;
			
			if($dataKomposisi){ // cek isi list komposisi ada / tidak
				if(cekArray($dataKomposisi)) $cekArray = false; // array kosong
				else $cekArray = true;
			}

			$configData = setRule_validasi($dataProduk);
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

			if(!$cekArray) $cek = false;
		// ================================== //
		if($cek){
			$dataProduk = array(
				'id_produk' => validInputan($dataProduk['id_produk'], false, false),
				'kd_produk' => validInputan($dataProduk['kd_produk'], false, false),
				'nama' => (empty($dataProduk['nama'])) ? NULL : validInputan($dataProduk['nama'], false, false),
				'satuan' => (empty($dataProduk['satuan'])) ? NULL : validInputan($dataProduk['satuan'], false, false),
				'ket' => (empty($dataProduk['ket'])) ? NULL : validInputan($dataProduk['ket'], false, false),
				'foto' => (empty($valueFoto)) ? $valueFoto : validInputan($valueFoto, false, true),
				'stok' => validInputan($dataProduk['stok'], false, false),
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
				if(insertProduk($koneksi, $dataProduk)){
					foreach($dataKomposisi as $index => $array){
						// insert hanya yg statusnya bukan hapus
						if($dataKomposisi[$index]['status'] != "hapus"){
							$dataInsert['kd_produk'] = $dataProduk['kd_produk'];
							// get data list item
							foreach ($dataKomposisi[$index] as $key => $value) {
								$dataInsert[$key] = $value;
							}
							insertKomposisi($koneksi, $dataInsert);
						}
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
		}
		else $status = false;

		$output = array(
			'status' => $status,
			'errorDB' => $errorDB,
			'cekList' => $cekArray,
			'setError' => $setError,
			'setValue' => $setValue,
		);

		echo json_encode($output);
	}

	function getEdit($koneksi, $id){
		$dataProduk = empty(getProduk_by_id($koneksi, $id)) ? false : getProduk_by_id($koneksi, $id);
		$dataKomposisi = empty(getKomposisi_by_id($koneksi, $id)) ? false : getKomposisi_by_id($koneksi, $id);

		$output = array(
			'dataProduk' => $dataProduk,
			'listKomposisi' => $dataKomposisi,
		);

		echo json_encode($output);
	}

	function actionEdit($koneksi){
		$dataProduk = isset($_POST['dataProduk']) ? json_decode($_POST['dataProduk'],true) : false;
		$dataKomposisi = isset($_POST['dataKomposisi']) ? json_decode($_POST['dataKomposisi'],true) : false;

		// validasi
			$cekFoto = true;
			$status = $errorDB = $cekArray = false;
			
			if($dataKomposisi){ // cek isi list komposisi ada / tidak
				if(cekArray($dataKomposisi)) $cekArray = false; // array kosong
				else $cekArray = true;
			}

			$configData = setRule_validasi($dataProduk);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];
			
			if(!$cekArray) $cek = false;
		// ================================== //
		if($cek){
			$dataProduk = array(
				'id_produk' => validInputan($dataProduk['id_produk'], false, false),
				'kd_produk' => validInputan($dataProduk['kd_produk'], false, false),
				'nama' => (empty($dataProduk['nama'])) ? NULL : validInputan($dataProduk['nama'], false, false),
				'satuan' => (empty($dataProduk['satuan'])) ? NULL : validInputan($dataProduk['satuan'], false, false),
				'ket' => (empty($dataProduk['ket'])) ? NULL : validInputan($dataProduk['ket'], false, false),
			);

			if(updateProduk($koneksi, $dataProduk)){
				foreach($dataKomposisi as $index => $array){
					// update hanya yg statusnya bukan hapus dan aksinya edit
					if(($dataKomposisi[$index]['status'] != "hapus") && ($dataKomposisi[$index]['aksi'] == "edit")) {
						$dataUpdate['id_produk'] = $dataProduk['id_produk'];
						// get data list item
						foreach ($dataKomposisi[$index] as $key => $value) {
							$dataUpdate[$key] = $value;
						}
						updateKomposisi($koneksi,$dataUpdate);
					}
					// insert data
					else if(($dataKomposisi[$index]['status'] != "hapus") && ($dataKomposisi[$index]['aksi'] == "tambah")){
						$dataUpdate['kd_produk'] = $dataProduk['kd_produk'];
						// get data list item
						foreach ($dataKomposisi[$index] as $key => $value) {
							$dataUpdate[$key] = $value;
						}
						insertKomposisi($koneksi,$dataUpdate);
					}
					// hapus list
					else if(($dataKomposisi[$index]['status'] == "hapus") && ($dataKomposisi[$index]['aksi'] == "edit")){
						// get data list item
						foreach ($dataKomposisi[$index] as $key => $value) {
							$dataUpdate[$key] = $value;
						}
						deleteKomposisi($koneksi,$dataUpdate);
					}
				}
				$status = true;
				session_start();
				$_SESSION['notif'] = "Edit Data Berhasil";
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
			'cekList' => $cekArray,
			'setError' => $setError,
			'setValue' => $setValue,
		);

		echo json_encode($output);
	}

	// function get view
	function getView($koneksi, $id){

	}

	// function edit foto
	function editFoto($koneksi, $id){

	}

	// function hapus foto
	function hapusFoto($koneksi, $id){

	}

	// function get select produk
	function get_select_produk($koneksi){
		$data_produk = get_all_produk($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Produk --",
			),
		);
		foreach ($data_produk as $row) {
			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $row['kd_produk']." - ".$row['nama'];

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	// function get satuan produk
	function get_satuan_produk($koneksi, $id){
		$data_satuan = getProduk_by_id($koneksi, $id);

		echo json_encode($data_satuan['satuan']);
	}

	// function get komposisi produk
	function get_komposisi_produk($koneksi, $id){
		$data_komposisi = getKomposisi_by_id($koneksi, $id);

		echo json_encode($data_komposisi);
	}

	// function set rule
	function setRule_validasi($data){
		$required = $_POST['action'] == "edit" ? "not_required" : "required";

		$ruleData = array(
			// kd_produk
			array(
				'field' => $data['kd_produk'], 'label' => 'Kode Produk', 'error' => 'kd_produkError',
				'value' => 'kd_produk', 'rule' => 'string | 1 | 25 | required',
			),
			// nama
			array(
				'field' => $data['nama'], 'label' => 'Nama Produk', 'error' => 'namaError',
				'value' => 'nama', 'rule' => 'string | 1 | 50 | required',
			),
			// satuan
			array(
				'field' => $data['satuan'], 'label' => 'Satuan Produk', 'error' => 'satuanError',
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