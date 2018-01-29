<?php
	// get datatable data perencanaan
	function get_datatable_perencanaan_bahan_baku($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data perencanaan

	// function insert
	function insertPerencanaan_bahan_baku($koneksi, $data){
		$query = "INSERT INTO perencanaan_bahan_baku (tgl, periode, id_produk, jumlah_perencanaan, safety_stok_produk) ";
		$query .= "VALUES (:tgl, :periode, :produk, :hasil_perencanaan, :safety_stock_produk)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':tgl', $data['tgl']);
		$statement->bindParam(':periode', $data['periode']);
		$statement->bindParam(':produk', $data['produk']);
		$statement->bindParam(':hasil_perencanaan', $data['hasil_perencanaan']);
		$statement->bindParam(':safety_stock_produk', $data['safety_stock_produk']);
		$result = $statement->execute();

		return $result;
	}