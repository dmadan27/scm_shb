<?php
	define("base_url", "http://localhost/scm_shb/");

	define("base_hak_akses", 
		array(
			'beranda' => '<li class="menu-beranda"> 
							<a href="'.base_url.'"> 
								<i class="mdi mdi-home fa-fw" data-icon="v"></i> 
								<span class="hide-menu">Beranda</span> 
							</a> 
						</li>',
			// data master //
				'pekerjaan' => '<li class="menu-data-pekerjaan"> 
									<a href="'.base_url.'index.php?m=pekerjaan&p=list"> 
										<i class="mdi mdi-account-card-details fa-fw" data-icon="v"></i> 
										<span class="hide-menu">Data Pekerjaan</span> 
									</a> 
								</li>',
				'karyawan' => '<li class="menu-data-karyawan"> 
									<a href="'.base_url.'index.php?m=karyawan&p=list"> 
										<i class="mdi mdi-account-card-details fa-fw" data-icon="v"></i> 
										<span class="hide-menu">Data Karyawan</span> 
									</a> 
								</li>',
				'supplier' => '<li class="menu-data-supplier"> 
									<a href="'.base_url.'index.php?m=supplier&p=list"> 
										<i class="mdi mdi-account-multiple fa-fw" data-icon="v"></i> 
										<span class="hide-menu">Data Supplier</span> 
									</a> 
								</li>',
				'buyer' => '<li class="menu-data-buyer"> 
								<a href="'.base_url.'index.php?m=buyer&p=list"> 
									<i class="mdi mdi-account-multiple-outline fa-fw" data-icon="v"></i> 
									<span class="hide-menu">Data Buyer</span> 
								</a> 
							</li>',
				'bahan_baku' => '<li class="menu-data-bahan-baku"> 
									<a href="'.base_url.'index.php?m=bahan_baku&p=list"> 
										<i class="mdi mdi-cube-outline fa-fw" data-icon="v"></i> 
										<span class="hide-menu">Data Bahan Baku</span> 
									</a> 
								</li>',
				'produk' => '<li class="menu-data-produk"> 
								<a href="'.base_url.'index.php?m=produk&p=list"> 
									<i class="mdi mdi-cube-outline fa-fw" data-icon="v"></i> 
									<span class="hide-menu">Data Produk</span> 
								</a> 
							</li>',
				'harga_basis' => '<li class="menu-data-harga-basis"> 
									<a href="'.base_url.'index.php?m=harga_basis&p=list"> 
										<i class="mdi mdi-cash-usd fa-fw" data-icon="v"></i> 
										<span class="hide-menu">Data Harga Basis</span> 
									</a> 
								</li>',
				'kendaraan' => '<li class="menu-data-kendaraan"> 
									<a href="'.base_url.'index.php?m=kendaraan&p=list"> 
										<i class="mdi mdi-car fa-fw" data-icon="v"></i> 
										<span class="hide-menu">Data Kendaraan</span> 
									</a> 
								</li>',
				'user' => '<li class="menu-data-user"> 
								<a href="'.base_url.'index.php?m=user&p=list"> 
									<i class="mdi mdi-folder-account fa-fw" data-icon="v"></i> 
									<span class="hide-menu">Data User</span> 
								</a> 
							</li>',
			// =========== //
			'kir' => '<li class="menu-data-kir"> 
						<a href="'.base_url.'index.php?m=kir&p=list"> 
							<i class="mdi mdi-beaker fa-fw" data-icon="v"></i> 
							<span class="hide-menu">Data KIR</span> 
						</a> 
					</li>',
			'analisa_harga' => '<li class="menu-data-analisa-harga"> 
									<a href="'.base_url.'index.php?m=analisa_harga&p=list"> 
										<i class="mdi mdi-calculator fa-fw" data-icon="v"></i> 
										<span class="hide-menu">Data Analisa Harga</span> 
									</a> 
								</li>',
			'pembelian' => '<li class="menu-data-pembelian"> 
								<a href="'.base_url.'index.php?m=pembelian&p=list"> 
									<i class="mdi mdi-cart fa-fw" data-icon="v"></i> 
									<span class="hide-menu">Data Pembelian Bahan Baku</span> 
								</a> 
							</li>',
			'pemesanan' => '<li class="menu-data-pemesanan"> 
								<a href="'.base_url.'index.php?m=pemesanan&p=list"> 
									<i class="mdi mdi-cart-outline fa-fw" data-icon="v"></i> 
									<span class="hide-menu">Data Pemesanan Produk</span> 
								</a> 
							</li>',
			'pengiriman' => '<li class="menu-data-pengiriman"> 
								<a href="'.base_url.'index.php?m=pengiriman&p=list"> 
									<i class="mdi mdi-truck fa-fw" data-icon="v"></i> 
									<span class="hide-menu">Data Pengiriman</span> 
								</a> 
							</li>',
			'perencanaan_bahan_baku' => '<li class="menu-data-perencanaan-bahan-baku"> 
											<a href="'.base_url.'index.php?m=perencanaan_bahan_baku&p=list"> 
												<i class="mdi mdi-chart-line fa-fw" data-icon="v"></i> 
												<span class="hide-menu">Data Perencanaan Pengadaan Bahan Baku</span> 
											</a> 
										</li>',
			// monitoring persediaan //
				'stok_bahan_baku' => '<li class="menu-data-stok-bahan-baku"> 
										<a href="'.base_url.'index.php?m=stok_bahan_baku&p=list"> 
											<i class="mdi mdi-cube-send fa-fw" data-icon="v"></i> 
											<span class="hide-menu">Data Stok Bahan Baku</span> 
										</a> 
									</li>',
				'stok_produk' => '<li class="menu-data-stok-produk"> 
										<a href="'.base_url.'index.php?m=stok_produk&p=list"> 
											<i class="mdi mdi-cube-send fa-fw" data-icon="v"></i> 
											<span class="hide-menu">Data Stok Produk</span> 
										</a> 
									</li>',
				'mutasi_bahan_baku' => '<li class="menu-data-mutasi-bahan-baku"> 
											<a href="'.base_url.'index.php?m=mutasi_bahan_baku&p=list"> 
												<i class="mdi mdi-elevator fa-fw" data-icon="v"></i> 
												<span class="hide-menu">Data Mutasi Bahan Baku</span> 
											</a> 
										</li>',
				'mutasi_produk' => '<li class="menu-data-mutasi-produk"> 
										<a href="'.base_url.'index.php?m=mutasi_produk&p=list"> 
											<i class="mdi mdi-elevator fa-fw" data-icon="v"></i> 
											<span class="hide-menu">Data Mutasi Produk</span> 
										</a> 
									</li>',
			// ========== //
			'produksi' => '<li class="menu-data-produksi"> 
								<a href="'.base_url.'index.php?m=produksi&p=list"> 
									<i class="mdi mdi-factory fa-fw" data-icon="v"></i> 
									<span class="hide-menu">Data Produksi</span> 
								</a> 
							</li>',
		)
	);
	
	function set_hak_akses($hak_akses){
		switch (strtolower($hak_akses)) {
			case 'direktur':
				$set_hakAkses = array(
					'beranda' => array(
							"url" => base_hak_akses['beranda'],
							"aksi" => array(),
						),
					'data_master' => array(
						'pekerjaan' => array(
							"url" => base_hak_akses['pekerjaan'],
							"aksi" => array()
						),
						'karyawan' => array(
							"url" => base_hak_akses['karyawan'],
							"aksi" => array('view',)
						),
						'supplier' => array(
							"url" => base_hak_akses['supplier'],
							"aksi" => array('view',),
						),
						'buyer' => array(
							"url" => base_hak_akses['buyer'],
							"aksi" => array('view',),
						),
						'bahan_baku' => array(
							"url" => base_hak_akses['bahan_baku'],
							"aksi" => array('view',),
						),
						'produk' => array(
							"url" => base_hak_akses['produk'],
							"aksi" => array('view',),
						),
						'harga_basis' => array(
							"url" => base_hak_akses['harga_basis'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
						'kendaraan' => array(
							"url" => base_hak_akses['kendaraan'],
							"aksi" => array('view',),
						),
						'user' => array(
							"url" => base_hak_akses['user'],
							"aksi" => array(),
						),
					),
					'kir' => array(
							"url" => base_hak_akses['kir'],
							"aksi" => array('view',),
						),
					'analisa_harga' => array(
							"url" => base_hak_akses['analisa_harga'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
					'pembelian' => array(
							"url" => base_hak_akses['pembelian'],
							"aksi" => array('view',),
						),
					'pemesanan' => array(
							"url" => base_hak_akses['pemesanan'],
							"aksi" => array('view',),
						),
					'pengiriman' => array(
							"url" => base_hak_akses['pengiriman'],
							"aksi" => array('view',),
						),
					'perencanaan_bahan_baku' => array(
							"url" => base_hak_akses['perencanaan_bahan_baku'],
							"aksi" => array('view',),
						),
					'monitoring_persediaan' => array(
						'stok_bahan_baku' => array(
							"url" => base_hak_akses['stok_bahan_baku'],
							"aksi" => array('view',),
						),
						'stok_produk' => array(
							"url" => base_hak_akses['stok_produk'],
							"aksi" => array('view',),
						),
						'mutasi_bahan_baku' => array(
							"url" => base_hak_akses['mutasi_bahan_baku'],
							"aksi" => array('view',),
						),
						'mutasi_produk' => array(
							"url" => base_hak_akses['mutasi_produk'],
							"aksi" => array('view',),
						),
					),
					'produksi' => array(
							"url" => base_hak_akses['produksi'],
							"aksi" => array('view',),
						),
				);
				break;

			case 'bagian administrasi dan keuangan':
				$set_hakAkses = array(
					'beranda' => array(
							"url" => base_hak_akses['beranda'],
							"aksi" => array(),
						),
					'data_master' => array(
						'pekerjaan' => array(
							"url" => base_hak_akses['pekerjaan'],
							"aksi" => array('tambah', 'edit', 'hapus'),
						),
						'karyawan' => array(
							"url" => base_hak_akses['karyawan'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus', 'status'),
						),
						'supplier' => array(
							"url" => base_hak_akses['supplier'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
						'buyer' => array(
							"url" => base_hak_akses['buyer'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
						'bahan_baku' => array(
							"url" => base_hak_akses['bahan_baku'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
						'produk' => array(
							"url" => base_hak_akses['produk'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
						'harga_basis' => array(
							"url" => base_hak_akses['harga_basis'],
							"aksi" => array('view',),
						),
						'kendaraan' => array(
							"url" => base_hak_akses['kendaraan'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
					),
					'pembelian' => array(
							"url" => base_hak_akses['pembelian'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus', 'status'),
						),
					'pemesanan' => array(
							"url" => base_hak_akses['pemesanan'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus', 'jadwal', 'status'),
						),
					'pengiriman' => array(
							"url" => base_hak_akses['pengiriman'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus', 'status'),
						),
					'monitoring_persediaan' => array(
						'stok_bahan_baku' => array(
							"url" => base_hak_akses['stok_bahan_baku'],
							"aksi" => array(),
						),
						'stok_produk' => array(
							"url" => base_hak_akses['stok_produk'],
							"aksi" => array(),
						),
						'mutasi_bahan_baku' => array(
							"url" => base_hak_akses['mutasi_bahan_baku'],
							"aksi" => array(),
						),
						'mutasi_produk' => array(
							"url" => base_hak_akses['mutasi_produk'],
							"aksi" => array(),
						),
					),
				);
				break;

			case 'bagian gudang':
				$set_hakAkses = array(
					'beranda' => array(
							"url" => base_hak_akses['beranda'],
							"aksi" => array(),
						),
					'data_master' => array(
						'supplier' => array(
							"url" => base_hak_akses['supplier'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
						'bahan_baku' => array(
							"url" => base_hak_akses['bahan_baku'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
						'produk' => array(
							"url" => base_hak_akses['produk'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
					),
					'pemesanan' => array(
							"url" => base_hak_akses['pemesanan'],
							"aksi" => array('view',),
						),
					'perencanaan_bahan_baku' => array(
							"url" => base_hak_akses['perencanaan_bahan_baku'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
					'monitoring_persediaan' => array(
						'stok_bahan_baku' => array(
							"url" => base_hak_akses['stok_bahan_baku'],
							"aksi" => array(),
						),
						'stok_produk' => array(
							"url" => base_hak_akses['stok_produk'],
							"aksi" => array(),
						),
						'mutasi_bahan_baku' => array(
							"url" => base_hak_akses['mutasi_bahan_baku'],
							"aksi" => array(),
						),
						'mutasi_produk' => array(
							"url" => base_hak_akses['mutasi_produk'],
							"aksi" => array(),
						),
					),
				);
				break;

			case 'bagian analisa harga':
				$set_hakAkses = array(
					'beranda' =>  array(
							"url" => base_hak_akses['beranda'],
							"aksi" => array(),
						),
					'data_master' => array(
						'supplier' => array(
							"url" => base_hak_akses['supplier'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
						'bahan_baku' => array(
							"url" => base_hak_akses['bahan_baku'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
						'harga_basis' => array(
							"url" => base_hak_akses['harga_basis'],
							"aksi" => array('view',),
						),
					),
					'kir' => array(
							"url" => base_hak_akses['kir'],
							"aksi" => array('view',),
						),
					'analisa_harga' => array(
							"url" => base_hak_akses['analisa_harga'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
				);
				break;

			case 'bagian kir':
				$set_hakAkses = array(
					'beranda' => array(
							"url" => base_hak_akses['beranda'],
							"aksi" => array(),
						),
					'data_master' => array(
						'supplier' => array(
							"url" => base_hak_akses['supplier'],
							"aksi" => array('view',),
						),
						'bahan_baku' => array(
							"url" => base_hak_akses['bahan_baku'],
							"aksi" => array('view',),
						),
					),
					'kir' => array(
							"url" => base_hak_akses['kir'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
				);
				break;

			case 'bagian teknisi dan operasional':
				$set_hakAkses = array(
					'beranda' => array(
							"url" => base_hak_akses['beranda'],
							"aksi" => array(),
						),
					'data_master' => array(
						'bahan_baku' => array(
							"url" => base_hak_akses['bahan_baku'],
							"aksi" => array('view',),
						),
						'produk' => array(
							"url" => base_hak_akses['produk'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus'),
						),
					),
					'monitoring_persediaan' => array(
						'stok_bahan_baku' => array(
							"url" => base_hak_akses['stok_bahan_baku'],
							"aksi" => array(),
						),
						'stok_produk' => array(
							"url" => base_hak_akses['stok_produk'],
							"aksi" => array(),
						),
						'mutasi_bahan_baku' => array(
							"url" => base_hak_akses['mutasi_bahan_baku'],
							"aksi" => array(),
						),
						'mutasi_produk' => array(
							"url" => base_hak_akses['mutasi_produk'],
							"aksi" => array(),
						),
					),
					'produksi' => array(
							"url" => base_hak_akses['produksi'],
							"aksi" => array('tambah', 'view', 'edit', 'hapus', 'status'),
						),
				);
				break;

			// case 'buyer':
			// 	$set_hakAkses = array(
			// 		'beranda' => base_hak_akses['beranda'],
			// 		'pemesanan' => base_hak_akses['pemesanan'],
			// 		'pengiriman' => base_hak_akses['pengiriman'],
			// 	);
			// 	break;
			
			default: // administrator
				$set_hakAkses = array(
					'beranda' => array(
							"url" => base_hak_akses['beranda'],
							"aksi" => array(),
						),
					'data_master' => array(
						'user' => array(
							"url" => base_hak_akses['user'],
							"aksi" => array('tambah', 'edit', 'hapus', 'status', 'reset'),
						),
					),
				);
				break;
		}

		return $set_hakAkses;
	}

	function set_menu($hak_akses){
		$menu = '';

		foreach($hak_akses as $key => $value){
			if($key == "data_master"){
				$menu .= '<li class="menu-data-master">';
				$menu .= '<a href="javascript:void(0);" class="waves-effect"> <i class="mdi mdi-database fa-fw"></i>';
				$menu .= '<span class="hide-menu"> Data Master <span class="fa arrow"></span> </span> </a>';
				$menu .= '<ul class="nav nav-second-level">';

				foreach($value as $key_2 => $value_2){ 
					foreach($value_2 as $newKey => $newValue){
						if($newKey == "url"){
							$menu .= $newValue;
						}
					}
				}
				$menu .= '</ul></li>';
			}
			else if($key == "monitoring_persediaan"){
				$menu .= '<li class="menu-data-monitoring-persediaan">';
				$menu .= '<a href="javascript:void(0);" class="waves-effect"> <i class="mdi mdi-database fa-fw"></i>';
				$menu .= '<span class="hide-menu"> Data Monitoring Persediaan <span class="fa arrow"></span> </span> </a>';
				$menu .= '<ul class="nav nav-second-level">';

				foreach($value as $key_2 => $value_2){ 
					foreach($value_2 as $newKey => $newValue){
						if($newKey == "url"){
							$menu .= $newValue;
						}
					}
				}
				$menu .= '</ul></li>';
			}
			else{
				foreach($value as $key_2 => $value_2){
					if($key_2 == "url"){
						$menu .= $value_2;
					}
				}
			}
		}

		return $menu;		
	}

	function get_hak_akses($menu, $page, $hak_akses){
		$new_hakAkses = array();

		if($menu==false) return $cek = true;
		else{
			// cek menu dengan hak akses, ada atau tidak
			foreach($hak_akses as $key => $value){
				if($key == "data_master"){
					foreach($value as $key_2 => $value_2){
						$new_hakAkses[$key_2] = $value_2;
					}
				}
				else if($key == "monitoring_persediaan"){
					foreach($value as $key_2 => $value_2){
						$new_hakAkses[$key_2] = $value_2;
					}	
				}
				else{
					$new_hakAkses[$key] = $value;
				}
			}

			$cekMenu = array_key_exists($menu, $new_hakAkses) ? true : false;
			if($page == "form") $cekPage = get_btn_aksi($menu, $hak_akses, false, true) ? true : false;
			else $cekPage = true;

			return $cek = ($cekMenu && $cekPage) ? true : false;
		}
	}

	// get btn aksi
	function get_btn_aksi($menu, $hak_akses, $btnAksi=false, $tambah=false){
		$new_aksi = array();

		// get aksi tiap menu
		foreach($hak_akses as $key => $value){
			if($key == "data_master"){
				foreach($value as $key_2 => $value_2){
					$tempKey = $key_2;
					foreach($value_2 as $newKey => $newValue){
						if($newKey == "aksi"){
							$new_aksi[$tempKey] = $newValue;
						}
					}
				}
			}
			else if($key == "monitoring_persediaan"){
				foreach($value as $key_2 => $value_2){
					$tempKey = $key_2;
					foreach($value_2 as $newKey => $newValue){
						if($newKey == "aksi"){
							$new_aksi[$tempKey] = $newValue;
						}
					}
				}	
			}
			else{
				$tempKey = $key;
				foreach($value as $newKey => $newValue){
					if($newKey == "aksi"){
						$new_aksi[$tempKey] = $newValue;
					}
				}
			}
		}

		// btn aksi di list data
		if($btnAksi){
			foreach($btnAksi as $key => $value){
				$temp = $value;
				foreach($new_aksi[$menu] as $value){
					if($key == $value){
						$new_bntAksi[] = $temp;
					}
				}
			}

			if(!empty($new_bntAksi)){
				$output = '';
				foreach($new_bntAksi as $value){
					$output .= $value;
				}
			} else $output = "";
				
			return $output;
		}
		else if($tambah){
			return $cek = in_array('tambah', $new_aksi[$menu]) ? true : false;
		}
	}

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

	// fungsi untuk cek array list
	function cekArray($data){
		$cekKosong = true;

		foreach($data as $array){
			foreach ($array as $key => $value) {
				if($key == "status"){
					if($value != "hapus") $cekKosong = false;
				}
			}
		}

		return $cekKosong; // true --> list kosong, false --> ada isinya.
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
			$dataList .= "<li><i class='ti-angle-right'></i>".strtoupper($list)."</li>";
		}
		$dataList .= "</ul>";

		return $dataList;
	}

	// fungsi ubah nilai kosong menjadi -
	function gantiKosong($data){
		$tempData = $data=="" ? "-" : $data;
		return $tempData;
	}