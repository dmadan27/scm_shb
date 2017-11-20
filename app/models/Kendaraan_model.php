<?php
	// get all data kendaraan
	function get_datatable_kendaraan($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data kendaraan
	function get_all_kendaraan($koneksi){
		$query = "SELECT * FROM v_kendaraan";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get data kendaraan by id
	function getKendaraan_by_id($koneksi, $id){
		$query = "SELECT id, no_polis, id_supir, pendamping, tahun, jenis, muatan, status ";
		$query .= "FROM kendaraan WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// function insert
	function insertKendaraan($koneksi, $data){
		$query = "INSERT INTO kendaraan (no_polis, id_supir, pendamping, tahun, jenis, muatan, foto, status) "; 
		$query .= "VALUES (:no_polis, :id_supir, :pendamping, :tahun, :jenis, :muatan, :foto, :status)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':no_polis', $data['no_polis']);
		$statement->bindParam(':id_supir', $data['id_supir']);
		$statement->bindParam(':pendamping', $data['pendamping']);
		$statement->bindParam(':tahun', $data['tahun']);
		$statement->bindParam(':jenis', $data['jenis']);
		$statement->bindParam(':muatan', $data['muatan']);
		$statement->bindParam(':foto', $data['foto']);
		$statement->bindParam(':status', $data['status']);
		$result = $statement->execute();

		return $result;
	}

	// function update
	function updateKendaraan($koneksi, $data){
		$query = "UPDATE kendaraan SET no_polis=:no_polis, id_supir=:id_supir, pendamping=:pendamping, "; 
		$query .= " tahun=:tahun, jenis=:jenis, muatan=:muatan, status=:status WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':no_polis', $data['no_polis']);
		$statement->bindParam(':id_supir', $data['id_supir']);
		$statement->bindParam(':pendamping', $data['pendamping']);
		$statement->bindParam(':tahun', $data['tahun']);
		$statement->bindParam(':jenis', $data['jenis']);
		$statement->bindParam(':muatan', $data['muatan']);
		$statement->bindParam(':status', $data['status']);
		$statement->bindParam(':id', $data['id_kendaraan']);
		$result = $statement->execute();

		return $result;
	}