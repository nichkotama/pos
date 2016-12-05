<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');

if(isset($_POST['submit']) AND $_POST['barcode']){
    try{
    	$bcode=$_POST['barcode'];
        $result = $db->prepare("DELETE FROM barang WHERE barcode_barang = :bcode");
        $result->bindParam(':bcode', $bcode);
        $result->execute();
        header("Location:" . $url_web . "produk");
    }catch(Exception $e){
        if($mode_debug = true) echo $e->getMessage();
        echo "<div class='col-md-12'>
                <div class='j-forms'>
                    <div class='form-content'>
                        <div class='unit'> 
                            <div class='error-message text-center'>
                                <i class='fa fa-close'></i>Data terkait dengan transaksi, tidak bisa dihapus.
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
    }
}

?>