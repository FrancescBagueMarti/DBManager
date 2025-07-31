<?php
//header("Content-type: text/plain");
require_once("conf.php");
require_once(HOME_DIR."/Classes/Database.php");
require_once(__DIR__."/Models/Client.php");

$Database = new Classes\Database("localhost", "pruebas", "root","");
$Client = new Models\Client();

// print_r($Database->select($Client->select(false, ["join pets on pets.owner = client.id"])));
print_r($Client->insert($Client->columns, []));