<?php 
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
	$id = isset($_GET['id']) ? $_GET['id'] : false;
	$btn = $id ? "edit" : "tambah"; 
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Form <?= ucfirst($btn); ?> Data Penjadwalan Pengiriman</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li class="active">Data Penjadwalan Pengiriman</li>
        </ol>
    </div>
</div>
<div class="form-pengiriman">
	<form id="form_pengiriman" class="form-material" role="form" enctype="multipart/form-data">
		<input type="hidden" name="id_pengiriman" id="id_pengiriman">
		<!-- panel form 1-->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		Data Pengiriman
		        		<div class="panel-action">
		        		 	<a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
					 	</div>
		        	</div>
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
							<!-- panel kontrak - info kontrak - rekomendasi penjadwalan -->
			    	 		<div class="row">
			    	 			<div class="col-md-6">
			    	 				<fieldset>
			    	 					<legend>Data Pemesanan</legend>
			    	 					<!-- id_pemesanan - kontrak -->
			    	 					<div class="form-group field-kontrak has-feedback m-b-5">
											<label class="col-md-12" for="kontrak">No. Kontrak*</label>
					                        <div class="col-md-12">
					                            <select id="kontrak" class="form-control select2"></select>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>
										<div class="info-detail-pemesanan" style="display: block;">
											<!-- info buyer -->
				    	 					<div class="form-group field-info-buyer has-feedback m-b-5">
												<label class="col-md-12" for="info_buyer">Buyer:</label>
						                        <div class="col-md-12">
						                            <p class="form-control-static" id="info_buyer">Info Buyer</p>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
											<!-- info alamat pengiriman -->
											<div class="form-group field-info-alamat has-feedback m-b-5">
												<label class="col-md-12" for="info_alamat">Alamat Pengiriman:</label>
						                        <div class="col-md-12">
						                            <p class="form-control-static" id="info_alamat">Info Alamat</p>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
											<!-- info produk - info jumlah -->
											<div class="row">
												<div class="col-md-6">
													<!-- info produk -->
						    	 					<div class="form-group field-info-produk has-feedback m-b-5">
														<label class="col-md-12" for="info_produk">Produk:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_produk">Info Produk</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
												</div>
												<div class="col-md-6">
													<!-- info jumlah -->
						    	 					<div class="form-group field-info-jumlah has-feedback m-b-5">
														<label class="col-md-12" for="info_jumlah">Jumlah:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_jumlah">Info Jumlah</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
												</div>
											</div>
				    	 					<!-- info waktu pengiriman -->
				    	 					<div class="form-group field-tgl has-feedback m-b-5">
												<label class="col-md-12" for="tgl">Waktu Pengiriman:</label>
						                        <div class="col-md-12">
						                            <p class="form-control-static" id="info_waktu_pengiriman">Info Waktu Pengiriman</p>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
										</div>
										<!-- button proses penjadwalan -->
										<div class="form-group field-produk has-feedback m-b-5">
					                        <div class="col-md-12 text-right">
					                            <button id="btnRekomendasi" type="button" class="btn btn-danger btn-outline waves-effect waves-light" value="rekomendasi">Rekomendasi Penjadwalan Pengiriman</button>
					                        </div>
										</div>
			    	 				</fieldset>
			    	 			</div>
			    	 			<div class="col-md-6">
			    	 				<fieldset>
			    	 					<legend>Rekomendasi Penjadwalan</legend>
			    	 					<!-- info rekomendasi -->
			    	 					<div class="form-group field-info-rekomendasi has-feedback m-b-5">
											<label class="col-md-12" for="info_rekomendasi_pengiriman">Rekomendasi Penjadwalan Pengiriman:</label>
					                        <div class="col-md-12">
					                            <p class="form-control-static" id="info_rekomendasi_pengiriman">Info Rekomendasi Penjadwalan Pengiriman</p>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>
			    	 					<!-- tabel rekomendasi penjadwalan -->
			    	 					<div class="table-responsive">
											<table id="tabel_rekomendasi_pengiriman" class="table table-bordered table-hover">
												<thead>
													<tr>
														<th style="width: 15px">No</th>
														<th>Tanggal</th>
														<th>Kendaraan</th>
														<th>Jumlah</th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>	
			    	 				</fieldset>
			    	 			</div>
			    	 		</div>
			 			</div>
		    	 	</div>
		        </div>
		    </div>
		</div>
		<!-- panel form 2 -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		Data Detail Pengiriman
		        		<div class="panel-action">
		        		 	<a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
					 	</div>
		        	</div>
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
			 				<div class="row">
			 					<div class="col-md-6">
			 						<!-- tgl -->
									<div class="form-group field-tgl has-feedback m-b-5">
										<label class="col-md-12" for="kontrak">Tanggal*</label>
				                        <div class="col-md-12">
				                            <input id="tgl" type="text" class="form-control datepicker" placeholder="Masukkan Tanggal">
				                            <span class="help-block small pesan"></span>
				                        </div> 
									</div>
									<!-- kendaraan -->
									<div class="form-group field-kendaraan has-feedback m-b-5">
										<label class="col-md-12" for="kendaraan">Kendaraan*</label>
				                        <div class="col-md-12">
				                            <select id="kendaraan" class="form-control select2"></select>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
			 					</div>
			 					<div class="col-md-6">
			 						<div class="row">
			 							<div class="col-md-6">
			 								<!-- colly -->
											<div class="form-group field-colly has-feedback m-b-5">
												<label class="col-md-12" for="kontrak">Colly*</label>
						                        <div class="col-md-12">
						                            <div class="input-group">
						                        		<input id="colly" type="number" min="0" class="form-control" placeholder="Masukkan Colly">
						                        		<span class="input-group-addon">PCS</span>
						                        	</div>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
			 							</div>
			 							<div class="col-md-6">
			 								<!-- jumlah -->
											<div class="form-group field-jumlah has-feedback m-b-5">
												<label class="col-md-12" for="kontrak">Jumlah*</label>
						                        <div class="col-md-12">
						                            <div class="input-group">
						                        		<input id="jumlah" type="number" min="0" class="form-control" placeholder="Masukkan Jumlah">
						                        		<span class="input-group-addon">KG</span>
						                        	</div>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
			 							</div>
			 						</div>	
									<!-- status -->
									<div class="form-group field-status has-feedback m-b-5">
										<label class="col-md-12" for="status">Status*</label>
				                        <div class="col-md-12">
				                            <div class="input-group">
				                        		<select id="status" class="form-control"></select>
				                        		<span class="input-group-btn">
				                        			<button type="button" id="btnTambah_pengiriman" class="btn btn-danger btn-outline waves-effect waves-light" title="Tambah Detail Pengiriman"><i class="fa fa-plus"></i></button>
				                        		</span>
				                        	</div>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
			 					</div>
			 				</div>
			 				<!-- tabel list pengiriman -->
			    	 		<div class="row">
			    	 			<div class="col-md-12">
			    	 				<div class="table-responsive">
										<table id="tabel_detail_pengiriman" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th style="width: 15px">No</th>
													<th>Tanggal</th>
													<th>Kendaraan</th>
													<th>Colly</th>
													<th>Jumlah</th>
													<th>Status</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
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
							</div>
						</div>	
		        		<div class="text-right">
		        			<button id="btnSubmit_pengiriman" type="submit" class="btn btn-lg btn-info btn-outline waves-effect waves-light" value="<?= $btn ?>"><?= ucfirst($btn); ?></button>
		        			<a href="<?=base_url."index.php?m=pengiriman&p=list" ?>" class="btn btn-lg btn-default btn-outline waves-effect waves-light">Batal</a>
		        		</div>
		        	</div>
		        </div>
		    </div>
		</div>
	</form>
</div>

<!-- js form -->
<script type="text/javascript" src="<?= base_url."app/views/pengiriman/js/initForm.js"; ?>"></script>