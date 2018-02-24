<?php
	date_default_timezone_set('Asia/Jakarta');

	include_once("../function/helper.php");
	include_once("../function/koneksi.php");

	// fungsi get semua kendaraan
	function getAll_kendaraan($koneksi){
		$query = "SELECT id id_kendaraan, no_polis, muatan FROM kendaraan";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// fungsi get kendaraan by tgl
	function getKendaraan_byTgl($koneksi, $tgl){
		$query = "SELECT k.id id_kendaraan, k.no_polis, k.muatan ";
		$query .= "FROM kendaraan k JOIN pengiriman p ON p.id_kendaraan = k.id WHERE p.tgl = :tgl";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':tgl', $tgl);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// fungsi get total muatan kendaraan
	function getTotal_muatan($koneksi){
		$query = "SELECT SUM(muatan) total_muatan FROM kendaraan";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// fungsi get total pengiriman pada suatu tgl
	function getTotal_pengiriman_byTgl($koneksi, $tgl){
		$query = "SELECT SUM(k.muatan) total_muatan, SUM(p.jumlah) total_pengiriman FROM pengiriman p JOIN kendaraan k ON k.id = p.id_kendaraan WHERE tgl = :tgl GROUP BY(tgl)";
	}

	// function get kendaraan ready (yang tidak ada jadwal/tidak berangkat)
	function getKendaraan_ready($koneksi, $tgl){
		$data_kendaraan = getAll_kendaraan($koneksi);
		$data_kendaraan_berangkat = getKendaraan_byTgl($koneksi, $tgl);
		$data_kendaraan_ready = array();
		
		// pecah data kendaraan
		$temp_kendaraan = array();
		foreach($data_kendaraan as $index => $data){
			foreach($data as $key => $value){
				if($key === "id_kendaraan"){
					$temp_kendaraan[$index] = $value;
				}
			}
		}

		// pecah data kendaraan yg berangkat atau yg ada jadwal
		$temp_berangkat = array();
		foreach($data_kendaraan_berangkat as $index => $data){
			foreach($data as $key => $value){
				if($key === "id_kendaraan"){
					$temp_berangkat[$index] = $value;
				}
			}
		}

		// bandingkan kendaraan dengan kendaraan berangkat
		$temp_ready = array_diff($temp_kendaraan, $temp_berangkat);

		// set data kendaraan ready
		foreach($temp_ready as $key => $value){
			$data_kendaraan_ready[] = $data_kendaraan[$key];
		}

		$output = array(
			'data_kendaraan' => $data_kendaraan,
			'data_kendaraan_berangkat' => $data_kendaraan_berangkat,
			'data_kendaraan_ready' => $data_kendaraan_ready,
		);

		return $output;
	}
	// echo "<pre>";
	// print_r(getKendaraan_ready($koneksi, "2018-02-11")['data_kendaraan_ready']);
	// echo "</pre>";

	/*
		1. 	Tentukan prediksi pengiriman
			Waktu yang dibutuhkan = total pesanan / total muatan
	*/

	// total muatan yang dimiliki
	$total_muatan = getTotal_muatan($koneksi)['total_muatan'];
			
	// keterangan info kontrak
	$total_pesanan = 50000;
	$awal_pengiriman = new DateTime("2018-02-22");
	$batas_pengiriman = new DateTime("2018-02-25");
	$batas_pengiriman->add(new DateInterval('P1D'));
	$waktu_pengiriman = $awal_pengiriman->diff($batas_pengiriman)->d;

	$waktu_yang_dibutuhkan = ceil($total_pesanan / $total_muatan);

	/*
		2.	Get tgl pengiriman
			sesuaikan dengan jadwal pengiriman dan waktu yang dibutuhkan
	*/

	// get list tgl kontrak
	$interval = DateInterval::createFromDateString('1 day');
	$periode_tgl = new DatePeriod($awal_pengiriman, $interval, $batas_pengiriman);

	$list_tgl = array();
	foreach($periode_tgl as $tgl){
		$list_tgl[$tgl->format("Y-m-d")] = $tgl->format("Y-m-d");
	}

	/*
		3.	cek tgl satu persatu
			get tgl baru untuk insert
	*/
	// echo "<pre>";
	// print_r($list_tgl);
	// echo "</pre>";

	// echo "<br>";

	$newlist_tgl = array();
	foreach($list_tgl as $key => $value){
		$tgl = new DateTime($value);

		// cek tgl
		while(empty(getKendaraan_ready($koneksi, $tgl->format("Y-m-d"))['data_kendaraan_ready'])){
			// +1 hari
			$tgl->add(new DateInterval('P1D'));
			if(array_key_exists($tgl->format("Y-m-d"), $newlist_tgl)){
				// +1 hari
				$tgl->add(new DateInterval('P1D'));	
			}								
		}

		// insert pengiriman
		$newlist_tgl[$tgl->format("Y-m-d")] = $tgl->format("Y-m-d");
	}

	// echo "<pre>";
	// print_r($newlist_tgl);
	// echo "</pre>";
	
	/*
		
	*/