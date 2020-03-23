<?php

require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/UserLog.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/DBDatabase.php");

class DatabaseController{
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
        $name = $this->filter($this->request["dbname"]);
        $encoding = $this->filter($this->request["dbencoding"]);
        $serveraddress = $this->filter($this->request["dbserveraddress"]);
        $serverpassword = $this->filter($this->request["dbserverpassword"]);
        $serverusername = $this->filter($this->request["dbserverusername"]);
        $serverport = (int)$this->filter($this->request["dbserverport"]);
        $requester = $this->filter($this->request["uemail"]);
        if(isset($name) && isset($encoding) && isset($serveraddress) && isset($serverpassword) && isset($serverusername) && isset($serverport) && isset($requester)){
          $db = new DBDatabase(NULL,$name, $encoding , $requester, $serveraddress, $serverpassword, $serverusername, $serverport);
          $s = $db->save();
          if(!$s){
            $usrl = new UserLog(0,$requester, "DAT", "database insert - error",2);
            $usrl->save();
            $this->addError("Error during the insertion of database: " . $name);
          }else{
            $usrl = new UserLog(0,$requester, "DAT", "database insert - success",1);
            $usrl->save();
          }
        }else{
          $this->addError("Invalid request: " . serialize($this->request));
          $usrl = new UserLog(0,$requester, "DAT", "database insert - error - invalid request",3);
          $usrl->save();
        }
      break;
      case "DELETE":
        $requester = $this->filter($this->request["uemail"]);
        $id = $this->filter($this->request["id"]);
        if(isset($requester) && isset($id)){
          $db = new DBDatabase($id);
          if($db->delete()){
            $usrl = new UserLog(0,$requester, "DAT", "database delete - success",1);
            $usrl->save();
          }else{
            $usrl = new UserLog(0,$requester, "DAT", "database delete - error",2);
            $usrl->save();
            $this->addError("Error during the deletion of column");
          }
        }else{
          $usrl = new UserLog(0,$requester, "DAT", "database delete - ivalid request",1);
          $usrl->save();
          $this->addError("Error during the deletion of database - invalid request");
        }
      break;

      case "UPDATE":
        $id = $this->filter($this->request["dbid"]);
        $name = $this->filter($this->request["dbname"]);
        $encoding = $this->filter($this->request["dbencoding"]);
        $serveraddress = $this->filter($this->request["dbserveraddress"]);
        $serverpassword = $this->filter($this->request["dbserverpassword"]);
        $serverusername = $this->filter($this->request["dbserverusername"]);
        $serverport = (int)$this->filter($this->request["dbserverport"]);
        $requester = $this->filter($this->request["uemail"]);
        if(isset($name) && isset($encoding) && isset($serveraddress) && isset($serverpassword) && isset($serverusername) && isset($serverport) && isset($requester)){
          $db = new DBDatabase($id,$name, $encoding , $requester, $serveraddress, $serverpassword, $serverusername, $serverport);
          $s = $db->update();
          if($s<0){
            $usrl = new UserLog(0,$requester, "DAT", "database update - error",2);
            $usrl->save();
            $this->addError("Error during the updating of database: " . $name);
          }else{
            $usrl = new UserLog(0,$requester, "DAT", "database updated - success",1);
            $usrl->save();
          }
        }else{
          $this->addError("Invalid request: " . serialize($this->request));
          $usrl = new UserLog(0,$requester, "DAT", "database update - error - invalid request",3);
          $usrl->save();
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
