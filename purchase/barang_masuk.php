<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 
try {
    if(isset($_POST['update_keterangan'])){
        $id_pembelian_detail = $_POST['hdn_keterangan'];
        $keterangan = $_POST['keterangan'];
        $sql = "UPDATE transaksi_pembelian_detail 
                SET keterangan=?
                WHERE id_pembelian_detail=?";
        $q = $db->prepare($sql);
        $q->execute(array($keterangan, $id_pembelian_detail));
    }

    if(isset($_GET['key']) AND $_GET['method']  == 'details'){
        $cek_keterangan = $db->prepare("SELECT a.*, b.nama_barang, b.jml_stok FROM transaksi_pembelian_detail a JOIN barang b ON a.barcode_barang = b.barcode_barang WHERE a.id_pembelian_detail = " . $_GET['key']);
        $cek_keterangan->execute();
        $ada = $cek_keterangan->fetch();
        $jml_stok_awal = (int) $ada['jml_stok'];
        $jml_stok_tambah = (int) $ada['jml_beli'];
        $jml_stok_akhir = $jml_stok_awal+$jml_stok_tambah;

        if(isset($ada['keterangan'])){
            echo "<script type='text/javascript'>
                if (alert('Peringatan! Konfirmasi barang telah lengkap dengan hapus keterangan yang ada terlebih dulu')){
                    window.location = 'barang_masuk.php';
                }else{
                    window.location = 'barang_masuk.php';
                }
            </script>";
        }else{
            $id_accept = $_GET['key'];
            $sql = "UPDATE transaksi_pembelian_detail 
                    SET diterima=?, tgl_diterima=?
                    WHERE id_pembelian_detail=?";
            $q = $db->prepare($sql);
            $q->execute(array(1, date('Y-m-d'), $id_accept));

            $update_stok = $db->prepare("UPDATE barang 
                    SET jml_stok = ?
                    WHERE barcode_barang = ?");
            $update_stok->execute(array($jml_stok_akhir, $ada['barcode_barang']));            
        
            header("location: barang_masuk.php");
        }
    }

    $result = $db->prepare("SELECT transaksi_pembelian_detail.id_pembelian_detail, transaksi_pembelian_detail.id_pembelian, transaksi_pembelian_detail.barcode_barang, transaksi_pembelian_detail.jml_beli, transaksi_pembelian_detail.keterangan, barang.nama_barang FROM transaksi_pembelian_detail INNER JOIN barang ON transaksi_pembelian_detail.barcode_barang = barang.barcode_barang WHERE transaksi_pembelian_detail.diterima IS NULL ORDER BY transaksi_pembelian_detail.id_pembelian ");
    $result->execute(); 
} catch(Exception $e){
    if($mode_debug = true) echo $e->getMessage();
    echo "<div class='col-md-12'>
            <div class='j-forms'>
                <div class='form-content'>
                    <div class='unit'> 
                        <div class='error-message text-center'>
                            <i class='fa fa-close'></i>Kesalahan data input.
                        </div>
                    </div>
                </div>
            </div>
        </div>";
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $judul;?> - Produk</title>
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

function set_keterangan(url_set){
    var id_pembelian_detail = decodeURIComponent(url_set);
    document.getElementById("hdn_keterangan").value = id_pembelian_detail;
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
            <h2>List Barang Masuk</h2>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Order List <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> Manage</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped data-tbl">
                <thead>
                <tr>
					<th>Nomor PO</th>
                    <th>Nama Barang</th>
                    <th>Barcode</th>
                    <th>Jumlah Pesanan</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    $keterangan_detail[$i] = $row['keterangan'];
                ?>
                        <tr>
						<td> <?php echo $row['id_pembelian'] ?> </td>
                        <td> <?php echo $row['nama_barang'] ?></td>
                        <td> <?php echo $row['barcode_barang'] ?></td>
                        <td> <?php echo ($row['jml_beli'] ? $row['jml_beli'] : "0") ?></td>
                        <td> <?php echo $row['keterangan'] ?></td>
                        <td class="td-center">
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group" role="group" data-toggle="modal" data-target="#myModal" onclick="set_keterangan( <?php echo $row['id_pembelian_detail'] . ",'" . $keterangan_detail[$i] ?> ')">
                                <a class="btn btn-default btn-sm m-user-edit"><i class="zmdi zmdi-edit"></i></a>
							</div>
							<div class="btn-group" role="group">
                                <a href="barang_masuk.php?method=details&key=<?php echo $row["id_pembelian_detail"]?>" class="btn btn-default btn-sm m-user-edit"><i class="zmdi zmdi-check"></i></a>
                            </div>
						</div>
						</td>
                <?php  
                    }
                ?>
                </tbody>
            </table>
    </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    <!-- Modal content-->
        <form action="barang_masuk.php" method="post" class="j-forms">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Keterangan</h4>
            </div>
            <div class="modal-body">
                <div class="unit">
                    <div class="input">
                        <label class="icon-left" for="keterangan">
                            <i class="fa fa-book"></i>
                        </label>
                        <input class="form-control login-frm-input"  type="text" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" value="<?php if(isset($row['keterangan'])) echo $row['keterangan']?>" required="true">
                        <input type="hidden" name="hdn_keterangan" id="hdn_keterangan">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success" name="update_keterangan">Simpan</button>
            </div>
        </div>
        </form>
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