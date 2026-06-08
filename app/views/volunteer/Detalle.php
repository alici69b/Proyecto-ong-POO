<?php
require_once __DIR__ . "/../../../config.php";
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
        body { font-family: 'Bricolage Grotesque', sans-serif; background-color: #f4f9fa; }
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
            <button onclick="confirmarAccion()" id="modal-btn-confirmar"
                class="flex-1 font-extrabold text-sm py-3 rounded-2xl transition-all">
                Confirmar
            </button>
        </div>
    </div>
</div>
<body class="text-[#004e64] min-h-screen">

    <!-- Overlay móvil -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col gap-8 -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="mt-6 px-2">
            <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-2 hover:opacity-80 transition group mb-4">
                <svg fill="#ff3b30" class="w-6 h-6 transition-transform group-hover:rotate-12" viewBox="0 0 612.00 612.00">
                    <path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z"></path>
                    <path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z"></path>
                </svg>
                <h3 class="font-black text-lg tracking-tighter text-white">RESET</h3>
            </a>
        </div>
        <div class="flex items-center gap-3 mb-4 px-2">
            <?php if (!empty($_SESSION['foto_perfil'])): ?>
                <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($_SESSION['foto_perfil']) ?>" class="w-9 h-9 rounded-full object-cover border-2 border-white/30">
            <?php else: ?>
                <div class="w-9 h-9 bg-[#00a5cf] rounded-full flex items-center justify-center text-white font-bold text-sm">
                    <?= strtoupper(substr($_SESSION['user_nombre'] ?? 'A', 0, 1)) ?>
                </div>
            <?php endif; ?>
            <div class="text-xs">
                <p class="text-white font-bold truncate"><?= htmlspecialchars($_SESSION['user_nombre']) ?></p>
                <p class="text-[#9fffcb] text-[10px]">Voluntario</p>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-white/60 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <nav class="flex flex-col gap-2">
            <a href="<?= BASE_URL ?>/app/controllers/controller_volunteer_dashboard.php"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm font-bold">
                <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                </svg>
                Volver al panel
            </a>
        </nav>
        <div class="mt-auto pt-6 border-t border-white/10">
            <a href="<?= BASE_URL ?>/app/controllers/controller_logout.php"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 transition-all text-sm font-bold">
                <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24">
                    <path d="M16 17v-4H9v-2h7V7l5 5-5 5M14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z" />
                </svg>
                Cerrar sesión
            </a>
        </div>
    </aside>

    <!-- Contenido -->
    <div class="lg:ml-64 flex-1 min-h-screen flex flex-col">
    <main class="flex-1 p-4 md:p-8 w-full">

        <!-- Barra superior móvil -->
        <div class="lg:hidden flex items-center justify-between mb-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
            <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-[#004e64]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>
            <span class="text-sm font-bold text-[#004e64]">Panel Voluntario</span>
            <a href="<?= BASE_URL ?>/app/controllers/controller_volunteer_dashboard.php"
                class="p-2 rounded-lg hover:bg-gray-100 transition text-[#004e64]" title="Volver al panel">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                </svg>
            </a>
        </div>

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

        <!-- Gestión de estado -->
        <?php if ($activo): ?>
            <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
                <h3 class="text-lg font-extrabold mb-4">Cerrar este reset</h3>
                <p class="text-sm text-slate-500 mb-5">Añade una nota de cierre (opcional) y elige la acción.</p>
                <form method="POST" action="<?= BASE_URL ?>/app/controllers/controller_volunteer_reset_detalle.php?id=<?= $reset['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                    <textarea name="nota_cierre" rows="2"
                        placeholder="Escribe una nota de cierre para el chat... (opcional)"
                        class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 mb-6 resize-none focus:outline-none focus:ring-2 focus:ring-[#00a5cf]"></textarea>

                    <div class="border border-slate-100 rounded-2xl p-5 mb-5 bg-slate-50">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">
                            Historia de éxito (el admin la revisará antes de publicarla)
                        </p>
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Título *</label>
                            <input type="text" name="historia_titulo" required maxlength="150"
                                placeholder="Ej: Cómo retomé mis estudios gracias a RESET"
                                class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Descripción general *</label>
                            <textarea name="historia_descripcion" required rows="2" maxlength="300"
                                placeholder="Un resumen breve del caso..."
                                class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 resize-none bg-white focus:outline-none focus:ring-2 focus:ring-[#00a5cf]"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Situación antes *</label>
                            <textarea name="historia_antes" required rows="3" maxlength="600"
                                placeholder="¿Cómo estaba la persona cuando llegó a RESET?"
                                class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 resize-none bg-white focus:outline-none focus:ring-2 focus:ring-[#00a5cf]"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Situación después *</label>
                            <textarea name="historia_despues" required rows="3" maxlength="600"
                                placeholder="¿Qué logró conseguir gracias al acompañamiento?"
                                class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 resize-none bg-white focus:outline-none focus:ring-2 focus:ring-[#00a5cf]"></textarea>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="abrirModal(this.closest('form'), 'finalizar')"
                            class="flex-1 bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl hover:opacity-90 transition-all">
                            Finalizar
                        </button>
                        <button type="button" onclick="abrirModal(this.closest('form'), 'cancelar')"
                            class="flex-1 bg-red-50 text-red-600 border border-red-200 font-extrabold text-sm py-3 rounded-2xl hover:bg-red-100 transition-all">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        <?php elseif ((int)($reset['id_estado'] ?? 0) === 3 || (int)($reset['id_estado'] ?? 0) === 4): ?>
            <div class="bg-slate-50 rounded-3xl border border-slate-200 p-8 mb-6">
                <h3 class="text-lg font-extrabold mb-2 text-slate-500">Este reset está cerrado</h3>
                <p class="text-sm text-slate-400 mb-5">Puedes reactivarlo si necesitas retomar el caso.</p>
                <form method="POST" id="form-reactivar"
                    action="<?= BASE_URL ?>/app/controllers/controller_volunteer_reset_detalle.php?id=<?= $reset['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                    <input type="hidden" name="action" value="reactivar">
                    <button type="button" onclick="abrirModal(document.getElementById('form-reactivar'), 'reactivar')"
                        class="w-full border-2 border-slate-300 text-slate-500 font-extrabold text-sm py-3 rounded-2xl hover:border-[#00a5cf] hover:text-[#00a5cf] transition-all">
                        Reactivar reset
                    </button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Hilo de comentarios -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8">
            <h3 class="text-lg font-extrabold mb-6">
                Seguimiento
                <span class="text-slate-400 font-bold text-sm ml-2">(<?= count($comentarios) ?>)</span>
            </h3>

            <?php if (empty($comentarios)): ?>
                <p class="text-sm text-slate-400 text-center py-6">Todavía no hay notas en este caso.</p>
            <?php else: ?>
                <div class="flex flex-col gap-4 mb-8">
                    <?php foreach ($comentarios as $c): ?>
                        <?php $es_voluntario = !empty($c['es_voluntario']); ?>
                        <div class="flex gap-3 <?php if ($es_voluntario) echo 'flex-row-reverse'; ?>">
                            <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($c['foto_voluntario'] ?? 'default.png') ?>"
                                alt="Avatar" class="shrink-0 w-8 h-8 rounded-full object-cover">

                            <div class="flex-1 rounded-2xl px-4 py-3 relative
                                <?php if ($es_voluntario): ?>
                                    bg-gradient-to-br from-[#e0f7ff] to-[#d0fff0] ml-12
                                <?php else: ?>
                                    bg-slate-50 mr-12
                                <?php endif; ?>">

                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-extrabold text-[#004e64]">
                                        <?= htmlspecialchars($c['nombre_usuario'] ?? 'Usuario') ?>
                                        <?php if ($es_voluntario): ?>
                                            <span class="ml-1 text-[10px] bg-[#00a5cf] text-white px-2 py-0.5 rounded-full">tú</span>
                                        <?php else: ?>
                                            <span class="ml-1 text-[10px] bg-[#004e64] text-white px-2 py-0.5 rounded-full">usuario</span>
                                        <?php endif; ?>
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] text-slate-400">
                                            <?= date('d/m/Y H:i', strtotime($c['created_at'])) ?>
                                        </span>
                                        <!-- Boton para eliminar comentarios propios -->
                                        <?php if ($es_voluntario && empty($c['eliminado'])): ?>
                                            <div class="relative" x-data="{ open: false }">
                                                <button onclick="toggleMenu(<?= $c['id'] ?>)"
                                                    class="text-slate-400 hover:text-slate-600 transition-all p-1 rounded-lg hover:bg-black/5">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/>
                                                    </svg>
                                                </button>
                                                <div id="menu-<?= $c['id'] ?>" class="hidden absolute right-0 top-6 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-10 min-w-[140px]">
                                                    <form method="POST" action="<?= BASE_URL ?>/app/controllers/controller_volunteer_reset_detalle.php?id=<?= $reset['id'] ?>">
                                                        <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                                                        <input type="hidden" name="action" value="eliminar_comentario">
                                                        <input type="hidden" name="id_comentario" value="<?= $c['id'] ?>">
                                                        <button type="submit"
                                                            class="w-full text-left px-4 py-2 text-xs font-bold text-red-500 hover:bg-red-50 transition-all">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Contenido del comentario o placeholder si está eliminado -->
                                <?php if (!empty($c['eliminado'])): ?>
                                    <div class="flex items-center gap-2 text-slate-400 italic">
                                        <svg width="18" height="18" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="#ada9a9" fill-rule="evenodd" d="M5.781 4.414a7 7 0 019.62 10.039l-9.62-10.04zm-1.408 1.42a7 7 0 009.549 9.964L4.373 5.836zM10 1a9 9 0 100 18 9 9 0 000-18z"></path> </g></svg>
                                        <p class="text-xs text-slate-400 italic"> Este mensaje fue eliminado</p>
                                    </div>
                                <?php else: ?>
                                    <p class="text-sm text-slate-600 leading-relaxed">
                                        <?= nl2br(htmlspecialchars($c['texto'])) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
                                            
            <?php if ((int)($reset['id_estado'] ?? 0) !== 4): ?>
                <form method="POST" action="<?= BASE_URL ?>/app/controllers/controller_volunteer_reset_detalle.php?id=<?= $reset['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                    <input type="hidden" name="action" value="comentar">
                    <textarea name="texto" rows="3"
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

    <script>
        let modalForm = null;
        let modalAccion = null;

        function abrirModal(form, accion) {
            modalForm = form;
            modalAccion = accion;
            const titulo = document.getElementById('modal-titulo');
            const texto  = document.getElementById('modal-texto');
            const btn    = document.getElementById('modal-btn-confirmar');
            if (accion === 'finalizar') {
                titulo.textContent = '¿Finalizar este reset?';
                texto.textContent  = 'Se marcará como resuelto y no podrás cambiar el estado.';
                btn.className = 'flex-1 bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl';
                btn.textContent = 'Sí, finalizar';
            } else if (accion === 'reactivar') {
                titulo.textContent = '¿Reactivar este reset?';
                texto.textContent  = 'Volverá a estado activo y podrás seguir trabajando en él.';
                btn.className = 'flex-1 bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl';
                btn.textContent = 'Sí, reactivar';
            }else {
                titulo.textContent = '¿Cancelar este reset?';
                texto.textContent  = 'Se marcará como cancelado.';
                btn.className = 'flex-1 bg-red-500 text-white font-extrabold text-sm py-3 rounded-2xl';
                btn.textContent = 'Sí, cancelar';
            }
            document.getElementById('modal-confirmar').classList.remove('hidden');
        }

        function confirmarAccion() {
            if (modalForm && modalAccion) {
                const input = document.createElement('input');
                input.type  = 'hidden';
                input.name  = 'action';
                input.value = modalAccion;
                modalForm.appendChild(input);
                modalForm.submit();
            }
        }

        function cerrarModal() {
            document.getElementById('modal-confirmar').classList.add('hidden');
            modalForm   = null;
            modalAccion = null;
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleMenu(id) {
            const menu = document.getElementById('menu-' + id);
            // Cerramos todos los demás menús abiertos
            document.querySelectorAll('[id^="menu-"]').forEach(m => {
                if (m.id !== 'menu-' + id) m.classList.add('hidden');
            });
            menu.classList.toggle('hidden');
        }

        // Cerrar menús al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('[id^="menu-"]') && !e.target.closest('button[onclick^="toggleMenu"]')) {
                document.querySelectorAll('[id^="menu-"]').forEach(m => m.classList.add('hidden'));
            }
        });
    </script>
</body>
</html>