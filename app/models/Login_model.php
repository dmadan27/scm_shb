<?php
	function get_login($koneksi, $username){
		$query = "SELECT * FROM user WHERE BINARY username = :username";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':username', $username);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function get_data_login($koneksi, $username){
		$query = "SELECT u.username, u.password, u.id_karyawan, u.hak_akses, u.status, k.no_induk, k.nama, k.email, k.foto, k.id_pekerjaan, p.nama jabatan ";
		$query .= "FROM user u JOIN karyawan k ON k.id = u.id_karyawan JOIN pekerjaan p ON p.id = k.id_pekerjaan WHERE BINARY u.username = :username";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':username', $username);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}
