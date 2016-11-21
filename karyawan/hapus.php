<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');

if(isset($_POST['submit']) AND $_POST['nik']){
    $nik=$_POST['nik'];

    $result = $db->prepare("SELECT * FROM karyawan WHERE id_karyawan = :nik");
    $result->bindParam(':nik', $nik);
    $result->execute();
    $result_toDelete = $result->fetch();
    chmod($url_web."images/karyawan/".$result_toDelete['foto'],0777); //Change the file permissions if allowed
    unlink($url_web."images/karyawan/".$result_toDelete['foto']);

    $result = $db->prepare("DELETE FROM karyawan WHERE id_karyawan = :nik");
    $result->bindParam(':nik', $nik);
    $result->execute();

    header("Location:" . $url_web . "karyawan");
}

?>