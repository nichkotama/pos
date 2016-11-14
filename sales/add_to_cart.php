<?php
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php'); 
try{
	$bcode = $_GET['whatever'];

	$query = $db->prepare("SELECT * FROM barang WHERE barcode_barang = '" . $_GET['whatever'] . "'");
	$query->execute();
	$data = $query->fetch();
	while ($row = $query->fetchAll(PDO::FETCH_ASSOC))
	{
		$data[] = $row;
	}
	echo json_encode($data);

}catch(Exception $e){
	echo $e->getMessage();
}
// $barcode = mysql_real_escape_string($_POST[]);
// echo $barcode;
?>