<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 
require('../php/modular/fpdf.php');
if(isset($_POST['btn_cetak'])){
    $tgl = $_POST['range_cetak'];
    $no_struk = $_POST['no_transaksi_kasir'];
    $barang = $_POST['nama_barang'];
    // $penjualan

    // $result = $db_handle->runQuery("SELECT * FROM toy");
    // $header = $db_handle->runQuery("SELECT `COLUMN_NAME` 
    // FROM `INFORMATION_SCHEMA`.`COLUMNS` 
    // WHERE `TABLE_SCHEMA`='blog_samples' 
    //     AND `TABLE_NAME`='toy'");

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetTitle('Laporan Penjualan Bung');   
    $pdf->SetFont('Arial','B',12);  
    $pdf->Cell(40,10,$tgl . "-==-" . $no_struk . "-==-" . $barang); 
    $pdf->Output();
    // foreach($header as $heading) {
    //  foreach($heading as $column_heading)
    //      $pdf->Cell(90,12,$column_heading,1);
    // }
    // foreach($result as $row) {
    //  $pdf->SetFont('Arial','',12);   
    //  $pdf->Ln();
    //  foreach($row as $column)
    //      $pdf->Cell(90,12,$column,1);
    // }
    // $pdf->Output();
    // 
    
}


// $hasil = $db->prepare("SELECT a.id_transaksi_header, a.tgl_transaksi, c.nama_barang, b.barcode_barang, b.jml_barang, b.harga_sub_total, (c.harga_beli * b.jml_barang) AS harga_beli_subtotal, (b.harga_sub_total - (c.harga_beli * b.jml_barang)) AS margin_penjualan FROM transaksi_kasir a JOIN transaksi_kasir_detail b ON a.id_transaksi_header = b.id_transaksi_header JOIN barang c ON b.barcode_barang = c.barcode_barang GROUP BY b.id_transaksi_detail");
// $hasil->execute();

// $result = $db->prepare("SELECT 
//                         kary.*, dept.departemen AS nama_departemen
//                         FROM karyawan kary
//                         LEFT JOIN departemen dept ON kary.departemen = dept.kode_awal
//                         ORDER BY id_karyawan ASC");
// $result->execute(); 
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<title><?php echo $judul;?> - Laporan Penjualan</title>
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
</head>
<body class="overlay-leftbar">

<?php include('../php/modular/top-menu.php') ?>
<?php include('../php/modular/side-menu.php') ?>

<section class="main-container">
<div class="container-fluid">
<div class="page-header filled light single-line">
    <div class="row widget-header block-header">
        <div class="col-sm-6">
            <h2>Karyawan</h2>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Karyawan <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> Manage</li>
            </ul>
        </div>
    </div>

        <div class="row">
            <div class="col-md-12">
                <div class="widget-container">
                    <div class="widget-content">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-1 control-label">Tanggal</label>
                                <div class="col-md-2">
                                    <input class="form-control input-daterange-datepicker" type="text" name="daterange" value="<?php echo date('d/m/Y') . ' - ' . date('d/m/Y')?>"/>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Page Container End Here-->
<section class="main-container m-t-min-20"><?php include('../php/modular/footer.php') ?></section>

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
<!--Forms-->
<script src="../js/lib/jquery.maskedinput.js"></script>
<script src="../js/lib/jquery.validate.js"></script>
<script src="../js/lib/jquery.form.js"></script>
<script src="../js/lib/j-forms.js"></script>
<!--Forms Plugins-->
<script src="../js/lib/jquery.tagsinput.js"></script>
<script src="../js/lib/jquery.mask.js"></script>
<script src="../js/lib/jquery.bootstrap-touchspin.js"></script>
<script src="../js/lib/bootstrap-filestyle.js"></script>
<script src="../js/lib/selectize.js"></script>
<script src="../js/lib/bootstrap-datepicker.js"></script>
<script src="../js/lib/moment.js"></script>
<script src="../js/lib/daterangepicker.js"></script>

<script src="../js/apps.js"></script>
</body>
</html>