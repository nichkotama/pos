<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 
$result = $db->prepare("SELECT * FROM departemen ORDER BY kode_awal");
$result->execute(); 
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $judul;?> - Departemen</title>
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
function fokus_teks() {
    document.getElementById("nama").focus();
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
            <h2>Departemen</h2>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Departemen <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> View</li>
            </ul>
        </div>
    </div>

    <div class="row widget-header block-header">
        <div class="col-sm-2 unit">
            <div class="input">
                <button type="button" class="btn btn-success" onclick=""  data-toggle="modal" data-target="#myModal" onclick="fokus_teks()"><i class="zmdi zmdi-plus"> Tambah Departemen</i></button>

                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                        <form action="tambah.php" method="post" class="j-forms">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Tambah Departemen</h4>
                            </div>
                            <div class="modal-body">
                                <div class="unit">
                                    <div class="input">
                                        <label class="icon-left" for="departemen">
                                            <i class="fa fa-book"></i>
                                        </label>
										<input class="form-control login-frm-input"  type="text" id="kode_awal" name="kode_awal" placeholder="Masukkan Kode" required="true">
                                        <input class="form-control login-frm-input"  type="text" id="nama_dept" name="nama_dept" placeholder="Masukkan Nama Departemen" required="true">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success" name="submit">Simpan</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
                    <table class="table table-striped data-tbl">
                        <thead>
                        <tr>
                            <th>Nama Departemen</th>
                            <th>Hak Akses Produk</th>
                            <th>Hak Akses Karyawan</th>
                            <th>Hak Akses Laporan</th>
							<th>Hak Akses Pos</th>
                            <th class="td-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            for ($i = 0; $row = $result->fetch(); $i++) {
                                echo "<tr>";
                                echo "<td>" . $row['departemen'] . "</td>";
                                echo "<td>" . ($row['hak_akses_produk'] == '1' ? "Granted" : "Restricted") . "</td>";
                                echo "<td>" . ($row['hak_akses_karyawan'] == '1' ? "Granted" : "Restricted") . "</td>";
                                echo "<td>" . ($row['hak_akses_laporan'] == '1' ? "Granted" : "Restricted") . "</td>";
                                echo "<td>" . ($row['hak_akses_pos'] == '1' ? "Granted" : "Restricted") . "</td>";
                                echo "<td class='td-center'>
                                <div class='btn-toolbar' role='toolbar'>
                                    <div class='btn-group' role='group'>
                                        <a href='edit.php?method=departemen&key=" . $row['kode_awal'] . "' class='btn btn-default btn-sm m-user-edit'><i class='zmdi zmdi-edit'></i></a>
                                    </div>
                                </div>
                                </td>";
                            }
                        ?>
                        </tbody>
                    </table>
    </div>
    </div>
</div>

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