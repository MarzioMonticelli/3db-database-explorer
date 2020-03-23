<?php

require_once('interfaces/DBDatabaseInterface.php');
require_once('DBTable.php');
require_once('Object3D.php');
require_once('../utilities/StringGenerator.php');
require_once('interfaces/MVCModelInterface.php');
require_once('mysql_utilities/ConnectionFactory.php');

class DBDatabase implements DBDatabaseInterface{
  private $id;
  private $name;
  private $encoding;
  private $user_id;
  private $server_address;
  private $server_password;
  private $server_username;
  private $server_port;
  private $tables;
  private $object3d;

  public function __construct($id = null, $name = null, $encoding = null, $user_id = null, $server_address = null, $server_password = null, $server_username = null, $server_port = null, $tables = null){
    if($name == NULL && $encoding == NULL && $user_id == NULL && $server_address == NULL && $server_password == NULL
      && $server_username == NULL && $server_port == NULL && $tables == NULL && $id != NULL){
        $this->setId($id);
        $this->tables = [];
    }else{
      $this->setId($id);
      $this->setName($name);
      $this->setEncoding($encoding);
      $this->setUserId($user_id);
      $this->setServerAddress($server_address);
      $this->setServerPassword($server_password);
      $this->setServerUsername($server_username);
      $this->setServerPort($server_port);
      if($tables != null)
        $this->setTables($tables);
      else $this->tables = [];
    }
  }

  public function setObject3D($object){
    if(isset($object) && $object != null){
      if($object instanceof object3D){
        $object->setReferTo($this->getId());
        $this->object3d = $object;
      }else throw new Exception('[MODEL ERR] DBDatabase: invalid 3D Object. It must be an instance of  Object3D', 101);
    }else throw new Exception('[MODEL ERR] DBDatabase: invalid 3D Object. It can\'t be null', 101);
  }

  public function getObject3D(){
    return $this->object3d;
  }

  public function setName($name){
    if(isset($name)){
      if(gettype($name)== "string"){
        if(strlen($name)>=2){
          if(strlen($name)<=30){
            $loc = filter_var($name, FILTER_SANITIZE_STRING);
            if(!$loc === false){
              $this->name = $name;
            }else throw new Exception('[MODEL ERR] DBDatabase: name - error during filtering', 103);
          }else throw new Exception('[MODEL ERR] DBDatabase: invalid name. Length must be less than or equal to 30', 202);
        }else throw new Exception('[MODEL ERR] DBDatabase: invalid name. Length must be grater than or equal to 2', 201);
      }else throw new Exception('[MODEL ERR] DBDatabase: name invalid type - ' . gettype($name), 102);
    }else throw new Exception('[MODEL ERR] DBDatabase: invalid name. It can\'t be null', 101);
  }

  public function getName(){
    return $this->name;
  }
  public function setEncoding($char_encoding){
    if($char_encoding !== NULL && gettype($char_encoding) == 'string'){
			if($char_encoding === ''){
				$this->encoding = 'utf8_general_ci';
			}else{
				$this->encoding = $char_encoding;
			}
		}else
			throw new Exception('[MODEL ERR] DBDatabase: char_encoding must be a not empty string', 102);
  }

  public function getEncoding(){
    return $this->encoding;
  }

  public function setId($id){
    if($id == null){
      $this->id = StringGenerator::randomString(32);
    }else{
      if(strlen($id) == 32){
        $loc = filter_var($id, FILTER_SANITIZE_STRING);
        if(!$loc === false){
          $this->id = $loc;
        }else throw new Exception('[MODEL ERR] DBDatabase: id - error during filtering', 103);
      }else throw new Exception('[MODEL ERR] DBDatabase: invalid id. Length must be equal to 32', 202);
    }
  }

  public function getId(){
    return $this->id;
  }

