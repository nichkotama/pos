<?php
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 


try {
    $nik = $_SESSION['uname'];
    $hari = date("Y-m-d");
    /* *
    * note : later must be added : SELECT * FROM transaksi_kasir_detail WHERE id_transaksi_header LIKE;
    * buat ngecek apa dia ngeklik pay now tanpa ada barang
    * */
    if(isset($_POST['add_to_cart'])){
        $terakhir = $_SESSION['kode_transaksi_header'];
        $bcode = $_POST['barcode'];
        $harga_subTotal = 0;
        if(!is_numeric($bcode)){
            // dapetin barcode produk
            $bc = $db->prepare("SELECT barcode_barang, harga_jual FROM barang WHERE nama_barang = '" . $bcode . "' AND jml_stok > 0");
            $bc->execute();
            $new_bc = $bc->fetch();
            $bcode = $new_bc['barcode_barang'];
            $harga_subTotal = $new_bc['harga_jual'];
        }
        // perlu cari ada duplikat apa ga
        $sql = "INSERT INTO transaksi_kasir_detail (id_transaksi_header, barcode_barang, jml_barang, harga_sub_total) 
            VALUES(?, ?, ?, ?)";
        $q = $db->prepare($sql);
        $q->execute(array($terakhir,$bcode,1,$harga_subTotal)); // pertama kali input jml_barangnya 1
    }

    if(isset($_POST['bayar'])){
        $terakhir = (int) $_SESSION['kode_transaksi_header'] + 1;
        $sql = "INSERT INTO transaksi_kasir (id_transaksi_header, id_petugas, tgl_transaksi, harga_total) 
            VALUES (:id_transaksi_header, :id_karyawan, :tgl, :total)";
        $q = $db->prepare($sql);
        $q->execute(array(':id_transaksi_header'=>$terakhir,':id_karyawan'=>$nik, ':tgl'=>$hari,':total'=>0));
        $_SESSION['kode_transaksi_header'] = $terakhir;
    // echo $_SESSION['kode_transaksi_header'];
    }

    if(isset($_GET['updateQty']) AND isset($_GET['bc'])){
        $kode_kasir = $_GET['updateQty'];
        $bcode = $_GET['bc'];
        $jml = $_GET['jumlah'];

        $harga = $db->prepare("SELECT harga_jual FROM barang WHERE barcode_barang='" . $bcode . "'");
        $harga->execute();
        $harga_get = $harga->fetch();
        $harga_satuan = (float) $harga_get['harga_jual'];

        $sql = "UPDATE transaksi_kasir_detail SET jml_barang= " . $jml . ", harga_sub_total=" . ($harga_satuan * $jml) . " WHERE id_transaksi_header = '" . $kode_kasir . "' AND barcode_barang='" . $bcode ."'";
        $q = $db->prepare($sql);
        $q->execute(); // pertama kali input jml_barangnya 1
        die();
    }

    if(isset($_POST['hapus_item'])){
        $id_transaksi_kasir = $_POST['remove'];
        $barang = $_POST['item'];
        $sql = "DELETE FROM transaksi_kasir_detail WHERE id_transaksi_header = '" . $id_transaksi_kasir 
            . "' AND barcode_barang = '" . $barang . "'";
            echo $sql;
        $q = $db->prepare($sql);
        $q->execute();
    }

    $top = $db->prepare("SELECT * FROM transaksi_kasir WHERE id_transaksi_header LIKE '" . date(Ymd) . "%' ORDER BY id_transaksi_header DESC LIMIT 1");
    $top->execute();
    $terakhir = $top->fetch();

    if(isset($_SESSION['kode_transaksi_header'])){
        if(isset($terakhir['id_transaksi_header'])){ // penjualan belum close atau klik pay
            $load_data = $db->prepare("SELECT * FROM transaksi_kasir_detail WHERE id_transaksi_header = " . $_SESSION['kode_transaksi_header']);
            $load_data->execute();
            $data = $load_data->fetch();
            $kode_terakhir = (int) $terakhir['id_transaksi_header'];
        }else{ // session masih ada tapi belum ada transaksi
            unset($_SESSION['kode_transaksi_header']);
        }
    }else{
        // Kalau belum, buat baru
        $id_transaksi_header = date(Ymd)."0001";
        $q = $db->prepare("INSERT INTO transaksi_kasir (id_transaksi_header, id_petugas, tgl_transaksi, harga_total) 
            VALUES (:id_transaksi_header, :id_karyawan, :tgl, :total)");
        $q->execute(array(':id_transaksi_header'=>$id_transaksi_header,':id_karyawan'=>$nik, ':tgl'=>$hari,':total'=>0));
        $kode_terakhir = $id_transaksi_header;
    
        $_SESSION['kode_transaksi_header'] = $kode_terakhir;
    }
} catch(Exception $e) {
    if($mode_debug = true) echo $e->getMessage();
}
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
    var barcode = '';
    var number = 0;
    var items = [];
    var qty = [];
    var isaNumber = false;
    var nilai = '';
    var barang = [];
    var banyak = [];
    window.onload = function() {
        var input = document.getElementById("barcode").focus();

    }
    $(function() {  
        $( "#barcode" ).autocomplete({
            source: "../php/modular/autocomplete.php?src=barcode_barang",  
            minLength:2, 
            autoFocus:true,
            focus: function (event, ui) {
                $(this).val(ui.item.value);
            }
            // select: function( event, ui ) {
            //     $.ajax({ /* THEN THE AJAX CALL */
            //         type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            //         url: "get-data.php", /* PAGE WHERE WE WILL PASS THE DATA */
            //         data: dataString, /* THE DATA WE WILL BE PASSING */
            //         success: function(result){ /* GET THE TO BE RETURNED DATA */
            //             $("#show").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
            //         }
            //     });
            // },
        });
    });
    function updateQty(kode,barcode){
        var jumlah = document.getElementById('qty_'+barcode).value;
        $.get("index.php?updateQty="+kode+"&bc="+barcode+"&jumlah="+jumlah, function(data){
            var hsatuan = document.getElementById("hargasatuan_"+barcode).value;
            angka_harga = hsatuan.replace(".", ",");
            angka_harga = hsatuan.replace(",", ".");
            document.getElementById("hargasub_"+barcode).value = parseFloat(angka_harga) * parseFloat(jumlah);
            // do nothing
        });
    }
</script>

<?php include('../php/modular/top-menu.php') ?>
<?php include('../php/modular/side-menu.php') ?>

<!--Page Container Start Here-->
<section class="main-container">
<div class="container-fluid">
<div class="page-header filled light">
    <div class="row widget-header block-header">
        <div class="col-sm-6">
            <h2>Sales</h2>
            <p>Penjualan Hari <?php echo $hari_ini ?></p>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Sales <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> Session</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="widget-container">
                <div class="widget-content">
                    <!-- <form action="#" method="post" class="j-forms" id="order-forms-quantity" novalidate> -->
                    <div class="j-forms" id="order-forms-quantity" novalidate>
                        <div class="form-group">
                            <form action="index.php" method="post">
                            <div class="col-sm-7 unit">
                                <div class="input">
                                    <label class="icon-left" for="name">
                                        <i class="fa fa-barcode"></i>
                                    </label>
                                    <input class="form-control" type="text" id="barcode" name="barcode" placeholder="Scan or Type Barcode Item Here">
                                </div>
                            </div>
                            <!-- start name -->
                            <!-- <div class="col-sm-3 unit">
                                <div class="input">
                                    <label class="icon-left" for="name">
                                        <i class="zmdi zmdi-shopping-basket"></i>
                                    </label>
                                    <input class="form-control" type="number" id="qty" placeholder="Qty" value=1 min=1 onkeypress="return cek_enter(event, 'qty')"> 
                                </div>
                            </div> -->
                            <div class="col-sm-2 unit">
                                <div class="input">
                                    <button type="submit" name="add_to_cart" class="btn btn-success"><i class="zmdi zmdi-plus"> Add Item</i></button>
                                </div>
                            </div>
                            </form>
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
            <form action="index.php" method="post">
            <div class="row">
            <?php
                $total_belanja = 0;
                if(isset($terakhir['id_transaksi_header'])){ // penjualan belum close atau klik pay
                $load_data = $db->prepare("SELECT detail.*, barang.* FROM transaksi_kasir_detail detail JOIN barang ON detail.barcode_barang = barang.barcode_barang WHERE id_transaksi_header = '" . $_SESSION['kode_transaksi_header'] ."'");
                $load_data->execute();
                for($i=0; $data = $load_data->fetch(); $i++){
                    echo "<div class='col-sm-12' id='baris'>"  
                    . "<div class='col-sm-1'><button class='btn btn-danger' name='hapus_item' type='submit'><i class='zmdi zmdi-close'></i></button>" . "<input type='hidden' name='remove' value='" . $_SESSION['kode_transaksi_header'] . "'/><input type='hidden' name='item' value='" . $data['barcode_barang'] . "'/></div>" 
                    . "<div class='col-sm-1 p-tb-9'>" . ($i+1) . "</div>" 
                    . "<div class='col-sm-3 p-tb-9'>" . $data['nama_barang'] . '</div>' 
                    . "<div class='col-sm-1'><input class='form-control' style='width:60px' type='number' id='qty_" .$data['barcode_barang'] . "' value='" . $data['jml_barang'] . "' onblur='updateQty(" . $_SESSION['kode_transaksi_header'] . "," . $data['barcode_barang'] . " )'></div>"
                    . "<div class='col-sm-3'><input class='form-control' type='text' id='hargasatuan_" .$data['barcode_barang'] . "' value='" . number_format(($data['harga_jual']),2,',','.') . "' readonly=''></div>" 
                    . "<div class='col-sm-3'><input class='form-control' type='text' id='hargasub_" .$data['barcode_barang'] . "' value='" . number_format(($data['harga_sub_total']),2,',','.') . "' readonly=''></div>"
                    . "</div>";
                    $total_belanja += (float) $data['harga_sub_total'];
                }   
                }             
            ?>
            </div>
            </form>
                            <!-- start totals -->
                            <div class="row m-t-20">
                                <div class="col-md-offset-9 col-sm-3 unit">
                                    <div class="input">
                                        <input class="form-control" type="text" placeholder="Totals" id="field_totals" readonly="" name="field_totals" value="<?php echo number_format(($total_belanja),2,',','.');?>">
                                    </div>
                                </div>
                            </div>
                            <!-- end totals -->
                            <!-- start response from server -->
                            <div id="response"></div>
                            <!-- end response from server -->
                            <!-- end /.content -->
                            <form action="index.php" method="post">
                            <div class="form-footer">
                                <button type="submit" name="bayar" class="btn btn-success primary-btn" style="width:30%; height:50px">Pay Now</button>
                            </div>
                            </form>
                            <!-- end /.footer -->
                            <!-- <button class="btn btn-danger" onclick="printData()">TEST Data</button> -->
                            <div id="cumateksbung"></div>
                            <div id="tampilan"></div>
                            <div id="wowtd"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
