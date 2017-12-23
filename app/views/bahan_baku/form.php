<?php Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung"); ?>
<!-- Form Modal untuk Tambah dan Edit Data -->
<div class="modal fade" id="modal_bahan_baku" tabindex="-1" role="dialog" aria-labelledby="labelModalBahanBaku" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalBahanBaku">Form Data Bahan Baku</h4>
			</div>
			<form id="form_bahan_baku" class="form-material" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_bahan_baku" id="id_bahan_baku">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<!-- kode bahan baku -->
							<div class="form-group field-kd-bahan-baku has-feedback m-b-5">
								<label class="col-md-12" for="kd_bahan_baku">Kode Bahan Baku</label>
		                        <div class="col-md-12">
		                            <input id="kd_bahan_baku" type="text" class="form-control" placeholder="Masukkan Kode Bahan Baku">
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>

							<!-- nama -->
							<div class="form-group field-nama has-feedback m-b-5">
								<label class="col-md-12" for="nama">Nama*</label>
		                        <div class="col-md-12">
		                            <input id="nama" type="text" class="form-control" placeholder="Masukkan Nama">
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>

							<!-- satuan -->
							<div class="form-group field-satuan has-feedback m-b-5">
								<label class="col-md-12" for="satuan">Satuan*</label>
		                        <div class="col-md-12">
		                            <select id="satuan" class="form-control"></select>
		                            <span class="help-block small pesan"></span>
		                        </div>
							</div>							
						</div>
						<div class="col-md-6">
							<!-- ket -->
							<div class="form-group field-ket has-feedback m-b-5">
								<label class="col-md-12" for="ket">Keterangan</label>
		                        <div class="col-md-12">
		                            <textarea id="ket" class="form-control" rows="3" placeholder="Masukkan Keterangan"></textarea>
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

							<!-- stok awal -->
							<div class="form-group field-stok has-feedback m-b-5">
								<label class="col-md-12" for="stok">Stok Awal</label>
		                        <div class="col-md-12">
		                            <input id="stok" type="number" min="0" class="form-control" placeholder="Masukkan Stok Awal">
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
                    <button id="btnSubmit_bahan_baku" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="tambah">Tambah</button>
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>