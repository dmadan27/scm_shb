<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
    $id = isset($_GET['id']) ? $_GET['id'] : false;
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Lihat Detail Data Supplier</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li>Data Master</li>
            <li class="active">Data Supplier</li>
        </ol>
    </div>
</div>
<div class="row">
    <!-- panel info lengkap -->
    <div class="col-md-12 col-xs-12">
        <div class="white-box">
        	<div class="sttabs tabs-style-linetriangle">
                <nav>
                    <ul>
                        <li><a href="#section-data-supplier"><span>Data Supplier</span></a></li>
                        <li><a href="#section-data-transaksi"><span>Data Transaksi</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-data-supplier">
                    	<div class="row">
                    		<!-- data supplier utama -->
                    		<div class="col-md-6 col-xs-12">
		                    	<!-- nik -->
		                        <div class="form-group m-b-5">
									<label>NIK:</label>
		                            <p class="form-control-static" id="info_nik">Info NIK</p>
								</div>
								<!-- npwp -->
		                        <div class="form-group m-b-5">
									<label>NPWP:</label>
		                            <p class="form-control-static" id="info_npwp">Info NPWP</p>
								</div>
								<!-- nama -->
		                        <div class="form-group m-b-5">
									<label>Nama:</label>
		                            <p class="form-control-static" id="info_nama">Info Nama</p>
								</div>
								<!-- alamat -->
		                        <div class="form-group m-b-5">
									<label>Alamat:</label>
		                            <p class="form-control-static" id="info_alamat">Info Alamat</p>
								</div>
								<!-- telp -->
		                        <div class="form-group m-b-5">
									<label>No. Telepon:</label>
		                            <p class="form-control-static" id="info_telp">Info No. Telepon</p>
								</div>
								<!-- email -->
		                        <div class="form-group m-b-5">
									<label>Email:</label>
		                            <p class="form-control-static" id="info_email">Info Email</p>
								</div>
								<!-- Status -->
		                        <div class="form-group m-b-5">
									<label>Status Supplier:</label>
		                            <p class="form-control-static" id="info_status">Info Status Supplier</p>
								</div>
								<div class="form-group m-b-5 text-right">
									<button id="editSupplier" type="button" class="btn btn-info btn-outline waves-effect waves-light">Edit Data</button>
	                    			<a href="<?=base_url."index.php?m=supplier&p=list" ?>" class="btn btn-default btn-outline waves-effect waves-light">Kembali</a>
								</div>
		                    </div>
		                    <!-- data supplier pengganti -->
							<div class="col-md-6 col-xs-12">
								<label>Supplier Pengganti</label>
								<hr>
								<table id="tabel_supplier_pengganti" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
		    	 					<thead>
		    	 						<tr>
		    	 							<th style="width: 15px">No</th>
		    	 							<th>No. KTP</th>
		    	 							<th>NPWP</th>
		    	 							<th>Nama</th>
		                                    <th>Alamat</th>
		                                    <th>No. Telepon</th>
		                                    <th>Email</th>
		    	 						</tr>
		    	 					</thead>
		    	 				</table>
							</div>
                    	</div>
                    </section>
                    <section id="section-data-transaksi">
               			<!-- info transaksi -->
               			<div class="row">
               				<div class="col-md-12">
               					<div class="form-group m-b-5">
									<label>Total Transaksi Tahun 2018</label>
		                            <p class="form-control-static" id="total_transaksi">Info Total Transaksi</p>
								</div>
               				</div>
               			</div>
               			<!-- tabel pembelian -->
               			<div class="row">
               				<div class="col-md-12">
               					<table id="tabel_transaksi" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
		    	 					<thead>
		    	 						<tr>
		    	 							<th style="width: 15px">No</th>
		    	 							<th>Tanggal</th>
		                                    <th>Invoice</th>
		                                    <th>Bahan Baku</th>
		                                    <th>Colly</th>
		                                    <th>Jumlah</th>
		                                    <th>Harga</th>
		                                    <th>PPH</th>
		                                    <th>Total</th>
		                                    <th>Status</th>
		    	 						</tr>
		    	 					</thead>
		    	 				</table>
               				</div>
               			</div>
                    </section>
                </div>
                <!-- /content -->
            </div>
        </div>
    </div>

    <!-- modal edit foto -->
    <div class="modal fade" id="modal_editFoto" tabindex="-1" role="dialog" aria-labelledby="labelModalEditFoto" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title" id="labelModalEditFoto">Edit Foto Karyawan</h4>
				</div>
				<form id="form_gantiFoto" class="form-material" role="form" enctype="multipart/form-data">
					<input type="hidden" name="id_karyawan" id="id_karyawan">
					<div class="modal-body">
						<label for="foto">Foto Karyawan</label>
                        <input type="file" id="foto" class="dropify"/>
					</div>
					<div class="modal-footer">
	                    <button id="btnGanti_foto" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="ganti_foto">Ganti Foto</button>
                     	<button id="btnHapus_foto" type="button" class="btn btn-danger btn-outline waves-effect waves-light" value="hapus_foto">Hapus Foto</button>
	                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- js view -->
<script type="text/javascript" src="<?= base_url."app/views/supplier/js/initView.js"; ?>"></script>
