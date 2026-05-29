<?php require_once __DIR__ . "/../../../config.php"; ?>
<!-- <?php
// if (!isset($resets)) {
//     header('Location: ../../controllers/controller_user_dashboard.php');
//     exit();
// }

// function iconoCategoria($cat) {
//     $cat = strtolower($cat ?? '');
//     if ($cat === 'estudio') {
//         return '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-10 h-10 text-[#00a5cf]"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></svg>';
//     }
//     if ($cat === 'proyecto') {
//         return '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-10 h-10 text-[#ff3b30]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>';
//     }
//     if ($cat === 'salud') {
//         return '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-10 h-10 text-[#25a18e]"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>';
//     }
//     if ($cat === 'creatividad') {
//         return '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-10 h-10 text-[#7ae582]"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 0-.5 1.71v2.04a.75.75 0 0 0 .75.75h14.25a.75.75 0 0 0 .75-.75v-1.04a2.25 2.25 0 0 0-.5-1.71 3 3 0 0 0-5.78-1.128M12 15.75V9m0 0V4.5m0 4.5h4.5m-4.5 0H7.5"/></svg>';
//     }
//     return '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-10 h-10 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>';
// }

// function badgeEstado($estado) {
//     $e = strtolower($estado ?? '');
//     if ($e === 'activo' || $e === 'en proceso') {
//         return '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-[#25a18e]/10 text-[#25a18e] border border-[#25a18e]/20"><span class="w-1.5 h-1.5 rounded-full bg-[#25a18e]"></span>En proceso</span>';
//     }
//     if ($e === 'pendiente') {
//         return '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Pendiente</span>';
//     }
//     if ($e === 'resuelto') {
//         return '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Logrado</span>';
//     }
//     if ($e === 'cancelado') {
//         return '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Cancelado</span>';
//     }
//     return '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">' . htmlspecialchars(ucfirst($estado ?? '')) . '</span>';
// }

// function badgeCategoria($cat) {
//     $map = [
//         'estudio' => 'bg-[#00a5cf]/10 text-[#00a5cf]',
//         'salud' => 'bg-[#25a18e]/10 text-[#25a18e]',
//         'proyecto' => 'bg-[#ff3b30]/10 text-[#ff3b30]',
//         'creatividad' => 'bg-[#7ae582]/20 text-green-700',
//         'otros' => 'bg-gray-100 text-gray-600',
//     ];
//     $clase = $map[strtolower($cat ?? '')] ?? 'bg-gray-100 text-gray-600';
//     return '<span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider ' . $clase . '">' . htmlspecialchars($cat ?? '') . '</span>';
// }
?> -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Mi Panel - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Bricolage Grotesque', sans-serif; background-color: #f4f9fa; }
    </style>
