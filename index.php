<?php
//Cargamos la clase de la base de datos
require_once "app/config/db.php";

$db = new Database();
$connection = $db->getConnection();




//Cargamos la vista principal
require_once "pages/Inicio.php";

?>