<?php
require_once __DIR__ . "/../../../config.php";
//Inicializamos las variables para evitar posibles errores
$flash = $flash ?? null;
$stats = $stats ?? ["total" => 0, "en_progreso" => 0, "completados" => 0];
$categorias = $categorias ?? [];
$id_categoria = $id_categoria ?? null;
$mis_resets = $mis_resets ?? [];
$disponibles = $disponibles ?? [];
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Panel Voluntario - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Bricolage Grotesque", sans-serif;
            background-color: #f4f9fa;
        }
    </style>
</head>
<!-- Modal de confirmación (POP-UP) -->
<div id="modal-confirmar" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/70 p-4">
    <div class="w-full max-w-md rounded-[2rem] bg-white p-6 shadow-2xl shadow-slate-900/10 border border-slate-200">
        <h3 class="text-xl font-extrabold text-slate-900 mb-4">Confirmar asignación</h3>
        <p class="text-sm text-slate-600 mb-6">
            ¿Seguro que quieres asignarte este reset? El cambio se guardará y verás la actividad en tu panel.
        </p>
        <div class="flex gap-3">
            <button type="button" onclick="cerrarModal()"
                class="w-full rounded-2xl border border-slate-200 bg-white text-slate-700 py-3 font-bold hover:bg-slate-50 transition-all">
                Cancelar
            </button>
            <button type="button" onclick="confirmarAsignacion()"
                class="w-full rounded-2xl bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] py-3 font-extrabold hover:opacity-90 transition-all">
                Confirmar
            </button>
        </div>
    </div>
</div>

