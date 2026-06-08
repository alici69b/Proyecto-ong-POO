<?php require_once __DIR__ . "/../../config.php"; ?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/public/img/Logo_RESET.svg">
    <title>Donar - RESET</title>
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
        .fade-in-4 { animation-delay: 0.35s; }
    </style>
</head>

<body class="bg-[#f4f9fa]" id="inicio">
    <?php require_once __DIR__ . "/../../src/components/Header.php"; ?>

    <a href="#inicio" class="fixed bottom-10 right-10 z-[9999] p-3 rounded-full bg-[#25a18e] text-white hover:bg-[#1a7a6b] transition-all shadow-xl flex items-center justify-center border-2 border-white/20" aria-label="Volver al inicio">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </a>

    <?php
    // ── Cargar stats para la sección de impacto ──
    $totalDonaciones = 0;
    $totalRecaudado = 0;
    $totalResetsCompletados = 0;
    $totalVoluntarios = 0;
    try {
        require_once __DIR__ . '/../../app/models/Donacion.php';
        require_once __DIR__ . '/../../app/models/Impacto.php';
        $donacionModel = new Donacion();
        $impactoModel = new Impacto();
        $totalDonaciones = $donacionModel->contarCompletadas();
        $totalRecaudado = $donacionModel->totalRecaudado();
        $totalResetsCompletados = $impactoModel->contarCompletados();
        $totalVoluntarios = $impactoModel->contarVoluntarios();
    } catch (Exception $e) {}
    ?>

    <!-- ═══ HERO ═══ -->
    <section class="relative min-h-[70vh] flex items-center pt-40 pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-linear-to-br from-[#004e64] via-[#007a93] to-[#00a5cf]"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, white 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="absolute top-20 right-10 w-72 h-72 bg-[#9fffcb] rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-10 left-10 w-96 h-96 bg-[#25a18e] rounded-full blur-3xl opacity-20"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <!-- Texto izquierda -->
                <div class="fade-in fade-in-1">
                    <p class="text-[#9fffcb] font-bold text-sm tracking-[0.2em] uppercase mb-2">Ayúdanos a ayudar</p>
                    <h1 class="font-['Domine'] text-white text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-4">
                        Tu donación<br>
                        <span class="text-[#9fffcb]">cambia vidas</span>
                    </h1>
                    <p class="text-white/80 text-lg mb-8 max-w-lg">
                        Cada aportación nos permite conectar a más personas que necesitan ayuda con voluntarios dispuestos a darla. 
                        Juntos podemos construir una red solidaria más fuerte.
                    </p>

                    <!-- Mini stats -->
                    <div class="grid grid-cols-3 gap-4 max-w-md">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                            <p class="text-white font-black text-2xl"><?= $totalVoluntarios ?></p>
                            <p class="text-white/60 text-xs font-semibold">Voluntarios</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                            <p class="text-white font-black text-2xl"><?= $totalResetsCompletados ?></p>
                            <p class="text-white/60 text-xs font-semibold">Resets hechos</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center border border-white/10">
                            <p class="text-[#9fffcb] font-black text-2xl"><?= number_format($totalRecaudado, 0, ',', '.') ?>€</p>
                            <p class="text-white/60 text-xs font-semibold">Donado</p>
                        </div>
                    </div>
                </div>

                <!-- Derecha: tarjetas de donación rápida -->
                <div class="fade-in fade-in-2">
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-8 border border-white/20">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">¿Cuánto quieres donar?</h3>
                        <p class="text-gray-400 text-sm mb-6">Elige una cantidad o personalízala</p>

                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-2 mb-6">
                            <?php $cantidades = [5, 10, 25, 50, 100]; ?>
                            <?php foreach ($cantidades as $cant): ?>
                            <button type="button" onclick="seleccionarCantidad(<?= $cant ?>)"
                                class="cantidad-btn py-3 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-600 hover:border-[#25a18e] hover:text-[#25a18e] hover:bg-[#25a18e]/5 transition-all active:scale-95">
                                <?= $cant ?>€
                            </button>
                            <?php endforeach; ?>
                        </div>

                        <?php $errores = $_SESSION['errores_donacion'] ?? []; $old = $_SESSION['old_donacion'] ?? []; $errorGeneral = $_SESSION['error_donacion'] ?? ''; ?>

                        <form method="POST" action="<?= BASE_URL ?>/app/controllers/controller_donacion.php" class="space-y-4">
                            <?php if ($errorGeneral): ?>
                                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                                    <?= htmlspecialchars($errorGeneral) ?>
                                </div>
                            <?php endif; ?>

                            <input type="hidden" name="_csrf" value="<?= generarTokenCSRF() ?>">

                            <div>
                            <input type="number" name="cantidad" id="input-cantidad" min="1" max="500" step="0.01"
                                value="<?= htmlspecialchars($old['cantidad'] ?? '') ?>"
                                placeholder="Otra cantidad..."
                                class="w-full p-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#25a18e] focus:border-[#25a18e] outline-none transition text-center text-xl font-bold">
                            <p class="text-gray-400 text-xs mt-1">Mínimo 1€ · Máximo 500€</p>
                            <?php if (!empty($errores['cantidad'])): ?>
                                <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars(is_array($errores['cantidad']) ? implode(', ', $errores['cantidad']) : $errores['cantidad']) ?></p>
                            <?php endif; ?>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nombre</label>
                                    <input type="text" name="nombre" value="<?= htmlspecialchars($old['nombre'] ?? $_SESSION['user_nombre'] ?? '') ?>" required
                                        class="w-full p-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#25a18e] focus:border-[#25a18e] outline-none transition">
                                    <?php if (!empty($errores['nombre'])): ?>
                                        <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars(is_array($errores['nombre']) ? implode(', ', $errores['nombre']) : $errores['nombre']) ?></p>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Email</label>
                                    <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? $_SESSION['user_email'] ?? '') ?>" required
                                        class="w-full p-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#25a18e] focus:border-[#25a18e] outline-none transition">
                                    <?php if (!empty($errores['email'])): ?>
                                        <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars(is_array($errores['email']) ? implode(', ', $errores['email']) : $errores['email']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Mensaje (opcional)</label>
                                <textarea name="mensaje" rows="2" maxlength="500" placeholder="Unas palabras de apoyo..."
                                    class="w-full p-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#25a18e] focus:border-[#25a18e] outline-none transition resize-none"><?= htmlspecialchars($old['mensaje'] ?? '') ?></textarea>
                            </div>

                            <input type="hidden" name="moneda" value="eur">

                            <button type="submit" name="donar" id="btn-donar"
                                class="w-full py-4 bg-[#25a18e] text-white font-bold text-lg rounded-xl hover:bg-[#1a7a6b] transition-all shadow-lg shadow-[#25a18e]/30 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                                Donar ahora
                            </button>

                            <div class="flex items-center justify-center gap-2 text-xs text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                                </svg>
                                Pago 100% seguro por Stripe
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ SECCIÓN IMPACTO ═══ -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12 fade-in fade-in-3">
                <p class="text-[#00a5cf] font-bold text-sm tracking-[0.2em] uppercase mb-2">Confianza</p>
                <h2 class="font-['Domine'] text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    ¿Por qué <i class="bg-linear-to-r from-[#00a5cf] to-[#9fffcb] bg-clip-text text-transparent">donar</i> a RESET?
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Cada euro se destina a mejorar y ampliar nuestra red de ayudas.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 fade-in fade-in-4">
                <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all border border-gray-100">
                    <div class="w-14 h-14 bg-[#00a5cf]/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-[#00a5cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Transparencia total</h3>
                    <p class="text-gray-500 text-sm">Publicamos cada año un informe detallado de ingresos y gastos para que sepas exactamente cómo se usa tu donación.</p>
                </div>

                <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all border border-gray-100">
                    <div class="w-14 h-14 bg-[#25a18e]/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-[#25a18e]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Impacto inmediato</h3>
                    <p class="text-gray-500 text-sm">Las donaciones nos permiten mantener la plataforma activa y seguir conectando voluntarios con quienes más lo necesitan.</p>
                </div>

                <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all border border-gray-100">
                    <div class="w-14 h-14 bg-[#004e64]/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-[#004e64]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">100% destinado a la causa</h3>
                    <p class="text-gray-500 text-sm">Al ser un proyecto educativo, no hay gastos de estructura. Cada donación se destinta íntegramente a la operativa de la ONG.</p>
                </div>
            </div>

            <!-- Contador donaciones -->
            <?php if ($totalDonaciones > 0): ?>
            <div class="mt-12 text-center fade-in fade-in-4">
                <p class="text-gray-400 text-sm">
                    Ya somos <span class="font-bold text-[#25a18e]"><?= $totalDonaciones ?> donantes</span> que han contribuido con 
                    <span class="font-bold text-[#25a18e]"><?= number_format($totalRecaudado, 2, ',', '.') ?>€</span>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php unset($_SESSION['error_donacion'], $_SESSION['errores_donacion'], $_SESSION['old_donacion']); ?>
    <?php require_once __DIR__ . '/../../src/components/footer.php'; ?>

    <script>
        function seleccionarCantidad(cant) {
            document.getElementById('input-cantidad').value = cant;
            document.querySelectorAll('.cantidad-btn').forEach(btn => {
                btn.classList.remove('border-[#25a18e]', 'text-[#25a18e]', 'bg-[#25a18e]/5');
                btn.classList.add('border-gray-200', 'text-gray-600');
            });
            event.target.classList.remove('border-gray-200', 'text-gray-600');
            event.target.classList.add('border-[#25a18e]', 'text-[#25a18e]', 'bg-[#25a18e]/5');
        }
    </script>
</body>
</html>
