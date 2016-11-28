<?php
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 
try{
	$bcode = $_GET['whatever'];
	$metode = $_GET['string']; //number = true; string = false; buat detect dia input nama apa barcode
	if($metode == "false"){
		$query = $db->prepare("SELECT * FROM barang WHERE nama_barang = '" . $bcode . "'");
	}else{
		$query = $db->prepare("SELECT * FROM barang WHERE barcode_barang = '" . $bcode . "'");
	}
	$query->execute();
	$data = $query->fetch();
	// while ($row = $query->fetchAll(PDO::FETCH_ASSOC))
	// {
	// 	$data[] = $row;
	// }
	echo json_encode($data);
}catch(Exception $e){
	echo $e->getMessage();
}
// $barcode = mysql_real_escape_string($_POST[]);
// echo $barcode;
?>