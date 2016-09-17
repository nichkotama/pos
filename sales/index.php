<?php require_once('../php/modular/config.php') ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $judul ?> - Homepage</title>
    <link type="text/css" rel="stylesheet" href="../css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="../css/material-design-iconic-font.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../css/animate.css">
    <link type="text/css" rel="stylesheet" href="../css/layout.css">
    <link type="text/css" rel="stylesheet" href="../css/components.css">
    <link type="text/css" rel="stylesheet" href="../css/widgets.css">
    <link type="text/css" rel="stylesheet" href="../css/plugins.css">
    <link type="text/css" rel="stylesheet" href="../css/pages.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap-extend.css">
    <link type="text/css" rel="stylesheet" href="../css/common.css">
    <link type="text/css" rel="stylesheet" href="../css/responsive.css">
    <link type="text/css" rel="stylesheet" href="../css/custom.css">
    <link type="text/css" id="themes" rel="stylesheet" href="">
</head>

<body class="overlay-leftbar">
<script type="text/javascript">
    var number = 1;
    var items = '';
    var qty = 1;
    var value = '';
    window.onload = function() {
        var input = document.getElementById("barcode").focus();
    }

    function myFunction(src, value) {
        var table = document.getElementById("myTable");
        if( src == 'barcode' ){
            items = value;
            qty = 1;
        }else if( src == 'qty' ){
            qty = value;
        }
        table.innerHTML = table.innerHTML 
            + '<div class="col-sm-1"><button class="btn btn-danger"><i class="zmdi zmdi-close"></i></button></div>' 
            + '<div class="col-sm-1 p-tb-9">' + number + '</div>' 
            + '<div class="col-sm-3 p-tb-9">' + items +'</div>' 
            + '<div class="col-sm-1"><input class="form-control" type="number" value="' + qty +'"/></div>' 
            + '<div class="col-sm-3"><input class="form-control" type="number" value="' + qty +'" readonly=""/></div>' 
            + '<div class="col-sm-3"><input class="form-control" type="number" value="' + qty +'" readonly=""/></div>' 
        number++;

        document.getElementById("barcode").value = '';
        document.getElementById("qty").value = 1;
        document.getElementById("barcode").focus();
        // var row = table.insertRow(1);
        // var cell1 = row.insertCell(0);
        // var cell2 = row.insertCell(1);
        // cell1.innerHTML = "NEW CELL1";
        // cell2.innerHTML = "NEW CELL2";
    }
    function cek_enter(e, src) {
    if (e.keyCode == 13) {
        if( src == 'barcode' ){
            value = document.getElementById('barcode').value;
            if (value == "") value = "item tidak diinput";
        }else if( src == 'qty' ){
            value = document.getElementById('qty').value;
        }
        return myFunction(src, value);
        // var field_barcode = document.getElementById('barcode');
        // var field_qty = document.getElementById('qty');
        // field_barcode.innerHTML = "";
        // field_qty.innerHTML = "";
    }
}
</script>
<?php include('../php/modular/top-menu.php') ?>
<?php include('../php/modular/side-menu.php') ?>

