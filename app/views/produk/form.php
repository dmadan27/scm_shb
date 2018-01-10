<?php 
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
	$id = isset($_GET['id']) ? $_GET['id'] : false;
	$btn = $id ? "edit" : "tambah"; 
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Form <?= ucfirst($btn); ?> Data Produk</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li>Data Master</li>
            <li class="active">Data Produk</li>
        </ol>
    </div>
</div>
<div class="form-produk">
	<form id="form_produk" class="form-material" role="form" enctype="multipart/form-data">
		<!-- panel form data Produk -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
							<input type="hidden" name="id_produk" id="id_produk">
			    	 		<div class="row">
			    	 			<div class="col-md-6">
			    	 				<fieldset>
			    	 					<legend>Data Produk</legend>
			    	 					<!-- kode produk -->
										<div class="form-group field-kd-produk has-feedback m-b-5">
											<label class="col-md-12" for="kd_produk">Kode Produk*</label>
					                        <div class="col-md-12">
					                            <input id="kd_produk" type="text" class="form-control" placeholder="Masukkan Kode Produk">
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>

										<!-- nama -->
										<div class="form-group field-nama has-feedback m-b-5">
											<label class="col-md-12" for="nama">Nama*</label>
					                        <div class="col-md-12">
					                            <input id="nama" type="text" class="form-control" placeholder="Masukkan Nama">
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>

										<!-- satuan -->
										<div class="form-group field-satuan has-feedback m-b-5">
											<label class="col-md-12" for="satuan">Satuan*</label>
					                        <div class="col-md-12">
					                            <select id="satuan" class="form-control"></select>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>	

										<!-- ket -->
										<div class="form-group field-ket has-feedback m-b-5">
											<label class="col-md-12" for="ket">Keterangan</label>
					                        <div class="col-md-12">
					                            <textarea id="ket" class="form-control" rows="3" placeholder="Masukkan Keterangan"></textarea>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>

										<!-- foto -->
										<div class="form-group field-foto has-feedback m-b-5">
			                                <label class="col-md-12">Foto</label>
			                                <div class="col-md-12">
					                            <input id="foto" type="file" class="form-control">
					                            <span class="help-block small pesan"></span>
					                        </div>
			                            </div>

										<!-- stok awal -->
										<div class="form-group field-stok has-feedback m-b-5">
											<label class="col-md-12" for="stok">Stok Awal*</label>
					                        <div class="col-md-12">
					                        	<div class="input-group">
					                        		<input id="stok" type="number" min="0" class="form-control" placeholder="Masukkan Stok Awal">
					                        		<span class="input-group-addon satuan-stok"></span>
					                        	</div>
					                            <span class="help-block small pesan"></span>
					                        </div>
										</div>
			    	 				</fieldset>		
			    	 			</div>
			    	 			<div class="col-md-6">
			    	 				<fieldset>
			    	 					<legend>Data Komposisi Produk</legend>
			    	 					<div class="row">
			    	 						<div class="col-md-6">
			    	 							<!-- bahan baku -->
												<div class="form-group field-bahan-baku has-feedback m-b-5">
													<label class="col-md-12" for="bahan_baku">Bahan Baku*</label>
							                        <div class="col-md-12">
						                            	<select id="bahan_baku" class="form-control select2"></select> 
							                            <span class="help-block small pesan"></span>
							                        </div>
												</div>
			    	 						</div>
			    	 						<div class="col-md-6">
			    	 							<!-- penyusutan -->
												<div class="form-group field-penyusutan has-feedback m-b-5">
													<label class="col-md-12" for="penyusutan">Penyusutan*</label>
							                        <div class="col-md-12">
							                            <div class="input-group">
							                            	<input id="penyusutan" type="number" min="0" step="0.01" class="form-control" placeholder="Masukkan Penyusutan">
							                            	<span class="input-group-addon">
							                            		%
							                            	</span>
							                            	<span class="input-group-btn">
							                            		<button type="button" id="btnTambah_komposisi" class="btn btn-danger btn-outline waves-effect waves-light" title="Tambah Data"><i class="fa fa-plus"></i></button>
							                            	</span>
							                            </div>
							                            <span class="help-block small pesan"></span>
							                        </div>
												</div>
			    	 						</div>
			    	 					</div>
					    	 					
										<!-- Tabel komposisi -->
										<div class="table-responsive">
											<table id="tabel_komposisi" class="table table-bordered table-hover">
												<thead>
													<tr>
														<th style="width: 15px">No</th>
														<th>Kode</th>
														<th>Bahan Baku</th>
														<th>Penyusutan</th>
														<th>Aksi</th>
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
		        			<button id="btnSubmit_produk" type="submit" class="btn btn-lg btn-info btn-outline waves-effect waves-light" value="<?= $btn ?>"><?= ucfirst($btn); ?></button>
		        			<a href="<?=base_url."index.php?m=produk&p=list" ?>" class="btn btn-lg btn-default btn-outline waves-effect waves-light">Batal</a>
		        		</div>
		        	</div>
		        </div>
		    </div>
		</div>
	</form>
</div>

<script type="text/javascript">
    var listKomposisi = [];
    var indexKomposisi = 0;
</script>
<!-- js form -->
<script type="text/javascript" src="<?= base_url."app/views/produk/js/initForm.js"; ?>"></script>