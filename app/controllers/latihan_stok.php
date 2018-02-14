<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	// include_once("../models/Stok_model.php");
	// include_once("../models/Perencanaan_bahan_baku_model.php");

	function getKomposisi_by_id($koneksi, $id){
		$query = "SELECT k.id id_komposisi, p.id id_produk, p.kd_produk, p.nama nama_produk, ";
		$query .= "b.id id_bahan_baku, b.nama nama_bahan_baku, b.kd_bahan_baku, b.satuan satuan_bahan_baku, k.penyusutan ";
		$query .= "FROM komposisi k JOIN produk p ON p.id = k.id_produk ";
		$query .= "JOIN bahan_baku b ON b.id = k.id_bahan_baku WHERE k.id_bahan_baku=:id ";
		$query .= "ORDER BY k.id_bahan_baku ASC";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	function getPerencanaan_produk_by_bahanBaku($koneksi, $id_bahan_baku, $periode){
		$query = "SELECT pbb.periode, pbb.id_produk, p.kd_produk, p.nama nama_produk, ";
		$query .= "pbb.jumlah_perencanaan, pbb.safety_stok_produk, ";
		$query .= "k.id_bahan_baku, bb.kd_bahan_baku, bb.nama nama_bahan_baku, bb.satuan, k.penyusutan ";
		$query .= "FROM perencanaan_bahan_baku pbb JOIN produk p on p.id = pbb.id_produk ";
		$query .= "JOIN komposisi k on k.id_produk = p.id JOIN bahan_baku bb on bb.id = k.id_bahan_baku ";
		$query .= "WHERE k.id_bahan_baku = :id_bahan_baku and periode = :periode";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id_bahan_baku', $id_bahan_baku);
		$statement->bindParam(':periode', $periode);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;	
	}

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

	// get produk yang memakai bahan baku tertentu
	$id_bahan_baku = 3;
	$periode = "2017-01";

	// get perencanaan produk yang dipilih
	if(empty(getPerencanaan_produk_by_bahanBaku($koneksi, $id_bahan_baku, $periode))){
		echo "gak ada hasil";
	}
	else{
		echo "ada hasil<br>";
		// var_dump(getPerencanaan_produk_by_bahanBaku($koneksi, $id_bahan_baku, $periode));

		// hitung jumlah perencanaan dan safety stoknya
		var_dump(hitung_jumlah_safety_stok_bahanBaku(getPerencanaan_produk_by_bahanBaku($koneksi, $id_bahan_baku, $periode)));
	}

