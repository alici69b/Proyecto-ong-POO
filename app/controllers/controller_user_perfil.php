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
require_once __DIR__ . '/../Helpers/Validaciones.php';

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

    // Acción: Actualizar datos personales
    if ($action == 'datos') {
        $nombre     = trim($_POST['nombre']);
        $apellidos  = trim($_POST['apellidos']);
        $tipo_ayuda = trim($_POST['tipo_ayuda']);

        $errores = Validaciones::validarDatosPersonales([
            'nombre' => $nombre, 'apellidos' => $apellidos, 'tipo_ayuda' => $tipo_ayuda
        ]);

        if (!empty($errores)) {
            $_SESSION['flash'] = ['tipo' => 'error', 'msg' => 'Revisa los campos obligatorios.'];
        } else {
            $ok = $usuarioModel->actualizarDatos($id_usuario, [
                'nombre' => $nombre, 'apellidos' => $apellidos, 'tipo_ayuda' => $tipo_ayuda
            ]);

            if ($ok) {
                $_SESSION['user_nombre'] = $nombre;
                $_SESSION['user_apellidos'] = $apellidos;
                $_SESSION['flash'] = ['tipo' => 'success', 'msg' => 'Datos actualizados correctamente.'];
            } else {
                $_SESSION['flash'] = ['tipo' => 'error', 'msg' => 'No se pudieron guardar los cambios.'];
            }
        }

        // Acción: cambiar contraseña
    } elseif ($action == 'password') {
        $actual    = $_POST['password_actual'];
        $nuevo     = $_POST['password_nuevo'];
        $confirmar = $_POST['password_confirmar'];

        $errores = Validaciones::validarPasswordConConfirmacion([
            'password_nueva' => $nuevo, 'password_confirmar' => $confirmar
        ]);

        if (!empty($errores)) {
            $_SESSION['flash'] = ['tipo' => 'error', 'msg' => reset($errores)[0]];
        } else {
            $datosUsuario = $usuarioModel->buscarPorId($id_usuario);
            if (!password_verify($actual, $datosUsuario['password'])) {
                $_SESSION['flash'] = ['tipo' => 'error', 'msg' => 'La contraseña actual no es correcta.'];
            } elseif (password_verify($nuevo, $datosUsuario['password'])) {
                $_SESSION['flash'] = ['tipo' => 'error', 'msg' => 'La nueva contraseña no puede ser igual a la actual.'];
            } else {
                $usuarioModel->cambiarPassword($id_usuario, $nuevo);
                $_SESSION['flash'] = ['tipo' => 'success', 'msg' => 'Contraseña actualizada correctamente.'];
            }
        }

    // Acción: cambiar foto de perfil
    } elseif ($action == 'foto') {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $errFoto = Validaciones::validarFoto($_FILES['foto']);

            if (!empty($errFoto)) {
                $_SESSION['flash'] = ['tipo' => 'error', 'msg' => $errFoto[0]];
            } else {
                $extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                $nombreArchivo  = 'user_' . $id_usuario . '_' . time() . '.' . $extension;
                $carpetaDestino = __DIR__ . '/../../public/img/';

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $carpetaDestino . $nombreArchivo)) {
                    $usuarioModel->actualizarFoto($id_usuario, $nombreArchivo);
                    $_SESSION['foto_perfil'] = $nombreArchivo;
                    $_SESSION['flash'] = array('tipo' => 'success', 'msg' => 'Foto actualizada correctamente.');
                } else {
                    $_SESSION['flash'] = array('tipo' => 'error', 'msg' => 'No se pudo guardar la imagen.');
                }
            }
        }
    //Eliminar cuenta
    } elseif ($action == 'eliminar_cuenta') {

        $ok = $usuarioNormal->eliminarCuenta($id_usuario);
        if ($ok) {
            $_SESSION = [];

            // Si se usan cookies para la sesión, eliminamos la cookie de sesión
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            // Destruimos la sesión y redirigimos a página de cuenta eliminada
            session_destroy();
            header('Location: ' . BASE_URL . '/app/views/auth/cuenta_eliminada.php');
            exit();
        } else {
            $_SESSION['flash'] = ['tipo' => 'error', 'msg' => 'No se pudo eliminar la cuenta.'];
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
