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

$user_logs = UserController::getAllUserLogs($e);
$user_apikey = new Apikey($e);
$user_apikey->load();

if($user!=null && isset($dbcontroller)){
	$udbs = $dbcontroller->getUserDb($user->getEmail());
}

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
		<style>
		/* additional styles */

		.main-panel{
			overflow-x: hidden;
		}
		.li-selected{
			text-decoration: overline;
		}
		.model-info{
			width: 300px;
			height: auto;
			border-color: #000;
			border:1px;
			z-index: 9999999;
			background-color: rgba(251, 64, 75,0.8);
			color:#fff;
			text-align: center;
			position: absolute;
			padding:10px;
			border-radius: 10px;
			border:1px solid #ffffff;
			font-family:"Roboto","Helvetica Neue",Arial,sans-serif;
			-webkit-box-shadow: 20px 28px 63px -3px rgba(0,0,0,0.28);
			-moz-box-shadow: 20px 28px 63px -3px rgba(0,0,0,0.28);
			box-shadow: 20px 28px 63px -3px rgba(0,0,0,0.28);
			margin-top: 300px;
			margin-left: 300px;
		}
		.model-info .title{
			text-transform:uppercase;
		}
		.info_val{
			color:#ffc299;
		}
		.text-left{
			text-align: left;
		}

		.dbdetails{
			border-radius: 0px;
			padding-right: 20px;
			margin-top: 112px;
			background-color:rgba(56,56,56,0.8);
		}
		.dbdetails ul{
			list-style: none;
			text-align: left;
			font-size: 16px;
			max-height:auto;
			overflow:auto;
			padding-left: 10px;
		}
		.dbdetails a{
			color:#fff;
		}
		.dbdetails ul li{
			padding-left: 15px;
			line-height: 30px;
			height: 30px;
		}
		.dbdetails ul li:hover, .dbdetails ul li a:hover{
			background-color: #fff;
			color:#FB404B;
		}

		#speed-precision{
			margin-left: 800px;
			margin-top: 80px;
		}
		#object-informations{
			width: 350px;
			padding:20px;
		}
		#loader{
			width: 100%;
			height: 100%;
			z-index: 9999999;
			background-color: #fff;
			text-align: center;
			position: absolute;
			color:#FF4A55;
		}
		#loader h4{
			color:#FF4A55;
		}
		</style>
</head>
<body>

<div id="loader">
	<img src="https://i.pinimg.com/originals/05/74/15/05741525b70c7ca6bcb88afd4aa16632.gif" alt="loading"/>
	<h4>Loading...</h4>
</div>
<div class="model-info" id="speed-precision">
	<div class="row">
		<h5 class="col-md-12 title">Speed and Precision</h5>
		<p class="col-md-2"><b>Speed:</b></p><p class="col-md-4"><b class="info_val" id="val-speed">10</b></p>
		<p class="col-md-2"><b>Prec.:</b></p><p class="col-md-4"><b class="info_val" id="val-precision">100</b></p>
	</div>
</div>
<div class="model-info" id="object-informations">
	<div class="row">
			<h5 class="col-md-12 title" id="val-name">Model Name</h5>
			<p class="col-md-2"><b>x:</b></p><p class="col-md-4"><b class="info_val" id="val-x">123.453</b></p>
			<p class="col-md-2"><b>y:</b></p><p class="col-md-4"><b class="info_val" id="val-y">23.453</b></p>
			<p class="col-md-2"><b>z:</b></p><p class="col-md-4"><b class="info_val" id="val-z">203.453</b></p>
			<p class="col-md-2"><b>alfa:</b></p><p class="col-md-4"><b class="info_val" id="val-alfa">1.0</b></p>
			<div class="row">
				<p class="col-md-6"><b>Material:</b></p>
				<select class="col-md-4 info-val" id="val-material"  style="color:#000">
				  <option value="0">Basic</option>
				  <option value="1">Depth</option>
				  <option value="2">Lambert</option>
				  <option value="3">Normal</option>
					<option value="4">Phong</option>
					<option value="5">Standard</option>
				</select>
			</div>
			<div class="row">
				<p class="col-md-6"><b>Texture:</b></p>
				<select class="col-md-4 info-val"  id="val-texture" style="color:#000">
				  <option value="0">Texture0</option>
				  <option value="1">Texture1</option>
				  <option value="2">Texture2</option>
				  <option value="3">Texture3</option>
					<option value="4">Texture4</option>
					<option value="5">Texture5</option>
					<option value="6">Texture6</option>
					<option value="7">Texture7</option>
					<option value="8">Texture8</option>
					<option value="9">Texture9</option>
					<option value="10">Texture10</option>
					<option value="11">Texture11</option>
					<option value="12">Texture12</option>
					<option value="13">Texture13</option>
					<option value="14">Texture14</option>
					<option value="15">Texture15</option>
				</select>
			</div>
			<div class="row">
				<p class="col-md-6"><b >Color:</b></p>
				<select class="col-md-4  info-val"  id="val-color" style="color:#000;">
					<option value="random" id="random-color" selected>Personalized</option>
				  <option value="ffffff">White</option>
				  <option value="000000">Black</option>
				  <option value="ff0000">Red</option>
					<option value="c91e38">Sapienza Red</option>
					<option value="fd8437">Orange</option>
					<option value="f0bb03">Gold</option>
					<option value="fffe03">Yellow</option>
				  <option value="00ff00">Green</option>
					<option value="0f3b1d">Dark Green</option>
					<option value="00a401">Light Green</option>
					<option value="0000ff">Blue</option>
					<option value="00a4c2">Light Blue</option>
					<option value="000861">Dark Blue</option>
					<option value="9747d4">Purple</option>
					<option value="8e9394">Grey</option>
					<option value="444444">Dark Grey</option>
					<option value="d3d4d7">Light Grey</option>
				</select>
			</div>
		</div>
	</div>

</div>

<div class="model-info dbdetails">
	<div class="row">
		<ul>
			<?php
				for($i=0; $i<count($udbs); $i++){
					echo('<li><a href="#" class="db-details" id="'.$udbs[$i]->getId().'">Zoom on <b class="name">'.$udbs[$i]->getName().'</b></a></li>');
					$tables = $udbs[$i]->getTables();
					for($y=0; $y<count($tables); $y++){
						echo('<li><a href="#" class="db-details" id="'.$tables[$y]->getId().'">Zoom on '.$udbs[$i]->getName().' - <b class="name">'.$tables[$y]->getName().'</b></a></li>');
						$cols = $tables[$y]->getColumns();
						for($z=0; $z<count($cols); $z++){
							echo('<li><a href="#" class="db-details" id="'.$cols[$z]->getId().'">Zoom on '.$udbs[$i]->getName().' - '.$tables[$y]->getName().' - <b class="name">'.$cols[$z]->getName().'</b></a></li>');
						}
					}
				}
			?>
			<li><a href="#" class="db-details" id="all">Zoom on <b>All</b></a></li>
		</ul>
		</div>
	</div>

