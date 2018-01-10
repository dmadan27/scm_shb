<?php
	// get datatable data pemesanan
	function get_datatable_pemesanan($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get data pemesanan yg sukses
	function getPemesanan_sukses($koneksi, $bulanPertama, $bulanSebelumnya, $produk){
		$bulanSebelumnya = $bulanSebelumnya;
		$bulanPertama = $bulanPertama;

		$query = "SELECT DATE_FORMAT(tgl, '%Y-%m') periode, SUM(jumlah) jumlah_periode ";
		$query .= "FROM v_pemesanan WHERE (DATE_FORMAT(tgl, '%Y-%m') BETWEEN :bulanPertama AND :bulanSebelumnya) AND id_produk =:produk ";
		$query .= "GROUP BY YEAR(tgl), MONTH(tgl) ORDER BY YEAR(tgl) ASC, MONTH(tgl) ASC";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':bulanPertama', $bulanPertama);
		$statement->bindParam(':bulanSebelumnya', $bulanSebelumnya);
		$statement->bindParam(':produk', $produk);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}