<!--Page Container Start Here-->
<section class="main-container">
<div class="container-fluid">
<div class="page-header filled light">
    <div class="row widget-header block-header">
        <div class="col-sm-6">
            <h2>Sales</h2>
            <p>Penjualan Hari Rabu, 14-Sep-2016</p>
        </div>
        <div class="col-sm-6">
            <ul class="list-page-breadcrumb">
                <li><a href="#">Sales <i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="active-page"> Session</li>
            </ul>
        </div>
        <div class="col-sm-12 m-t-20">
            <button class="btn btn-success active col-sm-6"><i class="zmdi zmdi-keyboard"> Keyboard Mode</i></button>
            <button class="btn btn-success col-sm-6"><i class="zmdi zmdi-image"> Mouse Mode</i></button>
        </div>
    </div>

        <div class="row">
            <div class="col-md-12">
                    <div class="widget-container">
                        <div class="widget-content">
                            <!-- <form action="#" method="post" class="j-forms" id="order-forms-quantity" novalidate> -->
                            <div class="j-forms" id="order-forms-quantity" novalidate>

                                <div class="form-group">
                                    <!-- start name -->
                                    <div class="col-sm-7 unit">
                                        <div class="input">
                                            <label class="icon-left" for="name">
                                                <i class="fa fa-barcode"></i>
                                            </label>
                                            <input class="form-control" type="text" id="barcode" name="barcode" placeholder="Scan Barcode or Type Item Here" onkeypress="return cek_enter(event, 'barcode')">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 unit">
                                        <div class="input">
                                            <label class="icon-left" for="name">
                                                <i class="zmdi zmdi-shopping-basket"></i>
                                            </label>
                                            <input class="form-control" type="number" id="qty" placeholder="Qty" value=1 min=1 onkeypress="return cek_enter(event, 'qty')"> 
                                        </div>
                                    </div>
                                    <div class="col-sm-2 unit">
                                        <div class="input">
                                            <button type="submit" class="btn btn-success" onclick="myFunction()"><i class="zmdi zmdi-plus"> Add Item</i></button>
                                        </div>
                                    </div>
                                </div>
                                    <!-- end name -->
                                    <!-- <div class="row fruits-calculation">
                                        <div class="col-md-12 unit">
                                            <table id="myTable">
                                                <th class="col-md-1">#</th>
                                                <th class="col-md-3">Item</th>
                                                <th class="col-md-2">Qty</th>
                                                <th class="col-md-3">Harga Satuan</th>
                                                <th class="col-md-3">Sub-Total</th>
                                            </table>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        <div class="col-sm-12" id="myTable">
                                            <div class="col-sm-1 heading-tabel">Remove</div>
                                            <div class="col-sm-1 heading-tabel">#</div>
                                            <div class="col-sm-3 heading-tabel">Item</div>
                                            <div class="col-sm-1 heading-tabel">Qty</div>
                                            <div class="col-sm-3 heading-tabel">Harga Satuan</div>
                                            <div class="col-sm-3 heading-tabel">Sub-Total</div>
                                        </div>
                                    </div>
                                    <!-- start  fruit coconut -->
                                    <!-- <div class="row fruits-calculation">
                                        <div class="col-md-5 unit">
                                            <label class="label">Available fruits</label>
                                            <div class="input">
                                                <input class="form-control" type="text" id="first_field" value="Coconut" readonly="" name="first_field">
                                            </div>
                                        </div>
                                        <div class="col-md-3 unit">
                                            <label class="label">Quantity</label>
                                            <div class="input quantity-events">
                                                <input class="form-control" type="text" id="first_field_quantity" name="first_field_quantity">
                                            </div>
                                        </div>
                                        <div class="col-md-2 unit">
                                            <label class="label">Price</label>
                                            <div class="input">
                                                <input class="form-control" type="text" id="first_field_price" value="$ 1.30" readonly="" name="first_field_price">
                                            </div>
                                        </div>
                                        <div class="col-md-2 unit">
                                            <label class="label">Total</label>
                                            <div class="input">
                                                <input class="form-control" type="text" id="first_field_total" readonly="" name="first_field_total">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end fruit coconut -->

                                    <!-- start fruit watermelon --
                                    <div class="row fruits-calculation">
                                        <div class="col-md-5 unit">
                                            <div class="input">
                                                <input class="form-control" type="text" id="second_field" value="Watermelon" readonly="" name="second_field">
                                            </div>
                                        </div>
                                        <div class="col-md-3 unit">
                                            <div class="input quantity-events">
                                                <input class="form-control" type="text" id="second_field_quantity" name="second_field_quantity">
                                            </div>
                                        </div>
                                        <div class="col-md-2 unit">
                                            <div class="input">
                                                <input class="form-control" type="text" id="second_field_price" value="$ 3.50" readonly="" name="second_field_price">
                                            </div>
                                        </div>
                                        <div class="col-md-2 unit">
                                            <div class="input">
                                                <input class="form-control" type="text" id="second_field_total" readonly="" name="second_field_total">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end fruit watermelon --

                                    <!-- start additional fruit --
                                    <div class="row fruits-calculation">
                                        <div class="col-md-5 unit">
                                            <div class="input">
                                                <input class="form-control" type="text" id="third_field" placeholder="add your fruit" name="third_field">
                                            </div>
                                        </div>
                                        <div class="col-md-3 unit">
                                            <div class="input quantity-events">
                                                <input class="form-control" type="text" id="third_field_quantity" name="third_field_quantity">
                                            </div>
                                        </div>
                                        <div class="col-md-2 unit">
                                            <div class="input">
                                                <input class="form-control" type="text" id="third_field_price" data-a-sign="$ " name="third_field_price">
                                            </div>
                                        </div>
                                        <div class="col-md-2 unit">
                                            <div class="input">
                                                <input class="form-control" type="text" id="third_field_total" readonly="" name="third_field_total">
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- end additional fruit -->

                                    <!-- start totals -->
                                    <div class="row m-t-20">
                                        <div class="col-md-offset-8 col-md-4 unit">
                                            <div class="input">
                                                <input class="form-control" type="text" placeholder="Totals" id="field_totals" readonly="" name="field_totals">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end totals -->

                                    <!-- start response from server -->
                                    <div id="response"></div>
                                    <!-- end response from server -->

                                <!-- end /.content -->

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-success primary-btn">Order Now</button>
                                </div>
                                <!-- end /.footer -->

                            </div>
                        </div>
                </div>
            </div>
        </div>
