<div class="modal fade" id="modal_karyawan" tabindex="-1" role="dialog" aria-labelledby="labelModalKaryawan" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalKaryawan">Form Data Karyawan</h4>
			</div>
			<form id="form_karyawan" class="form-material" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_karyawan" id="id_karyawan">
				<div class="modal-body">
					<div class="sttabs tabs-style-line">
						<nav>
                            <ul>
                                <li><a href="#data-diri" class="data-diri"><span>Data Diri</span></a></li>
                                <li><a href="#data-karyawan"><span>Data Karyawan</span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                        	<section id="data-diri">
								<div class="row">
									<div class="col-md-6">
										<!-- NIK -->
										<div class="form-group field-nik has-feedback m-b-5">
											<label class="col-md-12" for="nik">NIK*</label>
					                        <div class="col-md-12">
					                            <input id="nik" type="text" class="form-control field" placeholder="Masukkan NIK">
					                            <span class="help-block small pesan"></span>
					                        </div>
					                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
										</div>

										<!-- NPWP -->
										<div class="form-group field-npwp has-feedback m-b-5">
											<label class="col-md-12" for="npwp">NPWP</label>
					                        <div class="col-md-12">
					                            <input id="npwp" type="text" class="form-control field" placeholder="Masukkan NPWP">
					                            <span class="help-block small pesan"></span>
					                        </div>
					                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
										</div>

										<!-- nama -->
										<div class="form-group field-nama has-feedback m-b-5">
											<label class="col-md-12" for="nama">Nama*</label>
					                        <div class="col-md-12">
					                            <input id="nama" type="text" class="form-control field" placeholder="Masukkan Nama">
					                            <span class="help-block small pesan"></span>
					                        </div>
					                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
										</div>
										
										<!-- no telp -->
										<div class="form-group field-telp has-feedback m-b-5">
											<label class="col-md-12" for="telp">No. Telepon</label>
					                        <div class="col-md-12">
					                            <input id="telp" type="text" class="form-control field" placeholder="Masukkan No. Telepon">
					                            <span class="help-block small pesan"></span>
					                        </div>
					                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
										</div>
									</div>
									<div class="col-md-6">
										<!-- email -->
										<div class="form-group field-email has-feedback m-b-5">
											<label class="col-md-12" for="email">Email</label>
					                        <div class="col-md-12">
					                            <input id="email" type="email" class="form-control field" placeholder="Masukkan Email">
					                            <span class="help-block small pesan"></span>
					                        </div>
					                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
										</div>

										<!-- alamat -->
										<div class="form-group field-alamat has-feedback m-b-5">
											<label class="col-md-12" for="alamat">Alamat</label>
					                        <div class="col-md-12">
					                            <textarea id="alamat" class="form-control field" rows="5" placeholder="Masukkan Alamat"></textarea>
					                            <span class="help-block small pesan"></span>
					                        </div>
					                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
										</div>
											
										<!-- foto -->
										<div class="form-group field-foto has-feedback m-b-5">
		                                    <label class="col-sm-12">Upload Foto</label>
		                                    <div class="col-sm-12">
		                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
		                                            <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">Pilih Foto</span> <span class="fileinput-exists">Ganti</span>
		                                            <input type="file" name="foto" id="foto"> </span> <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Hapus</a>
		                                        </div>
		                                        <span class="help-block small pesan"></span>
		                                    </div>
		                                    <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
		                                </div>
									</div>
								</div>										
                            </section>
                            <section id="data-karyawan">
                                <div class="row">
									<div class="col-md-6">
										<!-- No. Induk -->
										<div class="form-group field-no-induk has-feedback m-b-5">
											<label class="col-md-12" for="no_induk">No. Induk Karyawan*</label>
					                        <div class="col-md-12">
					                            <input id="no_induk" type="text" class="form-control field" placeholder="Masukkan No. Induk Karyawan">
					                            <span class="help-block small pesan"></span>
					                        </div>
					                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
										</div>

										<!-- Jabatan -->
										<div class="form-group field-jabatan has-feedback m-b-5">
											<label class="col-md-12" for="jabatan">Jabatan*</label>
					                        <div class="col-md-12">
					                            <select id="jabatan" class="form-control field"></select>
					                            <span class="help-block small pesan"></span>
					                        </div>
					                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
										</div>
									</div>
									<div class="col-md-6">
										<!-- Gaji Pokok -->
										<div class="form-group field-gaji has-feedback m-b-5">
											<label class="col-md-12" for="gaji">Gaji Pokok*</label>
					                        <div class="col-md-12">
					                            <input id="gaji" type="number" class="form-control field" placeholder="Masukkan Gaji Pokok" min="0">
					                            <span class="help-block small pesan"></span>
					                        </div>
					                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
										</div>

										<!-- status -->
										<div class="form-group field-status has-feedback m-b-5">
											<label class="col-md-12" for="status">Status*</label>
					                        <div class="col-md-12">
					                            <select id="status" class="form-control"></select>
					                            <span class="help-block small pesan"></span>
					                        </div>
					                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
				                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
										</div>
									</div>
								</div>
                            </section>
                        </div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<span class="help-block small">* Wajib Diisi</span>
						</div>
					</div>	
				</div>
				<div class="modal-footer">
                    <button id="btnSubmit_karyawan" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="tambah">Tambah</button>
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>