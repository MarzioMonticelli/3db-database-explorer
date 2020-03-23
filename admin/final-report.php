<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>3dB - Final Report</title>

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
                    <a class="navbar-brand" href="#">Final Report</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                           <a href="#">
                                <i class="fa fa-search" style="margin-right:20px;"></i>
																<input type="text"  class="btn" placeholder="search..." id="search" style="margin:0px; padding:0px;cursor:auto;"/>
                            </a>
                        </li>
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

                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
							<div class="row text-center" style="background-color:#a94442; color:#fff; height:auto;padding-bottom:20vh;">
								<img src="assets/img/report/logo_sapienza.png" style="width:30%; margin-top:10vh;margin-bottom:10vh;">
								<h1 class="col-md-12"> INTERACTIVE GRAPHICS</h1>
								<h3>FINAL REPORT</h3>
								<h4>Date: <b>26/09/2017</b></h4>
								<h4>Student: <b>Marzio Monticelli</b>(1459333)</h4>
								<h4>Professor: <b>Marco Schaerf</b></h4>
							</div>
							<div class="row" style="padding:10vh;background-color:#ffffff;">
									<div class="col-md-1"></div>
									<div class="col-md-10">
										<h2> <b> Introduction </b></h1>
										<h4>Aims and final results about the developed application with particular care about the developing process</h4>
										<p style="margin:2vw;font-size:20px;">
											The project is based on the idea to develop a <b> 3D Web Service </b> to manage databases
											and see in visual way a 3D representation of data space through simply web interfaces. The developed application
											allows to organize all the structures created by the final user in a spatial way. <br>
											It could be used to present database based projects in a physical representation.
											It's clear that this kind of data representation is more effective when structures' complexity increase,
											moreover, in a real application context, it permits to have a complete vision on the data tier and to perform a better
											analysis about how data is stored and organized.
											<br><br>
											This presentation will focus on three sections: <br><br>
											<b style="font-size:23px">WEB APPLICATION</b> <br>
											Will present in general how the web application was developed, the used architecture, the web APIs and technical aspects about the used technologies.<br><br>
											<b style="font-size:23px">WEBGL AND THREE.JS</b><br>
											Will present how the 3D representation was implemented with particular attention on used environment, addressed
											choices about technologies, used libraries and implemented functionalities. In general the second part will present
											detailed informations about technical aspects of the project and implemented interactions.<br><br>
											<b style="font-size:23px">SETUP AND RUN</b> <br>
											This section explains how to setup the project and run it on a the local machine, the needed technologies and versions.<br><br>
										</p>
									</div>
									<div class="col-md-1"></div>
							</div>

							<div class="row" style="padding:4vh;background-color:#f7f7f7;">
									<div class="col-md-1"></div>
									<div class="col-md-10">
										<h2><b>Web Application Overview</b></h1>
										<h4>This section show informations about the Architecture, the Data Tier, the Logic Tier, the Presentation Tier and Exposed API services</h4>
										<h3 style="margin-top:5vh;"><b>MVC</b> Architecture Pattern</h3>
										<p style="margin:2vw;font-size:20px;">
											The application is developed with Model View Controller software architectural pattern.
											It is divided into three interconnected parts: Models , Views and Controlled.
											This is done to separate internal representations of information from the ways information is presented to,
											and accepted from, the user.<br><br>
											<i>
											The MVC design pattern decouples these major components allowing for efficient code reuse and parallel development.
											Traditionally used for desktop graphical user interfaces (GUIs), this architecture has become popular for designing
											 web applications and even mobile, desktop and other clients Popular programming languages like Java, C#, Ruby, PHP
											 and others have popular MVC frameworks that are currently being used in web application development straight out of the box.
											 <br><br><b>The Goal</b> of this particular architectural pattern is the <b>Simultaneous development</b> and the  <b>Code reuse:</b><br>
											 Because MVC decouples the various components of an application, developers are able to work in parallel on different components
											 without impacting or blocking one another. For example, a team might divide their developers between the front-end and the
											 back-end. The back-end developers can design the structure of the data and how the user interacts with it without requiring
											 the user interface to be completed. Conversely, the front-end developers are able to design and test the layout of the application
											 prior to the data structure being available.<br>
											 By creating components that are independent of one another, developers are able to reuse components quickly and
											 easily in other applications. The same (or similar) view for one application can be refactored for another
											 application with different data because the view is simply handling how the data is being displayed to the user.
										  </i>
										</p>
										<div class="text-center col-md-6" style="margin-top:4vh;">
											<img src="assets/img/report/mvc.png" style="width:50%; margin-top:5vh;margin-bottom:10vh;">
										</div>
										<div class="col-md-6" style="margin-top:1vh;">
												<h3 style="margin-bottom:3vh;"><b>Components Interaction</b></h3>
												<p style="margin:0vw;font-size:20px;">
													Interacting with the views (interfaces) User calls Controllers functions that manupulates models relative to information
													he wants to change or retrieve. The model is delegated to manage interactions between Logic and Data tier.<br>
													The functions belonging to the Logic tier are managed by Controllers, while functions interacting with Data tier are
													inserted inside Models so that a model can directly update its informations retrieving them from the Data tier, throught
													some support modules (classes). <br>
													Models have also the responsability to update the views changing informations displayed to the user. Through the Controllers'
													functions the User makes requests to Controllers that manipulate, as explained before, relative Models have the aim to update Views.
												</p>
										</div>
										<h3 class="col-md-12" style="margin-top:5vh;"><b>Data</b> Tier</h3>
										<p class="col-md-12" style="margin:2vw;font-size:20px;">
											Data tier is realized with <a href="https://www.mysql.com/it/">MySQL</a>(vrs. 5.0.12-dev) and in particular managed with
											<a href="https://www.phpmyadmin.net/">phpMyAdmin</a>(vrs 4.6.5.2) technology.<br><br>

											<i>
											<b>phpMyAdmin</b> is a free software tool written in PHP, intended to handle the administration of MySQL over the Web.
											 phpMyAdmin supports a wide range of operations on MySQL and MariaDB. <br>
											 Frequently used operations (managing databases,tables, columns, relations, indexes, users, permissions, etc)
											 can be performed via the user interface, while you still have the ability to directly execute any SQL statement.
										  </i><br><br>

											As we can see from the following image the final data structure is quite simple and it is composed by 7 entities that could be
											easily interpretated.
										</p>
										<img class="col-md-12" src="assets/img/report/dbschema.png" style="width:100%; margin-top:5vh;margin-bottom:10vh;">
										<p class="col-md-12" style="margin:2vw;font-size:20px;">
											In particular <b>Object3D</b> table was designed to contains all the informations about position, size, kind of material, alpha value, color and texture
											of the objects are represented during <b>3D Experience</b>. The value <b>referto</b> is used to store the identifier of objects are
											represented to those specific coordinates.
											It was decided to accomplish 3dobject connection to other entitites without the foreign keys, because of it simplifies data tier and it decreases its complexity.
											Data correctness is checked and managed inside the Model relative to object3d table in which some functions are developed to avoid that a single record
											will be pointed by different entities. At the same time the other side correctness is checked because of we don't want that a single entity can be represented
											by multiple 3dobject (Every single object must be represented by one and only one 3dobject in the scene).
										</p>

										<h3 class="col-md-12" style="margin-top:5vh;"><b>Logic</b> Tier and <b>API</b> services</h3>
										<p class="col-md-12" style="margin:2vw;font-size:20px;">
											<b>Logic Tier</b> and in general the application was realized with <a href="http://php.net/">PHP</a> (vrs. 7.1.1).
											<br> PHP is an Object Oriented programming language useful to realize server side application (also a mobile application was
											developed but it is not presented in this document) and it was used to code logic tier and all nedded structures as well.<br>
											By architectural point of view business logic is integrated  in Models and Controllers. For each entity, relative Model deals
											in take care of data representation and it implements all functions needed to the abstracted logic. It is the central component
											of the architectural pattern because it expresses the application's behavior in term of the problem domain, it also directly manage,
											as explained, rules of the application.
										</p>
										<img class="col-md-12" src="assets/img/report/logic1.png" style="width:100%; margin-top:5vh;margin-bottom:10vh;">
										<p class="col-md-12" style="margin:2vw;font-size:20px;">
											As we can see in the next section inside the application 3D objects' position and other informations about Models are tracked.
											To a better experience in navigation and 3D Models' manipulation it was necessary to develop an <b>API system</b> that permits
											to update, without page reloading, informations about Environment's state and objects' representation.
											Api service was developed with the <b>RESTFULL</b> paradigm so that users can consume exposed services after an autentication
											maded through a personal <b>Api Key</b> assigned at registration time.<br>
											In this sense we can see Interfaces, and in general the Logic tier, as a Client that consume Server's services.
											This choice was maded because of reasons explained in the quoted text that fallows.<br><br>
											<i>
												<b style="font-size:24px;">REST architectural style properties</b>:<br><br>
												Performance - component interactions can be the dominant factor in user-perceived performance and network
												efficiency.<br>
												Scalability to support large numbers of components and interactions among components. Roy Fielding, one of the
												principal authors of the HTTP specification, describes REST's effect on scalability as follows:<br>
												REST's client–server separation of concerns simplifies component implementation, reduces the complexity of connector
												semantics, improves the effectiveness of performance tuning, and increases the scalability of pure server components.
												 Layered system constraints allow intermediaries—proxies, gateways, and firewalls—to be introduced at various points
												 in the communication without changing the interfaces between components, thus allowing them to assist in
												 communication translation or improve performance via large-scale, shared caching. REST enables intermediate
												 processing by constraining messages to be self-descriptive: interaction is stateless between requests, standard
												 methods and media types are used to indicate semantics and exchange information, and responses explicitly indicate
												cacheability.<br><br>
												<b>Simplicity</b> of a uniform Interface<br>
												<b>Modifiability</b> of components to meet changing needs (even while the application is running)<br>
												<b>Visibility</b> of communication between components by service agents<br>
												<b>Portability</b> of components by moving program code with the data<br>
												<b>Reliability</b> is the resistance to failure at the system level in the presence of failures within
												components, connectors, or data<br><br>
											</i>
										</p>

										<h3 class="col-md-12" style="margin-top:5vh;"><b>Presentation</b> Tier</h3>
										<p class="col-md-6" style="font-size:20px;margin-top:3vh;">
											Presentation tier was realized with <a href="https://it.wikipedia.org/wiki/HTML">HTML5</a> and <a href="https://it.wikipedia.org/wiki/CSS">CSS</a>.
											<br><a href="http://getbootstrap.com/">Bootstrap</a> (light) library is also used to make the application responsive.
											Complex interactions and all dynamic behaviors was realized with <a href="https://it.wikipedia.org/wiki/JavaScript">Javascript</a> in particular
											with <a href="https://jquery.com/">jQuery</a> library through which HTML elements, DOM structure and Async. calls are managed, meanwhile
											<a href="https://threejs.org/">Three.js</a> was used as 3D Environment, but we discuss in detailed way about it in the next sections.
										</p>
										<div class="col-md-6">
											<img src="assets/img/report/presentation1.png" style="width:100%;margin-bottom:10vh;margin-top:3vh;">
										</div>
									</div>
									<div class="col-md-1"></div>
							</div>
							<div class="row" style="padding:10vh;background-color:#ffffff;">
									<div class="col-md-1"></div>
									<div class="col-md-10">
										<h2><b>3D Environment:</b> <b> WebGL</b> and <b>Three.js</b></h1>
										<h4>Detailed report about technological choices, code and user functionalities</h4>
										<h3 class="col-md-12" style="margin-top:5vh;">The <b>Environment</b></h3>
										<p style="margin:2vw;font-size:20px;">
											<a href="http://localhost/IG%20FINAL%20PROJECT/3dB/admin/3D-experience.php">3D Experience</a> was developed with <b>Three.js</b>
											that allows the creation of GPU-accelerated 3D animations using the JavaScript language as part of a website without
											relying on proprietary browser plugins. This is possible thanks to the advent of WebGL. High-level libraries
											such as Three.js or GLGE, SceneJS, PhiloGL or a number of other libraries make it possible to author complex
											3D computer animations that display in the browser without the effort required for a traditional standalone
											application or a plugin.<br>
											<b>Three.js</b> is characterized by the following features:<br><br>
											<b>Effects</b>: Anaglyph, cross-eyed and parallax barrier.<br>
											<b>Scenes</b>: add and remove objects at run-time; fog<br>
											<b>Cameras</b>: perspective and orthographic; controllers: trackball, FPS, path and more<br>
											<b>Animation</b>: armatures, forward kinematics, inverse kinematics, morph and keyframe<br>
											<b>Lights</b>: ambient, direction, point and spot lights; shadows: cast and receive<br>
											<b>Materials</b>: Lambert, Phong, smooth shading, textures and more<br>
											<b>Shaders</b>: access to full OpenGL Shading Language (GLSL) capabilities: lens flare, depth pass and extensive post-processing library<br>
											<b>Objects</b>: meshes, particles, sprites, lines, ribbons, bones and more - all with Level of detail<br>
											<b>Geometry</b>: plane, cube, sphere, torus, 3D text and more; modifiers: lathe, extrude and tube<br>
											<b>Data loaders</b>: binary, image, JSON and scene<br>
											<b>Utilities</b>: full set of time and 3D math functions including frustum, matrix, quaternion, UVs and more<br>
											<b>Export and import</b>: utilities to create Three.js-compatible JSON files from within: Blender, openCTM, FBX, Max, and OBJ<br>
											<b>Support</b>: API documentation is under construction, public forum and wiki in full operation<br>
											<b>Examples</b>: Over 150 files of coding examples plus fonts, models, textures, sounds and other support files<br>
											<b>Debugging</b>: Stats.js, WebGL Inspector, Three.js Inspector<br>
											Three.js runs in all browsers supported by WebGL 1.0.<br><br>

											This library is based on <b>WebGL</b>  is a JavaScript API for rendering 3D graphics within any compatible
											web browser without the use of plug-ins. WebGL is integrated completely into all the web standards of the
											browser allowing GPU accelerated usage of physics and image processing and effects as part of the web page
											canvas. Its elements can be mixed with other HTML elements and composited with other parts of the page or
											page background. WebGL programs consist of control code written in JavaScript and shader code that is
											written in OpenGL Shading Language (GLSL), a language similar to C or C++, and is executed on a computer's
											graphics processing unit (GPU).
										</p>
										<h3 class="col-md-12" style="margin-top:5vh;"><b>Libraries</b>, <b>Tools</b> and <b>Models</b></h3>
										<br><br>
										<p style="margin:2vw;font-size:20px;">
											The list the follows contains information about libraries and tools are used to develop the 3D Experience that will be
											showed and explained in detail in the next section.<br><br>
											<b style="font-size:25px;">Generals:</b><br><br>
											<b style="font-size:22px; color:#a94442;">jQuery</b><br><br>
											jQuery is a fast, small, and feature-rich JavaScript library. It makes things like HTML document traversal
											and manipulation, event handling, animation, and Ajax much simpler with an easy-to-use API that works across
											a multitude of browsers. With a combination of versatility and extensibility, jQuery has changed the way that
											millions of people write JavaScript.<br><br>
											<b style="font-size:22px;color:#a94442;">Bootstrap</b><br><br>
											Bootstrap is an open source toolkit for developing with HTML, CSS, and JS. Quickly prototype your ideas or
											build your entire app with our Sass variables and mixins, responsive grid system, extensive prebuilt components,
											and powerful plugins built on jQuery.<br><br>
											<b style="font-size:22px;color:#a94442;">Bootstrap Checkbox and Radio Switch:</b><br><br>
											It is a bootstrap plugins that as the aim to manage checkboxes and radio switchers. It permits to retrieve
											in easily way information, change interface representation and behaviours of radio and switcher components.<br><br>
											<b style="font-size:22px;color:#a94442;">Chartist</b><br><br>
											Chartist.js is the product of a community that was disappointed about the abilities provided by other charting libraries.
											Of course there are hundreds of other great charting libraries but after using them there were always tweaks you
											would have wished for that were not included.<br><br>
											<b style="font-size:22px;color:#a94442;">Bootstrap notify</b><br><br>
											Bootstrap Notify is a jQuery plugin to provide simple yet fully customisable notifications. The javascript
											code snippets in this documentation with the green edge are runnable by clicking them.<br><br>
											<b style="font-size:22px;color:#a94442;">Light Bootstrap Dashboard</b><br><br>
											Light Bootstrap Dashboard is an admin dashboard template designed to be beautiful and simple.
											It is built on top of Bootstrap 3 and it is fully responsive. It comes with a big collections of
											elements that will offer you multiple possibilities to create the app that best fits your needs.
											It can be used to create admin panels, project management systems, web applications backend, CMS or CRM.<br><br><br>
											<b style="font-size:25px;">WebGL:</b><br><br>
											<b style="font-size:22px;color:#a94442;">Three.js</b><br></br>
											See previous section: The <b>Environment</b><br></br>
											<b style="font-size:22px;color:#a94442;">Drag Controls</b><br></br>
											Drag Controls is a WebGL extension to manage drag controls inside the scene. Through this library you can drag object in the scene by
											the catching of specified events with Javascript Event Listeners.<br><br>
											<b style="font-size:22px;color:#a94442;">Trackball Controls</b><br></br>
											It permits you to use Trackball controls to pan and move the camera around the scene, moreover it can be used to move the object around
											with the support of drag controls extension. With the trackball controls, you can very easily use your mouse to move the camera around the scene.<br><br>
											<b style="font-size:22px;color:#a94442;">Stats</b><br></br>
											It permits to render statistics connect to the GPU and the scene renderization.<br></br>
											<b style="font-size:24px;">Renderer:</b><br><br>
											<b style="font-size:22px;color:#a94442;">Projector</b><br><br>
											It is an extention to make vectors projection, it also useful to calculate intersections between mouse directrix and objects in the scene.
										</p>
										<h3 class="col-md-12" style="margin-top:5vh;"><b>Technical Aspects</b> and <b>Implemented Interactions</b></h3>
										<p style="margin:2vw;font-size:20px;">
											To create <b>Scene</b>it was used a simple HTML div in which 3D object are renderized through the core render() function that
											deals in updating <b>controls</b> and to call the <b>render</b> function.<br>
											The render is accomplished by <b>THREE.WebGLRenderer</b> that is created and instantiated in the initialization function.<br>
											In the Initialization function all precalculated objects are created and inserted inside the <b>Scene</b>. <br>
											To create the complex tree structure a complex javascript object was created, it has the aim to mantain the whole informations about objects' dependecies and physical connections.
											Each complex object represent a <b>Database</b> structure, that is created as an objects composed by children with <b>autonomous</b> behaviour. Each <b>Database</b> is composed by a
											set of <b>Tables</b> and each Table is composed by a set of <b>Columns</b>. The Hierarchy between objects is underlined
											by positions, size, connections and even animations.<br>
											The object <b>DatabaseStruct</b> is composed by an identifier (multiple complex objects are inserted inside the Scene) , a base size used to define the difference between objects' size
											in relation to the explained hierarchy, the default informations about first object's position, default material for objects inside the "class", the default material for lines that connects
											each object to his direct father, what kind of controller the user wats to use for the specific complex object, and the texture is selected for a specified object inside the set of objects
											in the structure.<br><br>
											Follow the complete code of the function that initialize the Scene:
										</p>
										<img src="assets/img/report/init.png" style="width:100%;margin-bottom:10vh;margin-top:3vh;">
										<p style="margin:2vw;font-size:20px;">
											As we can see also lights and camera are initialized inside the function. <b>PHP</b> code is used to print and create the javascript code required to build all the complex objects relative to
											registered user. The function <b>createObject</b> is delegated to effectively create the specific object inside the DatabaseStruct while the function <b>connect</b>
											,belonging to the same class, create a line object that connects father and children in the Scene.  When an object is connected to another one, that object is inserted inside the children
											of the <b>Mesh</b> Object so that in DatabaseStruct's objects set is mantained only one <b>Mesh</b> that is the reference to a specified Database created thorough the interfaces in the administration panel.<br><br>

											<b>DatabaseStruct</b> object has other functions with which can be generated a spefied number of children for a specific object. It also manage the interaction between its structure and the data
												stored inside the physical storage through the call of the right <b>API endpoint</b>.
										</p>
										<img src="assets/img/report/js2.png" style="width:100%;margin-bottom:10vh;margin-top:3vh;">
										<p style="margin:2vw;font-size:20px;">
											When an object is clicked or dragged a information panel is displayed. It contrains informations about object position, alpha value, used material, used texture and used color. Through this panel
											you can also change material, texture and color of the specified object.<br>
											A complete vision of how much objects are present in scene and how they are organized is also showed when the first button in the top bar is clicked. Scene details are also showed in another
											panel that appears when the <b>show details</b> voice is clicked (principal navigation menu).<br><br>
											The user can intact directly with all the object in the scene changing the position that is asynchronous updated in the physical storage. When an object is moved all his children, in autonomous way,
											are updated because of the hierarchy previous explained. Only object's children are updated when their father is moving, moreover line connecting objects are recreated to respect new objects position.<br><br>
											When an object is clicked, the object and his children are underlined in two different selectable kind: <b>Object Animation</b> and <b>Camera Animation</b>.<br>
											If <b>Object animation</b> is selected the <b>animation_type</b> variable is updated and selected object  is underlines by a <b>Gravity</B> simulation so that its children start to gravitate around the object that rotate on x,y and z axis.
											The <b>Gravity</b> simulation was easily created by changing the rotation of the selected object in the <b>render</b> function.
										</p>
										<img src="assets/img/report/render.png" style="width:100%;margin-bottom:10vh;margin-top:3vh;">
										<p style="margin:2vw;font-size:20px;">
											In the other case if <b>Camera Animation</b> is selected the camera is moved until the object fit the screen. This animation is managed by two variables: <b>interval limit</b> and <b>increment</b>;
											The first is used to set a space interval in which stop the camera so that to fit the object in the <b>camera view</b> while the increment is the factor added to the camera position coordinate between one renderization step and the next.<br>
											The user can manage these variables by clicking <b>Speed</b> and <b>Precision</b> buttons on the top of the screen. When one of this buttons are clicked a panel showing the parameters value is displayed.<br><br>
											If <b>No Animation</b> is choosed, the mesh was selected is not underlined and user can navigate the scene through  W-S-A-D keys on his keyboard.<br><br>
											The user can also reset camera position by clicking the <b>Reset Camera</b> voice in the left side menu. When it is clicked the function <b>setCameraPosition</b> is called and it change the camera coordinates to the
											initial position, resetting the fov and all camera's parameters to default values.
											By clicking <b>Disable Drag</b> voice, global drag controls are disabled by disablig drag controls of each complex structure present in the scene. Disabling the drag, user can navigate the scene witout modifing any object position.<br><br>

											Because of Javascript limitations, <b>Textures</b> are precalculated and renderized inside specified materials. The materials are applied to the selected Mesh only when the user changes the field relative to Texture application.<br>
											As we can notice in the init function at line 1716, after that all DatabaseStrct are builded the function <b>createTextureMaterial</b> is called. This function create the material after that the specified texture is loaded by
											the <b>Texture loader</b>. From the fact that javascript runs on a single thread and images uploading process is an expensive operation in term of resource and time, texture are inserted initially in a global array and are applied to specific mesh only after
											that all texture are loaded. Until all texture are not applied, global interface is blocked with a graphic loader.<br><br>

											Created Databases could be displayed with two different visualization: <b>Graph vh iew</b> or <b>Gravity view</b>.<br>
											The first was is showed in the previous images while the second apply the <b>Gravity</b> effect explained before to the whole structures in the scene.
											If both <b>Gravity view</b> and <b>Object animation</b> are selected the rotation effect on the axis is cumulated;<br><br>

											Selecting the world icon on the top section menu, user can change scene background color choosing between a light or a darker version. The global information about Scene configuration are not stored in any storage but could be reapplied in simple way.
											If <b>Dark</b> theme is selected and an object is dragged or clicked, line's material are checked: if material color is not in contrast with the theme a contrast color is selected and lines that connects the specific object are updated. The same behaviour
											is applied when <b>Lighter</b> theme is selected.
										</p>
									</div>
									<div class="col-md-1"></div>
							</div>
							<div class="row" style="padding:4vh;background-color:#f7f7f7;">
									<div class="col-md-1"></div>
									<div class="col-md-10">
										<h2><b>Setup and Run</b></h1>
										<h4>This section explains how to setup the project and run it on a the local machine, the needed technologies and versions.</h4>
										<h3 style="margin-top:5vh;"><b>XAMPP</b> - All you need</h3>

										<p style="margin:2vw;font-size:20px;">
											If you work on Windows, Linux or OS X you can use XAMPP to setup all you need to run this project on your local machine.<br>
											XAMPP is the most popular PHP development environment, is a completely free, easy to install Apache distribution containing MariaDB, PHP, and Perl. The XAMPP open source package has been set up to be incredibly easy to install and to use. <br>
											If you don't know how to install XAMPP on your machine you can easily foud the procedure on the <a href="https://www.apachefriends.org/index.html">official site</a>.<br><br>
										</p>
										<img src="assets/img/report/xampp.png" style="width:100%;margin-bottom:10vh;margin-top:3vh;">
										<p style="margin:2vw;font-size:20px;">
											If you have successfully installed XAMPP now you can copy files contained in the directory called <b>3dB</b> inside the local server directory (on Windows usually at C:\xampp\htdocs).
											<br> After this step you have to run <b>XAMPP.exe</b> and starts <b>Apache</b> and <b>MySql</b> services through XAMPP interface.
										</p>
										<img src="assets/img/report/xampp1.png" style="width:100%;margin-bottom:10vh;margin-top:3vh;">
										<p style="margin:2vw;font-size:20px;">
											In the project directory you can found a subdirectory called <b>Documentation</b>, inside this directory you can found the <b>3dbcentral.sql</b> file that you have to import through <b>phpMyAdmin</b> interface.<br>
											To open <b>phpMyAdmin</b> you have to visit in your browser the address http://localhost/dashboard/. If you server is running you should see the panel presented in the first image of this section.<br>
											By clicking on <b>phpMyAdmin</b> you can address the interface through which you have the possibility to import <b>3dbcentral</b> database.<br>
											<img src="assets/img/report/mysql.png" style="width:100%;margin-bottom:10vh;margin-top:3vh;">
											At the end of this simple procedure you can see the site at the location http://localhost/3dB/index.php. In this page first of all you have to register a new Account that allows to you to enter in your private section (dashboard.php).
											In your private section you can add new Databases, Tables and Columns, change your informations and see the tracked history of your account.
										</p>
										<h3 style="margin-top:5vh;">Recommendation</h3>
										<p style="margin:2vw;font-size:20px;">
											<b>MySQL version 5.0.12 </b><br>
											<b>phpMyAdmin version 4.6.5.2 </b><br>
											<b>PHP version 7.1.1 </b><br>
										</p>

									</div>
									<div class="col-md-1"></div>
						  </div>

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


    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

	<script type="text/javascript">
    	$(document).ready(function(){

        	$.notify({
            	icon: 'pe-7s-smile',
            	message: "Here an HTML version of the <b>Final Report</b> about the project"

            },{
                type: 'danger',
                timer: 4000
            });

    	});
	</script>

</html>
