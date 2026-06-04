<?php

require_once __DIR__ . "/../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$_SESSION = [];

$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000,
    $params['path'], $params['domain'],
    $params['secure'], $params['httponly']
);

session_destroy();
header('Location: ' . BASE_URL . '/app/views/auth/Login.php');
exit();
