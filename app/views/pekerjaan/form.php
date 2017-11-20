<?php
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
?>
<!-- Form Modal untuk Tambah dan Edit Data -->
<div class="modal fade" id="modal_pekerjaan" tabindex="-1" role="dialog" aria-labelledby="labelModalPekerjaan" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalPekerjaan">Form Data Pekerjaan</h4>
			</div>
			<form id="form_pekerjaan" class="form-material" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_pekerjaan" id="id_pekerjaan">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<!-- nama / jabatan / pekerjaan -->
							<div class="form-group field-nama has-feedback m-b-5">
								<label class="col-md-12" for="nama">Jabatan / Pekerjaan*</label>
		                        <div class="col-md-12">
		                            <input id="nama" type="text" class="form-control" placeholder="Jabatan / Pekerjaan">
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>
							<div class="form-group field-ket has-feedback m-b-5">
								<label class="col-md-12" for="ket">Keterangan</label>
		                        <div class="col-md-12">
		                            <textarea id="ket" class="form-control" rows="6" placeholder="Masukkan Keterangan"></textarea>
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
                    <button id="btnSubmit_pekerjaan" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="tambah">Tambah</button>
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>