<?php
session_start();

//importamos los modelos que vamos a utilizar
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/UsuarioNormal.php';

// si no  exite el metodo post lo redirigimos al login 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/auth/Login.php');
    exit();
}

//si existe el metodo post entonces recogeremos los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['pass'];

    //si esta vacio entonces guardaremos en session el error y lo mostraremos por la vista
    if (empty($email) || empty($password)) {
        $_SESSION['error_login'] = 'Todos los campos son obligatorios.';
        header('Location: ../views/auth/Login.php');
        exit();
    }

    //intentamos cmprobar si el email esta en la bbdd
    try {
        $modelo  = new UsuarioNormal();
        $usuario = $modelo->buscarPorEmail($email);

        //si no esta mandaremos un error com oque el email no esta registrado
        if (!$usuario) {
            $_SESSION['error_login'] = 'El email no está registrado.';
            header('Location: ../views/auth/Login.php');
            exit();
        }

        //si la contraseña no es la misma que la que esta guardada en la bbdd entonces mostraremos un error
        if (!password_verify($password, $usuario['password'])) {
            $_SESSION['error_login'] = 'Contraseña incorrecta.';
            header('Location: ../views/auth/Login.php');
            exit();
        }

        //guardamos en session todos los datos del usuario
        $_SESSION['user_id']       = $usuario['id'];
        $_SESSION['user_nombre']   = $usuario['nombre'];
        $_SESSION['user_apellidos'] = $usuario['apellidos'];
        $_SESSION['user_email']    = $usuario['email'];
        $_SESSION['user_rol']      = $usuario['nombre_rol'];
        $_SESSION['foto_perfil']   = $usuario['foto_perfil'] ?? 'default.png';
        $_SESSION['logged_in']     = true;

        //comrpobamos que el rol esta en minusculas y los guardamos en una variable
        $rol = strtolower($usuario['nombre_rol']);

        //si el rol es admin, te  redirije a el dashboard del admin 
        if ($rol === 'admin') {
            header('Location: ../views/admin/dashboard.php');
            //si el rol es voluntario, te  redirije a el dashboard del voluntario
        } elseif ($rol === 'soy-voluntario') {
            header('Location: ../views/volunteer/dashboard.php');
            //si el rol es usuario, te  redirije a el dashboard del usuario reset
        } elseif ($rol === 'soy-usuario') {
            header('Location: ../controllers/controller_user_dashboard.php');
            //si no te llevara a la pagina principal
        } else {
            header('Location: /Proyecto-ong-POO/index.php');
        }
        exit();
        //si da error al intentarlo, recogemos el error en sessio y redirigimos al login 
    } catch (Exception $e) {
        $_SESSION['error_login'] = 'Error interno: ' . $e->getMessage();
        header('Location: ../views/auth/Login.php');
        exit();
    }
}
