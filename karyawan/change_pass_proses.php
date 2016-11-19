<?php
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');
	$user = $_SESSION['uname'];
    $old_pass = $_POST['pass_lama'];
    $encrypted_pass = crypt($old_pass, salt);
	$new_pass = $_POST['pass_baru'];
	$conf_pass = $_POST['konf_pass'];
        
	$sql = "SELECT * FROM karyawan WHERE id_karyawan = '$user'";
	$hasil = mysqli_query($koneksi, $sql);

	if(mysqli_num_rows($hasil)){
		$b = mysqli_fetch_array($hasil);
		if($encrypted_pass == $b['password']){
			if($new_pass != $conf_pass){
				echo "<script type='text/javascript'>alert('Password Baru dan Konfirmasi Password tidak sama')</script>";
				echo "<script type='text/javascript'>window.location = 'change_pass.php'</script>";
				}else{
				$encrypted_new_pass = crypt($conf_pass, salt);
				$sql_update = "UPDATE karyawan SET password = '$encrypted_new_pass' WHERE id_karyawan = '$user'";
				mysqli_query($koneksi, $sql_update);
				echo "<script type='text/javascript'>alert('Change Password Success')</script>";
				echo "<script type='text/javascript'>window.location = 'change_pass.php'</script>";
			}
		}else{
			echo "<script type='text/javascript'>alert('Password Lama yang Anda masukkan salah')</script>";
			echo "<script type='text/javascript'>window.location = 'change_pass.php'</script>";
		}
	}else{
		echo "<script type='text/javascript'>alert('Data tidak valid')</script>";
		echo "<script type='text/javascript'>window.location = 'change_pass.php'</script>";
	}
?>