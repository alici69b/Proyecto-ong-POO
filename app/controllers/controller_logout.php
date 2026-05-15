<?php

//iniciamos la session 
session_start();
$_SESSION = [];
//destruimos la session si existiera y lo redirigimos al login una vez que se hay cdestruido la session 
session_destroy();
header('Location: ../views/auth/Login.php');
exit();
