<?php

class Validaciones
{
    public static function validarNombre(string $nombre): array
    {
        $errores = [];
        if (empty($nombre)) {
            $errores[] = "El nombre es obligatorio";
        } elseif (strlen(trim($nombre)) < 2) {
            $errores[] = "El nombre debe tener al menos 2 caracteres";
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

    public static function validarCantidad(mixed $cantidad): array
    {
        $errores = [];
        $cantidad = floatval($cantidad);
        if ($cantidad < 1 || $cantidad > 500) {
            $errores[] = "La cantidad debe estar entre 1€ y 500€";
        }
        return $errores;
    }

    public static function validarDonacion(array $datos): array
    {
        $errores = [];

        $errNombre = self::validarNombre($datos['nombre'] ?? '');
        if (!empty($errNombre)) {
            $errores['nombre'] = $errNombre;
        }

        $errEmail = self::validarEmail($datos['email'] ?? '');
        if (!empty($errEmail)) {
            $errores['email'] = $errEmail;
        }

        $errCantidad = self::validarCantidad($datos['cantidad'] ?? 0);
        if (!empty($errCantidad)) {
            $errores['cantidad'] = $errCantidad;
        }

        return $errores;
    }

    public static function validarContacto(array $datos): array
    {
        $errores = [];

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

    public static function validarLogin(array $datos): array
    {
        $errores = [];

        $errEmail = self::validarEmail($datos['email'] ?? '');
        if (!empty($errEmail)) {
            $errores['email'] = $errEmail;
        }

        $errPass = self::validarContrasena($datos['password'] ?? '');
        if (!empty($errPass)) {
            $errores['password'] = $errPass;
        }

        return $errores;
    }

    public static function validarConfirmacionPassword(string $password, string $confirmacion): array
    {
        $errores = [];
        if ($password !== $confirmacion) {
            $errores[] = "Las contraseñas no coinciden";
        }
        return $errores;
    }

    public static function validarPasswordConConfirmacion(array $datos, string $campoPassword = 'password_nueva', string $campoConfirmar = 'password_confirmar'): array
    {
        $errores = [];

        $errPass = self::validarContrasena($datos[$campoPassword] ?? '');
        if (!empty($errPass)) {
            $errores[$campoPassword] = $errPass;
        }

        $errConfirm = self::validarConfirmacionPassword(
            $datos[$campoPassword] ?? '',
            $datos[$campoConfirmar] ?? ''
        );
        if (!empty($errConfirm)) {
            $errores[$campoConfirmar] = $errConfirm;
        }

        return $errores;
    }

    public static function validarDatosPersonales(array $datos): array
    {
        $errores = [];

        $errNombre = self::validarNombre($datos['nombre'] ?? '');
        if (!empty($errNombre)) {
            $errores['nombre'] = $errNombre;
        }

        $errApellidos = self::validarNombre($datos['apellidos'] ?? '');
        if (!empty($errApellidos)) {
            $errores['apellidos'] = $errApellidos;
        }

        if (isset($datos['tipo_ayuda'])) {
            $errTipo = self::validarTipoAyuda($datos['tipo_ayuda']);
            if (!empty($errTipo)) {
                $errores['tipo_ayuda'] = $errTipo;
            }
        }

        return $errores;
    }

    public static function validarFoto(array $archivo, array $opciones = []): array
    {
        $errores = [];
        $permitidas = $opciones['extensiones'] ?? ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $maxTamano = $opciones['max_tamano'] ?? 2 * 1024 * 1024;

        if (empty($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) {
            $errores[] = "Error al subir el archivo";
            return $errores;
        }

        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $permitidas)) {
            $errores[] = "Formato no permitido. Usa: " . implode(', ', $permitidas);
        }

        if ($archivo['size'] > $maxTamano) {
            $maxMB = $maxTamano / (1024 * 1024);
            $errores[] = "La imagen no puede superar los {$maxMB}MB";
        }

        return $errores;
    }

    public static function validarUsuario(array $datos): array
    {
        $errores = [];

        $errNombre = self::validarNombre($datos['nombre'] ?? '');
        if (!empty($errNombre)) {
            $errores['nombre'] = $errNombre;
        }

        $errApellidos = self::validarNombre($datos['apellidos'] ?? '');
        if (!empty($errApellidos)) {
            $errores['apellidos'] = $errApellidos;
        }

        $errEmail = self::validarEmail($datos['email'] ?? '');
        if (!empty($errEmail)) {
            $errores['email'] = $errEmail;
        }

        if (isset($datos['password']) && $datos['password'] !== '') {
            $errPass = self::validarContrasena($datos['password']);
            if (!empty($errPass)) {
                $errores['password'] = $errPass;
            }
        }

        return $errores;
    }

    public static function validarHistoria(array $datos): array
    {
        $errores = [];

        $errTitulo = self::validarNombre($datos['titulo'] ?? '');
        if (!empty($errTitulo)) {
            $errores['titulo'] = $errTitulo;
        }

        $errContenido = self::validarMensaje($datos['contenido'] ?? '');
        if (!empty($errContenido)) {
            $errores['contenido'] = $errContenido;
        }

        return $errores;
    }
}
