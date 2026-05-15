<?php
if (!isset($resets)) {
    header('Location: ../../controllers/controller_user_dashboard.php');
    exit();
}
?>
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
            <a href="/Proyecto-ong-POO/app/controllers/controller_register.php?rol=usuario" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#25a18e] hover:bg-[#1d8a78] text-white text-sm font-bold rounded-full shadow-lg shadow-[#25a18e]/30 transition-all">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Nuevo RESET
            </a>
        </div>

        <?php if (empty($resets)): ?>
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#00a5cf]/10 flex items-center justify-center">
                <svg fill="none" stroke="#00a5cf" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </div>
            <p class="text-lg font-bold text-[#004e64] mb-1">Aún no tienes resets creados</p>
            <p class="text-sm text-gray-400 mb-6">Empieza tu primer RESET y da el primer paso hacia tu nueva oportunidad.</p>
            <a href="/Proyecto-ong-POO/app/controllers/controller_register.php?rol=usuario" class="inline-flex items-center gap-2 px-6 py-3 bg-[#00a5cf] hover:bg-[#008bb0] text-white text-sm font-bold rounded-full shadow-lg transition-all">
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
