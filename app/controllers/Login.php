<?php
	include_once("../function/helper.php");
	include_once("../function/koneksi.php");
	include_once("../function/validasi_form.php");

	include_once("../models/Login_model.php");

	$action = isset($_POST['action']) ? $_POST['action'] : false;

	if(!$action) die("Dilarang Akses Halaman Ini !!");
	else{
		switch (strtolower($action)) {
			case 'login':
				session_start();
				login($koneksi);
				break;

			case 'lupa_password':
				// session_start();
				lupa_password($koneksi);
				break;
			
			default:
				die();
				break;
		}
	}

	function login($koneksi){
		$cek = true;
		$status = false;
		$usernameError = $passwordError = $setError = $setValue = "";

		$username = validInputan($_POST['username'], false, true);
		$password = validInputan($_POST['password'], false, true);

		if(empty($username) || empty($password)){
			$cek = false;
			$usernameError = $passwordError = "Username dan Password Harap Diisi";
		}
		else{
			$data_login = get_login($koneksi, $username);
			if(!$data_login){
				$cek = false;
				$usernameError = $passwordError = "Username atau Password Anda Salah !";
			}
			else{
				if(password_verify($password, $data_login['password'])) $cek = true;
				else{
					$usernameError = $passwordError = "Username atau Password Anda Salah !";
					$cek = false;
				} 		
			}
		}

		if($cek){
			// cek status aktif
			if($data_login['status'] === "1"){
				// dapatkan info user
				$get_data_login = get_data_login($koneksi, $username);

				// set hak akses
				$hak_akses = set_hak_akses($data_login['hak_akses']);
				$status = true;
				$foto = empty($get_data_login['foto']) ? "default.jpg" : $get_data_login['foto'];
				
				// set session
				$_SESSION['sess_login'] = $status;
				$_SESSION['sess_username'] = $get_data_login['username'];
				$_SESSION['sess_nama'] = $get_data_login['nama'];
				$_SESSION['sess_email'] = $get_data_login['email'];
				$_SESSION['sess_foto'] = $foto;
				$_SESSION['sess_status'] = $data_login['status'];
				// $_SESSION['sess_pengguna'] = strtolower($data_login['jenis']) == 'k' ? $get_data_login['jabatan'] : "BUYER";
				$_SESSION['sess_pengguna'] = $get_data_login['jabatan'];
				$_SESSION['sess_hak_akses'] = $data_login['hak_akses']; // hak akses
				$_SESSION['sess_akses_menu'] = $hak_akses; // hak akses menu
				$_SESSION['sess_lockscreen'] = false;
				$_SESSION['sess_welcome'] = true;
				// $_SESSION['sess_time'] = false;
			}
			else{
				$status = false;
				$usernameError = $passwordError = "Username atau Password Anda Salah !";
			}
		}
		else $status = false;

		$_SESSION['sess_login'] = $status;

		$setError = array(
			'usernameError' => $usernameError,
			'passwordError' => $passwordError,
		);

		$setValue = array(
			'username' => $username,
			'password' => $password,
		);

		$output = array(
			'status' => $status,
			'setError' => $setError,
			'setValue' => $setValue,
		);

		echo json_encode($output);
	}