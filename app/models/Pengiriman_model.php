<?php
	function get_datatable_pengiriman($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	function insertPengiriman($koneksi, $data){
		$query = "CALL tambah_pengiriman (:tgl, :id_pemesanan, :id_kendaraan, :colly, :jumlah, :status) ";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':tgl', $data['tgl']);
		$statement->bindParam(':id_pemesanan', $data['id_pemesanan']);
		$statement->bindParam(':id_kendaraan', $data['kendaraan']);
		$statement->bindParam(':colly', $data['colly']);
		$statement->bindParam(':jumlah', $data['jumlah']);
		$statement->bindParam(':status', $data['status_pengiriman']);
		$result = $statement->execute();

		return $result;
	}

	function deletePengiriman($koneksi, $id, $id_pemesanan){
		$query = "CALL hapus_pengiriman (:id, :id_pemesanan)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->bindParam(':id_pemesanan', $id_pemesanan);
		$result = $statement->execute();

		return $result;
	}