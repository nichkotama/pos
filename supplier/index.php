<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 
$result = $db->prepare("SELECT * FROM supplier ORDER BY nama_supplier");
$result->execute(); 

$departemen = $db->prepare("SELECT * FROM departemen ORDER BY kode_awal");
$departemen->execute();

try{
    if(isset($_POST['submit-tambah'])) {
        $id_supplier = $_POST['hidden_id'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $telp = str_replace('-', '', $_POST['telp']);
        $alamat = $_POST['alamat'];
        // $dept = $db->prepare("SELECT departemen FROM departemen WHERE kode_awal = '" . $f . "'");
        // $dept->execute();
        // $res = $dept->fetch(); //single return db
       
        $sql = "INSERT INTO supplier (id_supplier, nama_supplier, no_telp, email, alamat) 
        VALUES (:id, :nama, :telp, :email, :alamat)";
        $q = $db->prepare($sql);
        $q->execute(array(':id'=>$id_supplier,':nama'=>$nama,':email'=>$email,':telp'=>$telp,':alamat'=>$alamat));
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
    <title><?php echo $judul;?> - Supplier</title>
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
function cek_terakhir(){
    $.get("../php/modular/autocomplete.php?method=id_supplier", function(data){
        var last_num = parseInt(data);
        if (isNaN(last_num)) last_num = 0;
        var current_num = last_num + 1;
        var digit = "" + current_num
        var pad = "000";
        var ans = pad.substring(0, pad.length - digit.length) + digit;
        document.getElementById("id_supplier").value = "SUP" + "-" + ans;
        document.getElementById("hidden_id").value = "SUP" + "-" + ans;
    });
}
window.onload = function() {
  cek_terakhir();
};
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
            <h2>Supplier</h2>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Supplier <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> Manage</li>
            </ul>
        </div>
    </div>

    <div class="row widget-header block-header">
        <div class="col-sm-2 unit">
            <div class="input">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAdd" onclick="fokus_teks()"><i class="zmdi zmdi-plus"> Tambah Supplier</i></button>

                <!-- Modal -->
                <div class="modal fade" id="modalAdd" role="dialog">
                    <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                        <form action="index.php" method="post" class="j-forms" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Tambah Supplier</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <div class="col-md-6 unit">
                                    <div class="input">
                                        <label class="icon-left" for="id_supplier">
                                            <i class="zmdi zmdi-assignment-account"></i>
                                        </label>
                                        <input class="form-control login-frm-input"  type="text" id="id_supplier" name="id_supplier" placeholder="Pilih Departemen Terlebih Dahulu" disabled="true" value="<?php if(isset($id_supplier)) echo $id_supplier?>" onkeyup="document.getElementById('hidden_id').value = this.value">
                                        <input type="hidden" name="hidden_id" id="hidden_id">
                                    </div>
                                </div>
                                <div class="unit col-md-4">
                                    <label class="checkbox">
                                        <input type="checkbox" onchange="document.getElementById('id_supplier').disabled = !this.checked;" >
                                        <i></i>
                                        Input ID Supplier Secara Manual
                                    </label>
                                </div>
                                </div>
                                <div class="row">
                                <div class=" col-md-12 unit">
                                    <div class="input">
                                        <label class="icon-left" for="nama">
                                            <i class="zmdi zmdi-account"></i>
                                        </label>
                                        <input class="form-control login-frm-input"  type="text" id="nama" name="nama" placeholder="Masukkan Nama Supplier" required="true" value="<?php if(isset($nama_supplier)) echo $nama_supplier?>">
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12 unit">
                                    <div class="input">
                                        <label class="icon-left" for="email">
                                            <i class="zmdi zmdi-email"></i>
                                        </label>
                                        <input class="form-control login-frm-input"  type="email" id="email" name="email" placeholder="Masukkan Email Supplier" required="true" value="<?php if(isset($email)) echo $email?>">
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12 unit">
                                    <div class="input">
                                        <label class="icon-left" for="telp">
                                            <i class="zmdi zmdi-phone"></i>
                                        </label>
                                        <input class="form-control login-frm-input phone-mask"  type="text" id="telp" name="telp" placeholder="Masukkan Nomor Telepon Supplier" required="true" value="<?php if(isset($telp)) echo $telp?>">
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12 unit">
                                    <div class="input">
                                        <label class="icon-left" for="alamat">
                                            <i class="zmdi zmdi-home"></i>
                                        </label>
                                        <textarea class="form-control login-frm-input"  type="text" id="alamat" name="alamat" placeholder="Masukkan Alamat Lengkap Supplier" required="true"> <?php if(isset($alamat)) echo $alamat?></textarea> 
                                    </div>
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
                            <th>ID Supplier</th>
                            <th>Nama Supplier</th>
                            <th>No Telp</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th class="td-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            for ($i = 0; $row = $result->fetch(); $i++) {
                                echo "<tr>";
                                # kolom id karyawan
                                echo "<td>" . $row['id_supplier'] . "</td>";
                                # kolom nama karyawan
                                echo "<td>" . $row['nama_supplier'] . "</td>";
                                # kolom barcode barang
                                echo "<td>" . $row['no_telp'] . "</td>";
                                # kolom barcode barang
                                echo "<td>" . $row['email'] . "</td>";
                                # kolom barcode barang
                                echo "<td>" . $row['alamat'] . "</td>";
                                # kolom aksi
                                echo "<td class='td-center'>
                                <div class='btn-toolbar' role='toolbar'>
                                    <div class='btn-group' role='group'>
                                        <a href='edit.php?method=supplier&key=" . $row['id_supplier'] . "' class='btn btn-default btn-sm m-user-edit'><i class='zmdi zmdi-edit'></i></a>
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

<!-- Modal -->
<div class="modal fade" id="modalAddDept" role="dialog">
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
                        <label class="icon-left" for="nama_karyawan">
                            <i class="zmdi zmdi-account"></i>
                        </label>
                        <input class="form-control login-frm-input"  type="text" id="nama" name="nama" placeholder="Masukkan Nama Supplier" required="true">
                    </div>
                </div>
                <div class="unit">
                    <div class="input">
                        <label>
                            Departemen
                        </label>
                            
                        <label class="input select">
                            <select class="form-control" name="departemen" onchange="if (this.selectedIndex = 'add'){ 
                                    $('#modalAdd').modal('toggle');
                                    $('#modalAddDept').modal('toggle');
                                }
                            ";>
                                <option>-- Pilih departemen --</option>
                                <?php
                                for ($i = 0; $data = $departemen->fetch(); $i++) {
                                    echo "<option value = '" . $data['id_supplier'] . "'>" . $data['departemen'] . "</option>";
                                }
                                ?>
                                <option value="add" style="color:#ccc;">Tambah Departemen...</option>
                            </select>
                            <i></i>
                        </label>
                    </div>
                </div>
                <div class="unit">
                    <div class="input">
                        <label class="icon-left" for="email">
                            <i class="zmdi zmdi-email"></i>
                        </label>
                        <input class="form-control login-frm-input"  type="email" id="email" name="email" placeholder="Masukkan Email Supplier" required="true">
                    </div>
                </div>
                <div class="unit">
                    <div class="input">
                        <label class="icon-left" for="telp">
                            <i class="zmdi zmdi-phone"></i>
                        </label>
                        <input class="form-control login-frm-input"  type="text" id="telp" name="telp" placeholder="Masukkan Nomor Telepon Supplier" required="true">
                    </div>
                </div>
                <div class="unit">
                    <div class="input">
                        <label class="icon-left" for="alamat">
                            <i class="zmdi zmdi-home"></i>
                        </label>
                        <textarea class="form-control login-frm-input"  type="text" id="alamat" name="alamat" placeholder="Masukkan Alamat Lengkap Supplier" required="true"></textarea> 
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-1 control-label">Foto</label>
                    <div class="col-md-11">
                        <input type="file" class="filestyle bootstrap-file" data-buttonbefore="true">
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
</section>
<section class="main-container m-t-min-20"><?php include('../php/modular/footer.php') ?></section>
<!--Page Container End Here-->
<!--Rightbar Start Here-->
<aside class="rightbar">
<div class="rightbar-container">
<div class="aside-chat-box">
    <div class="coversation-toolbar">
        <div class="chat-back">
            <i class="zmdi zmdi-long-arrow-left"></i>
        </div>
        <div class="active-conversation">
            <div class="chat-avatar">
                <img src="../images/avatar/amarkdalen.jpg" alt="user">
            </div>
            <div class="chat-user-status">
                <ul>
                    <li>Feeling Blessed</li>
                    <li>Amarkdalen</li>
                </ul>
            </div>
        </div>
        <div class="conversation-action">
            <ul>
                <li><i class="zmdi zmdi-phone-in-talk"></i></li>
                <li class="dropdown">
                    <a href="#" class="btn-more dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="zmdi zmdi-attachment-alt"></i>Attach A File</a></li>
                        <li><a href="#"><i class="zmdi zmdi-mic"></i>Voice</a></li>
                        <li><a href="#"><i class="zmdi zmdi-block"></i>Block User</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="conversation-container">
        <div class="conversation-row even">
            <ul class="conversation-list">
                <li>
                    <p>
                        Hi! this is mike how can I help you?
                    </p>
                </li>
                <li>
                    <p>
                        Hello Sir!
                    </p>
                </li>
            </ul>
        </div>
        <div class="conversation-row odd">
            <ul class="conversation-list">
                <li>
                    <p>
                        Hi! Mike I need a support my account is suspended but I don't know why?
                    </p>
                </li>
            </ul>
        </div>
        <div class="conversation-row even">
            <ul class="conversation-list">
                <li>
                    <p>
                        Ok Sir! Let me check this issue please wait a min
                    </p>
                </li>
            </ul>
        </div>
        <div class="conversation-row odd">
            <ul class="conversation-list">
                <li>
                    <p>
                        Ok sure :)
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="chat-text-input">
        <input type="text" class="form-control">
    </div>
</div>
<ul class="nav nav-tabs material-tabs rightbar-tab" role="tablist">
    <li class="active"><a href="#chat" aria-controls="message" role="tab" data-toggle="tab">Chat</a></li>
    <li><a href="#activities" aria-controls="notifications" role="tab" data-toggle="tab">Activities</a></li>
</ul>
<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="chat">
    <div class="chat-user-toolbar clearfix">
        <div class="chat-user-search pull-left">
            <span class="addon-icon"><i class="zmdi zmdi-search"></i></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
        <div class="add-chat-list pull-right">
            <i class="zmdi zmdi-accounts-add"></i>
        </div>
    </div>
    <div class="chat-user-container">
        <h3 class="clearfix"><span class="pull-left">Members</span><span class="pull-right online-counter">3 Online</span></h3>
        <ul class="chat-user-list">
            <li>
                <div data-trigger="hover" title="Robertoortiz" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/robertoortiz.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Admin</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left"><span class="chat-avatar"><img src="../images/avatar/robertoortiz.jpg" alt="Avatar"></span><span class="chat-u-info">Adellecharles<cite>New York</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li class="chat-u-online">
                <div data-trigger="hover" title="Kurafire" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/kurafire.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left"><span class="chat-avatar"><img src="../images/avatar/kurafire.jpg" alt="Avatar"></span><span class="chat-u-info">Kurafire<cite>New York</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li class="chat-u-away">
                <div data-trigger="hover" title="Mikeluby" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/mikeluby.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/mikeluby.jpg" alt="Avatar"></span><span class="chat-u-info">Bobbyjkane<cite>London City</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li class="chat-u-busy">
                <div data-trigger="hover" title="Joostvanderree" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/joostvanderree.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/joostvanderree.jpg" alt="Avatar"></span><span class="chat-u-info">Joostvanderree<cite>New York</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
        </ul>
        <h3 class="clearfix"><span class="pull-left">Guests</span><span class="pull-right online-counter">1 Online</span></h3>
        <ul class="chat-user-list">
            <li>
                <div data-trigger="hover" title="Kevinthompson" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/Kevinthompson.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/kevinthompson.jpg" alt="Avatar"></span><span class="chat-u-info">Kevinthompson<cite>Scotland</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li class="chat-u-online">
                <div data-trigger="hover" title="Mds" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/mds.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/mds.jpg" alt="Avatar"></span><span class="chat-u-info">Mds<cite>South West, England</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li>
                <div data-trigger="hover" title="Mko" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/mko.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/mko.jpg" alt="Avatar"></span><span class="chat-u-info">Mko<cite>New York</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li>
                <div data-trigger="hover" title="Coreyweb" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/coreyweb.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/coreyweb.jpg" alt="Avatar"></span><span class="chat-u-info">Coreyweb<cite>Northern Ireland</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li>
                <div data-trigger="hover" title="Amarkdalen" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/amarkdalen.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/amarkdalen.jpg" alt="Avatar"></span><span class="chat-u-info">Oykun<cite>New York</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
        </ul>
    </div>
</div>
<div role="tabpanel" class="tab-pane" id="activities">
    <div class="activities-timeline">
        <h3 class="tab-pane-header">Recent Activities</h3>
        <ul class="activities-list">
            <li>
                <div class="activities-badge">
                    <span class="w_bg_amber"><i class="zmdi zmdi-ticket-star"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Resolved Tickets #LTK7865</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> 30 min ago
                    </div>
                </div>
            </li>
            <li>
                <div class="activities-badge">
                    <span class="w_bg_cyan"><i class="zmdi zmdi-file-plus"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Files Uploaded</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> 1 hour ago
                    </div>
                    <div class="activities-post">
                        <ul class="new-file-lists">
                            <li><a href="#"><i class="fa fa-file-text"></i> change-log.txt</a></li>
                            <li><a href="#"><i class="fa fa-file-audio-o"></i> skype-conversation.mp3</a></li>
                            <li><a href="#"><i class="fa fa-file-powerpoint-o"></i> presentation.ppt</a></li>
                            <li><a href="#"><i class="fa fa-file-video-o"></i> howtouse.avi</a></li>
                            <li><a href="#"><i class="fa fa-file-image-o"></i> screenshot.jpg</a></li>
                            <li><a href="#"><i class="fa fa-file-word-o"></i> nda.doc</a></li>
                            <li><a href="#"><i class="fa fa-file-pdf-o"></i> resume.pdf</a></li>
                            <li><a href="#"><i class="fa fa-file-archive-o"></i> all-files.zip</a></li>
                            <li><a href="#"><i class="fa fa-file-excel-o"></i> bill.xls</a></li>
                            <li><a href="#">+10</a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <div class="activities-badge">
                    <span class="w_bg_light_blue"><i class="zmdi zmdi-image"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Images Uploaded</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> July 22 at 1:12pm
                    </div>
                    <div class="activities-post">
                        <ul class="new-image-lists">
                            <li><a href="#"><img src="../images/img-1-thumb.jpg" alt="image"></a></li>
                            <li><a href="#"><img src="../images/img-2-thumb.jpg" alt="image"></a></li>
                            <li><a href="#"><img src="../images/img-3-thumb.jpg" alt="image"></a></li>
                            <li><a href="#" class="more-list"><i class="zmdi zmdi-more-horiz"></i></a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <div class="activities-badge">
                    <span class="w_bg_green"><i class="zmdi zmdi-accounts-alt"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Users Approved</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> July 22 at 1:12pm
                    </div>
                    <div class="activities-post">
                        <ul class="new-user-lists">
                            <li><a href="#"><img src="../images/avatar/oykun.jpg" alt="image"></a></li>
                            <li><a href="#"><img src="../images/avatar/mds.jpg" alt="image"></a></li>
                            <li><a href="#"><img src="../images/avatar/robertoortiz.jpg" alt="image"></a></li>
                            <li><a href="#" class="more-list"><i class="zmdi zmdi-more-horiz"></i></a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <div class="activities-badge">
                    <span class="w_bg_deep_purple"><i class="zmdi zmdi-file-text"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Post New Article</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> July 22 at 1:12pm
                    </div>
                    <div class="activities-post">
                        <ul class="new-post-lists">
                            <li><a href="#">Man in the Verde Valley</a></li>
                            <li><a href="#">Sinagua Pueblo Life</a></li>
                            <li><a href="#">Montezuma Well</a></li>
                            <li><a href="#">The Natural Scene</a></li>
                            <li><a href="#">+6</a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <div class="activities-badge">
                    <span class="w_bg_teal"><i class="zmdi zmdi-comments"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Comments Replied</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> July 22 at 1:12pm
                    </div>
                    <div class="activities-post">
                        <ul class="new-comments-lists">
                            <li><a href="#">As long as you are reasonably careful about where you step and avoid putting ...</a></li>
                            <li><a href="#">Montezuma Castle is 5 miles north of Camp Verde, 60 miles south...</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
</div>
</div>
</aside>
<!--Rightbar End Here-->
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