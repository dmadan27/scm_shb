<?php
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

	$dataPemesanan = array(
		array(
			'periode' => '2014-01',
			'jumlah_periode' => 259.86,
		),
		array(
			'periode' => '2014-02',
			'jumlah_periode' => 255.73,
		),
		array(
			'periode' => '2014-03',
			'jumlah_periode' => 185.88,
		),
		array(
			'periode' => '2014-04',
			'jumlah_periode' => 476.45,
		),
		array(
			'periode' => '2014-05',
			'jumlah_periode' => 1814.27,
		),
		array(
			'periode' => '2014-06',
			'jumlah_periode' => 2046.57,
		),
		array(
			'periode' => '2014-07',
			'jumlah_periode' => 1842.25,
		),
		array(
			'periode' => '2014-08',
			'jumlah_periode' => 732.69,
		),
		array(
			'periode' => '2014-09',
			'jumlah_periode' => 775.22,
		),
		array(
			'periode' => '2014-10',
			'jumlah_periode' => 220.93,
		),
		array(
			'periode' => '2014-11',
			'jumlah_periode' => 50.26,
		),
		array(
			'periode' => '2014-12',
			'jumlah_periode' => 50.12,
		),
		array(
			'periode' => '2015-01',
			'jumlah_periode' => 120.58,
		),
		array(
			'periode' => '2015-02',
			'jumlah_periode' => 60.77,
		),
		array(
			'periode' => '2015-03',
			'jumlah_periode' => 100.85,
		),
		array(
			'periode' => '2015-04',
			'jumlah_periode' => 463.69,
		),
		array(
			'periode' => '2015-05',
			'jumlah_periode' => 1842,
		),
		array(
			'periode' => '2015-06',
			'jumlah_periode' => 3407.83,
		),
		array(
			'periode' => '2015-07',
			'jumlah_periode' => 3081.81,
		),
		array(
			'periode' => '2015-08',
			'jumlah_periode' => 2650.12,
		),
		array(
			'periode' => '2015-09',
			'jumlah_periode' => 1142.17,
		),
		array(
			'periode' => '2015-10',
			'jumlah_periode' => 425.04,
		),
		array(
			'periode' => '2015-11',
			'jumlah_periode' => 152.53,
		),
		array(
			'periode' => '2015-12',
			'jumlah_periode' => 45,
		),
		array(
			'periode' => '2016-01',
			'jumlah_periode' => 100.17,
		),
		array(
			'periode' => '2016-02',
			'jumlah_periode' => 200.94,
		),
		array(
			'periode' => '2016-03',
			'jumlah_periode' => 100.85,
		),
		array(
			'periode' => '2016-04',
			'jumlah_periode' => 50.13,
		),
		array(
			'periode' => '2016-05',
			'jumlah_periode' => 581.54,
		),
		array(
			'periode' => '2016-06',
			'jumlah_periode' => 130.48,
		),
		array(
			'periode' => '2016-07',
			'jumlah_periode' => 4134.67,
		),
		array(
			'periode' => '2016-08',
			'jumlah_periode' => 2251.93,
		),
		array(
			'periode' => '2016-09',
			'jumlah_periode' => 4870.26,
		),
		array(
			'periode' => '2016-10',
			'jumlah_periode' => 3482.96,
		),
		array(
			'periode' => '2016-11',
			'jumlah_periode' => 1000.12,
		),
		array(
			'periode' => '2016-12',
			'jumlah_periode' => 60.32,
		),
	);

	$array = array(

	);

	$peramalan = array(0);

	// $j = 0;

	// pecah array alpha
	foreach($arrayAlpha as $key => $alpha){
		$tempGalatKuadrat = array();
		// lakukan perhitungan peramalan
		for($i=0; $i<count($dataPemesanan); $i++){
			if($i==0){
				$hitungPeramalan=round(($alpha*$dataPemesanan[$i]['jumlah_periode'])+((1-$alpha)*$dataPemesanan[$i]['jumlah_periode']), 2, PHP_ROUND_HALF_UP);
				$peramalan[$i+1] = $hitungPeramalan;
			}
			else{
				$hitungPeramalan=round(($alpha*$dataPemesanan[$i]['jumlah_periode'])+((1-$alpha)*$peramalan[$i]), 2);
				$galat=$dataPemesanan[$i]['jumlah_periode']-$peramalan[$i];
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
		// $hasilPeramalan[$key]['nilaiMSE'] = hitung_MSE($arrayGalatKuadrat[$j]);
		// $j++;
	}

	foreach ($hasilPeramalan as $key => $array) {
		echo $key.": ";
		echo "<br>";
		foreach($array as $key => $value){
			if($key == "peramalan"){
				echo $key.": ";
				foreach($value as $peramalan){
					echo $peramalan;
					echo ", ";
				}
				echo "<br>";
			}
			if($key == "hasilPeramalan"){
				echo $key.": ".$value;
				echo "<br>";
			}
			if($key == "nilaiMSE"){
				echo $key.": ".$value;
				echo "<br>";

				// echo $key.": ";
				// foreach($value as $nilai_MSE){
				// 	echo $nilai_MSE;
				// 	echo ", ";
				// }
				// echo "<br>";
			}
		}
		echo "<br>";
	}

	// $min_MSE = array_keys($arrayGalatKuadrat_2, min($arrayGalatKuadrat_2));
	$min_MSE = array_search(min($arrayGalatKuadrat_2), $arrayGalatKuadrat_2);
	echo "Nilai MSE Terkecil: ".$hasilPeramalan[$min_MSE]['nilaiMSE'];
	// var_dump($min_MSE);



	// var_dump($arrayGalatKuadrat_2);
	// foreach($hasilPeramalan['alpha_0.9']['nilaiMSE'] as $value){
	// 	echo $value."<br>";
	// }

	function hitung_MSE($nilai_MSE){
		$mse = 0;
		foreach($nilai_MSE as $value){
			$mse += $value;
		}
		$mse = $mse/count($nilai_MSE);

		return round($mse, 2);
		// return count($nilai_MSE);
	}