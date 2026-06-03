<?php
require_once __DIR__ . '/../../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: ' . BASE_URL . '/Login');
    exit();
}

if ($_SESSION['user_rol'] !== 'admin') {
    header('Location: ' . BASE_URL . '/Inicio');
    exit();
}

//incluimos la conexion 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';

try {
    //intentamos crear la bbdd
    $db = new Db();
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

$chart_labels = [];
$chart_data = [];
$chart_bg_colors = [];
$chart_border_colors = [];

$color_map = [
    'pendiente' => ['bg' => 'rgba(255, 159, 10, 0.3)',  'border' => '#ff9f0a'],
    'activo'    => ['bg' => 'rgba(0, 165, 207, 0.3)',   'border' => '#00a5cf'],
    'resuelto'  => ['bg' => 'rgba(37, 161, 142, 0.3)',  'border' => '#25a18e'],
    'cancelado' => ['bg' => 'rgba(239, 68, 68, 0.3)',   'border' => '#ef4444'],
];

$fallback_color = ['bg' => 'rgba(148, 163, 184, 0.3)', 'border' => '#94a3b8'];

if (!empty($resets_por_estado)) {
    foreach ($resets_por_estado as $fila) {
        $chart_labels[] = $fila['nombre_estado'];
        $chart_data[] = (int)$fila['total'];
        $c = $color_map[$fila['nombre_estado']] ?? $fallback_color;
        $chart_bg_colors[] = $c['bg'];
        $chart_border_colors[] = $c['border'];
    }
} else {
    $chart_labels = ['pendiente', 'activo', 'resuelto'];
    $chart_data = [0, 0, 0];
    $chart_bg_colors = ['rgba(255, 159, 10, 0.3)', 'rgba(0, 165, 207, 0.3)', 'rgba(37, 161, 142, 0.3)'];
    $chart_border_colors = ['#ff9f0a', '#00a5cf', '#25a18e'];
}

$chart_labels_json = json_encode($chart_labels);
$chart_data_json = json_encode($chart_data);
$chart_bg_colors_json = json_encode($chart_bg_colors);
$chart_border_colors_json = json_encode($chart_border_colors);

$nuevos = 0;
$pendientes = 0;
$completados = 0;
$cancelados = 0;

foreach ($resets_por_estado as $fila) {
    switch ($fila['nombre_estado']) {
        case 'pendiente':
            $nuevos = (int)$fila['total'];
            break;
        case 'activo':
            $pendientes = (int)$fila['total'];
            break;
        case 'resuelto':
            $completados = (int)$fila['total'];
            break;
        case 'cancelado':
            $cancelados = (int)$fila['total'];
            break;
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
