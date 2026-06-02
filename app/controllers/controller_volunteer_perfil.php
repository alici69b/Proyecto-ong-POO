<?php
//Inicializamos sesión para manejar autenticación y mensajes flash
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Comprobamos que el usuario haya iniciado sesión y sea voluntario
if (!isset($_SESSION["logged_in"]) || $_SESSION["user_rol"] !== "soy-voluntario") {
    header("Location: ../views/auth/Login.php");
    exit();
}

//Cargamos archivos necesarios
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../models/Voluntario.php";

//Conexión y datos básicos del usuario
$db = new Db();
$conn = $db->getConnection();
$voluntario = new Voluntario();
$id_usuario = $_SESSION["user_id"];

//PROCESAR FORMULARIOS DEL PERFIL
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {

    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        $_SESSION["flash"] = ["tipo" => "error", "msg" => "Error de seguridad. Inténtalo de nuevo."];
        header("Location: /Proyecto-ong-POO/app/controllers/controller_volunteer_perfil.php");
        exit();
    }

    //ACTUALIZAR DATOS PERSONALES
    if ($_POST["action"] === "actualizar_datos") {

        // Recogemos y limpiamos datos del formulario
        $nombre = trim($_POST["nombre"] ?? "");
        $apellidos = trim($_POST["apellidos"] ?? "");
        $tipo_ayuda = trim($_POST["tipo_ayuda"] ?? "");
        $disponibilidad = trim($_POST["disponibilidad"] ?? "");

        //Validación básica
        if (empty($nombre) || empty($apellidos)) {

            $_SESSION["flash"] = [
                "tipo" => "error",
                "msg" => "Nombre y apellidos son obligatorios."
            ];
        } else {

            //Guardamos cambios en la base de datos
            $voluntario->actualizarDatos($id_usuario, [
                "nombre" => $nombre,
                "apellidos" => $apellidos,
                "tipo_ayuda" => $tipo_ayuda,
                "disponibilidad" => $disponibilidad
            ]);

            //Actualizamos también los datos de sesión
            $_SESSION["user_nombre"] = $nombre;
            $_SESSION["user_apellidos"] = $apellidos;

            $_SESSION["flash"] = [
                "tipo" => "success",
                "msg" => "Datos actualizados correctamente."
            ];
        }

    //ACTUALIZAR FOTO DE PERFIL
    } elseif ($_POST["action"] === "actualizar_foto") {

        //Comprobamos que se haya subido una imagen
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {

            //Sacamos extensión de la imagen
            $ext = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

            //Extensiones permitidas
            $permitidas = ["jpg", "jpeg", "png", "webp"];

            //Validamos formato
            if (!in_array($ext, $permitidas)) {

                $_SESSION["flash"] = [
                    "tipo" => "error",
                    "msg" => "Solo se permiten imágenes JPG, JPEG, PNG o WEBP."
                ];

                //Limitamos tamaño máximo a 2MB
            } elseif ($_FILES["foto"]["size"] > 2 * 1024 * 1024) {

                $_SESSION["flash"] = [
                    "tipo" => "error",
                    "msg" => "La imagen no puede superar 2MB."
                ];
            } else {

                //Generamos nombre único para evitar conflictos
                $nombre_archivo = "user_" . $id_usuario . "_" . time() . "." . $ext;

                // Ruta donde se guardará la imagen
                $ruta_destino = __DIR__ . "/../../public/img/" . $nombre_archivo;

                //Movemos la imagen a la carpeta definitiva
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta_destino)) {

                    // Guardamos nombre de imagen en BD
                    $voluntario->actualizarFoto($id_usuario, $nombre_archivo);

                    // Actualizamos la sesión
                    $_SESSION["foto_perfil"] = $nombre_archivo;

                    $_SESSION["flash"] = [
                        "tipo" => "success",
                        "msg" => "Foto actualizada correctamente."
                    ];
                } else {

                    $_SESSION["flash"] = [
                        "tipo" => "error",
                        "msg" => "No se pudo guardar la imagen."
                    ];
                }
            }
        } else {

            $_SESSION["flash"] = [
                "tipo" => "error",
                "msg" => "No se ha recibido ninguna imagen."
            ];
        }

    //CAMBIAR CONTRASEÑA
    } elseif ($_POST["action"] === "cambiar_password") {

        //Recogemos contraseñas
        $actual = $_POST["password_actual"] ?? "";
        $nueva = $_POST["password_nueva"] ?? "";
        $repetir = $_POST["password_repetir"] ?? "";

        //Comprobaciones básicas
        if (empty($actual) || empty($nueva) || empty($repetir)) {

            $_SESSION["flash"] = [
                "tipo" => "error",
                "msg" => "Todos los campos de contraseña son obligatorios."
            ];
        } elseif (strlen($nueva) < 6) {

            $_SESSION["flash"] = [
                "tipo" => "error",
                "msg" => "La nueva contraseña debe tener al menos 6 caracteres."
            ];
        } elseif ($nueva !== $repetir) {

            $_SESSION["flash"] = [
                "tipo" => "error",
                "msg" => "Las contraseñas nuevas no coinciden."
            ];
        } else {

            //Intentamos cambiar la contraseña y capturamos el resultado
            $resultado = $voluntario->cambiarPassword($id_usuario, $nueva);

            if ($resultado === true) {

                $_SESSION["flash"] = [
                    "tipo" => "success",
                    "msg" => "Contraseña cambiada correctamente."
                ];
            } else {

                $_SESSION["flash"] = [
                    "tipo" => "error",
                    "msg" => $resultado
                ];
            }
        }
    }

    //Redirigimos para evitar reenvío del formulario
    header("Location: /Proyecto-ong-POO/app/controllers/controller_volunteer_perfil.php");
    exit();
}

//CARGAMOS DATOS PARA MOSTRAR EN EL PERFIL
//Obtenemos datos actuales del usuario
$perfil = $voluntario->obtenerPerfil($id_usuario);

//Recuperamos mensaje flash si existe
$flash = $_SESSION["flash"] ?? null;

//Lo borramos después de mostrarlo
unset($_SESSION["flash"]);

//Cargamos la vista
require_once __DIR__ . "/../views/volunteer/perfil.php";
?>