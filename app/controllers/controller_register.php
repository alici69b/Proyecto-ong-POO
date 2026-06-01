<?php

require_once __DIR__ . '/../../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/UsuarioNormal.php';
require_once __DIR__ . '/../models/Voluntario.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';

// si exite algo enviado por port entonces rederigimos a la vista
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    require_once __DIR__ . '/../views/auth/Register.php';
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        $_SESSION['errores'] = ['general' => ['Error de seguridad. Inténtalo de nuevo.']];
        require_once __DIR__ . '/../views/auth/Register.php';
        exit();
    }

    $nombre   = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email    = trim($_POST['email']);
    $password = $_POST['contrasena'];
    $tipo     = $_POST['tipo'] ?? 'soy-usuario';

    // Segun el tipo que recojamos, se guardara uno u otro tipo
    if ($tipo === 'soy-voluntario') {
        $tipo_ayuda = trim($_POST['tipo_ayuda_voluntario']);
    } else {
        $tipo_ayuda = trim($_POST['tipo_ayuda_usuario']);
    }

    // Validamos los errores 
    $errores = [];

    $err_nombre    = Validaciones::validarNombre($nombre);
    $err_apellidos = Validaciones::validarNombre($apellidos);
    $err_email     = Validaciones::validarEmail($email);
    $err_password  = Validaciones::validarContrasena($password);
    $err_tipoayuda = Validaciones::validarTipoAyuda($tipo_ayuda);

    //guardamos en el array $errores el error para despues mostrarlo 
    if (!empty($err_nombre)) {
        $errores['nombre']     = $err_nombre;
    }
    if (!empty($err_apellidos)) {
        $errores['apellidos']  = $err_apellidos;
    }
    if (!empty($err_email)) {
        $errores['email']      = $err_email;
    }
    if (!empty($err_password)) {
        $errores['password']   = $err_password;
    }
    if (!empty($err_tipoayuda)) {
        $errores['tipo_ayuda'] = $err_tipoayuda;
    }

    // Si hay errores, redirigimos al registro
    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        require_once __DIR__ . '/../views/auth/Register.php';
        exit();
    }

    // Buscamo si el reset creado, le existe el email
    $modeloUsuario = new UsuarioNormal();
    if ($modeloUsuario->buscarPorEmail($email)) {
        $_SESSION['errores'] = ['email' => ['Este email ya está registrado']];
        header('Location: ../views/auth/Register.php');
        exit();
    }

    // guardamos los datos del usuario en un array para despues usarlo en las funciones del modelo
    $datos = [
        'nombre'          => $nombre,
        'apellidos'       => $apellidos,
        'email'           => $email,
        'password'        => $password,
        'tipo_ayuda'      => $tipo_ayuda,
        'disponibilidad'  => '',
        'contacto_extra'  => ''
    ];

    // Segun el tipo que sea, se le instanciara un objeto u otro 
    try {
        if ($tipo === 'soy-voluntario') {
            $modelo    = new Voluntario();
        } else {
            $modelo = new UsuarioNormal();
        }

        $resultado = $modelo->insertarUsuario($datos);

        // Segun el mensaje, ya sea de error o de exito, se mostrara en la vista
        if ($resultado) {
            $_SESSION['mensaje_exito'] = "¡Cuenta creada! Ya puedes iniciar sesión.";
            require_once __DIR__ . '/../views/auth/Login.php';
            exit();
        } else {
            $_SESSION['errores'] = ['general' => ['Error al crear la cuenta, inténtalo de nuevo']];
            require_once __DIR__ . '/../views/auth/Register.php';
            exit();
        }
        exit();
        //capto el error y lo guardo en session para despues mostralo 
    } catch (\Exception $e) {
        $_SESSION['errores'] = ['general' => ['Error interno: ' . $e->getMessage()]];
        require_once __DIR__ . '/../views/auth/Register.php';
        exit();
    }
}
