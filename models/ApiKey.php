<?php


require_once('interfaces/ApiKeyInterface.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/3dB/utilities/DateTimeUtilities.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/3dB/utilities/StringGenerator.php');
require_once('mysql_utilities/ConnectionFactory.php');
require_once('interfaces/MVCModelInterface.php');

class ApiKey implements ApiKeyInterface, MVCModelInterface{
  private $apikey;
  private $creation_date;
  private $user_id;
  private $deadline_date;
  private $ischanged;


  public function __construct($user_id = null, $key = null){
    if(isset($user_id)){
      $this->setUserId($user_id);
      $this->setKey($this->generateKey());
      $date = date_create()->format('Y-m-d H:i:s'); // DateTime object (MySql format)
      $date = new DateTime($date);
      $this->setCreationDate($date);
      $date->modify('+1 year');
      $this->setDeadline($date);
      $this->ischanged = false;
    }else{
      if(isset($key)){
        $this->apikey = $key;
      }
    }
  }

  public function toArray(){
    return [
      "apikey" => $this->apikey,
      "key_creation_date" => $this->creation_date,
      "key_deadline" => $this->deadline_date
    ];
  }

  private function setKey($apikey){
    if(isset($apikey)){
      if(gettype($apikey) == "string"){
        if(strlen($apikey)== 16){
            $loc = filter_var($apikey, FILTER_SANITIZE_STRING);
            if(!$loc === false){
              $this->apikey = $apikey;
            }else throw new Exception('[MODEL ERR] USER: name - error during filtering', 103);
          }else throw new Exception('[MODEL ERR] USER: invalid apikey', 203);
      }else throw new Exception('[MODEL ERR] USER: apikey invalid type - ' . gettype($apikey), 102);
    }else throw new Exception('[MODEL ERR] USER: invalid apikey. It can\'t be null', 101);
  }

  public function getKey(){
    return $this->apikey;
  }

  private function setCreationDate($date){
    $this->creation_date = $date->format('Y-m-d H:i:s');
  }

  public function getCreationDate(){
    return $this->creation_date;
  }

  public function setUserId($user_id){
    $this->user_id = $user_id;
  }

  public function getUserId(){
    return $this->user_id;
  }

  private function setDeadline($date){
    $this->deadline_date = $date->format('Y-m-d H:i:s');
  }

  public function getDeadline(){
    return $this->deadline_date;
  }

  private function generateKey($length = 16){
    $key = StringGenerator::randomString($length);
    $check = $this->checkKey($key);
    if($check === true){
      return $this->generateKey($length);
    }elseif($check === false){
      return $key;
    }else{
      return $check;
    }
  }

  public function isValidKey(){
    if(isset($this->apikey)){
      if($this->checkKey($this->apikey)){
        return true;
      }else{
        return false;
      }
    }else throw new Exception("[MODEL ERR] User ApiKey - invalid apikey");
  }

  private function checkKey($key){
    if(gettype($key) != "string"){
      throw new Exception("[MODEL ERR] Apikey - invalid key: " . gettype($key) ." given , String required");
    }
    $cf = new ConnectionFactory();
    $conn = $cf->connect();
    $response = $conn->query("SELECT apikey FROM apikeys WHERE apikey='".$key."';")
    or die(print_r($conn->errorInfo(),true));
    $data = $response->fetch(PDO::FETCH_ASSOC);
    if(!$data){
      $response = $conn->query("SELECT apikey FROM apikeys WHERE user_id='".$this->getUserId()."';")
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetch(PDO::FETCH_ASSOC);
      if($data){
        return $data["apikey"];
      }else{
        return false;
      }
    }else{
      $response = $conn->query("SELECT apikey FROM apikeys WHERE user_id='".$this->getUserId()."';")
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetch(PDO::FETCH_ASSOC);
      if($data){
        return $data["apikey"];
      }else{
        $cf->disconnect();
        return true;
      }
    }
  }

  public function restoreApiKey(){
    $this->setKey($this->generateKey());
    $this->ischanged = true;
  }

  public function isChanged(){
    return $this->ischanged;
  }

  public function resetIsChanged(){
    $this->ischanged = false;
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
      $check = $this->checkKey($this->getKey());
      if($check === false){
        $cf = new ConnectionFactory();
        $conn = $cf->connect();
        $res = $conn->exec(SqlQueryGenerator::insertStatement($this))
        or die(print_r($conn->errorInfo(),true));
        $cf->disconnect();
        $cf = NULL;
        if($res)
          return true;
        else return false;
      }else{
        throw new Exception("[MODEL ERR] UserKey - user ". $this->getUserId() . " can't have 2 different keys");
      }
    }

    public static function getAll(){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $response = $conn->query(SqlQueryGenerator::selectAllStatement("apikeys"))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetchAll();
      $apikeys= [];
      $cf->disconnect();
      foreach($data as $apikey){
        $a = new ApiKey($apikey["user_id"]);
        $a->setCreationDate(new DateTime($apikey["creation_date"]));
        $a->setDeadline(new DateTime($apikey["expiration_date"]));
        $a->setKey($apikey["apikey"]);
        array_push($apikeys, $a);
      }
      return $apikeys;
    }

    public function delete(){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $res = $conn->exec(SqlQueryGenerator::deleteStatement('apikeys', 'user_id', $this->getUserId()))
      or die(print_r($conn->errorInfo(),true));
      $cf->disconnect();
      $cf = NULL;
      if($res)
        return true;
      else
        return false;
    }

    public function load(){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('apikeys','user_id', $this->getUserId()))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetch(PDO::FETCH_ASSOC);
      $cf->disconnect();
      if($data){
        $this->setCreationDate(new DateTime($data["creation_date"]));
        $this->setDeadline(new DateTime($data["expiration_date"]));
        $this->setKey($data["apikey"]);
        return true;
      }else
        return false;
    }



}


/* TEST ON CLASS
$ak = new ApiKey('marzio.monticelli@gmail.com');
$ak1 = new ApiKey('mario1.rossi@gmail.com');
$ak->delete();
$ak1->load();
if($ak->save())
  var_dump($ak);

echo("<br><br>");
  var_dump($ak1);

$ak->restoreApiKey();
echo("<br><br>");
var_dump($ak);

echo("<br><br>");
var_dump(ApiKey::getAll());
*/

?>
