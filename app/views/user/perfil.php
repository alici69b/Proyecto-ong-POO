<?php
require_once __DIR__ . "/../../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-usuario') {
    header('Location: ../auth/Login.php');
    exit();
}

if (!isset($flash)) $flash = null;
// $perfil viene del controlador con los datos de usuario + usuario_normal unidos
if (!isset($perfil)) $perfil = array();

// Opciones de tipo de ayuda (igual que en voluntario pero sin disponibilidad)
$tipos_ayuda = array('estudio', 'salud', 'creatividad', 'proyecto', 'otros');
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
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa;
        }
    </style>
</head>
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
                <a href="<?= BASE_URL ?>/app/controllers/controller_user_perfil.php"
                    class="bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-extrabold">
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

        <!-- CONTENIDO -->
        <main class="flex-1 md:ml-64 p-6 md:p-12 w-full max-w-3xl">

            <div class="mb-10">
                <h2 class="text-4xl font-extrabold tracking-tight mb-2">Mi perfil</h2>
                <p class="text-gray-400 text-sm italic">Gestiona tu información personal</p>
            </div>

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

            <!-- FOTO DE PERFIL -->
            <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
                <h3 class="text-lg font-extrabold mb-6">Foto de perfil</h3>
                <div class="flex items-center gap-6">
                    <!-- Previsualización de la foto -->
                    <img src="/Proyecto-ong-POO/public/img/<?= htmlspecialchars($perfil['foto_perfil'] ?? 'default.png') ?>"
                        alt="Foto de perfil"
                        id="preview-foto"
                        class="w-20 h-20 rounded-full object-cover border-4 border-slate-100">

                    <!-- Formulario para subir foto (se envía solo al seleccionar archivo) -->
                    <form method="POST" enctype="multipart/form-data"
                        action="<?= BASE_URL ?>/app/controllers/controller_user_perfil.php">
                        <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                        <input type="hidden" name="action" value="foto">
                        <label class="cursor-pointer">
                            <span class="inline-block text-sm font-bold border border-slate-200 rounded-2xl px-4 py-2 hover:bg-slate-50 text-slate-600">
                                Elegir imagen
                            </span>
                            <!-- Al cambiar el archivo se previsualiza y se envía el formulario automáticamente -->
                            <input type="file" name="foto" accept="image/*" class="hidden"
                                onchange="previewFoto(this); this.closest('form').submit()">
                        </label>
                        <p class="text-xs text-slate-400 mt-2">JPG, PNG o WEBP. Máx. 2MB.</p>
                    </form>
                </div>
            </div>

            <!-- DATOS PERSONALES -->
            <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
                <h3 class="text-lg font-extrabold mb-6">Datos personales</h3>
                <form method="POST" action="<?= BASE_URL ?>/app/controllers/controller_user_perfil.php">
                    <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                    <input type="hidden" name="action" value="datos">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre</label>
                            <input type="text" name="nombre"
                                value="<?= htmlspecialchars($perfil['nombre'] ?? '') ?>"
                                class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Apellidos</label>
                            <input type="text" name="apellidos"
                                value="<?= htmlspecialchars($perfil['apellidos'] ?? '') ?>"
                                class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Email</label>
                        <input type="email" name="email"
                            value="<?= htmlspecialchars($perfil['email'] ?? '') ?>"
                            class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                    </div>

                    <!-- Tipo de ayuda (único campo extra del usuario normal) -->
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Tipo de ayuda que busco</label>
                        <select name="tipo_ayuda"
                            class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 bg-white font-bold text-slate-600 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                            <?php foreach ($tipos_ayuda as $tipo): ?>
                                <option value="<?= $tipo ?>"
                                    <?php if (isset($perfil['tipo_ayuda']) && $perfil['tipo_ayuda'] == $tipo) echo 'selected'; ?>>
                                    <?= ucfirst($tipo) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm py-3 rounded-2xl hover:opacity-90">
                        Guardar cambios
                    </button>
                </form>
            </div>

            <!-- CAMBIAR CONTRASEÑA -->
            <div class="bg-white rounded-3xl border border-slate-100 p-8">
                <h3 class="text-lg font-extrabold mb-6">Cambiar contraseña</h3>
                <form method="POST" action="<?= BASE_URL ?>/app/controllers/controller_user_perfil.php">
                    <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                    <input type="hidden" name="action" value="password">

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Contraseña actual</label>
                        <input type="password" name="password_actual"
                            class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nueva contraseña</label>
                            <input type="password" name="password_nuevo"
                                class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Repetir nueva contraseña</label>
                            <input type="password" name="password_confirmar"
                                class="w-full text-sm border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full border-2 border-slate-200 text-slate-600 font-extrabold text-sm py-3 rounded-2xl hover:border-[#00a5cf] hover:text-[#00a5cf]">
                        Actualizar contraseña
                    </button>
                </form>
            </div>

        </main>
    </div>

    <script>
        // Muestra una previsualización de la foto antes de subirla
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