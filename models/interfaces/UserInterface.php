<?php

interface UserInterface{
  public function setName($name);
	public function getName();
  public function setSurname($name);
	public function getSurname();
  public function setEmail($email);
	public function getEmail();
  public function setPassword($password);
	public function getPassword();
  public function setDescription($description);
  public function getDescription();
}

?>
