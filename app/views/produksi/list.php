<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
?> 
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Data Produksi</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li class="active">Data Produksi</li>
        </ol>
    </div>
</div>

<!-- panel utama -->
<div class="row">
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
        	<div class="panel-heading">List Data Produksi</div>
    	 	<div class="panel-wrapper collapse in">
    	 		<div class="panel-wrapper collapse in">
    	 			<div class="panel-body">
    	 				<!-- panel button -->
    	 				<div class="row">
    	 					<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
    	 						<div class="btn-group m-b-30">
    	 							<button id="tambah_produksi" class="fcbtn btn btn-info btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i> Tambah</button>
    	 							<button id="exportExcel" class="fcbtn btn btn-success btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Export Data Ke Excel"><i class="fa fa-file-excel-o"></i> Export Excel</button>
    	 							<button id="exportPdf" class="fcbtn btn btn-danger btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Export Data Ke Pdf"><i class="fa fa-file-pdf-o"></i> Export Pdf</button>
    	 						</div>
    	 					</div>
    	 				</div>
	 					<table id="tabel_produksi" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
    	 					<thead>
    	 						<tr>
    	 							<th style="width: 15px">No</th>
    	 							<th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Jumlah Bahan Baku</th>
                                    <th>Hasil Produksi</th>
    	 							<th>Aksi</th>
    	 						</tr>
    	 					</thead>
    	 				</table>	
    	 			</div>
    	 		</div>
    	 	</div>
        </div>
    </div>
</div>
<!-- Form Modal dan view produksi -->
<?php 
    include_once('form.php');
    include_once('view.php'); 
?>

<!-- js list -->
<script type="text/javascript" src="<?= base_url."app/views/produksi/js/initList.js"; ?>"></script>
<!-- js form modal -->
<!-- <script type="text/javascript" src="<?= base_url."app/views/produksi/js/initForm.js"; ?>"></script> -->
<!-- js view modal -->
<!-- <script type="text/javascript" src="<?= base_url."app/views/produksi/js/initView.js"; ?>"></script> -->