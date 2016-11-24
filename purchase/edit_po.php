<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');

// Kalo disubmit (edit) maka menjalankan script dibawah ini
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
if(isset($_POST['update_po'])){
    try{
        $no_po = $_POST['nomor_po'];
        $nama_supplier = $_POST['nama_supplier'];
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
        echo $no_po.$id_supplier.date('Y-m-d').$total_beli; die();
        
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
if(isset($_GET['key']) AND $_GET['method'] == 'no_po'){
    $no_po = urldecode($_GET['key']);
    $result = $db->prepare("SELECT a.*, b.* FROM transaksi_pembelian a JOIN supplier b ON a.id_supplier = b.id_supplier WHERE a.id_pembelian = :no_po");
    $result->bindParam(':no_po', $no_po);
    $result->execute();
    $row = $result->fetch();
    // for($i=0; $row = $result->fetch(); $i++){
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $judul;?> - Edit PO</title>
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

<script>
window.onload = function() {
    var SetFokus = $('#barang_1');
    SetFokus.val(SetFokus.val());
    var strLength= SetFokus.val().length;
    SetFokus.focus();
    SetFokus[0].setSelectionRange(strLength, strLength);
    document.getElementById("barang_1").disabled = false;
}
</script>

</head>

<body class="overlay-leftbar">
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
    enable_next(id_num);
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
            <h2>Edit Purchase Order</h2>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li>Pembelian <i class="zmdi zmdi-chevron-right"></i></li>
                <li>Purchase Order <i class="zmdi zmdi-chevron-right"></i></li>
                <li class="active-page"> Sunting</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="widget-container">
                <div class="widget-content">
                    <form action="edit_po.php" class="j-forms" method="post" id="order-forms-quantity" novalidate>
                        <div class="form-group">
                            <div class="unit">
                                <div class="input">
                                    <label class="icon-left" for="nomor_po">
                                        <i class="fa fa-book"></i>
                                    </label>
                                    <input class="form-control login-frm-input"  type="text" id="nomor_po" name="nomor_po" required="true" value="<?php if(isset($row['id_pembelian'])) echo $row['id_pembelian']; ?>" readonly>
                                </div>
                            </div>
                            <div class="unit">
                                <div class="input">
                                    <label class="icon-left" for="supplier">
                                        <i class="fa fa-barcode"></i>
                                    </label>
                                    <input class="form-control login-frm-input"  type="text" id="supplier" name="supplier" placeholder="Masukkan Nama Supplier" required="true" value="<?php if(isset($row['nama_supplier']))  echo $row['nama_supplier'];?>" readonly>
                                    <input type="hidden" name="hdn_id_supplier" value="<?php if(isset($row['id_supplier']))  echo $row['id_supplier'];?>">
                                </div>
                            </div>
                            <div class="unit">
                                <div class="input">
                                    <label class="icon-left" for="supplier">
                                        <i class="fa fa-barcode"></i>
                                    </label>
                                    <input type="text" class="form-control login-frm-input input-date-picker" value="<?php if(isset($row['tgl_po'])) echo $row['tgl_po'];?>">
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
                            <div class="unit">
                                <div class="input">
                                    <button type="button" class="btn btn-default col-md-6" onclick="window.location.href='<?php echo $url_web?>purchase/list_po.php'">Batal</button>
                                    <button type="submit" class="btn btn-success col-md-6" name="update_po">Update</button>

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
                    <h4 class="modal-title">Hapus Produk</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                    <i class="zmdi zmdi-alert-circle-o zmdi-hc-5x"></i>
                    <br/>
                    <br/>
                    Apakah anda yakin akan menghapus <?php echo $row['nama_barang'] . " (Barcode: " . $row['barcode_barang'] . ")" ?>?
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="barcode" value="<?php echo $row['barcode_barang'] ?>"/>
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
<script src="../js/lib/bootstrap-datepicker.js"></script>
<script src="../js/apps.js"></script>
<script src="../js/custom.js"></script>
</body>
</html>