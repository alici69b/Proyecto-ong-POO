<?php
session_start();

require_once __DIR__ . '/../models/Mensaje.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';

//si existe el boton enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    //recojo los datos en un array para despues compararlos con las validaciones 
    $datos = [
        'nombre_remitente' => trim($_POST['nombre_remitente'] ?? ''),
        'email_remitente'  => trim($_POST['email_remitente'] ?? ''),
        'asunto'           => trim($_POST['asunto'] ?? ''),
        'cuerpo_mensaje'   => trim($_POST['cuerpo_mensaje'] ?? ''),
    ];

    //cuardamos en session las validaciones de contacto
    $_SESSION['errores'] = Validaciones::validarContacto($datos);

    //ssi existen errores entonces isntanciaremos la clase mensaje e insertaremos los mensajes
    if (empty($_SESSION['errores'])) {
        try {
            $mensajeModel = new Mensaje();
            $mensajeModel->insertar($datos);
            $_SESSION['exito'] = 'Mensaje enviado correctamente. Te responderemos pronto.';
        } catch (Exception $e) {
            $_SESSION['errores']['general'][] = 'Error al enviar el mensaje. Inténtalo de nuevo.';
        }
    }

    header('Location: /Proyecto-ong-POO/pages/Contact.php');
    exit();
}

include __DIR__ . '/../../pages/Contact.php';
