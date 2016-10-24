<?php 
require_once('php/modular/koneksi.php'); 
try{
	if(isset($_POST['submit'])){
	    //username and password sent from Form
	    $username = trim($_POST['login']);
	    $password = trim($_POST['password']);
	$result = $conn->prepare("SELECT * FROM karyawan WHERE id_karyawan= :hjhjhjh AND password= :asas");
	$result->bindParam(':hjhjhjh', $username);
	$result->bindParam(':asas', $password);
	$result->execute();
	$rows = $result->fetch(PDO::FETCH_NUM);
	if($rows > 0) {
	header("location: index.php");
	}
	else{
		$errmsg_arr[] = 'Username and Password are not found';
		$errflag = true;
	}
	}
} catch(Exception $e){
	echo $e->getMessage()
}

// session_start();
// if($_SERVER["REQUEST_METHOD"] == "POST")
// {
// $admin = $db->prepare('SELECT * FROM karyawan WHERE id_karyawan = :login and password = :password');
// $admin->execute(array(
//                   ':login' => $_POST['login'],
//                   ':passcode' => $_POST['password']
//                   ));
// $row = $admin->fetch(PDO::FETCH_ASSOC);
 
// if(empty($row['id_karyawan'])){

// echo "Your Login Name or Password is invalid";

// }else {

// $_SESSION['login_user'] = $_POST['login'];

// header("location: index.php");
// }
// }