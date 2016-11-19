<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');
$user 	= $_SESSION['uname'];
$nama	= $_POST['nama'];
$depart	= $_POST['departemen'];
$email 	= $_POST['email'];
$telp	= $_POST['telp'];
$alamat	= $_POST['alamat'];

$file_name = $_FILES['foto']['name'];
$file_tmp  = $_FILES['foto']['tmp_name'];
$file_size = $_FILES['foto']['size'];
$file_ext = strtolower(end(explode(".", $file_name)));
$ext_boleh = array("jpg", "png");
if(in_array($file_ext, $ext_boleh) || $_FILES['foto']['size'] == 0 ){
    if($file_size <= 2*1024*1024){
        if($_FILES['foto']['size'] != 0 ){
            $sumber = $file_tmp;
            echo $tujuan = "../images/karyawan/" . $nik . "." . $file_ext;
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
$sql1 = "UPDATE karyawan 
         SET nama_karyawan = '$nama', departemen = '$depart', email = '$email' , telp_karyawan = '$telp', alamat_karyawan = '$alamat', foto = '$tujuan'
		 WHERE id_karyawan = '$user'";
mysqli_query($koneksi, $sql1);
//header("location: index.php");
?>