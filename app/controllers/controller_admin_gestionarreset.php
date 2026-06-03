<?php
require_once __DIR__ . '/../../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: ' . BASE_URL . '/Login');
    exit();
}

if ($_SESSION['user_rol'] !== 'admin') {
    header('Location: ' . BASE_URL . '/Inicio');
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Historia.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Reset.php';
require_once __DIR__ . '/../models/Voluntario.php';

$db = new Db();
$conn = $db->getConnection();
$resetModel = new Reset($conn);
$volModel = new Voluntario();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_reset'])) {

    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        header('Location: ' . BASE_URL . '/app/controllers/controller_admin_gestionarreset.php');
        exit();
    }

    $id_reset = (int)$_POST['id_reset'];
    $id_voluntario = !empty($_POST['id_voluntario']) ? (int)$_POST['id_voluntario'] : null;
    $id_estado = (int)$_POST['id_estado'];

    if ($id_voluntario !== null && !$volModel->existe($id_voluntario)) {
        $id_voluntario = null;
    }

    $resetModel->actualizarAsignacionYEstado($id_reset, $id_voluntario, $id_estado);

    if ($id_estado === 3) {
        $historiaModel = new Historia();
        $historiaModel->crearAutomaticaDesdeReset($id_reset);
    }

    header('Location: ' . BASE_URL . '/app/controllers/controller_admin_gestionarreset.php?updated=1');
    exit();
}

$sql1 = "SELECT r.id AS id_reset, r.titulo, r.descripcion, r.created_at AS fecha, r.id_voluntario, r.id_estado, u.nombre AS solicitante, c.nombre_categoria, e.nombre_estado FROM reset r JOIN usuario u ON r.id_usuario = u.id LEFT JOIN categoria_reset c ON r.id_categoria = c.id LEFT JOIN estado_maestro e ON r.id_estado = e.id ORDER BY r.created_at DESC";
$resultado1 = $conn->query($sql1);
$resets = $resultado1->fetchAll();

$sql2 = "SELECT v.id AS id_voluntario, u.nombre FROM voluntario v JOIN usuario u ON v.id_usuario = u.id ORDER BY u.nombre";
$resultado2 = $conn->query($sql2);
$voluntarios = $resultado2->fetchAll();

$sql3 = "SELECT id AS id_estado, nombre_estado FROM estado_maestro ORDER BY id";
$resultado3 = $conn->query($sql3);
$estados = $resultado3->fetchAll();

include __DIR__ . '/../views/admin/gestionarreset.php';
