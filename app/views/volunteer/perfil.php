<?php
require_once __DIR__ . "/../../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'soy-voluntario') {
    header('Location: ../auth/Login.php');
    exit();
}
//Variables necesarias para mostrar el perfil
$perfil = $perfil ?? [];
$flash  = $flash  ?? null;

//Datos para los selects de tipo de ayuda y disponibilidad
$tipos_ayuda = ['estudio', 'salud', 'creatividad', 'proyecto', 'otros'];
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
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa;
        }
    </style>
</head>

<body class="text-[#004e64] min-h-screen">
    <div class="flex">

        <!--  Sidebar  -->
        <aside class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col gap-8">
            <div class="mt-10 px-2">
                <p class="font-bold text-white text-sm">Panel Voluntario</p>
                <p class="text-[10px] text-[#9fffcb] uppercase tracking-widest font-bold">RESET ONG</p>
            </div>
            <nav class="flex flex-col gap-2">
                <a href="/Proyecto-ong-POO/app/controllers/controller_volunteer_dashboard.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm font-bold">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 1.41-1.41L7.83 13H20v-2z" />
                    </svg>
                    Volver al panel
                </a>
                <a href="/Proyecto-ong-POO/app/controllers/controller_volunteer_perfil.php"
                    class="bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-extrabold">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                    </svg>
                    Mi perfil
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

        <!-- Contenido -->
        <main class="flex-1 md:ml-64 p-6 md:p-12 w-full max-w-3xl">

            <header class="mb-10">
                <h2 class="text-4xl font-extrabold tracking-tight mb-2">Mi perfil</h2>
                <p class="text-gray-400 text-sm italic">Gestiona tu información personal</p>
            </header>

            <!-- Flash -->
            <?php if ($flash): ?>
                <div class="mb-6 px-5 py-4 rounded-2xl text-sm font-bold
                <?= $flash['tipo'] === 'success'
                    ? 'bg-green-50 text-green-700 border border-green-200'
                    : 'bg-red-50 text-red-700 border border-red-200' ?>">
                    <?= htmlspecialchars($flash['msg']) ?>
                </div>
            <?php endif; ?>

            <!-- Foto de perfil  -->
            <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
                <h3 class="text-lg font-extrabold mb-6">Foto de perfil</h3>
                <div class="flex items-center gap-6">
                    <!-- Avatar actual -->
                    <img src="/Proyecto-ong-POO/public/img/<?= htmlspecialchars($perfil['foto_perfil'] ?? 'default.png') ?>"
                        alt="Foto de perfil"
                        class="w-20 h-20 rounded-full object-cover border-4 border-[#00a5cf]/30">

                    <!-- Formulario subida -->
                    <form method="POST"
                        action="/Proyecto-ong-POO/app/controllers/controller_volunteer_perfil.php"
                        enctype="multipart/form-data"
                        class="flex-1">
                        <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                        <input type="hidden" name="action" value="actualizar_foto">
                        <label class="block text-sm font-bold text-slate-500 mb-2">
                            Sube una nueva imagen (JPG, PNG o WEBP · máx. 2MB)
                        </label>
                        <div class="flex gap-3">
                            <input type="file"
                                name="foto"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="flex-1 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:font-bold file:bg-slate-100 file:text-slate-600 hover:file:bg-slate-200 transition-all">
                            <button type="submit"
                                class="shrink-0 bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] font-extrabold text-sm px-5 py-2 rounded-xl hover:opacity-90 transition-all">
                                Subir
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!--  Datos personales  -->
            <div class="bg-white rounded-3xl border border-slate-100 p-8 mb-6">
                <h3 class="text-lg font-extrabold mb-6">Datos personales</h3>
                <form method="POST"
                    action="/Proyecto-ong-POO/app/controllers/controller_volunteer_perfil.php"
                    class="flex flex-col gap-5">
                    <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                    <input type="hidden" name="action" value="actualizar_datos">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nombre</label>
                            <input type="text"
                                name="nombre"
                                value="<?= htmlspecialchars($perfil['nombre'] ?? '') ?>"
                                required
                                class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Apellidos</label>
                            <input type="text"
                                name="apellidos"
                                value="<?= htmlspecialchars($perfil['apellidos'] ?? '') ?>"
                                required
                                class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                        </div>
                    </div>

                    <!-- Email solo lectura -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Email</label>
                        <input type="email"
                            value="<?= htmlspecialchars($perfil['email'] ?? '') ?>"
                            disabled
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
                    action="/Proyecto-ong-POO/app/controllers/controller_volunteer_perfil.php"
                    class="flex flex-col gap-5">
                    <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
                    <input type="hidden" name="action" value="cambiar_password">

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Contraseña actual</label>
                        <input type="password"
                            name="password_actual"
                            required
                            class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nueva contraseña</label>
                        <input type="password"
                            name="password_nueva"
                            required
                            minlength="6"
                            class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Repetir nueva contraseña</label>
                        <input type="password"
                            name="password_repetir"
                            required
                            minlength="6"
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
</body>
</html>