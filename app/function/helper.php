<?php
	define("base_url", "http://localhost/scm_shb/");

	define("base_hak_akses", 
		array(
			'beranda' => '<li class="menu-beranda"> <a href="'.base_url.'"> <i class="mdi mdi-home fa-fw" data-icon="v"><i/> <span class="hide-menu">Beranda</span> </a> </li>',
			// data master //
				'pekerjaan' => '<li class="menu-data-pekerjaan"> <a href="'.base_url.'index.php?m=pekerjaan&p=list"> <i class="mdi mdi-account-card-details fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Pekerjaan</span> </a> </li>',
				'karyawan' => '<li class="menu-data-karyawan"> <a href="'.base_url.'index.php?m=karyawan&p=list"> <i class="mdi mdi-home fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Karyawan</span> </a> </li>',
				'kendaraan' => '<li class="menu-data-kendaraan"> <a href="'.base_url.'index.php?m=kendaraan&p=list"> <i class="mdi mdi-car fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Kendaraan</span> </a> </li>',
				'barang' => '<li class="menu-data-barang"> <a href="'.base_url.'index.php?m=barang&p=list"> <i class="mdi mdi-cube-outline fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Barang</span> </a> </li>',
				'supplier' => '<li class="menu-data-supplier"> <a href="'.base_url.'index.php?m=supplier&p=list"> <i class="mdi mdi-account-multiple fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Supplier</span> </a> </li>',
				'buyer' => '<li class="menu-data-buyer"> <a href="'.base_url.'index.php?m=buyer&p=list"> <i class="mdi mdi-account-multiple-outline fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Buyer</span> </a> </li>',
				'user' => '<li class="menu-data-user"> <a href="'.base_url.'index.php?m=user&p=list"> <i class="mdi mdi-folder-account fa-fw" data-icon="v"><i/> <span class="hide-menu">Data User</span> </a> </li>',
			// =========== //
			'kir' => '<li class="menu-data-kir"> <a href="'.base_url.'index.php?m=user&p=list"> <i class="mdi mdi-folder-account fa-fw" data-icon="v"><i/> <span class="hide-menu">Data User</span> </a> </li>',
			'analisa_harga' => '<li class="menu-data-analisa-harga"> <a href="'.base_url.'index.php?m=analisa&p=list"> <i class="mdi mdi-folder-account fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Analisa Harga</span> </a> </li>',
			'pembelian' => '<li class="menu-data-pembelian"> <a href="'.base_url.'index.php?m=user&p=list"> <i class="mdi mdi-folder-account fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Pembelian</span> </a> </li>',
			'pemesanan' => '<li class="menu-data-pemesanan"> <a href="'.base_url.'index.php?m=user&p=list"> <i class="mdi mdi-folder-account fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Pemesanan</span> </a> </li>',
			'pengiriman' => '<li class="menu-data-pengiriman"> <a href="'.base_url.'index.php?m=user&p=list"> <i class="mdi mdi-folder-account fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Pengiriman</span> </a> </li>',
			'mutasi_barang' => '<li class="menu-data-mutasi-barang"> <a href="'.base_url.'index.php?m=user&p=list"> <i class="mdi mdi-folder-account fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Mutasi Barang</span> </a> </li>',
			'produksi' => '<li class="menu-data-produksi"> <a href="'.base_url.'index.php?m=user&p=list"> <i class="mdi mdi-folder-account fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Produksi</span> </a> </li>',
			'peramalan' => '<li class="menu-data-peramalan"> <a href="'.base_url.'index.php?m=user&p=list"> <i class="mdi mdi-folder-account fa-fw" data-icon="v"><i/> <span class="hide-menu">Data Peramalan</span> </a> </li>',
		)
	);

	function cekDuplikat($koneksi, $config_db){
		$tabel = $config_db['tabel'];
		$field = $config_db['field'];
		$value = $config_db['value'];

		if($value === "") $cek = false;
		else{
			$query = "SELECT COUNT(*) FROM $tabel WHERE $field=?";

			// prepare
			$statement = $koneksi->prepare($query);
			// bind
			$statement->bindParam(1, $value);
			// execute
			$statement->execute();
			$result = $statement->fetch();

			if($result[0] > 0) $cek = true; // jika duplikat
			else $cek = false; // jika tidak
		}

		return $cek;
	}

	//fungsi format rupiah
	function rupiah($harga){
		$string = "Rp. ".number_format($harga,2,",",".");
		return $string;
	}

	function get_bulanIndo($bulan){
		$arrBulan = array(
					1 => "Januari",
					2 => "Februari",
					3 => "Maret",
					4 => "April",
					5 => "Mei",
					6 => "Juni",
					7 => "Juli",
					8 => "Agustus",
					9 => "September",
					10 => "Oktober",
					11 => "November",
					12 => "Desember",
				);
		$get_bulan = $arrBulan[(int)$bulan];

		return $get_bulan;
	}

	//fungsi format tgl indo
	function cetakTgl($tgl, $format){
		//array hari
		$arrHari = array(
					1 => "Senin",
					2 => "Selasa",
					3 => "Rabu",
					4 => "Kamis",
					5 => "Jumat",
					6 => "Sabtu",
					7 => "Minggu",
				);
		
		//explode $tgl
		$split = explode("-", $tgl);
		$getTgl = $split[2]; //get tgl
		$getBulan = $split[1]; //get bulan
		$getTahun = $split[0]; //get tahun

		$tgl_indo = $getTgl." ".get_bulanIndo($getBulan)." ".$getTahun; //format dd bulan tahun
		$num = date('N', strtotime($tgl)); //get tgl untuk disesuaikan dgn hari

		switch ($format) {
			case 'dd-mm-yyyy': // 27-02-2018
				$cetak_tgl = $getTgl."-".$getBulan."-".$getTahun;
				break;
			
			case 'yyyy-mm-dd': // 2018-02-27
				$cetak_tgl = $getTahun."-".$getBulan."-".$getTgl;
				break;

			case 'd-m-y': // 27 Februari 2018
				$cetak_tgl = $tgl_indo;
				break;

			case 'yyyymmdd':
				$cetak_tgl = $getTahun.$getBulan.$getTgl;
				break;

			case 'full': // Senin, 27 Februari 2018
			default:
				$cetak_tgl = $arrHari[$num].", ".$tgl_indo;
				break;
		}

		return $cetak_tgl; 
	}

	// fungsi cetak list item
	function cetakListItem($dataItem){
		$array = explode(',', $dataItem);
		$array = array_map('trim', $array);

		$dataList = "<ul class='list-icons'>";
		foreach($array as $list){
			$dataList .= "<li><i class='ti-angle-right'></i>MENU ".strtoupper($list)."</li>";
		}
		$dataList .= "</ul>";

		return $dataList;
	}

	// fungsi ubah nilai kosong menjadi -
	function gantiKosong($data){
		$tempData = $data=="" ? "-" : $data;
		return $tempData;
	}