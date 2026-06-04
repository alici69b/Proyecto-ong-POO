<?php
require_once __DIR__ . "/../../../config.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'admin') {
    header('Location: ../auth/Login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Usuarios - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Bricolage Grotesque', sans-serif; }
        body { background-color: #f4f9fa; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
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
            <a href="<?= BASE_URL ?>/app/controllers/controller_admin_gestionusuarios.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-bold text-sm shadow-lg">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Usuarios
            </a>
            <a href="<?= BASE_URL ?>/app/controllers/controller_admin_gestionarhistorias.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-6">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">Gestión de Usuarios</h1>
                <p class="text-slate-500"><?= $total_usuarios ?> usuarios registrados</p>
            </div>
            <div class="flex gap-3 w-full lg:w-auto">
                <form method="GET" class="relative flex-1 lg:w-80">
                    <input type="text" name="search" value="<?= htmlspecialchars($buscar) ?>" placeholder="Buscar por nombre o email..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-[#25a18e] focus:border-transparent outline-none transition-all shadow-sm text-sm">
                    <svg class="absolute left-3 top-3 w-5 h-5 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </form>
                <button onclick="abrirModalCrear()" class="px-5 py-2.5 bg-[#25a18e] text-white rounded-xl text-sm font-bold shadow-lg hover:bg-[#1e8575] transition-all active:scale-95 flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>
                    Nuevo Usuario
                </button>
            </div>
        </header>

        <?php if (isset($_GET['updated'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Usuario actualizado correctamente
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Usuario eliminado correctamente
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['errordelete'])): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"/></svg>
                No puedes eliminarte a ti mismo
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['created'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Usuario creado correctamente
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['erroremail'])): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"/></svg>
                El email ya está registrado
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <?php /* Desktop: tabla completa */ ?>
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[11px] font-bold uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Usuario</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Rol</th>
                            <th class="px-6 py-4">Registro</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php if (empty($usuarios)): ?>
                            <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">No se encontraron usuarios.</td></tr>
                        <?php else: ?>
                            <?php foreach ($usuarios as $u): ?>
                            <tr class="hover:bg-slate-50/80 transition-all">
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                            <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($u['foto_perfil'] ?? 'foto_defecto.webp') ?>" alt="Foto"
                                                 class="w-full h-full object-cover"
                                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                            <div class="w-full h-full hidden items-center justify-center text-xs font-bold text-slate-400 bg-gradient-to-br from-[#00a5cf] to-[#9fffcb] text-white">
                                                <?= $u['iniciales'] ?>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-700"><?= htmlspecialchars($u['nombre'] . ' ' . ($u['apellidos'] ?? '')) ?></p>
                                            <p class="text-[10px] text-slate-400">ID: #<?= $u['id'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 text-slate-600"><?= htmlspecialchars($u['email']) ?></td>
                                <td class="px-6 py-3.5">
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full <?= $u['nombre_rol'] === 'admin' ? 'bg-red-50 text-red-600' : ($u['nombre_rol'] === 'soy-voluntario' ? 'bg-blue-50 text-blue-600' : 'bg-green-50 text-green-600') ?>">
                                        <?= $u['nombre_rol'] === 'soy-usuario' ? 'Usuario' : ($u['nombre_rol'] === 'soy-voluntario' ? 'Voluntario' : 'Admin') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-slate-500 text-xs"><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                                <td class="px-6 py-3.5 text-center">
                                    <div class="flex justify-center gap-1">
                                        <button onclick="abrirModalEditar(<?= $u['id'] ?>, '<?= addslashes($u['nombre']) ?>', '<?= addslashes($u['apellidos'] ?? '') ?>', '<?= addslashes($u['email']) ?>', <?= (int)$u['id_rol'] ?>)" class="p-2 hover:bg-blue-50 text-blue-500 rounded-xl transition-all active:scale-90" title="Editar">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </button>
                                        <button onclick="abrirModal(<?= $u['id'] ?>)" class="p-2 hover:bg-red-50 text-red-400 hover:text-red-600 rounded-xl transition-all active:scale-90" title="Eliminar">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php /* Móvil y tablet: cards en grid */ ?>
            <div class="lg:hidden p-4 sm:p-6">
                <?php if (empty($usuarios)): ?>
                    <div class="py-12 text-center text-slate-400">No se encontraron usuarios.</div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php foreach ($usuarios as $u): ?>
                        <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm hover:shadow-md transition-all">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                    <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($u['foto_perfil'] ?? 'foto_defecto.webp') ?>" alt="Foto"
                                         class="w-full h-full object-cover"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                    <div class="w-full h-full hidden items-center justify-center text-xs font-bold text-slate-400 bg-gradient-to-br from-[#00a5cf] to-[#9fffcb] text-white">
                                        <?= $u['iniciales'] ?>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-slate-700 truncate"><?= htmlspecialchars($u['nombre'] . ' ' . ($u['apellidos'] ?? '')) ?></p>
                                    <p class="text-xs text-slate-400 truncate"><?= htmlspecialchars($u['email']) ?></p>
                                    <div class="flex flex-wrap items-center gap-2 mt-2">
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?= $u['nombre_rol'] === 'admin' ? 'bg-red-50 text-red-600' : ($u['nombre_rol'] === 'soy-voluntario' ? 'bg-blue-50 text-blue-600' : 'bg-green-50 text-green-600') ?>">
                                            <?= $u['nombre_rol'] === 'soy-usuario' ? 'Usuario' : ($u['nombre_rol'] === 'soy-voluntario' ? 'Voluntario' : 'Admin') ?>
                                        </span>
                                        <span class="text-[10px] text-slate-400"><?= date('d/m/Y', strtotime($u['created_at'])) ?></span>
                                    </div>
                                    <div class="flex items-center gap-1 mt-3 pt-3 border-t border-slate-50">
                                        <button onclick="abrirModalEditar(<?= $u['id'] ?>, '<?= addslashes($u['nombre']) ?>', '<?= addslashes($u['apellidos'] ?? '') ?>', '<?= addslashes($u['email']) ?>', <?= (int)$u['id_rol'] ?>)" class="flex-1 py-2 text-xs font-bold text-blue-500 hover:bg-blue-50 rounded-xl transition-all" title="Editar">
                                            Editar
                                        </button>
                                        <button onclick="abrirModal(<?= $u['id'] ?>)" class="flex-1 py-2 text-xs font-bold text-red-400 hover:bg-red-50 rounded-xl transition-all" title="Eliminar">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="p-4 bg-slate-50 flex flex-col sm:flex-row justify-between items-center border-t border-slate-100 gap-4">
                <p class="text-xs text-slate-400 font-bold uppercase">Página <?= $pagina ?> de <?= $total_paginas ?></p>
                <div class="flex flex-wrap gap-1.5">
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="<?= BASE_URL ?>/app/controllers/controller_admin_gestionusuarios.php?p=<?= $i ?>&search=<?= urlencode($buscar) ?>" class="w-9 h-9 flex items-center justify-center rounded-xl font-bold text-[13px] transition-all <?= $i === $pagina ? 'bg-[#004e64] text-white shadow-md' : 'bg-white border border-slate-200 hover:text-[#004e64]' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </main>

</div>

    <div id="modal-editar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white p-6 rounded-2xl shadow-2xl max-w-lg w-full border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-black text-slate-800">Editar usuario</h3>
                <button type="button" onclick="cerrarModalEditar()" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <form method="POST" class="space-y-4" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                <input type="hidden" name="id_usuario" id="edit-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre</label>
                        <input type="text" name="nombre" id="edit-nombre" required class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Apellidos</label>
                        <input type="text" name="apellidos" id="edit-apellidos" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Email</label>
                    <input type="email" name="email" id="edit-email" required class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Rol</label>
                    <select name="id_rol" id="edit-rol" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                        <option value="1">Usuario</option>
                        <option value="2">Voluntario</option>
                        <option value="3">Administrador</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Foto de perfil <span class="text-[10px] lowercase font-normal">(opcional)</span></label>
                    <input type="file" name="foto" accept="image/jpeg,image/png,image/webp,image/gif" class="mt-1 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-[#00a5cf] file:text-white hover:file:bg-[#0088aa] file:cursor-pointer file:transition-all">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nueva contraseña <span class="text-[10px] lowercase font-normal">(opcional)</span></label>
                    <input type="password" name="password_nuevo" id="edit-password" placeholder="Dejar vacío para mantener" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="cerrarModalEditar()" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-3 bg-[#00a5cf] text-white font-bold rounded-xl shadow-lg hover:bg-[#0088aa] transition-all">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-crear" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white p-6 rounded-2xl shadow-2xl max-w-lg w-full border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-black text-slate-800">Nuevo usuario</h3>
                <button type="button" onclick="cerrarModalCrear()" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <form method="POST" class="space-y-4" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                <input type="hidden" name="action_crear" value="1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre</label>
                        <input type="text" name="nombre" required class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Apellidos</label>
                        <input type="text" name="apellidos" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Email</label>
                    <input type="email" name="email" required class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Contraseña</label>
                    <input type="password" name="password" required class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Rol</label>
                    <select name="id_rol" class="mt-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] outline-none w-full cursor-pointer">
                        <option value="1">Usuario</option>
                        <option value="2">Voluntario</option>
                        <option value="3">Administrador</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Foto de perfil <span class="text-[10px] lowercase font-normal">(opcional)</span></label>
                    <input type="file" name="foto" accept="image/jpeg,image/png,image/webp,image/gif" class="mt-1 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-[#25a18e] file:text-white hover:file:bg-[#1e8575] file:cursor-pointer file:transition-all">
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="cerrarModalCrear()" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-3 bg-[#25a18e] text-white font-bold rounded-xl shadow-lg hover:bg-[#1e8575] transition-all">Crear usuario</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-confirmar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-sm w-full text-center">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"/></svg>
            </div>
            <h3 class="text-xl font-black mb-2">¿Eliminar usuario?</h3>
            <p class="text-slate-500 text-sm mb-6">Esta acción no se puede deshacer.</p>
            <div class="flex gap-3">
                <button onclick="cerrarModal()" class="flex-1 py-3 bg-slate-100 font-bold rounded-xl">Cancelar</button>
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
        function abrirModalEditar(id, nombre, apellidos, email, rol) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-apellidos').value = apellidos;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-rol').value = rol;
            document.getElementById('edit-password').value = '';
            document.getElementById('modal-editar').classList.remove('hidden');
        }
        function cerrarModalEditar() { document.getElementById('modal-editar').classList.add('hidden'); }
        function abrirModalCrear() { document.getElementById('modal-crear').classList.remove('hidden'); }
        function cerrarModalCrear() { document.getElementById('modal-crear').classList.add('hidden'); }
        function abrirModal(id) {
            document.getElementById('btn-confirmar-eliminar').href = '<?= BASE_URL ?>/app/controllers/controller_admin_gestionusuarios.php?action=delete&id=' + id;
            document.getElementById('modal-confirmar').classList.remove('hidden');
        }
        function cerrarModal() { document.getElementById('modal-confirmar').classList.add('hidden'); }
        window.addEventListener('click', function(e) {
            if (e.target === document.getElementById('modal-editar')) cerrarModalEditar();
            if (e.target === document.getElementById('modal-crear')) cerrarModalCrear();
            if (e.target === document.getElementById('modal-confirmar')) cerrarModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') { cerrarModalEditar(); cerrarModalCrear(); cerrarModal(); }
        });
    </script>
</body>
</html>
