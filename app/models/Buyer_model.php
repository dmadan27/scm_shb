<?php
	// get datatable data buyer
	function get_datatable_buyer($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data buyer
	function get_all_buyer($koneksi){
		$query = "SELECT * FROM v_buyer";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}