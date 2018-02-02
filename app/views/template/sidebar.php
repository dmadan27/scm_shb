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
                    <img src="<?= base_url."assets/images/".$sess_foto; ?>" alt="user-img" class="img-circle"> 
                    <span class="hide-menu"> <?= ucwords(strtolower($sess_nama)); ?><span class="fa arrow"></span></span>
                </a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="javascript:void(0)"><i class="ti-user"></i> <span class="hide-menu">My Profile</span></a></li>
                    <li><a href="<?= base_url."logout.php"; ?>"><i class="fa fa-power-off"></i> <span class="hide-menu">Logout</span></a></li>
                </ul>
            </li>

            <?php 
                echo set_menu($sess_akses_menu); 
            ?>
        </ul>
    </div>
</div>