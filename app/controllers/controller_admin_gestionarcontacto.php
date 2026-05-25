<?php
session_start();

require_once __DIR__ . '/../models/Mensaje.php';

$mensajeModel = new Mensaje();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $mensajeModel->eliminar((int)$_GET['id']);
    header('Location: controller_admin_gestionarcontacto.php?deleted=1');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'read' && isset($_GET['id'])) {
    $mensajeModel->marcarComoLeido((int)$_GET['id']);
    header('Location: controller_admin_gestionarcontacto.php');
    exit();
}

$mensajes = $mensajeModel->obtenerTodos();
$total_mensajes = $mensajeModel->contarTodos();
$no_leidos = $mensajeModel->contarNoLeidos();
$leidos = $total_mensajes - $no_leidos;

include __DIR__ . '/../views/admin/gestionarcontacto.php';
