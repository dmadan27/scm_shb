<?php
	// get all data karyawan
	function get_all_pekerjaan($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		// tutup_koneksi($koneksi);

		return $result;
	}

	// get data pekerjaan by id
	function get_data_by_id($koneksi, $id){
		$query = "SELECT * FROM pekerjaan WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// function insert
	function insertPekerjaan($koneksi, $data){
		$query = "INSERT INTO pekerjaan (jabatan, ket) VALUES (:jabatan, :ket)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':jabatan', $data['jabatan']);
		$statement->bindParam(':ket', $data['ket']);
		$result = $statement->execute();

		return $result;
	}

	function updatePekerjaan($koneksi, $data){
		// $data = setNull($data);
		$query = "UPDATE pekerjaan SET jabatan=:jabatan, ket=:ket WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $data['id_pekerjaan']);
		$statement->bindParam(':jabatan', $data['jabatan']);
		$statement->bindParam(':ket', $data['ket']);
		$result = $statement->execute();

		return $result;
	}