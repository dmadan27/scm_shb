<?php
	// get all data barang
	function get_all_supplier($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		// tutup_koneksi($koneksi);

		return $result;
	}

	// get data supplier inti
	function get_data_supplierInti($koneksi){
		$status = '1';
		$query = "SELECT id, nik, npwp, nama FROM supplier WHERE status = :status";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':status', $status);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// function insert
	function insertSupplier($koneksi, $data){
		$query = "CALL tambah_supplier(:nik, :npwp, :nama, :telp, :alamat, :foto, :status, :supplier_inti)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':nik', $data['nik']);
		$statement->bindParam(':npwp', $data['npwp']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':telp', $data['telp']);
		$statement->bindParam(':alamat', $data['alamat']);
		$statement->bindParam(':foto', $data['foto']);
		$statement->bindParam(':status', $data['status']);
		$statement->bindParam(':supplier_inti', $data['supplier_inti']);
		$result = $statement->execute();

		return $result;
	}	
