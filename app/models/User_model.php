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
		$query = "INSERT INTO user (username, password, id_karyawan, hak_akses, status) VALUES (:username, :password, :id_karyawan, :hak_akses, :status)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':username', $data['username']);
		$statement->bindParam(':password', $data['password']);
		$statement->bindParam(':id_karyawan', $data['pengguna']);
		$statement->bindParam(':hak_akses', $data['hak_akses']);
		$statement->bindParam(':status', $data['status']);
		$result = $statement->execute();

		return $result;
	}

	function deleteUser($koneksi, $id){
		$query = "DELETE FROM user WHERE username = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		return $result;
	}