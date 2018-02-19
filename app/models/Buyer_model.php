<?php
	// get datatable data buyer
	function get_datatable_buyer($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data buyer
	function get_all_buyer($koneksi){
		$query = "SELECT * FROM v_buyer";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get data buyer by id
	function getBuyer_by_id($koneksi, $id){
		$query = "SELECT id, npwp, nama, alamat, telp, email, status ";
		$query .= "FROM buyer WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// get data buyer untuk select
	function get_data_select_buyer($koneksi){
		$status = '1';
		$query = "SELECT id, nama FROM buyer WHERE status=:status";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':status', $status);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// function insert
	function insertBuyer($koneksi, $data){
		$query = "INSERT INTO buyer (npwp, nama, alamat, telp, email, status) ";
		$query .= "VALUES (:npwp, :nama, :alamat, :telp, :email, :status)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':npwp', $data['npwp']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':alamat', $data['alamat']);
		$statement->bindParam(':telp', $data['telp']);
		$statement->bindParam(':email', $data['email']);
		$statement->bindParam(':status', $data['status']);
		$result = $statement->execute();

		return $result;
	}

	// function update
	function updateBuyer($koneksi, $data){
		$query = "UPDATE buyer SET npwp=:npwp, nama=:nama, alamat=:alamat, telp=:telp, "; 
		$query .= " email=:email, status=:status WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $data['id_buyer']);
		$statement->bindParam(':npwp', $data['npwp']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':alamat', $data['alamat']);
		$statement->bindParam(':telp', $data['telp']);
		$statement->bindParam(':email', $data['email']);
		$statement->bindParam(':status', $data['status']);
		$result = $statement->execute();

		return $result;
	}

	function deleteBuyer($koneksi, $id){
		$query = "DELETE FROM buyer WHERE id = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		return $result;
	}