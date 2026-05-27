<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-voluntario') {
    header('Location: ../auth/Login.php');
    exit();
}

$reset       = $reset       ?? [];
$comentarios = $comentarios ?? [];
$flash       = $flash       ?? null;

$activo = isset($reset['id_estado']) && (int)$reset['id_estado'] === 2;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Detalle Reset - RESET ONG</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa;
        }
    </style>
</head>
<!-- Modal de confirmación -->
<div id="modal-confirmar" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl">
        <h4 class="text-lg font-extrabold mb-2" id="modal-titulo">¿Estás seguro?</h4>
        <p class="text-sm text-slate-500 mb-6" id="modal-texto">Esta acción no se puede deshacer.</p>
        <div class="flex gap-3">
            <button onclick="cerrarModal()"
                class="flex-1 border border-slate-200 text-slate-600 font-bold text-sm py-3 rounded-2xl hover:bg-slate-50 transition-all">
                Cancelar
            </button>
            <button onclick="confirmarAccion()"
                id="modal-btn-confirmar"
                class="flex-1 font-extrabold text-sm py-3 rounded-2xl transition-all">
                Confirmar
            </button>
        </div>
    </div>
</div>

<body class="text-[#004e64] min-h-screen">
    <div class="flex">

        <!-- ── Sidebar ── -->
        <aside class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col gap-8">
            <div class="mt-10 px-2">
                <p class="font-bold text-white text-sm">Panel Voluntario</p>
                <p class="text-[10px] text-[#9fffcb] uppercase tracking-widest font-bold">RESET ONG</p>
            </div>
            <nav class="flex flex-col gap-2">
                <a href="/Proyecto-ong-POO/app/controllers/controller_volunteer_dashboard.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm font-bold">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                    </svg>
                    Volver al panel
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-white/10">
                <a href="/Proyecto-ong-POO/app/controllers/controller_logout.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 transition-all text-sm font-bold">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24">
                        <path d="M16 17v-4H9v-2h7V7l5 5-5 5M14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z" />
                    </svg>
                    Cerrar sesión
                </a>
            </div>
        </aside>

        <!-- ── Contenido ── -->
        <main class="flex-1 md:ml-64 p-6 md:p-12 w-full max-w-4xl">

            <!-- Flash -->
            <?php if ($flash): ?>
                <div class="mb-6 px-5 py-4 rounded-2xl text-sm font-bold
                <?= $flash['tipo'] === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' ?>">
                    <?= htmlspecialchars($flash['msg']) ?>
                </div>
            <?php endif; ?>

            <!-- Cabecera del reset -->
            <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <h2 class="text-3xl font-extrabold leading-snug">
                        <?= htmlspecialchars($reset['titulo'] ?? '') ?>
                    </h2>
                    <?php
                    $badgeClass = match ((int)($reset['id_estado'] ?? 0)) {
                        2 => 'bg-blue-50 text-blue-700',
                        3 => 'bg-green-50 text-green-700',
                        4 => 'bg-red-50 text-red-700',
                        default => 'bg-slate-100 text-slate-500',
                    };
                    ?>
                    <span class="shrink-0 text-xs font-bold px-3 py-1 rounded-full <?= $badgeClass ?>">
                        <?= htmlspecialchars($reset['nombre_estado'] ?? '') ?>
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-600 mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Categoría</p>
                        <p class="font-bold"><?= htmlspecialchars($reset['nombre_categoria'] ?? '—') ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Contacto</p>
                        <p class="font-bold"><?= htmlspecialchars($reset['nombre_contacto'] ?? '—') ?></p>
                    </div>
                    <?php if (!empty($reset['email_contacto'])): ?>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Email</p>
                            <a href="mailto:<?= htmlspecialchars($reset['email_contacto']) ?>"
                                class="font-bold text-[#00a5cf] hover:underline">
                                <?= htmlspecialchars($reset['email_contacto']) ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Fecha</p>
                        <p class="font-bold"><?= date('d/m/Y', strtotime($reset['created_at'])) ?></p>
                    </div>
                </div>

                <?php if (!empty($reset['descripcion'])): ?>
                    <div class="mb-3">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Descripción</p>
                        <p class="text-sm text-slate-600 leading-relaxed"><?= nl2br(htmlspecialchars($reset['descripcion'])) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($reset['causa_abandono'])): ?>
                    <div class="mb-3">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Causa del abandono</p>
                        <p class="text-sm text-slate-600 leading-relaxed"><?= nl2br(htmlspecialchars($reset['causa_abandono'])) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($reset['necesidades_reset'])): ?>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Necesidades</p>
                        <p class="text-sm text-slate-600 leading-relaxed"><?= nl2br(htmlspecialchars($reset['necesidades_reset'])) ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ── Gestión de estado (solo si está activo) ── -->
            <?php if ($activo): ?>
                <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
                    <h3 class="text-lg font-extrabold mb-4">Cerrar este reset</h3>
                    <p class="text-sm text-slate-500 mb-5">Añade una nota de cierre (opcional) y elige la acción.</p>

                    <form method="POST"
                        action="/Proyecto-ong-POO/app/controllers/controller_reset_detalle.php?id=<?= $reset['id'] ?>">
                        <textarea name="nota_cierre"
                            rows="3"
                            placeholder="Escribe una nota de cierre... (opcional)"
                            class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 mb-4 resize-none focus:outline-none focus:ring-2 focus:ring-[#00a5cf]"></textarea>

                        <div class="flex gap-3">
                            <button type="button"
                                onclick="abrirModal(this.closest('form'), 'finalizar')"
                                class="flex-1 bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl hover:opacity-90 transition-all">
                                Finalizar
                            </button>
                            <button type="button"
                                onclick="abrirModal(this.closest('form'), 'cancelar')"
                                class="flex-1 bg-red-50 text-red-600 border border-red-200 font-extrabold text-sm py-3 rounded-2xl hover:bg-red-100 transition-all">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            <?php elseif ((int)($reset['id_estado'] ?? 0) === 3 || (int)($reset['id_estado'] ?? 0) === 4): ?>
                <!-- Bloque reactivar -->
                <div class="bg-slate-50 rounded-3xl border border-slate-200 p-8 mb-6">
                    <h3 class="text-lg font-extrabold mb-2 text-slate-500">Este reset está cerrado</h3>
                    <p class="text-sm text-slate-400 mb-5">Puedes reactivarlo si necesitas retomar el caso.</p>
                    <form method="POST"
                        action="/Proyecto-ong-POO/app/controllers/controller_reset_detalle.php?id=<?= $reset['id'] ?>">
                        <input type="hidden" name="action" value="reactivar">
                        <button type="submit"
                            onclick="return confirm('¿Reactivar este reset?')"
                            class="w-full border-2 border-slate-300 text-slate-500 font-extrabold text-sm py-3 rounded-2xl hover:border-[#00a5cf] hover:text-[#00a5cf] transition-all">
                            Reactivar reset
                        </button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- ── Hilo de comentarios ── -->
            <div class="bg-white rounded-3xl border border-slate-100 p-8">
                <h3 class="text-lg font-extrabold mb-6">
                    Seguimiento
                    <span class="text-slate-400 font-bold text-sm ml-2">(<?= count($comentarios) ?>)</span>
                </h3>

                <!-- Lista de comentarios -->
                <?php if (empty($comentarios)): ?>
                    <p class="text-sm text-slate-400 text-center py-6">Todavía no hay notas en este caso.</p>
                <?php else: ?>
                    <div class="flex flex-col gap-4 mb-8">
                        <?php foreach ($comentarios as $c): ?>
                            <div class="flex gap-3">
                                <!-- Avatar -->
                                <div class="shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-[#00a5cf] to-[#9fffcb] flex items-center justify-center text-[#004e64] font-extrabold text-xs">
                                    <?= strtoupper(substr($c['nombre_usuario'] ?? 'V', 0, 1)) ?>
                                </div>
                                <!-- Burbuja -->
                                <div class="flex-1 bg-slate-50 rounded-2xl px-4 py-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-extrabold text-[#004e64]">
                                            <?= htmlspecialchars($c['nombre_usuario'] ?? 'Voluntario') ?>
                                            <?php if ($c['es_voluntario']): ?>
                                                <span class="ml-1 text-[10px] bg-[#004e64] text-white px-2 py-0.5 rounded-full">voluntario</span>
                                            <?php endif; ?>
                                        </span>
                                        <span class="text-[10px] text-slate-400">
                                            <?= date('d/m/Y H:i', strtotime($c['created_at'])) ?>
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-600 leading-relaxed">
                                        <?= nl2br(htmlspecialchars($c['texto'])) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario nuevo comentario (solo si el reset no está cerrado) -->
                <?php if ((int)($reset['id_estado'] ?? 0) !== 4): ?>
                    <form method="POST"
                        action="/Proyecto-ong-POO/app/controllers/controller_reset_detalle.php?id=<?= $reset['id'] ?>">
                        <input type="hidden" name="action" value="comentar">
                        <textarea name="texto"
                            rows="3"
                            placeholder="Añade una nota de seguimiento..."
                            class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 mb-3 resize-none focus:outline-none focus:ring-2 focus:ring-[#00a5cf]"></textarea>
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl hover:opacity-90 transition-all">
                            Añadir nota
                        </button>
                    </form>
                <?php else: ?>
                    <p class="text-xs text-center text-slate-400 mt-4">Este reset está cancelado y no admite más comentarios.</p>
                <?php endif; ?>
            </div>

        </main>
    </div>
    <!-- Scripts -->
    <script>
        let modalForm = null;
        let modalAccion = null;

        function abrirModal(form, accion) {
            modalForm = form;
            modalAccion = accion;

            const titulo = document.getElementById('modal-titulo');
            const texto = document.getElementById('modal-texto');
            const btn = document.getElementById('modal-btn-confirmar');

            if (accion === 'finalizar') {
                titulo.textContent = '¿Finalizar este reset?';
                texto.textContent = 'Se marcará como resuelto y no podrás cambiar el estado.';
                btn.className = 'flex-1 bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl';
                btn.textContent = 'Sí, finalizar';
            } else {
                titulo.textContent = '¿Cancelar este reset?';
                texto.textContent = 'Se marcará como cancelado.';
                btn.className = 'flex-1 bg-red-500 text-white font-extrabold text-sm py-3 rounded-2xl';
                btn.textContent = 'Sí, cancelar';
            }

            document.getElementById('modal-confirmar').classList.remove('hidden');
        }

        function confirmarAccion() {
            if (modalForm && modalAccion) {
                // Inyectamos el campo action que antes iba en el botón
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'action';
                input.value = modalAccion;
                modalForm.appendChild(input);
                modalForm.submit();
            }
        }

        function cerrarModal() {
            document.getElementById('modal-confirmar').classList.add('hidden');
            modalForm = null;
            modalAccion = null;
        }
    </script>
</body>

</html>