<?php
require_once __DIR__ . "/../../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

// Si no está logueado o no es usuario, lo mandamos al login
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-usuario') {
    header('Location: ../auth/Login.php');
    exit();
}

// Evitamos errores si las variables no vienen definidas
if (!isset($reset)) $reset = array();
if (!isset($comentarios)) $comentarios = array();
if (!isset($flash)) $flash = null;

// Comprobamos el estado del reset para saber qué mostrar
$estado = isset($reset['id_estado']) ? (int)$reset['id_estado'] : 0;
$puede_cancelar = ($estado == 1 || $estado == 2);
$esta_resuelto  = ($estado == 3);
$esta_cancelado = ($estado == 4);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Mi Reset - RESET ONG</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa;
        }
    </style>
</head>
<!-- Modal de confirmación para cancelar -->
<div id="modal-cancelar" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl">
        <h4 class="text-lg font-extrabold mb-2">¿Cancelar este reset?</h4>
        <p class="text-sm text-slate-500 mb-6">Se marcará como cancelado.</p>
        <div class="flex gap-3">
            <button onclick="cerrarModal()"
                class="flex-1 border border-slate-200 text-slate-600 font-bold text-sm py-3 rounded-2xl hover:bg-slate-50">
                Volver
            </button>
            <button onclick="confirmarCancelar()"
                class="flex-1 bg-red-500 text-white font-extrabold text-sm py-3 rounded-2xl hover:bg-red-600">
                Sí, cancelar
            </button>
        </div>
    </div>