</div>
</div>

</section>
<section class="main-container m-t-min-20"><?php include('../php/modular/footer.php') ?></section>

<!--Page Container End Here-->
<!--Rightbar Start Here-->
<aside class="rightbar">
<div class="rightbar-container">
<div class="aside-chat-box">
    <div class="coversation-toolbar">
        <div class="chat-back">
            <i class="zmdi zmdi-long-arrow-left"></i>
        </div>
        <div class="active-conversation">
            <div class="chat-avatar">
                <img src="../images/avatar/amarkdalen.jpg" alt="user">
            </div>
            <div class="chat-user-status">
                <ul>
                    <li>Feeling Blessed</li>
                    <li>Amarkdalen</li>
                </ul>
            </div>
        </div>
        <div class="conversation-action">
            <ul>
                <li><i class="zmdi zmdi-phone-in-talk"></i></li>
                <li class="dropdown">
                    <a href="#" class="btn-more dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="zmdi zmdi-attachment-alt"></i>Attach A File</a></li>
                        <li><a href="#"><i class="zmdi zmdi-mic"></i>Voice</a></li>
                        <li><a href="#"><i class="zmdi zmdi-block"></i>Block User</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="conversation-container">
        <div class="conversation-row even">
            <ul class="conversation-list">
                <li>
                    <p>
                        Hi! this is mike how can I help you?
                    </p>
                </li>
                <li>
                    <p>
                        Hello Sir!
                    </p>
                </li>
            </ul>
        </div>
        <div class="conversation-row odd">
            <ul class="conversation-list">
                <li>
                    <p>
                        Hi! Mike I need a support my account is suspended but I don't know why?
                    </p>
                </li>
            </ul>
        </div>
        <div class="conversation-row even">
            <ul class="conversation-list">
                <li>
                    <p>
                        Ok Sir! Let me check this issue please wait a min
                    </p>
                </li>
            </ul>
        </div>
        <div class="conversation-row odd">
            <ul class="conversation-list">
                <li>
                    <p>
                        Ok sure :)
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="chat-text-input">
        <input type="text" class="form-control">
    </div>
</div>
<ul class="nav nav-tabs material-tabs rightbar-tab" role="tablist">
    <li class="active"><a href="#chat" aria-controls="message" role="tab" data-toggle="tab">Chat</a></li>
    <li><a href="#activities" aria-controls="notifications" role="tab" data-toggle="tab">Activities</a></li>
