<?php
	include_once("app/function/koneksi.php");
	include_once("app/function/helper.php");
	date_default_timezone_set('Asia/Jakarta');

	// variabel get request page
	$m = isset($_GET['m']) ? $_GET['m'] : false; // untuk get menu
	$p = isset($_GET['p']) ? $_GET['p'] : false; // untuk get page

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
    	<?php include_once("app/views/template/css/autoload_index_css.php"); ?>
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

	    <!-- autoload index js -->
	    <?php include_once("app/views/template/js/autoload_index_js.php"); ?>
	</body>
</html>