<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');

if(isset($_POST['submit']) AND $_POST['id_pembelian']){
    $id_beli=$_POST['id_pembelian'];
    $result = $db->prepare("DELETE a.*, b.* FROM transaksi_pembelian a, transaksi_pembelian_detail b WHERE a.id_pembelian = :id_beli AND b.id_pembelian = :id_beli");
    $result->bindParam(':id_beli', $id_beli);
    $result->execute();
    header("Location:" . $url_web . "purchase/list_po.php");
}

?>