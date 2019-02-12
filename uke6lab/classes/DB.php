<?php

class DB {
  private static $db=null;
  private $dsn = 'mysql:dbname=fileStorage;host=192.168.80.3';
  private $user = 'root';
  private $password = 'test';
  private $dbh = null;

  private function __construct() {
    try {
        $this->dbh = new PDO($this->dsn, $this->user, $this->password);
    } catch (PDOException $e) {
        // NOTE IKKE BRUK DETTE I PRODUKSJON
        echo 'Connection failed: ' . $e->getMessage();
    }
  }

  public static function getDBConnection() {
      if (DB::$db==null) {
        DB::$db = new self();
      }
      return DB::$db->dbh;
  }
}