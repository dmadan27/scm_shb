<?php
	$dbHost = "localhost";
	$dbUser = "root";
	$dbPass = "";
	$dbName = "scm_shb";

	try{
		$koneksi = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		$koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		die("Koneksi Database Error: " . $e->getMessage()); // jika ada error
	}