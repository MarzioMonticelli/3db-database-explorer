<?php
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/UserLog.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/Apikey.php");

class RegistrationController{

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
      case "POST":
        if(isset($this->request["name"]) && isset($this->request["surname"]) && isset($this->request["email"]) && isset($this->request["password"])){
          try{
            $u1 = new User(filter($this->request["email"]), filter($this->request["name"]), filter($this->request["surname"]), filter($this->request["password"]));
            try{
              $res = $u1->save();
              if($res){
                $usrl = new UserLog(0,filter($this->request["email"]), "USE", "registration");
                $ak = new ApiKey($this->request["email"]);
                $usrl->save();
                $ak->save();
                return true;
              }else{
                $error = "Something want wrong during your registration. Please try again!";
                $usrl = new UserLog(0,filter($this->request["email"]), "USE", "registration error");
                $usrl->save();
                $this->addError($error);
                return false;
              }
            }catch(Exception $ex){
              if($ex->getCode() == 23000){
                $error = "The email is used by another user. Please choose another email";
                $this->addError($error);
                return false;
              }else{
                $this->addError($ex->getMessage());
                return false;
              }
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
