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

			default:
				# code...
				break;
		}
	}

	// fungsi list perencanaan
	function listPerencanaan_bahan_baku($koneksi){
		$config_db = array(
			'tabel' => 'v_perencanaan_bahan_baku',
			'kolomOrder' => array(null, 'tgl', 'periode', 'nama_produk', 'hasil_peramalan',null, null),
			'kolomCari' => array('tgl', 'periode', 'nama_produk', 'kd_produk', 'hasil_peramalan', 'jumlah_bahan_baku'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_perencanaan = get_datatable_perencanaan_bahan_baku($koneksi, $config_db);

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_peramalan as $row){
			$no_urut++;
			
			// view
			$aksiView = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Lihat Detail Data" onclick="getView('."'".$row["id_peramalan"]."'".')"><i class="ti-zoom-in"></i></button>';			
			// edit
			$aksiEdit = '<button type="button" class="btn btn-info btn-outline btn-circle m-r-5" title="Edit Data" onclick="getEdit('."'".$row["id_peramalan"]."'".')"><i class="ti-pencil-alt"></i></button>';
			// hapus
			$aksiHapus = '<button type="button" class="btn btn-danger btn-outline btn-circle m-r-5" title="Edit Data" onclick="getHapus('."'".$row["id_peramalan"]."'".')"><i class="ti-trash"></i></button>';

			$aksi = $aksiView.$aksiEdit.$aksiHapus;

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = cetakTgl($row['tgl'], 'full');
			$dataRow[] = $row['periode'];
			$dataRow[] = $row['kd_produk'].' - '.$row['nama_produk'];
			$dataRow[] = $row['hasil_peramalan'].' '.$row['satuan_produk'];
			$dataRow[] = $row['jumlah_bahan_baku'];
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

	function hitung_peramalan($koneksi){
		$dataForm = isset($_POST) ? $_POST : false;
		// inisialisasi awal
		$peramalan = array(0);
		$a = 0.9;

		// validasi
			// get bulan sebelumnya dari peramalan
			$bulanSebelumnya = date('Y-m', strtotime('-1 months', strtotime($dataForm['periode']))); 

			// get bulan pertama untuk peramalan
			$bulanPertama = date('Y-m', strtotime('-36 months', strtotime($dataForm['periode'])));

			$get_dataPemesanan = getPemesanan_sukses($koneksi, $bulanPertama, $bulanSebelumnya, $dataForm['produk']);

			// get list bulan
			$start    = new DateTime($bulanPertama); // bulan pertama (data ke 1)
			$start->modify('first day of this month');
			$end      = new DateTime($bulanSebelumnya); // bulan terakhir (data ke 36) - bulan sebelum peramalan yg diinginkan
			$end->modify('first day of next month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);

			$listBulan = array();
			foreach ($period as $dt) {
			    $listBulan[] = $dt->format("Y-m");
			}

			// proses penyesuaian nilai data pemesanan dgn list bulan
			$data_pemesanan = array();

		// ======================================= //

		// proses hitung single exponential smoothing
		for($i=0; $i<count($get_dataPemesanan); $i++){
			if($i==0){ // hitung peramalan pertama, f-2
				$hitungPeramalan = $a * $get_dataPemesanan[$i]['jumlah_periode'] + (1 - $a) * $get_dataPemesanan[$i]['jumlah_periode'];
			}
			else{ // hitung peramalan sampai yg diinnginkan, f-37
				$hitungPeramalan = $a * $get_dataPemesanan[$i]['jumlah_periode'] + (1 - $a) * $peramalan[$i];	
			}

			// simpan hasil peramalan
			$peramalan[$i+1] = $hitungPeramalan;
		}

		// proses hitung jumlah bahan baku

		// get komposisi produk
		$get_bahanBaku = getKomposisi_by_id($koneksi, $dataForm['produk']);

		$jumlah_bahanBaku = $get_bahanBaku;

		for($i=0; $i<count($jumlah_bahanBaku); $i++){
			$jumlah_bahanBaku[$i]['jumlah_bahanBaku'] = $hitungPeramalan + ($hitungPeramalan*$jumlah_bahanBaku[$i]['penyusutan']);
		}

		// // hitung safety produk
		// $safety_stock = hitung_safetyStock($hitungPeramalan,)

		$output = array(
			'hasil_peramalan' =>$hitungPeramalan,
			'jumlah_bahan_baku' => $jumlah_bahanBaku,
			// 'safety_stock' => $safety_stock,
		);

		echo json_encode($output);
	}

	function hitung_safetyStock($hasil_peramalan, $nilai_z){
		$l = 1;
		$Sl2 = pow(($l/10), 2);

		$d = $hasil_peramalan / 24;
		$d2 = pow($d, 2);
		$Sd2 = pow(($d/10), 2);

		$sdl = sqrt($d2*$Sl2+$l*$Sd2);
		$ss = $nilai_z * $sdl;

		return $ss;
	}
	