<?php
require_once __DIR__ . "/../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

// Comprobamos que el usuario esté logueado y sea de tipo usuario normal
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-usuario') {
    header('Location: ../views/auth/Login.php');
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/UsuarioNormal.php';

// Usamos UsuarioNormal, que hereda de Usuario
$usuarioModel = new UsuarioNormal();

$id_usuario = $_SESSION['user_id'];

// ── Si se envía un formulario ────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'Error de seguridad.');
        header('Location: controller_user_perfil.php');
        exit();
    }

    $action = $_POST['action'];

    // Acción: guardar datos personales
    if ($action == 'datos') {
        $nombre     = trim($_POST['nombre']);
        $apellidos  = trim($_POST['apellidos']);
        $tipo_ayuda = trim($_POST['tipo_ayuda']);

        $ok = $usuarioModel->actualizarDatos($id_usuario, array(
            'nombre'     => $nombre,
            'apellidos'  => $apellidos,
            'tipo_ayuda' => $tipo_ayuda
        ));

        if ($ok) {
            // Actualizamos también los datos de la sesión
            $_SESSION['user_nombre']    = $nombre;
            $_SESSION['user_apellidos'] = $apellidos;
            $_SESSION['flash'] = array('tipo' => 'success', 'msg' => 'Datos actualizados correctamente.');
        } else {
            $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'No se pudieron guardar los cambios.');
        }

        // Acción: cambiar contraseña
    } elseif ($action == 'password') {
        $actual    = $_POST['password_actual'];
        $nuevo     = $_POST['password_nuevo'];
        $confirmar = $_POST['password_confirmar'];

        if ($nuevo != $confirmar) {
            $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'Las contraseñas nuevas no coinciden.');
        } elseif (strlen($nuevo) < 6) {
            $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'La contraseña debe tener al menos 6 caracteres.');
        } else {
            // Primero verificamos que la contraseña actual sea correcta
            $datosUsuario = $usuarioModel->buscarPorId($id_usuario);
            if (password_verify($actual, $datosUsuario['password'])) {
                $usuarioModel->cambiarPassword($id_usuario, $nuevo);
                $_SESSION['flash'] = array('tipo' => 'success', 'msg' => 'Contraseña actualizada correctamente.');
            } else {
                $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'La contraseña actual no es correcta.');
            }
        }

        // Acción: cambiar foto de perfil
    } elseif ($action == 'foto') {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $extension  = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $permitidas = array('jpg', 'jpeg', 'png', 'webp');
            $maxTamano  = 2 * 1024 * 1024; // 2 MB

            if (!in_array($extension, $permitidas)) {
                $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'Formato no permitido. Usa JPG, PNG o WEBP.');
            } elseif ($_FILES['foto']['size'] > $maxTamano) {
                $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'La imagen supera los 2MB.');
            } else {
                $nombreArchivo  = 'user_' . $id_usuario . '_' . time() . '.' . $extension;
                $carpetaDestino = __DIR__ . '/../../public/img/';

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $carpetaDestino . $nombreArchivo)) {
                    $usuarioModel->actualizarFoto($id_usuario, $nombreArchivo);
                    $_SESSION['flash'] = array('tipo' => 'success', 'msg' => 'Foto actualizada correctamente.');
                } else {
                    $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'No se pudo guardar la imagen.');
                }
            }
        }
    }

    header('Location: controller_user_perfil.php');
    exit();
}

// ── Obtenemos los datos para mostrar en la vista ─────────────────────────────
// obtenerPerfil() nos devuelve usuario + usuario_normal en una sola consulta
$perfil = $usuarioModel->obtenerPerfil($id_usuario);

$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
unset($_SESSION['flash']);

// Cargamos la vista
require_once __DIR__ . '/../views/user/perfil.php';
