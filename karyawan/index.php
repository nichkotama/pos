<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 
$result = $db->prepare("SELECT 
                        kary.*, dept.departemen AS nama_departemen
                        FROM karyawan kary
                        LEFT JOIN departemen dept ON kary.departemen = dept.kode_awal
                        ORDER BY id_karyawan ASC");
$result->execute(); 

$departemen = $db->prepare("SELECT * FROM departemen ORDER BY kode_awal");
$departemen->execute();

try{
    if(isset($_POST['submit-tambah']) AND isset($_FILES['foto'])){
        $nik = $_POST['nik_hidden'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $telp = str_replace('-', '', $_POST['telp']);
        $alamat = $_POST['alamat'];
        $pass = $_POST['password'];
        $password    = crypt($pass, salt);
        $departemen_select = $_POST['departemen'];
        // $dept = $db->prepare("SELECT departemen FROM departemen WHERE kode_awal = '" . $f . "'");
        // $dept->execute();
        // $res = $dept->fetch(); //single return db
        $file_name = $_FILES['foto']['name'];
        $file_tmp  = $_FILES['foto']['tmp_name'];
        $file_size = $_FILES['foto']['size'];
        $file_ext = strtolower(end(explode(".", $file_name)));
        $ext_boleh = array("jpg", "png");
        if(in_array($file_ext, $ext_boleh) || $_FILES['foto']['size'] == 0 ){
            if($file_size <= 2*1024*1024)
            {
                if($_FILES['foto']['size'] != 0 ){
                    $sumber = $file_tmp;
                    $tujuan = "../images/karyawan/" . $nik . "." . $file_ext;
                    // die("sumber: " . $sumber . ", tujuan: " . $tujuan);
                    move_uploaded_file($sumber, $tujuan);
                }
            }
            else{
                echo "<div class='col-md-12'>
                    <div class='j-forms'>
                        <div class='form-content'>
                            <div class='unit'> 
                                <div class='error-message text-center'>
                                    <i class='fa fa-close'></i>Ukuran file maximal adalah 2MB, file anda terlalu besar.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
        // die("EXT FILE BOLEH DI UPLOAD.");
        }else{
            echo "<div class='col-md-12'>
                <div class='j-forms'>
                    <div class='form-content'>
                        <div class='unit'> 
                            <div class='error-message text-center'>
                                <i class='fa fa-close'></i>File yang dibolehkan adalah JPG dan PNG.
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
        }
        $sql = "INSERT INTO karyawan (id_karyawan,nama_karyawan,departemen,password,email,telp_karyawan,alamat_karyawan,foto) 
        VALUES (:nik,:nama,:dept,:password,:email,:telp,:alamat,:foto_wo_path)";
        $q = $db->prepare($sql);
        $q->execute(array(':nama'=>$nama,':email'=>$email,':telp'=>$telp,':alamat'=>$alamat,':password'=>$password,':nik'=>$nik,':dept'=>$departemen_select,':foto_wo_path'=>($nik . "." . $file_ext)));
        header("location: index.php");
    }
}catch(Exception $e){
    if($mode_debug = true) echo $e->getMessage();
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $judul;?> - Karyawan</title>
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
function cek_terakhir(kode_awal){
    $.get("../php/modular/autocomplete.php?kode_awal="+kode_awal, function(data){
        var last_num = parseInt(data);
        if (isNaN(last_num)) last_num = 0;
        var current_num = last_num + 1;
        var digit = "" + current_num
        var pad = "000";
        var ans = pad.substring(0, pad.length - digit.length) + digit;
        document.getElementById("nik").value = kode_awal + "-" + ans;
        document.getElementById("nik_hidden").value = kode_awal + "-" + ans;
    });
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
            <h2>Karyawan</h2>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Karyawan <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> Manage</li>
            </ul>
        </div>
    </div>

    <div class="row widget-header block-header">
        <div class="col-sm-2 unit">
            <div class="input">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAdd" onclick="fokus_teks()"><i class="zmdi zmdi-plus"> Tambah Karyawan</i></button>

                <!-- Modal -->
                <div class="modal fade" id="modalAdd" role="dialog">
                    <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                        <form action="index.php" method="post" class="j-forms" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Tambah Karyawan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <div class=" col-md-12 unit">
                                    <div class="input">
                                        <label class="icon-left" for="nama_karyawan">
                                            <i class="zmdi zmdi-account"></i>
                                        </label>
                                        <input class="form-control login-frm-input"  type="text" id="nama" name="nama" placeholder="Masukkan Nama Karyawan" required="true" value="<?php if(isset($nama)) echo $nama?>">
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12 unit">
                                    <div class="input">
                                        <label>
                                            Departemen
                                        </label>
                                            
                                        <label class="input select">
                                            <select class="form-control" name="departemen" onchange="if (this.value === 'add'){ 
                                                    $('#modalAdd').modal('toggle');
                                                    $('#modalAddDept').modal('toggle'); //harus ganti windows.redorect
                                                }else{
                                                    cek_terakhir(this.value);
                                                }
                                            ">
                                                <option disabled selected style="display:none;">-- Pilih departemen --</option>
                                                <?php
                                                for ($i = 0; $data = $departemen->fetch(); $i++) {
                                                    echo "<option value = '" . $data['kode_awal'] . "'>" . $data['departemen'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <i></i>
                                        </label>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6 unit">
                                    <div class="input">
                                        <label class="icon-left" for="nik">
                                            <i class="zmdi zmdi-assignment-account"></i>
                                        </label>
                                        <input class="form-control login-frm-input"  type="text" id="nik" name="nik" placeholder="Pilih Departemen Terlebih Dahulu" disabled="true" value="<?php if(isset($nik)) echo $nik?>">
                                        <input type="hidden" name="nik_hidden" id="nik_hidden">
                                    </div>
                                </div>
                                <div class="unit col-md-4">
                                    <label class="checkbox">
                                        <input type="checkbox" onchange="document.getElementById('nik').disabled = !this.checked;" >
                                        <i></i>
                                        Input NIK Secara Manual
                                    </label>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12 unit">
                                    <div class="input">
                                        <label class="icon-left" for="email">
                                            <i class="zmdi zmdi-email"></i>
                                        </label>
                                        <input class="form-control login-frm-input"  type="email" id="email" name="email" placeholder="Masukkan Email Karyawan" required="true" value="<?php if(isset($email)) echo $email?>">
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12 unit">
                                    <div class="input">
                                        <label class="icon-left" for="telp">
                                            <i class="zmdi zmdi-phone"></i>
                                        </label>
                                        <input class="form-control login-frm-input phone-mask"  type="text" id="telp" name="telp" placeholder="Masukkan Nomor Telepon Karyawan" required="true" value="<?php if(isset($telp)) echo $telp?>">
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12 unit">
                                    <div class="input">
                                        <label class="icon-left" for="password">
                                            <i class="zmdi zmdi-key"></i>
                                        </label>
                                        <input class="form-control login-frm-input"  type="password" id="password" name="password" placeholder="Masukkan Password Awal Karyawan" required="true" value="<?php if(isset($password)){ echo $password;}
                                        else{echo "123456";}?>">
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12 unit">
                                    <div class="input">
                                        <label class="icon-left" for="alamat">
                                            <i class="zmdi zmdi-home"></i>
                                        </label>
                                        <textarea class="form-control login-frm-input"  type="text" id="alamat" name="alamat" placeholder="Masukkan Alamat Lengkap Karyawan" required="true"> <?php if(isset($alamat)) echo $alamat?></textarea> 
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-1 control-label">Foto</label>
                                    <div class="col-md-11">
                                        <input type="file" name="foto" class="filestyle bootstrap-file" data-buttonbefore="true">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success" name="submit-tambah">Simpan</button>
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
                            <th>ID Karyawan</th>
                            <th>Nama Karyawan</th>
                            <th>Departemen</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <th class="td-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            for ($i = 0; $row = $result->fetch(); $i++) {
                                echo "<tr>";
                                # kolom id karyawan
                                echo "<td>" . $row['id_karyawan'] . "</td>";
                                # kolom nama karyawan
                                echo "<td>" . $row['nama_karyawan'] . "</td>";
                                # kolom barcode barang
                                echo "<td>" . $row['nama_departemen'] . "</td>";
                                # kolom barcode barang
                                echo "<td>" . $row['email'] . "</td>";
                                # kolom barcode barang
                                echo "<td><i class='td-profile-thumb'><img src='". $url_web . "images/karyawan/" . $row['foto'] . "'></i></td>";
                                # kolom aksi
                                echo "<td class='td-center'>
                                <div class='btn-toolbar' role='toolbar'>
                                    <div class='btn-group' role='group'>
                                        <a href='edit.php?method=karyawan&key=" . $row['id_karyawan'] . "' class='btn btn-default btn-sm m-user-edit'><i class='zmdi zmdi-edit'></i></a>
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
<script src="../js/lib/jquery.mask.js"></script>
</body>
</html>