<?php
	function get_datatable_analisa_harga($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get analisa harga yg belum dibayar
	function get_analisaHarga_belumBayar_byId($koneksi, $supplier){
		$status = "BELUM DIBAYAR";
		$query = "SELECT * FROM v_analisa_harga WHERE id_supplier= :supplier AND status_analisa = :status ";
		$query .= "ORDER BY tgl_analisa DESC";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':supplier', $supplier);
		$statement->bindParam(':status', $status);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	function insertAnalisa_harga($koneksi, $data){
		$status = "0";
		$query = "INSERT INTO analisa_harga (tgl, id_kir, id_harga_basis, harga_basis, harga_beli, status) ";
		$query .= "VALUES (:tgl, :kd_kir, :id_harga_basis, :harga_basis, :harga_beli, :status)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':tgl', $data['tgl']);
		$statement->bindParam(':kd_kir', $data['kd_kir']);
		$statement->bindParam(':id_harga_basis', $data['id_basis']);
		$statement->bindParam(':harga_basis', $data['harga_basis']);	
		$statement->bindParam(':harga_beli', $data['harga_beli']);
		$statement->bindParam(':status', $status);
		$result = $statement->execute();

		return $result;
	}

	// function delete analisa harga
	function deleteAnalisa_harga($koneksi, $id){
		$query = "DELETE FROM analisa_harga WHERE id = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		return $result;
	}