<?php
	require_once('koneksi.php');
	//connect to your database
	if(isset($_GET['src'])){
  	mysql_connect(db_server,db_user,db_pass);
  	mysql_select_db(db_name);
		switch ($_GET['src']) {
			case 'barcode_barang':
				$term = trim(strip_tags($_GET['term']));
				$qstring = "SELECT barcode_barang, nama_barang 
							FROM barang 
							WHERE nama_barang LIKE '%".$term."%' OR barcode_barang LIKE '".$term."%'";
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
	} else if(isset($_GET['kode_awal'])){
		try{
			$query = $db->prepare("SELECT id_karyawan FROM karyawan WHERE id_karyawan LIKE '" . $_GET['kode_awal'] . "%' ORDER BY id_karyawan DESC LIMIT 1");
			$query->execute();
			$urutan = $query->fetch();
        	$urutan_terakhir = explode("-", $urutan['id_karyawan']);
        	echo $urutan_terakhir[1];
		}catch(Exception $e){
    		if($mode_debug = true) echo $e->getMessage();
		}
	}
?>