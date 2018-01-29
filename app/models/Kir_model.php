<?php
	function get_datatable_kir($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data kir

	// get kir by id

	// get increment kd kir
	function get_inc_kd_kir($koneksi, $jenis){
		$kode = $jenis."-".date("Y").date("m").date("d");
		$query = "SELECT kd_kir FROM kir WHERE kd_kir LIKE '%".$kode."%' ORDER BY id DESC LIMIT 1";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// insert kir
	function insertKir($koneksi, $data){
		$query = "INSERT INTO kir (kd_kir, tgl, id_supplier, jenis_bahan_baku, status) ";
		$query .= "VALUES (:kd_kir, :tgl, :id_supplier, :jenis_bahan_baku, :status)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':kd_kir', $data['kd_kir']);
		$statement->bindParam(':tgl', $data['tgl']);
		$statement->bindParam(':id_supplier', $data['id_supplier']);
		$statement->bindParam(':jenis_bahan_baku', $data['jenis_bahan_baku']);
		$statement->bindParam(':status', $data['status']);
		$result = $statement->execute();

		return $result;
	}

	// insert kir kopi
	function insertKir_kopi($koneksi, $data){
		$query = "CALL tambah_kir_kopi(:kd_kir, :trase, :gelondong, :air, :ayakan, :kulit, :rendemen)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':kd_kir', $data['kd_kir']);
		$statement->bindParam(':trase', $data['trase']);
		$statement->bindParam(':gelondong', $data['gelondong']);
		$statement->bindParam(':air', $data['air']);
		$statement->bindParam(':ayakan', $data['ayakan']);
		$statement->bindParam(':kulit', $data['kulit']);
		$statement->bindParam(':rendemen', $data['rendemen']);
		$result = $statement->execute();

		return $result;
	}

	// insert kir lada
	function insertKir_lada($koneksi, $data){
		$query = "CALL tambah_kir_lada(:kd_kir, :air, :berat, :abu)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':kd_kir', $data['kd_kir']);
		$statement->bindParam(':air', $data['air']);
		$statement->bindParam(':berat', $data['berat']);
		$statement->bindParam(':abu', $data['abu']);
		$result = $statement->execute();

		return $result;
	}