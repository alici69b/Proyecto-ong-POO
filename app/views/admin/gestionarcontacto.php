<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'admin') {
    header('Location: ../auth/Login.php');
    exit();
}

/** @var array $mensajes - Variable definida en el controlador (controller_admin_gestionarcontacto.php, línea 17) */
/** @var int $total_mensajes - Variable definida en el controlador (controller_admin_gestionarcontacto.php, línea 18) */
/** @var int $no_leidos - Variable definida en el controlador (controller_admin_gestionarcontacto.php) */
/** @var int $leidos - controller_admin_gestionarcontacto.php:39 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Bandeja de entrada - RESET</title>
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
            <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionusuarios.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Usuarios
            </a>
            <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionarhistorias.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Historias
            </a>
            <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionarcontacto.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-bold text-sm shadow-lg">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
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
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-extrabold tracking-tight">Bandeja de entrada</h1>
                    <?php if ($no_leidos > 0): ?>
                        <span class="px-2.5 py-1 bg-red-500 text-white text-[10px] font-bold rounded-full"><?= $no_leidos ?> sin leer</span>
                    <?php endif; ?>
                </div>
                <p class="text-slate-500"><?= $total_mensajes ?> mensajes recibidos</p>
            </div>
            <button onclick="location.reload()" class="px-6 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold hover:shadow-md transition-all active:scale-95">Actualizar</button>
        </header>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Mensaje eliminado correctamente
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-[#e0f7fa] p-6 rounded-2xl border border-cyan-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-cyan-600 shadow-sm">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
                <div>
                    <p class="text-3xl font-black"><?= $total_mensajes ?></p>
                    <p class="text-xs font-bold text-cyan-700/60 uppercase tracking-wider">Total mensajes</p>
                </div>
            </div>
            <div class="bg-[#fef3f0] p-6 rounded-2xl border border-orange-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-orange-400 shadow-sm">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-3xl font-black"><?= $leidos ?></p>
                    <p class="text-xs font-bold text-orange-700/60 uppercase tracking-wider">Leídos</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <?php if (empty($mensajes)): ?>
                <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-slate-300">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <p class="text-slate-400 font-bold text-lg">Bandeja vacía</p>
                    <p class="text-slate-300 text-sm">No hay mensajes de contacto todavía.</p>
                </div>
            <?php else: ?>
                <?php foreach ($mensajes as $m): ?>
                <div class="rounded-2xl p-6 shadow-sm transition-all <?= empty($m['leido']) ? 'bg-blue-50/50 border-l-4 border-l-[#00a5cf] border border-blue-100' : 'bg-white border border-slate-100 hover:shadow-md' ?>">
                    <div class="flex flex-col md:flex-row md:items-center gap-6">
                        <div class="w-14 h-14 rounded-full bg-slate-100 border-4 border-slate-50 flex items-center justify-center text-xl font-bold text-slate-400 flex-shrink-0">
                            <?= strtoupper(substr($m['nombre_remitente'] ?? $m['email_remitente'], 0, 1)) ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h2 class="font-bold text-lg text-slate-800"><?= htmlspecialchars($m['nombre_remitente'] ?? 'Anónimo') ?></h2>
                                <span class="text-xs text-slate-300">•</span>
                                <span class="text-sm text-slate-400"><?= htmlspecialchars($m['email_remitente']) ?></span>
                            </div>
                            <h3 class="font-extrabold text-[#005f73] text-sm uppercase tracking-wide"><?= htmlspecialchars($m['asunto'] ?? 'Sin asunto') ?></h3>
                            <p class="mt-2 text-slate-500 text-sm leading-relaxed italic"><?= htmlspecialchars($m['cuerpo_mensaje'] ?? $m['mensaje'] ?? '') ?></p>
                            <p class="mt-3 text-[10px] font-bold text-slate-300 uppercase tracking-widest">Recibido el <?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></p>
                        </div>
                        <div class="flex-shrink-0 flex flex-col gap-2">
                            <?php if (empty($m['leido'])): ?>
                                <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionarcontacto.php?action=read&id=<?= $m['id'] ?>" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-[#00a5cf] hover:bg-[#00a5cf]/10 rounded-xl transition-all border border-transparent hover:border-[#00a5cf]/30">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Marcar leído
                                </a>
                            <?php endif; ?>
                            <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionarcontacto.php?action=delete&id=<?= $m['id'] ?>" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-red-400 hover:bg-red-50 rounded-xl transition-all border border-transparent hover:border-red-100" onclick="return confirm('¿Eliminar este mensaje?')">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                Eliminar
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}
</script>
</body>
</html>
