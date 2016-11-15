<?php
	require_once('../php/modular/config.php');
	//connect to your database
  	mysql_connect($db_server,$db_user,$db_pass);
  	mysql_select_db($db_name);
	//harus selalu gunakan variabel term saat memakai autocomplete,
	//jika variable term tidak bisa, gunakan variabel q
	$term = trim(strip_tags($_GET['term']));
	$qstring = "SELECT barcode_barang, nama_barang FROM barang WHERE nama_barang LIKE '%".$term."%' OR barcode_barang LIKE '".$term."%'";
	$result = mysql_query($qstring);
	while ($row = mysql_fetch_array($result))
	{
	    $row['value']=htmlentities(stripslashes($row['nama_barang']));
	    $row['id']=(int)$row['barcode_barang'];
	    $row_set[] = $row;
	}
	echo json_encode($row_set);
?>