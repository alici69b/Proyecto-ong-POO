<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'admin') {
    header('Location: ../auth/Login.php');
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Historia.php';
$historiaModel = new Historia();

$db = new Database();
$conn = $db->getConnection();

$usuarios = $conn->query("SELECT id, nombre, apellidos FROM usuario WHERE id_rol = 1 ORDER BY nombre ASC")->fetchAll();
$voluntarios = $conn->query("SELECT u.id, u.nombre, u.apellidos FROM usuario u JOIN voluntario v ON u.id = v.id_usuario ORDER BY u.nombre ASC")->fetchAll();
$categorias = $conn->query("SELECT nombre_categoria FROM categoria_reset ORDER BY id ASC")->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_crear'])) {
    $datos = $_POST;
    if (!empty($_FILES['foto']['name'])) {
        $archivo = $_FILES['foto'];
        $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($ext, $permitidas)) {
            $nombreArchivo = 'historia_nueva_' . time() . '.' . $ext;
            $ruta = __DIR__ . '/../../public/img/' . $nombreArchivo;
            if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
                $datos['foto'] = $nombreArchivo;
            }
        }
    }
    $id = $historiaModel->insertar($datos);
    header('Location: controller_admin_gestionarhistorias.php?created=' . ($id > 0 ? 1 : 0));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_editar']) && isset($_POST['id'])) {
    $datos = $_POST;
    if (!empty($_FILES['foto']['name'])) {
        $archivo = $_FILES['foto'];
        $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($ext, $permitidas)) {
            $nombreArchivo = 'historia_' . $_POST['id'] . '_' . time() . '.' . $ext;
            $ruta = __DIR__ . '/../../public/img/' . $nombreArchivo;
            if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
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
