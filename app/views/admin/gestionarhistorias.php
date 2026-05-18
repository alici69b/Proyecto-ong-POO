<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'admin') {
    header('Location: ../auth/Login.php');
    exit();
}

/** @var array $historias - Variable definida en el controlador (controller_admin_gestionarhistorias.php, línea 6) */
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
    <aside class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col">
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
            <a href="/Proyecto-ong-POO/app/controllers/controller_admin_gestionarhistorias.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-bold text-sm shadow-lg">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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

    <main class="flex-1 ml-64 p-8">
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">Gestión de Historias</h1>
                <p class="text-slate-500"><?= count($historias) ?> historias de éxito para inspirar</p>
            </div>
            <button class="px-6 py-2.5 bg-[#25a18e] text-white rounded-xl text-sm font-bold shadow-lg hover:bg-[#1e8575] transition-all active:scale-95 flex items-center gap-2">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>
                Nueva Historia
            </button>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-[#e0f7fa] p-6 rounded-2xl border border-cyan-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-cyan-600 shadow-sm">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <p class="text-3xl font-black"><?= count($historias) ?></p>
                    <p class="text-xs font-bold text-cyan-700/60 uppercase tracking-wider">Total historias</p>
                </div>
            </div>
            <div class="bg-[#fef3f0] p-6 rounded-2xl border border-orange-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-orange-400 shadow-sm">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-3xl font-black"><?= count(array_filter($historias, fn($h) => $h['estado'] === 'Borrador')) ?></p>
                    <p class="text-xs font-bold text-orange-700/60 uppercase tracking-wider">Borradores</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <?php foreach ($historias as $h): ?>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col xl:flex-row xl:items-center justify-between gap-6 hover:shadow-md transition-all">
                    <div class="flex items-start gap-4 flex-1 min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-cyan-50 flex items-center justify-center text-xl flex-shrink-0"><?= $h['icono'] ?></div>
                        <div class="min-w-0 flex-1">
                            <h2 class="font-bold text-lg text-slate-800 truncate"><?= htmlspecialchars($h['titulo']) ?></h2>
                            <div class="flex flex-wrap items-center gap-2 mt-1 text-sm text-slate-400">
                                <span class="font-semibold text-slate-600"><?= htmlspecialchars($h['solicitante']) ?></span>
                                <span class="opacity-50">•</span>
                                <span class="bg-slate-100 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase"><?= htmlspecialchars($h['nombre_categoria']) ?></span>
                                <span class="opacity-50">•</span>
                                <span><?= date('d/m/Y', strtotime($h['fecha'])) ?></span>
                            </div>
                            <p class="mt-2 text-slate-500 text-sm line-clamp-2 italic">"<?= htmlspecialchars($h['descripcion']) ?>"</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 flex-shrink-0">
                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold <?= $h['estado'] === 'Publicada' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100' : 'bg-amber-50 text-amber-700 ring-1 ring-amber-100' ?>">
                            <span class="h-1.5 w-1.5 rounded-full <?= $h['estado'] === 'Publicada' ? 'bg-emerald-500' : 'bg-amber-500' ?>"></span>
                            <?= $h['estado'] ?>
                        </span>
                        <div class="flex items-center gap-1 text-slate-400 border-l border-slate-100 pl-4">
                            <button title="Editar" class="p-2 rounded-lg hover:bg-slate-100 hover:text-[#00a5cf] transition">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                            </button>
                            <button title="Eliminar" class="p-2 rounded-lg hover:bg-red-50 hover:text-red-600 transition">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
