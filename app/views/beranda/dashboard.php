<?php
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
	switch (strtolower($sess_hak_akses)) {
		case 'direktur':
			include_once("direktur/beranda.php");
			break;

		case 'bagian administrasi dan keuangan':
			include_once("administrasi_keuangan/beranda.php");
			break;

		case 'bagian gudang':
			include_once("gudang/beranda.php");
			break;

		case 'bagian analisa harga':
			include_once("analisa_harga/beranda.php");
			break;

		case 'bagian kir':
			include_once("kir/beranda.php");
			break;

		case 'bagian teknisi dan operasional':
			include_once("teknisi_operasional/beranda.php");
			break;

		case 'buyer':
			include_once("buyer/beranda.php");
			break;
		
		default: // administrator
			include_once("administrator/beranda.php");
			break;
	}	
?>