<?php
	date_default_timezone_set('Asia/Jakarta');
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Perencanaan_bahan_baku_model.php");
	include_once("../models/Pemesanan_model.php");
	include_once("../models/Produk_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listPerencanaan_bahan_baku($koneksi);
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

			case 'hitung_peramalan':
				hitung_peramalan($koneksi);
				break;

			case 'hitung_jumlah_bahanbaku':
				$nilai_perencanaan = isset($_POST['nilai_perencanaan']) ? $_POST['nilai_perencanaan'] : false; 
				$produk = isset($_POST['produk']) ? $_POST['produk'] : false;

				$get_bahanBaku = getKomposisi_by_id($koneksi, $produk);
				$jumlah_bahanBaku = hitung_jumlah_bahanBaku($nilai_perencanaan, $get_bahanBaku);
				echo json_encode($jumlah_bahanBaku);
				break;

			case 'hitung_safety_stock':
				hitung_safety_stock($koneksi);
				break;

			default:
				# code...
				break;
		}
	}

	// fungsi list perencanaan
	function listPerencanaan_bahan_baku($koneksi){
		$config_db = array(
			'tabel' => 'v_perencanaan_bahan_baku',
			'kolomOrder' => array(null, 'tgl', 'periode', 'nama_produk', 'jumlah_perencanaan', null, null, null),
			'kolomCari' => array('tgl', 'periode', 'nama_produk', 'kd_produk', 'jumlah_perencanaan'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_perencanaan = get_datatable_perencanaan_bahan_baku($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_perencanaan as $row){
			$no_urut++;
			
			// view
			$aksiView = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id"]."'".')"><i class="ti-zoom-in"></i></button>';	
			// edit
			$aksiEdit = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id"]."'".')"><i class="ti-pencil-alt"></i></button>';
			// hapus
			$aksiHapus = '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Hapus Data" onclick="getHapus('."'".$row["id"]."'".')"><i class="ti-trash"></i></button>';

			$aksi = $aksiView.$aksiEdit.$aksiHapus;

			// hitung jumlah bahan baku
			$get_bahanBaku = getKomposisi_by_id($koneksi, $row['id_produk']);
			$temp_jumlah_bahanBaku = hitung_jumlah_bahanBaku($row['jumlah_perencanaan'], $get_bahanBaku);

			$jumlah_bahanBaku = array();

			for($i=0; $i<count($temp_jumlah_bahanBaku); $i++){
				$jumlah_bahanBaku[] = $temp_jumlah_bahanBaku[$i]['jumlah_bahanBaku']." ".$temp_jumlah_bahanBaku[$i]['satuan_bahan_baku'];
			}

			$jumlah_bahanBaku = implode(', ', $jumlah_bahanBaku);

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = cetakTgl($row['tgl'], 'full');
			$dataRow[] = $row['periode'];
			$dataRow[] = $row['kd_produk']." - ".$row['nama_produk'];
			$dataRow[] = $row['jumlah_perencanaan']." ".$row['satuan_produk'];
			$dataRow[] = cetakListItem($row['komposisi']);
			$dataRow[] = cetakListItem($jumlah_bahanBaku);
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
		$dataPerencanaan = isset($_POST['dataPerencanaan']) ? json_decode($_POST['dataPerencanaan'],true) : false;
		$listJumlahBahanBaku = isset($_POST['listJumlahBahanBaku']) ? json_decode($_POST['listJumlahBahanBaku'],true) : false;
		$safety_stock_bahanBaku = isset($_POST['safety_stock_bahanBaku']) ? json_decode($_POST['safety_stock_bahanBaku'],true) : false;

		$status = $errorDB = false;

		// validasi
			$configData = setRule_validasi($dataPerencanaan);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];

			// cek duplikat periode dan produk

		// ====================================== //

		if($cek){
			$dataPerencanaan = array(
				'id_perencanaan' => validInputan($dataPerencanaan['id_perencanaan'], false, false),
				'tgl' => validInputan($dataPerencanaan['tgl'], false, false),
				'periode' => validInputan($dataPerencanaan['periode'], false, false),
				'produk' => validInputan($dataPerencanaan['produk'], false, false),
				'hasil_perencanaan' => validInputan($dataPerencanaan['hasil_perencanaan'], false, false),
				'safety_stock_produk' => validInputan($dataPerencanaan['safety_stock_produk'], false, false),
			);

			// insert
			if(insertPerencanaan_bahan_baku($koneksi, $dataPerencanaan)){
				$status = true;
				session_start();
				$_SESSION['notif'] = "Tambah Data Berhasil";
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
			// 'cekList' => $cekArray,
			'setError' => $setError,
			'setValue' => $setValue,
		);

		echo json_encode($output);
	}

	function hitung_peramalan($koneksi){
		$dataForm = isset($_POST) ? $_POST : false;
		$status = false;

		// inisialisasi awal
		$peramalan = array(0);
		$arrayAlpha = array(
			'alpha_0.1' => 0.1, 
			'alpha_0.2' => 0.2, 
			'alpha_0.3' => 0.3, 
			'alpha_0.4' => 0.4, 
			'alpha_0.5' => 0.5, 
			'alpha_0.6' => 0.6, 
			'alpha_0.7' => 0.7, 
			'alpha_0.8' => 0.8, 
			'alpha_0.9' => 0.9
		);

		// validasi
			$configData = setRule_peramalan($dataForm);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];
		// ============================== //

		if($cek){
			$status = true;

			$getBulanSebelumnya = date('Y-m', strtotime('-1 months', strtotime($dataForm['periode']))); 
			$getBulanPertama = date('Y-m', strtotime('-36 months', strtotime($dataForm['periode'])));
			$get_dataPemesanan = getPemesanan_sukses($koneksi, $getBulanPertama, $getBulanSebelumnya, $dataForm['produk']);

			// get list bulan
				// $start    = new DateTime($getBulanPertama); // bulan pertama (data ke 1)
				// $start->modify('first day of this month');
				// $end      = new DateTime($getBulanSebelumnya); // bulan terakhir (data ke 36) - bulan sebelum peramalan yg diinginkan
				// $end->modify('first day of next month');
				// $interval = DateInterval::createFromDateString('1 month');
				// $period   = new DatePeriod($start, $interval, $end);

				// $listBulan = array();
				// foreach ($period as $dt) {
				//     $listBulan[] = $dt->format("Y-m");
				// }

				// proses penyesuaian nilai data pemesanan dgn list bulan
				// $data_pemesanan = array();

			// proses hitung single exponential smoothing
			foreach($arrayAlpha as $key => $alpha){
				$tempGalatKuadrat = array();
				// lakukan perhitungan peramalan
				for($i=0; $i<count($get_dataPemesanan); $i++){
					if($i==0){
						$hitungPeramalan=round(($alpha*$get_dataPemesanan[$i]['jumlah_periode'])+((1-$alpha)*$get_dataPemesanan[$i]['jumlah_periode']), 2, PHP_ROUND_HALF_UP);
						$peramalan[$i+1] = $hitungPeramalan;
					}
					else{
						$hitungPeramalan=round(($alpha*$get_dataPemesanan[$i]['jumlah_periode'])+((1-$alpha)*$peramalan[$i]), 2);
						$galat=$get_dataPemesanan[$i]['jumlah_periode']-$peramalan[$i];
						$galatAbsolut=abs($galat);
						$galatKuadrat=pow($galatAbsolut, 2);

						$peramalan[$i+1] = $hitungPeramalan;

						$tempGalatKuadrat[] = round($galatKuadrat, 2, PHP_ROUND_HALF_UP);
					}			
				}
				$arrayGalatKuadrat = $tempGalatKuadrat;
				$arrayGalatKuadrat_2[$key] = hitung_MSE($arrayGalatKuadrat);

				$hasilPeramalan[$key]['peramalan'] = $peramalan;
				$hasilPeramalan[$key]['hasilPeramalan'] = round($hitungPeramalan, 2);
				$hasilPeramalan[$key]['nilaiMSE'] = hitung_MSE($arrayGalatKuadrat);
			}

			// pemilihan nilai mse terkecil
			$min_MSE = array_search(min($arrayGalatKuadrat_2), $arrayGalatKuadrat_2);
			$hasilPeramalan = $hasilPeramalan[$min_MSE]['hasilPeramalan'];

			$get_bahanBaku = getKomposisi_by_id($koneksi, $dataForm['produk']);
			$jumlah_bahanBaku = hitung_jumlah_bahanBaku($hasilPeramalan, $get_bahanBaku);
		}
		else {
			$status = false;
			$hasilPeramalan = $jumlah_bahanBaku = "";
		}

		$output = array(
			'status' => $status,
			'setError' => $setError,
			'setValue' => $setValue,
			'hasilPeramalan' =>$hasilPeramalan,
			'jumlah_bahanBaku' => $jumlah_bahanBaku,
		);

		echo json_encode($output);
	}

	function hitung_MSE($nilai_MSE){
		$mse = 0;
		foreach($nilai_MSE as $value){
			$mse += $value;
		}
		$mse = $mse/count($nilai_MSE);

		return round($mse, 2);
	}

	function hitung_jumlah_bahanBaku($hasilPerencanaan, $bahanBaku){
		// proses hitung jumlah bahan baku
		for($i=0; $i<count($bahanBaku); $i++){
			$bahanBaku[$i]['jumlah_bahanBaku'] = round($hasilPerencanaan + ($hasilPerencanaan*$bahanBaku[$i]['penyusutan']), 2);
		}

		return $bahanBaku;
	}

	function hitung_safety_stock($koneksi){
		$dataForm = isset($_POST) ? $_POST : false;
		$status = false;
		$ss = 0;

		// validasi
			$configData = setRule_safetyStock($dataForm);
			$validasi = set_validasi($configData);
			$cek = $validasi['cek'];
			$setError = $validasi['setError'];
			$setValue = $validasi['setValue'];

			$cekParameter = (empty($setError['nilai_zError']) && empty($setError['nilai_lError'])) ? true : false;
		// ============================== //

		if($cek){
			$status = true;
			$l = $dataForm['nilai_l'];
			$Sl2 = pow(($l/10), 2);

			$d = $dataForm['hasil_perencanaan'] / 24;
			$d2 = pow($d, 2);
			$Sd2 = pow(($d/10), 2);

			$sdl = sqrt($d2*$Sl2+$l*$Sd2);
			$ss = $dataForm['nilai_z'] * $sdl;

			// get komposisi produk
			$get_bahanBaku = getKomposisi_by_id($koneksi, $dataForm['produk']);
			$ss_bahanBaku = $get_bahanBaku;

			for($i=0; $i<count($ss_bahanBaku); $i++){
				$ss_bahanBaku[$i]['safety_stock'] = round(($ss + ($ss*$ss_bahanBaku[$i]['penyusutan'])), 2);
			}
		}
		else{
			$status = false;
			$ss_bahanBaku = array();
		}

		$output = array(
			'status' => $status,
			'cekParameter' => $cekParameter,
			'setError' => $setError,
			'setValue' => $setValue,
			'safety_stock_produk' => round($ss, 2),
			'safety_stock_bahanBaku' => $ss_bahanBaku,
		);

		echo json_encode($output);
	}
	
	function setRule_peramalan($data){
		$ruleData = array(
			// periode
			array(
				'field' => $data['periode'], 'label' => 'Periode', 'error' => 'periodeError',
				'value' => 'periode', 'rule' => 'string | 1 | 25 | required',
			),
			// produk
			array(
				'field' => $data['produk'], 'label' => 'Produk', 'error' => 'produkError',
				'value' => 'produk', 'rule' => 'string | 1 | 50 | required',
			),
		);

		return $ruleData;
	}

	function setRule_safetyStock($data){
		$required = $_POST['cekParameter'] == true ? "required" : "not_required";

		$ruleData = array(
			// produk
			array(
				'field' => $data['produk'], 'label' => 'Produk', 'error' => 'produkError',
				'value' => 'produk', 'rule' => 'string | 1 | 50 | required',
			),
			// hasil perencanaan
			array(
				'field' => $data['hasil_perencanaan'], 'label' => 'Hasil Perencanaan', 'error' => 'hasilPerencanaanError',
				'value' => 'hasilPerencanaan', 'rule' => 'nilai | 1 | 999999999 | required',
			),
			// nilai z
			array(
				'field' => $data['nilai_z'], 'label' => 'Service Level', 'error' => 'nilai_zError',
				'value' => 'nilai_z', 'rule' => 'nilai | 1 | 999999999 | '.$required,
			),
			// nilai l
			array(
				'field' => $data['nilai_l'], 'label' => 'Lead Time', 'error' => 'nilai_lError',
				'value' => 'nilai_l', 'rule' => 'nilai | 1 | 999999999 | '.$required,
			),
		);

		return $ruleData;
	}

	function setRule_validasi($data){
		$ruleData = array(
			// tgl
			array(
				'field' => $data['tgl'], 'label' => 'Tanggal', 'error' => 'tglError',
				'value' => 'tgl', 'rule' => 'string | 1 | 25 | required',
			),
			// periode
			array(
				'field' => $data['periode'], 'label' => 'Periode', 'error' => 'periodeError',
				'value' => 'periode', 'rule' => 'string | 1 | 25 | required',
			),
			// produk
			array(
				'field' => $data['produk'], 'label' => 'Produk', 'error' => 'produkError',
				'value' => 'produk', 'rule' => 'string | 1 | 50 | required',
			),
			// hasil perencanaan
			array(
				'field' => $data['hasil_perencanaan'], 'label' => 'Hasil Perencanaan', 'error' => 'hasil_perencanaanError',
				'value' => 'hasil_perencanaan', 'rule' => 'nilai | 1 | 9999999 | required',
			),
			// safety stock produk
			array(
				'field' => $data['safety_stock_produk'], 'label' => 'Safety Stock Produk', 'error' => 'safety_stock_produkError',
				'value' => 'safety_stock_produk', 'rule' => 'nilai | 1 | 9999999 | required',
			),
		);

		return $ruleData;
	}