<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-usuario') {
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
    <title>Mi Panel - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Bricolage Grotesque', sans-serif; background-color: #f4f9fa; }
    </style>
</head>
<body class="text-[#004e64] min-h-screen">
    <div class="flex">
        <aside class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col gap-8">
            <div class="flex items-center justify-between mt-10 px-2">
                <div>
                    <p class="font-bold text-white text-sm">Mi Panel</p>
                    <p class="text-[10px] text-[#9fffcb] uppercase tracking-widest font-bold">RESET ONG</p>
                </div>
            </div>
            <nav class="flex flex-col gap-2">
                <a href="dashboard.php" class="bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-extrabold">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 36 36"><path d="M32 5H4c-1.1 0-2 .9-2 2v22c0 1.1.9 2 2 2h28c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zM4 29V7h28v22H4z"/><path d="M15.6 15.2l-6 8.7-4-3.5 1-1.2 2.7 2.4 6.3-9.2 6.7 10 6.8-8.9 1.3 1-8.1 10.7z"/></svg>
                    Mi progreso
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-white/10">
                <a href="../../controllers/controller_logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 transition-all text-sm font-bold">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24"><path d="M16 17v-4H9v-2h7V7l5 5-5 5M14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z"/></svg>
                    Cerrar sesión
                </a>
            </div>
        </aside>
        <main class="flex-1 md:ml-64 p-6 md:p-12 w-full">
            <header class="mb-10">
                <h2 class="text-4xl font-extrabold tracking-tight mb-2">Bienvenido, <?= htmlspecialchars($_SESSION['user_nombre']) ?></h2>
                <p class="text-gray-400 text-sm italic">Tu proceso RESET · <?= date('d/m/Y') ?></p>
            </header>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Estado actual</p>
                    <div class="text-5xl font-extrabold text-slate-800">Nuevo</div>
                </div>
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Días en programa</p>
                    <div class="text-5xl font-extrabold text-slate-800">0</div>
                </div>
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Progreso</p>
                    <div class="text-5xl font-extrabold text-slate-800">0%</div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
