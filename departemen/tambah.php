<?php
require_once('../php/modular/koneksi.php');
try{
	$a = $_POST['kode_awal'];
	$b = $_POST['nama_dept'];
	$c = ($_POST['prod_aktif'] == 'on' ? 1:0);
	$d = ($_POST['kary_aktif'] == 'on' ? 1:0);
	$e = ($_POST['pos_aktif'] == 'on' ? 1:0);
	$f = ($_POST['lap_aktif'] == 'on' ? 1:0);
	$sql = "INSERT INTO departemen (kode_awal,departemen,hak_akses_produk,hak_akses_karyawan,hak_akses_pos,hak_akses_laporan) 
	VALUES (:a,:b,:c,:d,:e,:f)";
	$q = $db->prepare($sql);
	$q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d,':e'=>$e,':f'=>$f));
	header("location: index.php");
}catch(Exception $e){
    if($mode_debug = true) echo $e->getMessage();
}
?>