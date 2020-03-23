<?php 

class AdmittedRowValues{
	
	public static function getAdmittedTypes(){
		return  array('CHAR','VARCHAR','TINYTEXT', 'TEXT', 'MEDIUMTEXT', 'LONGTEXT', 'TINYINT', 'VARYING','ENUM','SET','BINARY','BIT','BOOLEAN','SERIAL','VARBINARY ','INT','SMALLINT','MEDIUMINT','BIGINT','DECIMAL','NUMERIC','FLOAT','REAL','DOUBLE','DATE','DATETIME','TIME','YEAR','TIMESTAMP','INTERVAL','ARRAY','MULTISET','XML', 'TINYBLOB', 'BLOB', 'MEDIUMBLOB', 'LONGBLOB','GEOMETRY', 'POINT', 'LINESTRING', 'POLYGON', 'MULTIPOINT','MULTILINESTRING', 'MULTYPOLIGON','GEOMETRYCOLLECTION');
	}
	public static function getAdmittedAttributes(){
		return array('BINARY','UNSIGNED','UNSIGNED ZEROFILL', 'on update CURRENT_TIMESTAMP', '');
	}
	public static function getAdmittedDefaultVal(){
		return array('NULL', 'CURRENT_TIMESTAMP', '');
	}
	public static function getAdmittedVirtuality(){
		return  array('VIRTUAL', 'PERSISTENT' , '');
	}
	public static function getAdmittedMime(){
		return array('image/jpg', 'text/plain' , 'application/octetstream' , 'image/png', 'text/octetstream');
	}
}


?>