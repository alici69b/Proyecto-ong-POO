<?php
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Reset.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/auth/Login.php');
    exit();
}

$email    = trim($_POST['email'] ?? '');
$password = $_POST['pass'] ?? '';

if (empty($email) || empty($password)) {
    $_SESSION['error_login'] = 'Todos los campos son obligatorios.';
    header('Location: ../views/auth/Login.php');
    exit();
}

try {
    $modelo  = new Reset();
    $usuario = $modelo->buscarPorEmail($email);

    if (!$usuario) {
        $_SESSION['error_login'] = 'El email no está registrado.';
        header('Location: ../views/auth/Login.php');
        exit();
    }

    if (!password_verify($password, $usuario['password'])) {
        $_SESSION['error_login'] = 'Contraseña incorrecta.';
        header('Location: ../views/auth/Login.php');
        exit();
    }

    $_SESSION['user_id']     = $usuario['id'];
    $_SESSION['user_nombre'] = $usuario['nombre'];
    $_SESSION['user_email']  = $usuario['email'];
    $_SESSION['user_rol']    = $usuario['nombre_rol'];
    $_SESSION['logged_in']   = true;

    $rol = strtolower($usuario['nombre_rol']);
    if ($rol === 'admin') {
        header('Location: ../views/admin/dashboard.php');
    } elseif ($rol === 'soy-voluntario') {
        header('Location: ../views/volunteer/dashboard.php');
    } elseif ($rol === 'soy-usuario') {
        header('Location: ../views/user/dashboard.php');
    } else {
        header('Location: /Proyecto-ong-POO/index.php');
    }
    exit();

} catch (Exception $e) {
    $_SESSION['error_login'] = 'Error interno: ' . $e->getMessage();
    header('Location: ../views/auth/Login.php');
    exit();
}
