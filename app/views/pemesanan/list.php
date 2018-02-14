<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
    $notif = isset($_SESSION['notif']) ? $_SESSION['notif'] : false;
    unset($_SESSION['notif']);
?> 
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Data Pemesanan</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li class="active">Data Pemesanan</li>
        </ol>
    </div>
</div>

<!-- panel utama -->
<div class="row">
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
        	<div class="panel-heading">List Data Pemesanan</div>
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
                                                <button id="tambah_pemesanan" class="fcbtn btn btn-info btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i> Tambah</button>
                                            <?php
                                        }
                                    ?>
    	 							<button id="exportExcel" class="fcbtn btn btn-success btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Export Data Ke Excel"><i class="fa fa-file-excel-o"></i> Export Excel</button>
    	 							<button id="exportPdf" class="fcbtn btn btn-danger btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Export Data Ke Pdf"><i class="fa fa-file-pdf-o"></i> Export Pdf</button>
    	 						</div>
    	 					</div>
    	 				</div>
	 					<table id="tabel_pemesanan" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
    	 					<thead>
    	 						<tr>
    	 							<th style="width: 15px">No</th>
    	 							<th>Tanggal</th>
                                    <th>No. Kontrak</th>
                                    <th>Buyer</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Waktu Pengiriman</th>
                                    <th>Status</th>
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

<!-- modals ubah status -->
<div class="modal fade" id="modal_ubah_status" tabindex="-1" role="dialog" aria-labelledby="labelModalUbahStatus" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalUbahStatus">Ubah Status Pemesanan</h4>
            </div>
            <form id="form_ubah_status" class="form-material" role="form" enctype="multipart/form-data">
                <input type="hidden" name="id_pemesanan" id="id_pemesanan">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- satuan -->
                            <div class="form-group field-satuan has-feedback m-b-5">
                                <label class="col-md-12" for="satuan">Status Pemesanan</label>
                                <div class="col-md-12">
                                    <select id="status" class="form-control"></select>
                                    <span class="help-block small pesan"></span>
                                </div>
                            </div>                          
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <button id="btnSubmit_ubah_status" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="ubah_status">Ubah</button>
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
    if($notif){
        ?>
        <script>var notif = "<?php echo $notif; ?>";</script>
        <?php
    }
    else{
        ?>
        <script>var notif = false;</script>
        <?php
    } 
?>
<!-- js list -->
<script type="text/javascript" src="<?= base_url."app/views/pemesanan/js/initList.js"; ?>"></script>