  public function setUserId($id){
    if(isset($id)){
      if(filter_var($id, FILTER_VALIDATE_EMAIL)) {
        if($this->checkUserId($id)){
          $this->user_id = $id;
        }else throw new Exception('[MODEL ERR] DBDatabase: user email not present', 100);
      }else throw new Exception('[MODEL ERR] DBDatabase: email invalid format', 102);
    }else throw new Exception('[MODEL ERR] DBDatabase: invalid user id. It can\'t be null', 101);
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

  public function setTables($tables){
    if($tables !== NULL && gettype($tables) == 'array'){
			$this->tables = array();
			foreach($tables as $table){
				$this->addTable($table);
			}
		}else
			throw new Exception('[MODEL ERR] DBDatabase: tables must be an array', 402);
  }

  public function getTables(){
    return $this->tables;
  }

  public function addTable($table){
    if($table !== NULL && $table instanceof DBTable){
      if(!$this->inTables($table))
			   array_push($this->tables, $table);
		}else
			throw new Exception('[MODEL ERR] DBDatabase: table must be an instance of DBTable', 600);
  }

  private function inTables($table){
    if($table !== NULL && $table instanceof DBTable){
      if(count($this->tables) == 0)
        return false;
      else{
  			$found = false;
  			foreach($this->tables as $tTable)
  				if($tTable->equals($table))
            $found = true;

  			return $found;
      }
    }
  }


  public function removeTable($table){
		if($table !== NULL && $table instanceof DBTable){
			$nTables = array();
			foreach($this->tables as $tTable){
				if(!$tTable->equals($table))
					array_push($nTables ,$tTable);
			}
			$this->tables = $nTables;
			return $table;
		}else
			throw new Exception('[MODEL ERR] DBDatabase: table must be an instance of DBTable', 600);
	}

  public function setServerAddress($server_address){
    if(isset($server_address)){
      if(gettype($server_address)== "string"){
        if(strlen($server_address) > 0 && strlen($server_address) <= 1024){
          $this->server_address = $server_address;
        }else throw new Exception('[MODEL ERR] DBDatabase: invalid server address. Length must be less than or equal to 1024', 201);
      }else throw new Exception('[MODEL ERR] DBDatabase: server address invalid format - ' . gettype($name), 102);
    }else throw new Exception('[MODEL ERR] DBDatabase: invalid server address. It can\'t be null', 101);
  }

  public function getServerAddress(){
    return $this->server_address;
  }

  public function setServerPassword($server_password){
    if(isset($server_password)){
      if(gettype($server_password)== "string"){
        if(strlen($server_password) >= 0 && strlen($server_password) <= 64){
          $this->server_password = $server_password;
        }else throw new Exception('[MODEL ERR] DBDatabase: invalid server password. Length must be less than or equal to 1024', 201);
      }else throw new Exception('[MODEL ERR] DBDatabase: server password invalid format - ' . gettype($name), 102);
    }else throw new Exception('[MODEL ERR] DBDatabase: invalid server password. It can\'t be null', 101);
  }

  public function getServerPassword(){
    return $this->server_password;
  }

  public function setServerUsername($server_username){
    if(isset($server_username)){
      if(gettype($server_username)== "string"){
        if(strlen($server_username) > 0 && strlen($server_username) <= 64){
          $this->server_username = $server_username;
        }else throw new Exception('[MODEL ERR] DBDatabase: invalid server username. Length must be less than or equal to 1024', 201);
      }else throw new Exception('[MODEL ERR] DBDatabase: server username invalid format - ' . gettype($name), 102);
    }else throw new Exception('[MODEL ERR] DBDatabase: invalid server username. It can\'t be null', 101);
  }

  public function getServerUsername(){
    return $this->server_username;
  }


  public function setServerPort($server_port){
    if(isset($server_port)){
      if(gettype($server_port)== "integer"){
        if($server_port >= 0 && $server_port <= 1023){
          $this->server_port = $server_port;
        }else throw new Exception('[MODEL ERR] DBDatabase: invalid server port. It must be less than or equal to 1023', 303);
      }else throw new Exception('[MODEL ERR] DBDatabase: server port invalid format (integer required) - ' . gettype($server_port), 102);
    }else throw new Exception('[MODEL ERR] DBDatabase: invalid server port. It can\'t be null', 101);
  }

  public function getServerPort(){
    return $this->server_port;
  }

  public function getTablesNumber(){
    return count($this->tables);
  }
  public function getColsNumber(){
    $tot = 0;
    foreach($this->tables as $table)
        $tot += $table->getColsNumber();
    return $tot;
  }

  /* DATA TIER */

    public function update(){
      /* to check */
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $query = SqlQueryGenerator::updateStatement($this);
      $res = $conn->exec($query);
      $cf->disconnect();
      $cf = NULL;
      if($res == false && $res != 0){
        throw new Exception("[MODEL ERROR] DBDatabase - Error during updating: " .$conn->errorInfo(), 1);
      }else{
        if($res == 0){
            return -1;
        }else
          return true;
      }

    }


    public function save(){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $ret = $conn->exec(SqlQueryGenerator::insertStatement($this))
      or die(print_r($conn->errorInfo(),true));
      $cf->disconnect();
      $cf = NULL;
      foreach($this->getTables() as $table){
        $ret = $ret && $table->save();
      }
      if($this->object3d != null)
        $this->object3d->save();
      if($ret)
        return true;
      else
        return false;
    }

    public static function getAll(){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $response = $conn->query(SqlQueryGenerator::selectAllStatement("dbdatabases"))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetchAll();
      $dbs = [];
      foreach($data as $db){
        $ldb = new DBDatabase($db["id"], $db["name"],$db["encoding"], $db["user_id"], $db["server_address"],$db["server_password"], $db["server_username"],(int) $db["server_port"]);
        $tables = DBTable::getAllDatabaseId($db["id"]);
        foreach($tables as $table){
          $table->load();
          $ldb->addTable($table);
        }

        $obj3d = Object3D::getObject3DReference($ldb->getId());
        if($obj3d !== false){
          $ldb->setObject3D($obj3d);
        }

        array_push($dbs, $ldb);
      }
      return $dbs;
    }

    public static function getAllUserDBs($email){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('dbdatabases','user_id', $email))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetchAll();
      $dbs = [];
      foreach($data as $db){
        $ldb = new DBDatabase($db["id"], $db["name"],$db["encoding"], $db["user_id"], $db["server_address"],$db["server_password"], $db["server_username"],(int) $db["server_port"]);
        $tables = DBTable::getAllDatabaseId($db["id"]);
        foreach($tables as $table){
          $table->load();
          $ldb->addTable($table);
        }

        $obj3d = Object3D::getObject3DReference($ldb->getId());
        if($obj3d !== false){
          $ldb->setObject3D($obj3d);
        }
        array_push($dbs, $ldb);
      }
      return $dbs;
    }

