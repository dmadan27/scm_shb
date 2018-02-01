<?php
	// get all data harga basis
	function get_datatable_harga_basis($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data harga_basis
	function get_all_harga_basis($koneksi){
		$query = "SELECT * FROM harga_basis";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get data harga_basis by id
	function getHargaBasis_by_id($koneksi, $id){
		$query = "SELECT * FROM harga_basis WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// get data harga basis untuk select
	function getHarga_basis_select($koneksi){
		$query = "SELECT * FROM harga_basis";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// function insert
	function insertHargaBasis($koneksi, $data){
		$query = "INSERT INTO harga_basis (tgl, jenis, harga_basis) VALUES (:tgl, :jenis, :harga_basis)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':tgl', $data['tgl']);
		$statement->bindParam(':jenis', $data['jenis']);
		$statement->bindParam(':harga_basis', $data['harga_basis']);
		$result = $statement->execute();

		return $result;
	}

	function updateHargaBasis($koneksi, $data){
		$query = "UPDATE harga_basis SET tgl=:tgl, jenis=:jenis, harga_basis=:harga_basis WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $data['id_harga_basis']);
		$statement->bindParam(':tgl', $data['tgl']);
		$statement->bindParam(':jenis', $data['jenis']);
		$statement->bindParam(':harga_basis', $data['harga_basis']);
		$result = $statement->execute();

		return $result;
	}