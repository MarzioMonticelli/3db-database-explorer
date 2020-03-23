<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/3dB/config/server.config.php');
require_once('SqlQueryGenerator.php');
require_once('interfaces/ConnectionFactoryInterface.php');

class ConnectionFactory implements ConnectionFactoryInterface{
	private $database; // DBDatabase Model
	private $connection; // PDO
	private $connection_options; // string
	private $use_default; // boolean
	private $messages; //array


	public function __construct($database = NULL){
		$this->connection = NULL;
    try{
      $this->setDatabase($database);
      $this->use_default = false;
    }catch(Exception $e){
      $this->use_default = true;
      $this->database = false;
    }
		$this->connection_options = NULL;
		$this->messages = array();
	}

  public function setDatabase($db){
		if(isset($db) && $db != NULL){
			if($db instanceof DBDatabase){
				$this->database = $db;
			}else throw new Exception('[ERR] DATBASE MANAGER: invalid database type ('.gettype($db_name).')', 102);
		}else throw new Exception('[ERR] DATABASE MANAGER : invalid database it can\'t be null', 101);
	}

	// if Database name exist than it trys to connect to that dabase : connection on success
	// else it trys to connect to default server: SERVER_NAME : connection on success

	public function connect(){
		if(defined('SERVER_NAME') && SERVER_NAME != NULL && SERVER_NAME != '' && gettype(SERVER_NAME) == 'string' &&
		   defined('SERVER_USERNAME') && SERVER_USERNAME != NULL && SERVER_USERNAME != '' && gettype(SERVER_USERNAME) == 'string' &&
		   defined('SERVER_PASSWORD') && gettype(SERVER_PASSWORD) == 'string'
		){
			if(!$this->use_default){
				try{
          $db = $this->database;
					if($this->connection_options != NULL)
						$this->connection = new PDO("mysql:host=".$db->getServerAddress().";dbname=". $db->getName(), $db->getServerUsername(), $db->getServerPassword(), $this->connection_options);
					else // default connection options
						$this->connection = new PDO("mysql:host=".$db->getServerAddress().";dbname=". $db->getName(), $db->getServerUsername(), $db->getServerPassword());
					$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          array_push($this->messages,date("Y-m-d H:i:s").' - [SUCC] The connection was established with DB: ' . $db->getName());
					return $this->connection;
				}catch( PDOException $Exception ) {
					$this->disconnect();
					throw new Exception($Exception->getMessage(), (int)$Exception->getCode());
				}
			}else{
				try{
					$this->connection =  new PDO("mysql:host=".SERVER_NAME.";dbname=".DEFAULT_DATABASE_NAME, SERVER_USERNAME, SERVER_PASSWORD);
					$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					array_push($this->messages,date("Y-m-d H:i:s").' - [SUCC] The connection was established with host because of database is not setted');
					return $this->connection;
				}catch( PDOException $Exception ) {
					$this->disconnect();
					throw new Exception($Exception->getMessage(), (int)$Exception->getCode());
				}
			}
		}else throw new Exception('[FATAL ERROR] server informations are invalid. Please check your ../../config/server.config.php file - SN:'.SERVER_NAME.' SUN:'.SERVER_USERNAME.' SP:'.SERVER_PASSWORD.'');
	}

	public function disconnect(){
    array_push($this->messages,date("Y-m-d H:i:s").' - [SUCC] Server Disconnected');
		$this->connection = NULL; // PDO connection is closed when pdo object is not yet referenced
	}


  public function useDefault(){
    $this->use_default = true;
  }

  public function useDB(){
    $db = $this->database;
    if(isset($db)){
      if($db instanceof DBDatabase){
        $this->use_default = false;
      }else throw new Exception('[ERR] DATABASE MANAGER : invalid database it can\'t be null', 101);
    }else throw new Exception('[ERR] DATABASE MANAGER : invalid database it can\'t be null', 101);
  }



  public function printMessages(){
		echo('<h2>Messages:</h2>');
		for($i=0; $i<count($this->messages); $i++){
			echo('<p><b>Message'.$i.'</b> : '. $this->messages[$i] . '</p>');
		}
	}


}

/* TEST ON CLASS
$dbd = new DBDatabase("3dbcentral", "" , "marzio.monticell@gmail.com", "localhost", "", "root", 21);
var_dump($dbd);
$cf = new ConnectionFactory($dbd);

$cf->connect();
$cf->disconnect();
$cf->printMessages();
*/

?>
