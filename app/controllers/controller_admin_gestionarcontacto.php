<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$modo_simulado = isset($_SESSION['modo_simulado']) && $_SESSION['modo_simulado'];

require_once __DIR__ . '/../models/Mensaje.php';

$mensajeModel = new Mensaje();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    if ($modo_simulado) {
        header('Location: controller_admin_gestionarcontacto.php?sim_bloqueado=1');
        exit();
    }
    $mensajeModel->eliminar((int)$_GET['id']);
    header('Location: controller_admin_gestionarcontacto.php?deleted=1');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'read' && isset($_GET['id'])) {
    if ($modo_simulado) {
        header('Location: controller_admin_gestionarcontacto.php?sim_bloqueado=1');
        exit();
    }
    $mensajeModel->marcarComoLeido((int)$_GET['id']);
    header('Location: controller_admin_gestionarcontacto.php');
    exit();
}

$mensajes = $mensajeModel->obtenerTodos();
$total_mensajes = $mensajeModel->contarTodos();
$no_leidos = $mensajeModel->contarNoLeidos();
$leidos = $total_mensajes - $no_leidos;

include __DIR__ . '/../views/admin/gestionarcontacto.php';
