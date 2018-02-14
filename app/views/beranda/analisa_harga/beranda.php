<?php
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Beranda</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li class="active"><a href="<?= base_url; ?>">Beranda</a></li>
        </ol>
    </div>
</div>

<!-- panel utama -->
<div class="row">
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
    	 	<div class="panel-wrapper collapse in">
    	 		<div class="panel-wrapper collapse in">
    	 			<div class="panel-body">
                      	<h3>Selamat Datang di Sistem Informasi SCM - SHB</h3>
                        <hr>
                        <h3><?= $sess_nama." - ".$sess_pengguna ?></h3>
    	 			</div>
    	 		</div>
    	 	</div>
        </div>
    </div>
</div>
