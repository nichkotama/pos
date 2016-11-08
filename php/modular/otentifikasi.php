<?php
session_start();
if(!isset($_SESSION['login']) OR $_SESSION['login'] != 1) header("Location:" . $url_web . "login_user.php");