<?php
session_start();

require_once '../models/Usuario.php';
require_once '../models/Reset.php';
require_once '../models/Voluntario.php';
require_once '../models/Validaciones.php';

//si no hayun envio por post entonces redirigimos a la vista del registro
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/auth/registro.php');
    exit();
}

// recogemos el formulario
$nombre   = trim($_POST['nombre']);
$email    = trim($_POST['email']);
$password = $_POST['contrasena'];
$tipo     = $_POST['tipo'] ?? 'soy-usuario';

// segun el tipo de ayuda, lo guardaremos en una variable
if ($tipo === 'soy-voluntario') {
    $tipo_ayuda = trim($_POST['tipo_ayuda_voluntario']);
} else {
    $tipo_ayuda = trim($_POST['tipo_ayuda_usuario']);
}

// validamos los nombres, el email, la contraseña, y el tipo de ayuda
$errores = [];

$errores_nombre = Validaciones::validarNombre($nombre);
$errores_email = Validaciones::validarEmail($email);
$errores_password = Validaciones::validarContrasena($password);
$errores_tipoayuda = Validaciones::validarTipoAyuda($tipo_ayuda);


if (!empty($errores_nombre)) {
    $errores['nombre'] = $errores_nombre;
}
if (!empty($errores_email)) {
    $errores['email']      = $errores_email;
}
if (!empty($errores_password)) {
    $errores['password']   = $errores_password;
}
if (!empty($errores_tipoayuda)) {
    $errores['tipo_ayuda'] = $errores_tipoayuda;
}

// si hay erroresp ues rederigimos de nuevo
if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    header('Location: ../views/auth/registro.php');
    exit();
}

// comprobamos que el email no exista  si existe los redirijimos al login
$reset = new Reset(); 
if ($reset->buscarPorEmail($email)) {
    $_SESSION['errores'] = ['email' => ['Este email ya está registrado']];
    header('Location: ../views/auth/Login.php');
    exit();
}

// Guardamos los datos en un array para poder insertarlos dentro de la bbddd
$datos = [
    'nombre'     => $nombre,
    'apellidos'  => '',
    'email'      => $email,
    'password'   => $password,
    'tipo_ayuda' => $tipo_ayuda
];

// instanciamos el objeto segun el tipo de usuarios que sea
if ($tipo === 'soy-voluntario') {
    $datos['disponibilidad'] = '';
    $datos['contacto_extra'] = '';
    $modelo    = new Voluntario();
} else {
    $modelo = new Reset(); 
}

$resultado = $modelo->insertarUsuario($datos);

// segun el resultado, era enviado al login o al registro de nuevo
if ($resultado) {
    $_SESSION['mensaje_exito'] = "¡Cuenta creada! Ya puedes iniciar sesión.";
    header('Location: ../views/auth/login.php');
} else {
    $_SESSION['errores'] = ['general' => ['Error al crear la cuenta, inténtalo de nuevo']];
    header('Location: ../views/auth/registro.php');
}
exit();
