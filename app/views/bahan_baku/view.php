<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
    $id = isset($_GET['id']) ? $_GET['id'] : false;
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Lihat Detail Data Bahan Baku</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li>Data Master</li>
            <li class="active">Data Bahan Baku</li>
        </ol>
    </div>
</div>
<div class="row">
	<!-- panel foto -->
	<div class="col-md-4 col-xs-12">
        <div class="white-box">
            <div class="user-bg">
                <div class="overlay-box">
                    <div class="user-content">
                        <a href="javascript:void(0)" data-effect="mfp-zoom-in"><img src="javascript:;" class="thumb-lg img-circle" alt="Foto Bahan Baku"/></a>
                        <h4 class="text-white">Nama</h4>
                        <h5 class="text-white">Bahan Baku</h5>
                    </div>
                </div>
            </div>
            <div class="user-btm-box">
            	<!-- edit data -->
                <div class="col-md-4 col-sm-4 text-center">
                	<button id="btnEdit_data" type="button" class="btn btn-lg btn-info btn-outline btn-circle m-r-5" data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="ti-pencil-alt"></i></button>
                </div>
                <!-- edit foto -->
                <div class="col-md-4 col-sm-4 text-center">
                    <button id="btnEdit_foto" type="button" class="btn btn-lg btn-success btn-outline btn-circle m-r-5" data-toggle="tooltip" data-placement="top" title="Edit Foto"><i class="ti-camera"></i></button>
                </div>
                <!-- kembali -->
                <div class="col-md-4 col-sm-4 text-center">
                    <button id="btnKembali" type="button" class="btn btn-lg btn-primary btn-outline btn-circle m-r-5" data-toggle="tooltip" data-placement="top" title="Kembali"><i class="ti-back-left"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!-- panel info lengkap -->
    <div class="col-md-8 col-xs-12">
        <div class="white-box">
        	<div class="sttabs tabs-style-linetriangle">
                <nav>
                    <ul>
                        <li><a href="#section-data-bahan-baku"><span>Data Bahan Baku</span></a></li>
                        <li><a href="#section-data-mutasi-bahan-baku"><span>Data Mutasi Bahan Baku</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-data-buyer">
						<!-- Kode bahan baku -->
                        <div class="form-group m-b-5">
							<label>Kode Bahan Baku:</label>
                            <p class="form-control-static" id="info_kd_bahan_baku">Info Bahan Baku</p>
						</div>
						<!-- nama -->
                        <div class="form-group m-b-5">
							<label>Nama Bahan Baku:</label>
                            <p class="form-control-static" id="info_nama">Info Nama Bahan Baku</p>
						</div>
						<!-- satuan -->
                        <div class="form-group m-b-5">
							<label>Satuan:</label>
                            <p class="form-control-static" id="info_satuan">Info Satuan</p>
						</div>
						<!-- keterangan -->
                        <div class="form-group m-b-5">
							<label>Keterangan:</label>
                            <p class="form-control-static" id="info_ket">Info Keterangan</p>
						</div>
						<!-- Stok -->
                        <div class="form-group m-b-5">
							<label>Stok:</label>
                            <p class="form-control-static" id="info_stok">Info Stok</p>
						</div>
                    </section>
                    <section id="section-data-mutasi-bahan-baku">
                        <table id="tabel_mutasi_bahan_baku" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
    	 					<thead>
    	 						<tr>
    	 							<th style="width: 15px">No</th>
    	 							<th>Tanggal</th>
                                    <th>Barang Masuk</th>
                                    <th>Barang Keluar</th>
    	 						</tr>
    	 					</thead>
    	 				</table>
                    </section>
                </div>
                <!-- /content -->
            </div>
        </div>
    </div>

    <!-- modal edit foto -->
    <div class="modal fade" id="modal_editFoto" tabindex="-1" role="dialog" aria-labelledby="labelModalEditFoto" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title" id="labelModalEditFoto">Edit Foto Bahan Baku</h4>
				</div>
				<form id="form_gantiFoto" class="form-material" role="form" enctype="multipart/form-data">
					<input type="hidden" name="id_karyawan" id="id_karyawan">
					<div class="modal-body">
						<label for="foto">Foto Bahan Baku</label>
                        <input type="file" id="foto" class="dropify"/>
					</div>
					<div class="modal-footer">
	                    <button id="btnGanti_foto" type="submit" class="btn btn-info btn-outline waves-effect waves-light" value="ganti_foto">Ganti Foto</button>
                     	<button id="btnHapus_foto" type="button" class="btn btn-danger btn-outline waves-effect waves-light" value="hapus_foto">Hapus Foto</button>
	                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- js view -->
<script type="text/javascript" src="<?= base_url."app/views/bahan_baku/js/initView.js"; ?>"></script>
