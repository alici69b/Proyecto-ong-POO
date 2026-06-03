<?php
require_once __DIR__ . "/../../../config.php";

// Evitamos errores si las variables no vienen definidas
if (!isset($flash)) $flash = null;
if (!isset($stats)) $stats = array("total" => 0, "activos" => 0, "resueltos" => 0);
if (!isset($categorias)) $categorias = array();
if (!isset($id_categoria)) $id_categoria = null;
if (!isset($mis_resets)) $mis_resets = array();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Mi Panel - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa;
        }
    </style>
</head>
<!-- Modal para crear un nuevo reset -->
<div id="modal-nuevo-reset" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/70 p-4">
    <div class="w-full max-w-lg rounded-[2rem] bg-white p-8 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-extrabold text-slate-900">Nueva solicitud de Reset</h3>
            <button onclick="cerrarModal()" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form method="POST" action="<?= BASE_URL ?>/app/controllers/controller_user_dashboard.php">
            <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
            <input type="hidden" name="action" value="crear_reset">

            <!-- Título -->
            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Título *</label>
                <input type="text" name="titulo" required maxlength="150"
                    placeholder="¿En qué necesitas ayuda?"
                    class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
            </div>

            <!-- Categoría -->
            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Categoría *</label>
                <select name="id_categoria" required
                    class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                    <option value="">Selecciona una categoría</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id'] ?>">
                            <?= htmlspecialchars(ucfirst($cat['nombre_categoria'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Descripción</label>
                <textarea name="descripcion" rows="3" maxlength="1000"
                    placeholder="Cuéntanos un poco más sobre tu situación..."
                    class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 resize-none focus:outline-none focus:ring-2 focus:ring-[#00a5cf]"></textarea>
            </div>

            <!-- Necesidades -->
            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">¿Qué necesitas exactamente?</label>
                <textarea name="necesidades_reset" rows="2" maxlength="500"
                    placeholder="Ej: orientación, motivación, recursos..."
                    class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 resize-none focus:outline-none focus:ring-2 focus:ring-[#00a5cf]"></textarea>
            </div>

            <!-- Causa abandono -->
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">¿Qué te hizo parar? (opcional)</label>
                <textarea name="causa_abandono" rows="2" maxlength="500"
                    placeholder="Ej: falta de tiempo, desmotivación..."
                    class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 resize-none focus:outline-none focus:ring-2 focus:ring-[#00a5cf]"></textarea>
            </div>

            <!-- Botones -->
            <div class="flex gap-3">
                <button type="button" onclick="cerrarModal()"
                    class="flex-1 border border-slate-200 text-slate-600 font-bold text-sm py-3 rounded-2xl hover:bg-slate-50">
                    Cancelar
                </button>
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl hover:opacity-90">
                    Enviar solicitud
                </button>
            </div>
        </form>
    </div>
</div>

<body class="text-[#004e64] min-h-screen">
     <!-- Overlay móvil -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>


        <!-- SIDEBAR -->
        <aside id="sidebar" class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col gap-8">
            <div class="mt-6 px-2">
                <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-2 hover:opacity-80 transition group mb-4">
                    <svg fill="#ff3b30" class="w-6 h-6" viewBox="0 0 612 612">
                        <path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z" />
                        <path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z" />
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
                    <p class="text-[#9fffcb] text-[10px]">Usuario</p>
                </div>
            </div>
            <nav class="flex flex-col gap-2">
                <a href="<?= BASE_URL ?>/app/controllers/controller_user_dashboard.php"
                    class="bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-extrabold">
                    Mis Resets
                    <?php if ($hay_notificacion): ?>
                        <span class="ml-auto w-2.5 h-2.5 rounded-full bg-red-500 shrink-0"></span>
                    <?php endif; ?>
                </a>
                <a href="<?= BASE_URL ?>/app/controllers/controller_user_perfil.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 text-sm font-bold">
                    Mi perfil
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-white/10">
                <a href="<?= BASE_URL ?>/app/controllers/controller_logout.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 text-sm font-bold">
                    Cerrar sesión
                </a>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
    <div class="lg:ml-64 flex-1 min-h-screen flex flex-col">
    <main class="flex-1 p-4 md:p-8 w-full">

        <!-- Barra superior móvil con botón hamburguesa -->
        <div class="lg:hidden flex items-center justify-between mb-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
            <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-[#004e64]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>
            <span class="text-sm font-bold text-[#004e64]"><?= htmlspecialchars($_SESSION['user_nombre']) ?></span>
        </div>

        <!-- Cabecera -->
        <div class="mb-10 flex items-start justify-between gap-4">
            <div>
                <h2 class="text-4xl font-extrabold tracking-tight mb-2">
                    Hola, <?= htmlspecialchars($_SESSION['user_nombre']) ?>
                </h2>
                <p class="text-gray-400 text-sm italic">Mi panel · <?= date('d/m/Y') ?></p>
            </div>
            <!-- Botón para abrir el modal de nuevo reset -->
            <button onclick="abrirModal()"
                class="shrink-0 bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm px-6 py-3 rounded-2xl hover:opacity-90 shadow-md">
                + Nuevo Reset
            </button>
        </div>

        <!-- Mensaje flash (éxito o error) -->
        <?php if ($flash != null): ?>
            <?php if ($flash['tipo'] == 'success'): ?>
                <div class="mb-8 px-5 py-4 rounded-2xl text-sm font-bold bg-green-50 text-green-700 border border-green-200">
                    <?= htmlspecialchars($flash['msg']) ?>
                </div>
            <?php else: ?>
                <div class="mb-8 px-5 py-4 rounded-2xl text-sm font-bold bg-red-50 text-red-700 border border-red-200">
                    <?= htmlspecialchars($flash['msg']) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- ESTADÍSTICAS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-14">
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-8">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Mis Resets</p>
                <div class="text-5xl font-extrabold text-slate-800"><?= $stats['total'] ?></div>
            </div>
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-8">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">En progreso</p>
                <div class="text-5xl font-extrabold text-slate-800"><?= $stats['activos'] ?></div>
            </div>
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-8">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Resueltos</p>
                <div class="text-5xl font-extrabold text-slate-800"><?= $stats['resueltos'] ?></div>
            </div>
        </div>

        <!-- MIS RESETS -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-2xl font-extrabold">Mis solicitudes</h3>

            <!-- Filtros -->
            <form method="GET" action="" class="flex flex-wrap items-center gap-2">
                <!-- Filtro por categoría -->
                <select name="categoria" onchange="this.form.submit()"
                    class="text-sm border border-slate-200 rounded-xl px-4 py-2 bg-white font-bold text-slate-600 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?php if ($id_categoria == $cat['id']) echo 'selected'; ?>>
                            <?= htmlspecialchars(ucfirst($cat['nombre_categoria'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Filtro por estado -->
                <select name="estado" onchange="this.form.submit()"
                    class="text-sm border border-slate-200 rounded-xl px-4 py-2 bg-white font-bold text-slate-600 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                    <option value="">Todos los estados</option>
                    <option value="1" <?php if (isset($id_estado) && $id_estado == 1) echo 'selected'; ?>>Pendiente</option>
                    <option value="2" <?php if (isset($id_estado) && $id_estado == 2) echo 'selected'; ?>>Activo</option>
                    <option value="3" <?php if (isset($id_estado) && $id_estado == 3) echo 'selected'; ?>>Resuelto</option>
                    <option value="4" <?php if (isset($id_estado) && $id_estado == 4) echo 'selected'; ?>>Cancelado</option>
                </select>

                <!-- Botón limpiar si hay algún filtro activo -->
                <?php if ($id_categoria || (isset($id_estado) && $id_estado)): ?>
                    <a href="?" class="text-xs text-slate-400 hover:text-slate-600 font-bold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Limpiar
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Lista de resets -->
        <?php if (count($mis_resets) == 0): ?>
            <div class="bg-white rounded-3xl border border-slate-100 p-10 text-center text-slate-400">
                <p class="text-lg font-bold mb-1">Todavía no tienes solicitudes</p>
                <p class="text-sm">Pulsa el botón "Nuevo Reset" para pedir ayuda a un voluntario.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <?php foreach ($mis_resets as $r): ?>
                    <?php
                    // Color del badge según el estado
                    if ($r['id_estado'] == 1) {
                        $badgeClass = 'bg-amber-50 text-amber-700';
                    } elseif ($r['id_estado'] == 2) {
                        $badgeClass = 'bg-blue-50 text-blue-700';
                    } elseif ($r['id_estado'] == 3) {
                        $badgeClass = 'bg-green-50 text-green-700';
                    } elseif ($r['id_estado'] == 4) {
                        $badgeClass = 'bg-red-50 text-red-700';
                    } else {
                        $badgeClass = 'bg-slate-100 text-slate-500';
                    }

                    // Si está cerrado (resuelto o cancelado) lo mostramos con menos opacidad
                    $cerrado = ($r['id_estado'] == 3 || $r['id_estado'] == 4);
                    ?>
                    <a href="<?= BASE_URL ?>/app/controllers/controller_user_reset_detalle.php?id=<?= $r['id'] ?>"
                        class="rounded-3xl border p-6 flex flex-col gap-3 transition-all cursor-pointer
                        <?php if ($cerrado): ?>
                            bg-slate-50 border-slate-200 opacity-60 hover:opacity-80
                        <?php else: ?>
                            bg-white border-slate-100 hover:border-[#00a5cf] hover:shadow-md
                        <?php endif; ?>">

                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <h4 class="font-extrabold text-base"><?= htmlspecialchars($r['titulo']) ?></h4>
                                <!-- Punto rojo si hay mensajes sin leer del voluntario -->
                                <?php if ($r['tiene_notificacion']): ?>
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-500 shrink-0" title="Tienes mensajes sin leer"></span>
                                <?php endif; ?>
                            </div>
                            <span class="shrink-0 text-xs font-bold px-3 py-1 rounded-full <?= $badgeClass ?>">
                                <?= htmlspecialchars($r['nombre_estado']) ?>
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 line-clamp-2"><?= htmlspecialchars($r['descripcion']) ?></p>

                        <div class="flex items-center gap-3 text-xs text-slate-400 flex-wrap">
                            <span class="px-2 py-1 rounded-lg font-bold bg-slate-100">
                                <?= htmlspecialchars($r['nombre_categoria']) ?>
                            </span>
                            <!-- Voluntario asignado -->
                            <?php if (!empty($r['nombre_voluntario'])): ?>
                                <span>👤 <?= htmlspecialchars($r['nombre_voluntario']) ?></span>
                            <?php else: ?>
                                <span class="italic text-slate-300">Sin voluntario aún</span>
                            <?php endif; ?>
                            <span class="ml-auto"><?= date('d/m/Y', strtotime($r['created_at'])) ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>
    </div>

<script>
    // Abrir y cerrar el modal de nuevo reset
    function abrirModal() {
        document.getElementById('modal-nuevo-reset').classList.remove('hidden');
    }

    function cerrarModal() {
        document.getElementById('modal-nuevo-reset').classList.add('hidden');
    }

    // Cerrar el modal si se hace clic fuera del contenido
    document.getElementById('modal-nuevo-reset').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModal();
        }
    });

    // Abrir y cerrar el sidebar en móvil
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>
</body>
</html>