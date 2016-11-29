<?php
	require_once('koneksi.php');
	//connect to your database
	if(isset($_GET['src'])){
  	// mysql_connect(db_server,db_user,db_pass);
  	// mysql_select_db(db_name);
		switch ($_GET['src']) {
			case 'barcode_barang':
				$term = trim(strip_tags($_GET['term']));
				$qstring = "SELECT barcode_barang, nama_barang 
							FROM barang 
							WHERE jml_stok >= 1 AND nama_barang LIKE '%".$term."%'";
				$result = $db->prepare($qstring);
				$result->execute();
				while ($row = $result->fetch())
				{
				    $row['value']=htmlentities(stripslashes($row['nama_barang']));
				    $row['id']=(int)$row['barcode_barang'];
				    $row_set[] = $row;
				}
				echo json_encode($row_set);
				break;
			case 'nama_barang':
				$term = trim(strip_tags($_GET['term']));
				$supplier = '';
				if(isset($_GET['supplier'])) $supplier = trim(strip_tags($_GET['supplier']));
				$qstring = "SELECT barcode_barang, nama_barang, harga_beli 
							FROM barang 
							WHERE nama_barang LIKE '%".$term."%'
							OR barcode_barang LIKE '%".$term."%'";
				if($supplier != ''){
					$qstring .= "AND id_supplier = '$supplier'";
				}
				$result = $db->prepare($qstring);
				$result->execute();
				while ($row = $result->fetch())
				{
				    $row['value']=htmlentities(stripslashes($row['nama_barang'])) . " (Barcode:" . $row['barcode_barang'] . ")";
				    $row['id']=(int)$row['barcode_barang'];
				    $row['hbeli']=(int)$row['harga_beli'];
				    $row_set[] = $row;
				}
				echo json_encode($row_set);
				break;
			case 'supplier':
				$term = trim(strip_tags($_GET['term']));
				$qstring = "SELECT id_supplier, nama_supplier 
							FROM supplier 
							WHERE nama_supplier LIKE '%".$term."%'";
				$result = $db->prepare($qstring);
				$result->execute();
				while ($row = $result->fetch())
				{
				    $row['value']=htmlentities(stripslashes($row['nama_supplier']));
				    $row['id']=$row['id_supplier'];
				    $row_set[] = $row;
				}
				echo json_encode($row_set);
				break;
			case 'nomor_struk':
				$term = trim(strip_tags($_GET['term']));
				$qstring = "SELECT id_transaksi_header 
							FROM transaksi_kasir 
							WHERE id_transaksi_header LIKE '%".$term."%'";
				$result = $db->prepare($qstring);
				$result->execute();
				while ($row = $result->fetch())
				{
				    $row['value']=htmlentities(stripslashes($row['id_transaksi_header']));
				    $row['id']=(int)$row['id_transaksi_header'];
				    $row_set[] = $row;
				}
				echo json_encode($row_set);
			case 'nomor_po':
				$term = trim(strip_tags($_GET['term']));
				$qstring = "SELECT transaksi_pembelian.id_pembelian
							FROM transaksi_pembelian JOIN transaksi_pembelian_detail ON transaksi_pembelian.id_pembelian = transaksi_pembelian_detail.id_pembelian
							WHERE transaksi_pembelian_detail.tgl_diterima IS NOT NULL AND transaksi_pembelian.id_pembelian LIKE '%".$term."%'";
				$result = $db->prepare($qstring);
				$result->execute();
				while ($row = $result->fetch())
				{
				    $row['value']=htmlentities(stripslashes($row['id_pembelian']));
				    $row['id']=(int)$row['id_pembelian'];
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
	} else if(isset($_GET['method'])){
		try{
			if($_GET['method'] === 'id_supplier'){
				$query = $db->prepare("SELECT id_supplier FROM supplier ORDER BY id_supplier DESC LIMIT 1");
				$query->execute();
				$urutan = $query->fetch();
	        	$urutan_terakhir = explode("-", $urutan['id_supplier']);
	        	echo $urutan_terakhir[1];
	        }
		}catch(Exception $e){
    		if($mode_debug = true) echo $e->getMessage();
		}
	}
?>