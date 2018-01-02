<?php 
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
	$id = isset($_GET['id']) ? $_GET['id'] : false;
	$btn = $id ? "edit" : "tambah"; 
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Form <?= ucfirst($btn); ?> Data KIR</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li class="active">Data KIR</li>
        </ol>
    </div>
</div>
<div class="form-kir">
	<form id="form_kir" class="form-material" role="form" enctype="multipart/form-data">
		<!-- panel form data Produk -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
							<input type="hidden" name="id_kir" id="id_kir">
			    	 		<div class="row">
			    	 			<!-- data kir -->
			    	 			<div class="col-md-6">
			    	 				<fieldset>
			    	 					<legend>Data KIR</legend>
			    	 					<!-- jenis bahan baku -->
				    	 				<div class="form-group field-jenis has-feedback m-b-5">
											<label class="col-md-12" for="jenis">Jenis Bahan Baku*</label>
					                        <div class="col-md-12">
					                            <select id="jenis" class="form-control"></select>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>
				    	 				<!-- kode kir -->
				    	 				<div class="form-group field-kd-kir has-feedback m-b-5">
											<label class="col-md-12" for="kd_kir">Kode KIR*</label>
					                        <div class="col-md-12">
					                            <input id="kd_kir" type="text" class="form-control" placeholder="Masukkan Kode KIR">
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>
				    	 				<!-- tgl -->
				    	 				<div class="form-group field-tgl has-feedback m-b-5">
											<label class="col-md-12" for="tgl">Tanggal*</label>
					                        <div class="col-md-12">
					                            <input id="tgl" type="text" class="form-control datepicker" placeholder="Masukkan Tanggal">
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>
				    	 				<!-- supplier -->
				    	 				<div class="form-group field-supplier has-feedback m-b-5">
											<label class="col-md-12" for="supplier">Supplier*</label>
					                        <div class="col-md-12">
					                            <select id="supplier" class="form-control select2"></select>
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
			    	 				</fieldset>
			    	 			</div>
			    	 			<!-- data detail kir - kir kopi | lada -->
			    	 			<div class="col-md-6">
			    	 				<div class="kir-kopi" style="display: none;">
			    	 					<fieldset>
			    	 						<legend>Data KIR Kopi</legend>
			    	 						<!-- trase -->
				    	 					<div class="form-group field-trase has-feedback m-b-5">
												<label class="col-md-12" for="trase">Trase*</label>
						                        <div class="col-md-12">
						                            <input id="trase" type="number" class="form-control" placeholder="Masukkan Trase">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
				    	 					<!-- gelondong -->
				    	 					<div class="form-group field-gelondong has-feedback m-b-5">
												<label class="col-md-12" for="gelondong">Gelondong*</label>
						                        <div class="col-md-12">
						                            <input id="gelondong" type="number" class="form-control" placeholder="Masukkan Gelondong">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
				    	 					<!-- air -->
				    	 					<div class="form-group field-air-kopi has-feedback m-b-5">
												<label class="col-md-12" for="air_kopi">Air*</label>
						                        <div class="col-md-12">
						                            <input id="air_kopi" type="number" class="form-control" placeholder="Masukkan Air">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
				    	 					<!-- ayakan -->
				    	 					<div class="form-group field-ayakan has-feedback m-b-5">
												<label class="col-md-12" for="ayakan">Ayakan*</label>
						                        <div class="col-md-12">
						                            <input id="ayakan" type="number" class="form-control" placeholder="Masukkan Ayakan">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
				    	 					<!-- kulit -->
				    	 					<div class="form-group field-kulit has-feedback m-b-5">
												<label class="col-md-12" for="kulit">Kulit*</label>
						                        <div class="col-md-12">
						                            <input id="kulit" type="number" class="form-control" placeholder="Masukkan Kulit">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
				    	 					<!-- rendemen -->
				    	 					<div class="form-group field-rendemen has-feedback m-b-5">
												<label class="col-md-12" for="rendemen">Rendemen*</label>
						                        <div class="col-md-12">
						                            <input id="rendemen" type="number" class="form-control" placeholder="Masukkan Rendemen">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
			    	 					</fieldset>
			    	 				</div>
			    	 				<div class="kir-lada" style="display: none;">
			    	 					<fieldset>
			    	 						<legend>Data KIR Lada</legend>
			    	 						<!-- air -->
			    	 						<div class="form-group field-air-lada has-feedback m-b-5">
												<label class="col-md-12" for="air_lada">Air*</label>
						                        <div class="col-md-12">
						                            <input id="air_lada" type="number" class="form-control" placeholder="Masukkan Air">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
				    	 					<!-- berat -->
				    	 					<div class="form-group field-berat has-feedback m-b-5">
												<label class="col-md-12" for="berat">Berat*</label>
						                        <div class="col-md-12">
						                            <input id="berat" type="number" class="form-control" placeholder="Masukkan Berat">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
				    	 					<!-- abu -->
				    	 					<div class="form-group field-abu has-feedback m-b-5">
												<label class="col-md-12" for="abu">Abu*</label>
						                        <div class="col-md-12">
						                            <input id="abu" type="number" class="form-control" placeholder="Masukkan Abu">
						                            <span class="help-block small pesan"></span>
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
		        			<button id="btnSubmit_kir" type="submit" class="btn btn-lg btn-info btn-outline waves-effect waves-light" value="<?= $btn ?>"><?= ucfirst($btn); ?></button>
		        			<a href="<?=base_url."index.php?m=kir&p=list" ?>" class="btn btn-lg btn-default btn-outline waves-effect waves-light">Batal</a>
		        		</div>
		        	</div>
		        </div>
		    </div>
		</div>
	</form>
</div>

<!-- js form -->
<script type="text/javascript" src="<?= base_url."app/views/kir/js/initForm.js"; ?>"></script>