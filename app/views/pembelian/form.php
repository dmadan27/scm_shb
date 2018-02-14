<?php 
	Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
	$id = isset($_GET['id']) ? $_GET['id'] : false;
	$btn = $id ? "edit" : "tambah"; 
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Form <?= ucfirst($btn); ?> Data Pembelian</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li class="active">Data Pembelian</li>
        </ol>
    </div>
</div>
<div class="form-pembelian">
	<form id="form_pembelian" class="form-material" role="form" enctype="multipart/form-data">
		<!-- panel form pembelian -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		Data Pembelian
		        		<div class="panel-action">
		        		 	<a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
					 	</div>
		        	</div>
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
							<input type="hidden" name="id_pembelian" id="id_pembelian">
			    	 		<div class="row">
			    	 			<div class="col-md-6">
		    	 					<!-- tgl - invoice -->
		    	 					<div class="row">
		    	 						<div class="col-md-6">
		    	 							<!-- tgl -->
					    	 				<div class="form-group field-tgl has-feedback m-b-5">
												<label class="col-md-12" for="tgl">Tanggal*</label>
						                        <div class="col-md-12">
						                            <input id="tgl" type="text" class="form-control datepicker" placeholder="Masukkan Tanggal">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
		    	 						</div>
		    	 						<div class="col-md-6">
		    	 							<!-- invoice -->
					    	 				<div class="form-group field-invoice has-feedback m-b-5">
												<label class="col-md-12" for="invoice">Invoice*</label>
						                        <div class="col-md-12">
						                            <input id="invoice" type="text" class="form-control" placeholder="Masukkan Invoice">
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
		    	 						</div>
		    	 					</div>	
			    	 				<!-- supplier -->
			    	 				<div class="form-group field-supplier has-feedback m-b-5">
										<label class="col-md-12" for="supplier">Supplier*</label>
				                        <div class="col-md-12">
				                        	<div class="input-group">
				                        		<select id="supplier" class="form-control select2"></select>
				                        		<span class="input-group-btn">
				                        			<button id="pengganti_supplier" type="button" class="btn btn-danger btn-outline waves-effect waves-light">Supplier Pengganti</button>
				                        		</span>
				                        	</div>
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
			    	 			<div class="col-md-6">
			    	 				<!-- jenis pembayaran - jenis pph -->
			    	 				<div class="row">
			    	 					<div class="col-md-6">
			    	 						<!-- jenis pembayaran -->
					    	 				<div class="form-group field-jenis-pembayaran has-feedback m-b-5">
												<label class="col-md-12" for="jenis_pembayaran">Jenis Pembayaran*</label>
						                        <div class="col-md-12">
						                            <select id="jenis_pembayaran" class="form-control"></select>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
			    	 					</div>
			    	 					<div class="col-md-6">
			    	 						<!-- jenis pph -->
					    	 				<div class="form-group field-jenis-pph has-feedback m-b-5">
												<label class="col-md-12" for="jenis_pph">Jenis PPH*</label>
						                        <div class="col-md-12">
						                            <select id="jenis_pph" class="form-control"></select>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
			    	 					</div>
			    	 				</div>	
			    	 				<!-- ket -->
			    	 				<div class="form-group field-ket has-feedback m-b-5">
										<label class="col-md-12" for="ket">Keterangan</label>
				                        <div class="col-md-12">
				                            <textarea id="ket" class="form-control" rows="6" placeholder="Masukkan Keterangan Pembelian"></textarea>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
			    	 			</div>
			    	 		</div>
			 			</div>
		    	 	</div>
		        </div>
		    </div>
		</div>
		<!-- panel form detail pembelian -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		Data Detail Pembelian
		        		<div class="panel-action">
		        		 	<a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
					 	</div>
		        	</div>
		    	 	<div class="panel-wrapper collapse in">
			 			<div class="panel-body">
		    	 			<!-- form detail pembelian -->
			    	 		<div class="row">
			    	 			<div class="col-md-6">
			    	 				<!-- analisa harga -->
			    	 				<div class="form-group field-analisa-harga has-feedback m-b-5">
										<label class="col-md-12" for="analisa_harga">Analisa Harga*</label>
				                        <div class="col-md-12">
				                            <select id="analisa_harga" class="form-control select2">
				                            	<option value="">-- Pilih Analisa Harga --</option>
				                            </select>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
									<!-- harga -->
			    	 				<div class="form-group field-harga has-feedback m-b-5">
										<label class="col-md-12" for="harga">Harga Beli*</label>
				                        <div class="col-md-12">
				                        	<input id="harga" type="number" min="0" step="any" class="form-control" placeholder="Masukkan Harga Beli">
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
			    	 			</div>
			    	 			<div class="col-md-6">
		    	 					<!-- bahan baku -->
			    	 				<div class="form-group field-bahan-baku has-feedback m-b-5">
										<label class="col-md-12" for="bahan_baku">Bahan Baku*</label>
				                        <div class="col-md-12">
				                            <select id="bahan_baku" class="form-control select2"></select>
				                            <span class="help-block small pesan"></span>
				                        </div>
									</div>
									<!-- colly - jumlah -->
									<div class="row">
										<div class="col-md-6">
											<!-- colly -->
											<div class="form-group field-colly has-feedback m-b-5">
												<label class="col-md-12" for="colly">Colly</label>
						                        <div class="col-md-12">
						                        	<div class="input-group">
						                        		<input id="colly" type="number" min="0" step="any" class="form-control" placeholder="Masukkan Colly">
						                        		<span class="input-group-addon">PCS</span>
						                        	</div>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
										</div>
										<div class="col-md-6">
											<!-- jumlah -->
											<div class="form-group field-jumlah has-feedback m-b-5">
												<label class="col-md-12" for="jumlah">Jumlah*</label>
						                        <div class="col-md-12">
						                        	<div class="input-group">
						                        		<input id="jumlah" type="number" min="0" step="any" class="form-control" placeholder="Masukkan Jumlah">
						                        		<span class="input-group-addon satuan"></span>                   	
						                        		<span class="input-group-btn">
						                        			<button type="button" id="btnTambah_barang" class="btn btn-danger btn-outline waves-effect waves-light" title="Tambah Detail Pembelian"><i class="fa fa-plus"></i></button>
						                        		</span>
						                        	</div>
						                            <span class="help-block small pesan"></span>
						                        </div>
											</div>
										</div>
									</div>
			    	 			</div>
			    	 		</div>
			    	 		<!-- tabel list barang -->
			    	 		<div class="row">
			    	 			<div class="col-md-12">
			    	 				<div class="table-responsive">
										<table id="tabel_detail_pembelian" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th style="width: 15px">No</th>
													<th>Barang</th>
													<th>Colly</th>
													<th>Jumlah</th>
													<th>Harga</th>
													<th>Subtotal</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
									<h4 id="tampilPPH" class="text-right">PPH: Rp. -,00</h4>
									<h4 id="tampilHarga" class="text-right">Sub Total: Rp. -,00</h4>
									<h2 id="tampilTotal" class="text-right">Total: Rp. -,00</h2>	
			    	 			</div>
			    	 		</div>
			 			</div>
		    	 	</div>
		        </div>
		    </div>
		</div>
		<!-- panel button -->
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		        <div class="panel panel-default">
		        	<div class="panel-heading">
		        		<div class="row">
							<div class="col-md-12">
								<span class="help-block small">* Wajib Diisi</span>
							</div>
						</div>	
		        		<div class="text-right">
		        			<button id="btnSubmit_pembelian" type="submit" class="btn btn-lg btn-info btn-outline waves-effect waves-light" value="<?= $btn ?>"><?= ucfirst($btn); ?></button>
		        			<?php
		        				if(!$id){
		        					?>
		        						<button id="btnSubmit_pembelian_print" type="submit" class="btn btn-lg btn-success btn-outline waves-effect waves-light" value="<?= $btn ?>">Tambah dan Cetak</button>
		        					<?php
		        				}
		        			?>
		        			<a href="<?=base_url."index.php?m=pembelian&p=list" ?>" class="btn btn-lg btn-default btn-outline waves-effect waves-light">Batal</a>
		        		</div>
		        	</div>
		        </div>
		    </div>
		</div>
	</form>
</div>

<script type="text/javascript">
    var listDetailPembelian = [];
    var indexDetailPembelian = 0;
</script>
<!-- js form -->
<script type="text/javascript" src="<?= base_url."app/views/pembelian/js/initForm.js"; ?>"></script>