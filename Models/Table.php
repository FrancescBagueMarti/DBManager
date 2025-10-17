<?php // table.php
namespace Models;
class Table {
    public $tableName;
    public $columns;
    public $columnsNoId;

    public function __construct($tableName, $columns) {
        $this->tableName = $tableName;
        $this->columns = (function($tableName,$cols) {
            $aux = [];
            foreach($cols as $c) {
                $aux[] = $tableName.".".$c;
            }
            return $aux;
        })($tableName,$columns); // fix: assign columns
        $this->columnsNoId = (function($tableName, $cols){
            $aux = [];
            foreach($cols as $c) {
                if ($c != "id") {
                    $aux[] = $tableName.".".$c;
                }
            }
            return $aux;
        })($tableName, $columns);
    }
    /**
     * @param array $cols array that contains the names of the columns  ex: ['name', 'age', 'COUNT(id)']
     * @param array $join array that contains the join strings          ex: ['JOIN pets ON pets.ownerId = person.id', 'JOIN cars ON cars.ownerId = person.id']
     * @param array $where Array that contains the where strings        ex: ['person.gender = "male"', 'cars.color = "red"']
     */
    public function select($cols = false, $join = false, $where = false): string {
        $hasCols = $cols != false;
        if (!$hasCols) {
            $cols = implode(", ", $this->columns);
        } else {
            $cols = implode(", ", $cols);
        }

        $query = "SELECT $cols FROM $this->tableName";

        if ($join != false) {
            foreach ($join as $j) {
                $query .= " $j";  // Append each join clause to the query
            }

            // Optional: if $cols is false, also add joined tables' columns as table.*
            // This would require parsing join strings to extract table names
            
            foreach($join as $j) {
                $tab = (function($s){
                    $aux = explode(" ",$s);
                    $aux = array_values(array_filter($aux, function($valor) {
                        return $valor !== '';
                    }));
                    return $aux[1];
                })($j);
                $s = explode("FROM", $query);
                $s[0].=" , ".$tab.".* ";
                $query = implode("FROM", $s);
            }
        }

        // checks if there is a $where array
        if ($where != false) {
            // Checks if $where is empty
            if (empty($where)) {
                $query .= " WHERE ";
                foreach($where as $index => $clause) {
                    // Only adds the 'AND' KEYWORD when it is not the first where clause
                    if ($index != 0) {
                        $query .= " AND ";
                    }
                    $query .= " ".$clause." ";
                }
            }
        }
        
        return $query;
    }

    protected function insert($cols=false, $values=false) {
        $query = "";
        if (count($cols) == 0) {
            return ["result"=>"KO", "message"=>"No se han pasado columnas al insert"];
        }
        if ($cols != false) {
            $query.="INSERT (".implode(", ",$cols).") INTO ".$this->tableName;
        } else {
            $query.="INSERT (".implode(", ",$this->columns).") INTO ".$this->tableName;
        }
        
        if ($values == false || count($values) == 0) {
            return ["result" => "KO", "message" => "No se han pasado valores al insert"];
        }

        echo $query;
      
    }
}
?>