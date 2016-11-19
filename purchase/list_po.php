<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 
$result = $db->prepare("SELECT transaksi_pembelian.id_pembelian, supplier.nama_supplier, transaksi_pembelian.tgl_po FROM transaksi_pembelian 
						INNER JOIN supplier ON transaksi_pembelian.id_supplier = supplier.id_supplier");
$result->execute(); 
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $judul ?> - POS Session</title>
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
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>

</head>
<body class="overlay-leftbar">

<script type="text/javascript">
function fokus_teks() {
    document.getElementById("nama").focus();
}

$(function() {  
    $( "#supplier" ).autocomplete({
        source: "../php/modular/autocomplete.php?src=supplier",  
        minLength:2, 
        autoFocus:true,
        select: function( event, ui ) {
          // document.getElementById('tampilan').innerHTML += ui.item.value + "<br/>";
        },

    });
});
</script>

<?php include('../php/modular/top-menu.php') ?>
<?php include('../php/modular/side-menu.php') ?>
<!--Page Container Start Here-->
<section class="main-container">
<div class="container-fluid">
<div class="page-header filled light single-line">
    <div class="row widget-header block-header">
        <div class="col-sm-6">
            <h2>List PO</h2>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Product <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> Manage</li>
            </ul>
        </div>
    </div>

    <div class="row widget-header block-header">
        <div class="col-sm-2 unit">
            <div class="input">
                <button type="button" class="btn btn-success" onclick=""  data-toggle="modal" data-target="#myModal" onclick="fokus_teks()"><i class="zmdi zmdi-plus"> Buat PO</i></button>

                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                        <form action="tambah.php" method="post" class="j-forms form-horizontal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Buat Purchase Order</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <div class="unit col-md-12">
                                    <div class="input">
                                        <label class="icon-left" for="nomor_po">
                                            <i class="fa fa-book"></i>
                                        </label>
                                        <input class="form-control login-frm-input"  type="text" id="nomor_po" name="nomor_po" placeholder="Masukkan Nomor PO" required="true">
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="unit col-md-12">
                                    <div class="input">
                                        <label class="icon-left" for="nama_supplier">
                                            <i class="zmdi zmdi-assignment-account"></i>
                                        </label>
                                        <input class="form-control login-frm-input"  type="text" id="supplier" name="supplier" placeholder="Pilih Supplier" required="true">
                                    </div>
                                </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12" id="myTable">
                                        <div class="col-sm-1 heading-tabel">Remove</div>
                                        <div class="col-sm-1 heading-tabel">#</div>
                                        <div class="col-sm-3 heading-tabel">Item</div>
                                        <div class="col-sm-1 heading-tabel">Qty</div>
                                        <div class="col-sm-3 heading-tabel">Harga Satuan (Rp)</div>
                                        <div class="col-sm-3 heading-tabel">Sub-Total (Rp)</div>
                                    </div>
                                </div>
                                <?php for($i=0;$i<5;$i++) { ?>
                                <div class="row">
                                    <div class="col-md-12" id="baris">
                                        <div class="col-md-1"><button class="btn btn-danger" name="hapus_item" type="submit"><i class="zmdi zmdi-close"></i></button></div>
                                        <div class="col-md-1 p-tb-9"><?php echo ($i+1) ?></div>
                                        <div class="col-md-3 p-tb-9"><input type="text" name="barang_<?php echo ($i+1)?>"></div>
                                        <div class="col-md-1 p-tb-9"><input type="number" name="qty_<?php echo ($i+1)?>" style='width:60px' min="1"></div>
                                        <div class="col-md-3 p-tb-9"><input type="text" name="hargabeli"></div>
                                        <div class="col-md-3 p-tb-9"><input type="text" name="subtotal-hb"></div>
                                    </div>
                                </div>
                                <?php } ?>
                                
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
                <th>Nomor PO</th>
                <th>Tanggal PO</th>
                <th>Supplier</th>
                <th class="td-center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
                for ($i = 0; $row = $result->fetch(); $i++) {
                    echo "<tr>";
                    # kolom id pembelian
                    echo "<td>" . $row['id_pembelian'] . "</td>";
                    # kolom tanggal PO
                    echo "<td>" . $row['tgl_po'] . "</td>";
                    # kolom id supplier
                    echo "<td>" . $row['nama_supplier'] . "</td>";
                    # kolom aksi
                    echo "<td class='td-center'>
                    <div class='btn-toolbar' role='toolbar'>
                        <div class='btn-group' role='group'>
                            <a href='edit.php?method=barcode&key=" . $row['id_pembelian'] . "' class='btn btn-default btn-sm m-user-edit'><i class='zmdi zmdi-edit'></i></a>
                        </div>
						<div class='btn-group' role='group'>
                            <a href='edit.php?method=barcode&key=" . $row['id_pembelian'] . "' class='btn btn-default btn-sm m-user-edit'><i class='zmdi zmdi-print'></i></a>
                        </div>
						<div class='btn-group' role='group' data-toggle='modal' data-target='#modalHapus' name='hapus'>
                            <a class='btn btn-default btn-sm m-user-edit'><i class='zmdi zmdi-delete'></i></a>									
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

<!-- KETIKA KLIK HAPUS, doc by Nicholas -->
<div class="modal fade" id="modalHapus" role="dialog">
    <div class="modal-dialog modal-lg">
        <form action="hapus_po.php" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Hapus PO</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                    <i class="zmdi zmdi-alert-circle-o zmdi-hc-5x"></i>
                    <br/>
                    <br/>
                    Apakah anda yakin akan menghapus <?php echo $row['id_pembelian'] ?>?
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="barcode" value="<?php echo $row['id_pembelian'] ?>"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" name="submit">Yakin</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End of KETIKA KLIK HAPUS -->


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
<script src="../js/lib/jquery-jvectormap.js"></script>
<script src="../js/lib/jquery-jvectormap-world-mill.js"></script>
<script src="../js/lib/jquery-jvectormap-us-aea.js"></script>
<script src="../js/lib/smart-resize.js"></script>
<!--iCheck-->
<script src="../js/lib/icheck.js"></script>
<script src="../js/lib/jquery.switch.button.js"></script>
<!--CHARTS-->
<script src="../js/lib/chart/sparkline/jquery.sparkline.js"></script>
<script src="../js/lib/chart/easypie/jquery.easypiechart.min.js"></script>
<script src="../js/lib/chart/flot/excanvas.min.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.min.js"></script>
<script src="../js/lib/chart/flot/curvedLines.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.time.min.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.stack.min.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.axislabels.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.resize.min.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.tooltip.min.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.spline.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.pie.min.js"></script>
<!--Forms-->
<script src="../js/lib/jquery.maskedinput.js"></script>
<script src="../js/lib/jquery.validate.js"></script>
<script src="../js/lib/jquery.form.js"></script>
<script src="../js/lib/j-forms.js"></script>
<script src="../js/lib/jquery.loadmask.js"></script>
<script src="../js/lib/vmap.init.js"></script>
<script src="../js/lib/theme-switcher.js"></script>
<script src="../js/apps.js"></script>
</body>
</html>