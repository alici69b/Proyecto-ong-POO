<?php
$is_local = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1']);
define('BASE_URL', $is_local ? '/Proyecto-ong-POO' : '');
