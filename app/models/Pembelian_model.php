<?php
	function get_datatable_pembelian($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// function get increment invoice
	function get_inc_invoice_pembelian($koneksi){
		$kode = date("Y").date("m").date("d");
		$query = "SELECT invoice FROM pembelian_bahan_baku WHERE invoice LIKE '%".$kode."%' ORDER BY id DESC LIMIT 1";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// function insert pembelian
	function insertPembelian($koneksi, $data){
		$query = "INSERT INTO pembelian_bahan_baku (tgl, invoice, id_supplier, jenis_pembayaran, jenis_pph, pph, total, ket, status) ";
		$query .= "VALUES (:tgl, :invoice, :id_supplier, :jenis_pembayaran, :jenis_pph, :pph, :total, :ket, :status)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':tgl', $data['tgl']);
		$statement->bindParam(':invoice', $data['invoice']);
		$statement->bindParam(':id_supplier', $data['supplier']);
		$statement->bindParam(':jenis_pembayaran', $data['jenis_pembayaran']);
		$statement->bindParam(':jenis_pph', $data['jenis_pph']);
		$statement->bindParam(':pph', $data['pph']);
		$statement->bindParam(':total', $data['total_pph']);
		$statement->bindParam(':ket', $data['ket']);
		$statement->bindParam(':status', $data['status']);
		$result = $statement->execute();

		return $result;
	}

	// function insert detail pembelian
	function insertDetail_pembelian($koneksi, $data){
		$query = "CALL tambah_detail_pembelian(:invoice, :tgl, :id_bahan_baku, :id_analisa_harga, :colly, :jumlah, :harga, :subtotal)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':invoice', $data['invoice']);
		$statement->bindParam(':tgl', $data['tgl']);
		$statement->bindParam(':id_bahan_baku', $data['id_bahan_baku']);
		$statement->bindParam(':id_analisa_harga', $data['id_analisa_harga']);
		$statement->bindParam(':colly', $data['colly']);
		$statement->bindParam(':jumlah', $data['jumlah']);
		$statement->bindParam(':harga', $data['harga_beli']);
		$statement->bindParam(':subtotal', $data['subtotal']);
		$result = $statement->execute();

		return $result;
	}