    public function delete(){
      //delete all database's table
      $res = true;
      $this->load();
      foreach($this->getTables() as $table)
        $res = $res && $table->delete();

      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $res = $res && $conn->exec(SqlQueryGenerator::deleteStatement('dbdatabases', 'id', $this->getId()))
      or die(print_r($conn->errorInfo(),true));
      $cf->disconnect();
      $cf = NULL;

      if(isset($this->object3d))
        $this->object3d->delete();

      if($res)
        return true;
      else
        return false;
    }

    public function load(){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('dbdatabases','id', $this->getId()))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetch(PDO::FETCH_ASSOC);
      if($data){
        $this->setName($data["name"]);
        $this->setEncoding($data["encoding"]);
        $this->setUserId($data["user_id"]);
        $this->setServerAddress($data["server_address"]);
        $this->setServerPassword($data["server_password"]);
        $this->setServerUsername($data["server_username"]);
        $this->setServerPort((int)$data["server_port"]);
        $cf->disconnect();
        $tables = DBTable::getAllDatabaseId($this->getId());
        foreach($tables as $table)
          $this->addTable($table);

        $obj3d = Object3D::getObject3DReference($this->getId());
        if($obj3d !== false){
          $this->setObject3D($obj3d);
        }
        return true;
      }else{
        return false;
      }
    }


}



