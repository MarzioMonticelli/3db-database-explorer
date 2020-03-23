<?php


interface DBTableInterface{
	public function getName();
	public function setName($name);
	public function getColumns();
	public function setColumns($cols);
	public function addColumn($col);
	public function removeColumn($col);
	public function setCharEncoding($char_encoding);
	public function getCharEncoding();
}

?>
