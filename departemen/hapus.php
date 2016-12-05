
<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');

if(isset($_POST['submit']) AND $_POST['kode_awal']){
    $kode=$_POST['kode_awal'];
    $result = $db->prepare("DELETE FROM departemen WHERE kode_awal = :kode");
    $result->bindParam(':kode', $kode);
    $result->execute();
    header("Location:" . $url_web . "departemen");
}
?>