</head>
<body class="text-[#004e64] min-h-screen bg-[#f4f9fa]">

    <?php require_once __DIR__ . "/../../../src/components/Header.php"; ?>

    <div class="mt-15 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-[#004e64] to-[#003d4f] text-white p-8 md:p-10 mb-10 shadow-2xl shadow-[#004e64]/20">
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#00a5cf]/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-[#9fffcb]/5 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold leading-tight">Hola, <?= $nombreCompleto ?>. <br><span class="text-[#9fffcb] font-medium text-lg md:text-xl">Tu proceso de reinicio esta en marcha</span></h2>
                </div>
                <div class="flex gap-6 md:gap-10">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-extrabold text-white"><?= $totalResets ?></div>
                        <div class="text-[11px] uppercase tracking-widest text-[#9fffcb]/80 font-bold mt-1">Resets</div>
                    </div>
                    <div class="w-px bg-white/20"></div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-extrabold text-white"><?= $enCurso ?></div>
                        <div class="text-[11px] uppercase tracking-widest text-[#9fffcb]/80 font-bold mt-1">En curso</div>
                    </div>
                    <div class="w-px bg-white/20"></div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-extrabold text-white"><?= $logrados ?></div>
                        <div class="text-[11px] uppercase tracking-widest text-[#9fffcb]/80 font-bold mt-1">Logrados</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-extrabold text-[#004e64]">Mis Resets</h3>
            <div class="flex items-center gap-3">
                <a href="<?= BASE_URL ?>/app/controllers/controller_profile.php" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:border-[#00a5cf] text-[#004e64] text-sm font-bold rounded-full shadow-sm transition-all">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    Configuración
                </a>
                <a href="<?= BASE_URL ?>/app/controllers/controller_register.php?rol=usuario" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#25a18e] hover:bg-[#1d8a78] text-white text-sm font-bold rounded-full shadow-lg shadow-[#25a18e]/30 transition-all">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Nuevo RESET
                </a>
            </div>
        </div>

        <?php if (empty($resets)): ?>
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#00a5cf]/10 flex items-center justify-center">
                <svg fill="none" stroke="#00a5cf" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </div>
            <p class="text-lg font-bold text-[#004e64] mb-1">Aún no tienes resets creados</p>
            <p class="text-sm text-gray-400 mb-6">Empieza tu primer RESET y da el primer paso hacia tu nueva oportunidad.</p>
            <a href="<?= BASE_URL ?>/app/controllers/controller_register.php?rol=usuario" class="inline-flex items-center gap-2 px-6 py-3 bg-[#00a5cf] hover:bg-[#008bb0] text-white text-sm font-bold rounded-full shadow-lg transition-all">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Crear mi primer RESET
            </a>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($resets as $reset): 
                $titulo = htmlspecialchars($reset['titulo'] ?? 'Sin título');
                $causa = htmlspecialchars(mb_substr($reset['causa_abandono'] ?? '', 0, 120));
                $necesidades = htmlspecialchars(mb_substr($reset['necesidades_reset'] ?? '', 0, 120));
                $categoria = $reset['nombre_categoria'] ?? '';
                $estado = $reset['nombre_estado'] ?? '';
                $fecha = date('Y-m-d', strtotime($reset['created_at'] ?? 'now'));
                $mentor = '';
                if (!empty($reset['vol_nombre'])) {
                    $mentor = htmlspecialchars($reset['vol_nombre'] . ' ' . ($reset['vol_apellidos'] ?? ''));
                }
                $progress = 0;
                if (strtolower($estado) === 'resuelto') $progress = 100;
                elseif (strtolower($estado) === 'activo') $progress = 60;
                elseif (strtolower($estado) === 'pendiente') $progress = 15;
            ?>
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-6 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <?= iconoCategoria($categoria) ?>
                        <div>
                            <h4 class="font-extrabold text-[#004e64] text-lg leading-tight"><?= $titulo ?></h4>
                            <div class="flex items-center gap-2 mt-1">
                                <?= badgeCategoria($categoria) ?>
                                <?= badgeEstado($estado) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="font-bold text-gray-400 uppercase tracking-wider">Progreso</span>
                        <span class="font-extrabold text-[#004e64]"><?= $progress ?>%</span>
                    </div>
                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] transition-all duration-700" style="width: <?= $progress ?>%"></div>
                    </div>
                </div>

                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <div class="flex items-center gap-2">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-4 h-4 text-gray-400 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                        <span class="text-gray-400"><?= $fecha ?></span>
                    </div>
                    <?php if (!empty($causa)): ?>
                    <div class="flex gap-2">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                        <p class="text-gray-500"><?= $causa ?><?= mb_strlen($reset['causa_abandono'] ?? '') > 120 ? '...' : '' ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($necesidades)): ?>
                    <div class="flex gap-2">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>
                        <p class="text-gray-500"><?= $necesidades ?><?= mb_strlen($reset['necesidades_reset'] ?? '') > 120 ? '...' : '' ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-[#9fffcb]/40 flex items-center justify-center text-xs font-bold text-[#004e64]">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                        </div>
                        <span class="text-sm text-gray-500">
                            <?= $mentor ? 'Mentor: <strong class="text-[#004e64]">' . $mentor . '</strong>' : '<span class="text-gray-400 italic">Sin mentor asignado</span>' ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>
