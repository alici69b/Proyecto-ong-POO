<?php
if (session_status() === PHP_SESSION_NONE) session_start();

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

$filtroLeido = $_GET['leido'] ?? '';
$pagina = max(1, (int)($_GET['p'] ?? 1));
$por_pagina = 4;

$mensajes = $mensajeModel->obtenerPaginado('', $filtroLeido, $pagina, $por_pagina);
$total_mensajes = $mensajeModel->contarConFiltro('', $filtroLeido);
//ceil--> redndea el numero
$total_paginas = max(1, (int)ceil($total_mensajes / $por_pagina));
$no_leidos = $mensajeModel->contarNoLeidos();
$leidos = $mensajeModel->contarTodos() - $no_leidos;

include __DIR__ . '/../views/admin/gestionarcontacto.php';
