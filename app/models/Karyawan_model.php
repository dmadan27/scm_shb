<?php
	// get all data karyawan
	function get_all_karyawan($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		// tutup_koneksi($koneksi);

		return $result;
	}

	// get data karyawan by id
	function get_data_by_id($koneksi, $id){
		$query = "SELECT * FROM karyawan WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// function insert
	function insertKaryawan($koneksi, $data){
		$query = "INSERT INTO karyawan (no_induk, nik, npwp, nama, telp, email, alamat, foto, jabatan, status) ";
		$query .= "VALUES (:no_induk, :nik, :npwp, :nama, :telp, :email, :alamat, :foto, :jabatan, :status)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':no_induk', $data['no_induk']);
		$statement->bindParam(':nik', $data['nik']);
		$statement->bindParam(':npwp', $data['npwp']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':telp', $data['telp']);
		$statement->bindParam(':email', $data['email']);
		$statement->bindParam(':alamat', $data['alamat']);
		$statement->bindParam(':foto', $data['foto']);
		$statement->bindParam(':jabatan', $data['jabatan']);
		$statement->bindParam(':status', $data['status']);
		$result = $statement->execute();

		return $result;
	}