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
				action($koneksi, $action);
				break;

			case 'getedit':
				getEdit($koneksi, $id);
				break;

			case 'edit':
				action($koneksi, $action);
				break;

			case 'get_select_supplierutama':
				get_select_supplierUtama($koneksi);
				break;

			case 'getview':
				getView($koneksi, $id);
				break;

			case 'gethapus':
				getHapus($koneksi, $id);
				break;

			case 'getexcel':

				break;

			case 'getpdf':
				getPdf($koneksi);
				break;

			default:
				die();
				break;
		}
	}

	// fungsi list supplier
	function listSupplier($koneksi){
		$config_db = array(
			'tabel' => 'v_supplier',
			'kolomOrder' => array(null, 'nik', 'npwp', 'nama', 'alamat', 'telp', 'status', null),
			'kolomCari' => array('nik', 'npwp', 'nama', 'alamat', 'telp', 'status'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_supplier = get_datatable_supplier($koneksi, $config_db);

		session_start();

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_supplier as $row){
			$no_urut++;
			$status = strtolower($row['status'])=='utama' ? '<span class="label label-success label-rouded">'.$row['status'].'</span>' : '<span class="label label-info label-rouded">'.$row['status'].'</span>';
			
			$btnAksi = array(
				'view' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>',
				'edit' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>',
				'hapus' => '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["id"]."'".')"><i class="ti-trash"></i></button>',
			);

			// fungsi get aksi
			$aksi = get_btn_aksi('supplier', $_SESSION['sess_akses_menu'], $btnAksi);

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = gantiKosong($row['nik']);
			$dataRow[] = gantiKosong($row['npwp']);
			$dataRow[] = $row['nama'];
			$dataRow[] = gantiKosong($row['alamat']);
			$dataRow[] = gantiKosong($row['telp']);
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
	function action($koneksi, $action){
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
				'id_supplier' => validInputan($dataForm['id_supplier'], false, false),
				'nik' => (empty($dataForm['nik'])) ? NULL : validInputan($dataForm['nik'], false, false),
				'npwp' => (empty($dataForm['npwp'])) ? NULL : validInputan($dataForm['npwp'], false, false),
				'nama' => validInputan($dataForm['nama'], false, false),
				'alamat' => (empty($dataForm['alamat'])) ? NULL : validInputan($dataForm['alamat'], false, false),
				'telp' => (empty($dataForm['telp'])) ? NULL : validInputan($dataForm['telp'], false, false),
				'email' => (empty($dataForm['email'])) ? NULL : validInputan($dataForm['email'], false, true),
				'status' => validInputan($dataForm['status'], false, false),
				'supplier_utama' => validInputan($dataForm['supplier_utama'], false, false),
			);

			// cek aksi
			if($action === "tambah"){ // insert
				if(insertSupplier($koneksi, $dataForm)) $status = true;
				else{
					$status = false;
					$errorDB = true;
				}
			}
			else if($action === "edit"){ // update
				if(updateSupplier($koneksi, $dataForm)) $status = true;
				else{
					$status = false;
					$errorDB = true;
				}
			}
			else{
				die();
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

	// funsi get data edit
	function getEdit($koneksi, $id){
		$data_supplier = empty(getSupplier_by_id($koneksi, $id)) ? false : getSupplier_by_id($koneksi, $id);

		echo json_encode($data_supplier);
	}

	// fungsi get view
	function getView($koneksi, $id){
		// $data_supplier = 

		// echo json_encode($data_supplier);
	}

	function getHapus($koneksi, $id){
		$hapus = deleteSupplier($koneksi, $id);

		if($hapus) $status = true;
		else $status = false;

		echo json_encode($status);
	}

	// function get data supplier utama untuk select
	function get_select_supplierUtama($koneksi){
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
				$text = (!empty($row['nik'])) ? $row['nik'].' (NIK) - '.$row['nama'] : $row['nama'];
			}
			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $text;

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	// function get excel
	function getExcel(){

	}

	// function get pdf
	function getPdf($koneksi){
		$data_supplier = get_all_supplier($koneksi);
		$columns = array(
			"No", "NIK", "NPWP", "Nama", "Alamat", "No. Telepon", "Status", "Supplier Utama",
		);
		$rows = array();
		$no_urut = 0;
		// pecah data untuk di sesuaikan format
		foreach($data_supplier as $row){
			$no_urut++;

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = gantiKosong($row['nik']);
			$dataRow[] = gantiKosong($row['npwp']);
			$dataRow[] = $row['nama'];
			$dataRow[] = gantiKosong($row['alamat']);
			$dataRow[] = gantiKosong($row['telp']);
			$dataRow[] = gantiKosong($row['email']);
			$dataRow[] = $row['status'];
			$dataRow[] = ($row['nama'] == $row['nama_utama']) ? "-" : $row['nama_utama'];

			$rows[] = $dataRow;
		}

		$output = array(
			"columns" => $columns,
			"rows" => $rows,
		);

		echo json_encode($output);
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