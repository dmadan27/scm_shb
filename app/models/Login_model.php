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

	// function get_data_login_buyer($koneksi, $username){
	// 	$query = "SELECT u.username, u.password, u.jenis, u.hak_akses, b.id id_buyer, b.nama, b.email, b.foto ";
	// 	$query .= "FROM user u JOIN user_buyer ub ON ub.username = u.username JOIN buyer b ON b.id = ub.id_buyer ";
	// 	$query .= "WHERE BINARY u.username = :username";

	// 	$statement = $koneksi->prepare($query);
	// 	$statement->bindParam(':username', $username);
	// 	$statement->execute();
	// 	$result = $statement->fetch(PDO::FETCH_ASSOC);

	// 	return $result;
	// }