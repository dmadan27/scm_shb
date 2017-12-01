<?php Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung"); ?>
<!-- Form Modal untuk Tambah dan Edit Data -->
<div class="modal fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="labelModalUser" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalUser">Form Data User</h4>
			</div>
			<form id="form_user" class="form-material" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_user" id="id_user">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<!-- Username -->
							<div class="form-group field-username has-feedback m-b-5">
								<label class="col-md-12" for="username">Username*</label>
		                        <div class="col-md-12">
		                            <input id="username" type="text" class="form-control" placeholder="Masukkan Username">
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>

							<!-- password -->
							<div class="form-group field-password has-feedback m-b-5">
								<label class="col-md-12" for="password">Password*</label>
		                        <div class="col-md-12">
		                            <input id="password" type="password" class="form-control" placeholder="Masukkan Password">
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>

							<!-- konfirmasi password -->
							<div class="form-group field-konfirmasi-password has-feedback m-b-5">
								<label class="col-md-12" for="konf_password">Konfirmasi Password*</label>
		                        <div class="col-md-12">
		                            <input id="konf_password" type="password" class="form-control" placeholder="Masukkan Konfirmasi Password">
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
						<div class="col-md-6">
							<!-- Jenis -->
							<div class="form-group field-jenis has-feedback m-b-5">
								<label class="col-md-12" for="jenis">Jenis User*</label>
		                        <div class="col-md-12">
		                            <select id="jenis" class="form-control"></select>
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>

							<!-- pengguna -->
							<div class="form-group field-pengguna has-feedback m-b-5">
								<label class="col-md-12" for="pengguna">Pengguna*</label>
		                        <div class="col-md-12">
		                            <select id="pengguna" class="select2 form-control">
		                            	<option value="">-- Pilih Pengguna --</option>
		                            </select>
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>

							<!-- hak akses -->
							<div class="form-group field-hak-akses has-feedback m-b-5">
								<label class="col-md-12" for="hak_akses">Hak Akses*</label>
		                        <div class="col-md-12">
		                            <select id="hak_akses" class="select2 select2-multiple form-control" multiple="multiple" data-placeholder="-- Pilih Hak Akses --">
		                            </select>
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>							
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<span class="help-block small">* Wajib Diisi</span>
						</div>
					</div>	
				</div>
				<div class="modal-footer">
                    <button id="btnSubmit_user" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="tambah">Tambah</button>
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>