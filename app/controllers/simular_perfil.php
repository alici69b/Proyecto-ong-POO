<?php
require_once __DIR__ . "/../../config.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['modo_simulado'] = true;

$rol = $_GET['rol'] ?? '';

switch ($rol) {
    case 'voluntario':
        $_SESSION['logged_in'] = true;
        $_SESSION['user_rol'] = 'soy-voluntario';
        $_SESSION['id_voluntario'] = 999;
        $_SESSION['user_nombre'] = 'María García (Simulación)';

        include __DIR__ . '/controller_volunteer_dashboard.php';
        break;

    case 'socio':
        $_SESSION['logged_in'] = true;
        $_SESSION['user_rol'] = 'usuario';
        $_SESSION['user_nombre'] = 'Carlos Mendoza (Simulación)';

        include __DIR__ . '/controller_user_dashboard.php';
        break;

    case 'admin':
        $_SESSION['logged_in'] = true;
        $_SESSION['user_rol'] = 'admin';
        $_SESSION['user_nombre'] = 'Admin RESET (Simulación)';

        include __DIR__ . '/controller_admin_dashboard.php';
        break;

    default:
        header('Location: ' . BASE_URL . '/index.php');
        exit();
}
