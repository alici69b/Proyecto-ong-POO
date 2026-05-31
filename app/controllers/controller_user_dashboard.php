<?php
session_start();

// Comprobamos que el usuario esté logueado y sea de tipo usuario normal
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-usuario') {
    header('Location: ../views/auth/Login.php');
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Reset.php';

// Creamos la conexión y el modelo
$db         = new Database();
$conn       = $db->getConnection();
$resetModel = new Reset($conn);

$id_usuario = $_SESSION['user_id'];

// ── Si se envía el formulario de crear reset 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'crear_reset') {

    $titulo            = trim($_POST['titulo']);
    $id_categoria      = (int)$_POST['id_categoria'];
    $descripcion       = trim($_POST['descripcion']);
    $necesidades_reset = trim($_POST['necesidades_reset']);
    $causa_abandono    = trim($_POST['causa_abandono']);

    // Comprobamos que los campos obligatorios no estén vacíos
    if ($titulo == '' || $id_categoria == 0) {
        $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'El título y la categoría son obligatorios.');
    } else {
        // Nombre completo del usuario para el campo nombre_contacto
        $nombre_contacto = $_SESSION['user_nombre'] . ' ' . ($_SESSION['user_apellidos'] ?? '');
        $email_contacto  = $_SESSION['user_email'] ?? '';

        $ok = $resetModel->crear($titulo, $id_categoria, $id_usuario, $descripcion, $necesidades_reset, $causa_abandono, $nombre_contacto, $email_contacto);

        if ($ok) {
            $_SESSION['flash'] = array('tipo' => 'success', 'msg' => 'Solicitud enviada. En breve un voluntario se asignará a tu caso.');
        } else {
            $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'No se pudo crear la solicitud. Inténtalo de nuevo.');
        }
    }

    header('Location: controller_user_dashboard.php');
    exit();
}

// ── Recogemos el filtro de categoría si viene en la URL ──────────────────────
$id_categoria = null;
if (isset($_GET['categoria']) && $_GET['categoria'] != '') {
    $id_categoria = (int)$_GET['categoria'];
}

// ── Obtenemos los datos para la vista ────────────────────────────────────────
$mis_resets = $resetModel->obtenerPorUsuario($id_usuario, $id_categoria);

// Obtenemos las categorías directamente con una consulta simple
$stmtCat    = $conn->query("SELECT id, nombre_categoria FROM categoria_reset ORDER BY nombre_categoria");
$categorias = $stmtCat->fetchAll();

// Calculamos las estadísticas y las notificaciones de cada reset
$total             = count($mis_resets);
$activos           = 0;
$resueltos         = 0;
$hay_notificacion  = false; // Para el punto rojo del sidebar

foreach ($mis_resets as &$r) {
    if ($r['id_estado'] == 2) $activos++;
    if ($r['id_estado'] == 3) $resueltos++;

    // Comprobamos si este reset tiene mensajes sin leer
    $r['tiene_notificacion'] = $resetModel->tieneNotificacionUsuario($r['id']);

    // Si alguno tiene notificación, encendemos el punto del sidebar
    if ($r['tiene_notificacion']) {
        $hay_notificacion = true;
    }
}
unset($r); // Buena práctica tras usar & en el foreach

$stats = array('total' => $total, 'activos' => $activos, 'resueltos' => $resueltos);

// Recogemos el mensaje flash y lo borramos de la sesión
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
unset($_SESSION['flash']);

// Cargamos la vista
require_once __DIR__ . '/../views/user/dashboard.php';
?>