<?php
namespace Classes;
use \PDO;
use \TableRows;
class Database {
    private string $serverName;
    private string $userName;
    private string $password;
    private string $database;

    private static function eliminarClavesNumericas(array $array): array {
        $resultado = [];
    
        foreach ($array as $key => $subArray) {
            if (is_array($subArray)) {
                // Filtrar claves numéricas en el subarray
                $filtrado = array_filter($subArray, function($value, $clave) {
                    return !is_int($clave);
                }, ARRAY_FILTER_USE_BOTH);
                $resultado[$key] = $filtrado;
            } else {
                $resultado[$key] = $subArray;
            }
        }
    
        return $resultado;
    }
    
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

        return self::eliminarClavesNumericas(
            $stmt->fetchAll()
        );
    }
    public function insert($query) {
        $conn = $this->getConnection();
        $conn->exec($query);
    }
    public static function columnsForSelect($cols) {
        $aux=[];
        foreach($cols as $c) {
            $aux[]= $c." as '".$c."'";
        }
        return $aux;
    }
}