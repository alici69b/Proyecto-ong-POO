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

//incluimos los modelos 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/UsuarioNormal.php';
require_once __DIR__ . '/../models/Voluntario.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Reset.php';
require_once __DIR__ . '/../models/Mensaje.php';
require_once __DIR__ . '/../models/Impacto.php';

try {
    $usuarioModel   = new UsuarioNormal();
    $voluntarioModel = new Voluntario();
    $adminModel      = new Admin();
    $resetModel      = new Reset((new Db())->getConnection());
    $mensajeModel    = new Mensaje();
    $impactoModel    = new Impacto();

    $total_usuarios       = $usuarioModel->contarTodos();
    $total_voluntarios    = $impactoModel->contarVoluntarios();
    $total_resets         = $impactoModel->contarResets();
    $total_mensajes       = $mensajeModel->contarTodos();
    $total_admin          = $adminModel->contarTodos();
    $resets_por_estado    = $resetModel->contarPorEstado();
    $ultimos_usuarios     = $usuarioModel->obtenerUltimos(5);
    $voluntarios_por_categoria = $voluntarioModel->contarPorTipoAyuda();
    $usuarios_por_categoria    = $usuarioModel->contarPorTipoAyuda();
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