</div>
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
                    <a href="#">
                        <i class="pe-7s-box2"></i>
                        <p>Global Environment</p>
                    </a>
                </li>
								<li>
                    <a id="reset-camera-position" href="#">
                        <i class="pe-7s-video"></i>
                        <p>Reset Camera</p>
                    </a>
                </li>
								<li>
                    <a id="drag-movement" href="#">
                        <i class="pe-7s-expand1"></i>
                        <p>Disable Drag</p>
                    </a>
                </li>
								<li>
                    <a id="details-mode" href="#">
                        <i class="pe-7s-news-paper"></i>
                        <p>Show Details</p>
                    </a>
                </li>

								<li class="active-pro">
                    <a href="dashboard.php">
                        <i class="pe-7s-left-arrow"></i>
                        <p>Return to Manager</p>
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
                    <a class="navbar-brand" href="#">3D Experience</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="pe-7s-display2"></i>
                                    <b class="caret"></b>
                                    <span class="notification">3</span>
                              </a>
                              <ul class="dropdown-menu" style="max-height:300px;overflow:auto;">
																<?php
																	for($i=0; $i<count($udbs); $i++){
																		echo('<li><a href="#" class="db-details" id="'.$udbs[$i]->getId().'">Zoom on <b class="name">'.$udbs[$i]->getName().'</b></a></li>');
																		$tables = $udbs[$i]->getTables();
																		for($y=0; $y<count($tables); $y++){
																			echo('<li><a href="#" class="db-details" id="'.$tables[$y]->getId().'">Zoom on '.$udbs[$i]->getName().' - <b class="name">'.$tables[$y]->getName().'</b></a></li>');
																			$cols = $tables[$y]->getColumns();
																			for($z=0; $z<count($cols); $z++){
																				echo('<li><a href="#" class="db-details" id="'.$cols[$z]->getId().'">Zoom on '.$udbs[$i]->getName().' - '.$tables[$y]->getName().' - <b class="name">'.$cols[$z]->getName().'</b></a></li>');
																			}
																		}
																	}
																?>
                                <li><a href="#" class="db-details" id="all">Zoom on <b>All</b></a></li>
                              </ul>
                        </li>
												<li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="pe-7s-photo-gallery"></i>
                                    <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <li class="li-selected"><a class="change-theme" data-theme="Light">Light</a></li>
                                <li><a id="scene-dark" class="change-theme" data-theme="Dark">Dark</a></li>
                              </ul>
                        </li>
												<li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="pe-7s-world"></i>
                                    <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <li class="li-selected"><a class="change-display-type" data-type="graph">Graph</a></li>
                                <li><a id="scene-dark" class="change-display-type" data-type="gravity">Gravity</a></li>
                              </ul>
                        </li>
												<li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="pe-7s-camera"></i>
                                    <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
																<li class="li-selected"><a class="change-animation-type" data-type="nope">No Animation</a></li>
                                <li><a class="change-animation-type" data-type="object">Object Animation</a></li>
                                <li><a class="change-animation-type" data-type="camera">Camera Animation</a></li>
                              </ul>
                        </li>
												<li><button class="btn btn-warning" id = "Button-Stop">Stop Animation</button></li>
												<li><button class="btn btn-warning" id = "Button-10p">+10% Speed</button></li>
												<li><button class="btn btn-warning" id = "Button-10m">-10% Speed</button></li>
												<li><button class="btn btn-warning" id = "Button-10pp">+10% Precision</button></li>
												<li><button class="btn btn-warning" id = "Button-10mp">-10% Precision</button></li>
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
                                <li><a href="final-report.php">Credits and References</a></li>

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
            <div class="container-fluid" id="canvas-container">

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


    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>




	<script src="webgl-utils/utils/js/controls/FlyControls.js"></script>
	<script src="webgl-utils/utils/build/three.js"></script>
	<script src="webgl-utils/utils/js/controls/DragControls.js"></script>
	<script src="webgl-utils/utils/js/controls/TrackballControls.js"></script>
	<script src="webgl-utils/utils/js/libs/stats.min.js"></script>
	<script src="webgl-utils/utils/js/renderers/Projector.js"></script>
	<script src="webgl-utils/utils/js/tween.js"></script>

	<script>

	$('.dbdetails').css("margin-left", $('.content').width()-10);
	$('.dbdetails').css("height", $('.content').height());
	$('.dbdetails ul').css("max-height",$('.content').height()-20);
	$('.dbdetails').hide();
	$('#object-informations').hide();
	$('#speed-precision').hide();

	function showSpeedPrecision(){
		$('#speed-precision').show(0);
		setTimeout(function(){
			$('#speed-precision').hide(0);
		},1000);
	}

		var container, stats;
		var camera, controls, dragControls,dragControls, scene, renderer;
		var initial_camera_position = {x:0,y:0,z:1500};
		var camera_fov = 70;
		var scene_theme = "Light";
		var drag_movement = true;
		var details_mode = false;
		var projector = new THREE.Projector();
		var mouse2D = new THREE.Vector3(0, 0, 1500);
		var animated_object = null;
		var interval_limit =212;
		var increment = 10;
		var animation_type = "nope";
		var display_type = "graph";
		var animated_objects = [];
		var texture_loader =  new THREE.TextureLoader();
		var global_mixed;


		var objects = [];
		var objects1 = [];

		var points = [];
		var points1 = [];
		var lines = [];
    var lines1 = [];



		var line_materials = [
			new THREE.LineBasicMaterial({ color: 0x0000ff }),
			new THREE.LineBasicMaterial({ color: 0x000000 }),
			new THREE.LineBasicMaterial({ color: 0xffffff * Math.random()})
		];
		var object_materials = [
			new THREE.MeshBasicMaterial( { color: Math.random() * 0xffffff } ) ,
			new THREE.MeshDepthMaterial() ,
			new THREE.MeshLambertMaterial({ color: Math.random() * 0xffffff }),
			new THREE.MeshNormalMaterial(),
			new THREE.MeshPhongMaterial({ color: Math.random() * 0xffffff }),
			new THREE.MeshStandardMaterial(),
		];


		for(var i=0; i<object_materials.length; i++){
			object_materials[i].needsUpdate = true;
		}

		var texture_materials = [];

		function hasColorMaterial(name){
			switch(name){
				case "MeshBasicMaterial":
					return true;
				break;
				case "MeshDepthMaterial":
					return false;
				break;
				case "MeshLambertMaterial":
					return true;
				break;
				case "MeshNormalMaterial":
					return false;
				break;
				case "MeshPhongMaterial":
					return true;
				break;
				case "MeshStandardMaterial":
					return false;
				break;
				default:
					return -1;
				break;
			}
		}

		function getMaterialFromName(name){
			switch(name){
				case "MeshBasicMaterial":
					return object_materials[0];
				break;
				case "MeshDepthMaterial":
					return object_materials[1];
				break;
				case "MeshLambertMaterial":
					return object_materials[2];
				break;
				case "MeshNormalMaterial":
					return object_materials[3];
				break;
				case "MeshPhongMaterial":
					return object_materials[4];
				break;
				case "MeshStandardMaterial":
					return object_materials[5];
				break;
				default:
					return object_materials[0];
				break;
			}
		}

		var move_camera_on_click = true;

		$('#Button-Stop').click(function(){
			if(animation_type == "object"){
				animated_object.rotation.x = 0;
				animated_object.rotation.y = 0;
				animated_object.rotation.z = 0;
				$('#object-informations').hide();
			}
			animated_object = null;
		});
		$('#Button-10p').click(function(){
			increment += (increment * 10)/100;
			$('#val-speed').html((increment+"").substring(0,6));
			showSpeedPrecision();
		});
		$('#Button-10m').click(function(){
			increment -= (increment * 10)/100;
			$('#val-speed').html((increment+"").substring(0,6));
			showSpeedPrecision();
		});
		$('#Button-10mp').click(function(){
			interval_limit += (interval_limit * 10)/100;
			$('#val-precision').html((interval_limit+"").substring(0,6));4
			showSpeedPrecision();
		});
		$('#Button-10pp').click(function(){
			interval_limit -= (interval_limit * 10)/100;
			$('#val-precision').html((interval_limit+"").substring(0,6));
			showSpeedPrecision();
		});



		var Point = function(px,py,pz,pid){
			this.x = px;
			this.y = py;
			this.z = pz;
			this.name = pid;
		}


    var DatabaseStruct = function(
      id,
      position_x, position_y, position_z,
      objects,lines,
      default_object_material,
      default_line_material,
      default_controls
    ){
      this.id = id;
			this.base_size = 10;
      this.default_position = [position_x,position_y,position_z];

      if(objects != null){
        this.objects = objects;
      }else{
        this.objects = [];
      }
      if(lines != null){
        this.lines = lines;
      }else{
        this.lines = [];
      }

      this.default_object_material = default_object_material;
      this.default_line_material = default_line_material;
			this.controls_type = default_controls;
			this.actions_controller;
			this.selected_textures = {size:0};

			this.initializeControls = function(default_c){
				if(this.objects.length == 0){
					console.error("impossibile to initialize " + default_c + " controls because of no objects are present.");
				}else{
					if(default_c == null)
						var contr = this.controls_type;
					else
						var contr = default_c;
					switch(contr){
						case "Drag":
							var objs = this.getFamily(this.objects);
							this.actions_controller = new THREE.DragControls( objs, camera, renderer.domElement );
						break;
						default:
							this.actions_controller = new THREE.DragControls( this.getFamily(), camera, renderer.domElement );
						break;
					}
				}
			}



// family maximum with 3 level
			this.getFamily = function(obj){
				var family = [];
				if(obj.length <=0){
					return [];
				}else{
					obj.forEach(function(o){
						family.push(o);
						if(typeof o.children != "undefined"){
							if(o.children.length>0){
							o.children.forEach(function(c){
								family.push(c);
								if(typeof c.children != "undefined"){
									if(c.children.length>0){
										c.children.forEach(function(cc){
											family.push(cc);
										});
									}
								}
							});
							}
						}
					});
					return family;
				}
			}

      this.generateChilds = function(mesh, numb_childs ){
        for ( var i = 0; i < numb_childs; i ++ ) {
  					var positions = getRelativePosition(this.default_position[0],this.default_position[1],this.default_position[2],700,700,700, -200, -200 , -200 );
  					var o = this.createObject(
              this.id,"Cube",
              positions["x"],positions["y"],positions["z"],
              30, null);
            this.connect(mesh,o, true);
        }
      }

      this.addObject = function(mesh, overwrite){
        var index = this.objectIsPresent(mesh);
        if(index < 0){
          this.objects.push(mesh);
        }else{
          if(overwrite){
            this.objects[index] = mesh;
						this.objects[index].children = mesh.children;
					}
        }
      }

      /*
      function objectIsPresent
        description: check if mesh is present inside objects array, if it is return the index, -1 otherwise
        return: Integer
      */
      this.objectIsPresent = function(mesh){
        for(var i =0; i<this.objects.length; i++){
          var o = this.objects[i];
          if(o.name == mesh.name)
            return i;
        }
        return -1;
      }


			/*
			function deepSearch
				description: check if mesh is present inside the struct, if success return true, false otherwise
				return: Boolean
			*/
			this.deepSearch = function(mesh){
				if(this.objects[0] == null)
					return false;
				else{
					if(this.objects[0].name == mesh.name){
						return true;
					}else{
						this.getFamily(this.objects).forEach(function(c){

							if(c.name == mesh.name){
								return true;
							}
						});
						return false;
					}
				}
			}

      this.render = function(){
          this.objects.forEach(function(o){
            scene.add(o); // add objects to the global scene;
          });
          this.lines.forEach(function(l){
            scene.add(l); // add objects to the global scene;
          });
      }

			this.renderLines = function(){
          this.lines.forEach(function(l){
            scene.add(l); // add objects to the global scene;
          });
      }

			this.applyTextureMaterial = function(){
				if(this.selected_textures["size"] > 0){
					var name = this.objects[0].name;
					var name = name.split("#");
					var name = name[0];
					if(typeof(this.selected_textures[name]) != "undefined"){
						console.log("texture:" + this.selected_textures[name] );
						this.objects[0].material = texture_materials[this.selected_textures[name]];
					}
					global_mixed = this.selected_textures;
					this.getFamily(this.objects).forEach(function(c){
						var name = c.name;
						var name = name.split("#");
						var name = name[0];
						if(typeof(global_mixed[name])!= "undefined"){
							c.material = texture_materials[global_mixed[name]];
						}
					});
				}else{
					//console.log(this.selected_textures);
					console.warn("No textures are setted for this structure");
				}
			}
      /*
      function createObject
        description: create the new Mesh as specified in parameters
        return: Mesh
      */

      this.createObject = function(geometry_name, geometry_type, x, y, z, size,object_material, color, texture){
				if(x == null && y == null && z == null){
					var pos = getRelativePosition(
						200,200,200,
						200, 200, 200,
						0,0,0
					);
					x = pos["x"];
					y = pos["y"];
					z = pos["z"];
				}
        var geometry = null;
  			switch(geometry_type){
  				case "Sphere":
  					geometry = new THREE.SphereBufferGeometry( size, size*2, size*2 );
  				break;
  				case "Cube":
  					geometry = new THREE.BoxBufferGeometry( size, size, size );
  				break;
  				default:
  					geometry = new THREE.SphereBufferGeometry( size ,size*2, size*2 );
  				break;
  			}

        if(geometry_name != null)
          geometry.name = geometry_name;

        var object;
        if(object_material == null){
					var mat = object_materials[this.default_object_material].clone();
					if(texture != null && typeof(texture) != "undefined" && texture != "null"){
						if(mat.type != "MeshDepthMaterial" && mat.type != "MeshNormalMaterial"){
							console.log("Mexture type:");
							console.log(typeof(texture_materials[parseInt(texture)]));
							if(typeof(texture_materials[parseInt(texture)]) == "undefined"){
								mat = object_materials[this.default_object_material].clone();
								this.selected_textures[geometry_name] = parseInt(texture);
								this.selected_textures["size"]++;
							}else{
								mat = texture_materials[parseInt(texture)].clone();
							}
						}else{
							console.warn("Texture is not applicable to "+mat.type);
						}
					}
          object = new THREE.Mesh( geometry,  mat);
        }else{
					var mat = (getMaterialFromName(object_material)).clone();
					if(texture != null && typeof(texture) != "undefined" && texture != "null"){
						if(mat.type != "MeshDepthMaterial" && mat.type != "MeshNormalMaterial"){
							console.log("Mexture type:");
							console.log(typeof(texture_materials[parseInt(texture)]));
							if(typeof(texture_materials[parseInt(texture)]) == "undefined"){
								mat = object_materials[this.default_object_material].clone();
								this.selected_textures[geometry_name] = parseInt(texture);
								this.selected_textures["size"]++;
							}else{
								mat = texture_materials[parseInt(texture)].clone();
							}
						}else{
							console.warn("Texture is not applicable to "+mat.type);
						}
					}
          object = new THREE.Mesh( geometry,  mat);
				}

				if(color != null && color != 0 && hasColorMaterial(object.material.type)){
					object.material.color.setHex(color);
				}
  			object.position.x = x;
  			object.position.y = y;
  			object.position.z = z;
  			object.name = geometry_name+"#obj-"+this.objects.length;
  			/*
  			object.rotation.x = Math.random() * 2 * Math.PI;
  			object.rotation.y = Math.random() * 2 * Math.PI;
  			object.rotation.z = Math.random() * 2 * Math.PI;
  			object.scale.x = Math.random() * 2 + 1;
  			object.scale.y = Math.random() * 2 + 1;
  			object.scale.z = Math.random() * 2 + 1;
  			*/
  			object.castShadow = true;
  			object.receiveShadow = true;
  			return object;
      }

			/*
      function updateDatabase
        description: update with async. calls all informations about 3D objects in the scene
										 present in relative Database's Table using 3DB api services.
        return: void
      */

			this.updateDatabase = function(){
				if(this.objects[0] != null){
					var name = this.objects[0].name;
					name = name.split("#");
					name = name[0];
					if(hasColorMaterial(this.objects[0].material.type)){
						var color = "0x"+this.objects[0].material.color.getHex().toString(16);
						if(color == "0x0"){
							color = "0xff0000";
						}
					}else{
						var color = "0xffffff";
					}

					if(this.objects[0].material.map != null)
						var texture = this.objects[0].material.name;
					else {
								var texture = "null";
						}
					$.post("http://localhost/IG%20FINAL%20PROJECT/3dB/api/api.php", {
						apikey: "<?php echo($user_apikey->getKey()); ?>",
						request: "Object3D/central/"+name+"/0/"+this.objects[0].position.x+"/"+this.objects[0].position.y+"/"+this.objects[0].position.z+"/50/"+this.objects[0].material.type+"/1.0/"+texture+"/"+color+"/database"})
					.done(function(data){
						console.log("updated: " + name);
					});
					var family = this.getFamily(this.objects);
					family.forEach(function(o){
						var name = o.name;
						name = name.split("#");
						name = name[0];
						if(hasColorMaterial(o.material.type)){
							var color = "0x"+o.material.color.getHex().toString(16);
							if(color == "0x0"){
								color = "0xff0000";
							}
						}else{
							var color = "0xffffff";
						}
						if(o.children.length >0){
							var type = "table";
							var size = 30
						}else{
							var type = "column";
							var size = 20;
						}

						if(o.material.map != null)
							var texture = o.material.name;
						else {
								var texture = "null";
						}


						$.post("http://localhost/IG%20FINAL%20PROJECT/3dB/api/api.php", {
							apikey: "<?php echo($user_apikey->getKey()); ?>",
							request: "Object3D/central/"+name+"/0/"+o.position.x+"/"+o.position.y+"/"+o.position.z+"/"+size+"/"+o.material.type+"/1.0/"+texture+"/"+color+"/"+type+""})
						.done(function(data){
							console.log("updated: " + name);
						});
					});

				}else{
					console.error("updateBatabase - nullpointer exception in updateDatabase function");
				}
			}

			/*
      function getAllParentsPosition
        description: return the sum of all parents positions
        return: array(x,y,z)
      */
			this.getAllParentsPosition = function(mesh){
				var x = 0;
				var y = 0;
				var z = 0;
				var lm = mesh;
				while(true){
					if(lm.parent != null){
						x += lm.parent.position.x;
						y += lm.parent.position.y;
						z += lm.parent.position.z;
						lm = lm.parent;
					}else{
						break;
					}
				}
				return [x,y,z];
			}

			/*
      function setIncrementalObjectSize
        description: set the size of the object to respect to the number of its childrens
        return: void
      */
			this.setIncrementalObjectSize = function(){
				if(this.objects[0] != null){
					if(this.objects[0].length>0){
						this.objects[0].childrens.forEach(function(c){
						});
					}else{ // no childs
					}
				}else{
					console.warn("setIncrementalObjectSize: Nullpointer Exception - i can't set the size of null");
				}
			}


      this.connect = function(father, child, add){
  			if(father.type == "Mesh" && child.type == "Mesh"){
  				var line_geometry = new THREE.Geometry();
  				if(father.name != child.name){
						var pp = this.getAllParentsPosition(father);
							line_geometry.vertices.push(new THREE.Vector3(
								pp[0] + father.position.x,
								pp[1] + father.position.y,
								pp[2] + father.position.z
							));
							line_geometry.vertices.push(new THREE.Vector3(
								pp[0] + father.position.x + child.position.x,
								pp[1] + father.position.y + child.position.y,
								pp[2] + father.position.z + child.position.z
							));

						if(typeof line_materials[this.default_line_material] != "undefined"){
  						var line = new THREE.Line(line_geometry, line_materials[this.default_line_material].clone());
							if(hasColorMaterial(father.material.type)){
								var line_color = father.material.color.getHex().toString(16);
								var lcl = line_color.length;
								for(var i=0; i<6-lcl; i++){
									line_color = "0"+line_color ;
								}
								if(line_color == "ffffff" && scene_theme == "Light"){
									line.material.color.setHex("0x000000");
								}else if(line_color == "000000" && scene_theme == "Dark"){
									line.material.color.setHex("0xffffff");
								}else{
									line.material.color.setHex("0x"+line_color);
								}
							}
  						line.name = father.name + "*" + child.name;
  						this.lines.push(line);
							if(add == true)
              	father.add(child);
  					}else
  						console.error("Undefined line material index " + this.default_line_material);
  				}else{
  					console.log("I can't add line between the same object");
  				}
  			}else{
  				console.error("invalid mesh_a and/or meash_b type. Meshs are required");
  			}
  		}

			this.getAllConnections = function(mesh, without_father){
					if(mesh.parent.type == "Scene"){
						return this.lines;
					}
					var llines = [];
					this.lines.forEach(function(l){
						var name = (""+l.name).split("*");
						var father_name = name[0];
						var children_name = name[1];
						if(without_father == true){
							if(mesh.name == father_name){
								llines.push(l);
							}
						}else{
							if(mesh.name == father_name || mesh.name == children_name){
								llines.push(l);
							}
						}
					});
					return llines;
			}

			this.hideMeshConnections = function(mesh){
				console.log("PASSED MESH: ");
				var m1 = mesh;
				console.log(m1);
				console.log("************");
				var lines = this.getAllConnections(m1, true);
				console.log(m1);
				if(typeof(lines) != "undefined"){
					if(lines.length >0){
						lines.forEach(function(l){
							l.visible = false;
						});
					}else{
						console.warn("hideMeshConnections: no lines founded!");
					}
				}
				console.log("selected:");
				console.log(lines);
			}

			this.showMeshConnections = function(mesh){
				var lines = this.getAllConnections(mesh);
				if(typeof(lines) != "undefined"){
					if(lines.length >0){
						lines.forEach(function(l){
							l.visible = true;
						});
					}else{
						console.warn("showMeshConnections: no lines founded!");
					}
				}
			}



			this.getExternalNodes = function(number){
				var analized = [];
				var i = 0;
				var all = this.getFamily(this.objects);
				all.forEach(function(node){
					if(analized.length<=0){
						analized.push(node);
					}else{
						if(
							Math.abs(analized[i].position.x) < Math.abs(node.position.x) &&
							Math.abs(analized[i].position.y) < Math.abs(node.position.y) &&
							Math.abs(analized[i].position.z) < Math.abs(node.position.z)
						){
							i++;
							analized.push(node);
						}else{
							var loc = analized[i];
							analized[i+1] = loc;
							analized[i] = node;
							i++;
						}
					}
				});
				var ret = [];
				for(var i =0; i<number; i++){
							ret.push(analized[(analized.length-1)-i]);
				}
				return ret;
			}

    }


		<?php
			for($i =0; $i<count($udbs); $i++){
				echo("var ds".$i.";");
			}
		?>

		init();
    animate();


		$('.change-theme').click(function(){
			setRendererTheme($(this).attr("data-theme"));
			$('.change-theme').parent().removeClass("li-selected");
			$(this).parent().addClass("li-selected");
		});

		$('#reset-camera-position').click(function(){
			setCameraPostion(
				initial_camera_position["x"],
				initial_camera_position["y"],
				initial_camera_position["z"]
			);
		});

		$('#drag-movement').click(function(){
			if($(this).hasClass("disable-drag")){
				$(this).removeClass("disable-drag");
				$(this).find("p").html("Disable Drag");
				drag_movement = true;
				<?php
					for($i =0; $i<count($udbs); $i++){
						echo("ds".$i.".actions_controller.activate();");
					}
				?>
			}else{
				$(this).addClass("disable-drag");
				$(this).find("p").html("Enable Drag");
				drag_movement = false;
				<?php
					for($i =0; $i<count($udbs); $i++){
						echo("ds".$i.".actions_controller.deactivate();");
					}
				?>
			}
		});

		$('#details-mode').click(function(){
			if($(this).hasClass("show-details")){
				details_mode = false;
				$(this).removeClass("show-details");
				$(this).find("p").html("Show Details");
				$('.dbdetails').hide(0);
			}else{
				details_mode = true;
				$(this).addClass("show-details");
				$(this).find("p").html("Hide Details");
				$('.dbdetails').show(0);
			}
		});

