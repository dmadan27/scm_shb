<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
	$filename = "app/views/$m/$p.php";
?>
<div id="page-wrapper">
    <div class="container-fluid">
      	
    	<?php
    		if(file_exists($filename)) include_once($filename);
        	else include_once("app/views/beranda/dashboard.php");
    	?>

    </div>
    <!-- /.container-fluid -->
    <footer class="footer text-center"> 
    	<strong>Sistem Informasi SCM SHB</strong> | Copyright &copy; <?php echo date("Y"); ?> <a href="http://sarhifbrothers.co.id" target="_blank">PT. SARHIF BROTHERS</a>. All rights reserved | Powered By <a href="https://wrappixel.com/ampleadmin/" target="_blank">Ample Admin</a>
    </footer>
</div>
