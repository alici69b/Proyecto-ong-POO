<?php
//Controlador del login
echo "Hola";

//Inicializamos sesion
session_start();

//Leemos el rol que viene por GET
$_SESSION["rol"] = $_GET["rol"] ?? "usuario"; // por defecto usuario

//Cargamos la vista del login
require_once __DIR__ . "/../views/auth/Register.php";
?>