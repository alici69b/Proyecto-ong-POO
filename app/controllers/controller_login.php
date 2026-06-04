<?php
require_once __DIR__ . "/../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

//importamos los modelos y helpers
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/UsuarioNormal.php';
require_once __DIR__ . '/../models/Voluntario.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';

// si no  exite el metodo post lo redirigimos al login 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/app/views/auth/Login.php');
    exit();
}

//si existe el metodo post entonces recogeremos los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        $_SESSION['error_login'] = 'Error de seguridad. Inténtalo de nuevo.';
        header('Location: ' . BASE_URL . '/app/views/auth/Login.php');
        exit();
    }

    $email    = trim($_POST['email']);
    $password = $_POST['pass'];

    //validamos email y contraseña con el helper
    $errores = Validaciones::validarLogin(['email' => $email, 'password' => $password]);
    if (!empty($errores)) {
        $_SESSION['error_login'] = reset($errores)[0];
        header('Location: ' . BASE_URL . '/app/views/auth/Login.php');
        exit();
    }

    //intentamos cmprobar si el email esta en la bbdd
    try {
        $modelo  = new UsuarioNormal();
        $usuario = $modelo->buscarPorEmail($email);

        //si no esta mandaremos un error com oque el email no esta registrado
        if (!$usuario) {
            $_SESSION['error_login'] = 'El email no está registrado.';
            header('Location: ' . BASE_URL . '/app/views/auth/Login.php');
            exit();
        }

        //si la contraseña no es la misma que la que esta guardada en la bbdd entonces mostraremos un error
        if (!password_verify($password, $usuario['password'])) {
            $_SESSION['error_login'] = 'Contraseña incorrecta.';
            header('Location: ' . BASE_URL . '/app/views/auth/Login.php');
            exit();
        }

        session_regenerate_id(true);

        $_SESSION['user_id']       = $usuario['id'];
        $_SESSION['user_nombre']   = $usuario['nombre'];
        $_SESSION['user_apellidos'] = $usuario['apellidos'];
        $_SESSION['user_email']    = $usuario['email'];
        $rol = trim(strtolower($usuario['nombre_rol'] ?? ''));
        $_SESSION['user_rol']      = $rol;
        $_SESSION['user_rol_id']   = (int)($usuario['id_rol'] ?? 0);
        $_SESSION['foto_perfil']   = $usuario['foto_perfil'] ?? 'foto_defecto.webp';
        $_SESSION['logged_in']     = true;

        // Recordar usuario por 1 día si marcó el checkbox
        if (isset($_POST['recordarDatos'])) {
            setcookie('recordar_email', $usuario['email'], time() + 86400, '/', '', false, true);
        } else {
            setcookie('recordar_email', '', time() - 3600, '/');
        }

        //Si el rol del usuario es voluntario, obtenemos su id_voluntario a través del modelo
        if ($rol === 'soy-voluntario' || $_SESSION['user_rol_id'] === 2) {
            $volModel = new Voluntario();
            $_SESSION['id_voluntario'] = $volModel->obtenerIdPorUsuario($usuario['id']);
        }

        // Redirigimos según el rol del usuario
        if ($rol === 'admin' || $_SESSION['user_rol_id'] === 3) {
            header('Location: ' . BASE_URL . '/app/controllers/controller_admin_dashboard.php');
        } elseif ($rol === 'soy-voluntario' || $_SESSION['user_rol_id'] === 2) {
            header('Location: ' . BASE_URL . '/app/controllers/controller_volunteer_dashboard.php');
        } elseif ($rol === 'soy-usuario' || $_SESSION['user_rol_id'] === 1) {
            header('Location: ' . BASE_URL . '/app/controllers/controller_user_dashboard.php');
        } else {
            header('Location: ' . BASE_URL . '/index.php');
        }
        exit();
        //si da error al intentarlo, recogemos el error en sessio y redirigimos al login 
    } catch (Exception $e) {
        $_SESSION['error_login'] = 'Error interno: ' . $e->getMessage();
        header('Location: ' . BASE_URL . '/app/views/auth/Login.php');
        exit();
    }
}