/*
 TEST ON CLASS



$dbd = new DBDatabase(NULL,"DBprova", "" , "marzio.monticelli@gmail.com", "localhost", "pass", "username", 21);
$ob = new Object3D(0, 12.34, 0.45, 34.430,"fdsfdsf", "material1", "texture.jpg", 0.5);
$dbd->setObject3D($ob);
$dbd->save();
var_dump($dbd);


echo("<BR><BR>DB2<BR><BR>");
$dbd1 = new DBDatabase(NULL,"DB2", "" , "marzio.monticelli@gmail.com", "localhost", "pass", "username", 21);
$a1 = new DBTable(NULL, $dbd1->getId(), $dbd1->getUserId(),'Users1');
$col01 = new DBCol(NULL,$a1->getDatabaseId(), $a1->getId(), $a1->getUserId(), 'riga12', 'TEXT', 2000, false);
$col11 = new DBCol(NULL,$a1->getDatabaseId(), $a1->getId(), $a1->getUserId(), 'riga22', 'VARCHAR', 2000, false);
$col21 = new DBCol(NULL,$a1->getDatabaseId(), $a1->getId(), $a1->getUserId(), 'riga32', 'DOUBLE');
$a1->addColumn($col01);
$a1->addColumn($col11);
$a1->addColumn($col21);
$dbd1->addTable($a1);
//var_dump($dbd1);
$dbd1->save();

$dbd1->delete();
$dbd->delete();

$a = new DBTable('Users');
$col = new DBCol('riga1', 'INT');
$col2 = new DBCol('riga2', 'VARCHAR',false,false, 32, true,'','default value',false, 'commento test');
$col3 = new DBCol('ID', 'INT',true, true, 32, false, '', '', true, 'identificativo univoco');
$a->addColumn($col);
$a->addColumn($col2);
$a->addColumn($col3);
$a->removeColumn($col2);
echo("GET NAME: " . $a->getName().'<br><br>');
$a->setName("TABELLA1");
$cols = array($col, $col2, $col3);
$a->setColumns($cols);
var_dump($a);

echo('<BR><BR>');




$dbd = new DBDatabase("HNSj33bwqi9TVSjlZ8PvNW3uNOGxZowB","DB1", "" , "marzio.monticelli@gmail.com", "localhost", "pass", "username", 21);
$dbd2 = new DBDatabase(null,"DB2", "" , "marzio.monticelli@gmail.com", "localhost", "pass", "username", 21);
$dbd3 = new DBDatabase(null,"DB3", "" , "marzio.monticelli@gmail.com", "localhost", "pass", "username", 21);
$dbd->save();
$dbd2->save();
$dbd3->save();

$db = new DBDatabase("HNSj33bwqi9TVSjlZ8PvNW3uNOGxZowB");
$db->load();
echo('<BR><BR>');

echo('<BR><BR>');
$db->delete();
var_dump(DBDatabase::getAll());


$dbd->addTable($a);
$b = new DBTable('Admins');
$col = new DBCol('riga1', 'INT');
$col2 = new DBCol('riga2', 'VARCHAR',false,false, 32, true,'','default value',false, 'commento test');
$col3 = new DBCol('ID', 'INT',true, true, 32, false, '', '', true, 'identificativo univoco');
$b->addColumn($col);
$b->addColumn($col2);
$b->addColumn($col3);
echo("GET NAME: " . $a->getName().'<br><br>');
$a->setName("TABELLA2");
$cols = array($col, $col2, $col3);
$a->setColumns($cols);
var_dump($b);
echo('<br><br> CREATE ST.<BR><BR>');
echo($a->getCreateStatement());

$dbd->addTable($b);
echo('<BR><BR>');
var_dump($dbd);

*/


?>
