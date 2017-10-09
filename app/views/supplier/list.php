<?php
	
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Data Supplier</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li>Data Master</li>
            <li class="active">Data Karyawan</li>
        </ol>
    </div>
</div>

<!-- panel utama -->
<div class="row">
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
        	<div class="panel-heading">List Data Supplier</div>
    	 	<div class="panel-wrapper collapse in">
    	 		<div class="panel-wrapper collapse in">
    	 			<div class="panel-body">
    	 				<!-- panel button -->
    	 				<div class="row">
    	 					<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
    	 						<div class="btn-group m-b-30">
    	 							<button id="tambah_supplier" class="fcbtn btn btn-info btn-outline waves-effect waves-light btn-1b"><i class="fa fa-plus"></i> Tambah</button>
    	 							<button class="fcbtn btn btn-success btn-outline waves-effect waves-light btn-1b"><i class="fa fa-file-excel-o"></i> Export Excel</button>
    	 							<button class="fcbtn btn btn-danger btn-outline waves-effect waves-light btn-1b"><i class="fa fa-file-pdf-o"></i> Export Pdf</button>
    	 						</div>
    	 					</div>
    	 				</div>
    	 				<div class="table-responsive">
    	 					<table id="tabel_karyawan" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
	    	 					<thead>
	    	 						<tr>
	    	 							<th style="width: 15px">No</th>
	    	 							<th>No. KTP</th>
	    	 							<th>NPWP</th>
	    	 							<th>Nama</th>
	    	 							<th>Status</th>
	    	 							<th>Aksi</th>
	    	 						</tr>
	    	 					</thead>
	    	 				</table>
    	 				</div>	
    	 			</div>
    	 		</div>
    	 	</div>
        </div>
    </div>
</div>

<!-- Form Modal Supplier -->
<div class="modal fade" id="modal_supplier" tabindex="-1" role="dialog" aria-labelledby="labelModalSupplier" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="labelModalSupplier">Form Data Supplier</h4>
			</div>
			<form id="form_supplier" class="form-material">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<!-- NIK -->
							<div class="form-group field-nik">
								<label class="col-md-12" for="nik">NIK</label>
		                        <div class="col-md-12">
		                            <input id="nik" type="text" class="form-control" placeholder="Masukkan NIK">
		                            <span class="help-block small"></span>
		                        </div>
							</div>

							<!-- NPWP -->
							<div class="form-group field-npwp">
								<label class="col-md-12" for="npwp">NPWP</label>
		                        <div class="col-md-12">
		                            <input id="npwp" type="text" class="form-control" placeholder="Masukkan NPWP">
		                            <span class="help-block small"></span>
		                        </div>
							</div>

							<!-- nama -->
							<div class="form-group field-nama">
								<label class="col-md-12" for="nama">Nama</label>
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
							<div class="form-group">
                                <label class="col-sm-12">File upload</label>
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
                                </div>
                            </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<!-- status -->
							<div class="form-group field-status">
								<label class="col-md-12" for="status">Status</label>
		                        <div class="col-md-12">
		                            <select id="status" class="form-control"></select>
		                            <span class="help-block small"></span>
		                        </div>
							</div>
						</div>
						<div class="col-md-6">
							<!-- supplier asli -->
							<div class="form-group field-supplier-asli">
								<label class="col-md-12" for="supplier_asli">Supplier Asli</label>
		                        <div class="col-md-12">
		                            <select id="supplier_asli" class="form-control select2" disabled></select>
		                            <span class="help-block small"></span>
		                        </div>
							</div>
						</div>
					</div>	
				</div>
				<div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-outline waves-effect waves-light">Tambah</button>
                    <button type="button" class="btn btn-default btn-outline waves-effect waves-light" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- js list -->
<script type="text/javascript">
    // setting datatable
    $(document).ready(function(){
        var tabel_supplier = $("#tabel_supplier").DataTable({
            "language" : {
                "lengthMenu": "Tampilkan _MENU_ data/page",
                "zeroRecords": "Data Tidak Ada",
                "info": "Menampilkan _START_ s.d _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 s.d 0 dari 0 data",
                "search": "Pencarian:",
                "loadingRecords": "Loading...",
                "processing": "Processing...",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "lengthMenu": [ 25, 50, 75, 100 ],
            "pageLength": 25,
            order: [],
            processing: true,
            serverSide: true,
            ajax: {
                url: base_url+"app/controllers/Supplier.php",
                type: 'POST',
                data: {
                    "action" : "list",
                }
            },
            "columnDefs": [
                {
                    "targets":[0], // disable order di kolom 1 dan 3
                    "orderable":false,
                }
            ],
        });

        $(".select2").select2();

        $("#tambah_supplier").click(function(){
        	$("#modal_supplier").modal();
        });
    });
</script>
