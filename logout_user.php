<?php
	include('php/modular/config.php');
	session_start();
	$_SESSION['login'] = null;
	$_SESSION['pesan'] = null;
	// session_destroy();
	header('Location:' . $url_web . 'login_user.php');
