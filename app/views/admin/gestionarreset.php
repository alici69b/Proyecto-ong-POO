<?php
session_start();
include_once "../../controlador/AdminControllers/ManageresetController.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Impactos - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa;
        }

        /* Prevents horizontal scroll on small screens */
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
                <a href="gestionarreset.php" class="bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-extrabold">
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

    <main class="flex-1 transition-all duration-300 md:ml-64 p-4 sm:p-8 lg:p-12">
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight mb-2">Gestionar Resets</h1>
                <p class="text-slate-500">Supervisión de solicitudes activas</p>
            </div>
            <button onclick="location.reload()" class="w-full sm:w-auto px-6 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-bold hover:shadow-md transition-all active:scale-95">
                Actualizar
            </button>
        </header>

        <div class="space-y-4">
            <?php if (empty($resets)): ?>
                <div class="bg-white rounded-3xl p-10 text-center border border-dashed border-slate-300">
                    <p class="text-slate-400">No hay resets registrados actualmente.</p>
                </div>
            <?php endif; ?>

            <?php foreach ($resets as $r): ?>
                <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 shadow-sm border border-slate-100 flex flex-col xl:flex-row xl:items-center justify-between gap-6 hover:shadow-md transition-shadow">

                    <div class="flex items-start gap-4 sm:gap-5">
                        <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-cyan-50 flex items-center justify-center text-xl sm:text-2xl">
                            🌞
                        </div>
                        <div class="min-w-0 flex-1">
                            <h2 class="font-bold text-base sm:text-lg text-slate-800 truncate"><?= htmlspecialchars($r['titulo'] ?? 'Sin título') ?></h2>
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mt-1 text-xs sm:text-sm text-slate-400">
                                <span class="font-semibold text-slate-600"><?= htmlspecialchars($r['solicitante'] ?? 'Anónimo') ?></span>
                                <span class="hidden sm:inline">•</span>
                                <span class="bg-slate-100 px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold uppercase"><?= htmlspecialchars($r['nombre_categoria'] ?? 'General') ?></span>
                                <span class="hidden sm:inline">•</span>
                                <span><?= date('d/m/Y', strtotime($r['fecha'])) ?></span>
                            </div>
                            <p class="mt-2 text-slate-500 text-sm line-clamp-2 sm:line-clamp-1 italic">
                                "<?= htmlspecialchars($r['descripcion']) ?>"
                            </p>
                        </div>
                    </div>

                    <form method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <input type="hidden" name="id_reset" value="<?= $r['id_reset'] ?>">

                        <select name="id_voluntario" class="flex-1 bg-slate-50 border-none text-sm rounded-xl px-4 py-3 ring-1 ring-slate-200 focus:ring-2 focus:ring-cyan-500 outline-none min-w-[140px]">
                            <option value="">Asignar voluntario</option>
                            <?php foreach ($voluntarios as $vol): ?>
                                <option value="<?= $vol['id_voluntario'] ?>" <?= ($r['id_voluntario'] == $vol['id_voluntario']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($vol['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="id_estado" onchange="this.form.submit()" class="flex-1 bg-white border-none text-sm font-bold rounded-xl px-4 py-3 ring-1 ring-slate-200 focus:ring-2 focus:ring-cyan-500 outline-none cursor-pointer min-w-[130px]">
                            <?php foreach ($estados as $est): ?>
                                <option value="<?= $est['id_estado'] ?>" <?= ($r['id_estado'] == $est['id_estado']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($est['nombre_estado']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <input type="hidden" name="actualizar_reset" value="1">
                        <button type="submit" class="bg-[#0a9396] text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-[#005f73] transition shadow-lg shadow-cyan-900/10 active:scale-95">
                            Guardar
                        </button>
                    </form>
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