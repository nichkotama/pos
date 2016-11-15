<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');

if(isset($_POST['submit']) AND $_POST['id_supplier']){
    $id_supplier=$_POST['id_supplier'];
    $result = $db->prepare("DELETE FROM supplier WHERE id_supplier = :id_supplier");
    $result->bindParam(':id_supplier', $id_supplier);
    $result->execute();
    header("Location:" . $url_web . "supplier");
}

?>