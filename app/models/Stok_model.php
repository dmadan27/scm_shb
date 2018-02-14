<?php
	function get_datatable_stok_bahan_baku($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	function get_datatable_stok_produk($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	function get_safetyStock_produk($koneksi, $id_produk, $periode){
		$query = "SELECT safety_stok_produk FROM perencanaan_bahan_baku WHERE id_produk=:id_produk AND periode=:periode";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id_produk', $id_produk);
		$statement->bindParam(':periode', $periode);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

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

		// return empty($result) ? false : $result;
		return $result;
	}