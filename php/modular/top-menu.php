<!-- Topbar Start Here--> 
<header class="topbar clearfix">
    <!--Top Search Bar Start Here-->
    <div class="top-search-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="search-input-addon">
                        <span class="addon-icon"><i class="zmdi zmdi-search"></i></span>
                        <input type="text" class="form-control top-search-input" placeholder="Search">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Top Search Bar End Here-->
    <!--Topbar Left Branding With Logo Start-->
    <div class="topbar-left pull-left">
        <div class="clearfix">
            <ul class="left-branding pull-left clickablemenu ttmenu dark-style menu-color-gradient">
                <li><span class="left-toggle-switch"><i class="zmdi zmdi-menu"></i></span></li>
                <li>
                    <div class="logo">
                        <a href="<?php echo $url_web;?>karyawan/karyawan_profile.php?method=karyawan&key="<?php echo $row['id_karyawan']?>"" title="Home Page"><img src="<?php echo $url_web ?>images/logo.png" alt="logo" style="max-height:60px; padding-left:60%;"></a>
                    </div>
                </li>
            </ul>
            <!--Mobile Search and Rightbar Toggle-->
            <ul class="branding-right pull-right">
                <li><a href="#" class="btn-mobile-search btn-top-search"><i class="zmdi zmdi-search"></i></a></li>
                <li><a href="#" class="btn-mobile-bar"><i class="zmdi zmdi-menu"></i></a></li>
            </ul>
        </div>
    </div>
    <!--Topbar Left Branding With Logo End-->
</header>
<!--Topbar End Here