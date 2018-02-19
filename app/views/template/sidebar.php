<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
           <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigasi Menu</span></h3>
        </div>
        <div class="user-profile">
            <div class="dropdown user-pro-body">
                <div><img src="<?= base_url."assets/images/".$sess_foto; ?>" alt="user-img" class="img-circle"></div>
                <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= ucwords(strtolower($sess_nama)); ?> <span class="caret"></span></a>
                <ul class="dropdown-menu animated flipInY">
                    <li><a href="#"><i class="ti-user"></i> Lihat Profil</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?= base_url."logout.php"; ?>"><i class="fa fa-power-off"></i> <span class="hide-menu">Logout</span></a></li>
                </ul>
            </div>
        </div>
        <ul class="nav" id="side-menu">
            <?php 
                echo set_menu($sess_akses_menu); 
            ?>
        </ul>
    </div>
</div>