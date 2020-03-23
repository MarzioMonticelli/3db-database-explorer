<?php

require_once('interfaces/DBColInterface.php');
require_once('../utilities/AdmittedRowValues.php');
require_once('../utilities/StringGenerator.php');
require_once('mysql_utilities/ConnectionFactory.php');
require_once('interfaces/MVCModelInterface.php');

class DBCol implements DBColInterface, MVCModelInterface{
	private $id;
	private $database_id;
	private $user_id;
	private $table_id;
	private $name;
	private $type;
	private $primary;
	private $unique;
	private $length;
	private $attributes;
	private $isnull;
	private $default_val;
	private $extra;
	private $comments;
	private $virtuality;
	private $mime;
	private $object3d;


	public function __construct($id = null,$database_id = null, $table_id = null, $user_id = null,  $name = null, $type = null,
	$length = 8, $primary = false, $unique = false, $isnull = false, $autoincrement = false, $comments = '', $attribute = '',
	$default_val = '', $virtuality = '', $mime = ''){
		if($name == null && $type == null && $id != null){
			$this->setId($id);
		}else{
			$this->setId($id);
			$this->setDatabaseId($database_id);
			$this->setTableId($table_id);
			$this->setUserId($user_id);
			$this->setName($name);
			$this->setType($type);
			$this->setPrimary($primary);
			$this->setUnique($unique);
			$this->setLength($length);
			$this->setAttributes($attribute);
			$this->setNull($isnull);
			$this->setDefault($default_val);
			$this->setAutoincrement($autoincrement);
			$this->setComments($comments);
			$this->setVirtuality($virtuality);
			$this->setMIMEtype($mime);
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
        }else throw new Exception('[MODEL ERR] DBCol: id - error during filtering', 103);
      }else throw new Exception('[MODEL ERR] DBCol: invalid id. Length must be equal to 16', 202);
    }
  }

  public function getId(){
    return $this->id;
  }

	public function setName($name){
		if($name != NULL && gettype($name) == 'string')
			$this->name = $name;
		else
			throw new Exception ('[MODEL ERR] DBCol: name must be a not empty string. ' , 102);
	}

	public function getName(){
		return $this->name;
	}

	public function setType($type){
		if($this->checkType($type))
			$this->type = $type;
		else
			throw new Exception ('[MODEL ERR] DBCol: passed type is not admissible. ' , 102);
	}
	public function getType(){
		return $this->type;
	}

	private function checkType($type){
		if($type !== NULL && gettype($type) == 'string'){
			$type = strtoupper($type);
			return in_array($type, AdmittedRowValues::getAdmittedTypes());
		}else
			throw new Exception ('[MODEL ERR] DBCol: type must be a not empty string. ' , 102);
	}

	public function getAdmittedTypes(){
		return AdmittedRowValues::getAdmittedTypes();
	}

	public function setPrimary($primary){
		if($primary !== NULL && gettype($primary) == 'boolean')
			$this->primary = $primary;
		else
			throw new Exception ('[MODEL ERR] DBCol: primary must be a not null boolean. ('.gettype($primary).') ' , 102);
	}

	public function isPrimary(){
		return $this->primary;
	}

	public function setUnique($unique){
		if(gettype($unique) == 'boolean')
			$this->unique = $unique;
		else
			throw new Exception ('[MODEL ERR] DBCol: unique must be a not null boolean. ' , 102);
	}

	public function isUnique(){
		return $this->unique;
	}

	public function setLength($length){
		if($length !== NULL && gettype($length) == 'integer' && $length>0)
			$this->length = $length;
		else
			throw new Exception ('[MODEL ERR] DBCol: length must be a not empty INTEGER grater than zero. ' , 302);
	}

	public function getLength(){
		return $this->length;
	}

	public function setAttributes($attributes){
		if($this->checkAttributes($attributes))
			$this->attributes = $attributes;
		else
			return false;

	}

	public function getAttributes(){
		return $this->attributes;
	}

	public function getAdmittedAttributes(){
		return AdmittedRowValues::getAdmittedAttributes();
	}

	private function checkAttributes($attribute){
		if($attribute !== NULL && gettype($attribute) == 'string'){
			return in_array($attribute, AdmittedRowValues::getAdmittedAttributes());
		}else
			throw new Exception ('[MODEL ERR] DBCol: attribute must be a not empty string. ' , 102);

	}
	public function setNull($null){
		if(gettype($null) == 'boolean')
			$this->isnull = $null;
		else
			throw new Exception ('[MODEL ERR] DBCol: isNull must be a not null boolean ('.gettype($null).' passed). ' , 102);
	}

	public function isNull(){
		return $this->isnull;
	}

	public function setDefault($default){
		if($this->checkDefaultVal($default))
			$this->default_val = $default;
		else
			throw new Exception ('[MODEL ERR] DBCol: default must be a not empty string. ' , 102);
	}

	private function checkDefaultVal($default){
		if($default!==NULL && gettype($default) == 'string'){
			return true;
		}else
			return false;
	}


	public function getDefault(){
		return $this->default_val;
	}

	public function getAdmittedDefault(){
		return AdmittedRowValues::getAdmittedDefaultVal();
	}

	public function setAutoincrement($extra){
		if(gettype($extra) == 'boolean')
			$this->extra = $extra;
		else
			throw new Exception ('[MODEL ERR] DBCol: extra(autoincrement) must be a not null boolean ('.gettype($extra).' passed). ' , 102);
	}

	public function isAutoincrement(){
		return $this->extra;
	}

	public function setComments($comments){
		if($comments !== NULL && gettype($comments) == 'string')
			$this->comments = $comments;
		else
			throw new Exception ('[MODEL ERR] DBCol: comments must be a not null string. ' , 102);
	}
	public function getComments(){
		return $this->comments;
	}

	public function setVirtuality($virtuality){
		if($this->checkVirtuality($virtuality))
			$this->virtuality = $virtuality;
		else
			return false;
	}

	private function checkVirtuality($vir){
		if($vir !== NULL && gettype($vir) == 'string')
			return in_array($vir, AdmittedRowValues::getAdmittedVirtuality());
		else
			throw new Exception ('[MODEL ERR] DBCol: virtuality must be a not empty string. ' , 102);
	}

	public function getVirtuality(){
		return $this->virtuality;
	}

	public function setMIMEtype($mime){
		if($this->checkMime($mime))
			$this->mime = $mime;
		else
			return false;
	}

	private function checkMime($mime){
		if($mime !== NULL && gettype($mime) == 'string')
			return in_array($mime, AdmittedRowValues::getAdmittedMime());
		else
			throw new Exception ('[MODEL ERR] DBCol: mime must be a not empty string. ' , 102);
	}


	public function getMIMEtype(){
		return $this->mime;
	}

	public function setTableId($id){
		if(isset($id)){
			if(gettype($id)== "string"){
				if(strlen($id)== 16){
					$this->table_id = $id;
				}else throw new Exception("[MODEL ERR] DBCol - Table id can't be null",101);
			}else throw new Exception("[MODEL ERR] DBCol - Table id must be a not null string",102);
		}else throw new Exception("[MODEL ERR] DBCol - invalid Table id",102);
	}

	public function getTableId(){
		return $this->table_id;
	}

	public function setDatabaseId($id){
		if(isset($id)){
			if(gettype($id)== "string"){
				if(strlen($id)== 32){
					$this->database_id = $id;
				}else throw new Exception("[MODEL ERR] DBCol - Database id can't be null",101);
			}else throw new Exception("[MODEL ERR] DBCol - Database id must be a not null string",102);
		}else throw new Exception("[MODEL ERR] DBCol - invalid Database id",102);
	}

	public function getDatabaseId(){
		return $this->database_id;
	}

	public function setUserId($id){
		if(isset($id)){
			if(gettype($id)== "string"){
				if(filter_var($id, FILTER_VALIDATE_EMAIL)) {
		       if($this->checkUserId($id)){
		         $this->user_id = $id;
		       }else throw new Exception('[MODEL ERR] DBCol - user id not present', 100);
		     }else throw new Exception('[MODEL ERR] DBCol - email invalid format', 102);
			}else throw new Exception("[MODEL ERR] DBCol - User id can't be null",101);
		}else throw new Exception("[MODEL ERR] DBCol - User id must be a not null string",102);
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


	public function setTransformBrowserView($tbv){}
	public function getTransformBrowserView(){}
	public function setTransformBrowserViewOptions($tbv_options){}
	public function getTransformBrowserViewOptions(){}
	public function setInputTransformation($input_transformation){}
	public function getInputTransformation(){}
	public function setInputTransformationOptions($input_transformation_options){}
	public function getInputTransformationOptions(){}

	public function equals($col){
		return $this->name === $col->getName();
	}


	private function isPresent($col){
		$cf = new ConnectionFactory();
		$conn = $cf->connect();
		$response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('dbcols','table_id', $col->getTableId()))
		or die(print_r($conn->errorInfo(),true));
		$data = $response->fetchAll();
		foreach($data as $c){
			if($c["name"] == $col->getName())
				return true;
		}
		$cf->disconnect();
		return false;
	}

	/* DATA TIER */

		public function update(){
			/* to check */
			$cf = new ConnectionFactory();
			$conn = $cf->connect();
			$query = SqlQueryGenerator::updateStatement($this);
			$res = $conn->exec($query);
			if($res == false && $res != 0){
        throw new Exception("[MODEL ERROR] DBColumn - Error during updating: " .$conn->errorInfo(), 1);
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
			if($this->isPresent($this))
				throw new Exception("[MODEL ERR] DBCol - column ".$this->getName()." is still present");

			$query = SqlQueryGenerator::insertStatement($this);
			$ret = $conn->exec($query)
			or die(print_r($conn->errorInfo(),true));
			$cf->disconnect();
			$cf = NULL;

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
			$response = $conn->query(SqlQueryGenerator::selectAllStatement("dbcols"))
			or die(print_r($conn->errorInfo(),true));
			$data = $response->fetchAll();
			$dbcols= [];
			$cf->disconnect();
			foreach($data as $dbcol){
				$a = new DBCol($dbcol["id"],$dbcol["database_id"],$dbcol["table_id"],$dbcol["user_id"],$dbcol["name"],$dbcol["type"],(int)$dbcol["length"],
				(boolean)$dbcol["isprimary"],(boolean)$dbcol["isunique"],(boolean)$dbcol["isnull"],(boolean)$dbcol["extra"],
				$dbcol["comments"],$dbcol["attributes"],$dbcol["default_val"],$dbcol["virtuality"],$dbcol["mime"]);
				$obj3d = Object3D::getObject3DReference($a->getId());
        if($obj3d !== false){
          $a->setObject3D($obj3d);
        }
				array_push($dbcols, $a);
			}
			return $dbcols;
		}

		public static function getAllTableId($table_id){
			$cf = new ConnectionFactory();
			$conn = $cf->connect();
			$response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('dbcols','table_id', $table_id))
			or die(print_r($conn->errorInfo(),true));
			$data = $response->fetchAll();
			$dbcols= [];
			$cf->disconnect();
			foreach($data as $dbcol){
				$a = new DBCol($dbcol["id"],$dbcol["database_id"],$dbcol["table_id"],$dbcol["user_id"],$dbcol["name"],$dbcol["type"],(int)$dbcol["length"],
				(boolean)$dbcol["isprimary"],(boolean)$dbcol["isunique"],(boolean)$dbcol["isnull"],(boolean)$dbcol["extra"],
				$dbcol["comments"],$dbcol["attributes"],$dbcol["default_val"],$dbcol["virtuality"],$dbcol["mime"]);
				$obj3d = Object3D::getObject3DReference($a->getId());
        if($obj3d !== false){
          $a->setObject3D($obj3d);
        }
				array_push($dbcols, $a);
			}
			return $dbcols;
		}

		public function delete(){
			$cf = new ConnectionFactory();
			$conn = $cf->connect();
			$res = $conn->exec(SqlQueryGenerator::deleteStatement('dbcols', 'id', $this->getId()))
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
			$response = $conn->query(SqlQueryGenerator::selectFromWhereStatement('dbcols','id', $this->getId()))
			or die(print_r($conn->errorInfo(),true));
			$data = $response->fetch(PDO::FETCH_ASSOC);
			$cf->disconnect();
			if($data){
				$this->setTableId($data["table_id"]);
				$this->setDatabaseId($data["database_id"]);
				$this->setUserId($data["user_id"]);
				$this->setName($data["name"]);
				$this->setNull((boolean)$data["isnull"]);
				$this->setPrimary((boolean)$data["isprimary"]);
				$this->setUnique((boolean)$data["isunique"]);
				$this->setLength((int)$data["length"]);
				$this->setAttributes($data["attributes"]);
				$this->setDefault($data["default_val"]);
				$this->setAutoincrement((boolean)$data["extra"]);
				$this->setComments($data["comments"]);
				$this->setVirtuality($data["virtuality"]);
				$this->setMIMEtype($data["mime"]);
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
$col = new DBCol(null,"icjQlFMXODJFOUxFhGOw9eaN5D5Fqvs5","EAAGyW9C9dDJlIJ3","marzio.monticelli@gmail.com", 'riga4', 'TEXT', 2000, false);
echo("<br><br> SAVED?:<BR>");
var_dump($col->save());
$col2 = new DBCol(null,"6lrqFHCbh44Qj6C8Xj1bpAyjx8GmYjUP","ggQlAvR9szNQjtKx","marzio.monticelli@gmail.com", 'riga2', 'DOUBLE');
$col2->save();
$col2->delete();
$col3 = new DBCol("eygvkqSK4A00D3Hx");
$col3->load();

var_dump($col);
echo('<br><br>');
var_dump($col2);
echo('<br><br>');
var_dump($col3);
echo('<br><br>');
var_dump(DBCol::getAll());
*/


?>
