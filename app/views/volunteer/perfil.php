<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-voluntario') {
    header('Location: ../auth/Login.php');
    exit();
}

$perfil = $perfil ?? [];
$flash  = $flash  ?? null;

$tipos_ayuda      = ['estudio', 'salud', 'creatividad', 'proyecto', 'otros'];
$disponibilidades = ['mañanas', 'tardes', 'noches', 'fines de semana', 'flexible'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Mi Perfil - RESET ONG</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Bricolage Grotesque', sans-serif; background-color: #f4f9fa; }
    </style>
</head>

<body class="text-[#004e64] min-h-screen">

    <!-- Overlay móvil -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col gap-8 -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="mt-6 px-2">
            <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-2 hover:opacity-80 transition group mb-4">
                <svg fill="#ff3b30" class="w-6 h-6" viewBox="0 0 612 612">
                    <path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z"/>
                    <path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z"/>
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

    
    <div class="lg:ml-64 flex-1 min-h-screen flex flex-col">
        <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-1 p-4 md:p-8 w-full">

        <!-- Barra superior móvil -->
        <div class="lg:hidden flex items-center justify-between mb-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
            <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-[#004e64]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>
            <span class="text-sm font-bold text-[#004e64]">Mi perfil</span>
            <a href="<?= BASE_URL ?>/app/controllers/controller_volunteer_dashboard.php"
                class="p-2 rounded-lg hover:bg-gray-100 transition text-[#004e64]" title="Volver al panel">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                </svg>
            </a>
        </div>

        <header class="mb-10">
            <h2 class="text-4xl font-extrabold tracking-tight mb-2">Mi perfil</h2>
            <p class="text-gray-400 text-sm italic">Gestiona tu información personal</p>
        </header>

        <!-- Flash -->
        <?php if ($flash): ?>
            <div class="mb-6 px-5 py-4 rounded-2xl text-sm font-bold
                <?= $flash['tipo'] === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' ?>">
                <?= htmlspecialchars($flash['msg']) ?>
            </div>
        <?php endif; ?>

        <!-- Foto de perfil -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
            <h3 class="text-lg font-extrabold mb-6">Foto de perfil</h3>
            <div class="flex items-center gap-6">
                <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($perfil['foto_perfil'] ?? 'default.png') ?>"
                    alt="Foto de perfil"
                    id="preview-foto"
                    class="w-20 h-20 rounded-full object-cover border-4 border-[#00a5cf]/30">
                <form method="POST"
                    action="<?= BASE_URL ?>/app/controllers/controller_volunteer_perfil.php"
                    enctype="multipart/form-data">
                    <input type="hidden" name="action" value="actualizar_foto">
                    <label class="cursor-pointer">
                        <span class="inline-block text-sm font-bold border border-slate-200 rounded-2xl px-4 py-2 hover:bg-slate-50 text-slate-600">
                            Elegir imagen
                        </span>
                        <input type="file" name="foto" accept="image/*" class="hidden"
                            onchange="previewFoto(this); this.closest('form').submit()">
                    </label>
                    <p class="text-xs text-slate-400 mt-2">JPG, PNG o WEBP. Máx. 2MB.</p>
                </form>
            </div>
        </div>

        <!-- Datos personales -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
            <h3 class="text-lg font-extrabold mb-6">Datos personales</h3>
            <form method="POST"
                action="<?= BASE_URL ?>/app/controllers/controller_volunteer_perfil.php"
                class="flex flex-col gap-5">
                <input type="hidden" name="action" value="actualizar_datos">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nombre</label>
                        <input type="text" name="nombre"
                            value="<?= htmlspecialchars($perfil['nombre'] ?? '') ?>" required
                            class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Apellidos</label>
                        <input type="text" name="apellidos"
                            value="<?= htmlspecialchars($perfil['apellidos'] ?? '') ?>" required
                            class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Email</label>
                    <input type="email" value="<?= htmlspecialchars($perfil['email'] ?? '') ?>" disabled
                        class="w-full text-sm border border-slate-100 rounded-xl px-4 py-3 bg-slate-50 text-slate-400 cursor-not-allowed">
                    <p class="text-xs text-slate-400 mt-1">El email no se puede cambiar.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Tipo de ayuda</label>
                        <select name="tipo_ayuda"
                            class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                            <?php foreach ($tipos_ayuda as $tipo): ?>
                                <option value="<?= $tipo ?>"
                                    <?= ($perfil['tipo_ayuda'] ?? '') === $tipo ? 'selected' : '' ?>>
                                    <?= ucfirst($tipo) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Disponibilidad</label>
                        <select name="disponibilidad"
                            class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                            <?php foreach ($disponibilidades as $disp): ?>
                                <option value="<?= $disp ?>"
                                    <?= ($perfil['disponibilidad'] ?? '') === $disp ? 'selected' : '' ?>>
                                    <?= ucfirst($disp) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl hover:opacity-90 transition-all">
                    Guardar cambios
                </button>
            </form>
        </div>

        <!-- Cambiar contraseña -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8">
            <h3 class="text-lg font-extrabold mb-6">Cambiar contraseña</h3>
            <form method="POST"
                action="<?= BASE_URL ?>/app/controllers/controller_volunteer_perfil.php"
                class="flex flex-col gap-5">
                <input type="hidden" name="action" value="cambiar_password">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Contraseña actual</label>
                    <input type="password" name="password_actual" required
                        class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nueva contraseña</label>
                    <input type="password" name="password_nueva" required minlength="6"
                        class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Repetir nueva contraseña</label>
                    <input type="password" name="password_repetir" required minlength="6"
                        class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                </div>
                <button type="submit"
                    class="w-full bg-red-50 text-red-600 border border-red-200 font-extrabold text-sm py-3 rounded-2xl hover:bg-red-100 transition-all">
                    Cambiar contraseña
                </button>
            </form>
        </div>

    </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function previewFoto(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-foto').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>