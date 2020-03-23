<?php

require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/UserLog.php");

class AuthController{

  private $request;
  private $type;
  private $errors;
  private $cookie_session_token;
  private $cookie_session_user;
  private $div_token;

  public function __construct($request = null, $type = null){
    $this->request = $request;
    $this->type = $type;
    $this->errors = [];
    $this->div_token = "$&$";
    $this->cookie_session_token ="3DB_token";
    $this->cookie_session_user ="3DB_user";
  }

  public function login(){
    switch($this->type){
        case "POST":
          try{
            $luser = new User($this->filter($_POST["log_email"]));
            $luser->load();
            $p1 = $_POST["log_password"];
            if( password_verify($p1, $luser->getPassword()) ) {
              $message = "login success";
              $usrl = new UserLog(0,$this->filter($_POST["log_email"]), "ACC", "login",1);
              $usrl->save();
              $this->resetCookies();
              $this->setCookie($this->cookie_session_token, password_hash($luser->getEmail(), PASSWORD_BCRYPT).$this->div_token.$luser->getPassword());
              $this->setCookie($this->cookie_session_user, $luser->getEmail());
              return true;
            }else{
              $this->addError("You email or your password are wrong.");
              return false;
            }
          }catch(Exception $ex){
            $this->addError("Something went wrong during login attempt: " . $ex->getMessage());
            return false;
          }
      break;
      default:
        return false;
        $this->addError("Invalid request");
      break;
    }
  }

  public function logout(){
    if(array_key_exists($this->cookie_session_user , $_COOKIE)){
      $usrl = new UserLog(0,$this->filter($_COOKIE[$this->cookie_session_user]), "ACC", "logout",1);
      $usrl->save();
    }
    $this->resetCookies();
  }

  private function setCookie($cookie_name, $cookie_value){
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); //one day
  }

  private function resetCookies(){
    unset($_COOKIE[$this->cookie_session_token]);
    unset($_COOKIE[$this->cookie_session_user]);
    setcookie($this->cookie_session_token, "", time()-(60*60*24), "/");
    setcookie($this->cookie_session_user, "", time()-(60*60*24), "/");
  }

  public function isAuth(){
    if(!isset($_COOKIE[$this->cookie_session_user]))
      return false;

    if(!isset($_COOKIE[$this->cookie_session_token]))
      return false;

      $u = new User($_COOKIE[$this->cookie_session_user]);
      $u->load();
      $c = $_COOKIE[$this->cookie_session_token];
      $c = explode($this->div_token, $c);
      if(count($c)!=2){
        $usrl = new UserLog(0,$_COOKIE[$this->cookie_session_user], "ACC", "authentication error", 5);
        $usrl->save();
        $this->addError("Authentication fail! Invalid token.");
        return false;
      }else{
        if(password_verify($_COOKIE[$this->cookie_session_user], $c[0]) && $c[1] == $u->getPassword())
          return true;
        else{
          $this->addError("Corrupted anthentication token.");
          return false;
        }
      }
  }

  private function filter($data) { //Filters data against security risks.
      return $data;
  }

  public function getAuthUser(){
    if($this->isAuth()){
      return $_COOKIE[$this->cookie_session_user];
    }else{
      $this->addError("No user is authenticated");
      return false;
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
