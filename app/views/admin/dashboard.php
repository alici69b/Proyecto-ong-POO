
<?php
include_once "../../controlador/AdminControllers/AdminController.php";
include_once "../../controlador/AdminControllers/RecentActivityController.php";
// Asumiendo que $conexion es tu variable de conexión a la base de datos
$listaActividad = obtenerActividadReciente($conexion, 6);

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
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>

<body class="text-[#004e64] min-h-screen">
    <div class="flex">
        <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden"></div>

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
                <a href="dashboard.php" class="bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-extrabold">
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

        <main class="flex-1 md:ml-64 p-6 md:p-12 w-full transition-all mt-3px">
            <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-10">
                <div>
                    <h2 class="text-4xl font-extrabold tracking-tight mb-2">Vista General</h2>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#7ae582] animate-pulse"></span>
                        <p class="text-gray-400 text-sm italic">Sincronizado: <?php echo date('H:i'); ?>hs</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                    <button onclick="location.reload()" class="flex-1 lg:flex-none px-6 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-bold hover:shadow-md transition-all active:scale-95">Actualizar</button>

                </div>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-[2.5rem] -mr-4 -mt-4 bg-purple-50 group-hover:bg-purple-100 transition-colors"></div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Usuarios</p>
                    <div class="text-5xl font-extrabold text-slate-800"><?php echo $usuarios_totales ?? 0 ?></div>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-[2.5rem] -mr-4 -mt-4 bg-yellow-50 group-hover:bg-yellow-100 transition-colors"></div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Pendientes</p>
                    <div class="text-5xl font-extrabold text-slate-800"><?php echo $total_usuarios_pendientes_resets ?? 0 ?></div>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-[2.5rem] -mr-4 -mt-4 bg-green-50 group-hover:bg-green-100 transition-colors"></div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Completados</p>
                    <div class="text-5xl font-extrabold text-slate-800"><?php echo $total_usuarios_Completado_resets ?? 0 ?></div>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-20 h-20 rounded-bl-[2.5rem] -mr-4 -mt-4 bg-blue-50 group-hover:bg-blue-100 transition-colors"></div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Voluntarios</p>
                    <div class="text-5xl font-extrabold text-slate-800"><?php echo $total_usuarios_voluntarios ?? 0 ?></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 ">
                <div class=" bg-white rounded-[3rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-6 md:p-10">
                    <div class="flex items-center gap-2 mb-8">
                        <div class="w-8 h-8 bg-teal-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <span class="text-slate-700 font-extrabold">Rendimiento RESETs</span>
                    </div>

                    <?php if (($total_usuarios_Nuevo_resets ?? 0) <= 0 && ($total_usuarios_pendientes_resets ?? 0) <= 0): ?>
                        <div class="flex flex-col items-center justify-center h-64 rounded-[2rem] bg-slate-50 p-8 text-center">
                            <h3 class="text-slate-400 font-bold">No hay datos suficientes para la gráfica</h3>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center h-64 mb-8 ">
                            <canvas id="miGrafico"></canvas>
                        </div> 
                    <?php endif; ?>
                </div>

                <div class="bg-white rounded-[3rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8 md:p-10">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-slate-700 font-extrabold flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#00a5cf] rounded-full animate-pulse"></span>
                            Actividad Reciente
                        </h2>
                        <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded-full font-bold uppercase">En vivo</span>
                    </div>

                    <div class="space-y-6 relative">
                        <div class="absolute left-6 top-0 bottom-0 w-px bg-slate-100 hidden sm:block"></div>

                        <?php foreach ($listaActividad as $act): ?>
                            <div class="flex items-start gap-4 relative group">
                                <div class="z-10 w-10 h-10 shrink-0 rounded-2xl flex items-center justify-center transition-all group-hover:scale-110 ">
                                    <?php echo $act['svg']; ?>
                                </div>

                                <div class="flex-1 min-w-0 pt-1">
                                    <div class="flex justify-between items-baseline gap-2">
                                        <h4 class="text-sm font-bold text-slate-800 truncate">
                                            <?php echo htmlspecialchars($act['titulo']); ?>
                                        </h4>
                                        <span class="text-[10px] font-bold text-slate-400 whitespace-nowrap">
                                            <?php echo $act['tiempo']; ?>
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 line-clamp-1 italic">
                                        <?php echo htmlspecialchars($act['detalle']); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    
                </div>
            </div>
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

        // Configuración Chart.js
        const ctx = document.getElementById('miGrafico').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Nuevos', 'En proceso', 'Éxito'],
            datasets: [{
                label: 'Cantidad de Resets',
                data: [
                    <?php echo $total_usuarios_Nuevo_resets ?? 0 ?>,
                    <?php echo $total_usuarios_pendientes_resets ?? 0 ?>,
                    <?php echo $total_usuarios_Completado_resets ?? 0 ?>
                ],
                // Colores al estilo Chart.js (Fondo suave, borde fuerte)
                backgroundColor: [
                    'rgba(96, 165, 250, 0.2)', // Azul
                    'rgba(74, 222, 128, 0.2)', // Verde
                    'rgba(45, 212, 191, 0.2)'  // Teal
                ],
                borderColor: [
                    'rgb(96, 165, 250)',
                    'rgb(74, 222, 128)',
                    'rgb(45, 212, 191)'
                ],
                borderWidth: 1,
                borderRadius: 8 // Bordes ligeramente redondeados en las barras
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)' // Líneas de fondo muy suaves
                    },
                    ticks: {
                        font: { family: 'Bricolage Grotesque', weight: 'bold' }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Bricolage Grotesque', weight: 'bold' }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false // Ocultamos la leyenda para que se vea más limpio
                }
            }
        }
    });
    </script>
</body>

</html>
