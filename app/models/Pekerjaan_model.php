<?php
	// get all data karyawan
	function get_datatable_pekerjaan($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data pekerjaan
	function get_all_pekerjaan($koneksi){
		$query = "SELECT * FROM pekerjaan";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get data pekerjaan by id
	function getPekerjaan_by_id($koneksi, $id){
		$query = "SELECT * FROM pekerjaan WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// get data pekerjaan untuk select
	function getPekerjaan_select($koneksi){
		$query = "SELECT id, nama FROM pekerjaan";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// function insert
	function insertPekerjaan($koneksi, $data){
		$query = "INSERT INTO pekerjaan (nama, ket) VALUES (:nama, :ket)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':ket', $data['ket']);
		$result = $statement->execute();

		return $result;
	}

	function updatePekerjaan($koneksi, $data){
		$query = "UPDATE pekerjaan SET nama=:nama, ket=:ket WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $data['id_pekerjaan']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':ket', $data['ket']);
		$result = $statement->execute();

		return $result;
	}