<body class="text-[#004e64] min-h-screen" id="inicio">
    <div class="flex">
        <!-- BOTON DE IR A INICIO ─────────────────────────────────────────────────────── -->
        <a href="#inicio" class="fixed bottom-10 right-10 z-[9999] p-3 rounded-full bg-[#25a18e] text-white hover:bg-[#1a7a6b] transition-all shadow-xl flex items-center justify-center border-2 border-white/20" aria-label="Volver al inicio"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </a>
        <!-- ── Sidebar ─────────────────────────────────────────────────────── -->
        <aside class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col gap-8">
            <div class="mt-6 px-2">
                <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-2 hover:opacity-80 transition group mb-4">
                    <svg fill="#ff3b30" class="w-6 h-6 transition-transform group-hover:rotate-12" viewBox="0 0 612.00 612.00">
                        <path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z"></path>
                        <path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z"></path>
                    </svg>
                    <h3 class="font-black text-lg tracking-tighter text-white">RESET</h3>
                </a>
            </div>
            <div class="flex items-center justify-between px-2">
                <div>
                    <p class="font-bold text-white text-sm">Panel Voluntario</p>
                    <p class="text-[10px] text-[#9fffcb] uppercase tracking-widest font-bold">RESET ONG</p>
                </div>
            </div>
            <nav class="flex flex-col gap-2">
                <a href="#mis-actividades"
                    class="sidebar-link bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-extrabold"
                    id="link-mis-actividades">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 36 36">
                        <path d="M32 5H4c-1.1 0-2 .9-2 2v22c0 1.1.9 2 2 2h28c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zM4 29V7h28v22H4z" />
                        <path d="M15.6 15.2l-6 8.7-4-3.5 1-1.2 2.7 2.4 6.3-9.2 6.7 10 6.8-8.9 1.3 1-8.1 10.7z" />
                    </svg>
                    Mis actividades
                </a>
                <a href="#resets-disponibles"
                    class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm font-bold"
                    id="link-resets-disponibles">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14H7v-2h5v2zm5-4H7v-2h10v2zm0-4H7V7h10v2z" />
                    </svg>
                    Resets disponibles
                </a>
                <a href="/Proyecto-ong-POO/app/controllers/controller_volunteer_perfil.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm font-bold">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                    </svg>
                    Mi perfil
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

        <!-- ── Contenido principal ──────────────────────────────────────────── -->
        <main class="flex-1 md:ml-64 p-6 md:p-12 w-full">
        <?php if (isset($modo_simulado) && $modo_simulado): ?>
        <div class="flex flex-col gap-2 mb-6">
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-yellow-50 border border-yellow-300 text-yellow-800 text-sm font-medium">
                <svg class="w-5 h-5 shrink-0 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                <span>Modo simulación — Las acciones están deshabilitadas. Solo puedes visualizar los datos.</span>
            </div>
            <?php if (isset($_GET['sim_bloqueado'])): ?>
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-50 border border-red-300 text-red-700 text-sm font-medium">
                <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                <span>Acción bloqueada: estás en modo simulación.</span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

            <!-- Cabecera -->
            <header class="mb-10">
                <h2 class="text-4xl font-extrabold tracking-tight mb-2">
                    Bienvenido, <?= htmlspecialchars($_SESSION["user_nombre"]) ?>
                </h2>
                <p class="text-gray-400 text-sm italic">Panel de voluntario · <?= date("d/m/Y") ?></p>
            </header>

            <!-- Flash message -->
            <?php if ($flash): ?>
                <div class="mb-8 px-5 py-4 rounded-2xl text-sm font-bold
                <?= $flash["tipo"] === "success"
                    ? "bg-green-50 text-green-700 border border-green-200"
                    : "bg-red-50 text-red-700 border border-red-200" ?>">
                    <?= htmlspecialchars($flash["msg"]) ?>
                </div>
            <?php endif; ?>

            <!-- ── Stats ────────────────────────────────────────────────────── -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-14">
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Mis RESETs asignados</p>
                    <div class="text-5xl font-extrabold text-slate-800"><?= (int)$stats["total"] ?></div>
                </div>
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">En progreso</p>
                    <div class="text-5xl font-extrabold text-slate-800"><?= (int)$stats["en_progreso"] ?></div>
                </div>
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-8">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Completados</p>
                    <div class="text-5xl font-extrabold text-slate-800"><?= (int)$stats["completados"] ?></div>
                </div>
            </div>

            <!-- ── Mis actividades ──────────────────────────────────────────── -->
            <section id="mis-actividades" class="mb-14">
                <h3 class="text-2xl font-extrabold mb-6">Mis actividades</h3>

                <?php if (empty($mis_resets)): ?>
                    <div class="bg-white rounded-3xl border border-slate-100 p-10 text-center text-slate-400">
                        <p class="text-lg font-bold mb-1">Todavía no tienes resets asignados</p>
                        <p class="text-sm">Explora los disponibles más abajo y apúntate al que mejor encaje contigo.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                        <?php foreach ($mis_resets as $r): ?>
                            <?php
                            $badgeClass = match ($r["id_estado"]) {
                                2 => "bg-blue-50 text-blue-700",
                                3 => "bg-green-50 text-green-700",
                                4 => "bg-red-50 text-red-700",
                                default => "bg-slate-100 text-slate-500",
                            };
                            $categoriaClass = match ($r["id_categoria"]) {
                                1 => "bg-cyan-50 text-cyan-700",     // estudio
                                2 => "bg-green-50 text-green-700",   // salud
                                3 => "bg-purple-50 text-purple-700", // creatividad
                                4 => "bg-yellow-50 text-yellow-700", // proyecto
                                5 => "bg-slate-100 text-slate-600",  // otros
                                default => "bg-slate-100 text-slate-500",
                            };
                            ?>
                            <?php $cerrado = in_array((int)$r['id_estado'], [3, 4]); ?>
                            <a href="<?= BASE_URL ?>/app/controllers/controller_reset_detalle.php?id=<?= $r['id'] ?>"
                                class="rounded-3xl border p-6 flex flex-col gap-3 transition-all cursor-pointer<?= $cerrado
                                                                                                                    ? 'bg-slate-50 border-slate-200 opacity-60 hover:opacity-80'
                                                                                                                    : 'bg-white border-slate-100 hover:border-[#00a5cf] hover:shadow-md' ?>">
                                <div class="flex items-start justify-between gap-3">
                                    <h4 class="font-extrabold text-base leading-snug">
                                        <?= htmlspecialchars($r["titulo"]) ?>
                                    </h4>
                                    <span class="shrink-0 text-xs font-bold px-3 py-1 rounded-full <?= $badgeClass ?>">
                                        <?= htmlspecialchars($r["nombre_estado"]) ?>
                                    </span>
                                </div>
                                <p class="text-sm text-slate-500 line-clamp-2"><?= htmlspecialchars($r["descripcion"]) ?></p>
                                <div class="flex items-center gap-4 text-xs text-slate-400 mt-1">
                                    <span class="px-2 py-1 rounded-lg font-bold <?= $categoriaClass ?>">
                                        <?= htmlspecialchars($r["nombre_categoria"]) ?>
                                    </span>
                                    <span><?= htmlspecialchars($r["nombre_contacto"] ?? "—") ?></span>
                                    <span class="ml-auto"><?= date("d/m/Y", strtotime($r["created_at"])) ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
            <!-- ── Resets disponibles ───────────────────────────────────────── -->
            <section id="resets-disponibles">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <h3 class="text-2xl font-extrabold">Resets disponibles</h3>

                    <!-- Filtro por categoría -->
                    <form method="GET" action="" class="flex items-center gap-2">
                        <select name="categoria"
                            onchange="this.form.submit()"
                            class="text-sm border border-slate-200 rounded-xl px-4 py-2 bg-white font-bold text-slate-600 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                            <option value="">Todas las categorías</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat["id"] ?>"
                                    <?= ($id_categoria === (int)$cat["id"]) ? "selected" : "" ?>>
                                    <?= htmlspecialchars(ucfirst($cat["nombre_categoria"])) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($id_categoria): ?>
                            <a href="?" class="inline-flex items-center gap-1 text-xs text-slate-400 hover:text-slate-600 font-bold"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg> Limpiar</a>
                        <?php endif; ?>
                    </form>
                </div>

                <?php if (empty($disponibles)): ?>
                    <div class="bg-white rounded-3xl border border-slate-100 p-10 text-center text-slate-400">
                        <p class="text-lg font-bold mb-1">No hay resets disponibles ahora mismo</p>
                        <p class="text-sm">Vuelve más tarde o prueba con otra categoría.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                        <?php foreach ($disponibles as $r): ?>
                            <?php
                            $categoriaClass = match ($r["id_categoria"]) {
                                1 => "bg-cyan-50 text-cyan-700",     // estudio
                                2 => "bg-green-50 text-green-700",   // salud
                                3 => "bg-purple-50 text-purple-700", // creatividad
                                4 => "bg-yellow-50 text-yellow-700", // proyecto
                                5 => "bg-slate-100 text-slate-600",  // otros
                                default => "bg-slate-100 text-slate-500",
                            };
                            ?>
                            <div class="bg-white rounded-3xl border border-slate-100 p-6 flex flex-col gap-3">
                                <div class="flex items-start justify-between gap-3">
                                    <h4 class="font-extrabold text-base leading-snug">
                                        <?= htmlspecialchars($r["titulo"]) ?>
                                    </h4>
                                    <span class="shrink-0 text-xs font-bold px-3 py-1 rounded-full bg-amber-50 text-amber-700">
                                        pendiente
                                    </span>
                                </div>
                                <p class="text-sm text-slate-500 line-clamp-2"><?= htmlspecialchars($r["descripcion"]) ?></p>
                                <div class="flex items-center gap-4 text-xs text-slate-400">
                                    <span class="px-2 py-1 rounded-lg font-bold <?= $categoriaClass ?>">
                                        <?= htmlspecialchars($r["nombre_categoria"]) ?>
                                    </span>
                                    <span><?= htmlspecialchars($r["nombre_contacto"] ?? "—") ?></span>
                                    <span class="ml-auto"><?= date("d/m/Y", strtotime($r["created_at"])) ?></span>
                                </div>

                                <!-- Botón asignarse -->
                                <form method="POST" action="\Proyecto-ong-POO\app\controllers\controller_volunteer_dashboard.php">
                                    <input type="hidden" name="action" value="asignar">
                                    <input type="hidden" name="id_reset" value="<?= $r["id"] ?>">
                                    <button type="button" onclick="abrirModal(this.closest('form'))"
                                        class="mt-1 w-full bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl hover:opacity-90 transition-all">
                                        Asignarme este reset
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
    <!-- Script para el modal -->
    <script>
        let modalForm = null;

        function abrirModal(form) {
            modalForm = form;
            document.getElementById("modal-confirmar").classList.remove("hidden");
        }

        function confirmarAsignacion() {
            if (modalForm) {
                modalForm.submit();
            }
        }

        function cerrarModal() {
            document.getElementById("modal-confirmar").classList.add("hidden");
            modalForm = null;
        }
    </script>
    <!-- Script para el sidebar -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const sections = document.querySelectorAll("section[id]");
            const links = document.querySelectorAll(".sidebar-link");

            window.addEventListener("scroll", () => {
                let current = "";

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 150;

                    if (window.scrollY >= sectionTop &&
                        window.scrollY < sectionTop + section.offsetHeight) {
                        current = section.getAttribute("id");
                    }
                });

                links.forEach(link => {
                    link.classList.remove(
                        "bg-gradient-to-r",
                        "from-[#00a5cf]",
                        "to-[#9fffcb]",
                        "text-[#004e64]",
                        "shadow-lg"
                    );

                    link.classList.add("text-blue-100");

                    if (link.getAttribute("href") === "#" + current) {
                        link.classList.add(
                            "bg-gradient-to-r",
                            "from-[#00a5cf]",
                            "to-[#9fffcb]",
                            "text-[#004e64]",
                            "shadow-lg"
                        );
                        link.classList.remove("text-blue-100");
                    }
                });
            });
        });
    </script>
</body>

</html>