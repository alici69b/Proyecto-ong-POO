<?php require_once __DIR__ . "/../config.php"; ?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/public/img/Logo_RESET.svg">
    <title><?= $tituloPagina ?? 'Transparencia - RESET' ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Domine">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bricolage Grotesque">
    <style>
        body { font-family: 'Bricolage Grotesque'; }
        html { scroll-behavior: smooth; }
        .fade-in { animation: fadeIn 0.5s ease both; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-[#f4f9fa]" id="inicio">
    <?php require_once __DIR__ . "/../src/components/Header.php"; ?>

    <a href="#inicio" class="fixed bottom-10 right-10 z-[9999] p-3 rounded-full bg-[#25a18e] text-white hover:bg-[#1a7a6b] transition-all shadow-xl flex items-center justify-center border-2 border-white/20" aria-label="Volver al inicio">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </a>

    <main class="fade-in max-w-7xl mx-auto px-4 py-12 pt-40">

        <!-- HERO: Story-driven intro -->
        <div class="text-center mb-16 max-w-4xl mx-auto">
            <p class="text-[#00a5cf] font-bold text-xs md:text-sm tracking-[0.2em] uppercase mb-4 opacity-90">Transparencia</p>
            <h1 class="font-['Domine'] text-slate-800 text-4xl md:text-6xl font-bold mb-6">
                De dónde viene y a dónde va <i class="bg-linear-to-r from-[#00a5cf] to-[#9fffcb] bg-clip-text text-transparent">tu ayuda</i>
            </h1>
            <p class="text-gray-500 text-lg leading-relaxed max-w-3xl mx-auto">
                En RESET creemos que la transparencia no es solo un requisito: es la base de la confianza. 
                Cada donación, cada hora de voluntariado y cada euro tiene un propósito. 
                Aquí te contamos, sin filtros, cómo gestionamos los recursos para ayudar a más personas a reiniciar sus vidas.
            </p>
            <div class="mt-6 flex flex-wrap justify-center gap-4 text-sm text-gray-400">
                <span class="bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg> Actualizado: <?= htmlspecialchars($ultimaActualizacion) ?></span>
                <span class="bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg> Moneda: <?= htmlspecialchars($moneda) ?></span>
                <span class="bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z"/></svg> <?= count($ejercicios) ?> ejercicios</span>
            </div>
        </div>

        <!-- SECTION: Esto hemos conseguido juntos (REAL DB DATA) -->
        <section class="mb-16 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-[#00a5cf] font-bold text-xs md:text-sm tracking-[0.2em] uppercase mb-2 opacity-90">Juntos hemos conseguido</p>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Esto es lo que logramos gracias a ti</h2>
                <p class="text-gray-500 mt-2">Datos reales extraídos de nuestra base de datos</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <div class="bg-white rounded-3xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-b from-[#25a18e]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="text-4xl mb-2 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182"/></svg></div>
                        <div class="text-4xl font-bold text-[#25a18e]"><?= $totalResetsDB ?></div>
                        <div class="text-sm text-gray-500 mt-1">Resets iniciados</div>
                        <p class="text-xs text-gray-400 mt-2">personas que decidieron reiniciar</p>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-b from-[#00a5cf]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="text-4xl mb-2 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 0 0-2.455 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"/></svg></div>
                        <div class="text-4xl font-bold text-[#00a5cf]"><?= $totalCompletadosDB ?></div>
                        <div class="text-sm text-gray-500 mt-1">Completados</div>
                        <p class="text-xs text-gray-400 mt-2">historias con final feliz</p>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-b from-[#ff3b30]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="text-4xl mb-2 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg></div>
                        <div class="text-4xl font-bold text-[#ff3b30]"><?= $totalVoluntariosDB ?></div>
                        <div class="text-sm text-gray-500 mt-1">Voluntarios</div>
                        <p class="text-xs text-gray-400 mt-2">personas que acompañan</p>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-b from-[#004e64]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="text-4xl mb-2 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg></div>
                        <div class="text-4xl font-bold text-[#004e64]"><?= $tasaExitoDB ?>%</div>
                        <div class="text-sm text-gray-500 mt-1">Satisfacción</div>
                        <p class="text-xs text-gray-400 mt-2">tasa de éxito</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- HUMAN CONNECTION: How money becomes impact -->
        <section class="mb-16 max-w-6xl mx-auto">
            <div class="bg-gradient-to-br from-white to-[#f4f9fa] rounded-3xl p-8 md:p-12 shadow-sm border border-slate-100">
                <div class="text-center mb-10">
                    <p class="text-[#00a5cf] font-bold text-xs md:text-sm tracking-[0.2em] uppercase mb-2 opacity-90">Tu ayuda en acción</p>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-800">¿Cómo se traduce cada euro en impacto real?</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto rounded-full bg-[#25a18e]/10 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-[#25a18e]"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 1 0 0 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        </div>
                        <p class="text-3xl font-bold text-[#25a18e]"><?= number_format($costePorReset, 0, ',', '.') ?> €</p>
                        <p class="text-sm text-gray-600 font-semibold mt-1">coste medio por reset</p>
                        <p class="text-xs text-gray-400 mt-2">Cada reset completado requiere acompañamiento, recursos y seguimiento durante meses.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto rounded-full bg-[#00a5cf]/10 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-[#00a5cf]"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/></svg>
                        </div>
                        <p class="text-3xl font-bold text-[#00a5cf]"><?= number_format($personasAlAno, 0, ',', '.') ?></p>
                        <p class="text-sm text-gray-600 font-semibold mt-1">personas ayudadas al año</p>
                        <p class="text-xs text-gray-400 mt-2">De media, acompañamos a esta cantidad de personas cada año en su proceso RESET.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto rounded-full bg-[#ff3b30]/10 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-[#ff3b30]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6m15 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        </div>
                        <p class="text-3xl font-bold text-[#ff3b30]"><?= $ejercicioActual['gastos'][0]['porcentaje'] ?>%</p>
                        <p class="text-sm text-gray-600 font-semibold mt-1">a programas de acompañamiento</p>
                        <p class="text-xs text-gray-400 mt-2">La mayor parte de nuestros gastos va directa a lo que importa: las personas.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CHARTS: Visual financial data -->
        <section class="mb-16 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-[#00a5cf] font-bold text-xs md:text-sm tracking-[0.2em] uppercase mb-2 opacity-90">Los números</p>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Así evolucionan nuestras finanzas</h2>
                <p class="text-gray-500 mt-2">Datos exportados de nuestro sistema ERP interno</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-3 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#25a18e]"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                        <h3 class="text-lg font-bold text-slate-800">Ingresos vs Gastos</h3>
                    </div>
                    <canvas id="chartAnual" height="240"></canvas>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-3 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#00a5cf]"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/></svg>
                        <h3 class="text-lg font-bold text-slate-800">Evolución mensual <?= $anios[0] ?></h3>
                    </div>
                    <canvas id="chartMensual" height="240"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-3 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#25a18e]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        <h3 class="text-lg font-bold text-slate-800">Ingresos <?= $anios[0] ?></h3>
                    </div>
                    <canvas id="chartIngresos" height="240"></canvas>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-3 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#ff3b30]"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/></svg>
                        <h3 class="text-lg font-bold text-slate-800">Gastos <?= $anios[0] ?></h3>
                    </div>
                    <canvas id="chartGastos" height="240"></canvas>
                </div>
            </div>
        </section>

        <!-- CARD: Annual totals -->
        <section class="mb-16 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-[#00a5cf] font-bold text-xs md:text-sm tracking-[0.2em] uppercase mb-2 opacity-90">Resumen global</p>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Balance de los últimos <?= count($ejercicios) ?> años</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-[#25a18e]/5 to-white rounded-3xl p-8 text-center shadow-sm border border-[#25a18e]/10 hover:shadow-lg transition">
                    <div class="text-4xl mb-3 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-[#25a18e]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg></div>
                    <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Ingresos totales</p>
                    <p class="text-4xl font-bold text-[#25a18e]"><?= number_format($totalIngresos, 0, ',', '.') ?> €</p>
                    <p class="text-xs text-gray-400 mt-2">Donaciones, subvenciones, cuotas y eventos</p>
                </div>
                <div class="bg-gradient-to-br from-[#ff3b30]/5 to-white rounded-3xl p-8 text-center shadow-sm border border-[#ff3b30]/10 hover:shadow-lg transition">
                    <div class="text-4xl mb-3 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-[#ff3b30]"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg></div>
                    <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Gastos totales</p>
                    <p class="text-4xl font-bold text-[#ff3b30]"><?= number_format($totalGastos, 0, ',', '.') ?> €</p>
                    <p class="text-xs text-gray-400 mt-2">Programas, personal, administración y marketing</p>
                </div>
                <div class="bg-gradient-to-br from-[#004e64]/5 to-white rounded-3xl p-8 text-center shadow-sm border border-[#004e64]/10 hover:shadow-lg transition">
                    <div class="text-4xl mb-3 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-[#004e64]"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg></div>
                    <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Superávit global</p>
                    <p class="text-4xl font-bold text-[#004e64]"><?= number_format($totalSuperavit, 0, ',', '.') ?> €</p>
                    <p class="text-xs text-gray-400 mt-2">Reinvertido en futuros programas RESET</p>
                </div>
            </div>
        </section>

        <!-- DETAILED TABLE PER YEAR -->
        <section class="mb-16 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-[#00a5cf] font-bold text-xs md:text-sm tracking-[0.2em] uppercase mb-2 opacity-90">Desglose anual</p>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Detalle por ejercicio</h2>
                <p class="text-gray-500 mt-2">Cada año publicamos nuestras cuentas para que puedas ver exactamente dónde va cada euro</p>
            </div>

            <div class="space-y-6">
                <?php foreach ($ejercicios as $ej): ?>
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] px-6 py-4 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white"><?= $ej['año'] ?></h3>
                        <span class="text-white/80 text-sm bg-white/20 px-3 py-1 rounded-full">
                            <?= number_format($ej['superavit'], 0, ',', '.') ?> € de superávit
                        </span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-[#25a18e]/5 rounded-xl p-4 text-center border border-[#25a18e]/10">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block -mt-0.5 align-middle mr-1 text-[#25a18e]"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg> Ingresos</p>
                                <p class="text-2xl font-bold text-[#25a18e]"><?= number_format($ej['ingresos_totales'], 0, ',', '.') ?> €</p>
                            </div>
                            <div class="bg-[#ff3b30]/5 rounded-xl p-4 text-center border border-[#ff3b30]/10">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block -mt-0.5 align-middle mr-1 text-[#ff3b30]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg> Gastos</p>
                                <p class="text-2xl font-bold text-[#ff3b30]"><?= number_format($ej['gastos_totales'], 0, ',', '.') ?> €</p>
                            </div>
                            <div class="bg-[#004e64]/5 rounded-xl p-4 text-center border border-[#004e64]/10">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block -mt-0.5 align-middle mr-1 text-[#004e64]"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg> Superávit</p>
                                <p class="text-2xl font-bold text-[#004e64]"><?= number_format($ej['superavit'], 0, ',', '.') ?> €</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b-2 border-slate-200">
                                        <th class="text-left py-3 px-3 text-gray-500 font-semibold uppercase tracking-wider text-xs">Concepto</th>
                                        <th class="text-right py-3 px-3 text-gray-500 font-semibold uppercase tracking-wider text-xs">Importe</th>
                                        <th class="text-right py-3 px-3 text-gray-500 font-semibold uppercase tracking-wider text-xs">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-[#25a18e]/5">
                                        <td class="py-3 px-3 font-bold text-[#25a18e]" colspan="3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block -mt-0.5 align-middle mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg> INGRESOS</td>
                                    </tr>
                                    <?php foreach ($ej['ingresos'] as $ing): ?>
                                    <tr class="border-b border-slate-50 hover:bg-gray-50 transition">
                                        <td class="py-2.5 px-3 text-gray-700"><?= htmlspecialchars($ing['categoria']) ?></td>
                                        <td class="py-2.5 px-3 text-right font-medium"><?= number_format($ing['monto'], 0, ',', '.') ?> €</td>
                                        <td class="py-2.5 px-3 text-right text-gray-500"><?= number_format($ing['porcentaje'], 1) ?>%</td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr class="bg-[#ff3b30]/5">
                                        <td class="py-3 px-3 font-bold text-[#ff3b30]" colspan="3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block -mt-0.5 align-middle mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/></svg> GASTOS</td>
                                    </tr>
                                    <?php foreach ($ej['gastos'] as $gas): ?>
                                    <tr class="border-b border-slate-50 hover:bg-gray-50 transition">
                                        <td class="py-2.5 px-3 text-gray-700"><?= htmlspecialchars($gas['categoria']) ?></td>
                                        <td class="py-2.5 px-3 text-right font-medium"><?= number_format($gas['monto'], 0, ',', '.') ?> €</td>
                                        <td class="py-2.5 px-3 text-right text-gray-500"><?= number_format($gas['porcentaje'], 1) ?>%</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-slate-50 font-bold">
                                        <td class="py-3 px-3 text-gray-800"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block -mt-0.5 align-middle mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/></svg> TOTAL MOVIMIENTO</td>
                                        <td class="py-3 px-3 text-right"><?= number_format($ej['ingresos_totales'] + $ej['gastos_totales'], 0, ',', '.') ?> €</td>
                                        <td class="py-3 px-3 text-right">100%</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- PLEDGE: Our commitment -->
        <section class="mb-16 max-w-4xl mx-auto">
            <div class="bg-gradient-to-br from-[#004e64] to-[#00a5cf] rounded-3xl p-8 md:p-12 text-center text-white shadow-xl">
                <div class="text-5xl mb-6 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg></div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4 font-['Domine']">Nuestro compromiso</h2>
                <p class="text-white/80 text-lg leading-relaxed max-w-2xl mx-auto mb-6">
                    En RESET nos comprometemos a publicar anualmente nuestras cuentas de forma clara y accesible. 
                    Cada socio, voluntario y donante tiene derecho a saber cómo se gestionan los recursos.
                </p>
                <div class="flex flex-wrap justify-center gap-3 text-sm">
                    <span class="bg-white/20 px-4 py-2 rounded-full backdrop-blur-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block -mt-0.5 align-middle mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg> Informes anuales</span>
                    <span class="bg-white/20 px-4 py-2 rounded-full backdrop-blur-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block -mt-0.5 align-middle mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg> Auditoría externa</span>
                    <span class="bg-white/20 px-4 py-2 rounded-full backdrop-blur-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block -mt-0.5 align-middle mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg> Canales abiertos</span>
                    <span class="bg-white/20 px-4 py-2 rounded-full backdrop-blur-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block -mt-0.5 align-middle mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg> Datos en abierto</span>
                </div>
            </div>
        </section>

        <!-- FOOTER NOTE -->
        <section class="text-center pb-8 max-w-6xl mx-auto">
            <div class="bg-gradient-to-r from-[#f4f9fa] to-white rounded-3xl p-8 border border-slate-100">
                <p class="text-xs text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block -mt-0.5 align-middle mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg> Datos financieros exportados desde sistema ERP externo (formato JSON) · 
                    Los datos de impacto provienen de la base de datos de RESET ·
                    Fichero fuente: <code class="bg-gray-100 px-2 py-0.5 rounded text-[#00a5cf]">public/data/erp_financiero.json</code>
                </p>
            </div>
        </section>

    </main>

    <?php require_once __DIR__ . "/../src/components/footer.php"; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colores = ['#25a18e', '#00a5cf', '#ff3b30', '#004e64', '#9fffcb', '#7ae582'];

    new Chart(document.getElementById('chartAnual'), {
        type: 'bar',
        data: {
            labels: [<?= '"' . implode('","', $anios) . '"' ?>],
            datasets: [
                { label: 'Ingresos', data: [<?= implode(',', $ingresosPorAnio) ?>], backgroundColor: '#25a18e', borderRadius: 8 },
                { label: 'Gastos', data: [<?= implode(',', $gastosPorAnio) ?>], backgroundColor: '#ff3b30', borderRadius: 8 }
            ]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true, ticks: { callback: v => v.toLocaleString('es') + ' €' } } } }
    });

    new Chart(document.getElementById('chartMensual'), {
        type: 'line',
        data: {
            labels: [<?php foreach ($ejercicioActual['evolucion_mensual'] as $m): ?>"<?= $m['mes'] ?>",<?php endforeach; ?>],
            datasets: [
                { label: 'Ingresos', data: [<?php foreach ($ejercicioActual['evolucion_mensual'] as $m): ?><?= $m['ingresos'] ?>,<?php endforeach; ?>], borderColor: '#25a18e', backgroundColor: 'rgba(37,161,142,0.1)', fill: true, tension: 0.4 },
                { label: 'Gastos', data: [<?php foreach ($ejercicioActual['evolucion_mensual'] as $m): ?><?= $m['gastos'] ?>,<?php endforeach; ?>], borderColor: '#ff3b30', backgroundColor: 'rgba(255,59,48,0.1)', fill: true, tension: 0.4 }
            ]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true, ticks: { callback: v => v.toLocaleString('es') + ' €' } } } }
    });

    new Chart(document.getElementById('chartIngresos'), {
        type: 'doughnut',
        data: {
            labels: [<?php foreach ($ejercicioActual['ingresos'] as $ing): ?>"<?= $ing['categoria'] ?>",<?php endforeach; ?>],
            datasets: [{ data: [<?php foreach ($ejercicioActual['ingresos'] as $ing): ?><?= $ing['monto'] ?>,<?php endforeach; ?>], backgroundColor: colores }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 12 } } } }
    });

    new Chart(document.getElementById('chartGastos'), {
        type: 'doughnut',
        data: {
            labels: [<?php foreach ($ejercicioActual['gastos'] as $gas): ?>"<?= $gas['categoria'] ?>",<?php endforeach; ?>],
            datasets: [{ data: [<?php foreach ($ejercicioActual['gastos'] as $gas): ?><?= $gas['monto'] ?>,<?php endforeach; ?>], backgroundColor: colores }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 12 } } } }
    });
});
</script>
</body>
</html>