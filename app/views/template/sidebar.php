<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navigasi Menu</span></h3> 
        </div>
        <ul class="nav" id="side-menu">
            <!-- menu left-sidebar profile -->
            <li class="user-pro">
                <a href="#" class="waves-effect">
                    <img src="<?= base_url."assets/plugins/images/users/varun.jpg"; ?>" alt="user-img" class="img-circle"> 
                    <span class="hide-menu"> Steve Gection<span class="fa arrow"></span></span>
                </a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="javascript:void(0)"><i class="ti-user"></i> <span class="hide-menu">My Profile</span></a></li>
                    <li><a href="javascript:void(0)"><i class="ti-wallet"></i> <span class="hide-menu">My Balance</span></a></li>
                    <li><a href="javascript:void(0)"><i class="ti-email"></i> <span class="hide-menu">Inbox</span></a></li>
                    <li><a href="javascript:void(0)"><i class="ti-settings"></i> <span class="hide-menu">Account Setting</span></a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-power-off"></i> <span class="hide-menu">Logout</span></a></li>
                </ul>
            </li>

            <!-- beranda -->
            <li class="menu-beranda">
                <a href="<?= base_url; ?>" class="waves-effect">
                    <i class="mdi mdi-home fa-fw" data-icon="v"></i> 
                    <span class="hide-menu">Beranda</span>
                </a>
            </li>

            <!-- Data Master -->
            <li class="menu-data-master">
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="mdi mdi-database fa-fw"></i> 
                    <span class="hide-menu"> 
                        Data Master <span class="fa arrow"></span> 
                    </span>
                </a>
                <ul class="nav nav-second-level">
                    <!-- data pekerjaan -->
                    <li class="menu-data-pekerjaan">
                        <a href="<?= base_url."index.php?m=pekerjaan&p=list"; ?>"><i class="mdi mdi-account-card-details fa-fw"></i><span class="hide-menu">Data Pekerjaan</span></a>
                    </li>
                    <!-- data karyawan -->
                    <li class="menu-data-karyawan">
                        <a href="<?= base_url."index.php?m=karyawan&p=list"; ?>"><i class="mdi mdi-account-card-details fa-fw"></i><span class="hide-menu">Data Karyawan</span></a>
                    </li>
                    <!-- data supplier -->
                    <li class="menu-data-supplier">
                        <a href="<?= base_url."index.php?m=supplier&p=list"; ?>"><i class="mdi mdi-account-multiple fa-fw"></i><span class="hide-menu">Data Supplier</span></a>
                    </li>
                    <!-- data buyer -->
                    <li class="menu-data-buyer">
                        <a href="<?= base_url."index.php?m=buyer&p=list"; ?>"><i class="mdi mdi-account-multiple-outline fa-fw"></i><span class="hide-menu">Data Buyer</span></a>
                    </li>
                    <!-- data barang -->
                    <li class="menu-data-barang">
                        <a href="<?= base_url."index.php?m=barang&p=list"; ?>"><i class="mdi mdi-cube-outline fa-fw"></i><span class="hide-menu">Data Barang</span></a>
                    </li>
                    <!-- data harga basis -->
                    <li class="menu-data-harga-basis">
                        <a href="<?= base_url."index.php?m=harga_basis&p=list"; ?>"><i class="mdi mdi-cube-outline fa-fw"></i><span class="hide-menu">Data Harga Basis</span></a>
                    </li>
                    <!-- data kendraan -->
                    <li class="menu-data-kendaraan">
                        <a href="<?= base_url."index.php?m=kendaraan&p=list"; ?>"><i class="mdi mdi-car fa-fw"></i><span class="hide-menu">Data Kendaraan</span></a>
                    </li>
                    <!-- data user -->
                    <li class="menu-data-user">
                        <a href="<?= base_url."index.php?m=user&p=list"; ?>"><i class="mdi mdi-cube-outline fa-fw"></i><span class="hide-menu">Data User</span></a>
                    </li>
                </ul>
            </li>

            <!-- data kir -->
            <li class="menu-kir">
                <a href="<?= base_url."index.php?m=kir&p=list"; ?>" class="waves-effect">
                    <i class="mdi mdi-home fa-fw" data-icon="v"></i> 
                    <span class="hide-menu">Data KIR</span>
                </a>
            </li>

            <!-- analisa harga -->
            <li class="menu-analisa-harga">
                <a href="<?= base_url."index.php?m=analisa_harga&p=list"; ?>" class="waves-effect">
                    <i class="mdi mdi-home fa-fw" data-icon="v"></i> 
                    <span class="hide-menu">Data Analisa Harga</span>
                </a>
            </li>

            <!-- pembelian -->
            <li class="menu-pembelian">
                <a href="<?= base_url."index.php?m=pembelian&p=list"; ?>" class="waves-effect">
                    <i class="mdi mdi-home fa-fw" data-icon="v"></i> 
                    <span class="hide-menu">Data Pembelian</span>
                </a>
            </li>

            <!-- pemesanan -->
            <li class="menu-pemesanan">
                <a href="<?= base_url."index.php?m=pemesanan&p=list"; ?>" class="waves-effect">
                    <i class="mdi mdi-home fa-fw" data-icon="v"></i> 
                    <span class="hide-menu">Data Pemesanan</span>
                </a>
            </li>

            <!-- pengiriman -->
            <li class="menu-pengiriman">
                <a href="<?= base_url."index.php?m=pengiriman&p=list"; ?>" class="waves-effect">
                    <i class="mdi mdi-home fa-fw" data-icon="v"></i> 
                    <span class="hide-menu">Data Pengiriman</span>
                </a>
            </li>

            <!-- perencanaan pengadaan bahan baku -->
            <li class="menu-perencanaan-bahan-baku">
                <a href="<?= base_url."index.php?m=perencanaan_bahan_baku&p=list"; ?>" class="waves-effect">
                    <i class="mdi mdi-home fa-fw" data-icon="v"></i> 
                    <span class="hide-menu">Data Perencanaan Pengadaan Bahan Baku</span>
                </a>
            </li>

            <!-- monitoring persediaan -->
            <li class="menu-data-monitoring">
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="mdi mdi-database fa-fw"></i> 
                    <span class="hide-menu"> 
                        Data Monitoring Persediaan <span class="fa arrow"></span> 
                    </span>
                </a>
                <ul class="nav nav-second-level">
                    <!-- data safety stock -->
                    <li class="menu-data-safety-stock"><a href="<?= base_url."index.php?m=safety_stock&p=list"; ?>"><i class="mdi mdi-account-card-details fa-fw"></i><span class="hide-menu">Data Safety Stock</span></a></li>
                    <!-- data mutasi barang -->
                    <li class="menu-data-mutasi-barang"><a href="<?= base_url."index.php?m=mutasi_barang&p=list"; ?>"><i class="mdi mdi-account-card-details fa-fw"></i><span class="hide-menu">Data Mutasi Barang</span></a></li>
                </ul>
            </li>

            <!-- produksi -->
            <li class="menu-produksi">
                <a href="<?= base_url."index.php?m=safety_stock&p=list"; ?>" class="waves-effect">
                    <i class="mdi mdi-home fa-fw" data-icon="v"></i> 
                    <span class="hide-menu">Data Produksi</span>
                </a>
            </li>
        </ul>
    </div>
</div>