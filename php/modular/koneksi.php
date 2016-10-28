<?php
require_once 'config.php';
// koneksi ke database
$koneksi = mysqli_connect(db_server, db_user, db_pass, db_name);

$db = new PDO('mysql:host='.db_server.';dbname='.db_name, db_user, db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(mysqli_connect_errno()) {
	if($mode_debug == true){
		echo "<div class='row'>
			<div class='col-md-12'>
				<div class='j-forms'>
					<div class='form-content'>
						<div class='unit'> 
							<div class='error-message text-center'>
							Error Code: ";
							echo "Error Code: ";
							echo mysqli_connect_errno() . "<br />Failed to connect to database because " . mysqli_connect_error();
						echo "</div>
						</div>
					</div>
				</div>
			</div>
			</div>";
	} else {
		echo "<div class='row'>
			<div class='col-md-12'>
				<div class='j-forms'>
					<div class='form-content'>
						<div class='unit'> 
							<div class='error-message text-center'>
								<i class='fa fa-close'></i>Kesalahan koneksi, Harap hubungi administrator.
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>";
	}
	}