</div>
<body class="text-[#004e64] min-h-screen">
    <div class="flex">

        <!-- SIDEBAR -->
        <aside class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col gap-8">
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
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 text-sm font-bold">
                    ← Volver al panel
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-white/10">
                <a href="<?= BASE_URL ?>/app/controllers/controller_logout.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 text-sm font-bold">
                    Cerrar sesión
                </a>
            </div>
        </aside>

        <!-- CONTENIDO -->
        <main class="flex-1 md:ml-64 p-6 md:p-12 w-full max-w-4xl">

            <!-- Mensaje flash -->
            <?php if ($flash != null): ?>
                <?php if ($flash['tipo'] == 'success'): ?>
                    <div class="mb-6 px-5 py-4 rounded-2xl text-sm font-bold bg-green-50 text-green-700 border border-green-200">
                        <?= htmlspecialchars($flash['msg']) ?>
                    </div>
                <?php else: ?>
                    <div class="mb-6 px-5 py-4 rounded-2xl text-sm font-bold bg-red-50 text-red-700 border border-red-200">
                        <?= htmlspecialchars($flash['msg']) ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- DATOS DEL RESET -->
            <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <h2 class="text-3xl font-extrabold"><?= htmlspecialchars($reset['titulo']) ?></h2>
                    <?php
                    // Badge de estado
                    if ($estado == 1) {
                        $badgeClass = 'bg-amber-50 text-amber-700';
                    } elseif ($estado == 2) {
                        $badgeClass = 'bg-blue-50 text-blue-700';
                    } elseif ($estado == 3) {
                        $badgeClass = 'bg-green-50 text-green-700';
                    } elseif ($estado == 4) {
                        $badgeClass = 'bg-red-50 text-red-700';
                    } else {
                        $badgeClass = 'bg-slate-100 text-slate-500';
                    }
                    ?>
                    <span class="shrink-0 text-xs font-bold px-3 py-1 rounded-full <?= $badgeClass ?>">
                        <?= htmlspecialchars($reset['nombre_estado']) ?>
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-600 mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Categoría</p>
                        <p class="font-bold"><?= htmlspecialchars($reset['nombre_categoria']) ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Voluntario asignado</p>
                        <?php if (!empty($reset['nombre_voluntario'])): ?>
                            <p class="font-bold text-[#00a5cf]"><?= htmlspecialchars($reset['nombre_voluntario']) ?></p>
                        <?php else: ?>
                            <p class="font-bold text-slate-400 italic">Pendiente de asignación</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Fecha</p>
                        <p class="font-bold"><?= date('d/m/Y', strtotime($reset['created_at'])) ?></p>
                    </div>
                </div>

                <?php if (!empty($reset['descripcion'])): ?>
                    <div class="mb-3">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Descripción</p>
                        <p class="text-sm text-slate-600"><?= nl2br(htmlspecialchars($reset['descripcion'])) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($reset['necesidades_reset'])): ?>
                    <div class="mb-3">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Qué necesito</p>
                        <p class="text-sm text-slate-600"><?= nl2br(htmlspecialchars($reset['necesidades_reset'])) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($reset['causa_abandono'])): ?>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Causa del bloqueo</p>
                        <p class="text-sm text-slate-600"><?= nl2br(htmlspecialchars($reset['causa_abandono'])) ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- BOTÓN CANCELAR (solo si está pendiente o activo) -->
            <?php if ($puede_cancelar): ?>
                <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
                    <h3 class="text-lg font-extrabold mb-2">¿Ya no necesitas ayuda con esto?</h3>
                    <p class="text-sm text-slate-500 mb-5">Puedes cancelar esta solicitud en cualquier momento.</p>
                    <form method="POST" id="form-cancelar"
                        action="<?= BASE_URL ?>/app/controllers/controller_user_reset_detalle.php?id=<?= $reset['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                        <input type="hidden" name="action" value="cancelar">
                        <button type="button" onclick="abrirModal()"
                            class="w-full bg-red-50 text-red-600 border border-red-200 font-extrabold text-sm py-3 rounded-2xl hover:bg-red-100">
                            Cancelar solicitud
                        </button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Aviso si está resuelto -->
            <?php if ($esta_resuelto): ?>
                <div class="bg-green-50 rounded-3xl border border-green-200 p-6 mb-6 flex items-center gap-4">
                    <span class="text-3xl">🎉</span>
                    <div>
                        <p class="font-extrabold text-green-700">¡Reset completado!</p>
                        <p class="text-sm text-green-600">Tu voluntario marcó este proceso como resuelto. ¡Enhorabuena!</p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- SEGUIMIENTO / CHAT -->
            <div class="bg-white rounded-3xl border border-slate-100 p-8">
                <h3 class="text-lg font-extrabold mb-6">
                    Seguimiento
                    <span class="text-slate-400 font-bold text-sm ml-2">(<?= count($comentarios) ?>)</span>
                </h3>

                <!-- Lista de comentarios -->
                <?php if (count($comentarios) == 0): ?>
                    <p class="text-sm text-slate-400 text-center py-6">
                        <?php if ($estado == 1): ?>
                            En cuanto un voluntario tome tu caso, verás el seguimiento aquí.
                        <?php else: ?>
                            Aún no hay mensajes en este caso.
                        <?php endif; ?>
                    </p>
                <?php else: ?>
                    <div class="flex flex-col gap-4 mb-8">
                        <?php foreach ($comentarios as $c): ?>
                            <?php
                            // Si es_voluntario tiene valor, el mensaje es del voluntario
                            // Si no, es del usuario (o sea, del que está viendo la página)
                            $es_voluntario = !empty($c['es_voluntario']);
                            ?>
                            <div class="flex gap-3 <?php if (!$es_voluntario) echo 'flex-row-reverse'; ?>">
                                <!-- Foto -->
                                <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($c['foto_voluntario'] ?? 'default.png') ?>"
                                    alt="Avatar"
                                    class="shrink-0 w-8 h-8 rounded-full object-cover">
                                <!-- Burbuja del mensaje -->
                                <div class="flex-1 rounded-2xl px-4 py-3
                                <?php if ($es_voluntario): ?>
                                    bg-slate-50 mr-12
                                <?php else: ?>
                                    bg-gradient-to-br from-[#e0f7ff] to-[#d0fff0] ml-12
                                <?php endif; ?>">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-extrabold text-[#004e64]">
                                            <?= htmlspecialchars($c['nombre_usuario'] ?? 'Usuario') ?>
                                            <?php if ($es_voluntario): ?>
                                                <span class="ml-1 text-[10px] bg-[#004e64] text-white px-2 py-0.5 rounded-full">voluntario</span>
                                            <?php else: ?>
                                                <span class="ml-1 text-[10px] bg-[#00a5cf] text-white px-2 py-0.5 rounded-full">tú</span>
                                            <?php endif; ?>
                                        </span>
                                        <span class="text-[10px] text-slate-400">
                                            <?= date('d/m/Y H:i', strtotime($c['created_at'])) ?>
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-600"><?= nl2br(htmlspecialchars($c['texto'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario para enviar un mensaje (desactivado si está cancelado) -->
                <?php if (!$esta_cancelado): ?>
                    <form method="POST"
                        action="<?= BASE_URL ?>/app/controllers/controller_user_reset_detalle.php?id=<?= $reset['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                        <input type="hidden" name="action" value="comentar">
                        <textarea name="texto" rows="3"
                            placeholder="Escribe un mensaje a tu voluntario..."
                            class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 mb-3 resize-none focus:outline-none focus:ring-2 focus:ring-[#00a5cf]"></textarea>
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl hover:opacity-90">
                            Enviar mensaje
                        </button>
                    </form>
                <?php else: ?>
                    <p class="text-xs text-center text-slate-400 mt-4">Esta solicitud está cancelada y no admite más mensajes.</p>
                <?php endif; ?>
            </div>

        </main>
    </div>

    <script>
        function abrirModal() {
            document.getElementById('modal-cancelar').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modal-cancelar').classList.add('hidden');
        }

        function confirmarCancelar() {
            document.getElementById('form-cancelar').submit();
        }
    </script>
</body>
</html>