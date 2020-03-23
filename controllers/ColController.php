<?php
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/UserLog.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/DBCol.php");

class ColController{
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
        $dbid = $this->filter($this->request["dbid"]);
        $tableid = $this->filter($this->request["tableid"]);
        $name = $this->filter($this->request["colname"]);
        $type = $this->filter($this->request["coltype"]);
        $len = (int)$this->filter($this->request["collength"]);
        $attr = $this->filter($this->request["colattributes"]);
        $null = (int)$this->filter($this->request["colnull"]);
        if($null <=0 || $null > 1){
          $null = false;
        }else if($null == 1){
          $null = true;
        }
        $autoinc = (int)$this->filter($this->request["colautoincrement"]);
        if($autoinc <=0 || $autoinc > 1){
          $autoinc = false;
        }else if($autoinc == 1){
          $autoinc = true;
        }
        $index = $this->filter($this->request["colindex"]);
        $comments = $this->filter($this->request["colcomments"]);
        if(!isset($comments) )
          $comments = "";
        $requester = $this->filter($this->request["uemail"]);
        if(isset($name) && isset($type) && isset($len) && isset($attr) && isset($null) && isset($autoinc) && isset($index) && isset($requester) && isset($tableid) && isset($dbid)){
          $primary = false;
          $unique = false;
          if($index == "Primary"){
            $primary = true;
          }else if($index == "Unique"){
            $unique = false;
          }

          $tb = new DBCol(NULL,$dbid, $tableid, $requester, $name, $type, $len, $primary, $unique, $null, $autoinc, $comments, $attr);
          $s = $tb->save();
          if(!$s){
            $usrl = new UserLog(0,$requester, "DAT", "col insert - error",2);
            $usrl->save();
            $this->addError("Error during the insertion of column: " . $name . " in specific database");
          }else{
            $usrl = new UserLog(0,$requester, "DAT", "col insert - success",1);
            $usrl->save();
          }
        }else{
          $this->addError("Invalid request: " . serialize($this->request));
          $usrl = new UserLog(0,$requester, "DAT", "col insert - error - invalid request",3);
          $usrl->save();
        }
      break;
      case "DELETE":
        $requester = $this->filter($this->request["uemail"]);
        $id = $this->filter($this->request["id"]);
        if(isset($requester) && isset($id)){
          $col = new DBCol($id);
          if($col->delete()){
            $usrl = new UserLog(0,$requester, "DAT", "col delete - success",1);
            $usrl->save();
          }else{
            $usrl = new UserLog(0,$requester, "DAT", "col delete - error",2);
            $usrl->save();
            $this->addError("Error during the deletion of column");
          }
        }else{
          $usrl = new UserLog(0,$requester, "DAT", "col delete - ivalid request",1);
          $usrl->save();
          $this->addError("Error during the deletion of column - invalid request");
        }
      break;
      default:
        return false;
        $this->addError("Invalid request");
      break;
    }
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
