<?php
	$data_penjualan = array(
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
		150.5,
	);

	$peramalan = array(0);

	$a = 0.9;

	// var_dump(count($data_penjualan));


	// tentukan jumlah data yang akan digunakan
	$jumlah_data = count($data_penjualan);

	// $i = 0;
	// foreach($data_penjualan as $value){
	// 	if($i==0){ // hitung peramalan pertama, f-2
	// 		$hitungPeramalan = $a * $data_penjualan[$i] + (1 - $a) * $data_penjualan[$i];
	// 	}
	// 	else{ // hitung peramalan sampai yg diinnginkan, f-37
	// 		$hitungPeramalan = $a * $data_penjualan[$i] + (1 - $a) * $peramalan[$i];	
	// 	}

	// 	// simpan hasil peramalan
	// 	$peramalan[$i+1] = $hitungPeramalan;
	// 	// $peramalan[$i+1] = number_format($hitungPeramalan,2);

	// 	$i++;
	// }

	for($i=0; $i<count($data_penjualan); $i++){
		if($i==0){ // hitung peramalan pertama, f-2
			$hitungPeramalan = $a * $data_penjualan[$i] + (1 - $a) * $data_penjualan[$i];
		}
		else{ // hitung peramalan sampai yg diinnginkan, f-37
			$hitungPeramalan = $a * $data_penjualan[$i] + (1 - $a) * $peramalan[$i];	
		}

		// simpan hasil peramalan
		$peramalan[$i+1] = $hitungPeramalan;
		// $peramalan[$i+1] = number_format($hitungPeramalan,2);
	}

	// var_dump($peramalan);
	foreach($peramalan as $value){
		echo number_format($value, 2, ',', '.').' <br>';
	}

	