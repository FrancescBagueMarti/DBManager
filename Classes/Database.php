<?php
namespace Classes;
use \PDO;
use \TableRows;
class Database {
    private string $serverName;
    private string $userName;
    private string $password;
    private string $database;
    
    public function __construct($serverName, $database, $userName, $password) {
        $this->serverName = $serverName;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;
    }
    private function getConnection() {
        $conn = new PDO("mysql:host=".$this->serverName.";dbname=".$this->database, $this->userName, $this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    
    public function select($query) {
    //   echo $query;
    //   return;
      $conn = $this->getConnection();
      $stmt = $conn->prepare($query);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    public function insert($query) {
      $conn = $this->getConnection();
      $conn->exec($query);
    }
}