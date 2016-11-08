<?php 
require_once('php/modular/koneksi.php'); 
if(isset($_POST['submit'])){
    session_start();
    $user = $_POST['login'];
    $pass = $_POST['password'];
    $newpass    = crypt($pass, salt);

    $sql = "SELECT id_karyawan, password 
            FROM karyawan 
            WHERE id_karyawan LIKE binary '$user' AND password = '$newpass'";
    
    $hasil = mysqli_query($koneksi, $sql);
    $baris = mysqli_fetch_assoc($hasil);
    if(mysqli_num_rows($hasil) == 0){
        echo "<div class='row'>
            <div class='col-md-12'>
                <div class='j-forms'>
                    <div class='form-content'>
                        <div class='unit'> 
                            <div class='error-message text-center'>
                                <i class='fa fa-close'></i>ID Karyawan atau Password salah.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>";
    } else{
        $_SESSION['login'] = 1;
        $_SESSION['uname'] = $user;
        header("Location: index.php");
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Login - <?php echo $judul ?></title>
    <link type="text/css" rel="stylesheet" href="css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="css/material-design-iconic-font.css">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="css/animate.css">
    <link type="text/css" rel="stylesheet" href="css/layout.css">
    <link type="text/css" rel="stylesheet" href="css/components.css">
    <link type="text/css" rel="stylesheet" href="css/widgets.css">
    <link type="text/css" rel="stylesheet" href="css/plugins.css">
    <link type="text/css" rel="stylesheet" href="css/pages.css">
    <link type="text/css" rel="stylesheet" href="css/bootstrap-extend.css">
    <link type="text/css" rel="stylesheet" href="css/common.css">
    <link type="text/css" rel="stylesheet" href="css/responsive.css">
    
</head>
<body class="login-page">

<script type="text/javascript">
    window.onload = function() {
        var SetFokus = $('#login');
        SetFokus.val(SetFokus.val());
        var strLength= SetFokus.val().length;
        SetFokus.focus();
        SetFokus[0].setSelectionRange(strLength, strLength);
    }
</script>

<!--Page Container Start Here-->
<section class="login-container boxed-login">
<div class="container">
<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
<div class="login-form-container">
    <form action="login_user.php" method="post" class="j-forms">

        <div class="login-form-header">
            <div class="logo">
                <a href="index.html" title="Homepage"><img src="images/logo-dark.png" alt="logo" style="max-width:150px"></a>
            </div>
        </div>
        <div class="login-form-content">



            <!-- start login -->
            <div class="unit">
                <div class="input login-input">
                    <label class="icon-left" for="login">
                        <i class="zmdi zmdi-account"></i>
                    </label>
                    <input class="form-control login-frm-input"  type="text" id="login" name="login" placeholder="Masukkan ID Karyawan" value="<?php echo $user?>">
                </div>
            </div>
            <!-- end login -->

            <!-- start password -->
            <div class="unit">
                <div class="input login-input">
                    <label class="icon-left" for="password">
                        <i class="zmdi zmdi-key"></i>
                    </label>
                    <input class="form-control login-frm-input"  type="password" id="password" name="password" placeholder="Masukkan Password">
						<!-- <span class="hint">
							<a href="#" class="link">Forgot password?</a>
						</span> -->
                </div>
            </div>
            <!-- end password -->


            <!-- start keep logged --
            <div class="unit">
                <label class="checkbox">
                    <input type="checkbox" name="logged" value="true" checked="">
                    <i></i>
                    Keep me logged in
                </label>
            </div>
            !-- end keep logged -->

        </div>
        <div class="login-form-footer">
            <button type="submit" class="btn-block btn btn-primary" name="submit" value="Submit">Sign in</button>
        </div>

    </form>
</div>
</div>
</div>
<!--Footer Start Here -->
<footer class="login-page-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
                <div class="footer-content">
                    <span class="footer-meta"><?php echo $judul . " created by " . $author ?></span>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--Footer End Here -->
</section>
<!--Page Container End Here-->
<script src="js/lib/jquery.js"></script>
<script src="js/lib/jquery-migrate.js"></script>
<script src="js/lib/bootstrap.js"></script>
<script src="js/lib/jRespond.js"></script>
<script src="js/lib/hammerjs.js"></script>
<script src="js/lib/jquery.hammer.js"></script>
<script src="js/lib/smoothscroll.js"></script>
<script src="js/lib/smart-resize.js"></script>

<script src="js/lib/jquery.validate.js"></script>
<script src="js/lib/jquery.form.js"></script>
<script src="js/lib/j-forms.js"></script>
<script src="js/lib/login-validation.js"></script>
</body>
</html>