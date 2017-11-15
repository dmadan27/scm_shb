<?php
	$id = isset($_GET['id']) ? $_GET['id'] : false;

	$btn = $id ? "edit" : "tambah";
	// if($id) $btn = "edit";
	// else $btn = "tambah";
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Form Data Karyawan</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li>Data Master</li>
            <li class="active">Data Karyawan</li>
        </ol>
    </div>
</div>

<div class="form-karyawan">
	<form id="form_karyawan" class="form-material" role="form" enctype="multipart/form-data">
		<!-- panel form data diri -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		Data Diri
		    		 	<div class="panel-action">
		        		 	<a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
					 	</div>
		        	</div>
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
							<input type="hidden" name="id_karyawan" id="id_karyawan">
			    	 		<div class="row">
			    	 			<div class="col-md-6">
			    	 				<!-- NIK -->
									<div class="form-group field-nik has-feedback m-b-5">
										<label class="col-md-12" for="nik">NIK</label>
				                        <div class="col-md-12">
				                            <input id="nik" type="text" class="form-control field" placeholder="Masukkan NIK">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- NPWP -->
									<div class="form-group field-npwp has-feedback m-b-5">
										<label class="col-md-12" for="npwp">NPWP</label>
				                        <div class="col-md-12">
				                            <input id="npwp" type="text" class="form-control field" placeholder="Masukkan NPWP">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- nama -->
									<div class="form-group field-nama has-feedback m-b-5">
										<label class="col-md-12" for="nama">Nama*</label>
				                        <div class="col-md-12">
				                            <input id="nama" type="text" class="form-control field" placeholder="Masukkan Nama">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- tmpt lahir dan tgl lahir -->
									<div class="row">
										<div class="col-md-6">
											<!-- tempat lahir -->
											<div class="form-group field-tempat-lahir has-feedback m-b-5">
												<label class="col-md-12" for="tempat_lahir">Tempat Lahir</label>
						                        <div class="col-md-12">
						                            <input id="tempat_lahir" type="text" class="form-control field" placeholder="Masukkan Tempat Lahir">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
										</div>
										<div class="col-md-6">
											<!-- tgl lahir -->
											<div class="form-group field-tgl-lahir has-feedback m-b-5">
												<label class="col-md-12" for="tgl_lahir">Tanggal Lahir</label>
						                        <div class="col-md-12">
						                            <input id="tgl_lahir" type="text" class="form-control datepicker field" placeholder="Masukkan Tanggal Lahir">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
										</div>								
									</div>

									<!-- jk -->
									<div class="form-group field-jk has-feedback m-b-5">
										<label class="col-md-12">Jenis Kelamin</label>
				                        <div class="col-md-12">
				                        	<div class="col-md-6">
				                        		<!-- laki2 -->
						                        <div class="radio radio-success">
						                        	<input type="radio" name="jk" id="jk_laki" value="L">
		                                            <label for="jk_laki"> Laki-Laki </label>
						                        </div>
				                        	</div>
				                        	<div class="col-md-6">
				                        		<!-- perempuan -->
						                        <div class="radio radio-success">
						                        	<input type="radio" name="jk" id="jk_perempuan" value="P">
		                                            <label for="jk_perempuan"> Perempuan </label>
						                        </div>
				                        	</div>
				                        </div>
				                        <span class="help-block small pesan"></span>
									</div>
			    	 			</div>
			    	 			<div class="col-md-6">
			    	 				<!-- alamat -->
									<div class="form-group field-alamat has-feedback m-b-5">
										<label class="col-md-12" for="alamat">Alamat</label>
				                        <div class="col-md-12">
				                            <textarea id="alamat" class="form-control field" rows="6" placeholder="Masukkan Alamat"></textarea>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- no telp -->
									<div class="form-group field-telp has-feedback m-b-5">
										<label class="col-md-12" for="telp">No. Telepon</label>
				                        <div class="col-md-12">
				                            <input id="telp" type="text" class="form-control field" placeholder="Masukkan No. Telepon">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- email -->
									<div class="form-group field-email has-feedback m-b-5">
										<label class="col-md-12" for="email">Email</label>
				                        <div class="col-md-12">
				                            <input id="email" type="email" class="form-control field" placeholder="Masukkan Email">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- foto -->
									<div class="form-group field-foto has-feedback m-b-5">
		                                <label class="col-md-12">Upload Foto</label>
		                                <div class="col-md-12">
				                            <input id="foto" type="file" class="form-control">
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
		<!-- panel form data karyawan -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		Data Karyawan
		    		 	<div class="panel-action">
		        		 	<a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
					 	</div>
		        	</div>
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
			 				<div class="row">
			    	 			<div class="col-md-6">
			    	 				<!-- No Induk -->
									<div class="form-group field-no-induk has-feedback m-b-5">
										<label class="col-md-12" for="no_induk">No. Induk Karyawan</label>
				                        <div class="col-md-12">
				                            <input id="no_induk" type="text" class="form-control field" placeholder="Masukkan No. Induk">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- tgl masuk -->
									<div class="form-group field-tgl-masuk has-feedback m-b-5">
										<label class="col-md-12" for="tgl_masuk">Tanggal Masuk</label>
				                        <div class="col-md-12">
				                            <input id="tgl_masuk" type="text" class="form-control datepicker field" placeholder="Masukkan Tanggal Masuk">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- jabatan -->
									<div class="form-group field-jabatan has-feedback m-b-5">
										<label class="col-md-12" for="jabatan">Jabatan</label>
				                        <div class="col-md-12">
				                            <select id="jabatan" class="form-control field"></select>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
			    	 			</div>
			    	 			<div class="col-md-6">
									<!-- gaji pokok -->
									<div class="form-group field-gaji has-feedback m-b-5">
										<label class="col-md-12" for="gaji">Gaji Pokok</label>
				                        <div class="col-md-12">
				                            <input id="gaji" type="text" class="form-control field" placeholder="Masukkan Gaji Pokok">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>

									<!-- status -->
									<div class="form-group field-status has-feedback m-b-5">
										<label class="col-md-12" for="status">Status</label>
				                        <div class="col-md-12">
				                            <select id="status" class="form-control field"></select>
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
		        		<div class="text-right">
		        			<button id="btnSubmit_karyawan" type="submit" class="btn btn-lg btn-info btn-outline waves-effect waves-light" value="<?= $btn ?>"><?= ucfirst($btn); ?></button>
		        			<a href="<?=base_url."index.php?m=karyawan&p=list" ?>" class="btn btn-lg btn-default btn-outline waves-effect waves-light">Batal</a>
		        		</div>
		        	</div>
		        </div>
		    </div>
		</div>
	</form>
</div>
	
<!-- js form -->
<script type="text/javascript" src="<?= base_url."app/views/karyawan/js/initForm.js"; ?>"></script>