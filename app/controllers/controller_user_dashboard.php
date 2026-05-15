<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-usuario') {
    header('Location: ../views/auth/Login.php');
    exit();
}

require_once __DIR__ . '/../config/db.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    $userId = (int) $_SESSION['user_id'];

    $stmt = $conn->prepare("
        SELECT r.*, c.nombre_categoria, e.nombre_estado,
               v.id AS v_id, u_vol.nombre AS vol_nombre, u_vol.apellidos AS vol_apellidos
        FROM reset r
        LEFT JOIN categoria_reset c ON r.id_categoria = c.id
        LEFT JOIN estado_maestro e ON r.id_estado = e.id
        LEFT JOIN voluntario v ON r.id_voluntario = v.id
        LEFT JOIN usuario u_vol ON v.id_usuario = u_vol.id
        WHERE r.id_usuario = :id
        ORDER BY r.created_at DESC
    ");
    $stmt->execute([':id' => $userId]);
    $resets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalResets = count($resets);
    $enCurso = 0;
    $logrados = 0;
    foreach ($resets as $r) {
        $est = strtolower($r['nombre_estado'] ?? '');
        if ($est === 'activo' || $est === 'pendiente') $enCurso++;
        if ($est === 'resuelto') $logrados++;
    }

    $nombreCompleto = htmlspecialchars(trim(($_SESSION['user_nombre'] ?? '') . ' ' . ($_SESSION['user_apellidos'] ?? '')));
} catch (Exception $e) {
    $resets = [];
    $totalResets = 0;
    $enCurso = 0;
    $logrados = 0;
    $nombreCompleto = htmlspecialchars(trim(($_SESSION['user_nombre'] ?? 'Usuario') . ' ' . ($_SESSION['user_apellidos'] ?? '')));
}

function iconoCategoria($cat) {
    $cat = strtolower($cat ?? '');
    if ($cat === 'estudio') {
        return '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-10 h-10 text-[#00a5cf]"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></svg>';
    }
    if ($cat === 'proyecto') {
        return '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-10 h-10 text-[#ff3b30]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>';
    }
    if ($cat === 'salud') {
        return '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-10 h-10 text-[#25a18e]"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>';
    }
    if ($cat === 'creatividad') {
        return '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-10 h-10 text-[#7ae582]"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 0-.5 1.71v2.04a.75.75 0 0 0 .75.75h14.25a.75.75 0 0 0 .75-.75v-1.04a2.25 2.25 0 0 0-.5-1.71 3 3 0 0 0-5.78-1.128M12 15.75V9m0 0V4.5m0 4.5h4.5m-4.5 0H7.5"/></svg>';
    }
    return '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-10 h-10 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>';
}

function badgeEstado($estado) {
    $e = strtolower($estado ?? '');
    if ($e === 'activo' || $e === 'en proceso') {
        return '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-[#25a18e]/10 text-[#25a18e] border border-[#25a18e]/20"><span class="w-1.5 h-1.5 rounded-full bg-[#25a18e]"></span>En proceso</span>';
    }
    if ($e === 'pendiente') {
        return '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Pendiente</span>';
    }
    if ($e === 'resuelto') {
        return '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Logrado</span>';
    }
    if ($e === 'cancelado') {
        return '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Cancelado</span>';
    }
    return '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">' . htmlspecialchars(ucfirst($estado ?? '')) . '</span>';
}

function badgeCategoria($cat) {
    $map = [
        'estudio' => 'bg-[#00a5cf]/10 text-[#00a5cf]',
        'salud' => 'bg-[#25a18e]/10 text-[#25a18e]',
        'proyecto' => 'bg-[#ff3b30]/10 text-[#ff3b30]',
        'creatividad' => 'bg-[#7ae582]/20 text-green-700',
        'otros' => 'bg-gray-100 text-gray-600',
    ];
    $clase = $map[strtolower($cat ?? '')] ?? 'bg-gray-100 text-gray-600';
    return '<span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider ' . $clase . '">' . htmlspecialchars($cat ?? '') . '</span>';
}

require_once __DIR__ . '/../views/user/dashboard.php';
