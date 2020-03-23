<?php

interface ConnectionFactoryInterface{

  public function setDatabase($db);
	public function connect();
  public function disconnect();
  public function useDefault();
  public function useDB();
  public function printMessages();
  
}

?>
