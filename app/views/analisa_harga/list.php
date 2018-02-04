<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
    $notif = isset($_SESSION['notif']) ? $_SESSION['notif'] : false;
    unset($_SESSION['notif']);
?>
<!-- Breadcrumb -->
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Data Analisa Harga</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?= base_url; ?>">Beranda</a></li>
            <li class="active">Data Analisa Harga</li>
        </ol>
    </div>
</div>

<!-- panel utama -->
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">List Data Analisa Harga</div>
            <div class="panel-wrapper collapse in">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <!-- panel button -->
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="btn-group m-b-30">
                                    <button id="tambah_analisa_harga" class="fcbtn btn btn-info btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i> Tambah</button>
                                    <button id="exportExcel" class="fcbtn btn btn-success btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Export Data Ke Excel"><i class="fa fa-file-excel-o"></i> Export Excel</button>
                                    <button id="exportPdf" class="fcbtn btn btn-danger btn-outline waves-effect waves-light btn-1b" data-toggle="tooltip" data-placement="top" title="Export Data Ke Pdf"><i class="fa fa-file-pdf-o"></i> Export Pdf</button>
                                </div>
                            </div>
                        </div>
                        <table id="tabel_analisa_harga" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 15px">No</th>
                                    <th>Tanggal</th>
                                    <th>Kode KIR</th>
                                    <th>Supplier</th>
                                    <th>Harga Basis</th>
                                    <th>Harga Beli</th>
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

<?php 
    if($notif){
        ?>
        <script>var notif = "<?php echo $notif; ?>";</script>
        <?php
    }
    else{
        ?>
        <script>var notif = false;</script>
        <?php
    } 
?>

<!-- js list -->
<script type="text/javascript" src="<?= base_url."app/views/analisa_harga/js/initList.js"; ?>"></script>