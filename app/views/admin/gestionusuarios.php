<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'admin') {
    header('Location: ../auth/Login.php');
    exit();
}

/** @var int $total_usuarios - Variable definida en el controlador (controller_admin_gestionusuarios.php, línea 57) */
/** @var int $pagina - Variable definida en el controlador (controller_admin_gestionusuarios.php, línea 42) */
/** @var int $total_paginas - Variable definida en el controlador (controller_admin_gestionusuarios.php, línea 58) */
/** @var string $buscar - Variable definida en el controlador (controller_admin_gestionusuarios.php, línea 41) */
/** @var array $usuarios - Variable definida en el controlador (controller_admin_gestionusuarios.php, línea 63) */
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
        <div class="flex items-center gap-3 px-2 mt-8 mb-10">
                <div class="flex items-center gap-3  mb-4">
                    <div class="w-9 h-9 bg-[#00a5cf] rounded-full flex items-center justify-center text-white font-bold text-sm">
                        <?= strtoupper(substr($_SESSION['user_nombre'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="text-xs">
                        <p class="text-white font-bold truncate"><?= htmlspecialchars($_SESSION['user_nombre']) ?></p>
                        <p class="text-[#9fffcb] text-[10px]">Administrador</p>
                    </div>
                </div>
            </div>
        <nav class="flex flex-col gap-1.5 flex-1">
            <a href="/Proyecto-ong-POO/app/controllers/controller_admin_dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 36 36"><path d="M32 5H4c-1.1 0-2 .9-2 2v22c0 1.1.9 2 2 2h28c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zM4 29V7h28v22H4z"/><path d="M15.6 15.2l-6 8.7-4-3.5 1-1.2 2.7 2.4 6.3-9.2 6.7 10 6.8-8.9 1.3 1-8.1 10.7z"/></svg>
                Vista general
            </a>
            <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionarreset.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" fill="currentColor" viewBox="0 0 1920 1920"><path d="M276.9 440.6v565.7c0 422.4 374.2 625.5 674.7 788.7l8 4.3 8.1-4.3c300.5-163.2 674.7-366.3 674.7-788.7V440.6l-682.8-321.7-682.8 321.7z"/></svg>
                Resets
            </a>
            <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionusuarios.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-bold text-sm shadow-lg">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Usuarios
            </a>
            <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionarhistorias.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Historias
            </a>
            <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionarcontacto.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Mensajes
            </a>
        </nav>
        <div class="pt-4 border-t border-white/10">
            
            <a href="/Proyecto-ong-POO/app/controllers/controller_logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 transition-all text-sm font-bold">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M16 17v-4H9v-2h7V7l5 5-5 5M14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z"/></svg>
                Cerrar sesión
            </a>
        </div>
    </aside>

    <div class="lg:ml-64 flex-1 min-h-screen flex flex-col">
    <main class="flex-1 p-4 md:p-8 max-w-[90rem] mx-auto w-full">
        <?php if (isset($modo_simulado) && $modo_simulado): ?>
        <div class="flex flex-col gap-2 mb-6">
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-yellow-50 border border-yellow-300 text-yellow-800 text-sm font-medium">
                <svg class="w-5 h-5 shrink-0 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                <span>Modo simulación — Las acciones están deshabilitadas. Solo puedes visualizar los datos.</span>
            </div>
            <?php if (isset($_GET['sim_bloqueado'])): ?>
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-50 border border-red-300 text-red-700 text-sm font-medium">
                <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                <span>Acción bloqueada: estás en modo simulación.</span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="lg:hidden flex items-center justify-between mb-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
            <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-[#004e64]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-[#00a5cf] flex items-center justify-center text-white font-bold text-xs"><?= strtoupper(substr($_SESSION['user_nombre'] ?? 'A', 0, 1)) ?></span>
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
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
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
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                El email ya está registrado
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[11px] font-bold uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Usuario</th>
                            <th class="px-6 py-4 hidden md:table-cell">Email</th>
                            <th class="px-6 py-4 hidden sm:table-cell">Rol</th>
                            <th class="px-6 py-4 hidden sm:table-cell">Registro</th>
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
                                            <img src="/Proyecto-ong-POO/public/img/<?= htmlspecialchars($u['foto_perfil'] ?? 'foto_defecto.webp') ?>" alt="Foto"
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
                                <td class="px-6 py-3.5 text-slate-600 hidden md:table-cell"><?= htmlspecialchars($u['email']) ?></td>
                                <td class="px-6 py-3.5 hidden sm:table-cell">
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full <?= $u['nombre_rol'] === 'admin' ? 'bg-red-50 text-red-600' : ($u['nombre_rol'] === 'soy-voluntario' ? 'bg-blue-50 text-blue-600' : 'bg-green-50 text-green-600') ?>">
                                        <?= $u['nombre_rol'] === 'soy-usuario' ? 'Usuario' : ($u['nombre_rol'] === 'soy-voluntario' ? 'Voluntario' : 'Admin') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-slate-500 text-xs hidden sm:table-cell"><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
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
            <div class="p-4 bg-slate-50 flex flex-col sm:flex-row justify-between items-center border-t border-slate-100 gap-4">
                <p class="text-xs text-slate-400 font-bold uppercase">Página <?= $pagina ?> de <?= $total_paginas ?></p>
                <div class="flex flex-wrap gap-1.5">
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionusuarios.php?p=<?= $i ?>&search=<?= urlencode($buscar) ?>" class="w-9 h-9 flex items-center justify-center rounded-xl font-bold text-[13px] transition-all <?= $i === $pagina ? 'bg-[#004e64] text-white shadow-md' : 'bg-white border border-slate-200 hover:text-[#004e64]' ?>"><?= $i ?></a>
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
            <form method="POST" class="space-y-4">
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
            <form method="POST" class="space-y-4">
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
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
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
            document.getElementById('btn-confirmar-eliminar').href = '/Proyecto-ong-POO/app/controllers/controller_admin_gestionusuarios.php?action=delete&id=' + id;
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
