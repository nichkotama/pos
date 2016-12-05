<?php 
require_once('php/modular/koneksi.php'); 
require_once('php/modular/otentifikasi.php'); 
try{
    $result_index = $db->prepare("SELECT 
                            kary.*, dept.departemen AS nama_departemen
                            FROM karyawan kary
                            LEFT JOIN departemen dept ON kary.departemen = dept.kode_awal
                            WHERE id_karyawan = ?
                            ORDER BY id_karyawan ASC");
    $result_index->execute(array($_SESSION['uname'])); 
    $toshow_index=$result_index->fetch();
}catch(Exception $e){
    if($mode_debug = true) echo $e->getMessage();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $judul ?> - Homepage</title>
    <link type="text/css" rel="stylesheet" href="css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="css/material-design-iconic-font.css">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="css/animate.css">
    <link type="text/css" rel="stylesheet" href="css/layout.css">
    <link type="text/css" rel="stylesheet" href="css/components.css">
    <link type="text/css" rel="stylesheet" href="css/widgets.css">
    <link type="text/css" rel="stylesheet" href="css/plugins.css">
    <link type="text/css" rel="stylesheet" href="css/pages.css">
    <link type="text/css" rel="stylesheet" href="css/bootstrap-extend.css">
    <link type="text/css" rel="stylesheet" href="css/common.css">
    <link type="text/css" rel="stylesheet" href="css/responsive.css">
    <link type="text/css" rel="stylesheet" href="css/custom.css">
</head>

<body class="overlay-leftbar">

<?php include('php/modular/top-menu.php') ?>
<?php include('php/modular/side-menu.php') ?>

<!--Page Container Start Here-->
<section class="main-container">
<div class="container">
<div class="page-header filled light">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <h2>Home Page</h2>
            <p>Anda Telah Login Sebagai</p>
        </div>
        <div class="col-md-6 col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Home</a></li>
            </ul>
        </div>
    </div>
    <div class="row m-t-20">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                Nama Karyawan
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <b><?php echo $toshow_index['nama_karyawan'];?></b>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                ID Karyawan
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <b><?php echo $toshow_index['id_karyawan'];?></b>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                Departemen
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <b><?php echo $toshow_index['nama_departemen'];?></b>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                Email
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <b><?php echo $toshow_index['email'];?></b>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                Nomor Telepon
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <b><?php echo $toshow_index['telp_karyawan'];?></b>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                Alamat
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <b><?php echo $toshow_index['alamat_karyawan'];?></b>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <img src="<?php echo $url_web . 'images/karyawan/' . $toshow_index['foto'] ?>" style="width:100%">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button type="button" class="btn btn-default col-md-12" onclick="window.location.href='<?php echo $url_web?>karyawan/change_pass.php'""><i class="zmdi zmdi-key"> Ganti Password</i></button>
            </div>
        </div>
    </div>
</div>
</div>

</section>
<section class="main-container m-t-min-20"><?php include('php/modular/footer.php') ?></section>

<script src="js/lib/jquery.js"></script>
<script src="js/lib/jquery-migrate.js"></script>
<script src="js/lib/bootstrap.js"></script>
<script src="js/lib/jquery.ui.js"></script>
<script src="js/lib/jRespond.js"></script>
<script src="js/lib/nav.accordion.js"></script>
<script src="js/lib/hover.intent.js"></script>
<script src="js/lib/hammerjs.js"></script>
<script src="js/lib/jquery.hammer.js"></script>
<script src="js/lib/jquery.fitvids.js"></script>
<script src="js/lib/scrollup.js"></script>
<script src="js/lib/smoothscroll.js"></script>
<script src="js/lib/jquery.slimscroll.js"></script>
<script src="js/lib/jquery.syntaxhighlighter.js"></script>
<script src="js/lib/velocity.js"></script>
<script src="js/lib/jquery-jvectormap.js"></script>
<script src="js/lib/jquery-jvectormap-world-mill.js"></script>
<script src="js/lib/jquery-jvectormap-us-aea.js"></script>
<script src="js/lib/smart-resize.js"></script>
<!--iCheck-->
<script src="js/lib/icheck.js"></script>
<script src="js/lib/jquery.switch.button.js"></script>
<!--CHARTS-->
<script src="js/lib/chart/sparkline/jquery.sparkline.js"></script>
<script src="js/lib/chart/easypie/jquery.easypiechart.min.js"></script>
<script src="js/lib/chart/flot/excanvas.min.js"></script>
<script src="js/lib/chart/flot/jquery.flot.min.js"></script>
<script src="js/lib/chart/flot/curvedLines.js"></script>
<script src="js/lib/chart/flot/jquery.flot.time.min.js"></script>
<script src="js/lib/chart/flot/jquery.flot.stack.min.js"></script>
<script src="js/lib/chart/flot/jquery.flot.axislabels.js"></script>
<script src="js/lib/chart/flot/jquery.flot.resize.min.js"></script>
<script src="js/lib/chart/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/lib/chart/flot/jquery.flot.spline.js"></script>
<script src="js/lib/chart/flot/jquery.flot.pie.min.js"></script>
<!--Forms-->
<script src="js/lib/jquery.maskedinput.js"></script>
<script src="js/lib/jquery.validate.js"></script>
<script src="js/lib/jquery.form.js"></script>
<script src="js/lib/j-forms.js"></script>
<script src="js/lib/jquery.loadmask.js"></script>
<script src="js/lib/vmap.init.js"></script>
<script src="js/lib/theme-switcher.js"></script>
<script src="js/apps.js"></script>
</body>
</html>
