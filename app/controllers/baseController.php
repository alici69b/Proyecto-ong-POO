<?php
class BaseController {

    // Redirigir a una URL
    protected function redirigir(string $url): void {
        header("Location: " . $url);
        exit();
    }

    // Cargar una vista
    protected function render(string $vista, array $datos = []): void {
        extract($datos); // convierte las claves del array en variables
        require_once "vistas/{$vista}.php";
    }

    // Verificar que hay sesión iniciada
    protected function verificarSesion(): void {
        if (!isset($_SESSION['usuario'])) {
            $this->redirigir('index.php?ruta=login');
        }
    }

    // Verificar el rol del usuario
    protected function verificarRol(string $rol): void {
        if ($_SESSION['usuario']['nombre_rol'] !== $rol) {
            $this->redirigir('index.php?ruta=login');
        }
    }
}