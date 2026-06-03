<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: ../views/auth/Login.php');
    exit();
}

$rol = $_SESSION['user_rol'] ?? '';

if ($rol === 'admin') {
    header('Location: controller_admin_dashboard.php');
} elseif ($rol === 'soy-voluntario') {
    header('Location: controller_volunteer_perfil.php');
} else {
    header('Location: controller_user_perfil.php');
}
exit();
