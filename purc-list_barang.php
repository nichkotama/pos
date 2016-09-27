<?php require_once('php/modular/config.php') ?> 
<!doctype html> 
<html> 
<head> 
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"> 
    <title><?php echo $judul ?> - Homepage</title> 
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
    <link type="text/css" rel="stylesheet" href="css/custom.css"> 
    <link type="text/css" id="themes" rel="stylesheet" href=""> 
</head> 
 
<body class="overlay-leftbar"> 
 
<?php include('php/modular/top-menu.php') ?> 
<?php include('php/modular/side-menu.php') ?> 
 
<!--Page Container Start Here--> 
<section class="main-container"> 
<div class="container"> 
    <div class="page-header filled light"> 
    <div class="row"> 
        <div class="col-md-6"> 
            <h2>Data Barang Yang Perlu Dipesan</h2> 
            <p>Hari.......</p> 
        </div> 
        <div class="col-md-6"> 
            <ul class="list-page-breadcrumb"> 
                <li><a href="#">Home <i class="zmdi zmdi-chevron-right"></i></a></li> 
                <li><a href="#">Layout <i class="zmdi zmdi-chevron-right"></i></a></li> 
                <li class="active-page"> Data Tables</li> 
            </ul> 
        </div> 
    </div> 
</div> 
 
<div class="row"> 
    <div class="col-md-12"> 
        <div class="widget-wrap"> 
            <div class="widget-header block-header clearfix"> 
                <h3>Data Barang</h3> 
                 
            </div> 
            <div class="widget-container"> 
                <div class="widget-content"> 
                    <table class="table data-tbl"> 
                    <thead> 
                    <tr> 
                        <th> 
                            Kode barang 
                        </th> 
                        <th> 
                            Nama Barang 
                        </th> 
                        <th> 
                            Jumlah Stock 
                        </th> 
                        <th> 
                            Nama Supplier 
                        </th> 
                        <th> 
                            Harga Beli 
nocapt