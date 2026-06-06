<?php
require_once __DIR__ . "/../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../views/auth/Reset_password.php';
