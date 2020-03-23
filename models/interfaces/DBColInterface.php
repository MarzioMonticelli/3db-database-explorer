<?php 

interface DBColInterface{
	public function setName($name);
	public function getName();
	public function setPrimary($primary);
	public function isPrimary();
	public function setUnique($unique);
	public function isUnique();
	public function setType($type);
	public function getType();
	public function setLength($length);
	public function getLength();
	public function setAttributes($attributes);
	public function getAttributes();
	public function setNull($null);
	public function isNull();
	public function setDefault($default);
	public function getDefault();
	public function setAutoincrement($extra);
	public function isAutoincrement();
	public function setComments($comments);
	public function getComments();
	public function setVirtuality($virtuality);
	public function getVirtuality();
	public function setMIMEtype($mime);
	public function getMIMEtype();
	public function setTransformBrowserView($tbv);
	public function getTransformBrowserView();
	public function setTransformBrowserViewOptions($tbv_options);
	public function getTransformBrowserViewOptions();
	public function setInputTransformation($input_transformation);
	public function getInputTransformation();
	public function setInputTransformationOptions($input_transformation_options);
	public function getInputTransformationOptions();
	public function equals($col);
}

?>
