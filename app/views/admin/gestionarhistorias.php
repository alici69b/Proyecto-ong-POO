<?php
session_start();

//simulacion de historias, solo falta conectarlo con la bbdd
$historias = [
    [
        'id_historia' => 1,
        'titulo' => 'De abandonar Medicina a ser cirujana',
        'solicitante' => 'Elena M.', 
        'nombre_categoria' => 'Estudios',
        'fecha' => '2026-04-21 12:00:00',
        'descripcion' => 'Una historia increíble de superación y cambio de rumbo profesional.', 
        'estado' => 'Publicada',
        'icono' => '📚'
    ],
    [
        'id_historia' => 2,
        'titulo' => 'Un sueño congelado que volvió a arder',
        'solicitante' => 'Javier R.',
        'nombre_categoria' => 'Proyecto',
        'fecha' => '2026-04-21 12:00:00',
        'descripcion' => 'Cómo retomar una pasión estancada y convertirla en realidad.',
        'estado' => 'Publicada',
        'icono' => '💡'
    ],
    [
        'id_historia' => 3,
        'titulo' => 'Correr otra vez después de 5 años',
        'solicitante' => 'Carmen S.',
        'nombre_categoria' => 'Hábitos',
        'fecha' => '2026-04-21 12:00:00',
        'descripcion' => 'El camino de vuelta a la salud física y la disciplina deportiva.',
        'estado' => 'Publicada',
        'icono' => '👟'
    ]
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Gestión de Historias - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa; 
        }

      
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }
    </style>
</head>

<body class="text-[#004e64] min-h-screen flex flex-col md:flex-row">

    <button onclick="toggleSidebar()" class="md:hidden fixed top-4 right-4 z-[60] bg-[#004e64] text-white p-3 rounded-xl shadow-lg">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
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
                <a href="gestionarhistorias.php" class="bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-extrabold">
                    <span class="opacity-70"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></span>
                    Historias
                </a>

                <a href="gestionarcontacto.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm group">
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

    <main class="flex-1 transition-all duration-300 md:ml-64 p-4 sm:p-8 lg:p-12 mt-3px">
        
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight mb-2">Gestión de Historias</h1>
                <p class="text-slate-500">Publica historias de éxito para inspirar a otros</p>
            </div>
            <button class="flex-1 lg:flex-none px-6 py-3 bg-[#25a18e] text-white rounded-2xl text-sm font-bold shadow-lg shadow-[#25a18e]/30 hover:bg-[#1e8575] transition-all active:scale-95">+ Nueva Historia</button>
        </header>

        <div class="space-y-4">
            <?php if (empty($historias)): ?>
                <div class="bg-white rounded-3xl p-10 text-center border border-dashed border-slate-300">
                    <p class="text-slate-400">No hay historias publicadas actualmente.</p>
                </div>
            <?php endif; ?>

            <?php foreach ($historias as $h): ?>
                <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 shadow-sm border border-slate-100 flex flex-col xl:flex-row xl:items-center justify-between gap-6 hover:shadow-md transition-shadow">

                    <div class="flex items-start gap-4 sm:gap-5 flex-1 min-w-0">
                        <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-cyan-50 flex items-center justify-center text-xl sm:text-2xl shadow-inner">
                            <?= htmlspecialchars($h['icono'] ?? '📝') ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h2 class="font-bold text-base sm:text-lg text-slate-800 truncate"><?= htmlspecialchars($h['titulo'] ?? 'Sin título') ?></h2>
                            
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mt-1 text-xs sm:text-sm text-slate-400">
                                <span class="font-semibold text-slate-600"><?= htmlspecialchars($h['solicitante'] ?? 'Anónimo') ?></span>
                                <span class="hidden sm:inline opacity-50">•</span>
                                <span class="bg-slate-100 px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-slate-600"><?= htmlspecialchars($h['nombre_categoria'] ?? 'General') ?></span>
                                <span class="hidden sm:inline opacity-50">•</span>
                                <span><?= date('d/m/Y', strtotime($h['fecha'])) ?></span>
                            </div>
                            
                            <p class="mt-2 text-slate-500 text-sm line-clamp-2 sm:line-clamp-1 italic opacity-80">
                                "<?= htmlspecialchars($h['descripcion']) ?>"
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-row items-center justify-end gap-3 sm:gap-4 flex-shrink-0">
                        
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-100">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            <?= htmlspecialchars($h['estado']) ?>
                        </span>

                        <div class="flex items-center gap-2 text-slate-400 border-l border-slate-100 pl-3 sm:pl-4">
                            <button title="Editar historia" class="p-2 rounded-lg hover:bg-slate-100 hover:text-[#00a5cf] transition">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path></svg>
                            </button>
                            <button title="Eliminar historia" class="p-2 rounded-lg hover:bg-red-50 hover:text-red-600 transition">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
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