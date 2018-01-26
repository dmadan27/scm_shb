<?php
	// get datatable data produk
	function get_datatable_produk($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data produk
	function get_all_produk($koneksi){
		$query = "SELECT * FROM produk";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get data produk  by id
	function getProduk_by_id($koneksi, $id){
		$query = "SELECT * FROM produk WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// get data komposisi by id
	function getKomposisi_by_id($koneksi, $id){
		$query = "SELECT k.id id_komposisi, p.id id_produk, p.kd_produk, p.nama nama_produk, ";
		$query .= "b.id id_bahan_baku, b.nama nama_bahan_baku, b.kd_bahan_baku, b.satuan satuan_bahan_baku, k.penyusutan ";
		$query .= "FROM komposisi k JOIN produk p ON p.id = k.id_produk ";
		$query .= "JOIN bahan_baku b ON b.id = k.id_bahan_baku WHERE k.id_produk=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// function insert produk
	function insertProduk($koneksi, $data){
		$tgl = date("Y-m-d");
		$query = "CALL tambah_produk (:kd_produk, :nama, :satuan, :ket, :foto, :tgl, :stok) ";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':kd_produk', $data['kd_produk']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':satuan', $data['satuan']);
		$statement->bindParam(':ket', $data['ket']);
		$statement->bindParam(':foto', $data['foto']);
		$statement->bindParam(':tgl', $tgl);
		$statement->bindParam(':stok', $data['stok']);
		$result = $statement->execute();

		return $result;
	}

	// function insert komposisi
	function insertKomposisi($koneksi, $data){
		$query = "CALL tambah_komposisi (:kd_produk, :id_bahan_baku, :penyusutan) ";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':kd_produk', $data['kd_produk']);
		$statement->bindParam(':id_bahan_baku', $data['id_bahan_baku']);
		$statement->bindParam(':penyusutan', $data['penyusutan']);
		$result = $statement->execute();

		return $result;
	}

	// function update produk
	function updateProduk($koneksi, $data){
		$query = "UPDATE produk SET kd_produk=:kd_produk, nama=:nama, satuan=:satuan, ket=:ket WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $data['id_produk']);
		$statement->bindParam(':kd_produk', $data['kd_produk']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':satuan', $data['satuan']);
		$statement->bindParam(':ket', $data['ket']);
		$result = $statement->execute();

		return $result;
	}

	// function update komposisi
	function updateKomposisi($koneksi, $data){
		$query = "UPDATE komposisi SET id_produk=:id_produk, id_bahan_baku=:id_bahan_baku, penyusutan=:penyusutan WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $data['id_komposisi']);
		$statement->bindParam(':id_produk', $data['id_produk']);
		$statement->bindParam(':id_bahan_baku', $data['id_bahan_baku']);
		$statement->bindParam(':penyusutan', $data['penyusutan']);
		$result = $statement->execute();

		return $result;
	}

	// function delete komposisi
	function deleteKomposisi($koneksi, $data){
		$query = "DELETE FROM komposisi WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $data['id_komposisi']);
		$result = $statement->execute();

		return $result;
	}
