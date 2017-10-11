<div class="modal fade" id="modal_supplier" tabindex="-1" role="dialog" aria-labelledby="labelModalSupplier" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalSupplier">Form Data Supplier</h4>
			</div>
			<form id="form_supplier" class="form-material" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_supplier" id="id_supplier">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<!-- NIK -->
							<div class="form-group field-nik has-feedback m-b-5">
								<label class="col-md-12" for="nik">NIK*</label>
		                        <div class="col-md-12">
		                            <input id="nik" type="text" class="form-control" placeholder="Masukkan NIK">
		                            <span class="help-block small pesan"></span>
		                        </div>
		                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
	                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
							</div>

							<!-- NPWP -->
							<div class="form-group field-npwp has-feedback m-b-5">
								<label class="col-md-12" for="npwp">NPWP</label>
		                        <div class="col-md-12">
		                            <input id="npwp" type="text" class="form-control" placeholder="Masukkan NPWP">
		                            <span class="help-block small pesan"></span>
		                        </div>
		                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
	                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
							</div>

							<!-- nama -->
							<div class="form-group field-nama has-feedback m-b-5">
								<label class="col-md-12" for="nama">Nama*</label>
		                        <div class="col-md-12">
		                            <input id="nama" type="text" class="form-control" placeholder="Masukkan Nama">
		                            <span class="help-block small pesan"></span>
		                        </div>
		                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
	                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
							</div>							
						</div>
						<div class="col-md-6">
							<!-- no telp -->
							<div class="form-group field-telp has-feedback m-b-5">
								<label class="col-md-12" for="telp">No. Telepon</label>
		                        <div class="col-md-12">
		                            <input id="telp" type="text" class="form-control" placeholder="Masukkan No. Telepon">
		                            <span class="help-block small pesan"></span>
		                        </div>
		                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
	                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
							</div>

							<!-- alamat -->
							<div class="form-group field-alamat has-feedback m-b-5">
								<label class="col-md-12" for="alamat">Alamat</label>
		                        <div class="col-md-12">
		                            <textarea id="alamat" class="form-control" rows="5" placeholder="Masukkan Alamat"></textarea>
		                            <span class="help-block small pesan"></span>
		                        </div>
		                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
	                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
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
						<div class="col-md-6">
							<!-- supplier asli -->
							<div class="form-group field-supplier-inti has-feedback m-b-5">
								<label class="col-md-12" for="supplier_inti">Supplier Inti**</label>
		                        <div class="col-md-12">
		                            <select id="supplier_inti" class="form-control select2"></select>
		                            <span class="help-block small pesan"></span>
		                        </div>
		                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
	                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<span class="help-block small">* Wajib Diisi</span>
							<span class="help-block small">** Wajib Diisi Jika Status Supplier adalah Pengganti</span>
						</div>
					</div>	
				</div>
				<div class="modal-footer">
                    <button id="btnSubmit_supplier" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="tambah">Tambah</button>
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>