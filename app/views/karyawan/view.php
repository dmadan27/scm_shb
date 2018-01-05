<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
    $id = isset($_GET['id']) ? $_GET['id'] : false;
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Lihat Detail Data Karyawan</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li>Data Master</li>
            <li class="active">Data Karyawan</li>
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
                        <a href="javascript:void(0)" data-effect="mfp-zoom-in"><img src="javascript:;" class="thumb-lg img-circle" alt="Foto Karyawan"/></a>
                        <h4 class="text-white">Nama</h4>
                        <h5 class="text-white">Jabatan / Pekerjaan</h5>
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
                        <li><a href="#section-data-diri"><span>Data Diri</span></a></li>
                        <li><a href="#section-data-karyawan"><span>Data Karyawan</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-data-diri">
                    	<div class="row">
                    		<div class="col-md-6">
		                    	<!-- nik -->
		                        <div class="form-group m-b-5">
									<label>NIK:</label>
		                            <p class="form-control-static" id="nik">Info NIK</p>
								</div>
								<!-- npwp -->
		                        <div class="form-group m-b-5">
									<label>NPWP:</label>
		                            <p class="form-control-static" id="npwp">Info NPWP</p>
								</div>
								<!-- nama -->
		                        <div class="form-group m-b-5">
									<label>Nama:</label>
		                            <p class="form-control-static" id="nama">Info Nama</p>
								</div>
								<!-- ttl -->
		                        <div class="form-group m-b-5">
									<label>Tempat dan Tanggal Lahir:</label>
		                            <p class="form-control-static" id="ttl">Info Tempat dan Tanggal Lahir</p>
								</div>
								<!-- jenis kelamin -->
		                        <div class="form-group m-b-5">
									<label>Jenis Kelamin:</label>
		                            <p class="form-control-static" id="jk">Info Jenis Kelamin</p>
								</div>
		                    </div>
							<div class="col-md-6">
								<!-- alamat -->
		                        <div class="form-group m-b-5">
									<label>Alamat:</label>
		                            <p class="form-control-static" id="alamat">Info Alamat</p>
								</div>
								<!-- telp -->
		                        <div class="form-group m-b-5">
									<label>No. Telepon:</label>
		                            <p class="form-control-static" id="telp">Info No. Telepon</p>
								</div>
								<!-- email -->
		                        <div class="form-group m-b-5">
									<label>Email:</label>
		                            <p class="form-control-static" id="email">Info Email</p>
								</div>
							</div>
                    	</div>
                    </section>
                    <section id="section-data-karyawan">
                        <!-- no induk -->
                        <div class="form-group m-b-5">
							<label>No. Induk Karyawan:</label>
                            <p class="form-control-static" id="no_induk">Info No. Induk Karyawan</p>
						</div>
						<!-- jabatan -->
                        <div class="form-group m-b-5">
							<label>Jabatan:</label>
                            <p class="form-control-static" id="jabatan">Info Jabatan</p>
						</div>
						<!-- tanggal masuk -->
                        <div class="form-group m-b-5">
							<label>Tanggal Masuk:</label>
                            <p class="form-control-static" id="tgl_masuk">Info Tanggal Masuk</p>
						</div>
						<!-- Status karyawan -->
                        <div class="form-group m-b-5">
							<label>Status Karyawan:</label>
                            <p class="form-control-static" id="status">Info Status Karyawan</p>
						</div>
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
	                <h4 class="modal-title" id="labelModalEditFoto">Edit Foto Karyawan</h4>
				</div>
				<form id="form_gantiFoto" class="form-material" role="form" enctype="multipart/form-data">
					<input type="hidden" name="id_karyawan" id="id_karyawan">
					<div class="modal-body">
						<label for="foto">Foto Karyawan</label>
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
<script type="text/javascript" src="<?= base_url."app/views/karyawan/js/initView.js"; ?>"></script>
