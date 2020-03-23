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

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>3dB - User Profile</title>

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
							<li class="active">
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
									<a class="navbar-brand" href="profile.php">My Account</a>
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Profile</h4>
                            </div>
                            <div class="content">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Company (disabled)</label>
                                                <input type="text" class="form-control" disabled placeholder="Company" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Username(disabled)</label>
                                                <input type="text" class="form-control" disabled placeholder="Username" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Education(disabled)</label>
                                                <input type="text" disabled class="form-control" placeholder="Education">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Company" value="<?php echo($user->getName()); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" id="surname" name="surname" placeholder="Last Name" value="<?php echo($user->getSurname()); ?>">
                                            </div>
                                        </div>
                                    </div>

																		<div class="row">
																			<div class="col-md-6">
																					<div class="form-group">
																							<label>Email</label>
																							<input type="email" class="form-control" id="email" name="email" placeholder="insert your email" value="<?php echo($user->getEmail()); ?>" disabled>
																					</div>
																			</div>
																			<div class="col-md-6">
																					<div class="form-group">
																							<label>Password</label>
																							<input type="password" class="form-control" id="password" name="password" placeholder="your password" value="mycriptedpass">
																					</div>
																			</div>
																		</div>

																		<div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About Me</label>
                                                <textarea rows="5" class="form-control" placeholder="Here can be your description" id="description" name="description"><?php
																										if($user->getDescription()){
																											echo($user->getDescription());
																										}else{
																											echo("insert a short description can describe you");
																										}
																									?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address(disabled)</label>
                                                <input type="text" class="form-control" disabled placeholder="Home Address" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City(disabled)</label>
                                                <input type="text" class="form-control" disabled placeholder="City" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Country(disabled)</label>
                                                <input type="text" class="form-control" disabled placeholder="Country" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code(disabled)</label>
                                                <input type="number" disabled class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>


																		<button type="reset" class="btn btn-default btn-fill pull-right">Reset</button>
                                    <button type="submit" class="btn btn-danger btn-fill pull-right" name="update_profile" id="update_profile">Update Profile</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="image">
                                <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400" alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author">
                                     <a href="#">
                                    <img class="avatar border-gray" src="assets/img/faces/face-0.jpg" alt="..."/>

                                      <h4 class="title"><?php echo($user->getName()." ".$user->getSurname()); ?><br />
                                         <!--<small>michael24</small>-->
                                      </h4>
                                    </a>
                                </div>
                                <p class="description text-center"> <?php
																	if($user->getDescription()){
																		echo($user->getDescription());
																	}else{
																		echo("insert a short description can describe you");
																	}
																?>
                                </p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <button href="#" class="btn btn-simple"><i class="fa fa-facebook-square"></i></button>
                                <button href="#" class="btn btn-simple"><i class="fa fa-twitter"></i></button>
                                <button href="#" class="btn btn-simple"><i class="fa fa-google-plus-square"></i></button>

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

</html>
