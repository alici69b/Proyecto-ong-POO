<?php
require_once __DIR__ . "/../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$modo_simulado = isset($_SESSION['modo_simulado']) && $_SESSION['modo_simulado'];

//Controlamos que el usuario esté logueado y el rol sea de voluntario, sino lo redirigimos al login
if (!isset($_SESSION["logged_in"]) || $_SESSION["user_rol"] !== "soy-voluntario") {
    header("Location: ../views/auth/Login.php");
    exit();
}

//Incluimos los modelos necesarios para esta vista
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../models/Voluntario.php";
require_once __DIR__ . "/../models/Reset.php";

//Instanciamos los modelos
$db = new Database();
$conn = $db->getConnection();
$resetModel = new Reset($conn);

//Obtenemos el id_voluntario de la sesión
$id_voluntario = $_SESSION["id_voluntario"] ?? null;

//Si se pulsa el boton de asignarse un reset
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "asignar") {

    if (!validarTokenCSRF($_POST['csrf_token'] ?? '')) {
        $_SESSION["flash"] = ["tipo" => "error", "msg" => "Error de seguridad."];
        header("Location: controller_volunteer_dashboard.php");
        exit();
    }

    $id_reset = filter_input(INPUT_POST, "id_reset", FILTER_VALIDATE_INT);

    //Comprobamos que tenemos los dos datos necesarios para la asignacion
    if ($id_reset && $id_voluntario) {
        $ok = $resetModel->asignarVoluntario($id_reset, $id_voluntario);
        $_SESSION["flash"] = $ok
            ? ["tipo" => "success", "msg" => "¡Reset asignado correctamente! Ya aparece en tus actividades."]
            : ["tipo" => "error", "msg" => "No se pudo asignar. Es posible que otro voluntario se haya adelantado."];
    }

    //Redirigimos para evitar duplicados al refrescar
    /* header("Location: controller_volunteer_dashboard.php");
    exit(); */
}

//Obtenemos los resets disponibles para mostrar en el dashborad + filtramos si se pide
$id_categoria = filter_input(INPUT_GET, "categoria", FILTER_VALIDATE_INT) ?: null; //Si no se pasa la categoria está sera null y no se aplicara filtro
$categorias = $conn->query("SELECT * FROM categoria_reset ORDER BY id")->fetchAll(); //Obtenemos las categorias para mostrar en el filtro
$disponibles = $resetModel->obtenerDisponibles($id_categoria);
$mis_resets = $id_voluntario ? $resetModel->obtenerMisResets($id_voluntario) : [];
$stats = $id_voluntario ? $resetModel->obtenerStatsVoluntario($id_voluntario) : ["total" => 0, "en_progreso" => 0, "completados" => 0];

// Calculamos las notificaciones de cada reset
$hay_notificacion = false;

foreach ($mis_resets as &$r) {
    $r['tiene_notificacion'] = $resetModel->tieneNotificacionVoluntario($r['id']);
    if ($r['tiene_notificacion']) {
        $hay_notificacion = true;
    }
}
unset($r);

$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);

//Incluimos la vista del dashboard voluntario
require_once __DIR__ . "/../views/volunteer/dashboard.php";
