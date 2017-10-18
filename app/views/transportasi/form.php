<?php

?>
<!-- Date picker plugins css -->
<link href="<?= base_url."assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css"; ?>" rel="stylesheet" type="text/css" />
<!-- Date Picker Plugin JavaScript -->
<script src="<?= base_url."assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"; ?>"></script>

<div class="modal fade" id="modal_transportasi" tabindex="-1" role="dialog" aria-labelledby="labelModalKendaraan" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalTransportasi">Form Data Transportasi</h4>
			</div>
			<form id="form_kendaraan" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_transportasi" id="id_transportasi">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<!-- nopolis -->
							<div class="form-group field-nopol has-feedback m-b-5">
								<label class="col-md-12" for="nopol">Nopol Kendaraan*</label>
		                        <div class="col-md-12">
		                            <input id="nopol" type="text" class="form-control" placeholder="Masukkan Nopol Kendaraan">
		                            <span class="help-block small pesan"></span>
		                        </div>
		                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
	                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
							</div>

							<!-- tahun -->
							<div class="form-group field-tahun has-feedback m-b-5">
								<label class="col-md-12" for="tahun">Tahun</label>
		                        <div class="col-md-12">
		                            <input id="tahun" type="text" class="form-control" placeholder="Masukkan Tahun">
		                            <span class="help-block small pesan"></span>
		                        </div>
		                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
	                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
							</div>

							<!-- jenis -->
							<div class="form-group field-jenis has-feedback m-b-5">
								<label class="col-md-12" for="jenis">Jenis*</label>
		                        <div class="col-md-12">
		                            <select id="jenis" class="form-control"></select>
		                            <span class="help-block small pesan"></span>
		                        </div>
		                        <span class="glyphicon glyphicon-remove form-control-feedback t-0 setError" style="display: none;"></span>
	                            <span class="glyphicon glyphicon-ok form-control-feedback t-0 setSuccess" style="display: none;"></span>
							</div>							
						</div>
						<div class="col-md-6">
							<!-- muatan -->
							<div class="form-group field-muatan has-feedback m-b-5">
								<label class="col-md-12" for="muatan">Muatan</label>
		                        <div class="col-md-12">
		                            <input id="muatan" type="number" class="form-control" placeholder="Masukkan Muatan (Satuan Kg)">
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