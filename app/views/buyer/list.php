<?php
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Data Buyer</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li>Data Master</li>
            <li class="active">Data Buyer</li>
        </ol>
    </div>
</div>

<!-- panel utama -->
<div class="row">
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
        	<div class="panel-heading">Lihat Semua Data Buyer</div>
    	 	<div class="panel-wrapper collapse in">
    	 		<div class="panel-wrapper collapse in">
    	 			<div class="panel-body">
    	 				<!-- panel button -->
    	 				<div class="row">
    	 					<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
    	 						<div class="btn-group m-b-30">
                                    <?php 
                                        if(get_btn_aksi($m, $sess_akses_menu, false, true)){
                                            ?>
                                                <button id="tambah_buyer" class="fcbtn btn btn-info btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i> Tambah</button>
                                            <?php
                                        }
                                    ?>
    	 							<button id="exportExcel" class="fcbtn btn btn-success btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Export Data Ke Excel"><i class="fa fa-file-excel-o"></i> Export Excel</button>
    	 							<button id="exportPdf" class="fcbtn btn btn-danger btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Export Data Ke Pdf"><i class="fa fa-file-pdf-o"></i> Export Pdf</button>
    	 						</div>
    	 					</div>
    	 				</div>
                        <!-- <div class="table-responsive"> -->
                            <table id="tabel_buyer" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 15px">No</th>
                                        <th>NPWP</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No. Telepon</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        <!-- </div> -->
    	 			</div>
    	 		</div>
    	 	</div>
        </div>
    </div>
</div>

<!-- Form Modal dan view Supplier -->
<?php 
    include_once('form.php');
?>

<!-- js list -->
<script type="text/javascript" src="<?= base_url."app/views/buyer/js/initList.js"; ?>"></script>
<!-- js form modal -->
<script type="text/javascript" src="<?= base_url."app/views/buyer/js/initForm.js"; ?>"></script>
