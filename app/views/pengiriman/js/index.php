<?php
	define("base_url", "http://localhost/scm_shb/");
?>
<!DOCTYPE html>  
<html lang="en">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	    <!-- Icon -->
		<link rel="icon" type="image/gif" href="<?= base_url."assets/images/shb-ori-icon.ico"; ?>">
    	<title>403 - Sistem Informasi SCM SHB</title>
		<!-- Bootstrap Core CSS -->
		<link href="<?= base_url."assets/bootstrap/dist/css/bootstrap.min.css"; ?>" rel="stylesheet">
		<!-- animation CSS -->
		<link href="<?= base_url."assets/css/animate.css"; ?>" rel="stylesheet">

		<link href="<?= base_url."assets/css/style.css"; ?>" rel="stylesheet">
        <link href="<?= base_url."assets/css/colors/megna-dark.css"; ?>" id="theme" rel="stylesheet">

	</head>
	<body>
		<section id="wrapper" class="error-page">
		  	<div class="error-box">
		    	<div class="error-body text-center">
		      		<h1 class="text-info">403</h1>
		      		<h3 class="text-uppercase">Forbidden Error</h3>
			      	<p class="text-muted m-t-30 m-b-30 text-uppercase">You don't have permission to access on this server.</p>
				 	<a href="<?= base_url; ?>" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a>
			 	</div>
				<footer class="footer text-center"> 
			    	<strong>Sistem Informasi SCM SHB</strong> | Copyright &copy; <?php echo date("Y"); ?> <a href="http://sarhifbrothers.co.id" target="_blank">PT. SARHIF BROTHERS</a>. All rights reserved | Powered By <a href="https://wrappixel.com/ampleadmin/" target="_blank">Ample Admin</a>
			    </footer>
			</div>
		</section>
		<!-- jQuery -->
		<script src="<?= base_url."assets/plugins/bower_components/jquery/dist/jquery.min.js"; ?>"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="<?= base_url."assets/bootstrap/dist/js/bootstrap.min.js"; ?>"></script>
	</body>
</html>
