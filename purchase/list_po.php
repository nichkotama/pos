<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 
try{
    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    // ADD PO
    if(isset($_POST['submit_po'])){
        $no_po = $_POST['nomor_po'];
        $nama_supplier = $_POST['supplier'];
        $id_supplier = $_POST['id_supplier'];

        $nama_item1 = $_POST['barang_1'];
        $barcode_item1 = get_string_between($nama_item1, '(Barcode:', ')');
        $kuantitas1 = $_POST['qty_1'];
        $subtotal1 = $_POST['subtotalbeli_1'];

        $nama_item2 = (isset($_POST['barang_2']) ? $_POST['barang_2'] : '');
        $barcode_item2 = get_string_between($nama_item2, '(Barcode:', ')');
        $kuantitas2 = (isset($_POST['qty_2']) ? $_POST['qty_2'] : 0);
        $subtotal2 = (isset($_POST['subtotalbeli_2']) ? $_POST['subtotalbeli_2'] : 0);

        $nama_item3 = (isset($_POST['barang_3']) ? $_POST['barang_3'] : '');
        $barcode_item3 = get_string_between($nama_item3, '(Barcode:', ')');
        $kuantitas3 = (isset($_POST['qty_3']) ? $_POST['qty_3'] : 0);
        $subtotal3 = (isset($_POST['subtotalbeli_3']) ? $_POST['subtotalbeli_3'] : 0);

        $nama_item4 = (isset($_POST['barang_4']) ? $_POST['barang_4'] : '');
        $barcode_item4 = get_string_between($nama_item4, '(Barcode:', ')');
        $kuantitas4 = (isset($_POST['qty_4']) ? $_POST['qty_4'] : 0);
        $subtotal4 = (isset($_POST['subtotalbeli_4']) ? $_POST['subtotalbeli_4'] : 0);

        $nama_item5 = (isset($_POST['barang_5']) ? $_POST['barang_5'] : '');
        $barcode_item5 = get_string_between($nama_item5, '(Barcode:', ')');
        $kuantitas5 = (isset($_POST['qty_5']) ? $_POST['qty_5'] : 0);
        $subtotal5 = (isset($_POST['subtotalbeli_5']) ? $_POST['subtotalbeli_5'] : 0);

        for($i=1; $i <= 5; $i++) {
            ${'subtotal' . $i} = str_replace(".","",${'subtotal' . $i});
        }
        $total_beli = $subtotal1 + $subtotal2 + $subtotal3 + $subtotal4 + $subtotal5;

        // SET PEMBELIAN HEADER
        $set_kepala = $db->prepare("INSERT INTO transaksi_pembelian (id_pembelian, id_supplier, tgl_po, total_pembelian)
        VALUES(?,?,?,?)");
        $set_kepala->execute(array($no_po,$id_supplier,date('Y-m-d'),$total_beli));
        // SET PEMBELIAN DETAIL
        for($i=1; $i<=5; $i++){
            if(${'nama_item'.$i} != ''){
                $q = "INSERT INTO transaksi_pembelian_detail (id_pembelian, barcode_barang, jml_beli, harga_sub_total)
                        VALUES(?,?,?,?)";
                $set_detail = $db->prepare($q);
                $set_detail->execute(array($no_po,${'barcode_item'.$i},${'kuantitas'.$i},${'subtotal'.$i}));
            }
        }

        // echo $id_supplier;
    }

    // ISI LIST
    $result = $db->prepare("SELECT transaksi_pembelian.id_pembelian, supplier.nama_supplier, transaksi_pembelian.tgl_po FROM transaksi_pembelian INNER JOIN supplier ON transaksi_pembelian.id_supplier = supplier.id_supplier");
    $result->execute(); 
    
    if(isset($_POST['create_po'])){
        $q = $db->prepare("INSERT INTO transaksi_kasir (id_transaksi_header, id_petugas, tgl_transaksi, harga_total) 
            VALUES (:id_transaksi_header, :id_karyawan, :tgl, :total)");
        $q->execute(array(':id_transaksi_header'=>$id_transaksi_header,':id_karyawan'=>$nik, ':tgl'=>$hari,':total'=>0));
        $kode_terakhir = $id_transaksi_header;
    }

    // DAPATKAN KODE TERAKHIR
    $top = $db->prepare("SELECT * FROM transaksi_pembelian WHERE id_pembelian LIKE '" . date('Y') . "/" . $bulan_romawi . "%' ORDER BY id_pembelian DESC LIMIT 1");
    $top->execute();
    $terakhir = $top->fetch();
    if(isset($terakhir['id_pembelian'])){
        $new_po =  str_pad((end(explode("/", $terakhir['id_pembelian'])) + 1), 4, '0', STR_PAD_LEFT);
        $nomor_po = date('Y') . "/" . $bulan_romawi . "/" . $new_po;
    }else{
        $nomor_po = date('Y') . "/" . $bulan_romawi . "/0001";
    }
}catch(Exception $e) {
    if($mode_debug = true) echo $e->getMessage();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $judul ?> - Purchase Order</title>
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
<script>
window.onload(){
    document.getElementById("barang_1").disabled = false;
}
</script>
<script type="text/javascript">
var id_supplier_select = '';
function fokus_teks() {
    document.getElementById("supplier").focus();
}

$(function() {  
    $( "#supplier" ).autocomplete({
        source: "../php/modular/autocomplete.php?src=supplier",  
        minLength:2, 
        autoFocus:true,
        select: function (event, ui) {
            document.getElementById("id_supplier").value = (ui.item.id);
            id_supplier_select = (ui.item.id);
        }
    });
    $( ".barcode" ).autocomplete({
        source: "../php/modular/autocomplete.php?src=nama_barang&supplier=SUP-001",  
        minLength:2, 
        autoFocus:true,
        focus: function (event, ui) {
            $(this).val(ui.item.value);
        },
        select: function (event, ui) {
            var baris_ke = this.id;
            baris_ke = baris_ke.split('_')[1];
            var hbeli = (ui.item.hbeli);
            document.getElementById("hargabeli_"+baris_ke).value = toRp(hbeli);
            document.getElementById("subtotalbeli_"+baris_ke).value = toRp(hbeli);
            get_totals();
        }
    });
    for(var loop=2;loop<=5;loop++){
        document.getElementById("barang_"+loop).disabled = true;
        document.getElementById("qty_"+loop).disabled = true;
        document.getElementById("hargabeli_"+loop).disabled = true;
    }
    document.getElementById("qty_1").value = 1;
    document.getElementById("barang_1").required = true;
});

function enable_next(id_next){
    if(document.getElementById("barang_"+id_next).value != ""){
        document.getElementById("barang_"+(id_next+1)).disabled = false;
        document.getElementById("qty_"+(id_next+1)).disabled = false;
        document.getElementById("qty_"+(id_next+1)).value = 1;
        document.getElementById("hargabeli_"+(id_next+1)).disabled = false;
    }else{
        document.getElementById("barang_"+(id_next+1)).disabled = true;
        document.getElementById("qty_"+(id_next+1)).disabled = true;
        document.getElementById("qty_"+(id_next+1)).value = "";
        document.getElementById("hargabeli_"+(id_next+1)).disabled = true;
        document.getElementById("hargabeli_"+id_next).value = "";
        get_totals();
    }
}

function clear_content(id_num){
    document.getElementById("barang_"+id_num).value = "";
    document.getElementById("qty_"+id_num).value =  1;
    document.getElementById("hargabeli_"+id_num).value =  "";
}

function get_totals(){
    var subtotal_hbeli = 0;
    if(document.getElementById("barang_1").value != "") {
        var hb1 = parseFloat(document.getElementById("hargabeli_1").value.replace(".", ""));
        subtotal_hbeli += hb1;
    }
    if(document.getElementById("barang_2").value != "") {
        var hb2 = parseFloat(document.getElementById("hargabeli_2").value.replace(".", ""));
        subtotal_hbeli += hb2;
    }
    if(document.getElementById("barang_3").value != "") {
        var hb3 = parseFloat(document.getElementById("hargabeli_3").value.replace(".", ""));
        subtotal_hbeli += hb3;
    }
    if(document.getElementById("barang_4").value != "") {
        var hb4 = parseFloat(document.getElementById("hargabeli_4").value.replace(".", ""));
        subtotal_hbeli += hb4;
    }
    if(document.getElementById("barang_5").value != "") {
        var hb5 = parseFloat(document.getElementById("hargabeli_5").value.replace(".", ""));
        subtotal_hbeli += hb5;
    }
    // alert(hb1);
    // subtotal_hbeli = hb1 + hb2 + hb3 + hb4 + hb5;
    document.getElementById("total_beli").value = toRp(subtotal_hbeli);
}

function set_hapus(url_set){
    var kode_po = decodeURIComponent(url_set);
    document.getElementById("yang_mau_dihapus").innerHTML = kode_po;
    document.getElementById("hdn_nomor_po").value = kode_po;
}

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
                <li><a href="#">Pembelian <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> Purchase Order</li>
            </ul>
        </div>
    </div>

    <div class="row widget-header block-header">
        <div class="col-sm-2 unit">
            <div class="input">
                <button type="button" class="btn btn-success" onclick=""  data-toggle="modal" data-target="#modalAddPO" onclick="fokus_teks()"><i class="zmdi zmdi-plus"> Buat PO</i></button>

                <!-- Modal -->
                <div class="modal fade" id="modalAddPO" role="dialog">
                    <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                        <form action="list_po.php" method="post" class="j-forms form-horizontal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Buat Purchase Order</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="unit col-md-6">
                                        <div class="input">
                                            <label class="icon-left" for="nomor_po">
                                                <i class="fa fa-book"></i>
                                            </label>
                                            <input class="form-control login-frm-input"  type="text" id="nomor_po" name="nomor_po" placeholder="Masukkan Nomor PO" required="true" value="<?php if(isset($nomor_po)) echo $nomor_po;?>" onfocus="this.blur();" readonly>
                                        </div>
                                    </div>
                                    <div class="unit col-md-6">
                                        <div class="input">
                                            <label class="icon-left" for="nama_supplier">
                                                <i class="zmdi zmdi-assignment-account"></i>
                                            </label>
                                            <input class="form-control"  type="text" id="supplier" name="supplier" placeholder="Pilih Supplier" required="true">
                                            <input type="hidden" name="id_supplier" id="id_supplier">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12" id="myTable">
                                        <div class="col-sm-1 heading-tabel">Clear</div>
                                        <div class="col-sm-1 heading-tabel">#</div>
                                        <div class="col-sm-3 heading-tabel">Item</div>
                                        <div class="col-sm-1 heading-tabel">Qty</div>
                                        <div class="col-sm-3 heading-tabel">Harga Satuan (Rp)</div>
                                        <div class="col-sm-3 heading-tabel">Sub-Total (Rp)</div>
                                    </div>
                                </div>
                                <?php for($i=1;$i<=5;$i++) { ?>
                                <div class="row">
                                    <div class="col-md-12" id="baris">
                                        <div class="col-md-1 p-tb-9"><button type="button" class="btn btn-danger" name="hapus_item" onfocus="this.blur();" onclick="clear_content(<?php echo $i?>)"><i class="zmdi zmdi-close"></i></button></div>
                                        <div class="col-md-1 p-tb-9"><?php echo ($i) ?></div> <!-- nomor_item_po -->
                                        <div class="col-md-3 p-tb-9"><input type="text" class="barcode form-control" placeholder="Masukkan nama barang" id="barang_<?php echo ($i)?>" onkeyup="enable_next(<?php echo $i;?>)" name="barang_<?php echo ($i)?>"></div>
                                        <div class="col-md-1 p-tb-9"><input type="number" class="form-control" id="qty_<?php echo ($i)?>" name="qty_<?php echo ($i)?>" min="1"></div>
                                        <div class="col-md-3 p-tb-9"><input type="text" class="form-control money-mask" id="hargabeli_<?php echo ($i)?>" name="hargabeli_<?php echo ($i)?>" readonly  onfocus="this.blur();"></div>
                                        <div class="col-md-3 p-tb-9"><input type="text" class="form-control money-mask" id="subtotalbeli_<?php echo ($i)?>" name="subtotalbeli_<?php echo ($i)?>" readonly  onfocus="this.blur();"></div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="pull-right col-md-3 p-tb-9" style="margin-right:1%;">
                                        <input type="text" class="form-control" id="total_beli" name="total_beli" placeholder="Total Belanja" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success" name="submit_po">Simpan</button>
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
            # untuk view_data
                for ($i = 0; $row = $result->fetch(); $i++) {
            ?>
                <tr>
                <td> <?php echo $row["id_pembelian"];?> </td>
                <td> <?php echo $row["tgl_po"];?></td>
                <td> <?php echo $row["nama_supplier"];?></td>
                <td class="td-center">
                    <div class="btn-toolbar" role="toolbar">
                        <!--<div class="btn-group" role="group">
                            <a href="edit_po.php?method=no_po&key=?php echo urlencode($row['id_pembelian']);?>" class="btn btn-default btn-sm m-user-edit"><i class="zmdi zmdi-edit"></i></a>
                        </div>-->
                        <div class="btn-group" role="group">
                            <a href="edit.php?method=barcode&key=<?php echo $row['id_pembelian'];?>" class="btn btn-default btn-sm m-user-edit"><i class="zmdi zmdi-print"></i></a>
                        </div>
                        <div class="btn-group" role="group" data-toggle="modal" data-target="#modalHapus" onclick="set_hapus('<?php echo urlencode($row['id_pembelian']);?>')" name="hapus">
                            <a class="btn btn-default btn-sm m-user-edit"><i class="zmdi zmdi-delete"></i></a>                                  
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
                    Apakah anda yakin akan menghapus seluruh data PO <span style="color:#17bab8" id="yang_mau_dihapus"></span> ?
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="nomor_po_hapus" id="hdn_nomor_po"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" name="hapus_po">Yakin</button>
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
<!-- Datatables -->
<script src="../js/lib/jquery.dataTables.js"></script>
<script src="../js/lib/dataTables.responsive.js"></script>
<script src="../js/lib/dataTables.tableTools.js"></script>
<script src="../js/lib/dataTables.bootstrap.js"></script>
<!--Forms-->
<script src="../js/lib/jquery.maskedinput.js"></script>
<script src="../js/lib/jquery.validate.js"></script>
<script src="../js/lib/jquery.form.js"></script>
<script src="../js/lib/j-forms.js"></script>
<script src="../js/lib/jquery.loadmask.js"></script>
<script src="../js/lib/vmap.init.js"></script>
<script src="../js/lib/theme-switcher.js"></script>
<script src="../js/apps.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/lib/jquery.mask.js"></script>
</body>
</html>