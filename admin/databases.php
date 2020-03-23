<?php
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/admin/auth/checkAuth.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/controllers/UserController.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/controllers/DatabaseController.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/controllers/TableController.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/controllers/ColController.php");

$e = $AuthController->getAuthUser();
$user = null;
$dbcontroller =  new DatabaseController();
$tbcontroller =  new TableController();
$clcontroller =  new ColController();
$udbs = [];
$filter_action = false;



if($e){
	$user = UserController::getUser($e);
}else{
	$AuthController->logout();
	header("Location: http://localhost/IG%20FINAL%20PROJECT/3dB/");
}

if(isset($_POST["logout"])){
	$AuthController->logout();
	header("Location: http://localhost/IG%20FINAL%20PROJECT/3dB/");
}

if(isset($_POST["dbcreate"]) && isset($dbcontroller)){
	$filter_action = true;
	$dbcontroller->setType("INSERT");
	$_POST["uemail"] = $user->getEmail();
	$dbcontroller->setRequest($_POST);
	$dbcontroller->process();
	$err = $dbcontroller->getLastError();
	if($err){
		//error message
	}
}

if(isset($_POST["tablecreate"])&& isset($tbcontroller)){
	$filter_action = true;
	$tbcontroller->setType("INSERT");
	$_POST["uemail"] = $user->getEmail();
	$tbcontroller->setRequest($_POST);
	$tbcontroller->process();
	$err = $tbcontroller->getLastError();
	if($err){
		//error message
	}
}

if(isset($_POST["colcreate"])&& isset($clcontroller)){
	$filter_action = true;
	$clcontroller->setType("INSERT");
	$_POST["uemail"] = $user->getEmail();
	$clcontroller->setRequest($_POST);
	$clcontroller->process();
	$err = $clcontroller->getLastError();
	if($err){
		//error message
	}
}

if(isset($_GET["action"]) && isset($_GET["type"]) && isset($_GET["id"]) && !$filter_action){
	switch($_GET["action"]){
		case "delete":
			switch($_GET["type"]){
				case "col":
					$clcontroller->setType("DELETE");
					$_POST["uemail"] = $user->getEmail();
					$_POST["id"] = $_GET["id"];
					$clcontroller->setRequest($_POST);
					$clcontroller->process();

				break;
				case "table":
					$tbcontroller->setType("DELETE");
					$_POST["uemail"] = $user->getEmail();
					$_POST["id"] = $_GET["id"];
					$tbcontroller->setRequest($_POST);
					$tbcontroller->process();
				break;
				case "database":
					$dbcontroller->setType("DELETE");
					$_POST["uemail"] = $user->getEmail();
					$_POST["id"] = $_GET["id"];
					$dbcontroller->setRequest($_POST);
					$dbcontroller->process();
				break;
				default:
				break;
			}
		break;
		default:
		break;
	}
}


if($user!=null && isset($tbcontroller)){
	$udbs = $dbcontroller->getUserDb($user->getEmail());
}


?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>3dB - Manage Databases</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href='assets/css/Roboto.css' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
		<style>
			.empty-message{
				text-align:center;
				background-color:rgba(0,0,0,0.1);
				line-height: 50px;
				color:#000;
				opacity: 0.3;
				margin-top:0px;
				margin-bottom:0px;
				width:98%;
				margin-left:1%;
			}
			.btnselected{
				background-color:#FF4A55;
				color:#fff;
			}
			.btnselected:hover{
				background-color:#fff;
				color:#FF4A55;
			}
		</style>
</head>
<body>

