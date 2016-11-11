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

?>