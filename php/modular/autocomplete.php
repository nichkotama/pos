<?php
	require_once('config.php');
	//connect to your database
  	mysql_connect($db_server,$db_user,$db_pass);
  	mysql_select_db($db_name);
	if(isset($_GET['src'])){
		switch ($_GET['src']) {
			case 'barcode_barang':
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
				break;
			
			default:
				# do nothing
				break;
		}
	}
?>