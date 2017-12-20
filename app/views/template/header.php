<?php
    Defined("BASE_PATH") or die("Dilarang Mengakses File Secara Langsung");
?>
<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <div class="top-left-part">
            <!-- Logo -->
            <a class="logo" href="index.html">
                <!-- Logo icon image, you can use font-icon also -->
                <b>
                	<!--This is dark logo icon-->
                	<img src="<?= base_url."assets/plugins/images/admin-logo.png"; ?>" alt="home" class="dark-logo" />
                	<!--This is light logo icon-->
                	<img src="<?= base_url."assets/plugins/images/shb-logo.png"; ?>" alt="home" class="light-logo" />
             	</b>
                <!-- Logo text image you can use text also -->
                <span class="hidden-xs">
	                <!--This is dark logo text-->
	                <img src="<?= base_url."assets/plugins/images/admin-text.png"; ?>" alt="home" class="dark-logo" />
	                <!--This is light logo text-->
	            	<img src="<?= base_url."assets/plugins/images/admin-text-dark.png"; ?>" alt="home" class="light-logo" />
             	</span>
         	</a>
        </div>
        <!-- /Logo -->
        <!-- Search input and Toggle icon -->
        <ul class="nav navbar-top-links navbar-left">
            <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">            
            <!-- profile -->
            <li class="dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> 
                	<img src="<?= base_url."assets/images/".$sess_foto; ?>" alt="user-img" width="36" class="img-circle">
                	<b class="hidden-xs"><?= $sess_username ?></b>
                	<span class="caret"></span> 
                </a>
                <ul class="dropdown-menu dropdown-user animated flipInY">
                    <li>
                        <div class="dw-user-box">
                            <div class="u-img"><img src="<?= base_url."assets/images/".$sess_foto; ?>" alt="user" /></div>
                            <div class="u-text">
                                <h4><?= ucwords(strtolower($sess_nama)); ?></h4>
                                <p class="text-muted small"><?= $sess_pengguna ?></p><a href="profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
                           	</div>
                    	</div>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?= base_url."logout.php"; ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
</nav>