//68 D - 65 A  - 87 W - 83 S - 81 Q - 69 E
		$( "body" ).keydown(function( event ) {
			if(!details_mode){
			  if ( event.which == 83 ) { // move camera backward
				 setCameraPostion(camera.position.x, camera.position.y, camera.position.z+=100);
			 }else if(event.which == 87 ){ // move camera forward
				 setCameraPostion(camera.position.x, camera.position.y, camera.position.z-=100);
			 }else if(event.which == 68 ){ // move camera forward
				 setCameraPostion(camera.position.x+=100, camera.position.y, camera.position.z);
			 }else if(event.which == 65 ){ // move camera forward
				 setCameraPostion(camera.position.x-=100, camera.position.y, camera.position.z);
			 }else if(event.which == 81 ){ // move camera forward
				 setCameraPostion(camera.position.x, camera.position.y+=100, camera.position.z);
			 }else if(event.which == 69 ){ // move camera forward
				 setCameraPostion(camera.position.x, camera.position.y-=100, camera.position.z);
			 }
	 		}
		});

		//insert as child of mesh group each mash in arr_mesh array

		function addChilds(mesh, childrens){
			childrens.forEach(function(child){
				mesh.add(child);
			});
			return mesh;
		}

		//connect with a line of material "material" the mesh "pointa" with all meshs in "arr" array
		//material is the index relative to material inside line_materials array

		function connectToObj(pointa, arr, material, arr_lines){
			if(pointa.type == "Mesh"){
				if(areMesh(arr)){
					arr.forEach(function(point){
						DrawLineObj(pointa, point, material, arr_lines);
					});
					addChilds(pointa, arr);
				}else
					console.error("Passed are is not composed by Point objects");
			}else
				console.error("Passed pointa is not a Point object");
		}

		// it checks if objects in array "arr" are of the type "Mesh"

		function areMesh(arr){
			arr.forEach(function(mesh){
				if(mesh.type != "Mesh")
					return false;
			});
			return true;
		}

		// Draw a line that connect "mesha" with "meshb". "material" is the index relative to "line_materials" array

		function DrawLineObj(mesha, meshb, material,arr_lines){
			if(mesha.type == "Mesh" && meshb.type == "Mesh"){
				var line_geometry = new THREE.Geometry();
				if(mesha.name != meshb.name){
					line_geometry.vertices.push(new THREE.Vector3(mesha.position.x, mesha.position.y, mesha.position.z));
					line_geometry.vertices.push(new THREE.Vector3(meshb.position.x, meshb.position.y, meshb.position.z));
					if(typeof line_materials[material] != "undefined"){
						var line = new THREE.Line(line_geometry, line_materials[material]);
						line.name = mesha.name + "*" + meshb.name;
						scene.add(line);
						arr_lines.push(line);
					}else
						console.error("Undefined line material index " + material);
				}else{
					console.log("I can't add line between the same object");
				}
			}else{
				console.error("invalid mesh_a and/or meash_b type. Meshs are required");
			}
		}

		// Drow a line between two objects of class Point with the specified material (index)

		function drawLine(point_a, point_b, material, arr_lines){
			if(isPoint(point_a)){
				if(isPoint(point_b)){
					var line_geometry = new THREE.Geometry();
					if(point_a.name != point_b.name){
						line_geometry.vertices.push(new THREE.Vector3(point_a.x, point_a.y, point_a.z));
						line_geometry.vertices.push(new THREE.Vector3(point_b.x, point_b.y, point_b.z));
						if(typeof line_materials[material] != "undefined"){
							var line = new THREE.Line(line_geometry, line_materials[material]);
							line.name = point_a.name + "*" + point_b.name;
							scene.add( line );
							arr_lines.push(line);
						}else
							console.error("Undefined line material index " + material);
					}else{
						console.log("I can't add line between the same object");
					}
				}else{
					console.error("impossibile to draw line between two undefined objects");
				}
			}else{
				console.error("impossibile to draw line between two undefined objects");
			}
		}

		//it checks if passed object is of the type Point

		function isPoint(point){
			if( typeof point.x != "undefined" && typeof point.y != "undefined" && typeof point.z != "undefined")
				return true;
			else return false;
		}

		// check if objects inside passed are are of the type Point

		function arePoints(point_arr){
			point_arr.forEach(function(point){
				if(!isPoint(point))
					return false;
			});
			return true;
		}


		//Drow lines of the specified material (index) between pointa and points inside array arr.
		function connectToPoint(pointa, arr, material, arr_lines){
      arr_lines = [];
			if(isPoint(pointa)){
				if(arePoints(arr)){
					arr.forEach(function(point){
						drawLine(pointa, point, material,arr_lines);
					});
				}else
					console.error("Passed are is not composed by Point objects");
			}else
				console.error("Passed pointa is not a Point object");
		}

		//create a new geometry of the specified type and material
		// if into_scene is setted to true also inserts specified mesh into the scene

		function addObject(geometry_type,geometry_name,object_name, x,y,z, size, material, obj_arr,points_arr, into_scene){

			var geometry = null;
			switch(geometry_type){
				case "Sphere":
					geometry = new THREE.SphereBufferGeometry( size, size*2, size*2 );
				break;
				case "Cube":
					geometry = new THREE.BoxBufferGeometry( size, size, size );
				break;
				default:
					geometry = new THREE.SphereBufferGeometry( size ,size*2, size*2 );
				break;
			}

      if(geometry_name != null)
        geometry.name = geometry_name;

      var object = new THREE.Mesh( geometry,  object_materials[4]);
			object.position.x = x;
			object.position.y = y;
			object.position.z = z;
			object.name = object_name+"obj-"+points_arr.length;
			points_arr.push(new Point(x,y,z, "obj-"+points_arr.length));

			/*
			object.rotation.x = Math.random() * 2 * Math.PI;
			object.rotation.y = Math.random() * 2 * Math.PI;
			object.rotation.z = Math.random() * 2 * Math.PI;

			object.scale.x = Math.random() * 2 + 1;
			object.scale.y = Math.random() * 2 + 1;
			object.scale.z = Math.random() * 2 + 1;
			*/
			object.castShadow = true;
			object.receiveShadow = true;
			obj_arr.push( object );
			if(into_scene){
				scene.add( object );
			}
			return object;
		}


		// remove the passed object from the scene

		function removeEntity(object) {
			var selectedObject = scene.getObjectByName(object.name);
			scene.remove( selectedObject );
			//animate();
		}

		//return the maximum number inside the array "arr"

		function Max(arr){
			var max = 0;
			arr.forEach(function(number){
				if(number>max)
					max = number;
			});
			return max;
		}

		// set passed hexadecimal color for all the material in object_materials array

		function setMaterialsColor(mcolor){
			if(mcolor.length!=8){
					mcolor = Math.random() * 0xffffff;
					console.error("setMaterialsColor: invalid color passed. A random color is setted!");
			}

			object_materials = [
				new THREE.MeshBasicMaterial( { color: mcolor } ) ,
				new THREE.MeshDepthMaterial() ,
				new THREE.MeshLambertMaterial({ color: mcolor }),
				new THREE.MeshNormalMaterial(),
				new THREE.MeshPhongMaterial({ color: mcolor }),
				new THREE.MeshStandardMaterial(),
			];
		}

		//if mesh is a leaf, update line position according to mesh position and its parent.


		function defragArray(arr){
			var ret = [];
			for(var i =0; i<arr.length; i++){
				if(arr[i] != null && arr[i] != "undefined")
					ret.push(arr[i]);
			}
			return ret;
		}

		function getRelativePosition(min_x, min_y, min_z, max_x, max_y, max_z, base_x, base_y, base_z){
			var randomx = Math.random();
			var randomy = Math.random();
			var randomz = Math.random();
			if(randomx>0.5){
				posx = base_x +  (Math.random() * max_x) - min_x;
			}else{
				posx = base_x + (Math.random() * max_x) + min_x;
			}
			if(randomy>0.5){
				posy = base_y + (Math.random() * max_y) - min_y;
			}else{
				posy = base_y + (Math.random() * max_y) + min_y;
			}
			if(randomz>0.5){
				posz =  base_z + (Math.random() * max_z) - min_z;
			}else{
				posz = base_z + (Math.random() * max_z) + min_z;
			}

			var ret = {x:posx, y:posy, z:posz};
			return ret;
		}

		function resetAllConnections(){
				<?php
				for($i=0; $i<count($udbs); $i++){
					?>
					ds<?php echo($i);?>.lines.forEach(function(l){
						l.visible = true;
					});
					updateConnections(null, ds<?php echo($i);?>);
					ds<?php echo($i);?>.renderLines();
					<?php
				}
				?>
				animated_objects.forEach(function(o){
					o.rotation.x = 0;
					o.rotation.y = 0;
					o.rotation.z = 0;
				});
				animated_objects = [];
		}

		function init() {

			container = document.getElementById("canvas-container");




			camera = new THREE.PerspectiveCamera( camera_fov, window.innerWidth / window.innerHeight, 1, 10000 );
			setCameraPostion(
				initial_camera_position["x"],
				initial_camera_position["y"],
				initial_camera_position["z"]
			);

			controls = new THREE.TrackballControls( camera );
			controls.rotateSpeed = 1.0;
			controls.zoomSpeed = 1.2;
			controls.panSpeed = 0.8;
			controls.noZoom = false;
			controls.noPan = false;
			controls.staticMoving = true;
			controls.dynamicDampingFactor = 0.3;

			scene = new THREE.Scene();

			scene.add( new THREE.AmbientLight( 0x505050) );


			var light = new THREE.SpotLight( 0xffffff, 1.5 );
			light.position.set( 500, 800, 2000 );
			light.castShadow = true;

			light.shadow = new THREE.LightShadow( new THREE.PerspectiveCamera( 50, 1, 200, 10000 ) );
			light.shadow.bias = - 0.00022;

			light.shadow.mapSize.width = 2048;
			light.shadow.mapSize.height = 2048;

			scene.add( light );



			renderer = new THREE.WebGLRenderer( { antialias: true, alpha: true} );
			setRendererTheme(scene_theme);

			renderer.setPixelRatio( window.devicePixelRatio );
			renderer.setSize( window.innerWidth, window.innerHeight );
			renderer.sortObjects = false;

			renderer.shadowMap.enabled = true;
			renderer.shadowMap.type = THREE.PCFShadowMap;

			container.appendChild( renderer.domElement );


			<?php
				for($i=0; $i<count($udbs); $i++){
					$obj3d = $udbs[$i]->getObject3D();
					?>
					<?php
					if($obj3d != null){
						?>
						ds<?php echo($i); ?>= new DatabaseStruct("<?php echo($udbs[$i]->getName()); ?>", <?php echo($obj3d->getPositionX()); ?>, <?php echo($obj3d->getPositionY()); ?>, <?php echo($obj3d->getPositionZ()); ?>,null,null,3,2,"Drag");

						var o<?php echo($i); ?> = ds<?php echo($i); ?>.createObject(
							"<?php echo($udbs[$i]->getId()); ?>",
							"Sphere",
							<?php echo($obj3d->getPositionX());?>,
							<?php echo($obj3d->getPositionY());?>,
							<?php echo($obj3d->getPositionZ());?>,
							<?php echo($obj3d->getSize());?>,
							"<?php echo($obj3d->getMaterial());?>",
						 	"<?php echo($obj3d->getColor());?>",
							"<?php echo($obj3d->getTexture());?>"
						);
						<?php

					}else{
						?>
						ds<?php echo($i); ?>= new DatabaseStruct("<?php echo($udbs[$i]->getName()); ?>", <?php echo($i*800); ?>,0,0,null,null,3,2,"Drag");
						var o<?php echo($i); ?> = ds<?php echo($i); ?>.createObject(
							"<?php echo($udbs[$i]->getId()); ?>",
							"Sphere",
							<?php echo($i*800); ?>,
							0, 0, 60,
							"<?php
								$obj3d = $udbs[$i]->getObject3D();
								if($obj3d != null){
										echo($obj3d->getMaterial());
								}
							  ?>",
							"<?php
							if($obj3d != null){
									echo($obj3d->getColor());
							}
							?>","<?php
							if($obj3d != null){
									echo($obj3d->getTexture());
							}
							?>");
						<?php
					}
					?>
					<?php
						$tbs = $udbs[$i]->getTables();
					 	for($y=0; $y<count($tbs); $y++){
							$tbo = $tbs[$y]->getObject3D();
							if($tbo != null){
								?>
								var tb<?php echo($y); ?> = ds<?php echo($i); ?>.createObject(
									"<?php echo($tbs[$y]->getId()); ?>",
									"Cube",
									<?php echo($tbo->getPositionX());?>,
									<?php echo($tbo->getPositionY());?>,
									<?php echo($tbo->getPositionZ());?>,
									<?php echo($tbo->getSize());?>,
									"<?php echo($tbo->getMaterial());?>",
									"<?php echo($tbo->getColor());?>",
									"<?php echo($tbo->getTexture());?>");

								<?php
							}else{
								?>
								var tb<?php echo($y); ?> = ds<?php echo($i); ?>.createObject(
									"<?php echo($tbs[$y]->getId()); ?>",
									"Cube",
									null,
									null,
									null,
									40, 4);
								<?php
							}
							?>

							ds<?php echo($i); ?>.connect(o<?php echo($i); ?>,tb<?php echo($y); ?>, true);
							<?php

							$cols = $tbs[$y]->getColumns();
							for($z =0 ; $z< count($cols); $z++){
								$clo = $cols[$z]->getObject3D();
								if($clo != null){
									?>
									var cl<?php echo($z); ?> = ds<?php echo($i); ?>.createObject(
										"<?php echo($cols[$z]->getId()); ?>",
										"Sphere",
										<?php echo($clo->getPositionX());?>,
										<?php echo($clo->getPositionY());?>,
										<?php echo($clo->getPositionZ());?>,
										<?php echo($clo->getSize());?>,
										"<?php echo($clo->getMaterial());?>",
										"<?php echo($clo->getColor());?>",
									"<?php echo($clo->getTexture());?>");
									<?php
								}else{
									?>
									var cl<?php echo($z); ?> = ds<?php echo($i); ?>.createObject(
										"<?php echo($cols[$z]->getId()); ?>",
										"Sphere",
										null,
										null,
										null,
										20, 4);
									<?php
								}
								?>
								ds<?php echo($i); ?>.connect(tb<?php echo($y); ?>,cl<?php echo($z); ?>, true);
								<?php
							}
						}
						?>
					ds<?php echo($i); ?>.addObject(o<?php echo($i); ?>, true);


					<?php
					echo("ds".$i.".initializeControls();");
					echo("ds".$i.".render();");
				}
			?>

			function initializeGravity(reset){
				if(reset){
					resetAllConnections();
				}else{
					<?php
					for($i=0; $i<count($udbs); $i++){
						?>
						animated_objects.push(ds<?php echo($i);?>.objects[0]);
						ds<?php echo($i);?>.lines.forEach(function(l){
							l.visible = false;
						});
						<?php
					}
					?>
				}
			}

			var loaded = 0;
			var texture_number = 15;
			for(var i=0; i<texture_number;i++){
				texture_loader.load("assets/img/textures/texture"+i+".jpg", function(texture){
					texture.image.isMap = true;
					createTextureMaterial(texture);
					updateLoaded();
				});
			}

			function updateLoaded(){
				loaded = loaded+1;
				if(loaded == texture_number){
					<?php
					for($i=0; $i<count($udbs); $i++){
						echo("ds".$i.".applyTextureMaterial();");
					}
					?>
				}
			}

			function setDisplayType(type){
				switch(type){
					case "graph":
						display_type = "graph";
						initializeGravity(true);
					break;
					case "gravity":
						display_type = "gravity";
						initializeGravity(false);
					break;
					default:
						display_type = "graph";
						initializeGravity(true);
					break;
				}
			}

			$('.change-display-type').click(function(){
				var type = $(this).attr("data-type");
				$('.change-display-type').parent().removeClass("li-selected");
				$(this).parent().addClass("li-selected");
				setDisplayType(type);
			});

			$('.change-animation-type').click(function(){
				$('.change-animation-type').parent().removeClass("li-selected");
				$(this).parent().addClass("li-selected");
				animation_type = $(this).attr("data-type");
			});

/*
			var info = document.createElement( 'div' );
			info.style.position = 'absolute';
			info.style.top = '10px';
			info.style.width = '100%';
			info.style.textAlign = 'center';
			info.innerHTML = '<a href="http://threejs.org" target="_blank">three.js</a> webgl - draggable cubes';
			container.appendChild( info );

			//stats = new Stats();
			//container.appendChild( stats.dom );

			//
*/
			clock = new THREE.Clock();
			window.addEventListener( 'resize', onWindowResize, false );

			setTimeout(function(){$('#loader').hide()}, 3000);

		}

		function getDatabaseStruct(mesh){
			<?php
				for($i =0; $i<count($udbs); $i++){
					?>
					if(ds<?php echo($i);?>.deepSearch(mesh)){
						return ds<?php echo($i);?>;
					}
					<?php
				}
			?>
		}


		function createTextureMaterial(texture){
			var mat = new THREE.MeshPhongMaterial({ map: texture });
			texture_materials.push(mat);
		}

		function updateConnections(obj , datas){
			datas.updateDatabase();
			for(var i=0; i<datas.lines.length; i++){
				removeEntity(datas.lines[i]);
			}
			datas.lines = [];
			datas.objects[0].children.forEach(function(o){
				datas.connect(datas.objects[0], o, false);
				if(typeof o.children != "undefined"){
					o.children.forEach(function(c){
						datas.connect(o, c, false);
						if(typeof c.children != "undefined"){
							c.children.forEach(function(cc){
								datas.connect(c, cc, false);
							});
						}
					});
				}
			});
		}

		<?php
			for($i=0; $i<count($udbs); $i++){
		?>
		ds<?php echo($i);?>.actions_controller.addEventListener( 'dragstart', function ( event ) {
			controls.enabled = false;
		});

		ds<?php echo($i);?>.actions_controller.addEventListener( 'dragend', function (event) {
			controls.enabled = true;
			if(display_type == "graph"){
			 updateConnections(event.object, ds<?php echo($i);?>);
			 if(animation_type == "object"){
				  resetAllConnections();
					ds<?php echo($i);?>.hideMeshConnections(event.object);
			 }
			 ds<?php echo($i);?>.renderLines();
		 	}
			showObjectInfo(null,null, event.object);
		 } );
		 <?php
	 			}
		 ?>

		 $('.model-info').mouseover(function(){
			 controls.enabled = false;
		 });
		 $('.model-info').mouseleave(function(){
			 controls.enabled = true;
		 });

		 $('.db-details').click(function(){
			$('#Button-Stop').removeClass("disabled");
			 showObjectInfo($(this).attr("id"), $(this).children(".name").html());
		 });


		 var selected_object = null;

		 function showObjectInfo(id , name, obj){
			 if(id == null && name == null && obj != null){
				 var object = obj;
				 var loc = obj.name;
				 loc = loc.split("#");
				 loc = loc[0];
				 name = $("#"+loc).children(".name").html();
			 }else{
			 		var object = scene.getObjectByName( id+"#obj-0", true );
		 	 }

			 selected_object = object;
			 if(object!=null){
				 $('#val-name').html(name);
				 $('#val-x').html((""+object.position.x).substring(0, 8));
				 $('#val-y').html((""+object.position.y).substring(0, 8));
				 $('#val-z').html((""+object.position.z).substring(0, 8));
				 $('#val-alfa').html("1.0");

				 switch(object.material.type){
					 case "MeshBasicMaterial":
					 	$('#val-material').val(0);
					 break;
					 case "MeshPhongMaterial":
					 	$('#val-material').val(4);
					 break;
					 case "MeshDepthMaterial":
					 	$('#val-material').val(1);
					 break;
					 case "MeshLambertMaterial":
					 	$('#val-material').val(2);
					 break;
					 case "MeshNormalMaterial":
					 	$('#val-material').val(3);
					 break;
					 case "MeshStandardMaterial":
					 	$('#val-material').val(5);
					 break;
				 }
				 if(hasColorMaterial(object.material.type)){
				 		 var color = object.material.color.getHex().toString( 16 );
						 if(color.length < 6){
							 for(var i =0; i<6-color.length+1;i++)
							 	color="0"+color;
						 }
						 var found = false;
						 $('#val-color option').each(function(){
							 if(color == $(this).val()){
								 $("#val-color").val(color);
								 found = true;
							 }
						 });
						 if(!found){
						 	$("#val-color").val("random");
							$("#random-color").html("#"+color);
						 }
			 		}
				 $('#object-informations').show(200);
				 var posx = object.position.x
				 var posy = object.position.y;
				 var posz = object.position.z;
				 if(object.parent.type == "Mesh"){
					 posx += object.parent.position.x;
					 posy += object.parent.position.y;
					 posz += object.parent.position.z;
					 if(object.parent.parent.type == "Mesh"){
						 posx += object.parent.parent.position.x;
						 posy += object.parent.parent.position.y;
						 posz += object.parent.parent.position.z;
					 }
				 }
				//setCameraPostion(posx,posy+200,posz+interval_limit0);
				if(animated_object != null){ // reset previous rotation value
					animated_object.rotation.x = 0;
					animated_object.rotation.y = 0;
					animated_object.rotation.z = 0;
				}
				animated_object = object;
			 }
		 }

		 $('#val-color').change(function(){
			var material_type = "Mesh"+$( "#val-material option:selected" ).text()+"Material";
			if(hasColorMaterial(material_type)){
				 var color = $(this).val();
				 selected_object.material.color.setHex("0x"+color);
		 	}else{
				console.warn("I can't set color to this material.");
			}
		 });

		 $('#val-material').change(function(){
			 var material =  parseInt($(this).val());
			 selected_object.material = object_materials[material].clone();
			 var material_type = "Mesh"+$( "#val-material option:selected" ).text()+"Material";
			  if(hasColorMaterial(material_type)){
					 var color =  $('#val-color').val();
					 selected_object.material.color.setHex("0x"+color);
		 		}else{
			 		console.warn("I can't set color to this material.");
		 		}
		 });

		 $('#val-texture').change(function(){
			 var texture = parseInt($(this).val());
			 var a = texture_materials[texture].clone();
			 a.color = selected_object.material.color;
			 a.name = texture;
			 console.log(a);
			 selected_object.material = a;
		 });

		function setRendererTheme(theme){
			switch(theme){
				case "Dark":
					$('.content').css("background-color", "rgb(94, 96, 99)");
					renderer.setClearColor( 0x5e6063, 1 );
					scene_theme = theme;
				break;
				case "Light":
					$('.content').css("background-color", "rgb(241, 243, 243)");
					renderer.setClearColor( 0xf1f3f3, 1);
					scene_theme = theme;
				break;
				default:
					renderer.setClearColor( 0x000000, 0 );
					scene_theme = "Light";
				break;
			}
		}



		function setCameraPostion(x,y,z, zoom){
			camera.position.x = x;
			camera.position.y = y;
			camera.position.z = z;
			if(zoom != null)
				camera.zoom = zoom;
      camera.updateProjectionMatrix();
		}

		function onWindowResize() {

			camera.aspect = window.innerWidth / window.innerHeight;
			camera.updateProjectionMatrix();

			renderer.setSize( window.innerWidth, window.innerHeight );

		}

		//

		function animate() {
			requestAnimationFrame( animate );
			render();
			//stats.update();
		}

		var founded = [false,false,false];

		function render() {
			if(animated_object != null){
				if(animation_type == "camera"){
					if(!(camera.position.y <= animated_object.position.y+interval_limit &&  camera.position.y >= animated_object.position.y-interval_limit)){
						if(camera.position.y > animated_object.position.y){
							setCameraPostion(camera.position.x, camera.position.y -= increment, camera.position.z);
						}else{
							setCameraPostion(camera.position.x, camera.position.y += increment, camera.position.z);
						}
					}else{
						founded[1] = true;
					}
					if(!(camera.position.z <= animated_object.position.z+interval_limit &&  camera.position.z >= animated_object.position.z-interval_limit)){
						if(camera.position.z > animated_object.position.z){
							setCameraPostion(camera.position.x, camera.position.y, camera.position.z-= increment);
						}else{
							setCameraPostion(camera.position.x, camera.position.y, camera.position.z+= increment);
						}
					}else{
						founded[2] = true;
					}
					if(!(camera.position.x <= animated_object.position.x+interval_limit &&  camera.position.x >= animated_object.position.x-interval_limit)){
						if(camera.position.x > animated_object.position.x){
							setCameraPostion(camera.position.x -= increment, camera.position.y, camera.position.z);
						}else{
							setCameraPostion(camera.position.x += increment, camera.position.y, camera.position.z);
						}
					}else{
						founded[0] = true;
					}

					if(founded[0] && founded[1] && founded[2]){
						animated_object = null;
						founded = [false,false,false];
						//camera.updateProjectionMatrix();
						$('#Button-Stop').addClass("disabled");
					}
				}else if(animation_type == "object"){
					animated_object.rotation.z += 0.02;
					animated_object.rotation.z += 0.02;
					animated_object.rotation.y += 0.02;
				}

			}
			if(display_type == "gravity"){
				if(animated_objects != null){
					animated_objects.forEach(function(animated_object){
						animated_object.rotation.x += 0.013;
						animated_object.rotation.y += 0.013;
						animated_object.rotation.z += 0.013;
					});
				}
			}
			controls.update();
			renderer.render( scene, camera );
		}

	</script>


</html>
