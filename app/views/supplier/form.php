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
		                            <span class="help-block small"></span>
		                        </div>
							</div>

							<!-- NPWP -->
							<div class="form-group field-npwp">
								<label class="col-md-12" for="npwp">NPWP*</label>
		                        <div class="col-md-12">
		                            <input id="npwp" type="text" class="form-control" placeholder="Masukkan NPWP">
		                            <span class="help-block small"></span>
		                        </div>
							</div>

							<!-- nama -->
							<div class="form-group field-nama">
								<label class="col-md-12" for="nama">Nama*</label>
		                        <div class="col-md-12">
		                            <input id="nama" type="text" class="form-control" placeholder="Masukkan Nama">
		                            <span class="help-block small"></span>
		                        </div>
							</div>							
						</div>
						<div class="col-md-6">
							<!-- no telp -->
							<div class="form-group field-telp">
								<label class="col-md-12" for="telp">No. Telepon</label>
		                        <div class="col-md-12">
		                            <input id="telp" type="text" class="form-control" placeholder="Masukkan No. Telepon">
		                            <span class="help-block small"></span>
		                        </div>
							</div>

							<!-- alamat -->
							<div class="form-group field-alamat">
								<label class="col-md-12" for="alamat">Alamat</label>
		                        <div class="col-md-12">
		                            <textarea id="alamat" class="form-control" rows="5" placeholder="Masukkan Alamat"></textarea>
		                            <span class="help-block small"></span>
		                        </div>
							</div>

							<!-- foto -->
							<div class="form-group field-foto">
                                <label class="col-sm-12" for="foto">Upload Foto</label>
                                <div class="col-sm-12">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput">
                                        	<i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        	<span class="fileinput-filename"></span>
                                        </div> 
                                        <span class="input-group-addon btn btn-default btn-file"> 
                                        	<span class="fileinput-new">Pilih Foto</span>
                                        	<span class="fileinput-exists">Ganti</span>
                                        	<input type="file" name="foto" id="foto"> 
                                        </span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Hapus</a> 
                                    </div>
                                    <span class="help-block small"></span>
                                </div>
                            </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<!-- status -->
							<div class="form-group field-status">
								<label class="col-md-12" for="status">Status*</label>
		                        <div class="col-md-12">
		                            <select id="status" class="form-control"></select>
		                            <span class="help-block small"></span>
		                        </div>
							</div>
						</div>
						<div class="col-md-6">
							<!-- supplier asli -->
							<div class="form-group field-supplier-inti">
								<label class="col-md-12" for="supplier_inti">Supplier Inti**</label>
		                        <div class="col-md-12">
		                            <select id="supplier_inti" class="form-control select2"></select>
		                            <span class="help-block small"></span>
		                        </div>
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
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>