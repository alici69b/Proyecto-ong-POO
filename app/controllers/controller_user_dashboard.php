<?php
session_start();

// Comprobamos que el usuario esté logueado y sea de tipo usuario normal
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-usuario') {
    header('Location: ../views/auth/Login.php');
    exit();
}

$nombreCompleto = htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario');
$totalResets = 0;
$enCurso = 0;
$logrados = 0;
$resets = [];

require_once __DIR__ . "/../views/user/dashboard.php";
