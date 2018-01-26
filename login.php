<?php
	session_start();
	include_once("app/function/koneksi.php");
	include_once("app/function/helper.php");

	$sess_login = isset($_SESSION['sess_login']) ? $_SESSION['sess_login'] : false;
	if($sess_login){
		header("Location: ".base_url);
		die();
	}
?>
<!DOCTYPE html>  
<html lang="en">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	    <!-- Icon -->
		<link rel="icon" type="image/gif" href="<?= base_url."assets/images/shb-ori-icon.ico"; ?>">
    	<title>Login | Sistem Informasi SCM SHB</title>

    	<!-- autoload index css -->
    	<?php include_once("app/views/template/css/autoload_css.php"); ?>
    	<link href="<?= base_url."assets/css/style.css"; ?>" rel="stylesheet">
        <link href="<?= base_url."assets/css/colors/megna-dark.css"; ?>" id="theme" rel="stylesheet">
    	<!-- jQuery -->
    	<script src="<?= base_url."assets/plugins/bower_components/jquery/dist/jquery.min.js"; ?>"></script>
    	<script type="text/javascript">
		    var base_url = "<?php print base_url; ?>";
		    var urlParams = <?php echo json_encode($_GET, JSON_HEX_TAG);?>;
		</script>
	</head>
	<body>
		<!-- Preloader -->
		<div class="preloader">
		 	<div class="cssload-speeding-wheel"></div>
		</div>
		<section id="wrapper" class="new-login-register">
	      	<div class="lg-info-panel" style="background: url(../scm_shb/assets/plugins/images/login-register.jpg) center center/cover no-repeat!important;">
      	        <div class="inner-panel">
		            <a href="javascript:void(0)" class="p-20 di"><img src="<?= base_url."assets/plugins/images/shb-logo.png"; ?>"></a>
        	      	<div class="lg-content">
                      	<h2>SISTEM INFORMASI SUPPLY CHAIN MANAGEMENT<br> PT. SARHIF BROTHERS</h2>
                      	<p class="text-muted">PT. SARHIF BROTHERS <br>Jl. Lintas Sumatera No. 148 Bernah Kotabumi Lampung Utara</p>
                  	</div>
              	</div>
      		</div>
      		<div class="new-login-box">
                <div class="white-box">
                	<div class="text-right">
                		<img src="<?= base_url."assets/plugins/images/shb-logo.png"; ?>">
                	</div>
                	<?php 
                		include_once("app/views/login/form_login.php");
                		include_once("app/views/login/form_lupa_password.php"); 
                	?>
        		</div>
  			</div>            
		</section>
        <?php include_once("app/views/template/js/autoload_js.php"); ?>
        <script type="text/javascript" src="<?= base_url."app/views/login/js/initLogin.js"; ?>"></script>
	</body>
</html>
