<?php
require_once('ThreeDBAPI.php');
// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
  if(array_key_exists("apikey", $_REQUEST) && array_key_exists("request", $_REQUEST)){
    $API = new ThreedbAPI($_REQUEST['request'],$_REQUEST['apikey'], $_SERVER['HTTP_ORIGIN']);
    echo json_encode($API->processAPI());
  }else{
    echo '<h3> <b style="color:#EE2D20;">3DB APIs service</b> - <b>Invalid request<b></h3><p> You have to specify you <b>apikey<b> (apikey) and <b>endpoint name</b> (request)</p>';
  }
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}

?>
