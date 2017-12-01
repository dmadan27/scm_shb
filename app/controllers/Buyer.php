<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Buyer_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listBuyer($koneksi);
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

			case 'getview':
				getView($koneksi, $id);
				break;

			case 'get_select_buyer':
				get_select_buyer($koneksi);
				break;

			case 'getexcel':

				break;

			case 'getpdf':
				$jenis = isset($_POST['jenis']) ? $_POST['jenis'] : false;
				getPdf($koneksi, $jenis, $id);
				break;

			default:
				die();
				break;
		}
	}

	// fungsi list buyer
	function listBuyer($koneksi){
		$config_db = array(
			'tabel' => 'v_buyer',
			'kolomOrder' => array(null, 'npwp', 'nama', 'alamat', 'telp', 'email', 'status', null),
			'kolomCari' => array('npwp', 'nama', 'alamat', 'telp', 'email', 'status'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_buyer = get_datatable_buyer($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_buyer as $row){
			$no_urut++;
			$status = strtolower($row['status'])=='aktif' ? '<span class="label label-success label-rouded">'.$row['status'].'</span>' : '<span class="label label-info label-rouded">'.$row['status'].'</span>';
			
			// view
			$aksi = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>';			
			// edit
			$aksi .= '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>';

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = gantiKosong($row['npwp']);
			$dataRow[] = $row['nama'];
			$dataRow[] = gantiKosong($row['alamat']);
			$dataRow[] = gantiKosong($row['telp']);
			$dataRow[] = gantiKosong($row['email']);
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
				'id_buyer' => validInputan($dataForm['id_buyer'], false, false),
				'npwp' => (empty($dataForm['npwp'])) ? NULL : validInputan($dataForm['npwp'], false, false),
				'nama' => validInputan($dataForm['nama'], false, false),
				'alamat' => (empty($dataForm['alamat'])) ? NULL : validInputan($dataForm['alamat'], false, false),
				'telp' => (empty($dataForm['telp'])) ? NULL : validInputan($dataForm['telp'], false, false),
				'email' => (empty($dataForm['email'])) ? NULL : validInputan($dataForm['email'], false, true),
				'status' => validInputan($dataForm['status'], false, false),
			);

			// cek aksi
			if($action === "tambah"){ // insert
				if(insertBuyer($koneksi, $dataForm)) $status = true;
				else{
					$status = false;
					$errorDB = true;
				}
			}
			else if($action === "edit"){ // update
				if(updateBuyer($koneksi, $dataForm)) $status = true;
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
		$data_buyer = empty(getBuyer_by_id($koneksi, $id)) ? false : getBuyer_by_id($koneksi, $id);

		echo json_encode($data_buyer);
	}

	// fungsi get select buyer
	function get_select_buyer($koneksi){
		$data_buyer = get_data_select_buyer($koneksi);
		$data = array(
			array(
				'value' => "",
				'text' => "-- Pilih Buyer --",
			),
		);
		foreach($data_buyer as $row){
			$dataRow = array();
			$dataRow['value'] = $row['id'];
			$dataRow['text'] = $row['nama'];

			$data[] = $dataRow;
		}

		echo json_encode($data);
	}

	// set rule validasi
	function setRule_validasi($data){
		$ruleData = array(
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
			// email
			array(
				'field' => $data['email'], 'label' => 'Email', 'error' => 'emailError',
				'value' => 'email', 'rule' => 'email | 1 | 255 | not_required',
			),
			// status
			array(
				'field' => $data['status'], 'label' => 'Status Supplier', 'error' => 'statusError',
				'value' => 'status', 'rule' => 'angka | 1 | 1 | required',
			),
		);

		return $ruleData;
	}