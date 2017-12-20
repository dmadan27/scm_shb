<?php
	// get datatable user
	function get_datatable_user($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data supplier
	function get_all_user($koneksi){
		$query = "SELECT * FROM v_user";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	function insertUser($koneksi, $data){
		$query = "CALL tambah_user(:username, :password, :jenis, :status, :pengguna, :hak_akses)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':username', $data['username']);
		$statement->bindParam(':password', $data['password']);
		$statement->bindParam(':jenis', $data['jenis']);
		$statement->bindParam(':status', $data['status']);
		$statement->bindParam(':pengguna', $data['pengguna']);
		$statement->bindParam(':hak_akses', $data['hak_akses']);
		$result = $statement->execute();

		return $result;
	}