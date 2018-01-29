<?php 
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
	$id = isset($_GET['id']) ? $_GET['id'] : false;
	$btn = $id ? "edit" : "tambah"; 
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Form <?= ucfirst($btn); ?> Data Perencanaan Pengadaan Bahan Baku</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li class="active">Data Perencanaan Pengadaan Bahan Baku</li>
        </ol>
    </div>
</div>
<div class="form-perencanaan">
	<form id="form_perencanaan" class="form-material" role="form" enctype="multipart/form-data">
		<!-- panel form perencanaan -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		Data Perencanaan Pengadaan Bahan Baku
		    		 	<div class="panel-action">
		        		 	<a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
					 	</div>
		        	</div>
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
							<input type="hidden" name="id_perencanaan" id="id_perencanaan">
			    	 		<div class="row">
			    	 			<div class="col-md-6">
		    	 					<!-- Tanggal -->
									<div class="form-group field-tgl has-feedback m-b-5">
										<label class="col-md-12" for="tgl">Tanggal Perencanaan Dilakukan*</label>
				                        <div class="col-md-12">
				                            <input id="tgl" type="text" class="form-control datepicker" placeholder="Masukkan Tanggal">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- Periode -->
									<div class="form-group field-periode has-feedback m-b-5">
										<label class="col-md-12" for="periode">Periode*</label>
				                        <div class="col-md-12">
				                            <input id="periode" type="text" class="form-control" placeholder="Masukkan Periode (Tahun dan Bulan)">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- Produk -->
									<div class="form-group field-produk has-feedback m-b-5">
										<label class="col-md-12" for="produk">Produk*</label>
				                        <div class="col-md-12">
				                            <select id="produk" class="form-control select2"></select>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- button proses peramalan -->
									<div class="form-group field-btn-peramalan has-feedback m-b-5">
				                        <div class="col-md-12 text-right">
				                            <button id="btnHitung_peramalan" type="button" class="btn btn-danger btn-outline waves-effect waves-light" value="hitung_peramalan">Gunakan Peramalan</button>
				                        </div>
									</div>	
			    	 			</div>
			    	 			<div class="col-md-6">
		    	 					<!-- Hasil Peramalan -->
									<div class="form-group field-hasil-perencanaan has-feedback m-b-5">
										<label class="col-md-12" for="hasil_perencanaan">Hasil Perencanaan*</label>
				                        <div class="col-md-12">
				                        	<div class="input-group">
				                        		<input id="hasil_perencanaan" type="number" min="0" step="any" class="form-control" placeholder="Hasil Perencanaan">
				                        		<span class="input-group-addon satuan-produk"></span>
				                        	</div>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
									<!-- Jumlah Bahan Baku -->
									<div class="table-responsive">
										<table id="tabel_jumlah_bahanBaku" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th style="width: 15px">No</th>
													<th>Kode</th>
													<th>Bahan Baku</th>
													<th>Jumlah</th>
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
		<!-- panel form safety stock -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
		        		Data Persediaan Pengaman (Safety Stock)
		    		 	<div class="panel-action">
		        		 	<a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
					 	</div>
		        	</div>
		        	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
			    	 		<div class="row">
			    	 			<!-- parameter safety stock -->
			    	 			<div class="col-md-6">
			    	 				<fieldset>
			    	 					<legend>Parameter Safety Stock</legend>
			    	 					<!-- nilai z / service level -->
			                        	<div class="form-group field-nilai-z has-feedback m-b-5">
			                        		<div class="row">
			                        			<div class="col-md-6">
			                        				<label class="col-md-12" for="nilai_z">Service Level</label>
							                        <div class="col-md-12">
							                            <select id="nilai_z" class="form-control" disabled></select>
							                            <span class="help-block small pesan"></span>
							                        </div>
			                        			</div>
			                        			<div class="col-md-6">
			                        				<label class="col-md-12" for="label_nilai_z">Nilai Z</label>
			                        				<div class="col-md-12">
			                        					<input type="number" id="label_nilai_z" class="form-control" placeholder="Nilai Z" disabled>
			                        				</div>
												</div>
					                       </div>
										</div>

										<!-- nilai rata2 permintaan -->
										<div class="form-group field-nilai-d has-feedback m-b-5">
											<label class="col-md-12" for="nilai_d">Nilai Rata-rata Permintaan (Nilai Perencanaan)</label>
					                        <div class="col-md-12">
					                           	<input type="number" id="nilai_d" class="form-control" placeholder="Nilai Hasil Perencanaan" disabled>
				                            	<span class="help-block small pesan"></span>
					                        </div>
										</div>

										<!-- nilai lead time -->
										<div class="form-group field-nilai-l has-feedback m-b-5">
											<label class="col-md-12" for="nilai_l">Nilai Lead Time (Waktu Tunggu Pengadaan Bahan Baku)</label>
					                        <div class="col-md-12">
					                            <input type="number" id="nilai_l" class="form-control" placeholder="Nilai Lead Time" disabled>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>

										<!-- radio button aktif/non aktif -->
										<div class="form-group field-switch has-feedback m-b-5">
											<label for="edit_parameter_ss">Edit Parameter</label>
											<input id="edit_parameter_ss" type="checkbox" class="js-switch" data-color="#13dafe" />
										</div>

										<!-- button hitung safety stock -->
										<div class="form-group field-btn-safety-stock has-feedback m-b-5">
					                        <div class="col-md-12 text-right">
					                            <button id="btnHitung_safetyStock" type="button" class="btn btn-danger btn-outline waves-effect waves-light" value="hitung_safety_stock">Hitung Safety Stock</button>
					                        </div>
										</div>	
			    	 				</fieldset>
			    	 			</div>
			    	 			<!-- field safety stock -->
			    	 			<div class="col-md-6">
		    	 					<fieldset>
		    	 						<legend>Nilai Safety Stock</legend>
		    	 						<!-- nilai safety stock produk -->
		    	 						<div class="form-group field-safety-stock-produk has-feedback m-b-5">
											<label class="col-md-12" for="safety_stock_produk">Nilai Safety Stock Produk</label>
					                        <div class="col-md-12">
					                        	<div class="input-group">
					                        		<input type="number" id="safety_stock_produk" min="0" step="any" class="form-control" placeholder="Masukkan Nilai Safety Stock Produk">
													<span class="input-group-addon satuan-ss-produk"></span>
					                        	</div>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>

		    	 						<!-- nilai safety stock bahan baku -->
		    	 						<div class="table-responsive">
											<table id="tabel_safety_stock_bahanBaku" class="table table-bordered table-hover">
												<thead>
													<tr>
														<th style="width: 15px">No</th>
														<th>Kode</th>
														<th>Bahan Baku</th>
														<th>Safety Stock</th>
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
		        			<button id="btnSubmit_perencanaan" type="submit" class="btn btn-lg btn-info btn-outline waves-effect waves-light" value="<?= $btn ?>"><?= ucfirst($btn); ?></button>
		        			<a href="<?=base_url."index.php?m=perencanaan_bahan_baku&p=list" ?>" class="btn btn-lg btn-default btn-outline waves-effect waves-light">Batal</a>
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
<script type="text/javascript" src="<?= base_url."app/views/perencanaan_bahan_baku/js/initForm.js"; ?>"></script>