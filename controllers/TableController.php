<?php
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/UserLog.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/DBTable.php");

class TableController{
  private $request;
  private $type;
  private $errors;

  public function __construct($request = null, $type = null){
    $this->request = $request;
    $this->type = $type;
    $this->errors = [];
  }

  public function process(){
    switch($this->type){
      case "INSERT":
        $name = $this->filter($this->request["tbname"]);
        $encoding = $this->filter($this->request["tbencoding"]);
        $db = $this->filter($this->request["dbid"]);
        $requester = $this->filter($this->request["uemail"]);
        if(isset($name) && isset($encoding) && isset($db) && isset($requester)){
          $tb = new DBTable(NULL,$db,$requester, $name, $encoding);
          $s = $tb->save();
          if(!$s){
            $usrl = new UserLog(0,$requester, "DAT", "table insert - error",2);
            $usrl->save();
            $this->addError("Error during the insertion of table: " . $name . " in specific database");
          }else{
            $usrl = new UserLog(0,$requester, "DAT", "table insert - success",1);
            $usrl->save();
          }
        }else{
          $this->addError("Invalid request: " . serialize($this->request));
          $usrl = new UserLog(0,$requester, "DAT", "table insert - error - invalid request",3);
          $usrl->save();
        }
      break;
      case "DELETE":
        $requester = $this->filter($this->request["uemail"]);
        $id = $this->filter($this->request["id"]);
        if(isset($requester) && isset($id)){
          $tab = new DBTable($id);
          if($tab->delete()){
            $usrl = new UserLog(0,$requester, "DAT", "table delete - success",1);
            $usrl->save();
          }else{
            $usrl = new UserLog(0,$requester, "DAT", "table delete - error",2);
            $usrl->save();
            $this->addError("Error during the deletion of column");
          }
        }else{
          $usrl = new UserLog(0,$requester, "DAT", "table delete - ivalid request",1);
          $usrl->save();
          $this->addError("Error during the deletion of table - invalid request");
        }
      break;
      default:
        return false;
        $this->addError("Invalid request");
      break;
    }
  }

  public static function getUserDb($email){
    return DBDatabase::getAllUserDBs($email);
  }

  private function filter($data) { //Filters data against security risks.
      return $data;
  }


  public function setRequest($request){
    $this->request = $request;
  }

  public function getRequest(){
    return $this->request;
  }

  public function setType($type){
    $this->type = $type;
  }

  public function getType(){
    return $this->type;
  }

  private function addError($error){
    if(isset($error))
      if(gettype($error) == "string")
        if(strlen($error)>0)
          array_push($this->errors, $error);
        else throw new Exception("[ERR CONTROLLER] RegistrationController-  invalid error. it can't be null", 101);
      else throw new Exception("[ERR CONTROLLER] RegistrationController - invalid error. it must be a string");
    else throw new Exception("[ERR CONTROLLER] RegistrationController - invalid error. it must be a valid string");
  }

  public function getLastError(){
    if(count($this->errors)>0){
      return $this->errors[count($this->errors)-1];
    }else{
      return false;
    }
  }

  public function getErrors(){
    return $this->errors;
  }
}

?>
