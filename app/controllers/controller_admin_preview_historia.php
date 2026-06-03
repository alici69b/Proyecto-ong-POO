<?php
require_once __DIR__ . "/../../config.php";
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'admin') {
    header('Location: ../auth/Login.php');
    exit();
}

require_once __DIR__ . '/../models/Historia.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die('ID de historia no válido');
}

$historiaModel = new Historia();
$h = $historiaModel->obtenerPorId($id);
if (!$h) {
    die('Historia no encontrada');
}

$foto = !empty($h['foto']) ? $h['foto'] : 'foto_defecto.webp';
$valoracion = (int)($h['valoracion'] ?? 5);
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/public/img/Logo_RESET.svg">
    <title>Vista previa - <?= htmlspecialchars($h['titulo']) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&family=Domine:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Bricolage Grotesque', sans-serif; }
        body { background: linear-gradient(135deg, #f4f9fa 0%, #e8f4f5 100%); }
    </style>
</head>
<body class="min-h-screen py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white/80 backdrop-blur-sm rounded-2xl p-4 shadow-sm border border-slate-100">
            <div class="flex items-center gap-3">
                <a href="controller_admin_gestionarhistorias.php" class="p-2 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-[#004e64] transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-2 hover:opacity-80 transition group ml-1">
                    <svg fill="#ff3b30" class="w-5 h-5 transition-transform group-hover:rotate-12" viewBox="0 0 612.00 612.00">
                        <path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z"></path>
                        <path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z"></path>
                    </svg>
                    <h3 class="font-black text-base tracking-tighter text-[#004e64]">RESET</h3>
                </a>
                <span class="text-slate-300 font-bold text-sm">/</span>
                <span class="text-slate-400 font-bold text-sm uppercase tracking-wider">Vista previa</span>
            </div>
            <div class="flex items-center gap-2">
                <?php if (!empty($h['automatica'])): ?>
                    <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-[11px] font-bold bg-purple-50 text-purple-700 ring-1 ring-purple-200">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Automática
                    </span>
                <?php endif; ?>
                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-bold <?= $h['estado'] === 'Publicada' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-amber-50 text-amber-700 ring-1 ring-amber-200' ?>">
                    <span class="h-1.5 w-1.5 rounded-full <?= $h['estado'] === 'Publicada' ? 'bg-emerald-500' : 'bg-amber-500' ?>"></span>
                    <?= $h['estado'] ?>
                </span>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-10 items-center bg-white rounded-3xl shadow-2xl p-8 lg:p-10 transition-all duration-300">
            <div class="w-full lg:w-auto shrink-0 flex justify-center lg:justify-end">
                <div class="relative inline-block">
                    <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($h['solicitante']) ?>" class="w-80 h-80 sm:w-96 sm:h-96 aspect-square object-cover rounded-3xl shadow-xl">
                    <div class="absolute -bottom-4 -right-4 px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg text-white bg-teal-600">
                        <?= htmlspecialchars($h['nombre_categoria']) ?>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-3xl flex flex-col flex-1">
                <div class="relative mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="text-teal-600 opacity-25 absolute -top-2 -left-2">
                        <path d="M9 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" />
                        <path d="M18 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" />
                    </svg>
                    <h1 class="text-3xl lg:text-4xl font-bold text-slate-800 font-['Domine'] pl-14 pt-2"><?= htmlspecialchars($h['titulo']) ?></h1>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                    <div class="bg-red-50/80 rounded-2xl p-6 border border-red-100">
                        <p class="text-sm font-bold text-orange-600 mb-3 uppercase tracking-wider">Antes</p>
                        <p class="text-gray-700 text-sm leading-relaxed"><?= htmlspecialchars($h['descripcion_antes'] ?? $h['descripcion']) ?></p>
                    </div>
                    <div class="bg-teal-50/80 rounded-2xl p-6 border border-teal-100">
                        <p class="text-sm font-bold text-teal-600 mb-3 uppercase tracking-wider">Después</p>
                        <p class="text-gray-700 text-sm leading-relaxed"><?= htmlspecialchars($h['descripcion_despues'] ?? $h['descripcion']) ?></p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-5 text-sm pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-3">
                        <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($foto) ?>" class="h-11 w-11 rounded-full object-cover ring-2 ring-slate-200">
                        <div>
                            <p class="font-bold text-slate-800"><?= htmlspecialchars($h['solicitante']) ?></p>
                        </div>
                    </div>
                    <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase tracking-wider font-bold">Voluntario</p>
                        <p class="font-semibold text-slate-700"><?= htmlspecialchars($h['nombre_voluntario'] ?? '—') ?></p>
                    </div>
                    <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase tracking-wider font-bold">Duración</p>
                        <p class="font-semibold text-slate-700"><?= (int)$h['duracion_meses'] ?> meses</p>
                    </div>
                    <div class="ml-auto flex gap-1">
                        <?php for ($s = 0; $s < $valoracion; $s++): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" class="text-yellow-400 drop-shadow-sm"><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                        <?php endfor; ?>
                        <?php for ($s = $valoracion; $s < 5; $s++): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-400"><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1.002l3.086 -6.253l3.086 6.253l6.9 1.002l-5 4.867l1.179 6.873z" /></svg>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="controller_admin_gestionarhistorias.php" class="inline-flex items-center gap-2 px-6 py-3 bg-[#004e64] text-white rounded-xl font-bold shadow-lg hover:bg-[#003d4f] transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver a Gestión de Historias
            </a>
        </div>
    </div>
</body>
</html>
