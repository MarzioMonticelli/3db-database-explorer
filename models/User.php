<?php
require_once('interfaces/UserInterface.php');
require_once('mysql_utilities/ConnectionFactory.php');
require_once('interfaces/MVCModelInterface.php');

class User implements UserInterface, MVCModelInterface{
  private $name; // |string| C [2,30]
  private $surname; // |string| C [2,30]
  private $password; // |string| C [6,64]
  private $email; // formatted string [string@string.dmn]
  private $description; // |string| C [10, 1024]
  private $registration_date;


  public function __construct($email, $name = NULL, $surname = NULL, $password = NULL, $description = NULL, $registration_date = NULL, $crypt = true){
    if(isset($email) && !isset($name) && !isset($surname) && !isset($passsword)){
      $this->setEmail($email);
    }else{
      $this->setName($name);
      $this->setSurname($surname);
      $this->setEmail($email);
      $this->setPassword($password, $crypt);
      $this->setDescription($description);
      if($registration_date !== NULL)
        $this->setRegistrationDate($registration_date);
      else
        $this->registration_date = date_create()->format('Y-m-d H:i:s');
    }
  }

  public function toArray(){
    return [
      "email"=> $this->email,
      "password" => $this->password,
      "name" => $this->name,
      "surname" => $this->surname,
      "description" => $this->description,
      "registration_date" => $this->registration_date
    ];
  }

  public function setName($name){
    if(isset($name)){
      if(gettype($name)== "string"){
        if(strlen($name)>=2){
          if(strlen($name)<=30){
            $loc = filter_var($name, FILTER_SANITIZE_STRING);
            if(!$loc === false){
              $this->name = $name;
            }else throw new Exception('[MODEL ERR] USER: name - error during filtering', 103);
          }else throw new Exception('[MODEL ERR] USER: invalid name. Length must be less than or equal to 30', 202);
        }else throw new Exception('[MODEL ERR] USER: invalid name. Length must be grater than or equal to 2', 201);
      }else throw new Exception('[MODEL ERR] USER: name invalid type - ' . gettype($name), 102);
    }else throw new Exception('[MODEL ERR] USER: invalid name. It can\'t be null', 101);
  }

  public function getName(){
    return $this->name;
  }

  public function setSurname($surname){
    if(isset($surname)){
      if(strlen($surname)>=2){
        if(strlen($surname)<=30){
          if(gettype($surname)== "string"){
            $loc = filter_var($surname, FILTER_SANITIZE_STRING);
            if(!$loc === false){
              $this->surname = $surname;
            }else throw new Exception('[MODEL ERR] USER: surname - error during filtering', 103);
          }else throw new Exception('[MODEL ERR] USER: surname invalid type - ' . gettype($surname), 102);
        }else throw new Exception('[MODEL ERR] USER: invalid surname. Length must be less than or equal to 30', 202);
      }else throw new Exception('[MODEL ERR] USER: invalid surname. Length must be grater than or equal to 2', 201);
    }else throw new Exception('[MODEL ERR] USER: invalid surname. It can\'t be null', 101);
  }

  public function getSurname(){
    return $this->surname;
  }

  public function setEmail($email){
    if(isset($email)){
      if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->email = $email;
      }else throw new Exception('[MODEL ERR] USER: email invalid format', 102);
    }else throw new Exception('[MODEL ERR] USER: invalid email. It can\'t be null', 101);
  }

  public function getEmail(){
    return $this->email;
  }

  public function setPassword($password, $crypt = true){
    if(isset($password)){
      if(strlen($password) >= 6) {
        if(strlen($password) <= 64){
          if($crypt)
            $this->password = password_hash($password, PASSWORD_BCRYPT);
          else
            $this->password = $password;
        }else throw new Exception('[MODEL ERR] USER: invalid password. Length must be less than or equal to 50', 202);
      }else throw new Exception('[MODEL ERR] USER: password invalid length. Length must be grater than or equal to 6', 201);
    }else throw new Exception('[MODEL ERR] USER: invalid password. It can\'t be null', 101);
  }

  public function getPassword(){
    return $this->password;
  }

  public function setDescription($description){
    if(isset($description)){
      if(gettype($description)== "string"){
        if(strlen($description)>=10){
          if(strlen($description)<=1024){
            $loc = filter_var($description, FILTER_SANITIZE_STRING);
            if(!$loc === false){
              $this->description = $description;
            }else throw new Exception('[MODEL ERR] USER: name - error during filtering', 103);
          }else throw new Exception('[MODEL ERR] USER: invalid description. Length must be less than or equal to 600', 202);
        }//else throw new Exception('[MODEL ERR] USER: invalid description. Length must be grater than or equal to 10', 201);
      }else throw new Exception('[MODEL ERR] USER: description invalid type - ' . gettype($description), 102);
    }
  }
  public function getDescription(){
    return $this->description;
  }


  public function setRegistrationDate($date){
    $this->registration_date = $date;
  }
  public function getRegistrationDate(){
    return $this->registration_date;
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
    $response = $conn->query(SqlQueryGenerator::selectAllStatement("users"))
    or die(print_r($conn->errorInfo(),true));
    $data = $response->fetchAll();
    $users = [];
    foreach($data as $user){
      $u = new User($user["email"], $user["name"],$user["surname"],$user["password"],$user["description"], $user["registration_date"], false);
      array_push($users, $u);
    }
    return $users;
  }

  public function delete(){
    $cf = new ConnectionFactory();
    $conn = $cf->connect();
    $conn->exec(SqlQueryGenerator::deleteStatement('users', 'email', $this->getEmail()))
    or die(print_r($conn->errorInfo(),true));
    $cf->disconnect();
    $cf = NULL;
    return true;
  }

  public function load(){
    $cf = new ConnectionFactory();
    $conn = $cf->connect();
    $response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('users','email', $this->getEmail()))
    or die(print_r($conn->errorInfo(),true));
    $data = $response->fetch(PDO::FETCH_ASSOC);
    $this->setName($data["name"]);
    $this->setSurname($data["surname"]);
    $this->setPassword($data["password"], false);
    if(strlen($data["description"]>0)){
      $this->setDescription($data["description"]);
    }
    $this->setRegistrationDate($data["registration_date"]);
    $cf->disconnect();
  }


}


/* TESTS ON CLASS
User($email, $name = NULL, $surname = NULL, $password = NULL, $description = NULL)
$u = new User("marzio.monticelli@gmail.com");
$u->load();
$u->setDescription("UNA NUOVA DESCRIZIONE PER L'UPDATE");
//$u->update();
var_dump(User::getAll());
*/
?>
