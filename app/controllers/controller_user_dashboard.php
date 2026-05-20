<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-usuario') {
    header('Location: ../views/auth/Login.php');
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Reset.php';

try {
    $resetModel = new UsuarioNormal();
    $userId = (int) $_SESSION['user_id'];

    $resets = $resetModel->obtenerResetsPorUsuario($userId);
    $stats = UsuarioNormal::calcularEstadisticas($resets);

    $totalResets = $stats['total'];
    $enCurso = $stats['en_curso'];
    $logrados = $stats['logrados'];
    $nombreCompleto = htmlspecialchars(trim(($_SESSION['user_nombre'] ?? '') . ' ' . ($_SESSION['user_apellidos'] ?? '')));
} catch (Exception $e) {
    $resets = [];
    $totalResets = 0;
    $enCurso = 0;
    $logrados = 0;
    $nombreCompleto = htmlspecialchars(trim(($_SESSION['user_nombre'] ?? 'Usuario') . ' ' . ($_SESSION['user_apellidos'] ?? '')));
}

require_once __DIR__ . '/../views/user/dashboard.php';
