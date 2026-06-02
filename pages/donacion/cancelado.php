<?php require_once __DIR__ . "/../../config.php"; ?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/public/img/Logo_RESET.svg">
    <title>Donación cancelada - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Domine">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bricolage Grotesque">
    <style>
        body { font-family: 'Bricolage Grotesque'; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.5s ease both; }
        .fade-in-1 { animation-delay: 0.05s; }
        .fade-in-2 { animation-delay: 0.15s; }
        .fade-in-3 { animation-delay: 0.25s; }
    </style>
</head>

<body class="bg-[#f4f9fa]" id="inicio">
    <?php require_once __DIR__ . "/../../src/components/Header.php"; ?>

    <a href="#inicio" class="fixed bottom-10 right-10 z-[9999] p-3 rounded-full bg-[#25a18e] text-white hover:bg-[#1a7a6b] transition-all shadow-xl flex items-center justify-center border-2 border-white/20" aria-label="Volver al inicio">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </a>

    <main class="min-h-screen flex items-center justify-center px-4 pt-40 pb-20">
        <div class="text-center max-w-lg fade-in fade-in-1">

            <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
            </div>

            <h1 class="font-['Domine'] text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Donación <i class="bg-linear-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">cancelada</i>
            </h1>

            <p class="text-gray-500 text-lg mb-2">
                No se ha realizado ningún cargo. Si cambias de opinión, estaremos encantados de recibir tu ayuda cuando quieras.
            </p>
            <p class="text-gray-400 text-sm mb-10">
                Cada aportación, por pequeña que sea, marca la diferencia.
            </p>

            <?php if (!empty($error)): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-8 text-sm">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= BASE_URL ?>/app/controllers/controller_donacion.php"
                    class="px-8 py-4 bg-[#25a18e] text-white font-bold rounded-xl hover:bg-[#1a7a6b] transition shadow-lg shadow-[#25a18e]/30">
                    Intentar de nuevo
                </a>
                <a href="<?= BASE_URL ?>/index.php"
                    class="px-8 py-4 border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:border-gray-300 transition">
                    Volver al inicio
                </a>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/../../src/components/footer.php'; ?>
</body>
</html>
