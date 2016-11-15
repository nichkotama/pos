<?php
require_once('../php/modular/koneksi.php');
try{
	$a = $_POST['barcode'];
	$b = $_POST['nama'];
	$c = (float)$_POST['hargabeli'];
	$d = (float)$_POST['hargajual'];
	$e = (int)$_POST['banyak'];
	$sql = "INSERT INTO barang (barcode_barang,nama_barang,harga_beli,harga_jual,jml_stok) 
	VALUES (:a,:b,:c,:d,:e)";
	$q = $db->prepare($sql);
	$q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d,':e'=>$e));
	header("location: index.php");
}catch(Exception $e){
	if($mode_debug == true){
		$e->getMessage();
	}
}
?>