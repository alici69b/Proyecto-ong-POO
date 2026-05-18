<?php
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
    <title>Dashboard Admin - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Bricolage Grotesque', sans-serif; }
        body { background-color: #f4f9fa; }
        .card { transition: all 0.3s ease; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 10px 10px -5px rgba(0,0,0,0.02); }
    </style>
</head>
<body class="text-[#004e64] min-h-screen">
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>
    <aside id="sidebar" class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col shadow-2xl -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="flex items-center justify-between px-2 mt-8 mb-10">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-[#00a5cf] rounded-full flex items-center justify-center text-white font-bold text-sm">
                        <?= strtoupper(substr($_SESSION['user_nombre'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="text-xs">
                        <p class="text-white font-bold truncate"><?= htmlspecialchars($_SESSION['user_nombre']) ?></p>
                        <p class="text-[#9fffcb] text-[10px]">Administrador</p>
                    </div>
                </div>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-white/60 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex flex-col gap-1.5 flex-1">
            <a href="../controllers/controller_admin_dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-bold text-sm shadow-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 36 36"><path d="M32 5H4c-1.1 0-2 .9-2 2v22c0 1.1.9 2 2 2h28c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zM4 29V7h28v22H4z"/><path d="M15.6 15.2l-6 8.7-4-3.5 1-1.2 2.7 2.4 6.3-9.2 6.7 10 6.8-8.9 1.3 1-8.1 10.7z"/></svg>
                Vista general
            </a>
            <a href="../views/admin/gestionarreset.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" fill="currentColor" viewBox="0 0 1920 1920"><path d="M276.9 440.6v565.7c0 422.4 374.2 625.5 674.7 788.7l8 4.3 8.1-4.3c300.5-163.2 674.7-366.3 674.7-788.7V440.6l-682.8-321.7-682.8 321.7z"/></svg>
                Resets <span class="ml-auto bg-white/20 text-[10px] px-2 py-0.5 rounded-full font-bold"><?= $total_resets ?></span>
            </a>
            <a href="../views/admin/gestionusuarios.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Usuarios <span class="ml-auto bg-white/20 text-[10px] px-2 py-0.5 rounded-full font-bold"><?= $total_usuarios ?></span>
            </a>
            <a href="../views/admin/gestionarhistorias.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Historias
            </a>
            <a href="../views/admin/gestionarcontacto.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Mensajes <span class="ml-auto bg-white/20 text-[10px] px-2 py-0.5 rounded-full font-bold"><?= $total_mensajes ?></span>
            </a>
        </nav>
        <div class="pt-4 border-t border-white/10">
            <a href="../controllers/controller_logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 transition-all text-sm font-bold">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M16 17v-4H9v-2h7V7l5 5-5 5M14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z"/></svg>
                Cerrar sesión
            </a>
        </div>
    </aside>
    <main class="flex-1 ml-0 lg:ml-64 p-4 md:p-8">
        <div class="lg:hidden flex items-center justify-between mb-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
            <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-[#004e64]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-[#00a5cf] flex items-center justify-center text-white font-bold text-xs"><?= strtoupper(substr($_SESSION['user_nombre'] ?? 'A', 0, 1)) ?></span>
                <span class="text-sm font-bold text-[#004e64]"><?= htmlspecialchars($_SESSION['user_nombre']) ?></span>
            </div>
        </div>
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight">Vista General</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="w-2 h-2 rounded-full bg-[#7ae582] animate-pulse"></span>
                        <p class="text-gray-400 text-sm"><?= date('l, d F Y · H:i') ?>hs</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button onclick="location.reload()" class="px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold hover:shadow-md transition-all active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 4v6h6M23 20v-6h-6"/><path d="M20.49 9A9 9 0 005.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 013.51 15"/></svg>
                        Actualizar
                    </button>
                </div>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="card bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-full">+<?= count($ultimos_usuarios) ?> nuevos</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Usuarios</p>
                    <p class="text-4xl font-extrabold text-slate-800 mt-1"><?= $total_usuarios ?></p>
                </div>
                <div class="card bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">En proceso</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Resets activos</p>
                    <p class="text-4xl font-extrabold text-slate-800 mt-1"><?= $pendientes ?></p>
                </div>
                <div class="card bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">Completados</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Finalizados</p>
                    <p class="text-4xl font-extrabold text-slate-800 mt-1"><?= $completados ?></p>
                </div>
                <div class="card bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Activos</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Voluntarios</p>
                    <p class="text-4xl font-extrabold text-slate-800 mt-1"><?= $total_voluntarios ?></p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-extrabold text-slate-700 flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#00a5cf] rounded-full"></span>
                            Estado de Resets
                        </h3>
                        <span class="text-[10px] font-bold text-slate-400">Total: <?= $total_resets ?></span>
                    </div>
                    <?php if ($total_resets > 0): ?>
                    <div class="h-64">
                        <canvas id="chartResets"></canvas>
                    </div>
                    <?php else: ?>
                    <div class="flex flex-col items-center justify-center h-64 bg-slate-50 rounded-xl">
                        <svg class="w-16 h-16 text-slate-300 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <p class="text-slate-400 font-bold">No hay datos de resets todavía</p>
                        <p class="text-slate-300 text-sm">Los datos aparecerán aquí cuando los usuarios soliciten resets.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-extrabold text-slate-700 flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#7ae582] rounded-full"></span>
                            Últimos usuarios
                        </h3>
                        <a href="../views/admin/gestionusuarios.php" class="text-[10px] font-bold text-[#00a5cf] hover:underline">Ver todos</a>
                    </div>
                    <div class="space-y-4">
                        <?php if (empty($ultimos_usuarios)): ?>
                            <p class="text-slate-400 text-sm text-center py-8">No hay usuarios registrados</p>
                        <?php else: ?>
                            <?php foreach ($ultimos_usuarios as $u): ?>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#00a5cf] to-[#9fffcb] flex items-center justify-center text-white font-bold text-xs">
                                    <?= strtoupper(substr($u['nombre'], 0, 1)) ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-700 truncate"><?= htmlspecialchars($u['nombre']) ?></p>
                                    <p class="text-[11px] text-slate-400 truncate"><?= htmlspecialchars($u['email']) ?></p>
                                </div>
                                <span class="text-[10px] font-bold px-2 py-1 rounded-full <?= $u['nombre_rol'] === 'admin' ? 'bg-red-50 text-red-500' : ($u['nombre_rol'] === 'soy-voluntario' ? 'bg-blue-50 text-blue-500' : 'bg-green-50 text-green-500') ?>">
                                    <?= $u['nombre_rol'] === 'soy-usuario' ? 'Usuario' : ($u['nombre_rol'] === 'soy-voluntario' ? 'Voluntario' : 'Admin') ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-[#004e64] to-[#007a8a] rounded-2xl p-6 text-white">
                    <p class="text-sm font-bold opacity-80 uppercase tracking-wider">Total resets</p>
                    <p class="text-4xl font-extrabold mt-2"><?= $total_resets ?></p>
                    <div class="mt-4 flex items-center gap-2 text-[11px] opacity-70">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        Nuevos: <?= $nuevos ?>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-[#25a18e] to-[#2ec4a0] rounded-2xl p-6 text-white">
                    <p class="text-sm font-bold opacity-80 uppercase tracking-wider">Voluntarios</p>
                    <p class="text-4xl font-extrabold mt-2"><?= $total_voluntarios ?></p>
                    <div class="mt-4 flex items-center gap-2 text-[11px] opacity-70">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Disponibles
                    </div>
                </div>
                <div class="bg-gradient-to-br from-[#ff3b30] to-[#ff6b6b] rounded-2xl p-6 text-white">
                    <p class="text-sm font-bold opacity-80 uppercase tracking-wider">Administradores</p>
                    <p class="text-4xl font-extrabold mt-2"><?= $total_admin ?></p>
                    <div class="mt-4 flex items-center gap-2 text-[11px] opacity-70">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Gestores del sistema
                    </div>
                </div>
                <div class="bg-gradient-to-br from-[#00a5cf] to-[#48cae4] rounded-2xl p-6 text-white">
                    <p class="text-sm font-bold opacity-80 uppercase tracking-wider">Mensajes</p>
                    <p class="text-4xl font-extrabold mt-2"><?= $total_mensajes ?></p>
                    <div class="mt-4 flex items-center gap-2 text-[11px] opacity-70">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Contacto
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php if ($total_resets > 0): ?>
    <script>
        new Chart(document.getElementById('chartResets'), {
            type: 'doughnut',
            data: {
                labels: ['Nuevos', 'En progreso', 'Completados'],
                datasets: [{
                    data: [<?= $nuevos ?>, <?= $pendientes ?>, <?= $completados ?>],
                    backgroundColor: ['#f59e0b', '#3b82f6', '#10b981'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 20, font: { family: 'Bricolage Grotesque', weight: 'bold', size: 12 } }
                    }
                }
            }
        });
    </script>
    <?php endif; ?>
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
