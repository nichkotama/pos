<?php
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 


try {
    // $sql = "INSERT INTO transaksi_kasir (id_petugas, tgl_transaksi, harga_total) 
    //     VALUES (:id_karyawan, :tgl, :total)";
    // $q = $db->prepare($sql);
    // $q->execute(array(':id_karyawan'=>$nik, ':tgl'=>$hari,':total'=>0));
    // if(!isset($_SESSION['kode_transaksi_header'])){
        // $_SESSION['kode_transaksi_header'] = date('Ymd').str_pad($test2,3,'0',STR_PAD_LEFT);
    // }
    // unset($_SESSION['kode_transaksi_header']);
    $top = $db->prepare("SELECT * FROM transaksi_kasir WHERE id_transaksi_header LIKE '" . date(Ymd) . "%' ORDER BY id_transaksi_header DESC LIMIT 1");
    $top->execute();
    $terakhir = $top->fetch();
    if(isset($terakhir['id_transaksi_header'])){ 
        $kode_terakhir = (int) $terakhir['id_transaksi_header'] + 1;
    }else{
        $nik = $_SESSION['uname'];
        $hari = date("Y-m-d");
        $id_transaksi_header = date(Ymd)."001";
        $sql = "INSERT INTO transaksi_kasir (id_transaksi_header, id_petugas, tgl_transaksi, harga_total) 
            VALUES (:id_transaksi_header, :id_karyawan, :tgl, :total)";
        $q = $db->prepare($sql);
        $q->execute(array(':id_transaksi_header'=>$id_transaksi_header,':id_karyawan'=>$nik, ':tgl'=>$hari,':total'=>0));
        $kode_terakhir = $id_transaksi_header;
    }
    // echo $_SESSION['kode_transaksi_header'];
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

    function myFunction(src, isi) {
        var table = document.getElementById("myTable");
        if( src == 'barcode' ){
            try{
                nilai = !isNaN(parseInt(isi)); //number = true; string = false; buat detect dia input nama apa barcode
                barcode = document.getElementById("barcode").value;
                items[number] = isi;
                qty[number] = 1;
                if( src == 'qty' ){
                    qty[number] = nilai;
                }
                $.get("add_to_cart.php?whatever="+barcode, function(data){
                    var row = JSON.parse(data);
                    table.innerHTML = table.innerHTML +
                        '<div id = "baris-' + number + '">'  
                        + '<div class="col-sm-1"><button class="btn btn-danger" onclick="deleteRow(' + number+1 + ')"><i class="zmdi zmdi-close"></i></button></div>' 
                        + '<div class="col-sm-1 p-tb-9">' + number + '</div>' 
                        + '<div class="col-sm-3 p-tb-9">' + row.nama_barang +'</div>' 
                        + '<div class="col-sm-1"><input class="form-control" type="number" value="' + qty[number] +'"/></div>' 
                        + '<div class="col-sm-3"><input class="form-control" type="text" value="' + row.harga_jual +'" readonly=""/></div>' 
                        + '<div class="col-sm-3"><input class="form-control" type="text" value="' + (qty[number] * row.harga_jual) +'" readonly=""/></div>' 
                        + '</div>'
                });
            }catch(err){
            }
        }else if( src == 'qty' ){
            qty[number] = nilai;
        }
        document.getElementById("barcode").value = '';
        document.getElementById("qty").value = 1;
        document.getElementById("barcode").focus();
        barang[number] = items[number];
        number++;
        // var row = table.insertRow(1);
        // var cell1 = row.insertCell(0);
        // var cell2 = row.insertCell(1);
        // cell1.innerHTML = "NEW CELL1";
        // cell2.innerHTML = "NEW CELL2"; 
    }
    
    function deleteRow( number ){
        // document.getElementById('baris-'+number).remove();
        document.getElementById('baris-'+number).innerHTML =  
            '<div id = "baris-' + number + '">'  
            + '<div class="col-sm-1 barang-cancel"><button class="btn btn-danger" onclick="deleteRow(' + number + ')"><i class="zmdi zmdi-close"></i></button></div>' 
            + '<div class="col-sm-1 p-tb-9 barang-cancel">' + number + '</div>' 
            + '<div class="col-sm-3 p-tb-9 barang-cancel">' + items[number] +'</div>' 
            + '<div class="col-sm-1"><input class="form-control" type="number" value="' + qty[number] +'" readonly=""/></div>' 
            + '<div class="col-sm-3"><input class="form-control" type="number" value="' + qty[number] +'" readonly=""/></div>' 
            + '<div class="col-sm-3"><input class="form-control" type="number" value="' + qty[number] +'" readonly=""/></div>' 
            + '</div>';
        delete barang[number];
        delete items[number];
        delete qty[number];
        }

    function cek_enter(e, src) {
        if (e.keyCode == 13) {
            if( src == 'barcode' ){
                nilai = document.getElementById('barcode').value;
                if (nilai == "") nilai = "item tidak diinput";
            }else if( src == 'qty' ){
                nilai = document.getElementById('qty').value;
            }
            return myFunction(src, nilai);
            // var field_barcode = document.getElementById('barcode');
            // var field_qty = document.getElementById('qty');
            // field_barcode.innerHTML = "";
            // field_qty.innerHTML = "";
        }
    }
    function printData(){
        document.getElementById('cumateksbung').innerHTML = 'barang >> ' + barang + '<br/>items >> ' + items + '<br/>qty >> ' + qty;
    }
</script>
<script>
    $(function() {  
        $( "#barcode" ).autocomplete({
            source: "../php/modular/autocomplete.php?src=barcode_barang",  
            minLength:2, 
            autoFocus:true,
            select: function( event, ui ) {
              document.getElementById('tampilan').innerHTML = ui.item.value;
            },
            focus: function (event, ui) {
                $(this).val(ui.item.value);
            }
        });
    });
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
                                <!-- start name -->
                                <div class="col-sm-7 unit">
                                    <div class="input">
                                        <label class="icon-left" for="name">
                                            <i class="fa fa-barcode"></i>
                                        </label>
                                        <input class="form-control" type="text" id="barcode" name="barcode" placeholder="Scan or Type Barcode Item Here" onkeypress="return cek_enter(event, 'barcode')">
                                    </div>
                                </div>
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
                                        <button type="submit" class="btn btn-success" onclick="myFunction()"><i class="zmdi zmdi-plus"> Add Item</i></button>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-sm-12" id="myTable">
                                        <div class="col-sm-1 heading-tabel">Remove</div>
                                        <div class="col-sm-1 heading-tabel">#</div>
                                        <div class="col-sm-3 heading-tabel">Item</div>
                                        <div class="col-sm-1 heading-tabel">Qty</div>
                                        <div class="col-sm-3 heading-tabel">Harga Satuan</div>
                                        <div class="col-sm-3 heading-tabel">Sub-Total</div>
                                    </div>
                                </div>

                                <!-- start totals -->
                                <div class="row m-t-20">
                                    <div class="col-md-offset-8 col-md-4 unit">
                                        <div class="input">
                                            <input class="form-control" type="text" placeholder="Totals" id="field_totals" readonly="" name="field_totals">
                                        </div>
                                    </div>
                                </div>
                                <!-- end totals -->

                                <!-- start response from server -->
                                <div id="response"></div>
                                <!-- end response from server -->

                            <!-- end /.content -->

                            <div class="form-footer">
                                <button type="submit" class="btn btn-success primary-btn" style="width:30%; height:50px">Pay</button>
                            </div>
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