</ul>
<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="chat">
    <div class="chat-user-toolbar clearfix">
        <div class="chat-user-search pull-left">
            <span class="addon-icon"><i class="zmdi zmdi-search"></i></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
        <div class="add-chat-list pull-right">
            <i class="zmdi zmdi-accounts-add"></i>
        </div>
    </div>
    <div class="chat-user-container">
        <h3 class="clearfix"><span class="pull-left">Members</span><span class="pull-right online-counter">3 Online</span></h3>
        <ul class="chat-user-list">
            <li>
                <div data-trigger="hover" title="Robertoortiz" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/robertoortiz.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Admin</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left"><span class="chat-avatar"><img src="../images/avatar/robertoortiz.jpg" alt="Avatar"></span><span class="chat-u-info">Adellecharles<cite>New York</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li class="chat-u-online">
                <div data-trigger="hover" title="Kurafire" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/kurafire.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left"><span class="chat-avatar"><img src="../images/avatar/kurafire.jpg" alt="Avatar"></span><span class="chat-u-info">Kurafire<cite>New York</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li class="chat-u-away">
                <div data-trigger="hover" title="Mikeluby" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/mikeluby.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/mikeluby.jpg" alt="Avatar"></span><span class="chat-u-info">Bobbyjkane<cite>London City</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li class="chat-u-busy">
                <div data-trigger="hover" title="Joostvanderree" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/joostvanderree.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/joostvanderree.jpg" alt="Avatar"></span><span class="chat-u-info">Joostvanderree<cite>New York</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
        </ul>
        <h3 class="clearfix"><span class="pull-left">Guests</span><span class="pull-right online-counter">1 Online</span></h3>
        <ul class="chat-user-list">
            <li>
                <div data-trigger="hover" title="Kevinthompson" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/Kevinthompson.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/kevinthompson.jpg" alt="Avatar"></span><span class="chat-u-info">Kevinthompson<cite>Scotland</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li class="chat-u-online">
                <div data-trigger="hover" title="Mds" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/mds.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/mds.jpg" alt="Avatar"></span><span class="chat-u-info">Mds<cite>South West, England</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li>
                <div data-trigger="hover" title="Mko" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/mko.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/mko.jpg" alt="Avatar"></span><span class="chat-u-info">Mko<cite>New York</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li>
                <div data-trigger="hover" title="Coreyweb" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/coreyweb.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/coreyweb.jpg" alt="Avatar"></span><span class="chat-u-info">Coreyweb<cite>Northern Ireland</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
            <li>
                <div data-trigger="hover" title="Amarkdalen" data-content="<div class='chat-user-info'>
                                        <div class='chat-user-avatar'>
                                        <img src='../images/avatar/amarkdalen.jpg' alt='Avatar'>
                                        </div>
                                        <div class='chat-user-details'>
                                        <ul>
                                        <li>Status: <span>Online</span></li>
                                        <li>Type: <span>Moderator</span></li>
                                        <li>Last Login: <span>3 hours Ago</span></li>
                                        <li></li>
                                        </ul>
                                        </div>
                                        </div>
                                        " data-placement="left">
                    <span class="chat-avatar"><img src="../images/avatar/amarkdalen.jpg" alt="Avatar"></span><span class="chat-u-info">Oykun<cite>New York</cite></span>
                </div>
                <span class="chat-u-status"><i class="fa fa-circle"></i></span>
            </li>
        </ul>
    </div>
</div>
<div role="tabpanel" class="tab-pane" id="activities">
    <div class="activities-timeline">
        <h3 class="tab-pane-header">Recent Activities</h3>
        <ul class="activities-list">
            <li>
                <div class="activities-badge">
                    <span class="w_bg_amber"><i class="zmdi zmdi-ticket-star"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Resolved Tickets #LTK7865</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> 30 min ago
                    </div>
                </div>
            </li>
            <li>
                <div class="activities-badge">
                    <span class="w_bg_cyan"><i class="zmdi zmdi-file-plus"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Files Uploaded</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> 1 hour ago
                    </div>
                    <div class="activities-post">
                        <ul class="new-file-lists">
                            <li><a href="#"><i class="fa fa-file-text"></i> change-log.txt</a></li>
                            <li><a href="#"><i class="fa fa-file-audio-o"></i> skype-conversation.mp3</a></li>
                            <li><a href="#"><i class="fa fa-file-powerpoint-o"></i> presentation.ppt</a></li>
                            <li><a href="#"><i class="fa fa-file-video-o"></i> howtouse.avi</a></li>
                            <li><a href="#"><i class="fa fa-file-image-o"></i> screenshot.jpg</a></li>
                            <li><a href="#"><i class="fa fa-file-word-o"></i> nda.doc</a></li>
                            <li><a href="#"><i class="fa fa-file-pdf-o"></i> resume.pdf</a></li>
                            <li><a href="#"><i class="fa fa-file-archive-o"></i> all-files.zip</a></li>
                            <li><a href="#"><i class="fa fa-file-excel-o"></i> bill.xls</a></li>
                            <li><a href="#">+10</a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <div class="activities-badge">
                    <span class="w_bg_light_blue"><i class="zmdi zmdi-image"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Images Uploaded</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> July 22 at 1:12pm
                    </div>
                    <div class="activities-post">
                        <ul class="new-image-lists">
                            <li><a href="#"><img src="../images/img-1-thumb.jpg" alt="image"></a></li>
                            <li><a href="#"><img src="../images/img-2-thumb.jpg" alt="image"></a></li>
                            <li><a href="#"><img src="../images/img-3-thumb.jpg" alt="image"></a></li>
                            <li><a href="#" class="more-list"><i class="zmdi zmdi-more-horiz"></i></a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <div class="activities-badge">
                    <span class="w_bg_green"><i class="zmdi zmdi-accounts-alt"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Users Approved</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> July 22 at 1:12pm
                    </div>
                    <div class="activities-post">
                        <ul class="new-user-lists">
                            <li><a href="#"><img src="../images/avatar/oykun.jpg" alt="image"></a></li>
                            <li><a href="#"><img src="../images/avatar/mds.jpg" alt="image"></a></li>
                            <li><a href="#"><img src="../images/avatar/robertoortiz.jpg" alt="image"></a></li>
                            <li><a href="#" class="more-list"><i class="zmdi zmdi-more-horiz"></i></a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <div class="activities-badge">
                    <span class="w_bg_deep_purple"><i class="zmdi zmdi-file-text"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Post New Article</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> July 22 at 1:12pm
                    </div>
                    <div class="activities-post">
                        <ul class="new-post-lists">
                            <li><a href="#">Man in the Verde Valley</a></li>
                            <li><a href="#">Sinagua Pueblo Life</a></li>
                            <li><a href="#">Montezuma Well</a></li>
                            <li><a href="#">The Natural Scene</a></li>
                            <li><a href="#">+6</a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <div class="activities-badge">
                    <span class="w_bg_teal"><i class="zmdi zmdi-comments"></i></span>
                </div>
                <div class="activities-details">
                    <h3 class="activities-header"><a href="#">Comments Replied</a></h3>
                    <div class="activities-meta">
                        <i class="fa fa-clock-o"></i> July 22 at 1:12pm
                    </div>
                    <div class="activities-post">
                        <ul class="new-comments-lists">
                            <li><a href="#">As long as you are reasonably careful about where you step and avoid putting ...</a></li>
                            <li><a href="#">Montezuma Castle is 5 miles north of Camp Verde, 60 miles south...</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
