<?php
require_once __DIR__ . '/../../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../Helpers/Validaciones.php';
require_once __DIR__ . '/../models/UsuarioNormal.php';
require_once __DIR__ . '/../models/Voluntario.php';
require_once __DIR__ . '/../models/Admin.php';

$usuarioModel   = new UsuarioNormal();
$voluntarioModel = new Voluntario();
$adminModel      = new Admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_crear'])) {

    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        header('Location: controller_admin_gestionusuarios.php');
        exit();
    }

    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos'] ?? '');
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $id_rol = (int)$_POST['id_rol'];

    $errores = Validaciones::validarUsuario([
        'nombre' => $nombre, 'apellidos' => $apellidos, 'email' => $email, 'password' => $password
    ]);
    if (!empty($errores)) {
        header('Location: controller_admin_gestionusuarios.php?errorvalidacion=1');
        exit();
    }

    if ($usuarioModel->existeEmail($email)) {
        header('Location: controller_admin_gestionusuarios.php?erroremail=1');
        exit();
    }

    $newId = $usuarioModel->insertarBase([
        'nombre' => $nombre, 'apellidos' => $apellidos,
        'email' => $email, 'password' => $password, 'id_rol' => $id_rol
    ]);

    if ($id_rol == 2) {
        $voluntarioModel->insertarSoloId($newId);
    } elseif ($id_rol == 3) {
        $adminModel->insertarSoloId($newId);
    }

    header('Location: controller_admin_gestionusuarios.php?created=1');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario'])) {

    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        header('Location: controller_admin_gestionusuarios.php');
        exit();
    }

    $id = (int)$_POST['id_usuario'];
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos'] ?? '');
    $email = trim($_POST['email']);
    $id_rol = (int)$_POST['id_rol'];

    $datosValidar = ['nombre' => $nombre, 'apellidos' => $apellidos, 'email' => $email];
    if (!empty($_POST['password_nuevo'])) {
        $datosValidar['password'] = $_POST['password_nuevo'];
    }
    $errores = Validaciones::validarUsuario($datosValidar);
    if (!empty($errores)) {
        header('Location: controller_admin_gestionusuarios.php?errorvalidacion=1');
        exit();
    }

    $usuarioModel->actualizarDatosAdmin($id, $nombre, $apellidos, $email, $id_rol);

    if (!empty($_POST['password_nuevo'])) {
        $usuarioModel->cambiarPassword($id, $_POST['password_nuevo']);
    }

    header('Location: controller_admin_gestionusuarios.php?updated=1');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($id !== (int)$_SESSION['user_id']) {
        $voluntarioModel->eliminarPorIdUsuario($id);
        $adminModel->eliminarPorIdUsuario($id);
        $usuarioModel->eliminar($id);
    }
    header('Location: controller_admin_gestionusuarios.php?deleted=1');
    exit();
}

$buscar = trim($_GET['search'] ?? '');
$pagina = max(1, (int)($_GET['p'] ?? 1));
$por_pagina = 10;

$total_usuarios = $usuarioModel->contarConFiltro($buscar);
$total_paginas = max(1, (int)ceil($total_usuarios / $por_pagina));

$usuarios = $usuarioModel->listarPaginado($buscar, $pagina, $por_pagina);

foreach ($usuarios as &$u) {
    $u['iniciales'] = strtoupper(substr($u['nombre'], 0, 1) . substr($u['apellidos'] ?? $u['nombre'], 0, 1));
    $u['fecha_registro'] = $u['created_at'];
}
unset($u);

include __DIR__ . '/../views/admin/gestionusuarios.php';
