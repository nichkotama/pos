<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');

if(isset($_POST['submit']) AND $_POST['nik']){
    $nik=$_POST['nik'];
    $result = $db->prepare("DELETE FROM karyawan WHERE id_karyawan = :nik");
    $result->bindParam(':nik', $nik);
    $result->execute();
    header("Location:" . $url_web . "karyawan");
}

?>