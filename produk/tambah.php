<?php
require_once('../php/modular/koneksi.php');
try{
	$a = $_POST['barcode'];
	$b = $_POST['nama'];
	$c = (float)$_POST['hargabeli'];
	$d = (float)$_POST['hargajual'];
	$e = (int)$_POST['banyak'];
	$f = $_POST['id_supplier'];
	$sql = "INSERT INTO barang (barcode_barang,nama_barang,harga_beli,harga_jual,jml_stok,id_supplier) 
	VALUES (:a,:b,:c,:d,:e,:f)";
	$q = $db->prepare($sql);
	$q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d,':e'=>$e,':f'=>$f));
	header("location: index.php");
}catch(Exception $e){
	if($mode_debug == true){
		$e->getMessage();
	}
}
?>