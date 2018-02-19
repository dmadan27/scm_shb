<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	// include_once("../models/Stok_model.php");
	// include_once("../models/Perencanaan_bahan_baku_model.php");

	function getDetail_pembelian_by_id_pembelian($koneksi, $id){
		$query = "SELECT * FROM v_detail_pembelian WHERE id_pembelian = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	function deletePembelian_bahan_baku($koneksi, $id){
		$query = "DELETE FROM pembelian_bahan_baku WHERE id = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		return $result;
	}

	function deleteDetail_pembelian($koneksi, $data){
		$query = "CALL hapus_detail_pembelian (:id_detail, :tgl, :id_bahan_baku, :id_analisa_harga, :jumlah)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id_detail', $data['id']);
		$statement->bindParam(':tgl', $data['tgl']);
		$statement->bindParam(':id_bahan_baku', $data['id_bahan_baku']);
		$statement->bindParam(':id_analisa_harga', $data['id_analisa_harga']);
		$statement->bindParam(':jumlah', $data['jumlah']);
		$result = $statement->execute();

		return $result;
	}
	
	function getHapus($koneksi, $id){
		$cek = false;

		// get data detail pembelian
		$dataDetail = getDetail_pembelian_by_id_pembelian($koneksi, $id);

		foreach($dataDetail as $index => $array){
			foreach ($dataDetail[$index] as $key => $value) {
				$dataDelete[$key] = $value;
			}
			if(deleteDetail_pembelian($koneksi, $dataDelete)) $cek = true;
		}

		if($cek){
			if(deletePembelian_bahan_baku($koneksi, $id))$status = true;
			else $status = false;
		}
		else $status = false;

		return $status;
	}

	var_dump(getHapus($koneksi, 3));
