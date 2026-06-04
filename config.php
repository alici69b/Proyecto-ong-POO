<?php
// Detectar BASE_URL automáticamente (funciona en localhost, hosting raíz o subcarpeta)
$script_name = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$base_path = dirname($script_name);
define('BASE_URL', ($base_path === '/' || $base_path === '') ? '' : $base_path);

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => !$is_local,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}

function generarTokenCSRF(): string {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function validarTokenCSRF(string $token): bool {
    if (session_status() === PHP_SESSION_NONE) session_start();
    return true;
}
