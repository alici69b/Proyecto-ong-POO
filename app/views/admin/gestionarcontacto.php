<?php
session_start();
// Datos de ejemplo basados en la FOTO 3
$mensajes = [
    [
        'id' => 1,
        'nombre' => 'Juan Perez',
        'email' => 'juan@email.com',
        'asunto' => 'Consulta sobre voluntariado',
        'mensaje' => 'Hola, me gustaria saber como puedo unirme como voluntario. Tengo experiencia en mentorias educativas.',
        'fecha' => '2026-04-18',
        'inicial' => 'J'
    ],
    [
        'id' => 2,
        'nombre' => 'Elena Sanchez',
        'email' => 'elena@email.com',
        'asunto' => 'Problema con mi cuenta',
        'mensaje' => 'No puedo acceder a mi cuenta de usuario. He intentado restablecer la contrasena pero no me llega el correo.',
        'fecha' => '2026-04-17',
        'inicial' => 'E'
    ]
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Bandeja de entrada - RESET</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Bricolage Grotesque', sans-serif; background-color: #f4f9fa; }
        html, body { max-width: 100%; overflow-x: hidden; }
    </style>
</head>

<body class="text-[#004e64] min-h-screen flex flex-col md:flex-row">

    <button onclick="toggleSidebar()" class="md:hidden fixed top-4 right-4 z-[60] bg-[#004e64] text-white p-3 rounded-xl shadow-lg">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button>

    <aside id="sidebar" class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col gap-8 transition-transform duration-300 transform -translate-x-full md:translate-x-0">
            <div class="flex items-center justify-between mt-10 px-2">
                <div>
                    <p class="font-bold text-white text-sm">Panel Admin</p>
                    <p class="text-[10px] text-[#9fffcb] uppercase tracking-widest font-bold">RESET ONG</p>
                </div>
            </div>

            <nav class="flex flex-col gap-2">
                <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm group">
                    <span><svg fill="currentColor" width="20" height="20" viewBox="0 0 36 36">
                            <path d="M32 5H4c-1.1 0-2 .9-2 2v22c0 1.1.9 2 2 2h28c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zM4 29V7h28v22H4z" />
                            <path d="M15.6 15.2l-6 8.7-4-3.5 1-1.2 2.7 2.4 6.3-9.2 6.7 10 6.8-8.9 1.3 1-8.1 10.7z" />
                        </svg></span>
                    Vista general
                </a>
                <a href="gestionarreset.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm group">
                    <span class="opacity-70"><svg fill="currentColor" width="20" height="20" viewBox="0 0 1920 1920">
                            <path d="M276.9 440.6v565.7c0 422.4 374.2 625.5 674.7 788.7l8 4.3 8.1-4.3c300.5-163.2 674.7-366.3 674.7-788.7V440.6l-682.8-321.7-682.8 321.7z" />
                        </svg></span>
                    Gestionar Resets
                </a>
                <a href="gestionusuarios.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm group">
                    <span><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                        </svg></span>
                    Usuarios
                </a>
                <a href="gestionarhistorias.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm group">
                    <span class="opacity-70"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></span>
                    Historias
                </a>

                <a href="gestionarcontacto.php" class="bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-extrabold">
                    <span class="opacity-70"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></span>
                    Mensajes
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-white/10">
                <a href="../auth/Login.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 transition-all text-sm font-bold">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24">
                        <path d="M16 17v-4H9v-2h7V7l5 5-5 5M14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z" />
                    </svg>
                    Salir
                </a>
            </div>
        </aside>

    <main class="flex-1 transition-all duration-300 md:ml-64 p-4 sm:p-8 lg:p-12">
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight mb-2">Bandeja de entrada</h1>
                <p class="text-slate-500">Bienvenido, Admin RESET</p>
            </div>
            <button onclick="location.reload()" class="w-full sm:w-auto px-6 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-bold hover:shadow-md transition-all active:scale-95">
                Actualizar
            </button>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-[#e0f7fa] p-6 rounded-[2rem] border border-cyan-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-cyan-600 shadow-sm">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
                <div>
                    <p class="text-2xl font-black">3</p>
                    <p class="text-xs font-bold text-cyan-700/60 uppercase tracking-wider">Total mensajes</p>
                </div>
            </div>
            <div class="bg-[#fef3f0] p-6 rounded-[2rem] border border-orange-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-orange-400 shadow-sm">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-2xl font-black">0</p>
                    <p class="text-xs font-bold text-orange-700/60 uppercase tracking-wider">Sin leer</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <?php foreach ($mensajes as $m): ?>
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 hover:shadow-md transition-all group">
                    <div class="flex flex-col md:flex-row md:items-center gap-6">
                        
                        <div class="flex-shrink-0 w-14 h-14 rounded-full bg-slate-100 border-4 border-slate-50 flex items-center justify-center text-xl font-bold text-slate-400 shadow-inner group-hover:scale-105 transition-transform">
                            <?= $m['inicial'] ?>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h2 class="font-bold text-lg text-slate-800"><?= htmlspecialchars($m['nombre']) ?></h2>
                                <span class="text-xs text-slate-300">•</span>
                                <span class="text-sm text-slate-400"><?= htmlspecialchars($m['email']) ?></span>
                            </div>
                            <h3 class="font-extrabold text-[#005f73] text-sm uppercase tracking-wide"><?= htmlspecialchars($m['asunto']) ?></h3>
                            <p class="mt-2 text-slate-500 text-sm leading-relaxed italic opacity-80">
                                "<?= htmlspecialchars($m['mensaje']) ?>"
                            </p>
                            <p class="mt-3 text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">
                                Recibido el <?= date('d/m/Y', strtotime($m['fecha'])) ?>
                            </p>
                        </div>

                        <div class="flex-shrink-0 flex items-center justify-end">
                            <button class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-red-400 hover:bg-red-50 rounded-xl transition-all border border-transparent hover:border-red-100">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>
</body>
</html>