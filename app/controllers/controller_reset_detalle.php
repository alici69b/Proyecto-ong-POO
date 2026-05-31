<?php
session_start();

// Controlamos acceso
if (!isset($_SESSION["logged_in"]) || $_SESSION["user_rol"] !== "soy-voluntario") {
    header("Location: ../views/auth/Login.php");
    exit();
}

// Incluimos lo necesario
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../models/Voluntario.php";
require_once __DIR__ . "/../models/Reset.php";
require_once __DIR__ . "/../models/ResetComentario.php";
require_once __DIR__ . "/../models/Historia.php";

// Instanciamos
$db               = new Database();
$conn             = $db->getConnection();
$resetModel       = new Reset($conn);
$comentarioModel  = new ResetComentario($conn);

// Datos de sesión
$id_voluntario = $_SESSION["id_voluntario"] ?? null;
$id_usuario    = $_SESSION["user_id"]       ?? null;

// Recogemos el id del reset de la URL (?id=X)
$id_reset = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

// Si no viene ID redirigimos al dashboard
if (!$id_reset || !$id_voluntario) {
    header("Location: controller_volunteer_dashboard.php");
    exit();
}

// Cargamos el reset comprobando que pertenece a este voluntario
$reset = $resetModel->obtenerPorId($id_reset, $id_voluntario);

// Si no existe o no le pertenece, volvemos al dashboard
if (!$reset) {
    header("Location: controller_volunteer_dashboard.php");
    exit();
}

// ── Acción: cambiar estado (finalizar o cancelar) ────────────────────────────
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {

    // Primero insertamos el comentario de cierre si viene relleno
    $nota = trim($_POST["nota_cierre"] ?? "");
    if ($nota !== "") {
        $comentarioModel->insertar($id_reset, null, $id_voluntario, $nota);
    }

    if ($_POST["action"] === "finalizar") {
        $ok = $resetModel->cambiarEstado($id_reset, $id_voluntario, 3); // 3 = resuelto

        if ($ok) {
            $historiaModel = new Historia();

            // Recogemos los datos que ha rellenado el voluntario en el formulario
            $titulo      = trim($_POST['historia_titulo']      ?? '');
            $descripcion = trim($_POST['historia_descripcion'] ?? '');
            $antes       = trim($_POST['historia_antes']       ?? '');
            $despues     = trim($_POST['historia_despues']     ?? '');

            // Si el voluntario ha rellenado los campos usamos sus datos
            // Si no (por si acaso), usamos el método automático como antes
            if ($titulo !== '' && $descripcion !== '' && $antes !== '' && $despues !== '') {
                $historiaModel->crearDesdeResetConDatos($id_reset, [
                    'titulo'              => $titulo,
                    'descripcion'         => $descripcion,
                    'descripcion_antes'   => $antes,
                    'descripcion_despues' => $despues,
                ]);
            } else {
                $historiaModel->crearAutomaticaDesdeReset($id_reset);
            }
        }

        $_SESSION["flash"] = $ok
            ? ["tipo" => "success", "msg" => "Reset marcado como resuelto. La historia quedará pendiente de revisión por el administrador."]
            : ["tipo" => "error",   "msg" => "No se pudo finalizar. Comprueba que el reset está activo."];
    } elseif ($_POST["action"] === "cancelar") {
        $ok = $resetModel->cambiarEstado($id_reset, $id_voluntario, 4); // 4 = cancelado
        $_SESSION["flash"] = $ok
            ? ["tipo" => "success", "msg" => "Reset cancelado correctamente."]
            : ["tipo" => "error",   "msg" => "No se pudo cancelar."];

        // ── Acción: añadir comentario ────────────────────────────────────────────
    } elseif ($_POST["action"] === "comentar") {
        $texto = trim($_POST["texto"] ?? "");
        if ($texto !== "") {
            $comentarioModel->insertar($id_reset, null, $id_voluntario, $texto);
            $_SESSION["flash"] = ["tipo" => "success", "msg" => "Comentario añadido."];
        } else {
            $_SESSION["flash"] = ["tipo" => "error", "msg" => "El comentario no puede estar vacío."];
        }
    } elseif ($_POST["action"] === "reactivar") {
        $ok = $resetModel->reactivar($id_reset, $id_voluntario);
        $_SESSION["flash"] = $ok
            ? ["tipo" => "success", "msg" => "Reset reactivado correctamente."]
            : ["tipo" => "error",   "msg" => "No se pudo reactivar."];
    }

    // Redirigimos a la misma página para evitar reenvío del formulario al refrescar
    header("Location: controller_reset_detalle.php?id=$id_reset");
    exit();
}

// Recargamos el reset por si cambió el estado tras el POST
$reset       = $resetModel->obtenerPorId($id_reset, $id_voluntario);
$comentarios = $comentarioModel->obtenerPorReset($id_reset);
$resetModel->actualizarVisitaVoluntario($id_reset); // Marcamos que el voluntario ha visto este reset (quita la notificación)

$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);

require_once __DIR__ . "/../views/volunteer/detalle.php";
?>