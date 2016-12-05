<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');

try{
    $user     = $_SESSION['uname'];
    $nik     = $_POST['nik'];
    $nama    = $_POST['nama'];
    $depart    = $_POST['departemen'];
    $email     = $_POST['email'];
    $telp    = str_replace("-","",$_POST['telp']);
    $alamat    = $_POST['alamat'];
    //$foto     = $_FILES['fotoedit'];

    //$sumber = $foto['tmp_name'];
    //$tujuan = '../images/karyawan/' . $foto['name'];
    //move_uploaded_file($sumber, $tujuan);
    //echo $sql1 = "UPDATE karyawan 
           //  SET nama_karyawan = '$nama', departemen = '$depart', email = '$email' , telp_karyawan = '$telp', alamat_karyawan = '$alamat', foto = '$tujuan'
            // WHERE id_karyawan = '$user'";
    //mysqli_query($koneksi, $sql1);
    //header("location: index.php");

    $file_name = $_FILES['foto2']['name'];
    $file_tmp  = $_FILES['foto2']['tmp_name'];
    $file_size = $_FILES['foto2']['size'];
    $file_ext = strtolower(end(explode(".", $file_name)));
    $ext_boleh = array("jpg", "png");
    if(in_array($file_ext, $ext_boleh) || $file_size > 0 ){
        if($file_size <= 2*1024*1024 AND $file_size > 0)
        {
            if($_FILES['foto2']['size'] != 0 ){
                $sumber = $file_tmp;
                $tujuan = "../images/karyawan/" . $nik . "." . $file_ext;
                // die("sumber: " . $sumber . ", tujuan: " . $tujuan);
                // unlink($tujuan);
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
    $sql1 = "UPDATE karyawan SET nama_karyawan = '$nama', departemen = '$depart', email = '$email' , telp_karyawan = '$telp', alamat_karyawan = '$alamat' ";
    if($file_size > 0) $sql1 .= ", foto = '" . $nik . "." . $file_ext . "' ";
    $sql1 .= "WHERE id_karyawan = '$nik'";

    $do_update_karyawan = $db->prepare($sql1);
    $do_update_karyawan->execute();

    sleep(3);
    header("location: index.php");
}catch(Exception $e){
    if($mode_debug = true) echo $e->getMessage();
}
?>