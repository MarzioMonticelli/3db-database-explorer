<?php
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/admin/auth/checkAuth.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/controllers/UserController.php");

$e = $AuthController->getAuthUser();
$user = null;

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

$user_logs = UserController::getAllUserLogs($e);

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>3dB - Dashboard</title>

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
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

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
                <li class="active">
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
                <li>
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

							<!--
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Email Statistics</h4>
                                <p class="category">Last Campaign Performance</p>
                            </div>
                            <div class="content">
                                <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Bounce
                                        <i class="fa fa-circle text-warning"></i> Unsubscribe
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-clock-o"></i> Campaign sent 2 days ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Users Behavior</h4>
                                <p class="category">24 Hours performance</p>
                            </div>
                            <div class="content">
                                <div id="chartHours" class="ct-chart"></div>
                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Click
                                        <i class="fa fa-circle text-warning"></i> Click Second Time
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Updated 3 minutes ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
							-->


                <div class="row">
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">Databases size</h4>
                                <p class="category">in order to number of tables</p>
                            </div>
                            <div class="content">
                                <div id="chartActivity" class="ct-chart"></div>

                                <div class="footer">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Db1
                                        <i class="fa fa-circle text-danger"></i> Db2
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-check"></i> See <a href="databases.php">Databases</a> for more informations about
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title">History</h4>
                                <p class="category">all recorded anctions on platform</p>
                            </div>
                            <div class="content">
                                <div class="table-full-width" style="max-height: 400px; overflow:auto;">
                                    <table class="table">
                                        <tbody>
																					<?php
																						foreach($user_logs as $ul){
																							$ult = $ul->getType();
																							$lev = (int)$ul->getLevel();
																							if($ult == "USE"){
																								if($lev <=2){
																									?>
																										<tr class="info">
																									<?php
																								}else if($lev <= 4){
																									?>
																										<tr class="warning">
																									<?php
																								}else if($lev>4){
																									 ?>
																										<tr class="danger">
																									<?php
																								}
																								?>
		                                                <td>
		                                                    <i class="fa fa-user">
		                                                </td>
		                                                <td><?php echo($ul->getTime()); ?> <b><?php echo($ul->getInfo()); ?></b></td>

		                                                <td class="td-actions text-right">
																											<i class="fa fa-cogs">
		                                                </td>
		                                            </tr>
																								<?php
																							}else if($ult == "ACC"){
																								if($lev <=2){
																									?>
																										<tr class="info">
																									<?php
																								}else if($lev <= 4){
																									?>
																										<tr class="warning">
																									<?php
																								}else if($lev>4){
																									?>
																										<tr class="danger">
																									<?php
																								}
																								?>
		                                                <td>
		                                                    <i class="fa fa-user">
		                                                </td>
		                                                <td><?php echo($ul->getTime()); ?> <b><?php echo($ul->getInfo()); ?> </b></td>

		                                                <td class="td-actions text-right">
																											<i class="fa fa-key">
		                                                </td>
		                                            </tr>
																								<?php
																							}else if($ult == "DAT"){
																								if($lev <=2){
																									?>
																										<tr class="info">
																									<?php
																								}else if($lev <= 4){
																									?>
																										<tr class="warning">
																									<?php
																								}else if($lev>4){
																									?>
																										<tr class="danger">
																									<?php
																								}
																								?>
		                                                <td>
		                                                    <i class="fa fa-database">
		                                                </td>
		                                                <td><?php echo($ul->getTime()); ?> <b> <?php echo($ul->getInfo()); ?> </b></td>

		                                                <td class="td-actions text-right">
																											<i class="fa fa-cogs">
		                                                </td>
		                                            </tr>
																								<?php
																							}else if($ult == "3D"){
																								if($lev <=2){
																									?>
																										<tr class="info">
																									<?php
																								}else if($lev <= 4){
																									?>
																										<tr class="warning">
																									<?php
																								}else if($lev>4){
																									?>
																										<tr class="danger">
																									<?php
																								}
																								?>
		                                                <td>
		                                                    <i class="fa fa-cube">
		                                                </td>
		                                                <td><?php echo($ul->getTime()); ?> <b> <?php echo($ul->getInfo()); ?></b></td>

		                                                <td class="td-actions text-right">
																											<i class="fa fa-cogs">
		                                                </td>
		                                            </tr>
																								<?php

																							}

																						}
																					?>

                                            <!--
                                            <tr>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="" data-toggle="checkbox">
                                                    </label>
                                                </td>
                                                <td>Unfollow 5 enemies from twitter</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
																					-->
                                        </tbody>
                                    </table>
                                </div>

                                <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Updated: <?php echo(date("d/m/Y - h:i ")); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

	<script type="text/javascript">
    	$(document).ready(function(){

        	demo.initChartist();

        	$.notify({
            	icon: 'pe-7s-smile',
            	message: "Welcome to <b>3dB</b> an experimental project for 3D Database Managing."

            },{
                type: 'danger',
                timer: 4000
            });

    	});
	</script>

</html>
