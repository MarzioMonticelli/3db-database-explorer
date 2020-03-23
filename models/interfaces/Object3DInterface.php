<?php


interface Object3DInterface{
  public function setPositionX($position);
  public function setPositionY($position);
  public function setPositionZ($position);
	public function getPositionX();
	public function getPositionY();
  public function getPositionZ();
  public function setMaterial($material);
  public function getMaterial();
  public function setTexture($texture);
  public function getTexture();
  public function setOpacity($opacity);
  public function getOpacity();
}

?>
