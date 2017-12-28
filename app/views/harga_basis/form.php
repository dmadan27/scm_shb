<?php
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
?>
<!-- Form Modal untuk Tambah dan Edit Data -->
<div class="modal fade" id="modal_hargaBasis" tabindex="-1" role="dialog" aria-labelledby="labelModalHargaBasis" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalHargaBasis">Form Data Harga Basis</h4>
			</div>
			<form id="form_hargaBasis" class="form-material" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_harga_basis" id="id_harga_basis">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<!-- tgl -->
							<div class="form-group field-tgl has-feedback m-b-5">
								<label class="col-md-12" for="tgl">Tanggal*</label>
		                        <div class="col-md-12">
		                            <input id="tgl" type="text" class="form-control datepicker field" placeholder="Masukkan Tanggal">
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>
							<!-- jenis -->
							<div class="form-group field-jenis has-feedback m-b-5">
								<label class="col-md-12" for="jenis">Jenis Basis*</label>
		                        <div class="col-md-12">
		                            <select id="jenis" class="form-control"></select>
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>
							<!-- harga basis -->
							<div class="form-group field-harga-basis has-feedback m-b-5">
								<label class="col-md-12" for="harga_basis">Harga Basis*</label>
		                        <div class="col-md-12">
		                            <input id="harga_basis" type="number" class="form-control" placeholder="Masukkan Harga Basis" min="0">
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
                    <button id="btnSubmit_hargaBasis" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="tambah">Tambah</button>
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>