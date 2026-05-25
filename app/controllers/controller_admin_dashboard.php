<?php
session_start();

//si no existe la session del logueo, entonces te redirige al login 
if (!isset($_SESSION['logged_in'])) {
    header('Location: ../views/auth/Login.php');
    exit();
}

//si el usuario no es admin entonces redirigimos al login 
if ($_SESSION['user_rol'] !== 'admin') {
    header('Location: ../views/auth/Login.php');
    exit();
}

//incluimos la conexion 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';

try {
    //intentamos crear la bbdd
    $db = new Database();
    $conn = $db->getConnection();

    //primera consulta para mostrar en la vista, contamos todos los usurios
    $sql1 = "SELECT COUNT(*) FROM usuario";
    $resultado1 = $conn->query($sql1);
    $total_usuarios = $resultado1->fetchColumn();

    // segunda consulta, para mostrar en la vista, contamos todos los voluntarios
    $sql2 = "SELECT COUNT(*) FROM voluntario";
    $resultado2 = $conn->query($sql2);
    $total_voluntarios = $resultado2->fetchColumn();

    // tercera consulta, para mostrar en la vista, contamos todos los reset
    $sql3 = "SELECT COUNT(*) FROM reset";
    $resultado3 = $conn->query($sql3);
    $total_resets = $resultado3->fetchColumn();

    // cuarta consulta, para mostrar en la vista, contamos todos los mensajes
    $sql4 = "SELECT COUNT(*) FROM mensaje";
    $resultado4 = $conn->query($sql4);
    $total_mensajes = $resultado4->fetchColumn();

    // quinta consulta, para mostrar en la vista, contamos todos los admin   
    $sql5 = "SELECT COUNT(*) FROM admin";
    $resultado5 = $conn->query($sql5);
    $total_admin = $resultado5->fetchColumn();

    // sexta consulta, para mostrar en la vista, mostramos el nombre del estado y el total de la tabla reset  
    $sql6 = "SELECT e.nombre_estado, COUNT(r.id) as total
             FROM estado_maestro e
             LEFT JOIN reset r ON r.id_estado = e.id
             GROUP BY e.id, e.nombre_estado";
    $resultado6 = $conn->query($sql6);
    $resets_por_estado = $resultado6->fetchAll();

    // septima consulta, para mostrar en la vista, mostramos el nombre del estado y el total de la tabla reset 
    $sql7 = "SELECT u.id, u.nombre, u.email, u.foto_perfil, u.created_at, r.nombre_rol
             FROM usuario u
             JOIN roles r ON u.id_rol = r.id
             ORDER BY u.created_at DESC
             LIMIT 5";
    $resultado7 = $conn->query($sql7);
    $ultimos_usuarios = $resultado7->fetchAll();

    // octaba consulta, para mostrar en la vista, voluntarios agrupados por tipo_ayuda
    $sql8 = "SELECT tipo_ayuda, COUNT(*) as total FROM voluntario GROUP BY tipo_ayuda";
    $resultado8 = $conn->query($sql8);
    $voluntarios_por_categoria = $resultado8->fetchAll();

    // novena consulta, para mostrar en la vista, usuarios normales agrupados por tipo_ayuda
    $sql9 = "SELECT un.tipo_ayuda, COUNT(*) as total FROM usuario_normal un JOIN usuario u ON u.id = un.id_usuario WHERE u.id_rol = 1 GROUP BY un.tipo_ayuda";
    $resultado9 = $conn->query($sql9);
    $usuarios_por_categoria = $resultado9->fetchAll();
//si da error, deberia de poner todos a cero 
} catch (Exception $e) {
    $total_usuarios = 0;
    $total_voluntarios = 0;
    $total_resets = 0;
    $total_mensajes = 0;
    $total_admin = 0;
    $resets_por_estado = [];
    $ultimos_usuarios = [];
    $voluntarios_por_categoria = [];
    $usuarios_por_categoria = [];
}

$nuevos = 0;
$pendientes = 0;
$completados = 0;

//lo que guardamos en la consulta seis, tendremso que compararlo con los estados que tenemos 
foreach ($resets_por_estado as $fila) {
    $estado = strtolower($fila['nombre_estado']);
    $total = $fila['total'];

    if (strpos($estado, 'nuevo') !== false) {
        $nuevos = $total;
    }

    if (strpos($estado, 'progreso') !== false) {
        $pendientes = $total;
    }

    if (strpos($estado, 'pendiente') !== false) {
        $pendientes = $total;
    }

    if (strpos($estado, 'completado') !== false) {
        $completados = $total;
    }

    if (strpos($estado, 'exito') !== false) {
        $completados = $total;
    }
}

$map_vol_labels = [
    'estudio'     => 'Mentoría en estudios',
    'salud'       => 'Coaching de salud',
    'creatividad' => 'Guía creativa',
    'proyecto'    => 'Asesoría de emprendimiento',
    'otros'       => 'Otro'
];

$map_usu_labels = [
    'estudio'     => 'Estudios',
    'salud'       => 'Salud',
    'creatividad' => 'Creatividad',
    'proyecto'    => 'Proyecto',
    'otros'       => 'Otros'
];

$cat_vol = [];
foreach ($voluntarios_por_categoria as $v) {
    $label = $map_vol_labels[$v['tipo_ayuda']] ?? ucfirst($v['tipo_ayuda']);
    $cat_vol[$label] = (int)$v['total'];
}

$cat_usu = [];
foreach ($usuarios_por_categoria as $u) {
    $label = $map_usu_labels[$u['tipo_ayuda']] ?? ucfirst($u['tipo_ayuda']);
    $cat_usu[$label] = (int)$u['total'];
}

$chart_vol_labels = json_encode(array_keys($cat_vol));
$chart_vol_data = json_encode(array_values($cat_vol));
$chart_usu_labels = json_encode(array_keys($cat_usu));
$chart_usu_data = json_encode(array_values($cat_usu));

include __DIR__ . '/../views/admin/dashboard.php';
