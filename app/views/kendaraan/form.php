<?php Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung"); ?>

<div class="modal fade" id="modal_kendaraan" tabindex="-1" role="dialog" aria-labelledby="labelModalKendaraan" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalKendaraan">Form Data Transportasi</h4>
			</div>
			<form id="form_kendaraan" class="form-material" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_kendaraan" id="id_kendaraan">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<!-- nopolis -->
							<div class="form-group field-no-polis has-feedback m-b-5">
								<label class="col-md-12" for="no_polis">Nopol Kendaraan*</label>
		                        <div class="col-md-12">
		                            <input id="no_polis" type="text" class="form-control field" placeholder="Masukkan Nopol Kendaraan">
		                            <span class="help-block small pesan"></span>
		                        </div>                   
							</div>

							<!-- supir -->
							<div class="form-group field-supir has-feedback m-b-5">
								<label class="col-md-12" for="supir">Supir*</label>
		                        <div class="col-md-12">
		                            <select id="supir" class="form-control field select2"></select>
		                            <span class="help-block small pesan"></span>
		                        </div>                   
							</div>

							<!-- pendamping -->
							<div class="form-group field-pendamping has-feedback m-b-5">
								<label class="col-md-12" for="pendamping">Pendamping</label>
		                        <div class="col-md-12">
		                            <input id="pendamping" type="text" class="form-control field" placeholder="Masukkan Pendamping">
		                            <span class="help-block small pesan"></span>
		                        </div>                   
							</div>

							<!-- status -->
							<div class="form-group field-status has-feedback m-b-5">
								<label class="col-md-12" for="status">Status*</label>
		                        <div class="col-md-12">
		                            <select id="status" class="form-control field"></select>
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>							
						</div>
						<div class="col-md-6">
							<!-- tahun -->
							<div class="form-group field-tahun has-feedback m-b-5">
								<label class="col-md-12" for="tahun">Tahun</label>
		                        <div class="col-md-12">
		                            <input id="tahun" type="text" class="form-control field" placeholder="Masukkan Tahun">
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>

							<!-- jenis -->
							<div class="form-group field-jenis has-feedback m-b-5">
								<label class="col-md-12" for="jenis">Jenis*</label>
		                        <div class="col-md-12">
		                            <select id="jenis" class="form-control field"></select>
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>

							<!-- muatan -->
							<div class="form-group field-muatan has-feedback m-b-5">
								<label class="col-md-12" for="muatan">Muatan*</label>
		                        <div class="col-md-12">
		                            <input id="muatan" type="number" min="0" class="form-control field" placeholder="Masukkan Muatan (Satuan Kg)">
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
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<span class="help-block small">* Wajib Diisi</span>
						</div>
					</div>	
				</div>
				<div class="modal-footer">
                    <button id="btnSubmit_kendaraan" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="tambah">Tambah</button>
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>