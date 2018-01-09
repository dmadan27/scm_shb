<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Peramalan_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list':
				listPeramalan($koneksi);
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
				hitung_peramalan();
				break;

			default:
				# code...
				break;
		}
	}

	// fungsi list peramalan
	function listPeramalan($koneksi){
		$config_db = array(
			'tabel' => 'v_peramalan',
			'kolomOrder' => array(null, 'tgl', 'periode', 'nama_produk', 'hasil_peramalan',null, null),
			'kolomCari' => array('tgl', 'periode', 'nama_produk', 'kd_produk', 'hasil_peramalan', 'jumlah_bahan_baku'),
			'orderBy' => false,
			'kondisi' => false,
		);

		$data_peramalan = get_datatable_peramalan($koneksi, $config_db);

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

	function hitung_peramalan(){
		// inisialisasi awal
		$peramalan = array(0);
		$a = 0.9;

		// get data pemesanan / penjualan
		$data_pemesanan = array(
			259.86,
			255.73,
			185.88,
			476.45,
			1814.27,
			2046.57,
			1842.25,
			732.69,
			775.22,
			220.93,
			50.26,
			50.12,
			120.58,
			60.77,
			100.85,
			463.69,
			1842,
			3407.83,
			3081.81,
			2650.12,
			1142.17,
			425.04,
			152.53,
			45,
			100.17,
			200.94,
			100.85,
			50.13,
			581.54,
			130.48,
			4134.67,
			2251.93,
			4870.26,
			3482.96,
			1000.12,
			60.32,
			// 150.5,
		);

		// proses hitung single exponential smoothing
		for($i=0; $i<count($data_pemesanan); $i++){
			if($i==0){ // hitung peramalan pertama, f-2
				$hitungPeramalan = $a * $data_pemesanan[$i] + (1 - $a) * $data_pemesanan[$i];
			}
			else{ // hitung peramalan sampai yg diinnginkan, f-37
				$hitungPeramalan = $a * $data_pemesanan[$i] + (1 - $a) * $peramalan[$i];	
			}

			// simpan hasil peramalan
			$peramalan[$i+1] = $hitungPeramalan;
			// $peramalan[$i+1] = number_format($hitungPeramalan,2);
		}

		// proses hitung jumlah bahan baku

		// get komposisi produk

		$arrBahanBaku = array();

		$jumlah_bahan_baku = $hitungPeramalan + ($hitungPeramalan*0.05);

		$output = array(
			'hasil_peramalan' => number_format($hitungPeramalan, 2, ',', '.'),
			'jumlah_bahan_baku' => number_format($jumlah_bahan_baku, 2, ',', '.'),
		);

		echo json_encode($output);
	}

	

	

	// // var_dump(count($data_penjualan));


	// // tentukan jumlah data yang akan digunakan
	// $jumlah_data = count($data_penjualan);

	// for($i=0; $i<count($data_penjualan); $i++){
	// 	if($i==0){ // hitung peramalan pertama, f-2
	// 		$hitungPeramalan = $a * $data_penjualan[$i] + (1 - $a) * $data_penjualan[$i];
	// 	}
	// 	else{ // hitung peramalan sampai yg diinnginkan, f-37
	// 		$hitungPeramalan = $a * $data_penjualan[$i] + (1 - $a) * $peramalan[$i];	
	// 	}

	// 	// simpan hasil peramalan
	// 	$peramalan[$i+1] = $hitungPeramalan;
	// 	// $peramalan[$i+1] = number_format($hitungPeramalan,2);
	// }

	// // var_dump($peramalan);
	// foreach($peramalan as $value){
	// 	echo number_format($value, 2, ',', '.').' <br>';
	// }

	