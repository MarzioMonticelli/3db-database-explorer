<?php


interface DBDatabaseInterface{

  public function setName($name);
  public function getName();
  public function setEncoding($encoding);
  public function getEncoding();
  public function setId($id);
  public function getId();
  public function setTables($tables);
  public function getTables();
  public function addTable($table);
  public function removeTable($table);


}


?>
