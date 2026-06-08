<?php
require_once __DIR__ . '/../../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: ' . BASE_URL . '/app/views/auth/Login.php');
    exit();
}

if ($_SESSION['user_rol'] !== 'admin') {
    header('Location: ' . BASE_URL . '/index.php');
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Historia.php';
require_once __DIR__ . '/../models/Reset.php';
require_once __DIR__ . '/../models/Voluntario.php';

$db = new Db();
$conn = $db->getConnection();
$resetModel      = new Reset($conn);
$voluntarioModel = new Voluntario();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_reset'])) {

    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        header('Location: ' . BASE_URL . '/app/controllers/controller_admin_gestionarreset.php');
        exit();
    }

    $id_reset = (int)$_POST['id_reset'];
    $id_voluntario = !empty($_POST['id_voluntario']) ? (int)$_POST['id_voluntario'] : null;
    $id_estado = (int)$_POST['id_estado'];

    // Si se está asignando un voluntario pero el estado sigue siendo "pendiente",
    // lo pasamos automáticamente a "activo" (igual que cuando el voluntario se auto-asigna)
    if ($id_voluntario !== null && $id_estado === 1) {
        $id_estado = 2;
    }

    $resetModel->actualizarAsignacion($id_reset, $id_voluntario, $id_estado);

    if ($id_estado === 3) {
        // Solo crear historia si el reset NO estaba ya en estado "resuelto"
        $estado_anterior = $resetModel->obtenerEstado($id_reset);

        if ($estado_anterior !== null && $estado_anterior !== 3) {
            $historiaModel = new Historia();
            $historiaModel->crearAutomaticaDesdeReset($id_reset);
        }
    }

    header('Location: ' . BASE_URL . '/app/controllers/controller_admin_gestionarreset.php?updated=1');
    exit();
}

$filtroEstado = $_GET['estado'] ?? '';
$pagina = max(1, (int)($_GET['p'] ?? 1));
$por_pagina = 3;

$resets      = $resetModel->obtenerPaginadoConDetalles('', $filtroEstado, $pagina, $por_pagina);
$total_resets = $resetModel->contarResetsConFiltro('', $filtroEstado);
$total_paginas = max(1, (int)ceil($total_resets / $por_pagina));
$voluntarios = $voluntarioModel->listarConNombre();
$estados     = $resetModel->obtenerEstados();

include __DIR__ . '/../views/admin/gestionarreset.php';
