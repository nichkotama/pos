<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 
// require('../php/modular/fpdf.php');
require('../php/modular/html_table.php');

if(isset($_POST['btn_cetak'])){
    $range = str_replace('/', '-',$_POST['range_cetak']);
    $tgl = explode(' - ', $range);
    $tgl_awal = date("Y-m-d", strtotime($tgl[0]));
    $tgl_akhir = date("Y-m-d", strtotime($tgl[1]));
    $no_struk = $_POST['filter_struk'];
    $barang = $_POST['filter_barang'];
    $bcodebarang = str_replace(')', '', end(explode('Barcode:', $barang)));
    // $penjualan

    $qPenjualan = "SELECT transaksi_kasir.id_transaksi_header, transaksi_kasir.tgl_transaksi, barang.nama_barang, transaksi_kasir_detail.barcode_barang, transaksi_kasir_detail.jml_barang, transaksi_kasir_detail.harga_sub_total, (barang.harga_beli * transaksi_kasir_detail.jml_barang) AS harga_beli_subtotal, (transaksi_kasir_detail.harga_sub_total - (barang.harga_beli * transaksi_kasir_detail.jml_barang)) AS margin_penjualan FROM transaksi_kasir JOIN transaksi_kasir_detail ON transaksi_kasir.id_transaksi_header = transaksi_kasir_detail.id_transaksi_header JOIN barang ON transaksi_kasir_detail.barcode_barang = barang.barcode_barang WHERE tgl_transaksi BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "' ";
    if($no_struk != ''){
        $qPenjualan .= "AND transaksi_kasir.id_transaksi_header = '$no_struk' ";
    }
    if($barang != ''){
        $qPenjualan .= "AND transaksi_kasir_detail.barcode_barang = '$bcodebarang' ";
    }
    $qPenjualan .= "GROUP BY transaksi_kasir_detail.id_transaksi_detail";
    $result_penjualan = $db->prepare($qPenjualan);
    $result_penjualan->execute();
    $pdf=new PDF();
    $pdf->AddPage('P','A4');
    // HEADER
    $pdf->Image($url_web.'images/logo-dark-mini.png',18,13,20);
    $pdf->SetFont('Arial','B',10); 
    $kop = "BM Mart";
    $kop_2 = "Jl. Lodan Raya No. 2, Ancol - Jakarta Utara";
    $kop_3 = "Laporan Penjualan Tanggal " . $_POST['range_cetak'];
    $pdf->Text(100 - ($pdf->GetStringWidth($text) / 2), 15, $kop);
    $pdf->Text(70 - ($pdf->GetStringWidth($text) / 2), 20, $kop_2);
    $pdf->Text(62 - ($pdf->GetStringWidth($text) / 2), 25, $kop_3);

    // BODY
    $pdf->SetFont('Arial','B',6); 
    $htmlTable="<TABLE BORDER='1px' cellspacing='0' cellpadding='0'>";
    $htmlTable.="<TR>";
    $htmlTable.="<TD width='75' bgcolor='#D0D0FF'>No. Struk</TD>";
    $htmlTable.="<TD width='75' bgcolor='#D0D0FF'>Tanggal</TD>";
    $htmlTable.="<TD width='250' bgcolor='#D0D0FF'>Nama Barang</TD>";
    $htmlTable.="<TD width='80' bgcolor='#D0D0FF'>Barcode</TD>";
    $htmlTable.="<TD width='50' bgcolor='#D0D0FF'>Jumlah</TD>";
    $htmlTable.="<TD width='75' bgcolor='#D0D0FF'>Harga Jual</TD>";
    $htmlTable.="<TD width='75' bgcolor='#D0D0FF'>Harga Beli</TD>";
    $htmlTable.="<TD width='75' bgcolor='#D0D0FF'>Laba</TD>";
    $htmlTable.="</TR>";
    for($i=0;$row = $result_penjualan->fetch();$i++){
        $htmlTable.="<TR>";
        $htmlTable.="<TD width='75'>".$row['id_transaksi_header']."</TD>";
        $htmlTable.="<TD width='75'>".$row['tgl_transaksi']."</TD>";
        $htmlTable.="<TD width='250'>".$row['nama_barang']."</TD>";
        $htmlTable.="<TD width='80'>".$row['barcode_barang']."</TD>";
        $htmlTable.="<TD width='50'>".$row['jml_barang']."</TD>";
        $htmlTable.="<TD width='75'>".str_replace(',', '.', number_format($row['harga_sub_total']))."</TD>";
        $htmlTable.="<TD width='75'>".str_replace(',', '.', number_format($row['harga_beli_subtotal']))."</TD>";
        $htmlTable.="<TD width='75'>".str_replace(',', '.', number_format($row['margin_penjualan']))."</TD>";
        $htmlTable.="</TR>";
    }
    $htmlTable.="</TABLE>";
    $pdf->WriteHTML("<br><br><br><br><hr><br>$htmlTable");
    $pdf->Output(); 
}


