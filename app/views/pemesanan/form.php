<?php 
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
	$id = isset($_GET['id']) ? $_GET['id'] : false;
	$btn = $id ? "edit" : "tambah"; 
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Form <?= ucfirst($btn); ?> Data Pemesanan</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li class="active">Data Pemesanan</li>
        </ol>
    </div>
</div>
<div class="form-pemesanan">
	<form id="form_pemesanan" class="form-material" role="form" enctype="multipart/form-data">
		<!-- panel form -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
							<input type="hidden" name="id_pemesanan" id="id_pemesanan">
			    	 		<div class="row">
			    	 			<div class="col-md-6">
			    	 				<!-- tgl -->
			    	 				<div class="form-group field-tgl has-feedback m-b-5">
										<label class="col-md-12" for="tgl">Tanggal Pemesanan*</label>
				                        <div class="col-md-12">
				                            <input id="tgl" type="text" class="form-control datepicker" placeholder="Masukkan Tanggal Pemesanan">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
			    	 				<!-- no_kontrak -->
			    	 				<div class="form-group field-no-kontrak has-feedback m-b-5">
										<label class="col-md-12" for="no_kontrak">No. Kontrak**</label>
				                        <div class="col-md-12">
				                            <input id="no_kontrak" type="text" class="form-control" placeholder="Masukkan No. Kontrak">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
			    	 				<!-- buyer -->
			    	 				<div class="form-group field-buyer has-feedback m-b-5">
										<label class="col-md-12" for="buyer">Buyer*</label>
				                        <div class="col-md-12">
				                            <select id="buyer" class="form-control select2"></select>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
									<!-- produk - jumlah produk -->
									<div class="row">
										<div class="col-md-6">
											<!-- produk -->
					    	 				<div class="form-group field-produk has-feedback m-b-5">
												<label class="col-md-12" for="produk">Produk*</label>
						                        <div class="col-md-12">
						                            <select id="produk" class="form-control select2"></select>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
										</div>
										<div class="col-md-6">
											<!-- jumlah produk -->
					    	 				<div class="form-group field-jumlah-produk has-feedback m-b-5">
												<label class="col-md-12" for="jumlah">Jumlah Produk*</label>
						                        <div class="col-md-12">
						                        	<div class="input-group">
						                        		<input id="jumlah" type="number" min="0" step="any" class="form-control" placeholder="Masukkan Jumlah Produk">
						                        		<span class="input-group-addon satuan-produk"></span>
						                        	</div>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
										</div>
									</div>	
			    	 				<!-- jumlah karung -->
			    	 				<div class="form-group field-jumlah-karung has-feedback m-b-5">
										<label class="col-md-12" for="jumlah_karung">Jumlah Karung</label>
				                        <div class="col-md-12">
				                            <input id="jumlah_karung" type="number" min="0" class="form-control" placeholder="Masukkan Jumlah Karung">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
					    	 		<!-- ket karung - kemasan -->	
									<div class="row">
										<div class="col-md-6">
											<!-- ket karung -->
					    	 				<div class="form-group field-ket-karung has-feedback m-b-5">
												<label class="col-md-12" for="ket_karung">Keterangan Karung</label>
						                        <div class="col-md-12">
						                            <select id="ket_karung" class="form-control"></select>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
										</div>
										<div class="col-md-6">
											<!-- kemasan -->
					    	 				<div class="form-group field-kemasan has-feedback m-b-5">
												<label class="col-md-12" for="kemasan">Kemasan</label>
						                        <div class="col-md-12">
						                            <select id="kemasan" class="form-control"></select>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
										</div>
									</div>
			    	 			</div>
			    	 			<div class="col-md-6">
			    	 				<!-- waktu pengiriman - batas wakru -->
			    	 				<div class="row">
			    	 					<div class="col-md-6">
			    	 						<!-- waktu pengiriman -->
					    	 				<div class="form-group field-waktu-pengiriman has-feedback m-b-5">
												<label class="col-md-12" for="waktu_pengiriman">Waktu Pengiriman*</label>
						                        <div class="col-md-12">
						                            <input id="waktu_pengiriman" type="text" class="form-control datepicker" placeholder="Masukkan Waktu Pengiriman">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
			    	 					</div>
			    	 					<div class="col-md-6">
			    	 						<!-- batas waktu -->
					    	 				<div class="form-group field-batas-waktu has-feedback m-b-5">
												<label class="col-md-12" for="batas_waktu_pengiriman">Batas Waktu Pengiriman*</label>
						                        <div class="col-md-12">
						                            <input id="batas_waktu_pengiriman" type="text" class="form-control datepicker" placeholder="Masukkan Batas Waktu Pengiriman">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
			    	 					</div>
			    	 				</div>	
			    	 				<!-- ket -->
			    	 				<div class="form-group field-ket has-feedback m-b-5">
										<label class="col-md-12" for="ket">Keterangan</label>
				                        <div class="col-md-12">
				                            <textarea id="ket" class="form-control" rows="6" placeholder="Masukkan Keterangan Pemesanan"></textarea>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
			    	 				<!-- lampiran -->
			    	 				<div class="form-group field-lampiran has-feedback m-b-5">
		                                <label class="col-md-12">Lampiran</label>
		                                <div class="col-md-12">
				                            <input id="lampiran" type="file" class="form-control">
				                            <span class="help-block small pesan"></span>
				                        </div>
		                            </div>
			    	 				<!-- status -->
			    	 				<div class="form-group field-status has-feedback m-b-5">
										<label class="col-md-12" for="status">Status*</label>
				                        <div class="col-md-12">
				                            <select id="status" class="form-control"></select>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
			    	 			</div>
			    	 		</div>
			 			</div>
		    	 	</div>
		        </div>
		    </div>
		</div>
		<!-- panel button -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		<div class="row">
							<div class="col-md-12">
								<span class="help-block small">* Wajib Diisi</span>
								<span class="help-block small">** Wajib Diisi Jika Ada</span>
							</div>
						</div>	
		        		<div class="text-right">
		        			<button id="btnSubmit_pemesanan" type="submit" class="btn btn-lg btn-info btn-outline waves-effect waves-light" value="<?= $btn ?>"><?= ucfirst($btn); ?></button>
		        			<a href="<?=base_url."index.php?m=pemesanan&p=list" ?>" class="btn btn-lg btn-default btn-outline waves-effect waves-light">Batal</a>
		        		</div>
		        	</div>
		        </div>
		    </div>
		</div>
	</form>
</div>

<!-- <script type="text/javascript">
    var listKomposisi = [];
    var indexKomposisi = 0;
</script> -->
<!-- js form -->
<script type="text/javascript" src="<?= base_url."app/views/pemesanan/js/initForm.js"; ?>"></script>