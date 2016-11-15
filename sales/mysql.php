<?php

//CREDENTIALS FOR DB
define ('DBSERVER', 'localhost');
define ('DBUSER', 'root');
define ('DBPASS','nicholaskotama');
define ('DBNAME','supermarket');

//LET'S INITIATE CONNECT TO DB
$connection = mysql_connect(DBSERVER, DBUSER, DBPASS) or die("Can't connect to server. Please check credentials and try again");
$result = mysql_select_db(DBNAME) or die("Can't select database. Please check DB name and try again");

//CREATE QUERY TO DB AND PUT RECEIVED DATA INTO ASSOCIATIVE ARRAY
if (isset($_REQUEST['query'])) {
    $query = $_REQUEST['query'];
    $sql = mysql_query ("SELECT barcode_barang, nama_barang FROM barang WHERE barcode_barang LIKE '%{$query}%' OR nama_barang LIKE '%{$query}%' LIMIT 1000");
	$array = array();
    while ($row = mysql_fetch_array($sql)) {
        $array[] = array (
            'label' => $row['barcode_barang'].', '.$row['nama_barang'],
            'value' => $row['barcode_barang'],
        );
    }
    //RETURN JSON ARRAY
    echo json_encode ($array);
}

?>