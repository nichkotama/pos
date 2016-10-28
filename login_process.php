<?php 
require_once('php/modular/koneksi.php'); 
try{
	if(isset($_POST['submit'])){
	    //username and password sent from Form
	    $username = trim($_POST['login']);
	    $password = trim($_POST['password']);
		$result = $db->prepare("SELECT * FROM karyawan WHERE id_karyawan BINARY = :user AND password= :pass");
		$result->bindParam(':user', $username);
		$result->bindParam(':pass', $password);
		$result->execute();
		$rows = $result->fetch(PDO::FETCH_NUM);
		if($rows > 0){
			header("location: index.php");
		}
	}
} catch(Exception $e){
	// echo $e->getMessage()
}
