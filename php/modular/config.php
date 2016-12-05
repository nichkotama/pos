<?php
	// general
  $url_web = 'http://belajar.abc/tugas_bps/';
	$judul = 'BM Mart POS';
	$author = 'Kelompok 2';
  // NOTE : MODE DEBUG UNTUK MENAMPILKAN ERROR, ~FALSE~ KETIKA INGIN DIPUBLISH
	$mode_debug = false;
  // WARNING : Hardcore showing error below !!! 
  // if($mode_debug = true){
  //   error_reporting(E_ALL);
  //   ini_set('display_errors', '1');
  // }
	// END OF MODE DEBUG CONFIGURATION
   
  setlocale(LC_MONETARY, 'id_ID'); 
  
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
  $array_bulan = array(
    1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII"
  );
    
  $bulan_romawi = $array_bulan[date('n')];
  $hari_indo = $daftar_hari[$hari_ke];
  $bln_indo = $daftar_bulan[$bulan_ke];
  $hari_ini = $hari_indo . ", " . date('d') . " " . $bln_indo . " " . date('Y');
?>
