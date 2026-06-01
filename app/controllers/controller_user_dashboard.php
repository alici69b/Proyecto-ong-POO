<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$modo_simulado = isset($_SESSION['modo_simulado']) && $_SESSION['modo_simulado'];

$nombreCompleto = htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario');
$totalResets = 0;
$enCurso = 0;
$logrados = 0;
$resets = [];

require_once __DIR__ . "/../views/user/dashboard.php";
