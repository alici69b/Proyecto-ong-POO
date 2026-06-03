<?php require_once __DIR__ . "/../../config.php"; ?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/public/img/Logo_RESET.svg">
    <title>Donación exitosa - RESET</title>
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

            <!-- Icono éxito animado -->
            <div class="w-24 h-24 bg-[#25a18e]/10 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-[#25a18e]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>

            <h1 class="font-['Domine'] text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                ¡Gracias por tu <i class="bg-linear-to-r from-[#00a5cf] to-[#9fffcb] bg-clip-text text-transparent">donación</i>!
            </h1>

            <p class="text-gray-500 text-lg mb-2">
                Tu generosidad nos ayuda a seguir conectando personas que necesitan ayuda con voluntarios dispuestos a darla.
            </p>
            <p class="text-gray-400 text-sm mb-10">
                Recibirás un correo electrónico con el resumen de tu donación.
            </p>

            <div class="bg-white rounded-2xl shadow-lg p-6 mb-10 border border-gray-100 inline-block">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#00a5cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                    </svg>
                    <p class="text-sm text-gray-500">Pago procesado de forma segura por <span class="font-bold text-gray-700">Stripe</span></p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= BASE_URL ?>/index.php"
                    class="px-8 py-4 bg-[#25a18e] text-white font-bold rounded-xl hover:bg-[#1a7a6b] transition shadow-lg shadow-[#25a18e]/30">
                    Volver al inicio
                </a>
                <a href="<?= BASE_URL ?>/app/controllers/controller_impacto.php"
                    class="px-8 py-4 border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:border-gray-300 transition">
                    Ver nuestro impacto
                </a>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/../../src/components/footer.php'; ?>
</body>
</html>
