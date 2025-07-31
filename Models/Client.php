<?php // client.php

namespace Models;

require_once(__DIR__."/../conf.php");
require_once(HOME_DIR . "/Models/Table.php");

class Client extends Table {
    public function __construct() {
        parent::__construct("client", ["id", "nombre", "apellidos", "edad", "email"]);
    }

    public function getTableName() {
        return $this->tableName;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function select($cols = false, $join = false, $where = false): string {
        $columns = $cols ?: $this->columns; // false/null/empty → use $this->columns
        return parent::select($cols, $join, $where);
    }
    public function insert($cols=false, $values=false) {
      return parent::insert($cols, $values);
    }
}
?>