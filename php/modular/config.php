<?php
	// general
	$url_web = 'http://belajar.abc/tugas_bps/';
  	$judul = 'BM Mart POS';
  	$author = 'Kelompok 2';
  	$mode_debug = true;
  	
  	// database
  	define('db_server', 'localhost'); // Server database, default : localhost
  	define('db_user', 'root'); // Nama user database
  	define('db_pass', 'nicholaskotama'); // Password user database
  	define('db_name', 'supermarket'); // Nama database

  	// enkripsi
  	define('format', '$2y$10$');
	define('hash', 'Kelompok2SuPERmarketIT');
	define('salt', format . hash);
?>
