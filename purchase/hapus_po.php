<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');
try{
	if(isset($_POST['hapus_po']) AND $_POST['nomor_po_hapus']){
	    $id_beli=$_POST['nomor_po_hapus'];
	    // echo $id_beli;
	    
	    $result = $db->prepare("DELETE FROM transaksi_pembelian_detail WHERE id_pembelian = :id_beli");
	    $result->bindParam(':id_beli', $id_beli);
	    $result->execute();

	    $result = $db->prepare("DELETE FROM transaksi_pembelian WHERE id_pembelian = :id_beli");
	    $result->bindParam(':id_beli', $id_beli);
	    $result->execute();
	    header("Location:" . $url_web . "purchase/list_po.php");
	}
}catch(Exception $e) {
    if($mode_debug = true) echo $e->getMessage();
}
?>