<?php
	// get datatable data bahan baku
	function get_datatable_bahan_baku($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data bahan baku
	function get_all_bahan_baku($koneksi){
		$query = "SELECT * FROM bahan_baku";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get data bahan baku by id
	function getBahanBaku_by_id($koneksi, $id){
		$query = "SELECT * FROM bahan_baku WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// function insert
	function insertBahan_baku($koneksi, $data){
		$tgl = date("Y-m-d");
		$query = "CALL tambah_bahan_baku (:kd_bahan_baku, :nama, :satuan, :ket, :foto, :tgl, :stok) ";

		$statement = $koneksi->prepare($query);
		// $statement->bindParam(':id_bahan_baku', $data['id_bahan_baku']);
		$statement->bindParam(':kd_bahan_baku', $data['kd_bahan_baku']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':satuan', $data['satuan']);
		$statement->bindParam(':ket', $data['ket']);
		$statement->bindParam(':foto', $data['foto']);
		$statement->bindParam(':tgl', $tgl);
		$statement->bindParam(':stok', $data['stok']);
		$result = $statement->execute();

		return $result;
	}

	// function update
	function updateBahan_baku($koneksi, $data){
		$query = "UPDATE bahan_baku SET kd_bahan_baku=:kd_bahan_baku, nama=:nama, satuan=:satuan, ket=:ket WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $data['id_bahan_baku']);
		$statement->bindParam(':kd_bahan_baku', $data['kd_bahan_baku']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':satuan', $data['satuan']);
		$statement->bindParam(':ket', $data['ket']);
		$result = $statement->execute();

		return $result;
	}

	function deleteBahanBaku($koneksi, $id){
		$query = "CALL hapus_bahan_baku(:id)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		return $result;
	}