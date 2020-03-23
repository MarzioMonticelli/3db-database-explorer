<?php

require_once('interfaces/Object3DInterface.php');
require_once('mysql_utilities/ConnectionFactory.php');

class Object3D implements Object3DInterface{

  private $id;
  private $position_x;
  private $position_y;
  private $position_z;
  private $size;
  private $material;
  private $opacity;
  private $texture;
  private $color;
  private $refer_id;

  public function __construct($id = 0, $positionx = null, $positiony= null, $positionz = null, $size = 40, $refer_id = null, $material = null, $texture = null, $color = null, $opacity = 1.0){
    if(!isset($positionx) && !isset($positiony) && !isset($positionz)){
      $this->setId($id);
    }else{
      $this->setId($id);
      $this->setPositionX($positionx);
      $this->setPositionY($positiony);
      $this->setPositionZ($positionz);
      $this->setOpacity($opacity);
      $this->setReferTo($refer_id);
      $this->setSize($size);
      if($material !=null)
        $this->setMaterial($material);
      if($texture != null)
        $this->setTexture($texture);
      if($color != null)
          $this->setColor($color);
    }
	}


  public function setId($id){
    if(isset($id) && gettype($id) == "integer"){
      $this->id = $id;
    }else throw new Exception("[MODEL ERR] Object3D - id can't be null or a ".gettype($id).".", 100);
  }

  public function getId(){
    return $this->id;
  }

  public function setSize($size){
    if(isset($size) && gettype($size) == "double"){
      $this->size = $size;
    }else throw new Exception("[MODEL ERR] Object3D - size can't be null or a ".gettype($size)." equal to " . $size . ".", 100);
  }

  public function getSize(){
    return $this->size;
  }
  public function setReferTo($refer_id){
    if(isset($refer_id)){
        $this->refer_id = $refer_id;
    }else throw new Exception("[MODEL ERR] Object3D - refer id can't be null.", 100);
  }

  public function getReferto(){
    return $this->refer_id;
  }

  public function usableReference($refer_id){
    if(Object3D::getObject3DReference($refer_id) == false){
      return true;
    }else
      return false;
  }

  public function setPositionX($position){
    if(isset($position) && $position != null || $position == 0){
      if(gettype($position) == "double"){
        $this->position_x = $position;
      }else throw new Exception("[MODEL ERR] Object3D - position x invalid type(".gettype($position).").",102);
    }else throw new Exception("[MODEL ERR] Object3D - position x can't be null or ".$position.".", 100);
  }

  public function setPositionY($position){
    if(isset($position) && $position != null || $position == 0){
      if(gettype($position) == "double"){
        $this->position_y = $position;
      }else throw new Exception("[MODEL ERR] Object3D - position y invalid type.",102);
    }else throw new Exception("[MODEL ERR] Object3D - position y can't be null or ".$position.".", 100);
  }

  public function setPositionZ($position){
    if(isset($position) && $position != null || $position == 0){
      if(gettype($position) == "double"){
        $this->position_z = $position;
      }else throw new Exception("[MODEL ERR] Object3D - position z invalid type.",102);
    }else throw new Exception("[MODEL ERR] Object3D - position z can't be null or ".$position.".", 100);
  }

	public function getPositionX(){
    return $this->position_x;
  }

	public function getPositionY(){
    return $this->position_y;
  }
  public function getPositionZ(){
    return $this->position_z;
  }

  public function setMaterial($material){
    if(isset($material) && $material != null){
      $this->material = $material;
    }
  }

  public function getMaterial(){
    return $this->material;
  }

  public function setTexture($texture){
    if(isset($texture) && $texture != null){
      $this->texture= $texture;
    }
  }

  public function getTexture(){
    return $this->texture;
  }

  public function setColor($color){
    if(isset($color) && $color != null){
      $this->color= $color;
    }
  }

  public function getColor(){
    return $this->color;
  }

  public function setOpacity($opacity){
    if(isset($opacity) && $opacity != null){
      if(gettype($opacity) == "double"){
        if($opacity >= 0.0 && $opacity <= 1.0)
          $this->opacity = $opacity;
        else throw new Exception("[MODEL ERR] Object3D - opacity invalid format it must be a double between 0.0 and 1.0.",102);
      }else throw new Exception("[MODEL ERR] Object3D - opacity invalid type.",102);
    }else throw new Exception("[MODEL ERR] Object3D - opacity can't be null.", 100);
  }

  public function getOpacity(){
    return $this->opacity;
  }

  public function save(){
    if($this->usableReference($this->refer_id)){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $ret = $conn->exec(SqlQueryGenerator::insertStatement($this))
      or die(print_r($conn->errorInfo(),true));
      $cf->disconnect();
      if($ret)
        return true;
      else
        return false;
    }else throw new Exception("[MODEL ERR] Object3D - Reference is used by another object.", 104);
  }

  public function load(){
    $cf = new ConnectionFactory();
    $conn = $cf->connect();
    $response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('object3d','id', $this->getId()))
    or die(print_r($conn->errorInfo(),true));
    $data = $response->fetch(PDO::FETCH_ASSOC);
    $cf->disconnect();
    if($data){
      $this->setPositionX((float)$data["x"]);
      $this->setPositionY((float)$data["y"]);
      $this->setPositionZ((float)$data["z"]);
      $this->setSize((float)$data["size"]);
      $this->setMaterial($data["material"]);
      $this->setOpacity((double)$data["opacity"]);
      $this->setTexture($data["texture"]);
      $this->setReferTo($data["referto"]);
      $this->setColor($data["color"]);
      return true;
    }else
      return false;
  }

  public function delete(){
    $res = true;
    $this->load();
    $cf = new ConnectionFactory();
    $conn = $cf->connect();
    $res = $res && $conn->exec(SqlQueryGenerator::deleteStatement('object3d', 'id', $this->getId()))
    or die(print_r($conn->errorInfo(),true));
    $cf->disconnect();
    $cf = NULL;
    if($res)
      return true;
    else
      return false;
  }

  public function update(){
    $cf = new ConnectionFactory();
    $conn = $cf->connect();
    $query = SqlQueryGenerator::updateStatement($this);
    $res = $conn->exec($query)
    or die(var_dump($conn->errorInfo()));
    $cf->disconnect();
    $cf = NULL;
    if($res)
      return true;
    else
      return false;
  }

  public static function getObject3DReference($ref_id){
    $cf = new ConnectionFactory();
    $conn = $cf->connect();
    $response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('object3d','referto', $ref_id));
    $data = $response->fetch(PDO::FETCH_ASSOC);
    if($response && $data != false){
      return new Object3D(
        (int)$data["id"],
        (float)$data["x"], (float)$data["y"], (float)$data["z"],
        (float)$data["size"],
        $ref_id, $data["material"], $data["texture"],$data["color"], (double)$data["opacity"]
      );
    }else{
      return false;
    }
  }

}



/* TEST ON CLASS

$o = new Object3D(4323, 12.34, 0.45, 34.430, 30.0, "5fdsfdsfsdfbgsd5", "material1", "texture.jpg","ffffff",0.5);
var_dump($o);
$o->save();
$o->setColor("0000000");
$o->update();
$o->load();
echo("<br><br>");
var_dump($o);
$o = new Object3D(40);
$o->load();
$o->setMaterial("newMaterial");
$o->update();
$o1 = Object3D::getObject3DReference("57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5");
var_dump($o1);

*/

?>
