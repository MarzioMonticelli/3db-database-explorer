<?php
require_once("controllers/RegistrationController.php");
require_once("controllers/AuthController.php");


$error = null;
$message = null;
$dac = new AuthController();
$auth = $dac->isAuth();

// login attempt
if(isset($_POST["log-in"])){
	$ac = new AuthController($_POST, "POST");
	$a = $ac->login();
	if($a){
		$message = 'Login successfull';
		header("Location: admin/profile.php");
	}else{
		$error = $ac->getLastError();
		$auth = false;
	}
}else if(isset($_POST["registration"])){
	$rc = new RegistratioNController($_POST, "POST");
	$pr = $rc->process();
	if($pr){
		$message = 'Now you can make the <a data-toggle="modal" data-target="#loginModal">login</a>';
	}else{
		$error = $rc->getLastError();
	}

}else if(isset($_POST["btn-logout"])){
	$dac->logout();
	$auth = $dac->isAuth();
}


function filter($data) { //Filters data against security risks.
    return $data;
}

?>

<!DOCTYPE HTML>
<!--
	Directive by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>3dB - 3D Database Manager</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<style>
			.modal-header{
				background-color:#FF4A55;
				color:#fff;
			}
			.modal-header .close{
				color:#fff;
			}
			.modal-content{
				border-radius: 0px;
				margin-top: 100px;
			}

			.fixed-header{
				min-height: 60px;
				background-color: rgba(0,0,0,0.9);
				color:#fff;
				padding-top: 10px;
				position:fixed;
				z-index: 99999999;
			}
			.user-img{
				height: 40px;
				border-radius:40px;
			}
			.logo-brand{
				height: 40px;
			}
		</style>

	</head>
	<body>


		<!-- Modals -->
		<div id="errModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Oops, something went wrong!</h4>
		      </div>
		      <div class="modal-body">
		        <p>
							<?php
							if(isset($error)){
								echo($error);
							}
							?>
						</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>

		  </div>
		</div>

		<div id="infoModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Great!</h4>
		      </div>
		      <div class="modal-body">
		        <p>
							<?php
							if(isset($message)){
								echo($message);
							}
							?>
						</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>

		  </div>
		</div>

		<div id="loginModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Login</h4>
		      </div>
		      <div class="modal-body">
						<form method="post">
							<div class="row">
								<div class="col-md-6">
									<label for="email">Email</label>
									<input class="text" type="text" name="log_email" id="log_email" value="" placeholder="youremail@domain.tld" required />
								</div>
								<div class="col-md-6">
									<label for="email">Password</label>
									<input class="text" type="password" name="log_password" id="log_password" value="" required />
								</div>
							</div>
							<div class="row" style="margin-top:2px;">
								<div class="col-md-12">
									<ul class="actions">
										<li><input type="submit" value="Send" /></li>
										<li><input type="reset" value="Reset" class="alt" /></li>
										<input type="hidden" name="log-in" id="log-in" value="1" />
									</ul>
								</div>
							</div>
						</form>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>

		  </div>
		</div>
	</div>
		<!-- Header -->
			<div class="col-md-12 fixed-header">
				<div class="row">
					<div class="col-md-10">
						<a href="index.php" alt="home">
							<img src="images/3dblogo.png" class="logo-brand" alt="home">
						</a>
					</div>
					<div class="col-md-1">
						<a href="admin/profile.php" alt="profile" id="user-profile">
							<img src="admin/assets/img/default-avatar.png" alt="profile" class="user-img">
						</a>
					</div>
					<div class="col-md-1">
						<form method="post" style="margin:0px!important;">
							<button type="submit" class="btn btn-danger" id="btn-logout" name="btn-logout">Logout</button>
						</form>
						<button class="btn btn-danger" id="btn-login" data-toggle="modal" data-target="#loginModal">Login</button>
					</div>
				</div>
			</div>
			<div id="header">

        <img src="images/3dblogo.png" class="logo">
				<h1>Experimental <b style="color:#e0071c;">3D</b><br>Database Manager</h1>
			</div>

		<!-- Main -->
			<div id="main">

				<header class="major container 75%">
					<h2>
            <a href="#">Android App</a><br>
            <a href="#">Web App</a><br>
            <a href="#">3D Experience</a><br>
            <a href="#">APIs</a><br>
          </h2>
					<!--
					<p>Tellus erat mauris ipsum fermentum<br />
					etiam vivamus nunc nibh morbi.</p>
					-->
				</header>

				<div class="box alt container">
					<section class="feature left">
						<a href="#" class="image icon fa-cube"><img src="images/pic01.jpg" alt="" /></a>
						<div class="content">
							<h3>3D Experience</h3>
							<p>in the experimental 3D experience you can navigate your database in a 3D space with a simple and customizable interface.  You can move tables and change informations
