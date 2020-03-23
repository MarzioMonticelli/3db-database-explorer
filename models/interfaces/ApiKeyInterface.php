<?php

interface ApiKeyInterface{

  public function getKey();
  public function getCreationDate();
  public function setUserId($user_id);
  public function getUserId();
  public function getDeadline();
  public function restoreApiKey();
  public function isChanged();
  public function resetIsChanged();

/*
Private functions

  private function setDeadline($date);
  private function setKey($key);
  private function setCreationDate($time);
  private function generateKey($length);
  private function checkKey($key);

*/

}

?>
