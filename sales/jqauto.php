<!doctype html>
  
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Demo Jquery UI autocomplete Candralab Coding Studio</title>
    <link rel="stylesheet" href="../css/jquery-ui.css" />
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>
 
    <script>
 
/*autocomplete muncul setelah user mengetikan minimal2 karakter */
    $(function() {  
        $( "#negara" ).autocomplete({
         source: "../php/modular/autocomplete.php?src=barcode_barang",  
            minLength:3, 
            autoFocus:true,
            select: function( event, ui ) {
              document.getElementById('tampilan').innerHTML += ui.item.value + "<br/>";
            },
        });
    });
    </script>
</head>
<body>
  
<div class="ui-widget">
    <label for="negara">Barang / Barcode: </label>
    <input id="negara" onkeypress="return cek_enter(event)" style="width:100%" />
</div>
<div id="tampilan"></div>
</body>
</html>