<div class="wrapper">
	<div class="sidebar" data-color="red" data-image="assets/img/sidebar-5.jpg">

	<!--

			Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
			Tip 2: you can also add an image using data-image tag

	-->

		<div class="sidebar-wrapper">
					<div class="logo">
							<a href="#" class="simple-text">
									<img src="../images/3dBlogo_nobg.png" alt="3dB logo" height="90px">
							</a>
					</div>

					<ul class="nav">
							<li>
									<a href="dashboard.php">
											<i class="pe-7s-graph"></i>
											<p>Dashboard</p>
									</a>
							</li>
							<li>
									<a href="profile.php">
											<i class="pe-7s-user"></i>
											<p>Account</p>
									</a>
							</li>
							<li class="active">
									<a href="databases.php">
											<i class="pe-7s-server"></i>
											<p>Databases</p>
									</a>
							</li>
							<li>
									<a href="adminapi.php">
											<i class="pe-7s-rocket"></i>
											<p>APIs</p>
									</a>
							</li>

			<li class="active-pro">
									<a href="3D-experience.php">
											<i class="pe-7s-right-arrow"></i>
											<p>Go to 3D Experience</p>
									</a>
							</li>
					</ul>
		</div>
	</div>

	<div class="main-panel">
			<nav class="navbar navbar-default navbar-fixed">
					<div class="container-fluid">
							<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
											<span class="sr-only">Toggle navigation</span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
									</button>
									<a class="navbar-brand" href="#">Dashboard</a>
							</div>
							<div class="collapse navbar-collapse">
									<ul class="nav navbar-nav navbar-left">
											<li class="dropdown">
														<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																	<i class="fa fa-globe"></i>
																	<b class="caret"></b>
																	<span class="notification">0</span>
														</a>
														<!--
														<ul class="dropdown-menu">

															<li><a href="#">Notification 1</a></li>
															<li><a href="#">Notification 2</a></li>
															<li><a href="#">Notification 3</a></li>
															<li><a href="#">Notification 4</a></li>
															<li><a href="#">Another notification</a></li>

														</ul>
														-->
											</li>
											<!--
											<li>
												 <a href="">
															<i class="fa fa-search"></i>
													</a>
											</li>
										-->
									</ul>

									<ul class="nav navbar-nav navbar-right">
											<li>
												 <a href="profile.php">
														 Account
													</a>
											</li>
											<li class="dropdown">
														<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																	Info About
																	<b class="caret"></b>
														</a>
														<ul class="dropdown-menu">
															<li><a href="#">The developer</a></li>
															<li><a href="#">Sapienza</a></li>
															<li><a href="#">Computer Science</a></li>
															<li><a href="#">Interactive Graphics</a></li>
															<li><a href="#">Mobile Applications</a></li>
															<li class="divider"></li>
															<li><a href="#">Credits and References</a></li>

														</ul>
											</li>
											<li>
												<form method="post">
													<button class="btn btn-danger" type="submit" id="logout" name="logout">Logout</button>
												</form>
											</li>
									</ul>
							</div>
					</div>
			</nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" id="databases">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Databases</h4>
                                <p class="category">a view of all your databases</p><br>
																<button type="button" class="btn btn-default show-view btnselected" data-id="global">Global View</button>
																<button type="button" class="btn btn-default" id="add-db">Add</button>
																<button type="button" class="btn btn-default" id="refresh-db"><i class="fa fa-refresh"></i></button>

																<form style="margin-bottom: 7em;" id="add-db-form" method="post">

																<div class="row" style="margin-top:2em;">
																	<div class="col-md-6">
																			<div class="form-group">
																					<label>Name</label>
																					<input type="text" class="form-control" id="dbname" name="dbname" placeholder="insert DB name" value="">
																			</div>
																	</div>
																	<div class="col-md-6">
																			<div class="form-group">
																					<label>ENCODING</label>
																					<select class="form-control" id="dbencoding" name="dbencoding">
																						<optgroup label="keybcs2" title="DOS Kamenicky Czech-Slovak">
																						<option value="keybcs2_bin" title="Ceco-Slovacco, Binario">keybcs2_bin</option>
																						<option value="keybcs2_general_ci" title="Ceco-Slovacco, case-insensitive">keybcs2_general_ci</option>
																						</optgroup>
																						<optgroup label="koi8r" title="KOI8-R Relcom Russian">
																						<option value="koi8r_bin" title="Russo, Binario">koi8r_bin</option>
																						<option value="koi8r_general_ci" title="Russo, case-insensitive">koi8r_general_ci</option>
																						</optgroup>
																						<optgroup label="koi8u" title="KOI8-U Ukrainian">
																						<option value="koi8u_bin" title="Ucraino, Binario">koi8u_bin</option>
																						<option value="koi8u_general_ci" title="Ucraino, case-insensitive">koi8u_general_ci</option>
																						</optgroup>
																						<optgroup label="latin1" title="cp1252 West European">
																						<option value="latin1_bin" title="Europeo Occidentale (multilingua), Binario">latin1_bin</option>
																						<option value="latin1_danish_ci" title="Danese, case-insensitive">latin1_danish_ci</option>
																						<option value="latin1_general_ci" title="Europeo Occidentale (multilingua), case-insensitive">latin1_general_ci</option>
																						<option value="latin1_general_cs" title="Europeo Occidentale (multilingua), case-sensitive">latin1_general_cs</option>
																						<option value="latin1_german1_ci" title="Tedesco (dizionario), case-insensitive">latin1_german1_ci</option>
																						<option value="latin1_german2_ci" title="Tedesco (rubrica), case-insensitive">latin1_german2_ci</option>
																						<option value="latin1_spanish_ci" title="Spagnolo, case-insensitive">latin1_spanish_ci</option>
																						<option value="latin1_swedish_ci" title="Svedese, case-insensitive" selected>latin1_swedish_ci</option>
																						</optgroup>
																						<optgroup label="latin2" title="ISO 8859-2 Central European">
																						<option value="latin2_bin" title="Europeo Centrale (multilingua), Binario">latin2_bin</option>
																						<option value="latin2_croatian_ci" title="Croato, case-insensitive">latin2_croatian_ci</option>
																						<option value="latin2_czech_cs" title="Ceco, case-sensitive">latin2_czech_cs</option>
																						<option value="latin2_general_ci" title="Europeo Centrale (multilingua), case-insensitive">latin2_general_ci</option>
																						<option value="latin2_hungarian_ci" title="Ungherese, case-insensitive">latin2_hungarian_ci</option>
																						</optgroup>
																						<optgroup label="latin5" title="ISO 8859-9 Turkish">
																						<option value="latin5_bin" title="Turco, Binario">latin5_bin</option>
																						<option value="latin5_turkish_ci" title="Turco, case-insensitive">latin5_turkish_ci</option>
																						</optgroup>
																						<optgroup label="latin7" title="ISO 8859-13 Baltic">
																						<option value="latin7_bin" title="Baltico (multilingua), Binario">latin7_bin</option>
																						<option value="latin7_estonian_cs" title="Estone, case-sensitive">latin7_estonian_cs</option>
																						<option value="latin7_general_ci" title="Baltico (multilingua), case-insensitive">latin7_general_ci</option>
																						<option value="latin7_general_cs" title="Baltico (multilingua), case-sensitive">latin7_general_cs</option>
																						</optgroup>
																						<optgroup label="macce" title="Mac Central European">
																						<option value="macce_bin" title="Europeo Centrale (multilingua), Binario">macce_bin</option>
																						<option value="macce_general_ci" title="Europeo Centrale (multilingua), case-insensitive">macce_general_ci</option>
																						</optgroup>
																						<optgroup label="macroman" title="Mac West European">
																						<option value="macroman_bin" title="Europeo Occidentale (multilingua), Binario">macroman_bin</option>
																						<option value="macroman_general_ci" title="Europeo Occidentale (multilingua), case-insensitive">macroman_general_ci</option>
																						</optgroup>
																						<optgroup label="sjis" title="Shift-JIS Japanese">
																						<option value="sjis_bin" title="Giapponese, Binario">sjis_bin</option>
																						<option value="sjis_japanese_ci" title="Giapponese, case-insensitive">sjis_japanese_ci</option>
																						</optgroup>
																						<optgroup label="swe7" title="7bit Swedish">
																						<option value="swe7_bin" title="Svedese, Binario">swe7_bin</option>
																						<option value="swe7_swedish_ci" title="Svedese, case-insensitive">swe7_swedish_ci</option>
																						</optgroup>
																						<optgroup label="tis620" title="TIS620 Thai">
																						<option value="tis620_bin" title="Thai, Binario">tis620_bin</option>
																						<option value="tis620_thai_ci" title="Thai, case-insensitive">tis620_thai_ci</option>
																						</optgroup>
																						<optgroup label="ucs2" title="UCS-2 Unicode">
																						<option value="ucs2_bin" title="Unicode (multilingua), Binario">ucs2_bin</option>
																						<option value="ucs2_croatian_ci" title="Croato, case-insensitive">ucs2_croatian_ci</option>
																						<option value="ucs2_croatian_mysql561_ci" title="Croato">ucs2_croatian_mysql561_ci</option>
																						<option value="ucs2_czech_ci" title="Ceco, case-insensitive">ucs2_czech_ci</option>
																						<option value="ucs2_danish_ci" title="Danese, case-insensitive">ucs2_danish_ci</option>
																						<option value="ucs2_esperanto_ci" title="Esperanto, case-insensitive">ucs2_esperanto_ci</option>
																						<option value="ucs2_estonian_ci" title="Estone, case-insensitive">ucs2_estonian_ci</option>
																						<option value="ucs2_general_ci" title="Unicode (multilingua), case-insensitive">ucs2_general_ci</option>
																						<option value="ucs2_general_mysql500_ci" title="Unicode (multilingua)">ucs2_general_mysql500_ci</option>
																						<option value="ucs2_german2_ci" title="Tedesco (rubrica), case-insensitive">ucs2_german2_ci</option>
																						<option value="ucs2_hungarian_ci" title="Ungherese, case-insensitive">ucs2_hungarian_ci</option>
																						<option value="ucs2_icelandic_ci" title="Islandese, case-insensitive">ucs2_icelandic_ci</option>
																						<option value="ucs2_latvian_ci" title="Lituano, case-insensitive">ucs2_latvian_ci</option>
																						<option value="ucs2_lithuanian_ci" title="Lituano, case-insensitive">ucs2_lithuanian_ci</option>
																						<option value="ucs2_myanmar_ci" title="sconosciuto, case-insensitive">ucs2_myanmar_ci</option>
																						<option value="ucs2_persian_ci" title="Persiano, case-insensitive">ucs2_persian_ci</option>
																						<option value="ucs2_polish_ci" title="Polacco, case-insensitive">ucs2_polish_ci</option>
																						<option value="ucs2_roman_ci" title="Europeo Occidentale, case-insensitive">ucs2_roman_ci</option>
																						<option value="ucs2_romanian_ci" title="Rumeno, case-insensitive">ucs2_romanian_ci</option>
																						<option value="ucs2_sinhala_ci" title="Cingalese, case-insensitive">ucs2_sinhala_ci</option>
																						<option value="ucs2_slovak_ci" title="Slovacco, case-insensitive">ucs2_slovak_ci</option>
																						<option value="ucs2_slovenian_ci" title="Sloveno, case-insensitive">ucs2_slovenian_ci</option>
																						<option value="ucs2_spanish2_ci" title="Spagnolo tradizionale, case-insensitive">ucs2_spanish2_ci</option>
																						<option value="ucs2_spanish_ci" title="Spagnolo, case-insensitive">ucs2_spanish_ci</option>
																						<option value="ucs2_swedish_ci" title="Svedese, case-insensitive">ucs2_swedish_ci</option>
																						<option value="ucs2_thai_520_w2" title="Thai">ucs2_thai_520_w2</option>
																						<option value="ucs2_turkish_ci" title="Turco, case-insensitive">ucs2_turkish_ci</option>
																						<option value="ucs2_unicode_520_ci" title="Unicode (multilingua)">ucs2_unicode_520_ci</option>
																						<option value="ucs2_unicode_ci" title="Unicode (multilingua), case-insensitive">ucs2_unicode_ci</option>
																						<option value="ucs2_vietnamese_ci" title="Vietnamese, case-insensitive">ucs2_vietnamese_ci</option>
																						</optgroup>
																						<optgroup label="ujis" title="EUC-JP Japanese">
																						<option value="ujis_bin" title="Giapponese, Binario">ujis_bin</option>
																						<option value="ujis_japanese_ci" title="Giapponese, case-insensitive">ujis_japanese_ci</option>
																						</optgroup>
																						<optgroup label="utf16" title="UTF-16 Unicode">
																						<option value="utf16_bin" title="sconosciuto, Binario">utf16_bin</option>
																						<option value="utf16_croatian_ci" title="Croato, case-insensitive">utf16_croatian_ci</option>
																						<option value="utf16_croatian_mysql561_ci" title="Croato">utf16_croatian_mysql561_ci</option>
																						<option value="utf16_czech_ci" title="Ceco, case-insensitive">utf16_czech_ci</option>
																						<option value="utf16_danish_ci" title="Danese, case-insensitive">utf16_danish_ci</option>
																						<option value="utf16_esperanto_ci" title="Esperanto, case-insensitive">utf16_esperanto_ci</option>
																						<option value="utf16_estonian_ci" title="Estone, case-insensitive">utf16_estonian_ci</option>
																						<option value="utf16_general_ci" title="sconosciuto, case-insensitive">utf16_general_ci</option>
																						<option value="utf16_german2_ci" title="Tedesco (rubrica), case-insensitive">utf16_german2_ci</option>
																						<option value="utf16_hungarian_ci" title="Ungherese, case-insensitive">utf16_hungarian_ci</option>
																						<option value="utf16_icelandic_ci" title="Islandese, case-insensitive">utf16_icelandic_ci</option>
																						<option value="utf16_latvian_ci" title="Lituano, case-insensitive">utf16_latvian_ci</option>
																						<option value="utf16_lithuanian_ci" title="Lituano, case-insensitive">utf16_lithuanian_ci</option>
																						<option value="utf16_myanmar_ci" title="sconosciuto, case-insensitive">utf16_myanmar_ci</option>
																						<option value="utf16_persian_ci" title="Persiano, case-insensitive">utf16_persian_ci</option>
																						<option value="utf16_polish_ci" title="Polacco, case-insensitive">utf16_polish_ci</option>
																						<option value="utf16_roman_ci" title="Europeo Occidentale, case-insensitive">utf16_roman_ci</option>
																						<option value="utf16_romanian_ci" title="Rumeno, case-insensitive">utf16_romanian_ci</option>
																						<option value="utf16_sinhala_ci" title="Cingalese, case-insensitive">utf16_sinhala_ci</option>
																						<option value="utf16_slovak_ci" title="Slovacco, case-insensitive">utf16_slovak_ci</option>
																						<option value="utf16_slovenian_ci" title="Sloveno, case-insensitive">utf16_slovenian_ci</option>
																						<option value="utf16_spanish2_ci" title="Spagnolo tradizionale, case-insensitive">utf16_spanish2_ci</option>
																						<option value="utf16_spanish_ci" title="Spagnolo, case-insensitive">utf16_spanish_ci</option>
																						<option value="utf16_swedish_ci" title="Svedese, case-insensitive">utf16_swedish_ci</option>
																						<option value="utf16_thai_520_w2" title="Thai">utf16_thai_520_w2</option>
																						<option value="utf16_turkish_ci" title="Turco, case-insensitive">utf16_turkish_ci</option>
																						<option value="utf16_unicode_520_ci" title="Unicode (multilingua)">utf16_unicode_520_ci</option>
																						<option value="utf16_unicode_ci" title="Unicode (multilingua), case-insensitive">utf16_unicode_ci</option>
																						<option value="utf16_vietnamese_ci" title="Vietnamese, case-insensitive">utf16_vietnamese_ci</option>
																						</optgroup>
																						<optgroup label="utf16le" title="UTF-16LE Unicode">
																						<option value="utf16le_bin" title="sconosciuto, Binario">utf16le_bin</option>
																						<option value="utf16le_general_ci" title="sconosciuto, case-insensitive">utf16le_general_ci</option>
																						</optgroup>
																						<optgroup label="utf32" title="UTF-32 Unicode">
																						<option value="utf32_bin" title="sconosciuto, Binario">utf32_bin</option>
																						<option value="utf32_croatian_ci" title="Croato, case-insensitive">utf32_croatian_ci</option>
																						<option value="utf32_croatian_mysql561_ci" title="Croato">utf32_croatian_mysql561_ci</option>
																						<option value="utf32_czech_ci" title="Ceco, case-insensitive">utf32_czech_ci</option>
																						<option value="utf32_danish_ci" title="Danese, case-insensitive">utf32_danish_ci</option>
																						<option value="utf32_esperanto_ci" title="Esperanto, case-insensitive">utf32_esperanto_ci</option>
																						<option value="utf32_estonian_ci" title="Estone, case-insensitive">utf32_estonian_ci</option>
																						<option value="utf32_general_ci" title="sconosciuto, case-insensitive">utf32_general_ci</option>
																						<option value="utf32_german2_ci" title="Tedesco (rubrica), case-insensitive">utf32_german2_ci</option>
																						<option value="utf32_hungarian_ci" title="Ungherese, case-insensitive">utf32_hungarian_ci</option>
																						<option value="utf32_icelandic_ci" title="Islandese, case-insensitive">utf32_icelandic_ci</option>
																						<option value="utf32_latvian_ci" title="Lituano, case-insensitive">utf32_latvian_ci</option>
																						<option value="utf32_lithuanian_ci" title="Lituano, case-insensitive">utf32_lithuanian_ci</option>
																						<option value="utf32_myanmar_ci" title="sconosciuto, case-insensitive">utf32_myanmar_ci</option>
																						<option value="utf32_persian_ci" title="Persiano, case-insensitive">utf32_persian_ci</option>
																						<option value="utf32_polish_ci" title="Polacco, case-insensitive">utf32_polish_ci</option>
																						<option value="utf32_roman_ci" title="Europeo Occidentale, case-insensitive">utf32_roman_ci</option>
																						<option value="utf32_romanian_ci" title="Rumeno, case-insensitive">utf32_romanian_ci</option>
																						<option value="utf32_sinhala_ci" title="Cingalese, case-insensitive">utf32_sinhala_ci</option>
																						<option value="utf32_slovak_ci" title="Slovacco, case-insensitive">utf32_slovak_ci</option>
																						<option value="utf32_slovenian_ci" title="Sloveno, case-insensitive">utf32_slovenian_ci</option>
																						<option value="utf32_spanish2_ci" title="Spagnolo tradizionale, case-insensitive">utf32_spanish2_ci</option>
																						<option value="utf32_spanish_ci" title="Spagnolo, case-insensitive">utf32_spanish_ci</option>
																						<option value="utf32_swedish_ci" title="Svedese, case-insensitive">utf32_swedish_ci</option>
																						<option value="utf32_thai_520_w2" title="Thai">utf32_thai_520_w2</option>
																						<option value="utf32_turkish_ci" title="Turco, case-insensitive">utf32_turkish_ci</option>
																						<option value="utf32_unicode_520_ci" title="Unicode (multilingua)">utf32_unicode_520_ci</option>
																						<option value="utf32_unicode_ci" title="Unicode (multilingua), case-insensitive">utf32_unicode_ci</option>
																						<option value="utf32_vietnamese_ci" title="Vietnamese, case-insensitive">utf32_vietnamese_ci</option>
																						</optgroup>
																						<optgroup label="utf8" title="UTF-8 Unicode">
																						<option value="utf8_bin" title="Unicode (multilingua), Binario">utf8_bin</option>
																						<option value="utf8_croatian_ci" title="Croato, case-insensitive">utf8_croatian_ci</option>
																						<option value="utf8_croatian_mysql561_ci" title="Croato">utf8_croatian_mysql561_ci</option>
																						<option value="utf8_czech_ci" title="Ceco, case-insensitive">utf8_czech_ci</option>
																						<option value="utf8_danish_ci" title="Danese, case-insensitive">utf8_danish_ci</option>
																						<option value="utf8_esperanto_ci" title="Esperanto, case-insensitive">utf8_esperanto_ci</option>
																						<option value="utf8_estonian_ci" title="Estone, case-insensitive">utf8_estonian_ci</option>
																						<option value="utf8_general_ci" title="Unicode (multilingua), case-insensitive">utf8_general_ci</option>
																						<option value="utf8_general_mysql500_ci" title="Unicode (multilingua)">utf8_general_mysql500_ci</option>
																						<option value="utf8_german2_ci" title="Tedesco (rubrica), case-insensitive">utf8_german2_ci</option>
																						<option value="utf8_hungarian_ci" title="Ungherese, case-insensitive">utf8_hungarian_ci</option>
																						<option value="utf8_icelandic_ci" title="Islandese, case-insensitive">utf8_icelandic_ci</option>
																						<option value="utf8_latvian_ci" title="Lituano, case-insensitive">utf8_latvian_ci</option>
																						<option value="utf8_lithuanian_ci" title="Lituano, case-insensitive">utf8_lithuanian_ci</option>
																						<option value="utf8_myanmar_ci" title="sconosciuto, case-insensitive">utf8_myanmar_ci</option>
																						<option value="utf8_persian_ci" title="Persiano, case-insensitive">utf8_persian_ci</option>
																						<option value="utf8_polish_ci" title="Polacco, case-insensitive">utf8_polish_ci</option>
																						<option value="utf8_roman_ci" title="Europeo Occidentale, case-insensitive">utf8_roman_ci</option>
																						<option value="utf8_romanian_ci" title="Rumeno, case-insensitive">utf8_romanian_ci</option>
																						<option value="utf8_sinhala_ci" title="Cingalese, case-insensitive">utf8_sinhala_ci</option>
																						<option value="utf8_slovak_ci" title="Slovacco, case-insensitive">utf8_slovak_ci</option>
																						<option value="utf8_slovenian_ci" title="Sloveno, case-insensitive">utf8_slovenian_ci</option>
																						<option value="utf8_spanish2_ci" title="Spagnolo tradizionale, case-insensitive">utf8_spanish2_ci</option>
																						<option value="utf8_spanish_ci" title="Spagnolo, case-insensitive">utf8_spanish_ci</option>
																						<option value="utf8_swedish_ci" title="Svedese, case-insensitive">utf8_swedish_ci</option>
																						<option value="utf8_thai_520_w2" title="Thai">utf8_thai_520_w2</option>
																						<option value="utf8_turkish_ci" title="Turco, case-insensitive">utf8_turkish_ci</option>
																						<option value="utf8_unicode_520_ci" title="Unicode (multilingua)">utf8_unicode_520_ci</option>
																						<option value="utf8_unicode_ci" title="Unicode (multilingua), case-insensitive">utf8_unicode_ci</option>
																						<option value="utf8_vietnamese_ci" title="Vietnamese, case-insensitive">utf8_vietnamese_ci</option>
																						</optgroup>
																						<optgroup label="utf8mb4" title="UTF-8 Unicode">
																						<option value="utf8mb4_bin" title="Unicode (multilingua), Binario">utf8mb4_bin</option>
																						<option value="utf8mb4_croatian_ci" title="Croato, case-insensitive">utf8mb4_croatian_ci</option>
																						<option value="utf8mb4_croatian_mysql561_ci" title="Croato">utf8mb4_croatian_mysql561_ci</option>
																						<option value="utf8mb4_czech_ci" title="Ceco, case-insensitive">utf8mb4_czech_ci</option>
																						<option value="utf8mb4_danish_ci" title="Danese, case-insensitive">utf8mb4_danish_ci</option>
																						<option value="utf8mb4_esperanto_ci" title="Esperanto, case-insensitive">utf8mb4_esperanto_ci</option>
																						<option value="utf8mb4_estonian_ci" title="Estone, case-insensitive">utf8mb4_estonian_ci</option>
																						<option value="utf8mb4_general_ci" title="Unicode (multilingua), case-insensitive">utf8mb4_general_ci</option>
																						<option value="utf8mb4_german2_ci" title="Tedesco (rubrica), case-insensitive">utf8mb4_german2_ci</option>
																						<option value="utf8mb4_hungarian_ci" title="Ungherese, case-insensitive">utf8mb4_hungarian_ci</option>
																						<option value="utf8mb4_icelandic_ci" title="Islandese, case-insensitive">utf8mb4_icelandic_ci</option>
																						<option value="utf8mb4_latvian_ci" title="Lituano, case-insensitive">utf8mb4_latvian_ci</option>
																						<option value="utf8mb4_lithuanian_ci" title="Lituano, case-insensitive">utf8mb4_lithuanian_ci</option>
																						<option value="utf8mb4_myanmar_ci" title="sconosciuto, case-insensitive">utf8mb4_myanmar_ci</option>
																						<option value="utf8mb4_persian_ci" title="Persiano, case-insensitive">utf8mb4_persian_ci</option>
																						<option value="utf8mb4_polish_ci" title="Polacco, case-insensitive">utf8mb4_polish_ci</option>
																						<option value="utf8mb4_roman_ci" title="Europeo Occidentale, case-insensitive">utf8mb4_roman_ci</option>
																						<option value="utf8mb4_romanian_ci" title="Rumeno, case-insensitive">utf8mb4_romanian_ci</option>
																						<option value="utf8mb4_sinhala_ci" title="Cingalese, case-insensitive">utf8mb4_sinhala_ci</option>
																						<option value="utf8mb4_slovak_ci" title="Slovacco, case-insensitive">utf8mb4_slovak_ci</option>
																						<option value="utf8mb4_slovenian_ci" title="Sloveno, case-insensitive">utf8mb4_slovenian_ci</option>
																						<option value="utf8mb4_spanish2_ci" title="Spagnolo tradizionale, case-insensitive">utf8mb4_spanish2_ci</option>
																						<option value="utf8mb4_spanish_ci" title="Spagnolo, case-insensitive">utf8mb4_spanish_ci</option>
																						<option value="utf8mb4_swedish_ci" title="Svedese, case-insensitive">utf8mb4_swedish_ci</option>
																						<option value="utf8mb4_thai_520_w2" title="Thai">utf8mb4_thai_520_w2</option>
																						<option value="utf8mb4_turkish_ci" title="Turco, case-insensitive">utf8mb4_turkish_ci</option>
																						<option value="utf8mb4_unicode_520_ci" title="Unicode (multilingua)">utf8mb4_unicode_520_ci</option>
																						<option value="utf8mb4_unicode_ci" title="Unicode (multilingua), case-insensitive">utf8mb4_unicode_ci</option>
																						<option value="utf8mb4_vietnamese_ci" title="Vietnamese, case-insensitive">utf8mb4_vietnamese_ci</option>
																						</optgroup>
																					</select>
																			</div>
																	</div>
																	<div class="col-md-3">
																			<div class="form-group">
																					<label>Server Address</label>
																					<input type="text" class="form-control" id="dbserveraddress" name="dbserveraddress" placeholder="insert server address" value="">
																			</div>
																	</div>
																	<div class="col-md-3">
																			<div class="form-group">
																					<label>Server Password</label>
																					<input type="password" class="form-control" id="dbserverpassword" name="dbserverpassword" placeholder="insert server password" value="">
																			</div>
																	</div>
																	<div class="col-md-3">
																			<div class="form-group">
																					<label>Server Username</label>
																					<input type="text" class="form-control" id="dbserverusername" name="dbserverusername" placeholder="insert Server username" value="">
																			</div>
																	</div>
																	<div class="col-md-3">
																			<div class="form-group">
																					<label>Server Port</label>
																					<input type="number" class="form-control" id="dbserverport" name="dbserverport" placeholder="insert Server port" value="21" min="0" max="1023">
																			</div>
																	</div>
																</div>
																<button type="submit" class="btn btn-danger btn-fill pull-left"  id="dbcreate" name="dbcreate">Create</button>
																<button type="reset" class="btn btn-default btn-fill pull-left">Close</button>

																</form>


                            </div>
                            <div class="content table-responsive table-full-width">
																<h5 id="dbtable-empty" class="empty-message">No databases are stored</h5>
                                <table class="table table-hover table-striped" id="db-table">
                                    <thead>
                                      <th>ID</th>
                                    	<th>Name</th>
                                    	<th>Encoding</th>
																			<th>Server Address</th>
																			<th>Server Password</th>
																			<th>Server Username</th>
																			<th>Server Port</th>
                                    	<th>Total Tables</th>
                                    	<th>Total Columns</th>
																			<th>Actions</th>
                                    </thead>
                                    <tbody>
																			<?php
																				foreach($udbs as $db){
																					echo('
																					<tr>
	                                        	<td>'.$db->getId().'</td>
	                                        	<td>'.$db->getName().'</td>
	                                        	<td>'.$db->getEncoding().'</td>
																						<td>'.$db->getServerAddress().'</td>
																						<td>'.$db->getServerPassword().'</td>
																						<td>'.$db->getServerUsername().'</td>
																						<td>'.$db->getServerPort().'</td>
	                                        	<td>'.$db->getTablesNumber().'</td>
	                                        	<td>'.$db->getColsNumber().'</td>
																						<td>
																							<button type="button" class="btn btn-info showtbdb show-view" data-id="tables" id="showtbdb-'.$db->getId().'">Tables</button>
																							<button type="button" class="btn btn-info editdb" id="editdb-'.$db->getId().'"><i class="fa fa-edit"></i></button>
																							<button type="button" class="btn btn-danger deletedb" id="deletedb-'.$db->getId().'" onclick="demo.showNotificationM('."'top','center','Are you sure you want to delete <b>".$db->getName()."</b>?', 'Yes','?action=delete&type=database&id=".$db->getId()."', 'pe-7s-alarm', 'warning', 1000)".'"><i class="fa fa-trash"></i></button>
																							<button type="button" class="btn btn-default exportdb" id="exportdb-'.$db->getId().'" onclick="demo.showNotificationM('."top','center','Export of <b>Db1</b> will start in few second, please wait.', '','', 'pe-7s-download','info', 200)".'"><i class="fa fa-floppy-o"></i></button>
																						</td>
	                                        </tr>'
																					);
																				}
																			?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

								<?php
									foreach($udbs as $db){
								?>
										<div class="col-md-12 db-tables" id="tables-<?php echo($db->getId())?>">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><b><?php echo($db->getName())?></b> - Tables</h4>
                                <p class="category">a view of all tables in Db1</p><br>
																<button type="button" class="btn btn-default show-view" data-id="database" >All DBs</button>
																<button type="button" class="btn btn-default add-table" id="addtable-<?php echo($db->getId())?>">Add</button>
																<button type="button" class="btn btn-default"><i class="fa fa-refresh"></i></button>

																<form style="margin-bottom: 7em;" method="post" class="add-table-form" id="tableform-<?php echo($db->getId())?>">
																<input type="hidden" name="dbid" value="<?php echo($db->getId())?>">

																<div class="row" style="margin-top:2em;">
																	<div class="col-md-6">
																			<div class="form-group">
																					<label>Name</label>
																					<input type="text" name="tbname" class="form-control" placeholder="insert Table name" value="">
																			</div>
																	</div>
																	<div class="col-md-6">
																			<div class="form-group">
																					<label>ENCODING</label>
																					<select class="form-control" id="tbencoding" name="tbencoding">
																						<optgroup label="keybcs2" title="DOS Kamenicky Czech-Slovak">
																						<option value="keybcs2_bin" title="Ceco-Slovacco, Binario">keybcs2_bin</option>
																						<option value="keybcs2_general_ci" title="Ceco-Slovacco, case-insensitive">keybcs2_general_ci</option>
																						</optgroup>
																						<optgroup label="koi8r" title="KOI8-R Relcom Russian">
																						<option value="koi8r_bin" title="Russo, Binario">koi8r_bin</option>
																						<option value="koi8r_general_ci" title="Russo, case-insensitive">koi8r_general_ci</option>
																						</optgroup>
																						<optgroup label="koi8u" title="KOI8-U Ukrainian">
																						<option value="koi8u_bin" title="Ucraino, Binario">koi8u_bin</option>
																						<option value="koi8u_general_ci" title="Ucraino, case-insensitive">koi8u_general_ci</option>
																						</optgroup>
																						<optgroup label="latin1" title="cp1252 West European">
																						<option value="latin1_bin" title="Europeo Occidentale (multilingua), Binario">latin1_bin</option>
																						<option value="latin1_danish_ci" title="Danese, case-insensitive">latin1_danish_ci</option>
																						<option value="latin1_general_ci" title="Europeo Occidentale (multilingua), case-insensitive">latin1_general_ci</option>
																						<option value="latin1_general_cs" title="Europeo Occidentale (multilingua), case-sensitive">latin1_general_cs</option>
																						<option value="latin1_german1_ci" title="Tedesco (dizionario), case-insensitive">latin1_german1_ci</option>
																						<option value="latin1_german2_ci" title="Tedesco (rubrica), case-insensitive">latin1_german2_ci</option>
																						<option value="latin1_spanish_ci" title="Spagnolo, case-insensitive">latin1_spanish_ci</option>
																						<option value="latin1_swedish_ci" title="Svedese, case-insensitive" selected>latin1_swedish_ci</option>
																						</optgroup>
																						<optgroup label="latin2" title="ISO 8859-2 Central European">
																						<option value="latin2_bin" title="Europeo Centrale (multilingua), Binario">latin2_bin</option>
																						<option value="latin2_croatian_ci" title="Croato, case-insensitive">latin2_croatian_ci</option>
																						<option value="latin2_czech_cs" title="Ceco, case-sensitive">latin2_czech_cs</option>
																						<option value="latin2_general_ci" title="Europeo Centrale (multilingua), case-insensitive">latin2_general_ci</option>
																						<option value="latin2_hungarian_ci" title="Ungherese, case-insensitive">latin2_hungarian_ci</option>
																						</optgroup>
																						<optgroup label="latin5" title="ISO 8859-9 Turkish">
																						<option value="latin5_bin" title="Turco, Binario">latin5_bin</option>
																						<option value="latin5_turkish_ci" title="Turco, case-insensitive">latin5_turkish_ci</option>
																						</optgroup>
																						<optgroup label="latin7" title="ISO 8859-13 Baltic">
																						<option value="latin7_bin" title="Baltico (multilingua), Binario">latin7_bin</option>
																						<option value="latin7_estonian_cs" title="Estone, case-sensitive">latin7_estonian_cs</option>
																						<option value="latin7_general_ci" title="Baltico (multilingua), case-insensitive">latin7_general_ci</option>
																						<option value="latin7_general_cs" title="Baltico (multilingua), case-sensitive">latin7_general_cs</option>
																						</optgroup>
																						<optgroup label="macce" title="Mac Central European">
																						<option value="macce_bin" title="Europeo Centrale (multilingua), Binario">macce_bin</option>
																						<option value="macce_general_ci" title="Europeo Centrale (multilingua), case-insensitive">macce_general_ci</option>
																						</optgroup>
																						<optgroup label="macroman" title="Mac West European">
																						<option value="macroman_bin" title="Europeo Occidentale (multilingua), Binario">macroman_bin</option>
																						<option value="macroman_general_ci" title="Europeo Occidentale (multilingua), case-insensitive">macroman_general_ci</option>
																						</optgroup>
																						<optgroup label="sjis" title="Shift-JIS Japanese">
																						<option value="sjis_bin" title="Giapponese, Binario">sjis_bin</option>
																						<option value="sjis_japanese_ci" title="Giapponese, case-insensitive">sjis_japanese_ci</option>
																						</optgroup>
																						<optgroup label="swe7" title="7bit Swedish">
																						<option value="swe7_bin" title="Svedese, Binario">swe7_bin</option>
																						<option value="swe7_swedish_ci" title="Svedese, case-insensitive">swe7_swedish_ci</option>
																						</optgroup>
																						<optgroup label="tis620" title="TIS620 Thai">
																						<option value="tis620_bin" title="Thai, Binario">tis620_bin</option>
																						<option value="tis620_thai_ci" title="Thai, case-insensitive">tis620_thai_ci</option>
																						</optgroup>
																						<optgroup label="ucs2" title="UCS-2 Unicode">
																						<option value="ucs2_bin" title="Unicode (multilingua), Binario">ucs2_bin</option>
																						<option value="ucs2_croatian_ci" title="Croato, case-insensitive">ucs2_croatian_ci</option>
																						<option value="ucs2_croatian_mysql561_ci" title="Croato">ucs2_croatian_mysql561_ci</option>
																						<option value="ucs2_czech_ci" title="Ceco, case-insensitive">ucs2_czech_ci</option>
																						<option value="ucs2_danish_ci" title="Danese, case-insensitive">ucs2_danish_ci</option>
																						<option value="ucs2_esperanto_ci" title="Esperanto, case-insensitive">ucs2_esperanto_ci</option>
																						<option value="ucs2_estonian_ci" title="Estone, case-insensitive">ucs2_estonian_ci</option>
																						<option value="ucs2_general_ci" title="Unicode (multilingua), case-insensitive">ucs2_general_ci</option>
																						<option value="ucs2_general_mysql500_ci" title="Unicode (multilingua)">ucs2_general_mysql500_ci</option>
																						<option value="ucs2_german2_ci" title="Tedesco (rubrica), case-insensitive">ucs2_german2_ci</option>
																						<option value="ucs2_hungarian_ci" title="Ungherese, case-insensitive">ucs2_hungarian_ci</option>
																						<option value="ucs2_icelandic_ci" title="Islandese, case-insensitive">ucs2_icelandic_ci</option>
																						<option value="ucs2_latvian_ci" title="Lituano, case-insensitive">ucs2_latvian_ci</option>
																						<option value="ucs2_lithuanian_ci" title="Lituano, case-insensitive">ucs2_lithuanian_ci</option>
																						<option value="ucs2_myanmar_ci" title="sconosciuto, case-insensitive">ucs2_myanmar_ci</option>
																						<option value="ucs2_persian_ci" title="Persiano, case-insensitive">ucs2_persian_ci</option>
																						<option value="ucs2_polish_ci" title="Polacco, case-insensitive">ucs2_polish_ci</option>
																						<option value="ucs2_roman_ci" title="Europeo Occidentale, case-insensitive">ucs2_roman_ci</option>
																						<option value="ucs2_romanian_ci" title="Rumeno, case-insensitive">ucs2_romanian_ci</option>
																						<option value="ucs2_sinhala_ci" title="Cingalese, case-insensitive">ucs2_sinhala_ci</option>
																						<option value="ucs2_slovak_ci" title="Slovacco, case-insensitive">ucs2_slovak_ci</option>
																						<option value="ucs2_slovenian_ci" title="Sloveno, case-insensitive">ucs2_slovenian_ci</option>
																						<option value="ucs2_spanish2_ci" title="Spagnolo tradizionale, case-insensitive">ucs2_spanish2_ci</option>
																						<option value="ucs2_spanish_ci" title="Spagnolo, case-insensitive">ucs2_spanish_ci</option>
																						<option value="ucs2_swedish_ci" title="Svedese, case-insensitive">ucs2_swedish_ci</option>
																						<option value="ucs2_thai_520_w2" title="Thai">ucs2_thai_520_w2</option>
																						<option value="ucs2_turkish_ci" title="Turco, case-insensitive">ucs2_turkish_ci</option>
																						<option value="ucs2_unicode_520_ci" title="Unicode (multilingua)">ucs2_unicode_520_ci</option>
																						<option value="ucs2_unicode_ci" title="Unicode (multilingua), case-insensitive">ucs2_unicode_ci</option>
																						<option value="ucs2_vietnamese_ci" title="Vietnamese, case-insensitive">ucs2_vietnamese_ci</option>
																						</optgroup>
																						<optgroup label="ujis" title="EUC-JP Japanese">
																						<option value="ujis_bin" title="Giapponese, Binario">ujis_bin</option>
																						<option value="ujis_japanese_ci" title="Giapponese, case-insensitive">ujis_japanese_ci</option>
																						</optgroup>
																						<optgroup label="utf16" title="UTF-16 Unicode">
																						<option value="utf16_bin" title="sconosciuto, Binario">utf16_bin</option>
																						<option value="utf16_croatian_ci" title="Croato, case-insensitive">utf16_croatian_ci</option>
																						<option value="utf16_croatian_mysql561_ci" title="Croato">utf16_croatian_mysql561_ci</option>
																						<option value="utf16_czech_ci" title="Ceco, case-insensitive">utf16_czech_ci</option>
																						<option value="utf16_danish_ci" title="Danese, case-insensitive">utf16_danish_ci</option>
																						<option value="utf16_esperanto_ci" title="Esperanto, case-insensitive">utf16_esperanto_ci</option>
																						<option value="utf16_estonian_ci" title="Estone, case-insensitive">utf16_estonian_ci</option>
																						<option value="utf16_general_ci" title="sconosciuto, case-insensitive">utf16_general_ci</option>
																						<option value="utf16_german2_ci" title="Tedesco (rubrica), case-insensitive">utf16_german2_ci</option>
																						<option value="utf16_hungarian_ci" title="Ungherese, case-insensitive">utf16_hungarian_ci</option>
																						<option value="utf16_icelandic_ci" title="Islandese, case-insensitive">utf16_icelandic_ci</option>
																						<option value="utf16_latvian_ci" title="Lituano, case-insensitive">utf16_latvian_ci</option>
																						<option value="utf16_lithuanian_ci" title="Lituano, case-insensitive">utf16_lithuanian_ci</option>
																						<option value="utf16_myanmar_ci" title="sconosciuto, case-insensitive">utf16_myanmar_ci</option>
																						<option value="utf16_persian_ci" title="Persiano, case-insensitive">utf16_persian_ci</option>
																						<option value="utf16_polish_ci" title="Polacco, case-insensitive">utf16_polish_ci</option>
																						<option value="utf16_roman_ci" title="Europeo Occidentale, case-insensitive">utf16_roman_ci</option>
																						<option value="utf16_romanian_ci" title="Rumeno, case-insensitive">utf16_romanian_ci</option>
																						<option value="utf16_sinhala_ci" title="Cingalese, case-insensitive">utf16_sinhala_ci</option>
																						<option value="utf16_slovak_ci" title="Slovacco, case-insensitive">utf16_slovak_ci</option>
																						<option value="utf16_slovenian_ci" title="Sloveno, case-insensitive">utf16_slovenian_ci</option>
																						<option value="utf16_spanish2_ci" title="Spagnolo tradizionale, case-insensitive">utf16_spanish2_ci</option>
																						<option value="utf16_spanish_ci" title="Spagnolo, case-insensitive">utf16_spanish_ci</option>
																						<option value="utf16_swedish_ci" title="Svedese, case-insensitive">utf16_swedish_ci</option>
																						<option value="utf16_thai_520_w2" title="Thai">utf16_thai_520_w2</option>
																						<option value="utf16_turkish_ci" title="Turco, case-insensitive">utf16_turkish_ci</option>
																						<option value="utf16_unicode_520_ci" title="Unicode (multilingua)">utf16_unicode_520_ci</option>
																						<option value="utf16_unicode_ci" title="Unicode (multilingua), case-insensitive">utf16_unicode_ci</option>
																						<option value="utf16_vietnamese_ci" title="Vietnamese, case-insensitive">utf16_vietnamese_ci</option>
																						</optgroup>
																						<optgroup label="utf16le" title="UTF-16LE Unicode">
																						<option value="utf16le_bin" title="sconosciuto, Binario">utf16le_bin</option>
																						<option value="utf16le_general_ci" title="sconosciuto, case-insensitive">utf16le_general_ci</option>
																						</optgroup>
																						<optgroup label="utf32" title="UTF-32 Unicode">
																						<option value="utf32_bin" title="sconosciuto, Binario">utf32_bin</option>
																						<option value="utf32_croatian_ci" title="Croato, case-insensitive">utf32_croatian_ci</option>
																						<option value="utf32_croatian_mysql561_ci" title="Croato">utf32_croatian_mysql561_ci</option>
																						<option value="utf32_czech_ci" title="Ceco, case-insensitive">utf32_czech_ci</option>
																						<option value="utf32_danish_ci" title="Danese, case-insensitive">utf32_danish_ci</option>
																						<option value="utf32_esperanto_ci" title="Esperanto, case-insensitive">utf32_esperanto_ci</option>
																						<option value="utf32_estonian_ci" title="Estone, case-insensitive">utf32_estonian_ci</option>
																						<option value="utf32_general_ci" title="sconosciuto, case-insensitive">utf32_general_ci</option>
																						<option value="utf32_german2_ci" title="Tedesco (rubrica), case-insensitive">utf32_german2_ci</option>
																						<option value="utf32_hungarian_ci" title="Ungherese, case-insensitive">utf32_hungarian_ci</option>
																						<option value="utf32_icelandic_ci" title="Islandese, case-insensitive">utf32_icelandic_ci</option>
																						<option value="utf32_latvian_ci" title="Lituano, case-insensitive">utf32_latvian_ci</option>
																						<option value="utf32_lithuanian_ci" title="Lituano, case-insensitive">utf32_lithuanian_ci</option>
																						<option value="utf32_myanmar_ci" title="sconosciuto, case-insensitive">utf32_myanmar_ci</option>
																						<option value="utf32_persian_ci" title="Persiano, case-insensitive">utf32_persian_ci</option>
																						<option value="utf32_polish_ci" title="Polacco, case-insensitive">utf32_polish_ci</option>
																						<option value="utf32_roman_ci" title="Europeo Occidentale, case-insensitive">utf32_roman_ci</option>
																						<option value="utf32_romanian_ci" title="Rumeno, case-insensitive">utf32_romanian_ci</option>
																						<option value="utf32_sinhala_ci" title="Cingalese, case-insensitive">utf32_sinhala_ci</option>
																						<option value="utf32_slovak_ci" title="Slovacco, case-insensitive">utf32_slovak_ci</option>
																						<option value="utf32_slovenian_ci" title="Sloveno, case-insensitive">utf32_slovenian_ci</option>
																						<option value="utf32_spanish2_ci" title="Spagnolo tradizionale, case-insensitive">utf32_spanish2_ci</option>
																						<option value="utf32_spanish_ci" title="Spagnolo, case-insensitive">utf32_spanish_ci</option>
																						<option value="utf32_swedish_ci" title="Svedese, case-insensitive">utf32_swedish_ci</option>
																						<option value="utf32_thai_520_w2" title="Thai">utf32_thai_520_w2</option>
																						<option value="utf32_turkish_ci" title="Turco, case-insensitive">utf32_turkish_ci</option>
																						<option value="utf32_unicode_520_ci" title="Unicode (multilingua)">utf32_unicode_520_ci</option>
																						<option value="utf32_unicode_ci" title="Unicode (multilingua), case-insensitive">utf32_unicode_ci</option>
																						<option value="utf32_vietnamese_ci" title="Vietnamese, case-insensitive">utf32_vietnamese_ci</option>
																						</optgroup>
																						<optgroup label="utf8" title="UTF-8 Unicode">
																						<option value="utf8_bin" title="Unicode (multilingua), Binario">utf8_bin</option>
																						<option value="utf8_croatian_ci" title="Croato, case-insensitive">utf8_croatian_ci</option>
																						<option value="utf8_croatian_mysql561_ci" title="Croato">utf8_croatian_mysql561_ci</option>
																						<option value="utf8_czech_ci" title="Ceco, case-insensitive">utf8_czech_ci</option>
																						<option value="utf8_danish_ci" title="Danese, case-insensitive">utf8_danish_ci</option>
																						<option value="utf8_esperanto_ci" title="Esperanto, case-insensitive">utf8_esperanto_ci</option>
																						<option value="utf8_estonian_ci" title="Estone, case-insensitive">utf8_estonian_ci</option>
																						<option value="utf8_general_ci" title="Unicode (multilingua), case-insensitive">utf8_general_ci</option>
																						<option value="utf8_general_mysql500_ci" title="Unicode (multilingua)">utf8_general_mysql500_ci</option>
																						<option value="utf8_german2_ci" title="Tedesco (rubrica), case-insensitive">utf8_german2_ci</option>
																						<option value="utf8_hungarian_ci" title="Ungherese, case-insensitive">utf8_hungarian_ci</option>
																						<option value="utf8_icelandic_ci" title="Islandese, case-insensitive">utf8_icelandic_ci</option>
																						<option value="utf8_latvian_ci" title="Lituano, case-insensitive">utf8_latvian_ci</option>
																						<option value="utf8_lithuanian_ci" title="Lituano, case-insensitive">utf8_lithuanian_ci</option>
																						<option value="utf8_myanmar_ci" title="sconosciuto, case-insensitive">utf8_myanmar_ci</option>
																						<option value="utf8_persian_ci" title="Persiano, case-insensitive">utf8_persian_ci</option>
																						<option value="utf8_polish_ci" title="Polacco, case-insensitive">utf8_polish_ci</option>
																						<option value="utf8_roman_ci" title="Europeo Occidentale, case-insensitive">utf8_roman_ci</option>
																						<option value="utf8_romanian_ci" title="Rumeno, case-insensitive">utf8_romanian_ci</option>
																						<option value="utf8_sinhala_ci" title="Cingalese, case-insensitive">utf8_sinhala_ci</option>
																						<option value="utf8_slovak_ci" title="Slovacco, case-insensitive">utf8_slovak_ci</option>
																						<option value="utf8_slovenian_ci" title="Sloveno, case-insensitive">utf8_slovenian_ci</option>
																						<option value="utf8_spanish2_ci" title="Spagnolo tradizionale, case-insensitive">utf8_spanish2_ci</option>
																						<option value="utf8_spanish_ci" title="Spagnolo, case-insensitive">utf8_spanish_ci</option>
																						<option value="utf8_swedish_ci" title="Svedese, case-insensitive">utf8_swedish_ci</option>
																						<option value="utf8_thai_520_w2" title="Thai">utf8_thai_520_w2</option>
																						<option value="utf8_turkish_ci" title="Turco, case-insensitive">utf8_turkish_ci</option>
																						<option value="utf8_unicode_520_ci" title="Unicode (multilingua)">utf8_unicode_520_ci</option>
																						<option value="utf8_unicode_ci" title="Unicode (multilingua), case-insensitive">utf8_unicode_ci</option>
																						<option value="utf8_vietnamese_ci" title="Vietnamese, case-insensitive">utf8_vietnamese_ci</option>
																						</optgroup>
																						<optgroup label="utf8mb4" title="UTF-8 Unicode">
																						<option value="utf8mb4_bin" title="Unicode (multilingua), Binario">utf8mb4_bin</option>
																						<option value="utf8mb4_croatian_ci" title="Croato, case-insensitive">utf8mb4_croatian_ci</option>
																						<option value="utf8mb4_croatian_mysql561_ci" title="Croato">utf8mb4_croatian_mysql561_ci</option>
																						<option value="utf8mb4_czech_ci" title="Ceco, case-insensitive">utf8mb4_czech_ci</option>
																						<option value="utf8mb4_danish_ci" title="Danese, case-insensitive">utf8mb4_danish_ci</option>
																						<option value="utf8mb4_esperanto_ci" title="Esperanto, case-insensitive">utf8mb4_esperanto_ci</option>
																						<option value="utf8mb4_estonian_ci" title="Estone, case-insensitive">utf8mb4_estonian_ci</option>
																						<option value="utf8mb4_general_ci" title="Unicode (multilingua), case-insensitive">utf8mb4_general_ci</option>
																						<option value="utf8mb4_german2_ci" title="Tedesco (rubrica), case-insensitive">utf8mb4_german2_ci</option>
																						<option value="utf8mb4_hungarian_ci" title="Ungherese, case-insensitive">utf8mb4_hungarian_ci</option>
																						<option value="utf8mb4_icelandic_ci" title="Islandese, case-insensitive">utf8mb4_icelandic_ci</option>
																						<option value="utf8mb4_latvian_ci" title="Lituano, case-insensitive">utf8mb4_latvian_ci</option>
																						<option value="utf8mb4_lithuanian_ci" title="Lituano, case-insensitive">utf8mb4_lithuanian_ci</option>
																						<option value="utf8mb4_myanmar_ci" title="sconosciuto, case-insensitive">utf8mb4_myanmar_ci</option>
																						<option value="utf8mb4_persian_ci" title="Persiano, case-insensitive">utf8mb4_persian_ci</option>
																						<option value="utf8mb4_polish_ci" title="Polacco, case-insensitive">utf8mb4_polish_ci</option>
																						<option value="utf8mb4_roman_ci" title="Europeo Occidentale, case-insensitive">utf8mb4_roman_ci</option>
																						<option value="utf8mb4_romanian_ci" title="Rumeno, case-insensitive">utf8mb4_romanian_ci</option>
																						<option value="utf8mb4_sinhala_ci" title="Cingalese, case-insensitive">utf8mb4_sinhala_ci</option>
																						<option value="utf8mb4_slovak_ci" title="Slovacco, case-insensitive">utf8mb4_slovak_ci</option>
																						<option value="utf8mb4_slovenian_ci" title="Sloveno, case-insensitive">utf8mb4_slovenian_ci</option>
																						<option value="utf8mb4_spanish2_ci" title="Spagnolo tradizionale, case-insensitive">utf8mb4_spanish2_ci</option>
																						<option value="utf8mb4_spanish_ci" title="Spagnolo, case-insensitive">utf8mb4_spanish_ci</option>
																						<option value="utf8mb4_swedish_ci" title="Svedese, case-insensitive">utf8mb4_swedish_ci</option>
																						<option value="utf8mb4_thai_520_w2" title="Thai">utf8mb4_thai_520_w2</option>
																						<option value="utf8mb4_turkish_ci" title="Turco, case-insensitive">utf8mb4_turkish_ci</option>
																						<option value="utf8mb4_unicode_520_ci" title="Unicode (multilingua)">utf8mb4_unicode_520_ci</option>
																						<option value="utf8mb4_unicode_ci" title="Unicode (multilingua), case-insensitive">utf8mb4_unicode_ci</option>
																						<option value="utf8mb4_vietnamese_ci" title="Vietnamese, case-insensitive">utf8mb4_vietnamese_ci</option>
																						</optgroup>
																					</select>
																			</div>
																	</div>
																</div>
																<button type="submit" class="btn btn-danger btn-fill pull-left" name="tablecreate">Create</button>
																<button type="reset" class="btn btn-default btn-fill pull-left">Close</button>

																</form>

														</div>

                            <div class="content table-responsive table-full-width">
														<h5 id="table-empty-<?php echo($db->getId()); ?>" class="empty-message">No tables are stored in <?php echo($db->getName()); ?></h5>
                                <table class="table table-hover table-striped dbtables" id="table-<?php echo($db->getId()); ?>">
                                    <thead>
																			<th>ID</th>
                                    	<th>Name</th>
                                    	<th>Encoding</th>
                                    	<th>Total Cols</th>
																			<th>Actions</th>
                                    </thead>
                                    <tbody>
																			<?php
																			 	foreach($db->getTables() as $table){
																		 	?>
                                        <tr>
																					<td><?php echo($table->getId());?></td>
                                        	<td><?php echo($table->getName());?></td>
                                        	<td><?php echo($table->getCharEncoding());?></td>
                                        	<td><?php echo($table->getColsNumber());?></td>
																					<td>
																						<button type="button" class="btn btn-info"><i class="fa fa-edit"></i></button>
																						<button type="button" class="btn btn-warning showcol" id="showcol-<?php echo($table->getId());?>"  data-db="tbdb-<?php echo($db->getId())?>"><i class="fa fa-eye"></i></button>
																						<button type="button" class="btn btn-danger" onclick="demo.showNotificationM('top','center','Are you sure you want to delete <b><?php echo($table->getName());?></b>?', 'Yes','?action=delete&type=table&id=<?php echo($table->getId());?>', 'pe-7s-alarm', 'warning', 1000)"><i class="fa fa-trash"></i></button>
																					</td>
                                        </tr>
																				<?php
																					}
																				 ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

								<?php
									}
								?>
								<?php
									foreach($udbs as $db){
											foreach($db->getTables() as $table){
								?>
										<div class="col-md-12 db-cols" id="colstable-<?php echo($table->getId()); ?>">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><b><?php echo($db->getName()); ?></b> - <b><?php echo($table->getName()); ?></b> - Structure</h4>
                                <p class="category">a view of all columns in <b><?php echo($db->getName()); ?></b> - <b><?php echo($table->getName()); ?></b></p><br>
																<button type="button" class="btn btn-default returntable" id="returntable-<?php echo($db->getId()); ?>" data-col="close-<?php echo($table->getId()); ?>"><?php echo($db->getName()); ?> Tables</button>
																<button type="button" class="btn btn-default add-col" id="addcol-<?php echo($table->getId()); ?>">Add</button>
																<button type="button" class="btn btn-default"><i class="fa fa-refresh"></i></button>

																<form style="margin-bottom: 7em;" method="post" class="add-col-form" id="add-col-form-<?php echo($table->getId()); ?>">
																<div class="row" style="margin-top:2em;">


																	<div class="col-md-2">
																			<div class="form-group">
																					<label>Name</label>
																					<input type="text" class="form-control" name="colname" placeholder="insert Table name" value="">
																			</div>
																	</div>
																	<div class="col-md-2">
																			<div class="form-group">
																				<label>Type</label>
																				<select class="form-control" name="coltype">
																					<optgroup label="Numbers" title="Numbers">
																						<option value="TINYINT">TINYINT</option>
																						<option value="SMALLINT">MALLINT</option>
																						<option value="MEDIUMINT">MEDIUMINT</option>
																						<option value="INT">INT</option>
																						<option value="BIGINT">BIGINT</option>
																						<option value="FLOAT">FLOAT</option>
																						<option value="DOUBLE">DOUBLE</option>
																						<option value="DECIMAL">DECIMAL</option>
																					</optgroup>
																					<optgroup label="Strings" title="Strings">
																						<option value="BIT">BIT</option>
																						<option value="CHAR">CHAR</option>
																						<option value="VARCHAR">VARCHAR</option>
																						<option value="TINYTEXT">TINYTEXT</option>
																						<option value="TEXT">TEXT</option>
																						<option value="MEDIUMTEXT">MEDIUMTEXT</option>
																						<option value="LONGTEXT">LONGTEXT</option>
																						<option value="BINARY">BINARY</option>
																						<option value="VARBINARY">VARBINARY</option>
																						<option value="TINYBLOB">TINYBLOB</option>
																						<option value="BLOB">BLOB</option>
																						<option value="MEDIUMBLOB">MEDIUMBLOB</option>
																						<option value="LONGBLOB">LONGBLOB</option>
																						<option value="ENUM">ENUM</option>
																						<option value="SET">SET</option>
																					</optgroup>
																					<optgroup label="Date and Time" title="Date and Time">
																						<option value="DATE">DATE</option>
																						<option value="DATETIME">DATETIME</option>
																						<option value="TIME">TIME</option>
																						<option value="TIMESTAMP">TIMESTAMP</option>
																						<option value="YEAR">YEAR</option>
																				</optgroup>
																				</select>
																			</div>
																	</div>
																	<div class="col-md-1">
																			<div class="form-group">
																				<label>Lenght</label>
																				<input type="number" name="collength" class="form-control" placeholder="specify how much filed" value="12" min="0">
																			</div>
																	</div>
																	<div class="col-md-1">
																			<div class="form-group">
																				<label>Attributes</label>
																				<select class="form-control" name="colattributes">
																					<option value="BINARY">BINARY</option>
																					<option value="UNSIGNED" selected>UNSIGNED</option>
																					<option value="UNSIGNED ZEROFILL">UNSIGNED ZEROFILL</option>
																					<option value="on update CURRENT_TIMESTAMP">on update CURRENT_TIMESTAMP</option>
																				</select>
																			</div>
																	</div>
																	<div class="col-md-1">
																			<div class="form-group">
																				<label>NULL</label>
																				<select class="form-control" name="colnull">
																					<option value="1">Yes</option>
																					<option value="0" selected>No</option>
																				</select>
																			</div>
																	</div>
																	<div class="col-md-1">
																			<div class="form-group">
																				<label>Autoinc.</label>
																				<select class="form-control" name="colautoincrement">
																					<option value="1">Yes</option>
																					<option value="0" selected>No</option>
																				</select>
																			</div>
																	</div>
																	<div class="col-md-2">
																			<div class="form-group">
																				<label>Index</label>
																				<select class="form-control" name="colindex" >
																					<option value="PRIMARY">Primary</option>
																					<option value="UNIQUE" selected>Unique</option>
																					<option value="INDEX" selected>Index</option>
																					<option value="FULLTEXT" selected>FullText</option>
																					<option value="SPATIAL" selected>Spatial</option>
																				</select>
																			</div>
																	</div>
																	<div class="col-md-2">
																			<div class="form-group">
																					<label>Comments</label>
																					<input type="text" class="form-control" placeholder="insert comment" name="colcomments" value="">
																			</div>
																	</div>

																</div>
																<input type="hidden" name="dbid" value="<?php echo($db->getId());?>">
																<input type="hidden" name="tableid" value="<?php echo($table->getId());?>">
																<button type="submit" class="btn btn-danger btn-fill pull-left" name="colcreate">Create</button>
																<button type="reset" class="btn btn-default btn-fill pull-left">Close</button>

																</form>

														</div>
                            <div class="content table-responsive table-full-width">
															<h5 id="col-empty-<?php echo($table->getId()); ?>" class="empty-message">No columns are stored in <?php echo($db->getName() . " - " . $table->getName()); ?> </h5>
                                <table class="table table-hover table-striped coltable" id="col-<?php echo($table->getId());?>">
                                    <thead>
                                    	<th>Name</th>
                                    	<th>Type</th>
																			<th>length</th>
                                    	<th>Attributes</th>
																			<th>Null</th>
																			<th>Autoincrement</th>
																			<th>Index</th>
																			<th>Comments</th>
																			<th>Extra</th>
																			<th>Actions</th>
                                    </thead>
                                    <tbody>
																			<?php
																			foreach($table->getColumns() as $col){
																				?>
                                        <tr>
                                        	<td><?php echo($col->getName()); ?></td>
                                        	<td><?php echo($col->getType()); ?></td>
                                        	<td><?php echo($col->getLength()); ?></td>
																					<td><?php echo($col->getAttributes()); ?></td>
																					<td>
																						<?php
																							if($col->isNull()){
																								echo('<i class="fa fa-check"></i>');
																							}
																						?>
																					</td>
																					<td>
																						<?php
																							if($col->isAutoincrement()){
																								echo('<i class="fa fa-check"></i>');
																							}
																						?>
																					</td>
																					<td>
																						<?php
																							if($col->isPrimary()){
																								echo('Primary');
																							}else if($col->isUnique()){
																								echo('Unique');
																							}
																						?>
																					</td>
																					<td><?php echo($col->getComments()); ?></td>
																					<td>nope</td>
																					<td>
																						<button type="button" class="btn btn-info"><i class="fa fa-edit"></i></button>
																						<button type="button" class="btn btn-danger" onclick="demo.showNotificationM('top','center','Are you sure you want to delete column <b><?php echo($col->getName()); ?></b>?', 'Yes','?action=delete&type=col&id=<?php echo($col->getId()); ?>', 'pe-7s-alarm', 'warning', 1000)"><i class="fa fa-trash"></i></button>
																					</td>
                                        </tr>
																				<?php
																			}
																			?>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
										<?php
									}
								}?>

