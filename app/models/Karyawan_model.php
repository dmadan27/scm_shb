<?php
	// get all data karyawan
	function get_datatable_karyawan($koneksi, $config_db){
		$query = get_dataTable($config_db);
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get all data karyawan
	function get_all_karyawan($koneksi){
		$query = "SELECT * FROM v_karyawan";

		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get data karyawan by id
	function getKaryawan_by_id($koneksi, $id){
		$query = "SELECT * FROM karyawan WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function getStatus_karyawan_byId($koneksi, $id){
		$query = "SELECT status FROM karyawan WHERE id = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	// get data karyawan untuk select
	function get_data_select_karyawan($koneksi){
		$status = '1';
		$query = "SELECT k.id, k.nama, p.nama jabatan FROM karyawan k ";
		$query .= "JOIN pekerjaan p ON p.id=k.id_pekerjaan WHERE status=:status";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':status', $status);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// get data select supir
	function get_data_supir($koneksi){
		$status = '1';
		$jabatan = "SUPIR";
		$query = "SELECT k.id, k.nama FROM karyawan k ";
		$query .= "JOIN pekerjaan p ON p.id=k.id_pekerjaan ";
		$query .= "WHERE p.nama=:jabatan AND k.status=:status";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':jabatan', $jabatan);
		$statement->bindParam(':status', $status);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	// function insert
	function insertKaryawan($koneksi, $data){
		$query = "INSERT INTO karyawan ";
		$query .= "(no_induk, nik, npwp, nama, tempat_lahir, tgl_lahir, jk, alamat, telp, email, foto, tgl_masuk, id_pekerjaan, status) ";
		$query .= "VALUES (:no_induk, :nik, :npwp, :nama, :tempat_lahir, :tgl_lahir, :jk, :alamat, :telp, :email, :foto, :tgl_masuk, :id_pekerjaan, :status)";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':no_induk', $data['no_induk']);
		$statement->bindParam(':nik', $data['nik']);
		$statement->bindParam(':npwp', $data['npwp']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':tempat_lahir', $data['tempat_lahir']);
		$statement->bindParam(':tgl_lahir', $data['tgl_lahir']);
		$statement->bindParam(':jk', $data['jk']);
		$statement->bindParam(':alamat', $data['alamat']);
		$statement->bindParam(':telp', $data['telp']);
		$statement->bindParam(':email', $data['email']);
		$statement->bindParam(':foto', $data['foto']);
		$statement->bindParam(':tgl_masuk', $data['tgl_masuk']);
		$statement->bindParam(':id_pekerjaan', $data['id_pekerjaan']);
		$statement->bindParam(':status', $data['status']);
		$result = $statement->execute();

		return $result;
	}

	// function update
	function updateKaryawan($koneksi, $data){
		// $data = setNull($data);
		$query = "UPDATE karyawan SET ";
		$query .= "nik=:nik, npwp=:npwp, nama=:nama, tempat_lahir=:tempat_lahir, tgl_lahir=:tgl_lahir, jk=:jk, ";
		$query .= "alamat=:alamat, telp=:telp, email=:email, tgl_masuk=:tgl_masuk, id_pekerjaan=:id_pekerjaan WHERE id=:id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':nik', $data['nik']);
		$statement->bindParam(':npwp', $data['npwp']);
		$statement->bindParam(':nama', $data['nama']);
		$statement->bindParam(':tempat_lahir', $data['tempat_lahir']);
		$statement->bindParam(':tgl_lahir', $data['tgl_lahir']);
		$statement->bindParam(':jk', $data['jk']);
		$statement->bindParam(':alamat', $data['alamat']);
		$statement->bindParam(':telp', $data['telp']);
		$statement->bindParam(':email', $data['email']);
		$statement->bindParam(':tgl_masuk', $data['tgl_masuk']);
		$statement->bindParam(':id_pekerjaan', $data['id_pekerjaan']);
		$statement->bindParam(':id', $data['id_karyawan']);
		$result = $statement->execute();

		return $result;
	}

	function updateStatus_karyawan($koneksi, $status, $id){
		$query = "UPDATE karyawan SET status = :status WHERE id = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':status', $status);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		return $result;		
	}

	function deleteKaryawan($koneksi, $id){
		$query = "DELETE FROM karyawan WHERE id = :id";

		$statement = $koneksi->prepare($query);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		return $result;
	}