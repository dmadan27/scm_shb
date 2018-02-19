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

	// cek duplikat periode dan produk
	function cekDuplikat_perencanaan($koneksi, $periode, $id_produk){
		$query = "SELECT COUNT(*) duplikat FROM perencanaan_bahan_baku WHERE periode=:periode AND id_produk=:id_produk";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':periode', $periode);
		$statement->bindParam(':id_produk', $id_produk);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

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

	// function delete perencanaan
	function deletePerencanaan_bahan_baku($koneksi, $id){
		$query = "DELETE FROM perencanaan_bahan_baku WHERE id = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		return $result;
	}