<?php
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/controllers/AuthController.php");

$AuthController = new AuthController();
$isauth = $AuthController->isAuth();
if(!$isauth){
	$AuthController->logout();
	header("Location: http://localhost/IG%20FINAL%20PROJECT/3dB/");
}

?>