</div>
</div>
</aside>
<!--Rightbar End Here-->


<script src="../js/lib/jquery.js"></script>
<script src="../js/lib/jquery-migrate.js"></script>
<script src="../js/lib/bootstrap.js"></script>
<script src="../js/lib/jquery.ui.js"></script>
<script src="../js/lib/jRespond.js"></script>
<script src="../js/lib/nav.accordion.js"></script>
<script src="../js/lib/hover.intent.js"></script>
<script src="../js/lib/hammerjs.js"></script>
<script src="../js/lib/jquery.hammer.js"></script>
<script src="../js/lib/jquery.fitvids.js"></script>
<script src="../js/lib/scrollup.js"></script>
<script src="../js/lib/smoothscroll.js"></script>
<script src="../js/lib/jquery.slimscroll.js"></script>
<script src="../js/lib/jquery.syntaxhighlighter.js"></script>
<script src="../js/lib/velocity.js"></script>
<script src="../js/lib/jquery-jvectormap.js"></script>
<script src="../js/lib/jquery-jvectormap-world-mill.js"></script>
<script src="../js/lib/jquery-jvectormap-us-aea.js"></script>
<script src="../js/lib/smart-resize.js"></script>
<!--iCheck-->
<script src="../js/lib/icheck.js"></script>
<script src="../js/lib/jquery.switch.button.js"></script>
<!--CHARTS-->
<script src="../js/lib/chart/sparkline/jquery.sparkline.js"></script>
<script src="../js/lib/chart/easypie/jquery.easypiechart.min.js"></script>
<script src="../js/lib/chart/flot/excanvas.min.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.min.js"></script>
<script src="../js/lib/chart/flot/curvedLines.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.time.min.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.stack.min.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.axislabels.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.resize.min.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.tooltip.min.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.spline.js"></script>
<script src="../js/lib/chart/flot/jquery.flot.pie.min.js"></script>
<!--Forms-->
<script src="../js/lib/jquery.maskedinput.js"></script>
<script src="../js/lib/jquery.validate.js"></script>
<script src="../js/lib/jquery.form.js"></script>
<script src="../js/lib/j-forms.js"></script>
<script src="../js/lib/jquery.loadmask.js"></script>
<script src="../js/lib/vmap.init.js"></script>
<script src="../js/lib/theme-switcher.js"></script>
<script src="../js/apps.js"></script>
</body>
</html>
