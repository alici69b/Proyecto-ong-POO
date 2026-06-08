<?php
require_once __DIR__ . "/../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../models/Mensaje.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';
require_once __DIR__ . '/../Helpers/FiltroProfanidad.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {

    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        $_SESSION['errores']['general'][] = 'Error de seguridad. Inténtalo de nuevo.';
        header('Location: ' . BASE_URL . '/pages/Contact.php');
        exit();
    }
    $datos = [
        'nombre_remitente' => FiltroProfanidad::limpiar(trim($_POST['nombre_remitente'] ?? '')),
        'email_remitente'  => trim($_POST['email_remitente'] ?? ''),
        'asunto'           => FiltroProfanidad::limpiar(trim($_POST['asunto'] ?? '')),
        'cuerpo_mensaje'   => FiltroProfanidad::limpiar(trim($_POST['cuerpo_mensaje'] ?? '')),
    ];

    $_SESSION['errores'] = Validaciones::validarContacto($datos);

    if (empty($_SESSION['errores'])) {
        try {
            $mensajeModel = new Mensaje();
            $mensajeModel->insertar($datos);

            $_SESSION['exito'] = 'Mensaje enviado correctamente. Te responderemos pronto.';
        } catch (Exception $e) {
            $_SESSION['errores']['general'][] = 'Error al enviar el mensaje. Inténtalo de nuevo.';
        }
    }

    header('Location: ' . BASE_URL . '/pages/Contact.php');
    exit();
}

include __DIR__ . '/../../pages/Contact.php';
