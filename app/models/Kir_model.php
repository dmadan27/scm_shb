<?php
	function get_datatable_kir($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data kir

	// get kir kopi by id
	function get_kir_kopi_by_id($koneksi, $idKir){
		$query = "SELECT * FROM kir_kopi WHERE id_kir = :idKir";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':idKir', $idKir);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// get kir lada by id
	function get_kir_lada_by_id($koneksi, $idKir){
		$query = "SELECT * FROM kir_lada WHERE id_kir = :idKir";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':idKir', $idKir);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function get_jenis_kir($koneksi, $idKir){
		$query = "SELECT jenis_bahan_baku FROM kir WHERE id = :idKir";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':idKir', $idKir);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;	
	}

	function get_supplier_kir($koneksi, $idKir){
		$query = "SELECT s.id, s.npwp, s.nik, s.nama nama_supplier FROM kir k ";
		$query .= "JOIN supplier s ON s.id = k.id_supplier WHERE k.id = :idKir";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':idKir', $idKir);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// get kir yang belum diberi harga
	function get_kir_analisa_harga($koneksi){
		$query = "SELECT k.id id_kir, k.kd_kir, k.id_supplier, ";
		$query .= "s.nama nama_supplier, s.npwp, s.nik FROM kir k ";
		$query .= "LEFT JOIN analisa_harga ah ON ah.id_kir = k.id ";
		$query .= "JOIN supplier s ON s.id = k.id_supplier WHERE ah.id_kir IS NULL ";
		$query .= "ORDER BY k.tgl DESC";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

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

	function deleteKir($koneksi, $id){
		$query = "CALL hapus_kir(:id)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		return $result;
	}