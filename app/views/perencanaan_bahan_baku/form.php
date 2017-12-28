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
<div class="form-peramalan">
	<form id="form_peramalan" class="form-material" role="form" enctype="multipart/form-data">
		<!-- panel form -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
							<input type="hidden" name="id_peramalan" id="id_peramalan">
			    	 		<div class="row">
			    	 			<div class="col-md-6">
			    	 				<fieldset>
			    	 					<legend>Data Peramalan</legend>
			    	 					<!-- Tanggal -->
										<div class="form-group field-tgl has-feedback m-b-5">
											<label class="col-md-12" for="tgl">Tanggal Peramalan Dilakukan*</label>
					                        <div class="col-md-12">
					                            <input id="tgl" type="text" class="form-control datepicker" placeholder="Masukkan Tanggal">
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>

										<!-- bulan dan tahun -->
										<div class="row">
											<div class="col-md-6">
												<!-- Bulan -->
												<div class="form-group field-bulan has-feedback m-b-5">
													<label class="col-md-12" for="bulan">Bulan*</label>
							                        <div class="col-md-12">
							                            <select id="bulan" class="form-control"></select>
							                            <span class="help-block small pesan"></span>
							                        </div>
												</div>
											</div>
											<div class="col-md-6">
												<!-- Tahun -->
												<div class="form-group field-tahun has-feedback m-b-5">
													<label class="col-md-12" for="tahun">Tahun*</label>
							                        <div class="col-md-12">
							                            <input id="tahun" type="text" class="form-control" placeholder="Masukkan Tahun">
							                            <span class="help-block small pesan"></span>
							                        </div>
												</div>
											</div>
										</div>

										<!-- Produk -->
										<div class="form-group field-produk has-feedback m-b-5">
											<label class="col-md-12" for="produk">Produk</label>
					                        <div class="col-md-12">
					                            <select id="produk" class="form-control select2"></select>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>

										<!-- button proses peramalan -->
										<div class="form-group field-produk has-feedback m-b-5">
					                        <div class="col-md-12 text-right">
					                            <button id="btnHitung_peramalan" type="button" class="btn btn-danger btn-outline waves-effect waves-light" value="hitung">Hitung Peramalan</button>
					                        </div>
										</div>
			    	 				</fieldset>		
			    	 			</div>
			    	 			<div class="col-md-6">
			    	 				<fieldset>
			    	 					<legend>Hasil Peramalan</legend>
			    	 					<!-- Hasil Peramalan -->
										<div class="form-group field-hasil-peramalan has-feedback m-b-5">
											<label class="col-md-12" for="hasil_peramalan">Hasil Peramalan*</label>
					                        <div class="col-md-12">
					                        	<div class="input-group">
					                        		<input id="hasil_peramalan" type="text" class="form-control" placeholder="Hasil Peramalan">
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
		        			<button id="btnSubmit_peramalan" type="submit" class="btn btn-lg btn-info btn-outline waves-effect waves-light" value="<?= $btn ?>"><?= ucfirst($btn); ?></button>
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