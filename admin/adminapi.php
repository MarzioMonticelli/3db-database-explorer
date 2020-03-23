<?php
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/admin/auth/checkAuth.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/controllers/UserController.php");

$e = $AuthController->getAuthUser();
$user = null;

if($e){
	$user = UserController::getUser($e);
}else{
	$AuthController->logout();
	header("Location: http://localhost/3dB/");
}

if(isset($_POST["logout"])){
	$AuthController->logout();
	header("Location: http://localhost/3dB/");
}

$user_logs = UserController::getAllUserLogs($e);
$user_apikey = new Apikey($e);
$user_apikey->load();

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
				<li class="active">
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
					<a class="navbar-brand" href="#">APIs</a>
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
			<div class="col-md-8 col-md-offset-2">
				<div class="card">
					<div class="header text-center">
						<h4 class="title">Open Api you can use</h4>
						<br>
						<p class="category">Your api key is <input type="text" value="<?php echo($user_apikey->getKey()); ?>" disabled></p>
						<br>
						<p class="text-danger" id="test-message"> message from text</p>
						<br>
					</div>
					<div class="content table-responsive table-full-width table-upgrade">
						<table class="table">
							<thead>
								<th>REQUEST</th>
								<th class="text-center">Method</th>
								<th class="text-center">Response</th>
								<th class="text-center">Test</th>
							</thead>
							<tbody>
								<tr>
									<td>api/api.php/central/users/single/user_email</td>
									<td>GET</td>
									<td>JSON<br> retrieve all the information relative to user_email</td>
									<td style="text-align:center;"><button class="btn btn-disabled" disabeld>Test it</button></td>
								</tr>
								<tr>
									<td>api/api.php/central/users/all</td>
									<td>GET</td>
									<td>JSON<br> retrieve all users</td>
									<td style="text-align:center;"><button class="btn btn-disabled" disabeld>Test it</button></td>
								</tr>
							</tbody>
						</table>

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

		$('#test-message').hide();
		
		/* 	TEST PRUPOSE ONLY
		$.get("http://localhost/3dB/api/api.php", {
			apikey: "<?php echo($user_apikey->getKey()); ?>",
			request: "users/central/single/marzio.monticelli@gmail.com"})
			.done (function(data){
				console.log("DONE");
				console.log(typeof data);
				console.log(data);
			})
			.error(function(data){
				console.log("SOME ERROR:");
				console.log(data);
			});

		$.post("http://localhost/3dB/api/api.php", {
			apikey: "<?php echo($user_apikey->getKey()); ?>",
			request: "Object3D/central/57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5/0/13.42/43.23/23.56/materal1/1.0/texturedaapi/database"})
			.done(function(data){
				console.log("UPDATED??");
				console.log(data);
			});
		*/
	});
</script>

</html>
