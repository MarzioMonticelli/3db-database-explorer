<?php

require_once("interfaces/SqlQueryGeneratorInterface.php");

class SqlQueryGenerator implements SqlQueryGeneratorInterface{


  public static function createDatabaseStatement($db){
    $dbname = $this->connection->quote($db->getName().";");
    return "CREATE DATABASE ".$dbname;
  }

  public static function createTableStatement($table){
    $sql ="CREATE TABLE ".$table->getName()."(";
		for($i=0;$i<count($table->getColumns()); $i++){
			$col = ($table->getColumns())[$i];
			$sql.=$col->getName().' '.$col->getType().'( '.$col->getLength().' ) ';
			if($col->isPrimary())
				$sql.= ' PRIMARY KEY';
			if($col->isUnique())
				$sql.= ' UNIQUE';
			if($col->isAutoincrement())
				$sql.=' AUTO_INCREMENT';
			if($col->isNull())
				$sql.= ' NULL';
			else
				$sql .= ' NOT NULL';
			if($col->getDefault() != '')
				$sql .= ' DEFAULT ' . $col->getDefault(). ' ';
			if($col->getComments() != '')
				$sql .= " COMMENT '".$col->getComments()."' ";
			if($i+1<count($table->getColumns()))
				$sql .= ',';
		}
		return $sql.=');';
  }

  public static function removeTableStatement($table){
    return "DROP TABLE ".$table->getName();
  }

  public static function updateTableStatement($table){
    $a = "UPDATE ".$table->getName()." SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1";
  }

  public static function createForeignKeyStatements($table){
    $statements = [];
    foreach($table->getForeignKeys() as $fkey){
      array_push($statements, "ALTER TABLE ".$table->getName(). " ADD FOREIGN KEY (".$fkey["column"].") REFERENCES ".$fkey["etable"]."(".$fkey["ecolumn"].");");
    }
    return $statements;
  }

  public static function insertStatement($obj){
    switch(get_class($obj)){
      case "User":
        return SqlQueryGenerator::insertUserStatement($obj);
      break;
      case "DBDatabase":
        return SqlQueryGenerator::insertDatabaseStatement($obj);
      break;
      case "DBTable":
        return SqlQueryGenerator::insertDBTableStatement($obj);
      break;
      case "DBCol":
        return SqlQueryGenerator::insertDBColStatement($obj);
      break;
      case "UserLog":
        return SqlQueryGenerator::insertUserLogStatement($obj);
      break;
      case "ApiKey":
        return SqlQueryGenerator::insertApiKeyStatement($obj);
      break;
      case "Object3D":
        return SqlQueryGenerator::insertObject3DStatement($obj);
      break;
    }
  }

  private static function insertUserStatement($user){
    if(isset($user)){
      if($user instanceof User){
        return "INSERT INTO Users VALUES ('".$user->getEmail()."', '".$user->getName()."', '".$user->getSurname()."','".$user->getPassword()."','".$user->getRegistrationDate()."','".$user->getDescription()."');";
      }else throw new Exception("[ERR] user must be an instance of User ", 102);
    }else throw new Exception("[ERR] SqlQueryGenerator - user must be a not null object", 101);
  }

  private static function insertDatabaseStatement($db){
    if(isset($db)){
      if($db instanceof DBDatabase){
        return "INSERT INTO dbdatabases VALUES ('".$db->getId()."', '".$db->getName()."', '".$db->getEncoding()."','".$db->getUserId()."','".$db->getServerAddress()."','".$db->getServerPassword()."','".$db->getServerUsername()."','".$db->getServerPort()."');";
      }else throw new Exception("[ERR] db must be an instance of DBDatabase ", 102);
    }else throw new Exception("[ERR] SqlQueryGenerator - db must be a not null object", 101);
  }

  private static function insertDBTableStatement($table){
    if(isset($table)){
      if($table instanceof DBTable){
        return "INSERT INTO dbtables VALUES ('".$table->getId()."','".$table->getName()."', '".$table->getCharEncoding()."','".$table->getDatabaseId()."','".$table->getUserId()."');";
      }else throw new Exception("[ERR] table must be an instance of DBTable ", 102);
    }else throw new Exception("[ERR] SqlQueryGenerator - table must be a not null object", 101);
  }

  private static function insertDBColStatement($col){
    if(isset($col)){
      if($col instanceof DBCol){
        $ret = SqlQueryGenerator::checkColNullValues($col);
        return "INSERT INTO dbcols VALUES ('".$col->getId()."','".$col->getTableId()."', '".$col->getDatabaseId()."','".$col->getUserId()."','".$col->getName()."','".$col->getType()."','".$col->isNull()."','".$col->isPrimary()."','".$col->isUnique()."','".$col->getLength()."'". $ret;
      }else throw new Exception("[ERR] SqlQueryGenerator - col must be an instance of DBCol ", 102);
    }else throw new Exception("[ERR] SqlQueryGenerator - col must be a not null object", 101);
  }

  private static function insertObject3DStatement($obj){
    if(isset($obj)){
      if($obj instanceof Object3D){
        return "INSERT INTO object3d VALUES ('".$obj->getPositionX()."','".$obj->getPositionY()."', '".$obj->getPositionZ()."', '".$obj->getSize()."', '".$obj->getMaterial()."','".$obj->getOpacity()."','".$obj->getTexture()."','".$obj->getColor()."','".$obj->getId()."','".$obj->getReferTo()."');";
      }else throw new Exception("[ERR] SqlQueryGenerator - object must be an instance of Object3D ", 102);
    }else throw new Exception("[ERR] SqlQueryGenerator - object must be a not null object", 101);
  }