$hasil_select = $db->prepare("SELECT transaksi_kasir.id_transaksi_header, transaksi_kasir.tgl_transaksi, barang.nama_barang, transaksi_kasir_detail.barcode_barang, transaksi_kasir_detail.jml_barang, transaksi_kasir_detail.harga_sub_total, (barang.harga_beli * transaksi_kasir_detail.jml_barang) AS harga_beli_subtotal, (transaksi_kasir_detail.harga_sub_total - (barang.harga_beli * transaksi_kasir_detail.jml_barang)) AS margin_penjualan FROM transaksi_kasir JOIN transaksi_kasir_detail ON transaksi_kasir.id_transaksi_header = transaksi_kasir_detail.id_transaksi_header JOIN barang ON transaksi_kasir_detail.barcode_barang = barang.barcode_barang GROUP BY transaksi_kasir_detail.id_transaksi_detail");
$hasil_select->execute();

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
    <link type="text/css" rel="stylesheet" href="../css/custom.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>

</head>
<body class="overlay-leftbar">
<script type="text/javascript">

$(function() {  
    $( ".barcode" ).autocomplete({
        source: "../php/modular/autocomplete.php?src=nama_barang",  
        minLength:2, 
        autoFocus:true,
        focus: function (event, ui) {
            $(this).val(ui.item.value);
        }
    });
    $( ".struk" ).autocomplete({
        source: "../php/modular/autocomplete.php?src=nomor_struk",  
        minLength:2, 
        autoFocus:true,
        focus: function (event, ui) {
            $(this).val(ui.item.value);
        }
    });
});
</script>
<?php include('../php/modular/top-menu.php') ?>
<?php include('../php/modular/side-menu.php') ?>

<section class="main-container">
<div class="container-fluid">
<div class="page-header filled light single-line">
    <div class="row widget-header block-header">
        <div class="col-sm-6">
            <h2>Laporan Penjualan</h2>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Laporan <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> Laporan Penjualan</li>
            </ul>
        </div>
    </div>

        <div class="row">
            <div class="col-md-12">
                <div class="widget-container">
                    <div class="widget-content">
                        <form action="laporan_penjualan.php" class="form-horizontal" method="post" target="_blank">
                            <div class="form-group">
                                <label class="col-md-1 control-label">Tanggal</label>
                                <div class="col-md-3">
                                    <input class="form-control input-daterange-datepicker" type="text" name="range_cetak" value="<?php echo date('d/m/Y') . ' - ' . date('d/m/Y')?>"/>
                                </div>
                                
                                <label class="col-md-1 control-label">Opsional <i class="zmdi zmdi-chevron-right"> </i></label>
                                <div class="col-md-3">
									<input type="text" name="filter_struk" class="struk form-control" placeholder="Masukkan nomor struk">
                                </div>
                                <div class="col-md-3">
									<input type="text" name="filter_barang" class="barcode form-control" placeholder="Masukkan nama atau barcode">
                                </div>
            					<button type="submit" name="btn_cetak" class="btn btn-success" style="width:64px;"><i class="zmdi zmdi-print"></i></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped data-tbl">
                <thead>
                <tr>
                    <th>No. Struk</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Barcode</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Laba</th>
                </tr>
                </thead>
                <tbody>
            <?php
            # untuk view_data
                for ($i = 0; $row = $hasil_select->fetch(); $i++) {
            ?>
                <tr>
                <td> <?php echo $row["id_transaksi_header"];?> </td>
                <td> <?php echo $row["tgl_transaksi"];?> </td>
                <td> <?php echo $row["nama_barang"];?> </td>
                <td> <?php echo $row["barcode_barang"];?> </td>
                <td> <?php echo $row["jml_barang"];?> </td>
                <td> <?php echo money_format('%.2n', $row["harga_sub_total"]);?> </td>
                <td> <?php echo money_format('%.2n', $row["harga_beli_subtotal"]);?> </td>
                <td> <?php echo money_format('%.2n', $row["margin_penjualan"]);?> </td>
            <?php
                }
            ?>
                </tbody>
            </table>
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
<script src="../js/custom.js"></script>
</body>
</html>