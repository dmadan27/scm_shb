<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
    // $notif = isset($_SESSION['notif']) ? $_SESSION['notif'] : false;
    // unset($_SESSION['notif']);
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Data Stok Produk</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li>Data Monitoring Persediaan</li>
            <li class="active">Data Stok Produk</li>
        </ol>
    </div>
</div>

<!-- panel utama -->
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">List Data Stok Produk</div>
            <div class="panel-wrapper collapse in">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <!-- panel button -->
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <div class="btn-group m-b-30">
                                    <button id="exportExcel" class="fcbtn btn btn-success btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Export Data Ke Excel"><i class="fa fa-file-excel-o"></i> Export Excel</button>
                                    <button id="exportPdf" class="fcbtn btn btn-danger btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Export Data Ke Pdf"><i class="fa fa-file-pdf-o"></i> Export Pdf</button>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <h3 class="text-right">
                                    Stok Periode Januari 2017
                                    <!-- <?= "Stok Periode ".get_bulanIndo(date('m'))." ".date('Y'); ?> -->
                                </h3>
                            </div>
                        </div>
                        <table id="tabel_stok_produk" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 15px">No</th>
                                    <th>Kode Produk</th>
                                    <th>Nama</th>
                                    <th>Stok Gudang</th>
                                    <th>Safety Stock</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- js list -->
<script type="text/javascript" src="<?= base_url."app/views/stok_produk/js/initList.js"; ?>"></script>