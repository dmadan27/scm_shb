<?php
	// get all data kendaraan
	function get_all_kendaraan($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		// tutup_koneksi($koneksi);

		return $result;
	}