  private static function checkColNullValues($col){
    //,'".$col->getAttributes()."','".$col->getDefault()."','".$col->isAutoincrement()."','".$col->getComments()."','".$col->getVirtuality()."','".$col->getMIMEtype()."');
    $ret = "";
    if($col->getAttributes() != null){
      $ret .= ",'".$col->getAttributes()."'";
    }else{
      $ret .= ",'NULL'";
    }
    if($col->getDefault() != null){
      $ret .= ",'".$col->getDefault()."'";
    }else{
      $ret .= ",'NULL'";
    }
    $ret .= ",'".$col->isAutoincrement()."'";
    if($col->getComments() != null){
      $ret .= ",'".$col->getComments()."'";
    }else{
      $ret .= ",'NULL'";
    }
    if($col->getVirtuality() != null){
      $ret .= ",'".$col->getVirtuality()."'";
    }else{
      $ret .= ",'NULL'";
    }
    if($col->getMIMEtype() != null){
      $ret .= ",'".$col->getMIMEtype()."'";
    }else{
      $ret .= ",'NULL'";
    }
    $ret .= ");";

    return $ret;
  }

  private static function insertUserLogStatement($ul){
    if(isset($ul)){
      if($ul instanceof UserLog){
        return "INSERT INTO userlogs VALUES ('".$ul->getId()."','".$ul->getTime()."', '".$ul->getUserId()."','".$ul->getType()."','".$ul->getInfo()."','".$ul->getLevel()."');";
      }else throw new Exception("[ERR] userlog must be an instance of UserLog ", 102);
    }else throw new Exception("[ERR] SqlQueryGenerator - userlog must be a not null object", 101);
  }

  private static function insertApiKeyStatement($apikey){
    if(isset($apikey)){
      if($apikey instanceof ApiKey){
        return "INSERT INTO apikeys VALUES ('".$apikey->getKey()."','".$apikey->getCreationDate()."', '".$apikey->getUserId()."','".$apikey->getDeadline()."');";
      }else throw new Exception("[ERR] apikey must be an instance of ApiKey ", 102);
    }else throw new Exception("[ERR] SqlQueryGenerator - apikey must be a not null object", 101);
  }


  public static function selectStatement($table_name,$columns){
    $statement = "SELECT ";
    for($i=0; $i<count($columns); $i++){
      if($i+1>count($columns))
        $statement .= $columns[$i];
      else
        $statement .= $columns[$i].",";
    }
    return $statement . "FROM ".$table.";";
  }

  public static function selectAllStatement($table){
    return "SELECT * FROM ".$table.";";
  }

  public static function deleteStatement($table, $column_name, $value){
    return "DELETE FROM ".$table." WHERE " . $column_name . "='".$value."';";
  }

  public static function selectFromWhereStatement($table, $column, $value){
    return "SELECT * FROM ".$table." WHERE ".$column." = '$value';";
  }

  public static function updateStatement($obj){
    switch(get_class($obj)){
      case 'User':
        return SqlQueryGenerator::updateUserStatement($obj);
      break;
      case "DBDatabase":
        return SqlQueryGenerator::updateDatabaseStatement($obj);
      break;
      case "UserLog":
        return SqlQueryGenerator::updateUserLogStatement($obj);
      break;
      case "Apikey":
        return SqlQueryGenerator::updateApikeyStatement($obj);
      break;
      case "DBTable":
        return SqlQueryGenerator::updateDBTableStatement($obj);
      break;
      case "Object3D":
        return SqlQueryGenerator::updateObject3DStatement($obj);
      break;
    }
  }

  private static function updateUserStatement($user){
    return "UPDATE users SET name='".$user->getName()."', surname='".$user->getSurname()."', password='".$user->getPassword()."', description='".$user->getDescription()."' WHERE email='".$user->getEmail()."';";
  }

  private static function updateDatabaseStatement($db){
    return "UPDATE dbdatabases SET name='".$db->getName()."', encoding='".$db->getEncoding()."', user_id='".$db->getUserId()."', server_address='".$db->getServerAddress()."', server_password='".$db->getServerPassword()."', server_username='".$db->getServerUsername()."', server_port='".$db->getServerPort()."' WHERE id='".$db->getId()."';";
  }

  private static function updateUserLogStatement($ul){
    return "UPDATE apikeys SET id='".$ul->getId()."', timestamp='".$ul->getTime()."', user_id='".$ul->getUserId()."', type='".$ul->getType()."', info='".$ul->getInfo()."', level='".$ul->getLevel()."' WHERE id='".$ul->getId()."';";
  }

  private static function updateApikeyStatement($apikey){
    return "UPDATE apikeys SET apikey='".$apikey->getKey()."', creation_date='".$apikey->getCreationDate()."', user_id='".$apikey->getUserId()."', expiration_date='".$apikey->getDeadline()."' WHERE user_id='".$apikey->getUserId()."';";
  }
  private static function updateDBTableStatement($dbtable){
    return "UPDATE dbtables SET id='".$dbtable->getId()."', name='".$dbtable->getName()."', encoding='".$dbtable->getCharEncoding()."', database_id='".$dbtable->getDatabaseId()."', user_id='".$dbtable->getUserId()."' WHERE id='".$dbtable->getId()."';";
  }
  private static function updateObject3DStatement($object){
    return "UPDATE object3d SET  x='".$object->getPositionX()."', y='".$object->getPositionY()."', z='".$object->getPositionZ()."', size='".$object->getSize()."', material='".$object->getMaterial()."', opacity='".$object->getOpacity()."', texture='".$object->getTexture()."', color='".$object->getColor()."', referto='".$object->getReferTo()."' WHERE id='".$object->getId()."';";
  }

}

?>
