<?php

require_once('interfaces/DBTableInterface.php');
require_once('DBCol.php');
require_once('../utilities/StringGenerator.php');
require_once('mysql_utilities/ConnectionFactory.php');
require_once('interfaces/MVCModelInterface.php');


class DBTable implements DBTableInterface, MVCModelInterface{
	private $id;
	private $name;
	private $char_encoding;
	private $database_id;
	private $user_id;
	private $cols;
	private $foreign_keys;
	private $object3d;

	public function __construct($id = null, $database_id = null, $user_id= null, $name = null, $char_encoding = '',$cols = []){
		if($database_id == null && $user_id == null && $name == null && $char_encoding == null && count($cols) == 0 && $id != null){
			$this->setId($id);
			$this->cols = [];
			$this->foreign_keys = [];
		}else{
			$this->setName($name);
			$this->setColumns($cols);
			$this->setCharEncoding($char_encoding);
			$this->setId($id);
			$this->setDatabaseId($database_id);
			$this->setUserId($user_id);
			$this->foreign_keys = [];
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

	public function setId($id){
    if($id == null){
      $this->id = StringGenerator::randomString(16);
    }else{
      if(strlen($id) == 16){
        $loc = filter_var($id, FILTER_SANITIZE_STRING);
        if(!$loc === false){
          $this->id = $loc;
        }else throw new Exception('[MODEL ERR] DBTable: id - error during filtering', 103);
      }else throw new Exception('[MODEL ERR] DBTable: invalid id. Length must be equal to 16', 202);
    }
  }

  public function getId(){
    return $this->id;
  }

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		if(gettype($name) == 'string' && $name != '')
			$this->name = strtr($name,array('"' => '', "'" => ''));
		else
			throw new Exception('[MODEL ERR] DBTable: name must be a not empty string' , 102);
	}

	public function getColumns(){
		return $this->cols;
	}

	public function setColumns($cols){
		if($cols !== NULL && gettype($cols) == 'array'){
			$this->cols = array();
			foreach($cols as $col){
				$this->addColumn($col);
			}
		}else
			throw new Exception('[MODEL ERR] DBTable: Columns must be an array '. gettype($cols) . ' given', 402);
	}

	public function addColumn($col){
		if($col !== NULL && $col instanceof DBCol){
			if(!$this->checkColumn($col))
				array_push($this->cols, $col);
		}else
			throw new Exception('[MODEL ERR] DBTable: col must be an instance of DBCol', 600);
	}

	public function addColumnValues($name, $type, $primary = false, $unique = false, $length = 8, $isnull = false,  $attribute = '', $default_val = '', $autoincrement = false, $comments = '', $virtuality = '', $mime = ''){
		$col = new DBCol($name, $type, $primary, $unique, $length, $isnull, $attribute, $default_val, $autoincrement, $comments, $virtuality, $mime);
		$this->addColumn($col);
	}

	public function removeColumn($col){
		if($col !== NULL && $col instanceof DBCol){
			$nColumns = array();
			foreach($this->cols as $tColumn){
				if(!$tColumn->equals($col))
					array_push($nColumns ,$tColumn);
			}
			$this->cols = $nColumns;
			return $col;
		}else
			throw new Exception('[MODEL ERR] DBTable: col must be an instance of DBCol', 600);
	}

	public function checkColumn($col){
		if($col !== NULL && $col instanceof DBCol){
			foreach($this->cols as $tColumn)
				if($tColumn->equals($col))
					return true;

			return false;
		}else
			throw new Exception('[MODEL ERR] DBTable: col must be an instance of DBCol', 600);
	}

	public function setCharEncoding($char_encoding){
		if($char_encoding !== NULL && gettype($char_encoding) == 'string'){
			if($char_encoding === ''){
				$this->char_encoding = 'utf8_general_ci';
			}else{
				$this->char_encoding = $char_encoding;
			}
		}else
			throw new Exception('[MODEL ERR] DBTable: char_encoding must be a not empty string', 102);
	}
	public function getCharEncoding(){
		return $this->char_encoding;
	}

	public function setUserId($id){
    if(isset($id)){
      if(filter_var($id, FILTER_VALIDATE_EMAIL)) {
        if($this->checkUserId($id)){
          $this->user_id = $id;
        }else throw new Exception('[MODEL ERR] DBTable: user email not present', 100);
      }else throw new Exception('[MODEL ERR] DBTable: email invalid format', 102);
    }else throw new Exception('[MODEL ERR] DBTable: invalid user id. It can\'t be null', 101);
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

	public function setDatabaseId($id){
    if(isset($id)){
			if(gettype($id)== "string"){
        if(strlen($id)==32){
					$loc = filter_var($id, FILTER_SANITIZE_STRING);
					if(!$loc === false){
						$this->database_id = $id;
					}else throw new Exception('[MODEL ERR] DBTable: database_id - error during filtering', 103);
				}else throw new Exception('[MODEL ERR] DBTable: invalid database_id. Length must be equal to 32', 201);
			}else throw new Exception('[MODEL ERR] DBTable: database_id invalid type - ' . gettype($id), 102);
    }else throw new Exception('[MODEL ERR] DBTable: invalid database_id. It can\'t be null', 101);
  }

  public function getDatabaseId(){
    return $this->database_id;
  }

	public function getForeignKeys(){
		return $this->foreign_keys;
	}

	public function addForeignKey($my_column, $ext_table_name, $ext_column_name){
		if($this->checkColumn($my_column)){
			if(isset($ext_table_name)){
				if(isset($ext_column_name)){
					array_push($this->foreign_keys, ["column"=>$my_column->getName(),"etable"=> $ext_table_name,"ecolumn" => $ext_column_name]);
				}else throw new Exception('[MODEL ERR] DBTable: invalid external column name. It can\'t be null', 101);
			}else throw new Exception('[MODEL ERR] DBTable: invalid external table name. It can\'t be null', 101);
		}
	}

	public function equals($table){
		return $this->id === $table->id;
	}

	public function getColsNumber(){
		return count($this->cols);
	}

	/* DATA TIER */

    public function update(){
      /* to check */
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $query = SqlQueryGenerator::updateStatement($this);
      var_dump($query);
      $res = $conn->exec($query);
			if($res == false && $res != 0){
        throw new Exception("[MODEL ERROR] DBTable - Error during updating: " .$conn->errorInfo(), 1);
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
			foreach($this->cols as $col){
				$ret = $ret && $col->save();
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
      $response = $conn->query(SqlQueryGenerator::selectAllStatement("dbtables"))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetchAll();
      $dbtables= [];
      $cf->disconnect();
      foreach($data as $dbtable){
        $a = new DBTable($dbtable["id"],$dbtable["database_id"],$dbtable["user_id"],$dbtable["name"],$dbtable["encoding"]);
				$cols = DBCols::getAllTableId($dbtable["id"]);
				foreach($cols as $col){
					$a->addColumn($col);
				}

				$obj3d = Object3D::getObject3DReference($a->getId());
        if($obj3d !== false){
          $a->setObject3D($obj3d);
        }

        array_push($dbtables, $a);
      }
      return $dbtables;
    }

		public static function getAllDatabaseId($database_id){
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('dbtables','database_id', $database_id))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetchAll();
      $dbtables= [];
      $cf->disconnect();
      foreach($data as $dbtable){
        $a = new DBTable($dbtable["id"],$dbtable["database_id"],$dbtable["user_id"],$dbtable["name"],$dbtable["encoding"]);
				$cols = DBCol::getAllTableId($dbtable["id"]);
				foreach($cols as $col){
					$a->addColumn($col);
				}

				$obj3d = Object3D::getObject3DReference($a->getId());
	      if($obj3d !== false){
	         $a->setObject3D($obj3d);
	      }

        array_push($dbtables, $a);
      }
      return $dbtables;
    }

    public function delete(){
			$res = true;
			$this->load();
			foreach($this->getColumns() as $col)
				$res = $res && $col->delete();
      $cf = new ConnectionFactory();
      $conn = $cf->connect();
      $res = $res && $conn->exec(SqlQueryGenerator::deleteStatement('dbtables', 'id', $this->getId()))
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
      $response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('dbtables','id', $this->getId()))
      or die(print_r($conn->errorInfo(),true));
      $data = $response->fetch(PDO::FETCH_ASSOC);
      $cf->disconnect();
      if($data){
        $this->setName($data["name"]);
				$this->setCharEncoding($data["encoding"]);
				$this->setDatabaseId($data["database_id"]);
				$this->setUserId($data["user_id"]);
				$cols = DBCol::getAllTableId($this->getId());
				foreach($cols as $col){
					$this->addColumn($col);
				}
				$obj3d = Object3D::getObject3DReference($this->getId());
	      if($obj3d !== false){
	        $this->setObject3D($obj3d);
	      }
        return true;
      }else
        return false;
    }

}


/* TEST ON CLASS
$a = new DBTable(NULL, 'KloExKokuc1MWmIICOko7Eap0Ogd794f', 'marzio.monticelli@gmail.com','NEWTAB');
$a->save();
$a->setId("3tUzGcZCm8XuaI3Z");
$a->setName("TableModified");
$a->setCharEncoding("another_encoding");
var_dump($a->update());

$a = new DBTable(NULL, '6lrqFHCbh44Qj6C8Xj1bpAyjx8GmYjUP', 'marzio.monticelli@gmail.com','Users');
$col = new DBCol(NULL,$a->getDatabaseId(), $a->getId(), $a->getUserId(), 'riga1', 'TEXT', 2000, false);
$col1 = new DBCol(NULL,$a->getDatabaseId(), $a->getId(), $a->getUserId(), 'riga2', 'VARCHAR', 2000, false);
$col2 = new DBCol(null,$a->getDatabaseId(), $a->getId(), $a->getUserId(), 'riga3', 'DOUBLE');
$a->addColumn($col);
$a->addColumn($col1);
$a->addColumn($col2);
var_dump($a);
$a->save();
//$b = new DBTable("pXKap1LrGdbnqsq6");
//$b->load();
echo("<br><br>");
var_dump($a);
echo("<br><br>");
var_dump(DBTable::getAll());

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
*/

?>
