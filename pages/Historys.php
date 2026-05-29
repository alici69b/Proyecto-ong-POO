<?php require_once __DIR__ . "/../config.php"; ?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/public/img/Logo_RESET.svg">
    <title>Historias - RESET</title>

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

    <main class="fade-in fade-in-1 max-w-7xl mx-auto px-4 py-12 pt-25">
        <div>
            <div class="text-center pt-15 pb-15">
                <p class="text-[#00a5cf] font-bold text-sm tracking-[0.2em] uppercase 4 opacity-90">Historias de reset</p>
                <h1 class="font-['Domine']  text-slate-800 md:text-6xl lg:text-6xl text-4xl font-bold mb-4">
                    El antes y después de no <i class="bg-linear-to-r from-[#00a5cf] to-[#9fffcb] bg-clip-text text-transparent">rendirse</i>
                </h1>
                <p class="text-gray-500 max-w-2xl mx-auto  sm:text-lg sm:p-2 lg:text-lg px-7">Personas reales que decidieron darse otra oportunidad. Lee sus historias y encuentra inspiración para la tuya.</p>
            </div>

            <div class="">
                <?php if (empty($historias)): ?>
                <div class="text-center py-20">
                    <p class="text-gray-400 text-lg">No hay historias publicadas aún. ¡Vuelve pronto!</p>
                </div>
                <?php else: ?>
                <?php foreach ($historias as $index => $h):
                    $reverse = $index % 2 !== 0;
                    $foto = !empty($h['foto']) ? $h['foto'] : 'foto_defecto.webp';
                    $valoracion = (int) ($h['valoracion'] ?? 5);
                ?>
                <div class="top-24 flex flex-col <?= $reverse ? 'lg:flex-row-reverse' : 'lg:flex-row' ?> gap-12 items-center mb-12 transition-all duration-300 bg-white rounded-3xl shadow-2xl p-6 z-<?= ($index + 1) * 10 ?>">
                    <div class="w-full lg:w-auto shrink-0 flex justify-center lg:justify-end">
                        <div class="relative inline-block">
                            <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($h['solicitante']) ?>" class="w-100 h-100 aspect-square object-cover rounded-3xl shadow-medium">
                            <div class="absolute -bottom-4 -right-4 px-4 py-2 rounded-xl text-sm font-medium shadow-lg text-white bg-teal-600">
                                <?= htmlspecialchars($h['nombre_categoria']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col lg:flex-row gap-6">
                        <div class="lg:w-auto p-8 lg:p-12 flex flex-col">
                            <div class="relative mb-8">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-quote text-teal-600 opacity-30">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" /><path d="M18 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" />
                                </svg>
                                <h1 class="text-2xl lg:text-3xl font-bold ml-0"><?= htmlspecialchars($h['titulo']) ?></h1>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div class="bg-red-50 rounded-2xl p-6">
                                    <p class="text-sm font-semibold text-orange-600 mb-2">ANTES</p>
                                    <p class="text-gray-700 text-sm leading-relaxed"><?= htmlspecialchars($h['descripcion_antes'] ?? $h['descripcion']) ?></p>
                                </div>
                                <div class="bg-teal-50 rounded-2xl p-6">
                                    <p class="text-sm font-semibold text-teal-600 mb-2">DESPUÉS</p>
                                    <p class="text-gray-700 text-sm leading-relaxed"><?= htmlspecialchars($h['descripcion_despues'] ?? $h['descripcion']) ?></p>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <div class="flex items-center gap-3">
                                    <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($foto) ?>" class="h-10 w-10 rounded-full object-cover">
                                    <div>
                                        <p class="font-semibold"><?= htmlspecialchars($h['solicitante']) ?></p>
                                        <p class="text-gray-500 text-sm"><?= (int)$h['edad'] ?> años</p>
                                    </div>
                                </div>
                                <div class="h-8 w-px bg-gray-300"></div>
                                <div class="flex items-center gap-1">
                                    <p><span class="text-gray-500">Voluntario:</span><span class="font-medium text-gray-800"> <?= htmlspecialchars($h['nombre_voluntario'] ?? '—') ?></span></p>
                                </div>
                                <div class="h-8 w-px bg-gray-300"></div>
                                <div class="flex items-center gap-1">
                                    <p><span class="text-gray-500">Duración:</span><span class="font-medium text-gray-800"> <?= (int)$h['duracion_meses'] ?> meses</span></p>
                                </div>
                            </div>
                            <div class="flex gap-1 text-yellow-400 ml-auto cursor-pointer">
                                <?php for ($s = 0; $s < $valoracion; $s++): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <?php endfor; ?>
                                <?php for ($s = $valoracion; $s < 5; $s++): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-star text-yellow-400"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1.002l3.086 -6.253l3.086 6.253l6.9 1.002l-5 4.867l1.179 6.873z" /></svg>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="pt-12 text-center relative z-50">
                <div class="bg-linear-to-r from-[#00a5cf] to-[#78d4a1] rounded-3xl p-12 text-white shadow-lg">
                    <h1 class="text-3xl lg:text-4xl font-bold mb-4">Tu historia puede ser la próxima</h1>
                    <p class="text-lg lg:text-xl mb-8 leading-relaxed">Cada una de estas personas estuvo donde tú estás ahora. El primer paso es siempre el más difícil, pero no tienes que darlo solo/a.</p>
                    <a href="<?= BASE_URL ?>/app/controllers/controller_register.php?rol=usuario" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-red-600/80 font-bold rounded-xl shadow-md hover:bg-red-600/80 hover:text-white transition-colors duration-300">
                        Solicitar mi RESET
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-right-dashed"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 12h.5m3 0h1.5m3 0h6" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </main>
    <?php require_once __DIR__ . "/../src/components/footer.php"; ?>
</body>
</html>
