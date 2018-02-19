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
				action($koneksi, $action);
				break;

			case 'getedit':
				getEdit($koneksi, $id);
				break;

			case 'edit':
				action($koneksi, $action);
				break;

			case 'gethapus':
				getHapus($koneksi, $id);
				break;

			case 'getpdf':
				getpdf($koneksi);
				break;

			default:
				die();
				break;
		}
	}

	// fungsi list pekerjaan
	function listPekerjaan($koneksi){
		$config_db = array(
			'tabel' => 'pekerjaan',
			'kolomOrder' => array(null, 'nama', null, null),
			'kolomCari' => array('id', 'nama', 'ket'),
			'orderBy' => array('id'=>'asc'),
			'kondisi' => false,
		);

		$data_pekerjaan = get_datatable_pekerjaan($koneksi, $config_db);

		session_start();

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_pekerjaan as $row){
			$no_urut++;
			
			$btnAksi = array(
				'edit' => '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>',
				'hapus' => '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["id"]."'".')"><i class="ti-trash"></i></button>',
			);
			$aksi = get_btn_aksi('pekerjaan', $_SESSION['sess_akses_menu'], $btnAksi)=="" ? "-" : get_btn_aksi('pekerjaan', $_SESSION['sess_akses_menu'], $btnAksi);

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['nama'];
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
				'id_pekerjaan' => validInputan($dataForm['id_pekerjaan'], false, false),
				'nama' => validInputan($dataForm['nama'], false, false),
				'ket' => (empty($dataForm['ket'])) ? NULL : validInputan($dataForm['ket'], false, false),
			);	

			if($action === "tambah"){ // insert
				if(insertPekerjaan($koneksi, $dataForm)) $status = true;
				else{
					$status = false;
					$errorDB = true;
				}
			}
			else if($action === "edit"){ // update
				if(updatePekerjaan($koneksi, $dataForm)) $status = true;
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

	function getEdit($koneksi, $id){
		$data_pekerjaan = empty(getPekerjaan_by_id($koneksi, $id)) ? false : getPekerjaan_by_id($koneksi, $id);
		echo json_encode($data_pekerjaan);
	}

	function getHapus($koneksi, $id){
		$hapus = deletePekerjaan($koneksi, $id);

		if($hapus) $status = true;
		else $status = false;

		echo json_encode($status);
	}

	// function get pdf
	function getPdf($koneksi){
		$data_pekerjaan = get_all_pekerjaan($koneksi);
		$columns = array(
			"No", "Jabatan / Pekerjaan", "Keterangan",
		);
		$rows = array();
		$no_urut = 0;
		foreach($data_pekerjaan as $row){
			$no_urut++;

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['nama'];
			$dataRow[] = gantiKosong($row['ket']);

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
		$ruleData = array(
			// nama - jabatan / pekerjaan
			array(
				'field' => $data['nama'], 'label' => 'Jabatan / Pekerjaan', 'error' => 'namaError',
				'value' => 'nama', 'rule' => 'string | 1 | 255 | required',
			),
			// keterangan
			array(
				'field' => $data['ket'], 'label' => 'Keterangan', 'error' => 'ketError',
				'value' => 'ket', 'rule' => 'string | 1 | 255 | not_required',
			),
		);

		return $ruleData;
	}