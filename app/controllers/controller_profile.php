<?php
session_start();

//si no existe la conecion entonces debera irse al login 
if (!isset($_SESSION['logged_in'])) {
    header('Location: ../views/auth/Login.php');
    exit();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/UsuarioNormal.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';


//creamos la conexion 
$db = new Db();
$conn = $db->getConnection();


    if (!isset($_SESSION['user_id'])) {
        header('Location: ../views/auth/Login.php');
        exit();
    }
    $userId = (int) $_SESSION['user_id'];
    $mensaje_exito = $_SESSION['mensaje_perfil'] ?? null;
    $errores = $_SESSION['errores_perfil'] ?? [];
    unset($_SESSION['mensaje_perfil'], $_SESSION['errores_perfil']);

    $modelo = new UsuarioNormal();
    $usuario = $modelo->buscarPorId($userId);

    if (!$usuario) {
        header('Location: ../views/auth/Login.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errores = [];

        if (isset($_POST['actualizar_perfil'])) {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');

            $err_nombre = Validaciones::validarNombre($nombre);
            $err_apellidos = Validaciones::validarNombre($apellidos);
            if (!empty($err_nombre)) $errores['nombre'] = $err_nombre;
            if (!empty($err_apellidos)) $errores['apellidos'] = $err_apellidos;

            $foto_perfil = $usuario['foto_perfil'] ?? 'default.png';

            if (empty($errores) && isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                $errFoto = Validaciones::validarFoto($_FILES['foto_perfil']);
                if (!empty($errFoto)) {
                    $errores['foto'] = $errFoto;
                } else {
                    $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
                    $nombreFoto = 'user_' . $userId . '_' . time() . '.' . $ext;
                    $destino = __DIR__ . '/../../public/img/' . $nombreFoto;

                    if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $destino)) {
                        if ($foto_perfil !== 'default.png' && $foto_perfil !== $usuario['foto_perfil']) {
                            $oldFile = __DIR__ . '/../../public/img/' . $foto_perfil;
                            if (file_exists($oldFile)) unlink($oldFile);
                        }
                        $foto_perfil = $nombreFoto;
                    } else {
                        $errores['foto'] = ['Error al subir la imagen.'];
                    }
                }
            }

            if (empty($errores)) {
                try {
                    $modelo->actualizar($userId, $nombre, $apellidos, $foto_perfil);
                    $_SESSION['user_nombre'] = $nombre;
                    $_SESSION['user_apellidos'] = $apellidos;
                    $_SESSION['foto_perfil'] = $foto_perfil;
                    $_SESSION['mensaje_perfil'] = 'Perfil actualizado correctamente.';
                } catch (Exception $e) {
                    $errores['general'] = ['Error al actualizar: ' . $e->getMessage()];
                }
            }

            if (!empty($errores)) {
                $_SESSION['errores_perfil'] = $errores;
            }
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }

        if (isset($_POST['cambiar_password'])) {
            $password_actual = $_POST['password_actual'] ?? '';
            $nueva_password = $_POST['nueva_password'] ?? '';
            $confirmar_password = $_POST['confirmar_password'] ?? '';

            if (empty($password_actual)) {
                $errores['password_actual'] = ['La contraseña actual es obligatoria.'];
            } elseif (!password_verify($password_actual, $usuario['password'])) {
                $errores['password_actual'] = ['La contraseña actual no es correcta.'];
            }

            $errPass = Validaciones::validarPasswordConConfirmacion([
                'password_nueva' => $nueva_password, 'password_confirmar' => $confirmar_password
            ]);
            if (!empty($errPass)) {
                $errores = array_merge($errores, $errPass);
            }

            if (empty($errores)) {
                try {
                    $modelo->cambiarPassword($userId, $nueva_password);
                    $_SESSION['mensaje_perfil'] = 'Contraseña cambiada correctamente.';
                } catch (Exception $e) {
                    $errores['general'] = ['Error al cambiar la contraseña: ' . $e->getMessage()];
                }
            }

            if (!empty($errores)) {
                $_SESSION['errores_perfil'] = $errores;
            }
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }

$usuario = $modelo->buscarPorId($userId);
$fotoPerfil = $usuario['foto_perfil'] ?? 'default.png';
$nombreCompleto = htmlspecialchars(trim(($usuario['nombre'] ?? '') . ' ' . ($usuario['apellidos'] ?? '')));

require_once __DIR__ . '/../views/user/profile.php';
