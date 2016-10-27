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

  // nama hari bahasa indonesia
  $hari_ke = date('D');
  $bulan_ke = date('M');
  $daftar_hari = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
  );
  $daftar_bulan = array(
    'Jan' => 'Januari',
    'Feb' => 'Februari',
    'Mar' => 'Maret',
    'Apr' => 'April',
    'May' => 'Mei',
    'Jun' => 'Juni',
    'Jul' => 'Juli',
    'Aug' => 'Agustus',
    'Sep' => 'Septermber',
    'Oct' => 'Oktober',
    'Nov' => 'November',
    'Dec' => 'Desember',
  );
  $hari_indo = $daftar_hari[$hari_ke];
  $bln_indo = $daftar_bulan[$bulan_ke];
  $hari_ini = $hari_indo . ", " . date('d') . " " . $bln_indo . " " . date('Y');
?>
