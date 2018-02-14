<?php
	// get datatable data pemesanan
	function get_datatable_pemesanan($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get kontrak yang proses atau pending
	function get_all_kontrak_proses($koneksi){
		$status_p = "P";
		$status_w = "W";

		$query = "SELECT p.id id_pemesanan, p.no_kontrak, p.id_buyer, b.nama nama_buyer, b.alamat, ";
		$query .= "p.id_produk, pr.kd_produk, pr.nama nama_produk, ";
		$query .= "p.jumlah, p.waktu_pengiriman, p.batas_waktu_pengiriman ";
		$query .= "FROM pemesanan p JOIN buyer b ON b.id = p.id_buyer ";
		$query .= "JOIN produk pr ON pr.id = p.id_produk WHERE p.status = :status_p OR p.status = :status_w";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':status_p', $status_p);
		$statement->bindParam(':status_w', $status_w);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get info kontrak by id
	function get_kontrak_byId($koneksi, $id){
		$query = "SELECT p.id id_pemesanan, p.no_kontrak, p.id_buyer, b.nama nama_buyer, b.alamat, ";
		$query .= "p.id_produk, pr.kd_produk, pr.nama nama_produk, pr.satuan, ";
		$query .= "p.jumlah, p.waktu_pengiriman, p.batas_waktu_pengiriman ";
		$query .= "FROM pemesanan p JOIN buyer b ON b.id = p.id_buyer ";
		$query .= "JOIN produk pr ON pr.id = p.id_produk WHERE p.id = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// get data pemesanan yg sukses
	function getPemesanan_sukses($koneksi, $bulanPertama, $bulanSebelumnya, $produk){
		$bulanSebelumnya = $bulanSebelumnya;
		$bulanPertama = $bulanPertama;

		$query = "SELECT DATE_FORMAT(tgl, '%Y-%m') periode, SUM(jumlah) jumlah_periode ";
		$query .= "FROM v_pemesanan WHERE (DATE_FORMAT(tgl, '%Y-%m') BETWEEN :bulanPertama AND :bulanSebelumnya) AND id_produk =:produk ";
		$query .= "GROUP BY YEAR(tgl), MONTH(tgl) ORDER BY YEAR(tgl) ASC, MONTH(tgl) ASC";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':bulanPertama', $bulanPertama);
		$statement->bindParam(':bulanSebelumnya', $bulanSebelumnya);
		$statement->bindParam(':produk', $produk);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// function get status by id
	function getStatus_pemesanan_byId($koneksi, $id){
		$query = "SELECT status FROM pemesanan WHERE id = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// insert pemesanan
	function insertPemesanan($koneksi, $data){
		$query = "INSERT INTO pemesanan (tgl, no_kontrak, id_buyer, id_produk, jumlah, ";
		$query .= "jumlah_karung, ket_karung, kemasan, waktu_pengiriman, batas_waktu_pengiriman, ket, lampiran, status) ";
		$query .= "VALUES (:tgl, :no_kontrak, :id_buyer, :id_produk, :jumlah, ";
		$query .= ":jumlah_karung, :ket_karung, :kemasan, :waktu_pengiriman, :batas_waktu_pengiriman, :ket, :lampiran, :status)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':tgl', $data['tgl']);
		$statement->bindParam(':no_kontrak', $data['no_kontrak']);
		$statement->bindParam(':id_buyer', $data['buyer']);
		$statement->bindParam(':id_produk', $data['produk']);
		$statement->bindParam(':jumlah', $data['jumlah']);
		$statement->bindParam(':jumlah_karung', $data['jumlah_karung']);
		$statement->bindParam(':ket_karung', $data['ket_karung']);
		$statement->bindParam(':kemasan', $data['kemasan']);
		$statement->bindParam(':waktu_pengiriman', $data['waktu_pengiriman']);
		$statement->bindParam(':batas_waktu_pengiriman', $data['batas_waktu_pengiriman']);
		$statement->bindParam(':ket', $data['ket']);
		$statement->bindParam(':lampiran', $data['lampiran']);
		$statement->bindParam(':status', $data['status']);
		$result = $statement->execute();

		return $result;
	}

	// update status
	function updateStatus_pemesanan($koneksi, $status, $id){
		$query = "UPDATE pemesanan SET status = :status WHERE id = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':status', $status);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		return $result;		
	}