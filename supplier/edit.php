<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');

// Kalo disubmit (edit) maka menjalankan script dibawah ini
if(isset($_POST['submit'])){
    try{
        // new data
        $id_supplier = $_POST['id_supplier'];
        $id_supplier_lama = $_POST['id_supplier_lama'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $telp = $_POST['telp'];
        $alamat = $_POST['alamat'];
        // $aktif = ($_POST['status_aktif'] == 'on' ? 1:0);
        // query
        $sql = "UPDATE supplier 
                SET id_supplier=?, nama_supplier=?, email=? , no_telp=?, alamat=?
                WHERE id_supplier=?";
        $q = $db->prepare($sql);
        $q->execute(array($id_supplier, $nama, $email, $telp, $alamat, $id_supplier_lama));
        header("location: index.php");
    }catch(Exception $e){
        if($mode_debug = true) echo $e->getMessage();
        echo "<div class='col-md-12'>
                <div class='j-forms'>
                    <div class='form-content'>
                        <div class='unit'> 
                            <div class='error-message text-center'>
                                <i class='fa fa-close'></i>Data yang anda masukan sudah ada atau salah.
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
    }
}

// Pas load data
if(isset($_GET['key']) AND $_GET['method'] == 'supplier'){
    $id_supplier=$_GET['key'];
    $result = $db->prepare("SELECT * FROM supplier WHERE id_supplier = :id_supplier");
    $result->bindParam(':id_supplier', $id_supplier);
    $result->execute();
    for($i=0; $row = $result->fetch(); $i++){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $judul;?> - Supplier</title>
    <link type="text/css" rel="stylesheet" href="../css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="../css/material-design-iconic-font.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../css/animate.css">
    <link type="text/css" rel="stylesheet" href="../css/layout.css">
    <link type="text/css" rel="stylesheet" href="../css/components.css">
    <link type="text/css" rel="stylesheet" href="../css/widgets.css">
    <link type="text/css" rel="stylesheet" href="../css/plugins.css">
    <link type="text/css" rel="stylesheet" href="../css/pages.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap-extend.css">
    <link type="text/css" rel="stylesheet" href="../css/common.css">
    <link type="text/css" rel="stylesheet" href="../css/responsive.css">
    <link type="text/css" rel="stylesheet" href="../css/custom.css">

<script>
window.onload = function() {
        var SetFokus = $('#nama');
        SetFokus.val(SetFokus.val());
        var strLength= SetFokus.val().length;
        SetFokus.focus();
        SetFokus[0].setSelectionRange(strLength, strLength);
}
</script>
</head>

<body class="overlay-leftbar">
<?php include('../php/modular/top-menu.php') ?>
<?php include('../php/modular/side-menu.php') ?>
<!--Page Container Start Here-->
<section class="main-container">
<div class="container-fluid">
<div class="page-header filled light single-line">
    <div class="row widget-header block-header">
        <div class="col-sm-6">
            <h2>Edit Supplier</h2>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Supplier <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> Sunting</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="widget-container">
                <div class="widget-content">
                    <form class="j-forms" method="post" id="order-forms-quantity" novalidate>
                        <div class="form-group">    
                            <div class="unit">
                                <div class="input">
                                    <label class="icon-left" for="id_supplier">
                                        <i class="zmdi zmdi-assignment-account"></i>
                                    </label>
                                    <input class="form-control login-frm-input"  type="text" id="id_supplier" name="id_supplier" placeholder="Masukkan ID Supplier" required="true" value="<?php echo $row['id_supplier']; ?>">
                                    <input type="hidden" name="id_supplier_lama" value="<?php echo $row['id_supplier'];?>">
                                </div>
                            </div>
                            <div class="unit">
                                <div class="input">
                                    <label class="icon-left" for="nama_supplier">
                                        <i class="zmdi zmdi-account"></i>
                                    </label>
                                    <input class="form-control login-frm-input"  type="text" id="nama" name="nama" placeholder="Masukkan Nama Supplier" required="true" value="<?php echo $row['nama_supplier']; ?>">
                                </div>
                            </div>
                            <div class="unit">
                                <div class="input">
                                    <label class="icon-left" for="email">
                                        <i class="fa fa-barcode"></i>
                                    </label>
                                    <input class="form-control login-frm-input"  type="email" id="email" name="email" placeholder="Masukkan Email Supplier" required="true" value="<?php echo $row['email'];?>">
                                    </div>
                            </div>
                            <div class="unit">
                                <div class="input">
                                    <label class="icon-left" for="telp">
                                        <i class="fa fa-money"></i>
                                    </label>
                                    <input class="form-control login-frm-input"  type="telp" id="telp" name="telp" placeholder="Masukkan Nomor Telepon Supplier" value="<?php echo $row['no_telp'];?>">
                                </div>
                            </div>
                            <div class="unit">
                                <div class="input">
                                    <label class="icon-left" for="alamat">
                                        <i class="fa fa-money"></i>
                                    </label>
                                    <textarea class="form-control login-frm-input" id="alamat" name="alamat" placeholder="Masukkan Alamat Supplier"><?php echo $row['alamat'];?></textarea>
                                </div>
                            </div>
                            <div class="unit">
                                <div class="input">
                                    <button type="submit" class="btn btn-success col-md-4" name="submit">Simpan</button>
                                    <button type="button" class="btn btn-default col-md-4" onclick="window.location.href='<?php echo $url_web?>supplier'">Batal</button>
                                    <button type="button" class="btn btn-danger col-md-4" data-toggle="modal" data-target="#modalHapus" name="hapus">Hapus Permanen</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- KETIKA KLIK HAPUS, doc by Nicholas -->
<div class="modal fade" id="modalHapus" role="dialog">
    <div class="modal-dialog modal-lg">
        <form action="hapus.php" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Hapus Supplier</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                    <i class="zmdi zmdi-alert-circle-o zmdi-hc-5x"></i>
                    <br/>
                    <br/>
                    Apakah anda yakin akan menghapus <?php echo $row['nama_supplier'] . " (ID Supplier: " . $row['id_supplier'] . ")" ?>?
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_supplier" value="<?php echo $row['id_supplier'] ?>"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" name="submit">Yakin</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End of KETIKA KLIK HAPUS -->
<?php
}}
?>
</section>
<section class="main-container m-t-min-20"><?php include('../php/modular/footer.php') ?></section>
<!--Page Container End Here-->

<script src="../js/lib/jquery.js"></script>
<script src="../js/lib/jquery-migrate.js"></script>
<script src="../js/lib/bootstrap.js"></script>
<script src="../js/lib/jquery.ui.js"></script>
<script src="../js/lib/jRespond.js"></script>
<script src="../js/lib/nav.accordion.js"></script>
<script src="../js/lib/hover.intent.js"></script>
<script src="../js/lib/hammerjs.js"></script>
<script src="../js/lib/jquery.hammer.js"></script>
<script src="../js/lib/jquery.fitvids.js"></script>
<script src="../js/lib/scrollup.js"></script>
<script src="../js/lib/smoothscroll.js"></script>
<script src="../js/lib/jquery.slimscroll.js"></script>
<script src="../js/lib/jquery.syntaxhighlighter.js"></script>
<script src="../js/lib/velocity.js"></script>
<script src="../js/lib/smart-resize.js"></script>

<!--Data Tables-->
<script src="../js/lib/jquery.dataTables.js"></script>
<script src="../js/lib/dataTables.responsive.js"></script>
<script src="../js/lib/dataTables.tableTools.js"></script>
<script src="../js/lib/dataTables.bootstrap.js"></script>

<!--Forms-->
<script src="../js/lib/jquery.maskedinput.js"></script>
<script src="../js/lib/jquery.validate.js"></script>
<script src="../js/lib/jquery.form.js"></script>
<!--Select2-->
<script src="../js/lib/select2.full.js"></script>
<script src="../js/lib/j-forms.js"></script>
<script src="../js/apps.js"></script>
</body>
</html>