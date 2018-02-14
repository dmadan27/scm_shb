<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Pemesanan_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listPemesanan($koneksi);
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

			case 'get_status':
				getStatus($koneksi, $id);
				break;

			case 'update_status':
				$status = isset($_POST['status']) ? $_POST['status'] : false;
				update_status($koneksi, $status, $id);
				break;

			default:
				# code...
				break;
		}
	}

	// fungsi list pemesanan
	function listPemesanan($koneksi){
		$config_db = array(
			'tabel' => 'v_pemesanan',
			'kolomOrder' => array(null, 'tgl', 'no_kontrak', 'nama_buyer', 'nama_produk', 'jumlah', 'waktu_pengiriman', 'status', null),
			'kolomCari' => array('tgl', 'no_kontrak', 'nama_buyer', 'nama_produk', 'jumlah', 'waktu_pengiriman', 'batas_waktu_pengiriman', 'status'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_pemesanan = get_datatable_pemesanan($koneksi, $config_db);

		session_start();

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_pemesanan as $row){
			$no_urut++;
			
			if(strtolower($row['status']) == "sukses") {
				$status ='<span class="label label-success label-rouded">'.$row['status'].'</span>';
				$disabled = "disabled";
			}
			else if(strtolower($row['status']) == "proses") {
				$status ='<span class="label label-info label-rouded">'.$row['status'].'</span>';
				$disabled = "";
			}
 			else if(strtolower($row['status']) == "pending") {
 				$status ='<span class="label label-warning label-rouded">'.$row['status'].'</span>';
 				$disabled = "";
 			}
			else {
				$status ='<span class="label label-danger label-rouded">'.$row['status'].'</span>';
				$disabled = "disabled";
			}

			$btnAksi = array(
				'view' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id_pemesanan"]."'".')"><i class="ti-zoom-in"></i></button>',
				'edit' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id_pemesanan"]."'".')"><i class="ti-pencil-alt"></i></button>',
				'hapus' => '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["id_pemesanan"]."'".')"><i class="ti-trash"></i></button>',
				'jadwal' => '<button type="button" '.$disabled.' class="btn btn-success btn-outline btn-circle m-r-5" title="Jadwalkan Pengiriman" onclick="setJadwal_pengiriman('."'".$row["id_pemesanan"]."'".')"><i class="ti-truck"></i></button>',
				'status' => '<button type="button" class="btn btn-primary btn-outline btn-circle m-r-5" title="Ubah Status" onclick="getStatus('."'".$row["id_pemesanan"]."'".')"><i class="ti-check-box"></i></button>',
			);

			// fungsi get aksi
			$aksi = get_btn_aksi('pemesanan', $_SESSION['sess_akses_menu'], $btnAksi);
			$waktu_pengiriman = !empty($row['waktu_pengiriman']) ? $row['waktu_pengiriman']." - ".$row['batas_waktu_pengiriman'] : "-";

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = cetakTgl($row['tgl'], 'full');
			$dataRow[] = gantikosong($row['no_kontrak']);
			$dataRow[] = $row['nama_buyer'];
			$dataRow[] = $row['nama_produk'];
			$dataRow[] = $row['jumlah']." ".$row['satuan_produk'];
			$dataRow[] = $waktu_pengiriman;
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
		$lampiran = isset($_FILES['lampiran']) ? $_FILES['lampiran'] : false;

		// validasi
			$status = $errorDB = false;
			$cekLampiran = true;

			$configData = setRule_validasi($dataForm);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];

			if($lampiran){
				$configFile = array(
					'error' => $lampiran['error'],
					'size' => $lampiran['size'],
					'name' => $lampiran['name'],
					'tmp_name' => $lampiran['tmp_name'],
					'max' => 2*1048576,
				);

				$valid_lampiran = validFile($configFile);
				if(!$valid_lampiran['cek']){
					$cek = false;
					$setError['lampiranError'] = $valid_lampiran['error'];
				}
				else $valueLampiran = 'lampiran/'.$valid_lampiran['namaFile'];
			}
			else $valueLampiran = NULL;
		// ========================================= //
		
		if($cek){
			$dataForm = array(
				'id_pemesanan' => validInputan($dataForm['id_pemesanan'], false, false),
				'tgl' => validInputan($dataForm['tgl'], false, false),
				'no_kontrak' => (empty($dataForm['no_kontrak'])) ? NULL : validInputan($dataForm['no_kontrak'], false, false),
				'buyer' => validInputan($dataForm['buyer'], false, false),
				'produk' => validInputan($dataForm['produk'], false, false),
				'jumlah' => validInputan($dataForm['jumlah'], false, false),
				'jumlah_karung' => (empty($dataForm['jumlah_karung'])) ? NULL : validInputan($dataForm['jumlah_karung'], false, false),
				'ket_karung' => (empty($dataForm['ket_karung'])) ? NULL : validInputan($dataForm['ket_karung'], false, false),
				'kemasan' => (empty($dataForm['kemasan'])) ? NULL : validInputan($dataForm['kemasan'], false, false),
				'waktu_pengiriman' => validInputan($dataForm['waktu_pengiriman'], false, false),
				'batas_waktu_pengiriman' => validInputan($dataForm['batas_waktu_pengiriman'], false, false),
				'ket' => (empty($dataForm['ket'])) ? NULL : validInputan($dataForm['ket'], false, false),
				'lampiran' => (empty($valueLampiran)) ? $valueLampiran : validInputan($valueLampiran, false, true),
				'status' => validInputan($dataForm['status'], false, false),
			);

			// jika upload lampiran
			if($lampiran){
				$path = "../../assets/lampiran/$valueLampiran";
				if(!move_uploaded_file($lampiran['tmp_name'], $path)){
					$pesanError['lampiranError'] = "Upload File Lampiran Gagal";
					$status = $cekLampiran = false;
				}
			}

			if($cekLampiran){
				// insert pemesanan
				if(insertPemesanan($koneksi, $dataForm)){
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

	function getStatus($koneksi, $id){
		$data_status = getStatus_pemesanan_byId($koneksi, $id);

		echo json_encode($data_status['status']);
	}

	function update_status($koneksi, $status, $id){
		// validasi
		if($status == ""){
			$cek = false;
			$pesan = "Status Tidak Boleh Kosong!";
		}
		else{
			if(updateStatus_pemesanan($koneksi, $status, $id)){
				$cek = true;
				$pesan = "Ubah Status Pemesanan Berhasil !";
			}
			else $cek = false;
		}

		$output = array(
			'status' => $cek,
			'pesan' => $pesan,
		);

		echo json_encode($output);
	}

	function setRule_validasi($data){
		$required = $_POST['action'] == "edit" ? "not_required" : "required";

		$ruleData = array(
			// tgl
			array(
				'field' => $data['tgl'], 'label' => 'Tanggal', 'error' => 'tglError',
				'value' => 'tgl', 'rule' => 'string | 1 | 25 | required',
			),
			// no. kontrak
			array(
				'field' => $data['no_kontrak'], 'label' => 'No. Kontrak', 'error' => 'no_kontrakError',
				'value' => 'no_kontrak', 'rule' => 'string | 1 | 50 | required',
			),
			// buyer
			array(
				'field' => $data['buyer'], 'label' => 'Buyer', 'error' => 'buyerError',
				'value' => 'buyer', 'rule' => 'angka | 1 | 9999 | required',
			),
			// produk
			array(
				'field' => $data['produk'], 'label' => 'Produk', 'error' => 'produkError',
				'value' => 'produk', 'rule' => 'angka | 1 | 9999 | required',
			),
			// jumlah produk
			array(
				'field' => $data['jumlah'], 'label' => 'Jumlah Produk', 'error' => 'jumlahError',
				'value' => 'jumlah', 'rule' => 'nilai | 10000 | 9999999 | required',
			),
			// jumlah karung
			array(
				'field' => $data['jumlah_karung'], 'label' => 'Jumlah Karung', 'error' => 'jumlah_karungError',
				'value' => 'jumlah_karung', 'rule' => 'nilai | 1 | 99999 | not_required',
			),
			// ket karung
			array(
				'field' => $data['ket_karung'], 'label' => 'Keterangan Karung', 'error' => 'ket_karungError',
				'value' => 'ket_karung', 'rule' => 'string | 1 | 255 | not_required',
			),
			// kemasan
			array(
				'field' => $data['kemasan'], 'label' => 'Kemasaan', 'error' => 'kemasanError',
				'value' => 'kemasan', 'rule' => 'string | 1 | 255 | not_required',
			),
			// waktu pengiriman
			array(
				'field' => $data['waktu_pengiriman'], 'label' => 'Waktu pengiriman', 'error' => 'waktu_pengirimanError',
				'value' => 'waktu_pengiriman', 'rule' => 'string | 1 | 255 | required',
			),
			// batas waktu pengiriman
			array(
				'field' => $data['batas_waktu_pengiriman'], 'label' => 'Batas Waktu Pengiriman', 'error' => 'batas_waktu_pengirimanError',
				'value' => 'batas_waktu_pengiriman', 'rule' => 'string | 1 | 255 | required',
			),
			// keterangan
			array(
				'field' => $data['ket'], 'label' => 'Keterangan', 'error' => 'ketError',
				'value' => 'ket', 'rule' => 'string | 1 | 255 | not_required',
			),
			// status
			array(
				'field' => $data['status'], 'label' => 'Status', 'error' => 'statusError',
				'value' => 'status', 'rule' => 'string | 1 | 255 | required',
			),
		);

		return $ruleData;
	}