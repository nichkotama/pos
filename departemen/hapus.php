<<<<<<< HEAD
<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');

if(isset($_POST['submit']) AND $_POST['barcode']){
    $bcode=$_POST['barcode'];
    $result = $db->prepare("DELETE FROM barang WHERE barcode_barang = :bcode");
    $result->bindParam(':bcode', $bcode);
    $result->execute();
    header("Location:" . $url_web . "produk");
}

=======
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

>>>>>>> a293c51b7049a60ade0d34591f27b614df3f6b0e
?>