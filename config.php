<?php
$is_local = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1']);
define('BASE_URL', $is_local ? '/Proyecto-ong-POO' : '');

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
    return !empty($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $token);
}
