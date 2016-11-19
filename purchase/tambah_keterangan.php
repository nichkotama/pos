<?php
require_once('../php/modular/koneksi.php');
try{
	$a = $_POST['keterangan'];
	$sql = "UPDATE transaksi_pembelian_detail SET keterangan=:a WHERE id";
	$q = $db->prepare($sql);
	$q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d,':e'=>$e));
	header("location: index.php");
}catch(Exception $e){
	if($mode_debug == true){
		$e->getMessage();
	}
}
?>