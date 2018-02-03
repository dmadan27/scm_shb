<?php 
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
	$id = isset($_GET['id']) ? $_GET['id'] : false;
	$btn = $id ? "edit" : "tambah"; 
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Form <?= ucfirst($btn); ?> Data Analisa Harga</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li>Data Master</li>
            <li class="active">Data Analisa Harga</li>
        </ol>
    </div>
</div>
<div class="form-analisa-harga">
	<form id="form_analisa_harga" class="form-material" role="form" enctype="multipart/form-data">
		<!-- panel form data Produk -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		Data Harga Basis dan KIR
		        		<div class="panel-action">
		        		 	<a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
					 	</div>
		        	</div>
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
							<input type="hidden" name="id_analisa_harga" id="id_analisa_harga">
			    	 		<div class="row">
			    	 			<div class="col-md-6">
			    	 				<fieldset>
			    	 					<legend>Data Harga Basis</legend>
	    	 							<!-- tgl -->
				    	 				<div class="form-group field-tgl has-feedback m-b-5">
											<label class="col-md-12" for="tgl">Tanggal*</label>
					                        <div class="col-md-12">
					                            <input id="tgl" type="text" class="form-control datepicker" placeholder="Masukkan Tanggal">
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>
					    	 			<div class="row">
					    	 				<div class="col-md-6">
					    	 					<!-- id basis -->
												<div class="form-group field-id-basis has-feedback m-b-5">
													<label class="col-md-12" for="id_basis">Basis*</label>
							                        <div class="col-md-12">
							                            <select id="id_basis" class="form-control select2"></select>
							                            <span class="help-block small pesan"></span>
							                        </div>
												</div>
					    	 				</div>
					    	 				<div class="col-md-6">
					    	 					<!-- harga basis -->
												<div class="form-group field-harga-basis has-feedback m-b-5">
													<label class="col-md-12" for="harga_basis">Harga Basis*</label>
							                        <div class="col-md-12">
							                            <input id="harga_basis" type="number" class="form-control" placeholder="Masukkan Harga Basis">
							                            <span class="help-block small pesan"></span>
							                        </div>
												</div>
					    	 				</div>
					    	 			</div>		
			    	 				</fieldset>
			    	 			</div>
			    	 			<div class="col-md-6">
			    	 				<fieldset>
			    	 					<legend>Data KIR</legend>
			    	 					<!-- kode kir -->
				    	 				<div class="form-group field-kd-kir has-feedback m-b-5">
											<label class="col-md-12" for="kd_kir">Kode KIR*</label>
					                        <div class="col-md-12">
					                            <select id="kd_kir" class="form-control select2"></select>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>
										<div class="kir-supplier" style="display: none;">
											<div class="form-group field-info-supplier has-feedback m-b-5">
												<label class="col-md-12" for="info_supplier">Supplier:</label>
						                        <div class="col-md-12">
						                            <p class="form-control-static" id="info_supplier">Info Supplier</p>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
										</div>
			    	 					<div class="kir-kopi" style="display: none;">
			    	 						<div class="row">
			    	 							<div class="col-md-6">
			    	 								<div class="form-group field-info-trase has-feedback m-b-5">
														<label class="col-md-12" for="info_trase">Trase:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_trase">Info Trase</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
			    	 							</div>
			    	 							<div class="col-md-6">
			    	 								<div class="form-group field-info-gelondong has-feedback m-b-5">
														<label class="col-md-12" for="info_gelondong">Gelondong:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_gelondong">Info Gelondong</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
			    	 							</div>
			    	 						</div>
			    	 						<div class="row">
			    	 							<div class="col-md-6">
			    	 								<div class="form-group field-info-air-kopi has-feedback m-b-5">
														<label class="col-md-12" for="info_air_kopi">Air:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_air_kopi">Info Air</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
			    	 							</div>
			    	 							<div class="col-md-6">
			    	 								<div class="form-group field-info-ayakan has-feedback m-b-5">
														<label class="col-md-12" for="info_ayakan">Ayakan:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_ayakan">Info Ayakan</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
			    	 							</div>
			    	 						</div>
			    	 						<div class="row">
			    	 							<div class="col-md-6">
			    	 								<div class="form-group field-info-kulit has-feedback m-b-5">
														<label class="col-md-12" for="info_kulit">Kulit:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_kulit">Info Kulit</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
			    	 							</div>
			    	 							<div class="col-md-6">
			    	 								<div class="form-group field-info-rendemen has-feedback m-b-5">
														<label class="col-md-12" for="info_rendemen">Rendemen:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_rendemen">Info Rendemen</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
			    	 							</div>
			    	 						</div>	
			    	 					</div>
			    	 					<div class="kir-lada" style="display: none;">
			    	 						<div class="row">
			    	 							<div class="col-md-4">
			    	 								<div class="form-group field-info-air-lada has-feedback m-b-5">
														<label class="col-md-12" for="info_air_lada">Air:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_air_lada">Info Air</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
			    	 							</div>
			    	 							<div class="col-md-4">
			    	 								<div class="form-group field-info-berat has-feedback m-b-5">
														<label class="col-md-12" for="info_berat">Berat:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_berat">Info Berat</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
			    	 							</div>
			    	 							<div class="col-md-4">
			    	 								<div class="form-group field-info-abu has-feedback m-b-5">
														<label class="col-md-12" for="info_abu">Abu:</label>
								                        <div class="col-md-12">
								                            <p class="form-control-static" id="info_abu">Info Abu</p>
								                            <span class="help-block small pesan"></span>
								                        </div>
													</div>
			    	 							</div>
			    	 						</div>		
			    	 					</div>
			    	 					<div class="form-group field-hitung-harga has-feedback m-b-5">
					                        <div class="col-md-12 text-right">
					                            <button id="btnHitung_harga" type="button" class="btn btn-danger btn-outline waves-effect waves-light" value="hitung_harga">Hitung Harga Beli</button>
					                        </div>
										</div>	
			    	 				</fieldset>
			    	 			</div>
			    	 		</div>
			 			</div>
		    	 	</div>
		        </div>
		    </div>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		Analisa Harga
		        		<div class="panel-action">
		        		 	<a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
					 	</div>
		        	</div>
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
			 				<div class="row">
			 					<div class="col-md-6">
			 						<div class="analisa-kopi" style="display: none;">
				 						<div class="form-group field-kalkulasi-rendemen has-feedback m-b-5">
											<label class="col-md-12" for="kalkulasi_rendemen">Kalkulasi Rendemen:</label>
					                        <div class="col-md-12">
					                            <p class="form-control-static" id="kalkulasi_rendemen">Kalkulasi Rendemen</p>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>
						 			</div>		
									<div class="analisa-lada" style="display: none;">
				 						<div class="row">
				 							<div class="col-md-6">
				 								<div class="form-group field-kalkulasi-air-abu has-feedback m-b-5">
													<label class="col-md-12" for="kalkulasi_air_abu">Kalkulasi Air + Abu:</label>
							                        <div class="col-md-12">
							                            <p class="form-control-static" id="kalkulasi_air_abu">Kalkulasi Air Abu</p>
							                            <span class="help-block small pesan"></span>
							                        </div>
												</div>
				 							</div>
				 							<div class="col-md-6">
				 								<div class="form-group field-kalkulasi-berat has-feedback m-b-5">
													<label class="col-md-12" for="kalkulasi_berat">Kalkulasi Berat:</label>
							                        <div class="col-md-12">
							                            <p class="form-control-static" id="kalkulasi_berat">Kalkulasi Berat</p>
							                            <span class="help-block small pesan"></span>
							                        </div>
												</div>
				 							</div>
				 						</div>	
				 					</div>
			 					</div>
			 					<!-- harga beli -->
			 					<div class="col-md-6">
			 						<div class="form-group field-harga-beli has-feedback m-b-5">
										<label class="col-md-12" for="harga_beli">Harga Beli:</label>
				                        <div class="col-md-12">
				                            <input id="harga_beli" type="number" class="form-control" placeholder="Masukkan Harga Beli">
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
							</div>
						</div>	
		        		<div class="text-right">
		        			<button id="btnSubmit_analisa_harga" type="submit" class="btn btn-lg btn-info btn-outline waves-effect waves-light" value="<?= $btn ?>"><?= ucfirst($btn); ?></button>
		        			<a href="<?=base_url."index.php?m=analisa_harga&p=list" ?>" class="btn btn-lg btn-default btn-outline waves-effect waves-light">Batal</a>
		        		</div>
		        	</div>
		        </div>
		    </div>
		</div>
	</form>
</div>

<!-- js form -->
<script type="text/javascript" src="<?= base_url."app/views/analisa_harga/js/initForm.js"; ?>"></script>