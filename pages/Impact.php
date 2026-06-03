<?php require_once __DIR__ . "/../config.php"; ?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/public/img/Logo_RESET.svg">
    <title>Impactos - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Domine">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bricolage Grotesque">

    <style>
        body { font-family: 'Bricolage Grotesque'; }
        html { scroll-behavior: smooth; }
        @keyframes shimmer { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
        .fade-in { animation: fadeIn 0.5s ease both; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-1 { animation-delay: 0.05s; }
        .fade-in-2 { animation-delay: 0.15s; }
        .fade-in-3 { animation-delay: 0.25s; }
        .fade-in-4 { animation-delay: 0.35s; }
        .fade-in-5 { animation-delay: 0.45s; }
        .fade-in-6 { animation-delay: 0.55s; }
    </style>
</head>

<body class=" bg-[#f4f9fa]" id="inicio">
    <?php require_once __DIR__ . "/../src/components/Header.php"; ?>

    <a href="#inicio" class="fixed bottom-10 right-10 z-[9999] p-3 rounded-full bg-[#25a18e] text-white hover:bg-[#1a7a6b] transition-all shadow-xl flex items-center justify-center border-2 border-white/20" aria-label="Volver al inicio"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </a>

    <main class="fade-in fade-in-1 max-w-7xl mx-auto px-4 py-12 pt-40">
        <div class="flex flex-col">
            <div class="text-center">
                <p class="text-[#00a5cf] font-bold text-sm tracking-[0.2em] uppercase 4 opacity-90">Nuestro impacto</p>
                <h1 class="font-['Domine']  text-slate-800 md:text-6xl lg:text-6xl text-4xl font-bold mb-4">
                    Cada número es una <i class="bg-linear-to-r from-[#00a5cf] to-[#9fffcb] bg-clip-text text-transparent">historia real</i>
                </h1>
                <p class="text-gray-500 max-w-2xl mx-auto  sm:text-lg sm:p-2 lg:text-lg px-7 ">Detrás de cada estadística hay una persona que decidió no rendirse</p>
            </div>

            <div class="fade-in fade-in-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-16 p-4">
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col flex-1 min-h-[250px] p-5 transition-transform transform hover:-translate-y-1 hover:scale-105 hover:shadow-xl hover:bg-[#e0f7f2] duration-300">
                    <div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh bg-[#d6f3ee] text-[#25a18e] w-10 h-10 rounded-lg mt-5"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg></div>
                    <div class="font-semibold text-4xl md:text-5xl mt-5"><?= $totalResets ?></div>
                    <h2 class="font-semibold text-lg mt-5">Resets Iniciados</h2>
                    <p class="font-thin text-gray-600/60">Proyectos y sueños retomados</p>
                </div>

                <div class=" bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col flex-1 min-h-[250px] p-5 transition-transform transform hover:-translate-y-1 hover:scale-105 hover:shadow-xl hover:bg-[#fff4e6] duration-300">
                    <div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check bg-[#f3e0d5] text-[#b96b2a] w-10 h-10 rounded-lg mt-5"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg></div>
                    <div class="font-semibold text-4xl md:text-5xl mt-5"><?= $totalCompletados ?></div>
                    <h2 class="font-semibold text-lg mt-5">Resets Completados</h2>
                    <p class="font-thin text-gray-600/60">Historias de éxito</p>
                </div>

                <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col flex-1 min-h-[250px] p-5 transition-all transform  hover:-translate-y-1 hover:scale-105 hover:shadow-xl hover:bg-[#fffdf0] duration-300">
                    <div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users bg-[#f3f3d5] text-[#b9af2a] w-10 h-10 rounded-lg mt-5"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg></div>
                    <div class="font-semibold text-4xl md:text-5xl mt-5"><?= $totalVoluntarios ?></div>
                    <h2 class="font-semibold text-lg mt-5">Voluntarios Activos</h2>
                    <p class="font-thin text-gray-600/60">Personas que ayudan</p>
                </div>

                <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col flex-1 min-h-[250px] p-5 transition-transform transform hover:-translate-y-1 hover:scale-105 hover:shadow-xl hover:bg-[#e0f7f2] duration-300">
                    <div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up bg-[#d6f3ee] text-[#25a18e] w-10 h-10 rounded-lg mt-5"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg></div>
                    <div class="font-semibold text-4xl md:text-5xl mt-5">95%</div>
                    <h2 class="font-semibold text-lg mt-5">Tasa de Satisfacción</h2>
                    <p class="font-thin text-gray-600/60">De nuestros usuarios</p>
                </div>
            </div>

            <div class="fade-in fade-in-3 grid grid-cols-1 lg:grid-cols-2 gap-6 pt-16 p-4 items-stretch">
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col flex-1 p-7 space-y-5 h-full">
                    <h2 class="font-semibold text-xl">Por categoría</h2>
                    <div class="flex flex-col space-y-6">
                        <?php foreach ($categorias as $cat):
                            $nombre = $cat['nombre_categoria'];
                            $total = (int) $cat['total'];
                            $porcentaje = $maxCat > 0 ? round(($total / $maxCat) * 100) : 0;
                            $label = $catLabels[$nombre] ?? ucfirst($nombre);
                        ?>
                        <div>
                            <div class="flex flex-row items-center space-y-1 justify-between">
                                <div class="flex flex-row space-x-5 items-center">
                                    <div><?= $catIconos[$nombre] ?? $catIconos['otros'] ?></div>
                                    <div class=""><?= $label ?></div>
                                </div>
                                <div class="text-gray-400"><?= $total ?></div>
                            </div>
                            <div class="bg-linear-to-r from-[#00a5cf] to-[#9fffcb] h-6 rounded-full transition-all duration-500" style="width: <?= $porcentaje ?>%;"></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col flex-1 p-7 lg:h-full h-70 justify-between lg:justify-normal lg:space-y-38">
                    <h2 class="font-semibold text-xl">Evolución mensual</h2>
                    <div class="flex flex-row flex-wrap justify-around items-center text-center gap-2">
                        <?php foreach ($evolucion as $e): ?>
                        <div>
                            <span><?= $e['total'] ?></span>
                            <div></div>
                            <span class="text-gray-400"><?= $e['label'] ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class=" fade-in fade-in-4 text-center pt-16 p-4">
                <div class="bg-linear-to-r from-[#00a5cf] to-[#78d4a1] rounded-3xl p-12 text-white shadow-lg flex flex-col md:flex-row justify-between items-center text-center space-y-6 md:space-y-0 md:space-x-10">
                    <div class="flex flex-col space-y-4 items-start justify-start text-start mb-6 md:mb-0">
                        <div class="text-2xl md:text-3xl font-bold">El <?= $tasaExito ?>% de las personas que piden un RESET logran completar su objetivo</div>
                        <div class="text-normal md:text-lg leading-relaxed">Con el apoyo adecuado, la motivación correcta y un plan claro, la mayoría de las personas consiguen retomar aquello que abandonaron.</div>
                    </div>
                    <div class="flex flex-col space-y-1 items-center">
                        <div class="font-semibold md:text-8xl text-6xl"><?= $tasaExito ?>%</div>
                        <div class="font-thin text-normal md:text-lg">Tasa de éxito</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once __DIR__ . "/../src/components/footer.php"; ?>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>
