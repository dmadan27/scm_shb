<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");
	include_once("../library/datatable.php");

	include_once("../models/Stok_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$id = isset($_POST['id']) ? $_POST['id'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'list_stok_bahan_baku':
				listStok_bahan_baku($koneksi);
				break;

			case 'list_stok_produk':
				listStok_produk($koneksi);
				break;

			default:
				die("error");
				break;
		}
	}

	function listStok_bahan_baku($koneksi){
		$config_db = array(
			'tabel' => 'bahan_baku',
			'kolomOrder' => array(null, 'kd_bahan_baku', 'nama', null, 'stok_akhir', null, null, null),
			'kolomCari' => array('kd_bahan_baku', 'nama', 'satuan', 'ket', 'stok_akhir'),
			'orderBy' => array('id' => 'asc'),
			'kondisi' => false,
		);

		$data_stok = get_datatable_stok_bahan_baku($koneksi, $config_db);
		$periode_param = date('Y-m');

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_stok as $row){
			$no_urut++;
			if(empty(getPerencanaan_produk_by_bahanBaku($koneksi, $row['id'], '2017-01'))){
				$jumlah_perencanaan = $safety_stok_bahan_baku = $jumlah_yang_dibutuhkan = "0";
				$status = '<span class="label label-warning label-rouded">BELUM DIRENCANAKAN</span>';
			}
			else{
				$hitung_jumlah = hitung_jumlah_safety_stok_bahanBaku(getPerencanaan_produk_by_bahanBaku($koneksi, $row['id'], '2017-01'));
				$jumlah_perencanaan = $hitung_jumlah['jumlah_bahanBaku'];
				$safety_stok_bahan_baku = $hitung_jumlah['safety_stok_bahan_baku'];
				$jumlah_yang_dibutuhkan = (($jumlah_perencanaan - ($row['stok_akhir'] + $safety_stok_bahan_baku))) < 0 ? "0" : ($jumlah_perencanaan - ($row['stok_akhir'] + $safety_stok_bahan_baku));

				$status = ($row['stok_akhir'] >= $jumlah_yang_dibutuhkan) ? '<span class="label label-success label-rouded">AMAN</span>' : '<span class="label label-danger label-rouded">TIDAK AMAN</span>';
			}

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['kd_bahan_baku'];
			$dataRow[] = $row['nama'];
			$dataRow[] = cetakAngka($jumlah_perencanaan)." ".$row['satuan'];
			$dataRow[] = cetakAngka($safety_stok_bahan_baku)." ".$row['satuan'];
			$dataRow[] = cetakAngka($row['stok_akhir'])." ".$row['satuan'];
			$dataRow[] = cetakAngka($jumlah_yang_dibutuhkan)." ".$row['satuan'];
			$dataRow[] = $status;
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

	function listStok_produk($koneksi){
		$config_db = array(
			'tabel' => 'v_produk',
			'kolomOrder' => array(null, 'kd_produk', 'nama', null, null, 'stok_akhir', null, null),
			'kolomCari' => array('kd_produk', 'nama', 'satuan', 'ket', 'stok_akhir'),
			'orderBy' => array('id' => 'asc'),
			'kondisi' => false,
		);

		$data_stok = get_datatable_stok_produk($koneksi, $config_db);
		$periode_param = date('Y-m');

		$data = array();
		$no_urut = $_POST['start'];
		foreach($data_stok as $row){
			$no_urut++;

			// get safety stock produk
			if(get_perencanaanProduk($koneksi, $row['id'], '2017-01')){
				$data_perencanaan = get_perencanaanProduk($koneksi, $row['id'], '2017-01');
				$jumlah_perencanaan = $data_perencanaan['jumlah_perencanaan'];
				$safety_stock = $data_perencanaan['safety_stok_produk'];
				$jumlah_yang_dibutuhkan = (($jumlah_perencanaan - ($row['stok_akhir'] + $safety_stock))) < 0 ? "0" : ($jumlah_perencanaan - ($row['stok_akhir'] + $safety_stock));
				$status = ($row['stok_akhir'] < $safety_stock) ? '<span class="label label-danger label-rouded">TIDAK AMAN</span>' : '<span class="label label-success label-rouded">AMAN</span>';
			}
			else{
				$jumlah_perencanaan = $safety_stock = $jumlah_yang_dibutuhkan = "0";
				$status = '<span class="label label-warning label-rouded">BELUM DIRENCANAKAN</span>';
			}

			$dataRow = array();
			$dataRow[] = $no_urut;
			$dataRow[] = $row['kd_produk'];
			$dataRow[] = $row['nama'];
			$dataRow[] = cetakAngka($jumlah_perencanaan)." ".$row['satuan']; // jumlah perencanaan
			$dataRow[] = cetakAngka($safety_stock)." ".$row['satuan']; // safety stock
			$dataRow[] = cetakAngka($row['stok_akhir'])." ".$row['satuan'];
			$dataRow[] = cetakAngka($jumlah_yang_dibutuhkan)." ".$row['satuan']; // jumlah yang dibutuhkan
			$dataRow[] = $status; // status
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

	// get safety stock produk
	function get_perencanaanProduk($koneksi, $id_produk, $periode){
		$data_perencanaan = get_perencanaan_produk($koneksi, $id_produk, $periode);

		return ($data_perencanaan) ? $data_perencanaan : false;
	}

	// hitung jumlah bahan baku total dan safety stock bahan baku total
	function hitung_jumlah_safety_stok_bahanBaku($data){
		// proses hitung jumlah bahan baku
		$jumlah_bahanBaku = $safety_stok_bahan_baku = 0;
		for($i=0; $i<count($data); $i++){
			$jumlah_bahanBaku += round($data[$i]['jumlah_perencanaan'] + ($data[$i]['jumlah_perencanaan']*$data[$i]['penyusutan']), 2);
			$safety_stok_bahan_baku += round($data[$i]['safety_stok_produk'] + ($data[$i]['safety_stok_produk']*$data[$i]['penyusutan']), 2);
		}

		$output = array(
			'jumlah_bahanBaku' => $jumlah_bahanBaku,
			'safety_stok_bahan_baku' => $safety_stok_bahan_baku,
		);

		return $output;
	}