<?php

interface SqlQueryGeneratorInterface{
  public static function createDatabaseStatement($db);
  public static function createTableStatement($table);
  public static function removeTableStatement($table);
  public static function updateTableStatement($table);
  public static function createForeignKeyStatements($table);
}

?>
