<?php Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung"); ?>
<!-- Form Modal untuk Tambah dan Edit Data -->
<div class="modal fade" id="modal_buyer" tabindex="-1" role="dialog" aria-labelledby="labelModalBuyer" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalBuyer">Form Data Buyer</h4>
			</div>
			<form id="form_buyer" class="form-material" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_buyer" id="id_buyer">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<!-- NPWP -->
							<div class="form-group field-npwp has-feedback m-b-5">
								<label class="col-md-12" for="npwp">NPWP</label>
		                        <div class="col-md-12">
		                            <input id="npwp" type="text" class="form-control" placeholder="Masukkan NPWP">
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>

							<!-- nama -->
							<div class="form-group field-nama has-feedback m-b-5">
								<label class="col-md-12" for="nama">Nama*</label>
		                        <div class="col-md-12">
		                            <input id="nama" type="text" class="form-control" placeholder="Masukkan Nama Buyer">
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>
							<!-- alamat -->
							<div class="form-group field-alamat has-feedback m-b-5">
								<label class="col-md-12" for="alamat">Alamat</label>
		                        <div class="col-md-12">
		                            <textarea id="alamat" class="form-control" rows="3" placeholder="Masukkan Alamat"></textarea>
		                            <span class="help-block small pesan"></span>
		                        </div>
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
							</div>

							<!-- email -->
							<div class="form-group field-email has-feedback m-b-5">
								<label class="col-md-12" for="email">Email</label>
		                        <div class="col-md-12">
		                            <input id="email" type="email" class="form-control" placeholder="Masukkan Email">
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
					</div>
					<div class="row">
						<div class="col-md-12">
							<span class="help-block small">* Wajib Diisi</span>
						</div>
					</div>	
				</div>
				<div class="modal-footer">
                    <button id="btnSubmit_buyer" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="tambah">Tambah</button>
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>