<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Pekerjaan_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listPekerjaan($koneksi);
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

	// fungsi list pekerjaan
	function listPekerjaan($koneksi){
		$config_db = array(
			'tabel' => 'pekerjaan',
			'kolomOrder' => array(null, 'jabatan', null, null),
			'kolomCari' => array('id', 'jabatan', 'ket'),
			'orderBy' => array('id'=>'asc'),
			'kondisi' => false,
		);

		$data_pekerjaan = get_all_pekerjaan($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_pekerjaan as $row){
			$no_urut++;

			// view
			$aksi = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>';			
			// edit
			$aksi .= '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>';

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['jabatan']; // jabatan
			$dataRow[] = gantiKosong($row['ket']);
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

			$configData = setRule_validasi($dataForm);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];
		// ================================== //

		if($cek){
			$dataForm = array(
				'id_pekerjaan' => validInputan($dataForm['id_pekerjaan'], false, false),
				'jabatan' => validInputan($dataForm['jabatan'], false, false),
				'ket' => validInputan($dataForm['ket'], false, false),
			);
	
			// lakukan insert
			if(insertPekerjaan($koneksi, $dataForm)) $status = true;
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

	function getEdit($koneksi, $id){
		$data_pekerjaan = empty(getPekerjaan_by_id($koneksi, $id)) ? false : getPekerjaan_by_id($koneksi, $id);
		echo json_encode($data_pekerjaan);
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
		// ================================== //

		if($cek){
			$dataForm = array(
				'id_pekerjaan' => validInputan($dataForm['id_pekerjaan'], false, false),
				'jabatan' => validInputan($dataForm['jabatan'], false, false),
				'ket' => validInputan($dataForm['ket'], false, false),
			);

			// lakukan update
			if(updatePekerjaan($koneksi, $dataForm)) $status = true;
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

	// set rule validasi
	function setRule_validasi($data){
		$ruleData = array(
			// nama - jabatan / pekerjaan
			array(
				'field' => $data['jabatan'], 'label' => 'Jabatan / Pekerjaan', 'error' => 'jabatanError',
				'value' => 'jabatan', 'rule' => 'string | 1 | 255 | required',
			),
			// keterangan
			array(
				'field' => $data['ket'], 'label' => 'Keterangan', 'error' => 'ketError',
				'value' => 'ket', 'rule' => 'string | 1 | 255 | not_required',
			),
		);

		return $ruleData;
	}