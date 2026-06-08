<?php
require_once __DIR__ . "/../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

// Comprobamos que el usuario esté logueado y sea de tipo usuario normal
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-usuario') {
    header('Location: ' . BASE_URL . '/app/views/auth/Login.php');
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Reset.php';
require_once __DIR__ . '/../models/ResetComentario.php';

$db              = new Db();
$conn            = $db->getConnection();
$resetModel      = new Reset($conn);
$comentarioModel = new ResetComentario($conn);

$id_usuario = $_SESSION['user_id'];

// Recogemos el id del reset de la URL
$id_reset = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Si no viene ID válido, volvemos al panel
if ($id_reset == 0) {
    header('Location: controller_user_dashboard.php');
    exit();
}

// Cargamos el reset y comprobamos que pertenece a este usuario
$reset = $resetModel->obtenerPorIdUsuario($id_reset, $id_usuario);

// Si no existe o no le pertenece, volvemos al panel
if (!$reset) {
    header('Location: controller_user_dashboard.php');
    exit();
}

// ── Si se envía un formulario ────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $action = $_POST['action'];

    // Acción: cancelar el reset
    if ($action == 'cancelar') {
        // Solo puede cancelar si está pendiente (1) o activo (2)
        if ($reset['id_estado'] == 1 || $reset['id_estado'] == 2) {
            $ok = $resetModel->cambiarEstadoUsuario($id_reset, $id_usuario, 4);
            if ($ok) {
                $_SESSION['flash'] = array('tipo' => 'success', 'msg' => 'Solicitud cancelada correctamente.');
            } else {
                $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'No se pudo cancelar la solicitud.');
            }
        } else {
            $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'Esta solicitud no se puede cancelar.');
        }

        // Acción: añadir comentario
    } elseif ($action == 'comentar') {
        // No puede comentar si está cancelado
        if ($reset['id_estado'] != 4) {
            $texto = trim($_POST['texto']);
            if ($texto != '') {
                // id_voluntario = null porque quien comenta es el usuario
                $comentarioModel->insertar($id_reset, $id_usuario, null, $texto);
                $_SESSION['flash'] = array('tipo' => 'success', 'msg' => 'Mensaje enviado.');
            } else {
                $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'El mensaje no puede estar vacío.');
            }
        }
    } elseif ($action == 'eliminar_comentario') {
    $id_comentario = filter_input(INPUT_POST, 'id_comentario', FILTER_VALIDATE_INT);
    if ($id_comentario) {
        $ok = $comentarioModel->marcarComoEliminado($id_comentario, null, $id_usuario);
        $_SESSION['flash'] = $ok
            ? ['tipo' => 'success', 'msg' => 'Mensaje eliminado.']
            : ['tipo' => 'error',   'msg' => 'No se pudo eliminar el mensaje.'];
        }  
    }

    // Redirigimos para evitar reenvío del formulario
    header('Location: controller_user_reset_detalle.php?id=' . $id_reset);
    exit();
}

// ── Recargamos los datos por si han cambiado ─────────────────────────────────
$reset       = $resetModel->obtenerPorIdUsuario($id_reset, $id_usuario);
$comentarios = $comentarioModel->obtenerPorReset($id_reset);

// Marcamos que el usuario ha visto este reset → borra la notificación del punto rojo
$resetModel->actualizarVisitaUsuario($id_reset);

$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
unset($_SESSION['flash']);

// Cargamos la vista
require_once __DIR__ . '/../views/user/detalle.php';
?>