<!--										<div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><b>Db1</b> - <b>Users</b> - Data</h4>
                                <p class="category">a view of all your databases</p><br>
																<button type="button" class="btn btn-default">Add</button>
																<button type="button" class="btn btn-default"><i class="fa fa-refresh"></i></button>

                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                      <th>ID</th>
                                    	<th>Name</th>
                                    	<th>Surname</th>
                                    	<th>Email</th>
                                    	<th>Telehpone</th>
																			<th>Password</th>
																			<th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <tr>
																					<td>1</td>
                                        	<td>Marzio</td>
                                        	<td>Monticelli</td>
                                        	<td>marzio.monticelli@gmail.com</td>
																					<td>3935058329</td>
                                        	<td>fdskfop32rfdspsèf3</td>
																					<td>
																						<button type="button" class="btn btn-info"><i class="fa fa-edit"></i></button>
																						<button type="button" class="btn btn-danger" onclick="demo.showNotificationM('top','center','Are you sure you want to delete <b>Db1</b>?', 'Yes','dashboard.php', 'pe-7s-alarm', 'warning', 1000)"><i class="fa fa-trash"></i></button>
																						<button type="button" class="btn btn-default" onclick="demo.showNotificationM('top','center','Export of <b>Db1</b> will start in few second, please wait.', '','', 'pe-7s-download','info', 200)"><i class="fa fa-floppy-o"></i></button>
																					</td>
                                        </tr>
																				<tr>
																					<td>2</td>
                                        	<td>Marzio</td>
                                        	<td>Monticelli</td>
                                        	<td>marzio.monticelli@gmail.com</td>
																					<td>3935058329</td>
                                        	<td>fdskfop32rfdspsèf3</td>
																					<td>
																						<button type="button" class="btn btn-info"><i class="fa fa-edit"></i></button>
																						<button type="button" class="btn btn-danger" onclick="demo.showNotificationM('top','center','Are you sure you want to delete <b>Db1</b>?', 'Yes','dashboard.php', 'pe-7s-alarm', 'warning', 1000)"><i class="fa fa-trash"></i></button>
																						<button type="button" class="btn btn-default" onclick="demo.showNotificationM('top','center','Export of <b>Db1</b> will start in few second, please wait.', '','', 'pe-7s-download','info', 200)"><i class="fa fa-floppy-o"></i></button>
																					</td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
									-->

										<!--
                    <div class="col-md-12">
                        <div class="card card-plain">
                            <div class="header">
                                <h4 class="title">Table on Plain Background</h4>
                                <p class="category">Here is a subtitle for this table</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover">
                                    <thead>
                                        <th>ID</th>
                                    	<th>Name</th>
                                    	<th>Salary</th>
                                    	<th>Country</th>
                                    	<th>City</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        	<td>1</td>
                                        	<td>Dakota Rice</td>
                                        	<td>$36,738</td>
                                        	<td>Niger</td>
                                        	<td>Oud-Turnhout</td>
                                        </tr>
                                        <tr>
                                        	<td>2</td>
                                        	<td>Minerva Hooper</td>
                                        	<td>$23,789</td>
                                        	<td>Curaçao</td>
                                        	<td>Sinaai-Waas</td>
                                        </tr>
                                        <tr>
                                        	<td>3</td>
                                        	<td>Sage Rodriguez</td>
                                        	<td>$56,142</td>
                                        	<td>Netherlands</td>
                                        	<td>Baileux</td>
                                        </tr>
                                        <tr>
                                        	<td>4</td>
                                        	<td>Philip Chaney</td>
                                        	<td>$38,735</td>
                                        	<td>Korea, South</td>
                                        	<td>Overland Park</td>
                                        </tr>
                                        <tr>
                                        	<td>5</td>
                                        	<td>Doris Greene</td>
                                        	<td>$63,542</td>
                                        	<td>Malawi</td>
                                        	<td>Feldkirchen in Kärnten</td>
                                        </tr>
                                        <tr>
                                        	<td>6</td>
                                        	<td>Mason Porter</td>
                                        	<td>$78,615</td>
                                        	<td>Chile</td>
                                        	<td>Gloucester</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
									-->


                </div>
            </div>
        </div>

				<footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Sapienza
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Interactive Graphics
                            </a>
                        </li>
                        <li>
                            <a href="#">
                               Mobile Applications
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; 2017 <a href="#">Marzio Monticelli</a>, Sapienza, Master in Engineering in Computer Science
                </p>
            </div>
        </footer>


    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

	<script>
		$(document).ready(function(){
			var animation_speed = 50;
			$('#add-db-form').hide();
			$('#add-table-form').hide();
			$('#empty-message').hide();
			$('.db-tables').hide();
			$('.add-table-form').hide();
			$('.add-col-form').hide();
			$('.db-cols').hide();


			$('#add-db').click(function(){
				if($(this).hasClass("showed")){
					$('#add-db-form').hide(animation_speed);
					$(this).removeClass("showed");
					$(this).html("Add");
				}else{
					$('#add-db-form').show(animation_speed);
					$(this).addClass("showed");
					$(this).html("Hide");
				}
			});

			$('#add-table').click(function(){
				if($(this).hasClass("showed")){
					$('#add-table-form').hide(animation_speed);
					$(this).removeClass("showed");
					$(this).html("Add");
				}else{
					$('#add-table-form').show(animation_speed);
					$(this).addClass("showed");
					$(this).html("Hide");
				}
			});

			$('.add-col').click(function(){
				var id = getVarId($(this).attr("id"));
				if($(this).hasClass("showed")){
					$('#add-col-form-'+id).hide(animation_speed);
					$(this).removeClass("showed");
					$(this).html("Add");
				}else{
					$('#add-col-form-'+id).show(animation_speed);
					$(this).addClass("showed");
					$(this).html("Hide");
				}
			});

			if($("#db-table tbody tr").length == 0){
				$("#db-table").hide();
				$('#dbtable-empty').show();
			}else{
				$('#dbtable-empty').hide();
				$("#db-table").show();
			}

			$('.dbtables').each(function(index){
				var id = getVarId($(this).attr("id"));
				if($(this).children("tbody").children("tr").length==0){
					$('#table-'+id).hide();
					$('#table-empty-'+id).show();
				}else{
					$('#table-empty-'+id).hide();
				}
			});

			$('.coltable').each(function(index){
				var id = getVarId($(this).attr("id"));
				if($(this).children("tbody").children("tr").length==0){
					$('#col-'+id).hide();
					$('#col-empty-'+id).show();
				}else{
					$('#col-empty-'+id).hide();
				}
			});

			$('.show-view').click(function(){
				var view = $(this).attr("data-id");
				console.log(view);
				switch(view){
					case 'global':
					if($(this).hasClass("selected")){
						$('#databases').show(animation_speed);
						$('.db-tables').hide(animation_speed);
						$(this).removeClass("selected");
						$(this).addClass("btnselected");
						$(this).html("Global View");
					}else{
						$('#databases').show(animation_speed);
						$('.db-tables').show(animation_speed);
						$(this).addClass("selected");
						$(this).addClass("btnselected");
						$(this).html("Dbs View");
					}
					break;
					case 'database':
						$('.db-tables').hide(animation_speed);
						$('#databases').show(animation_speed);
					break;
					case 'tables':
						$('#databases').hide(animation_speed);
					break;
				}

			});

			$('.showtbdb').click(function(){
				var id = getVarId($(this).attr("id"));
				$('.db-tables').hide(animation_speed);
				$('#tables-'+id).show(animation_speed);
			});

			$(".add-table").click(function(){
				var id = getVarId($(this).attr("id"));
				$("#tableform-"+id).show(animation_speed);
				if($(this).hasClass("showed")){
					$("#tableform-"+id).hide(animation_speed);
					$(this).removeClass("showed");
					$(this).html("Add");
				}else{
					$("#tableform-"+id).show(animation_speed);
					$(this).addClass("showed");
					$(this).html("Hide");
				}
			});

		});

		$('.showcol').click(function(){
			var id = getVarId($(this).attr("id"));
			var dbid =  getVarId($(this).attr("data-db"));
			$('#tables-' + dbid).hide();
			$('#colstable-'+id).show();
			console.log("Show col " + id);
		});

		$('.returntable').click(function(){
			var dbid = getVarId($(this).attr("id"));
			$('#tables-' + dbid).show();
			var idc = getVarId($(this).attr("data-col"));
			$('#colstable-'+idc).hide();
		});


		function getVarId(field){
			var id = field;
			id = id.split("-");
			return id[1];
		}
	</script>


</html>
