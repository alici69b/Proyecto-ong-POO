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
}