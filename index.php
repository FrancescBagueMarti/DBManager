<?php
header("Content-type: text");
require_once("conf.php");
require_once(HOME_DIR."/Classes/Database.php");
require_once(__DIR__."/Models/Client.php");

$Database = new Classes\Database("localhost", "pruebas", "root","");
$Client = new Models\Client();

// print_r( $Client->columnsNoId);
print_r($Database->select($Client->select(
    Classes\Database::columnsForSelect($Client->columnsNoId), 
    ["join pets on pets.owner = client.id"])
));
// print_r($Client->insert($Client->columnsNoId, [
//     [
//         ""
//     ]
// ]));