<?php
	Define("BASE_PATH", true);
	
	date_default_timezone_set('Asia/Jakarta');
	session_start();

	include_once("app/function/koneksi.php");
	include_once("app/function/helper.php");
	include_once("app/function/validasi_form.php");

	$sess_login = isset($_SESSION['sess_login']) ? $_SESSION['sess_login'] : false;
	$sess_username = isset($_SESSION['sess_username']) ? $_SESSION['sess_username'] : false;
	$sess_nama = isset($_SESSION['sess_nama']) ? $_SESSION['sess_nama'] : false;
	$sess_email = isset($_SESSION['sess_email']) ? $_SESSION['sess_email'] : false;
	$sess_foto = isset($_SESSION['sess_foto']) ? $_SESSION['sess_foto'] : false;
	$sess_pengguna = isset($_SESSION['sess_pengguna']) ? $_SESSION['sess_pengguna'] : false;
	$sess_hak_akses = isset($_SESSION['sess_hak_akses']) ? $_SESSION['sess_hak_akses'] : false;
	$sess_akses_menu = isset($_SESSION['sess_akses_menu']) ? $_SESSION['sess_akses_menu'] : false;
	$sess_lockscreen = isset($_SESSION['sess_lockscreen']) ? $_SESSION['sess_lockscreen'] : false;
	$sess_welcome = isset($_SESSION['sess_welcome']) ? $_SESSION['sess_welcome'] : false;
	unset($_SESSION['sess_welcome']);
	// $sess_time = isset($_SESSION['sess_time']) ? $_SESSION['sess_time'] : false;

	if(!$sess_login){
		header("Location: ".base_url."login.php");
		die();
	}

	// cek waktu idle

	// variabel get request page
	$m = isset($_GET['m']) ? strtolower(validInputan($_GET['m'], false, false)) : false; // untuk get menu
	$p = isset($_GET['p']) ? strtolower(validInputan($_GET['p'], false, false)) : false; // untuk get page

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	    <!-- Icon -->
		<link rel="icon" type="image/gif" href="<?= base_url."assets/images/shb-ori-icon.ico"; ?>">
    	<title>Sistem Informasi SCM SHB</title>

    	<!-- autoload index css -->
    	<?php include_once("app/views/template/css/autoload_css.php"); ?>
    	<!-- jQuery -->
    	<script src="<?= base_url."assets/plugins/bower_components/jquery/dist/jquery.min.js"; ?>"></script>
    	<script type="text/javascript">
		    var base_url = "<?php print base_url; ?>";
		    var urlParams = <?php echo json_encode($_GET, JSON_HEX_TAG);?>;
		</script>
	</head>
	<body class="fix-header">
		<!-- Preloader -->
		<div class="preloader">
	        <svg class="circular" viewBox="25 25 50 50">
	            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
	        </svg>
	    </div>
	    <!-- end preloader -->

	    <!-- wrapper -->
	    <div class="wrapper">
	    	<?php
	    		// header
	    		include_once("app/views/template/header.php");

	    		// left sidebar
	    		include_once("app/views/template/sidebar.php");

	    		// content - right sidebar - footer
	    		include_once("app/views/template/content.php");
	    	?>
	    </div>
	    <!-- endwrapper -->

     	<!-- Custom CSS -->
        <link href="<?= base_url."assets/css/style.css"; ?>" rel="stylesheet">
        <link href="<?= base_url."assets/css/colors/megna-dark.css"; ?>" id="theme" rel="stylesheet">
	    
	    <!-- autoload index js -->
	    <?php include_once("app/views/template/js/autoload_js.php"); ?>
	    <?php 
		    if($sess_welcome){
		        ?>
		        <script type="text/javascript">
			    	$(document).ready(function(){
			    		$.toast({
							heading: 'Selamat Datang di Sistem Informasi SCM-SHB',
							position: 'top-right',
				            loaderBg: '#ff6849',
				            icon: 'info',
				            hideAfter: 3000,
				            stack: 6
						});
			    	});
			    </script>
		        <?php
		    }
		?>
	    
	</body>
</html>