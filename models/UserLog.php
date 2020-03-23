<?php


require_once('interfaces/UserLogInterface.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/3dB/utilities/StringGenerator.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/3dB/utilities/LogUtilities.php');
require_once('mysql_utilities/ConnectionFactory.php');
require_once('interfaces/MVCModelInterface.php');

class UserLog implements UserLogInterface, MVCModelInterface{
  private $id;
  private $time;
  private $user_id;
  private $type;
  private $level;
  private $info;

  public function __construct($id = 0 , $user_id = NULL, $type = NULL, $info = NULL, $level = 0, $time = null){
    if($user_id == NULL && $type == NULL & $info == NULL && $level == NULL && $time == NULL && $id != NULL){
      $this->setId($id);
    }else{
      $this->setId($id);
      $this->setTime($time);
      $this->setUserId($user_id);
      $this->setType($type);
      $this->setInfo($info);
      $this->setLevel($level);
    }
  }

  public function setId($id){
    if(isset($id)){
      if(gettype($id) == "integer"){
        $this->id = $id;
      }else throw new Exception("[MODEL ERR] UserLog - id must be an integer", 102);
    }else throw new Exception("[MODEL ERR] UserLog - id must be a not null integer" , 101);
  }

  public function getId(){
    return $this->id;
  }

  public function setTime($data){
    if(isset($data)){
      $this->time = $data;
    }else{
      $this->time = date_create()->format('Y-m-d H:i:s'); // DateTime object (MySql format)
    }
  }
  public function getTime(){
    return $this->time;
  }

  public function setUserId($id){
    if(isset($id)){
      if(filter_var($id, FILTER_VALIDATE_EMAIL)) {
        if($this->checkUserId($id)){
          $this->user_id = $id;
        }else throw new Exception('[MODEL ERR] UserLog: user email not present', 100);
      }else throw new Exception('[MODEL ERR] UserLog: email invalid format', 102);
    }else throw new Exception('[MODEL ERR] UserLog: invalid user id. It can\'t be null', 101);
  }

  public function getUserId(){
    return $this->user_id;
  }

  private function checkUserId($id){
    $cf = new ConnectionFactory();
    $conn = $cf->connect();
    $response = $conn->query("SELECT email FROM users WHERE email='".$id."';")
    or die(print_r($conn->errorInfo(),true));
    $data = $response->fetch(PDO::FETCH_ASSOC);
    $cf->disconnect();
    if($data){
      return true;
    }else return false;
  }

  public function setType($type){
    if(isset($type)){
      if(in_array($type, LogUtilities::getAdmissibileLogTypes())){
        $this->type = $type;
      }else throw new Exception('[MODEL ERR] UserLog: type is not admissibile - Admissibile types: ACCESS , USER , DATA , 3D', 401);
    }else throw new Exception('[MODEL ERR] UserLog: invalid type. It can\'t be null', 101);
  }

  public function getType(){
    return $this->type;
  }

  public function setInfo($info){
    if(isset($info)){
      if(strlen($info)>1){
        $this->info = $info;
      }else throw new Exception('[MODEL ERR] UserLog: invalid infp. invalid length' , 201);
    }else throw new Exception('[MODEL ERR] UserLog: invalid info. It can\'t be null', 101);
  }

  public function getInfo(){
    return $this->info;
  }

  public function setLevel($level = 0){
    if($level >= 0){
      if($level <= 5){
        $this->level = $level;
      }else throw new Exception('[MODEL ERR] UserLog: invalid level it must be lower or equal to 5', 101);
    }else throw new Exception('[MODEL ERR] UserLog: invalid level it must be grater or equal to 0', 101);
  }

  public function getLevel(){
    return $this->level;
  }

  /* DATA TIER */

    public function update(){
      /* to check */
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $query = SqlQueryGenerator::updateStatement($this);
      var_dump($query);
      $conn->exec($query)
      or die(print_r($conn->errorInfo(),true));
      $cf->disconnect();
      $cf = NULL;
      return true;
    }


    public function save(){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $conn->exec(SqlQueryGenerator::insertStatement($this))
      or die(print_r($conn->errorInfo(),true));
      $cf->disconnect();
      $cf = NULL;
      return true;
    }

    public static function getAll(){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $response = $conn->query(SqlQueryGenerator::selectAllStatement("userlogs"))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetchAll();
      $userlogs = [];
      $cf->disconnect();
      foreach($data as $userlog){
        $u = new UserLog((int)$userlog["id"], $userlog["user_id"],$userlog["type"],$userlog["info"],$userlog["level"], $userlog["timestamp"]);
        array_push($userlogs, $u);
      }
      return $userlogs;
    }

    public static function getAllFromUserId($user_id){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('userlogs','user_id', $user_id))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetchAll();
      $userlogs = [];
      $cf->disconnect();
      foreach($data as $userlog){
        $u = new UserLog((int)$userlog["id"], $userlog["user_id"],$userlog["type"],$userlog["info"],$userlog["level"], $userlog["timestamp"]);
        array_push($userlogs, $u);
      }
      return $userlogs;
    }



    public function delete(){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $conn->exec(SqlQueryGenerator::deleteStatement('userlogs', 'id', $this->getId()))
      or die(print_r($conn->errorInfo(),true));
      $cf->disconnect();
      $cf = NULL;
      return true;
    }

    public function load(){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('userlogs','id', $this->getId()))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetch(PDO::FETCH_ASSOC);
      $cf->disconnect();
      if($data){
        $this->setTime($data["timestamp"]);
        $this->setUserId($data["user_id"]);
        $this->setType($data["type"]);
        $this->setInfo($data["info"]);
        $this->setLevel($data["level"]);
        return true;
      }else
        return false;
    }


}

/* TEST ON CLASS
$a = new UserLog(0,"mario1.rossi@gmail.com", "ACC", "login");
$a->save();
$b = new UserLog(12);
if($b->load()){
  var_dump($b);
  $b->delete();
}else{
  echo("uselog with id 12 is not present!");
}
echo("<br><br>");
var_dump($a);
echo("<br><br>");
var_dump(UserLog::getAll());
echo("<br><br>");
var_dump(UserLog::getAllFromUserId("mario1.rossi@gmail.com"));

*/




?>
