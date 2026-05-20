<?php
session_start();

require_once __DIR__ . '/../models/Mensaje.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';
require_once __DIR__ . '/../Helpers/Mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $datos = [
        'nombre_remitente' => trim($_POST['nombre_remitente'] ?? ''),
        'email_remitente'  => trim($_POST['email_remitente'] ?? ''),
        'asunto'           => trim($_POST['asunto'] ?? ''),
        'cuerpo_mensaje'   => trim($_POST['cuerpo_mensaje'] ?? ''),
    ];

    $_SESSION['errores'] = Validaciones::validarContacto($datos);

    if (empty($_SESSION['errores'])) {
        try {
            $mensajeModel = new Mensaje();
            $mensajeModel->insertar($datos);

            Mailer::notifyAdminContact($datos);

            $_SESSION['exito'] = 'Mensaje enviado correctamente. Te responderemos pronto.';
        } catch (Exception $e) {
            $_SESSION['errores']['general'][] = 'Error al enviar el mensaje. Inténtalo de nuevo.';
        }
    }

    header('Location: /Proyecto-ong-POO/pages/Contact.php');
    exit();
}

include __DIR__ . '/../../pages/Contact.php';
