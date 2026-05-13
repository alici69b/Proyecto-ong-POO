<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: ../views/auth/Login.php');
exit();
