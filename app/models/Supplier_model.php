<?php
	// get datatable data supplier
	function get_datatable_supplier($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		// tutup_koneksi($koneksi);

		return $result;
	}

	// get all data supplier
	function get_all_supplier($koneksi){
		$query = "SELECT * FROM v_supplier";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get data supplier by id
	function getSupplier_by_id($koneksi, $id){
		$query = "SELECT s.id, s.nik, s.npwp, s.nama, s.telp, s.alamat, s.status, isup.id_supplier_utama supplier_utama ";
		$query .= "FROM supplier s JOIN index_supplier isup ON isup.id_supplier = s.id WHERE s.id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// get data supplier by id + transaksi
	function getSupplier_full_by_id($koneksi, $id){
		
	}

	// get data supplier utama
	function get_data_supplierUtama($koneksi){
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
		// $data = setNull($data);
		$query = "CALL tambah_supplier(:nik, :npwp, :nama, :telp, :alamat, :status, :supplier_utama)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':nik', $data['nik']);
		$statement->bindParam(':npwp', $data['npwp']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':telp', $data['telp']);
		$statement->bindParam(':alamat', $data['alamat']);
		$statement->bindParam(':status', $data['status']);
		$statement->bindParam(':supplier_utama', $data['supplier_utama']);
		$result = $statement->execute();

		return $result;
	}

	// function update
	function updateSupplier($koneksi, $data){
		// $data = setNull($data);
		$query = "CALL edit_supplier(:id, :nik, :npwp, :nama, :telp, :alamat, :status, :supplier_utama)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $data['id_supplier']);
		$statement->bindParam(':nik', $data['nik']);
		$statement->bindParam(':npwp', $data['npwp']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':telp', $data['telp']);
		$statement->bindParam(':alamat', $data['alamat']);
		$statement->bindParam(':status', $data['status']);
		$statement->bindParam(':supplier_utama', $data['supplier_utama']);
		$result = $statement->execute();

		return $result;
	}
