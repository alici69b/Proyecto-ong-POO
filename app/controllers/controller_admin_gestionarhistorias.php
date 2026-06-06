<?php
require_once __DIR__ . '/../../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'admin') {
    header('Location: ../auth/Login.php');
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Historia.php';
require_once __DIR__ . '/../models/UsuarioNormal.php';
require_once __DIR__ . '/../models/Voluntario.php';
require_once __DIR__ . '/../models/Reset.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';
$historiaModel = new Historia();

$usuarioModel   = new UsuarioNormal();
$voluntarioModel = new Voluntario();
$resetModel      = new Reset((new Db())->getConnection());

$usuarios    = $usuarioModel->listarSolicitantes();
$voluntarios = $voluntarioModel->listarVoluntarios();
$categorias  = array_column($resetModel->obtenerCategorias(), 'nombre_categoria');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_crear'])) {

    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        header('Location: controller_admin_gestionarhistorias.php');
        exit();
    }

    $datos = $_POST;
    if (!empty($_FILES['foto']['name'])) {
        $errFoto = Validaciones::validarFoto($_FILES['foto']);
        if (empty($errFoto)) {
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $nombreArchivo = 'historia_nueva_' . time() . '.' . $ext;
            $ruta = __DIR__ . '/../../public/img/' . $nombreArchivo;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta)) {
                $datos['foto'] = $nombreArchivo;
            }
        }
    }
    $id = $historiaModel->insertar($datos);
    header('Location: controller_admin_gestionarhistorias.php?created=' . ($id > 0 ? 1 : 0));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_editar']) && isset($_POST['id'])) {

    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        header('Location: controller_admin_gestionarhistorias.php');
        exit();
    }

    $datos = $_POST;
    if (!empty($_FILES['foto']['name'])) {
        $errFoto = Validaciones::validarFoto($_FILES['foto']);
        if (empty($errFoto)) {
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $nombreArchivo = 'historia_' . $_POST['id'] . '_' . time() . '.' . $ext;
            $ruta = __DIR__ . '/../../public/img/' . $nombreArchivo;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta)) {
                $datos['foto'] = $nombreArchivo;
            }
        }
    }
    $ok = $historiaModel->actualizar((int)$_POST['id'], $datos);
    header('Location: controller_admin_gestionarhistorias.php?updated=' . ($ok ? 1 : 0));
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $ok = $historiaModel->eliminar((int)$_GET['id']);
    header('Location: controller_admin_gestionarhistorias.php?deleted=' . ($ok ? 1 : 0));
    exit();
}

$historias = $historiaModel->obtenerTodas();

$filtroEstado = $_GET['estado'] ?? '';
if ($filtroEstado === 'Publicada' || $filtroEstado === 'Borrador') {
    $historias = array_values(array_filter($historias, fn($h) => $h['estado'] === $filtroEstado));
}

include __DIR__ . '/../views/admin/gestionarhistorias.php';
