<?php
require_once('../php/modular/koneksi.php');
try{
	$a = $_POST['nama'];
	$b = $_POST['email'];
	$c = $_POST['telp'];
	$d = $_POST['alamat'];
	$e = $_POST['password'];
	$f = $_POST['departemen'];
	// $dept = $db->prepare("SELECT departemen FROM departemen WHERE kode_awal = '" . $f . "'");
	// $dept->execute();
	// $res = $dept->fetch();
	$sql = "INSERT INTO karyawan (nama_karyawan,email,telp_karyawan,alamat_karyawan,password,id_karyawan,departemen) 
	VALUES (:a,:b,:c,:d,:e,:f,:g)";
	$q = $db->prepare($sql);
	$q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d,':e'=>$e,':f'=>$f,':g'=>$f));
	header("location: index.php");
}catch(Exception $e){
    if($mode_debug = true) echo $e->getMessage();
}
?>