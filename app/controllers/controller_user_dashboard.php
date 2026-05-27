<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$modo_simulado = isset($_SESSION['modo_simulado']) && $_SESSION['modo_simulado'];

require_once __DIR__ . "/../views/user/dashboard.php";
