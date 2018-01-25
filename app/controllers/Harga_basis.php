<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Harga_basis_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listHargaBasis($koneksi);
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

			default:
				die();
				break;
		}
	}

	// fungsi list harga basis
	function listHargaBasis($koneksi){
		$config_db = array(
			'tabel' => 'v_harga_basis',
			'kolomOrder' => array(null, 'tgl', 'jenis', 'harga_basis', null),
			'kolomCari' => array('tgl', 'jenis', 'harga_basis'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_harga_basis = get_datatable_harga_basis($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_harga_basis as $row){
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
			$dataRow[] = cetakTgl($row['tgl'], 'full');
			$dataRow[] = $row['jenis'];
			$dataRow[] = rupiah($row['harga_basis']);
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
				'id_harga_basis' => validInputan($dataForm['id_harga_basis'], false, false),
				'tgl' => validInputan($dataForm['tgl'], false, false),
				'jenis' => validInputan($dataForm['jenis'], false, false),
				'harga_basis' => validInputan($dataForm['harga_basis'], false, false),
			);	

			if($action === "tambah"){ // insert
				if(insertHargaBasis($koneksi, $dataForm)) $status = true;
				else{
					$status = false;
					$errorDB = true;
				}
			}
			else if($action === "edit"){ // update
				if(updateHargaBasis($koneksi, $dataForm)) $status = true;
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
		$data_harga_basis = empty(getHargaBasis_by_id($koneksi, $id)) ? false : getHargaBasis_by_id($koneksi, $id);
		echo json_encode($data_harga_basis);
	}

	// set rule validasi
	function setRule_validasi($data){
		$ruleData = array(
			// tgl
			array(
				'field' => $data['tgl'], 'label' => 'Tanggal', 'error' => 'tglError',
				'value' => 'tgl', 'rule' => 'string | 1 | 255 | required',
			),
			// Jenis
			array(
				'field' => $data['jenis'], 'label' => 'Jenis Basis', 'error' => 'jenisError',
				'value' => 'jenis', 'rule' => 'string | 1 | 1 | required',
			),
			// harga basis
			array(
				'field' => $data['harga_basis'], 'label' => 'Harga Basis', 'error' => 'harga_basisError',
				'value' => 'harga_basis', 'rule' => 'nilai | 1 | 9999999 | required',
			),
		);

		return $ruleData;
	}