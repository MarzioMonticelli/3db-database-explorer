<?php

require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/UserLog.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/Apikey.php");

class UserController{
  private $request;
  private $type;
  private $errors;

  public function __construct($request, $type){
    $this->request = $request;
    $this->type = $type;
    $this->errors = [];
  }

  public function process(){
    switch($this->type){
      case "UPDATE":
        if(isset($this->request["name"]) && isset($this->request["surname"])  && isset($this->request["password"])){
          try{
            $u1 = new User($this->filter($this->request["email"]));
            $u1->load();
            $u1->setName($this->filter($this->request["name"]));
            $u1->setSurname($this->filter($this->request["surname"]));
            $u1->setPassword($this->filter($this->request["password"]));
            $u1->setDescription($this->filter($this->request["description"]));
            try{
              $res = $u1->update();
              if($res){
                $usrl = new UserLog(0,filter($this->request["email"]), "USE", "profile update - success",2);
                $usrl->save();
                return true;
              }else{
                $error = "Something want wrong during your profile update. Please try again!";
                $usrl = new UserLog(0,filter($this->request["email"]), "USE", "profile update - error",2);
                $usrl->save();
                $this->addError($error);
                return false;
              }
            }catch(Exception $ex){
              $error = "Something want wrong during your profile update. Please try again!";
              $usrl = new UserLog(0,filter($this->request["email"]), "USE", "profile update - error ".$ex->getCode(), 2);
              $this->addError($ex->getMessage());
              return false;
            }
          }catch(Exception $ex){
            $this->addError($ex->getMessage());
            return false;
          }

        }
      break;
      default:
        return false;
        $this->addError("Invalid request");
      break;
    }
  }

  public static function getUser($email){
    $u = new User($email);
    $u->load();
    return $u;
  }

  public static function getAllUserLogs($email){
    return UserLog::getAllFromUserId($email);
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
    return $this->errors[count($this->errors)-1];
  }

  public function getErrors(){
    return $this->errors;
  }
}

?>
