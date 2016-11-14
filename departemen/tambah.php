<?php
require_once('../php/modular/koneksi.php');
try{
	$a = $_POST['kode_awal'];
	$b = $_POST['nama_dept'];
	$sql = "INSERT INTO departemen (kode_awal,departemen) 
	VALUES (:a,:b)";
	$q = $db->prepare($sql);
	$q->execute(array(':a'=>$a,':b'=>$b));
	header("location: index.php");
}catch(Exception $e){
	if($mode_debug == true){
		$e->getMessage();
	}
}
?>