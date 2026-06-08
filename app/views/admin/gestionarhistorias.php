<?php
require_once __DIR__ . "/../../../config.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'admin') {
    header('Location: ../auth/Login.php');
    exit();
}

/** @var array $historias - Variable definida en el controlador */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Historias - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Bricolage Grotesque', sans-serif; }
        body { background-color: #f4f9fa; }
    </style>
</head>
<body class="text-[#004e64] min-h-screen flex">
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>
    <aside id="sidebar" class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="mt-6 px-2">
                <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-2 hover:opacity-80 transition group mb-4">
                    <svg fill="#ff3b30" class="w-6 h-6 transition-transform group-hover:rotate-12" viewBox="0 0 612.00 612.00">
                        <path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z"></path>
                        <path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z"></path>
                    </svg>
                    <h3 class="font-black text-lg tracking-tighter text-white">RESET</h3>
                </a>
            </div>
        <div class="flex items-center gap-3 px-2 mb-10">
                <div class="flex items-center gap-3  mb-4">
                    <?php if (!empty($_SESSION['foto_perfil'])): ?>
                        <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($_SESSION['foto_perfil']) ?>" class="w-9 h-9 rounded-full object-cover border-2 border-white/30">
                    <?php else: ?>
                        <div class="w-9 h-9 bg-[#00a5cf] rounded-full flex items-center justify-center text-white font-bold text-sm">
                            <?= strtoupper(substr($_SESSION['user_nombre'] ?? 'A', 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <div class="text-xs">
                        <p class="text-white font-bold truncate"><?= htmlspecialchars($_SESSION['user_nombre']) ?></p>
                        <p class="text-[#9fffcb] text-[10px]">Administrador</p>
                    </div>
                </div>
            </div>
        <nav class="flex flex-col gap-1.5 flex-1">
            <a href="<?= BASE_URL ?>/app/controllers/controller_admin_dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 36 36"><path d="M32 5H4c-1.1 0-2 .9-2 2v22c0 1.1.9 2 2 2h28c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zM4 29V7h28v22H4z"/><path d="M15.6 15.2l-6 8.7-4-3.5 1-1.2 2.7 2.4 6.3-9.2 6.7 10 6.8-8.9 1.3 1-8.1 10.7z"/></svg>
                Vista general
            </a>
            <a href="<?= BASE_URL ?>/app/controllers/controller_admin_gestionarreset.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" fill="currentColor" viewBox="0 0 1920 1920"><path d="M276.9 440.6v565.7c0 422.4 374.2 625.5 674.7 788.7l8 4.3 8.1-4.3c300.5-163.2 674.7-366.3 674.7-788.7V440.6l-682.8-321.7-682.8 321.7z"/></svg>
                Resets
            </a>
            <a href="<?= BASE_URL ?>/app/controllers/controller_admin_gestionusuarios.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Usuarios
            </a>
            <a href="<?= BASE_URL ?>/app/controllers/controller_admin_gestionarhistorias.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-bold text-sm shadow-lg">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Historias
            </a>
            <a href="<?= BASE_URL ?>/app/controllers/controller_admin_gestionarcontacto.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Mensajes
            </a>
        </nav>
        <div class="pt-4 border-t border-white/10">
            
            <a href="<?= BASE_URL ?>/app/controllers/controller_logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 transition-all text-sm font-bold">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M16 17v-4H9v-2h7V7l5 5-5 5M14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z"/></svg>
                Cerrar sesión
            </a>
        </div>
    </aside>

    <div class="lg:ml-64 flex-1 min-h-screen flex flex-col">
    <main class="flex-1 p-4 md:p-8 max-w-[90rem] mx-auto w-full">
        <div class="lg:hidden flex items-center justify-between mb-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
            <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-[#004e64]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>
            <div class="flex items-center gap-2">
                <?php if (!empty($_SESSION['foto_perfil'])): ?>
                    <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($_SESSION['foto_perfil']) ?>" class="w-8 h-8 rounded-full object-cover">
                <?php else: ?>
                    <span class="w-8 h-8 rounded-full bg-[#00a5cf] flex items-center justify-center text-white font-bold text-xs"><?= strtoupper(substr($_SESSION['user_nombre'] ?? 'A', 0, 1)) ?></span>
                <?php endif; ?>
                <span class="text-sm font-bold text-[#004e64]"><?= htmlspecialchars($_SESSION['user_nombre']) ?></span>
            </div>
        </div>
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">Gestión de Historias</h1>
                <p class="text-slate-500"><?= $total_historias ?> historias de éxito para inspirar</p>
            </div>
            <div class="flex items-center gap-3">
                <select onchange="window.location.href = 'controller_admin_gestionarhistorias.php?estado=' + this.value" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 focus:ring-2 focus:ring-[#25a18e] outline-none cursor-pointer shadow-sm">
                    <option value="" <?= empty($filtroEstado) ? 'selected' : '' ?>>Todas</option>
                    <option value="Publicada" <?= ($filtroEstado ?? '') === 'Publicada' ? 'selected' : '' ?>>Publicadas</option>
                    <option value="Borrador" <?= ($filtroEstado ?? '') === 'Borrador' ? 'selected' : '' ?>>Borradores</option>
                </select>
                <button onclick="abrirModalCrear()" class="px-6 py-2.5 bg-[#25a18e] text-white rounded-xl text-sm font-bold shadow-lg hover:bg-[#1e8575] transition-all active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>
                    Nueva Historia
                </button>
            </div>
        </header>

        <?php if (isset($_GET['created'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Historia creada correctamente
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Historia actualizada correctamente
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Historia eliminada correctamente
            </div>
        <?php endif; ?>
        <?php
        $total = $total_historias;
        $publicadas = $historiaModel->contarConFiltro('', 'Publicada');
        $borradores = $historiaModel->contarConFiltro('', 'Borrador');
        ?>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-[#e0f7fa] p-6 rounded-2xl border border-cyan-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-cyan-600 shadow-sm">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <p class="text-3xl font-black"><?= $total ?></p>
                    <p class="text-xs font-bold text-cyan-700/60 uppercase tracking-wider">Total historias</p>
                </div>
            </div>
            <div class="bg-[#e6f7e6] p-6 rounded-2xl border border-green-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-green-500 shadow-sm">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-3xl font-black"><?= $publicadas ?></p>
                    <p class="text-xs font-bold text-green-700/60 uppercase tracking-wider">Publicadas</p>
                </div>
            </div>
            <div class="bg-[#fef3f0] p-6 rounded-2xl border border-orange-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-orange-400 shadow-sm">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-3xl font-black"><?= $borradores ?></p>
                    <p class="text-xs font-bold text-orange-700/60 uppercase tracking-wider">Borradores</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <?php foreach ($historias as $h): ?>
                <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 hover:shadow-md transition-all">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-cyan-50 flex items-center justify-center text-lg sm:text-xl flex-shrink-0 relative">
                            <?php if (!empty($h['icono'])): ?><?= $h['icono'] ?><?php else: ?><svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg><?php endif; ?>
                            <?php if (!empty($h['automatica'])): ?>
                                <span class="absolute -top-1 -right-1 bg-purple-500 text-white text-[8px] w-4 h-4 rounded-full flex items-center justify-center font-bold" title="Generada automáticamente">A</span>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <h2 class="font-bold text-base sm:text-lg text-slate-800 truncate"><?= htmlspecialchars($h['titulo']) ?></h2>
                                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mt-1 text-xs sm:text-sm text-slate-400">
                                        <span class="font-semibold text-slate-600"><?= htmlspecialchars($h['solicitante'] ?? '') ?></span>
                                        <span class="opacity-50 hidden sm:inline">•</span>
                                        <span class="bg-slate-100 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase"><?= htmlspecialchars($h['nombre_categoria'] ?? '') ?></span>
                                        <span class="opacity-50 hidden sm:inline">•</span>
                                        <span><?= date('d/m/Y', strtotime($h['created_at'] ?? $h['fecha'])) ?></span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 flex-shrink-0 self-start">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] sm:text-xs font-semibold <?= ($h['estado'] ?? '') === 'Publicada' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100' : 'bg-amber-50 text-amber-700 ring-1 ring-amber-100' ?>">
                                        <span class="h-1.5 w-1.5 rounded-full <?= ($h['estado'] ?? '') === 'Publicada' ? 'bg-emerald-500' : 'bg-amber-500' ?>"></span>
                                        <?= htmlspecialchars($h['estado'] ?? '') ?>
                                    </span>
                                    <?php if (!empty($h['automatica'])): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-bold bg-purple-50 text-purple-700 ring-1 ring-purple-200" title="Generada automáticamente al completar un RESET">
                                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            Auto
                                        </span>
                                    <?php endif; ?>
                                    <div class="flex items-center gap-1 text-slate-400">
                                        <button onclick="abrirModalEditar(this)"
    data-id="<?= $h['id'] ?>"
    data-titulo="<?= htmlspecialchars($h['titulo'], ENT_QUOTES) ?>"
    data-solicitante="<?= htmlspecialchars($h['solicitante'] ?? '', ENT_QUOTES) ?>"
    data-voluntario="<?= htmlspecialchars($h['nombre_voluntario'] ?? '', ENT_QUOTES) ?>"
    data-categoria="<?= htmlspecialchars($h['nombre_categoria'] ?? '', ENT_QUOTES) ?>"
    data-descripcion="<?= htmlspecialchars($h['descripcion'] ?? '', ENT_QUOTES) ?>"
    data-antes="<?= htmlspecialchars($h['descripcion_antes'] ?? '', ENT_QUOTES) ?>"
    data-despues="<?= htmlspecialchars($h['descripcion_despues'] ?? '', ENT_QUOTES) ?>"
    data-duracion="<?= (int)($h['duracion_meses'] ?? 0) ?>"
    data-valoracion="<?= (int)($h['valoracion'] ?? 5) ?>"
    data-foto="<?= htmlspecialchars($h['foto'] ?? '', ENT_QUOTES) ?>"
    data-icono="<?= htmlspecialchars($h['icono'] ?? '', ENT_QUOTES) ?>"
    data-estado="<?= htmlspecialchars($h['estado'] ?? 'Borrador', ENT_QUOTES) ?>"
    title="Editar" class="p-1.5 sm:p-2 rounded-lg hover:bg-slate-100 hover:text-[#00a5cf] transition">
                                            <svg class="w-4 h-4 sm:w-[18px] sm:h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                        </button>
                                        <a href="controller_admin_preview_historia.php?id=<?= $h['id'] ?>" target="_blank" title="Vista previa" class="p-1.5 sm:p-2 rounded-lg hover:bg-slate-100 hover:text-[#00a5cf] transition">
                                            <svg class="w-4 h-4 sm:w-[18px] sm:h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <button onclick="abrirModalEliminar(<?= $h['id'] ?>)" title="Eliminar" class="p-1.5 sm:p-2 rounded-lg hover:bg-red-50 hover:text-red-600 transition">
                                            <svg class="w-4 h-4 sm:w-[18px] sm:h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 text-slate-500 text-sm leading-relaxed line-clamp-2 italic">"<?= htmlspecialchars($h['descripcion'] ?? '') ?>"</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($total_paginas > 1): ?>
        <div class="mt-6 p-4 bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xs text-slate-400 font-bold uppercase">Página <?= $pagina ?> de <?= $total_paginas ?></p>
            <div class="flex flex-wrap gap-1.5">
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <a href="controller_admin_gestionarhistorias.php?p=<?= $i ?>&estado=<?= urlencode($filtroEstado ?? '') ?>" class="w-9 h-9 flex items-center justify-center rounded-xl font-bold text-[13px] transition-all <?= $i === $pagina ? 'bg-[#004e64] text-white shadow-md' : 'bg-white border border-slate-200 hover:text-[#004e64]' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        </div>
        <?php endif; ?>
    </main>
</div>
<div id="modal-crear" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white p-6 rounded-2xl shadow-2xl max-w-lg w-full border border-slate-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-black text-slate-800">Nueva historia</h3>
            <button type="button" onclick="cerrarModalCrear()" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
            <input type="hidden" name="action_crear" value="1">
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Título</label>
                <input type="text" name="titulo" required class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Solicitante</label>
                    <select name="solicitante" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                        <option value="">Seleccionar usuario</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= htmlspecialchars($u['nombre'] . ' ' . ($u['apellidos'] ?? '')) ?>"><?= htmlspecialchars($u['nombre'] . ' ' . ($u['apellidos'] ?? '')) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Voluntario asignado</label>
                    <select name="nombre_voluntario" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                        <option value="">Seleccionar voluntario</option>
                        <?php foreach ($voluntarios as $v): ?>
                            <option value="<?= htmlspecialchars($v['nombre'] . ' ' . ($v['apellidos'] ?? '')) ?>"><?= htmlspecialchars($v['nombre'] . ' ' . ($v['apellidos'] ?? '')) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Categoría</label>
                    <select name="nombre_categoria" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                        <option value="">Seleccionar categoría</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars(ucfirst($cat)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Foto</label>
                    <input type="file" name="foto" accept="image/jpeg,image/png,image/webp,image/gif" class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none text-sm file:mr-3 file:py-1.5 file:px-4 file:rounded-xl file:border-0 file:bg-[#00a5cf] file:text-white file:font-bold file:text-xs hover:file:bg-[#0088aa] cursor-pointer">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Duración (meses)</label>
                    <input type="number" name="duracion_meses" min="0" max="999" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                </div>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Descripción (general)</label>
                <textarea name="descripcion" rows="2" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full"></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Antes</label>
                    <textarea name="descripcion_antes" rows="3" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full"></textarea>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Después</label>
                    <textarea name="descripcion_despues" rows="3" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full"></textarea>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Valoración</label>
                    <select name="valoracion" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Icono</label>
                    <input type="text" name="icono" value="" placeholder="Dejar vacío para icono por defecto" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                </div>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Estado</label>
                <select name="estado" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                    <option value="Borrador">Borrador</option>
                    <option value="Publicada">Publicada</option>
                </select>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="cerrarModalCrear()" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all">Cancelar</button>
                <button type="submit" class="flex-1 py-3 bg-[#25a18e] text-white font-bold rounded-xl shadow-lg hover:bg-[#1e8575] transition-all">Crear historia</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-editar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white p-6 rounded-2xl shadow-2xl max-w-lg w-full border border-slate-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-black text-slate-800">Editar historia</h3>
            <button type="button" onclick="cerrarModalEditar()" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
            <input type="hidden" name="action_editar" value="1">
            <input type="hidden" name="id" id="edit-id">
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Título</label>
                <input type="text" name="titulo" id="edit-titulo" required class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Solicitante</label>
                    <select name="solicitante" id="edit-solicitante" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                        <option value="">Seleccionar usuario</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= htmlspecialchars($u['nombre'] . ' ' . ($u['apellidos'] ?? '')) ?>"><?= htmlspecialchars($u['nombre'] . ' ' . ($u['apellidos'] ?? '')) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Voluntario asignado</label>
                    <select name="nombre_voluntario" id="edit-voluntario" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                        <option value="">Seleccionar voluntario</option>
                        <?php foreach ($voluntarios as $v): ?>
                            <option value="<?= htmlspecialchars($v['nombre'] . ' ' . ($v['apellidos'] ?? '')) ?>"><?= htmlspecialchars($v['nombre'] . ' ' . ($v['apellidos'] ?? '')) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Categoría</label>
                    <select name="nombre_categoria" id="edit-categoria" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                        <option value="">Seleccionar categoría</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars(ucfirst($cat)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Foto</label>
                    <div class="flex items-center gap-3 mt-1">
                        <img id="edit-foto-preview" src="" alt="Preview" class="w-12 h-12 rounded-xl object-cover border border-slate-200 hidden">
                        <input type="file" name="foto" accept="image/jpeg,image/png,image/webp,image/gif" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full text-sm file:mr-3 file:py-1.5 file:px-4 file:rounded-xl file:border-0 file:bg-[#00a5cf] file:text-white file:font-bold file:text-xs hover:file:bg-[#0088aa] cursor-pointer">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Duración (meses)</label>
                    <input type="number" name="duracion_meses" id="edit-duracion" min="0" max="999" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                </div>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Descripción (general)</label>
                <textarea name="descripcion" id="edit-descripcion" rows="2" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full"></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Antes</label>
                    <textarea name="descripcion_antes" id="edit-antes" rows="3" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full"></textarea>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Después</label>
                    <textarea name="descripcion_despues" id="edit-despues" rows="3" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full"></textarea>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Valoración</label>
                    <select name="valoracion" id="edit-valoracion" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Icono</label>
                    <input type="text" name="icono" id="edit-icono" placeholder="Dejar vacío para icono por defecto" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                </div>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Estado</label>
                <select name="estado" id="edit-estado" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                    <option value="Borrador">Borrador</option>
                    <option value="Publicada">Publicada</option>
                </select>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="cerrarModalEditar()" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all">Cancelar</button>
                <button type="submit" class="flex-1 py-3 bg-[#00a5cf] text-white font-bold rounded-xl shadow-lg hover:bg-[#0088aa] transition-all">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-eliminar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-sm w-full text-center">
        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"/></svg>
        </div>
        <h3 class="text-xl font-black mb-2">¿Eliminar historia?</h3>
        <p class="text-slate-500 text-sm mb-6">Esta acción no se puede deshacer.</p>
        <div class="flex gap-3">
            <button onclick="cerrarModalEliminar()" class="flex-1 py-3 bg-slate-100 font-bold rounded-xl">Cancelar</button>
            <a id="btn-confirmar-eliminar" href="#" class="flex-1 py-3 bg-red-500 text-white font-bold rounded-xl shadow-lg">Eliminar</a>
        </div>
    </div>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}
function abrirModalCrear() { document.getElementById('modal-crear').classList.remove('hidden'); }
function cerrarModalCrear() { document.getElementById('modal-crear').classList.add('hidden'); }
function abrirModalEditar(btn) {
    var d = btn.dataset;
    document.getElementById('edit-id').value = d.id;
    document.getElementById('edit-titulo').value = d.titulo;
    document.getElementById('edit-solicitante').value = d.solicitante;
    document.getElementById('edit-voluntario').value = d.voluntario;
    document.getElementById('edit-categoria').value = d.categoria;
    document.getElementById('edit-descripcion').value = d.descripcion;
    document.getElementById('edit-antes').value = d.antes;
    document.getElementById('edit-despues').value = d.despues;
    document.getElementById('edit-duracion').value = d.duracion;
    document.getElementById('edit-valoracion').value = d.valoracion;
    document.getElementById('edit-icono').value = d.icono;
    document.getElementById('edit-estado').value = d.estado;
    var preview = document.getElementById('edit-foto-preview');
    if (d.foto) {
        preview.src = '<?= BASE_URL ?>/public/img/' + d.foto;
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
    }
    document.getElementById('modal-editar').classList.remove('hidden');
}
function cerrarModalEditar() { document.getElementById('modal-editar').classList.add('hidden'); }
function abrirModalEliminar(id) {
    document.getElementById('btn-confirmar-eliminar').href = 'controller_admin_gestionarhistorias.php?action=delete&id=' + id;
    document.getElementById('modal-eliminar').classList.remove('hidden');
}
function cerrarModalEliminar() { document.getElementById('modal-eliminar').classList.add('hidden'); }
window.addEventListener('click', function(e) {
    if (e.target === document.getElementById('modal-crear')) cerrarModalCrear();
    if (e.target === document.getElementById('modal-editar')) cerrarModalEditar();
    if (e.target === document.getElementById('modal-eliminar')) cerrarModalEliminar();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { cerrarModalCrear(); cerrarModalEditar(); cerrarModalEliminar(); }
});
</script>
</body>
</html>
