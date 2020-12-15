<?php 
    include("config/base.php");
    session_start();

    //Expire the session if user is inactive for 30
    //minutes or more.
    $expireAfter = 10;

    //Check to see if our "last action" session
    //variable has been set.
    if(isset($_SESSION['last_action'])){

        //Figure out how many seconds have passed
        //since the user was last active.
        $secondsInactive = time() - $_SESSION['last_action'];

        //Convert our minutes into seconds.
        $expireAfterSeconds = $expireAfter * 60;

        //Check to see if they have been inactive for too long.
        if($secondsInactive >= $expireAfterSeconds){
            //User has been inactive for too long.
            //Kill their session.
            session_unset();
            session_destroy();
            header('Location: '.SITE_URL.'signin.php');
        }

    }

    //Assign the current timestamp as the user's
    //latest activity
    $_SESSION['last_action'] = time();

    
	if ($_SESSION['usertype'] == ""){
		 session_unset();
            session_destroy();
            header('Location: '.SITE_URL.'signin.php');
	}
	
	
	
    include("config/db.php");
    if(!$_SESSION) header('Location: '.SITE_URL.'signin.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>TTMOBI BackOffice</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?= ASSET_URL?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?= ASSET_URL?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?= ASSET_URL?>plugins/animate-css/animate.css" rel="stylesheet" />

    <link href="<?= ASSET_URL?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <link href="<?= ASSET_URL?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <link href="<?= ASSET_URL?>plugins/daterange-picker/css/daterange-picker.css" rel="stylesheet" />
    <!-- Morris Chart Css-->
    <link href="<?= ASSET_URL?>plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?= ASSET_URL?>css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?= ASSET_URL?>css/all-themes.css" rel="stylesheet" />
</head>
<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.html">TTMOBI Admin</a>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->