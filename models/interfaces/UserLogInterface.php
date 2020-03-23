<?php


interface UserLogInterface{

  public function setTime($data);
  public function getTime();
  public function setUserId($id);
  public function getUserId();
  public function setType($type);
  public function getType();
  public function setInfo($info);
  public function getInfo();
  public function setLevel($level);
  public function getLevel();

}


?>