directly in the 3D  representation of your data space.</p>
						</div>
					</section>
					<section class="feature right">
						<a href="#" class="image icon fa-code"><img src="images/pic02.jpg" alt="" /></a>
						<div class="content">
							<h3>Web App</h3>
							<p>Inside the web application you can insert new databases thorough simple interfaces and manage each single database by adding, deleting or modifing columns informations.  You can easily see how information is distributed in your databases.</p>
						</div>
					</section>
					<section class="feature left">
						<a href="#" class="image icon fa-mobile"><img src="images/pic03.jpg" alt="" /></a>
						<div class="content">
							<h3>Android App</h3>
							<p>Through the adroid application you can see all informations about your account and database, manage and check the state of your data. As well as the web app you can see informations about how data is distributed and so on. </p>
						</div>
					</section>
				</div>


				<div class="box container">
					<section>
						<header>
							<h3>Registration</h3>
              <p style="margin-top:30px;">After the registration you will receive an email to confirm your data. Through your future account you will be able to access to: web app, android app and the 3D experience </p>
						</header>
						<form method="post">
							<div class="row">
								<div class="6u 12u(mobilep)">
									<label for="name">Name</label>
									<input class="text" type="text" name="name" id="name" value="" placeholder="type your name"  required />
								</div>
                <div class="6u 12u(mobilep)">
									<label for="name">Surname</label>
									<input class="text" type="text" name="surname" id="surname" value="" placeholder="type your surname" required />
								</div>
							</div>
              <div class="row">
                <div class="6u 12u(mobilep)">
									<label for="email">Email</label>
									<input class="text" type="text" name="email" id="email" value="" placeholder="youremail@domain.tld" required />
								</div>
                <div class="6u 12u(mobilep)">
									<label for="email">Password</label>
									<input class="text" type="password" name="password" id="password" value="" required />
								</div>
              </div>
							<div class="row">
								<div class="12u">
									<ul class="actions">
										<li><input type="submit" value="Send" /></li>
										<li><input type="reset" value="Reset" class="alt" /></li>
										<input type="hidden" name="registration" id="registration" value="1"/>
									</ul>
								</div>
							</div>
						</form>
					</section>
				</div>


				<footer class="major container 75%">
					<h3>Have you an Account?</h3>
					<p>If you have already registered an account you can use this service direcly. Please </p>
					<ul class="actions">
						<li><a class="button" data-toggle="modal" data-target="#loginModal" style="color:#ffffff;">Login</a></li>
					</ul>
				</footer>

			</div>

		<!-- Footer -->
			<div id="footer">
				<div class="container 75%">
					<header class="major last">
            <img src="images/3dblogo.png" class="logo">
						<h2>3Db Project</h2>
					</header>

					<p>3dB it’s an experimental project  designed and developed by <a href="#"><b>Marzio Monticelli</b></a> for the final examination of  <a href="#"><b>Interactive Graphics</b></a> and <a href="#"><b>Mobile Application and Cloud computing</b></a> couses.  It is realized for <a href="#"><b>Sapienza, University of Rome</b></a>, during the <a href="#"><b>Master of Science in Engineering in Computer Science</b></a>.</p>

					<form method="post" action="#">
						<div class="row">
							<div class="6u 12u(mobilep)">
								<input type="text" name="name" placeholder="Name" />
							</div>
							<div class="6u 12u(mobilep)">
								<input type="email" name="email" placeholder="Email" />
							</div>
						</div>
						<div class="row">
							<div class="12u">
								<textarea name="message" placeholder="Message" rows="6"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="12u">
								<ul class="actions">
									<li><input type="submit" value="Send Message" /></li>
								</ul>
							</div>
						</div>
					</form>

					<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
						<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
					</ul>

					<ul class="copyright">
						<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>

				</div>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

			<script>
				$(document).ready(function(){
					<?php
						if($auth!= null){
							if($auth){
								?>
								$('#user-profile').show();
								$('#btn-logout').show();
								$('#btn-login').hide();
								<?php
							}else{
								?>
								$('#user-profile').hide();
								$('#btn-logout').hide();
								$('#btn-login').show();
								<?php
							}
						}else{
							?>
							$('#user-profile').hide();
							$('#btn-logout').hide();
							$('#btn-login').show();
							<?php
						}
					?>

					<?php
					if($error!=null){
						?>
						$("#errModal").modal("show");
					<?php
					}else if($message!=null){
						?>
						$("#infoModal").modal("show");
					<?php
					}
					?>

				});
			</script>

	</body>
</html>
