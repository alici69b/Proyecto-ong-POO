<?php

class Validaciones
{
    public static function validarNombre(string $nombre): array
    {
        $errores = [];
        if (empty($nombre)) {
            $errores[] = "El nombre es obligatorio";
        }
        return $errores;
    }

    public static function validarEmail(string $email): array
    {
        $errores = [];
        if (empty($email)) {
            $errores[] = "El email es obligatorio";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El email no es válido";
        }
        return $errores;
    }

    public static function validarContrasena(string $password): array
    {
        $errores = [];
        if (empty($password)) {
            $errores[] = "La contraseña es obligatoria";
        } elseif (strlen($password) < 8) {
            $errores[] = "Mínimo 8 caracteres";
        }
        return $errores;
    }

    public static function validarTipoAyuda(string $tipo_ayuda): array
    {
        $errores = [];
        if (empty($tipo_ayuda)) {
            $errores[] = "Selecciona una categoría";
        }
        return $errores;
    }

    public static function validarAsunto(string $asunto): array
    {
        $errores = [];
        if (empty($asunto)) {
            $errores[] = "El asunto es obligatorio.";
        }
        return $errores;
    }

    public static function validarMensaje(string $cuerpo_mensaje): array
    {
        $errores = [];
        if (empty($cuerpo_mensaje)) {
            $errores[] = "El mensaje no puede estar vacío.";
        }
        return $errores;
    }

    //funcion para validar la pagina de contacto
    public static function validarContacto(array $datos): array
    {
        $errores = [];

        //cuando hablamos del slt:: es una calse que no necesita instanciarse
        $errNombre = self::validarNombre($datos['nombre_remitente'] ?? '');
        if (!empty($errNombre)) {
            $errores['nombre_remitente'] = $errNombre;
        }

        $errEmail = self::validarEmail($datos['email_remitente'] ?? '');
        if (!empty($errEmail)) {
            $errores['email_remitente'] = $errEmail;
        }

        $errAsunto = self::validarAsunto($datos['asunto'] ?? '');
        if (!empty($errAsunto)) {
            $errores['asunto'] = $errAsunto;
        }

        $errMensaje = self::validarMensaje($datos['cuerpo_mensaje'] ?? '');
        if (!empty($errMensaje)) {
            $errores['cuerpo_mensaje'] = $errMensaje;
        }

        return $errores;
    }
}