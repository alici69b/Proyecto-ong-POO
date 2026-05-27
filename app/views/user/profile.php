<?php if (!isset($usuario)): header('Location: ../../controllers/controller_user_dashboard.php'); exit(); endif; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Mi Perfil - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Bricolage Grotesque', sans-serif; background-color: #f4f9fa; }
    </style>
</head>
<body class="text-[#004e64] min-h-screen bg-[#f4f9fa]">

    <?php require_once __DIR__ . "/../../../src/components/Header.php"; ?>

    <div class="pt-28 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <a href="/Proyecto-ong-POO/app/controllers/controller_user_dashboard.php" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#00a5cf] transition mb-6">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
            Volver al panel
        </a>

        <?php if ($mensaje_exito): ?>
        <div class="mb-6 flex items-center gap-3 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" class="w-5 h-5 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            <p class="font-medium"><?= htmlspecialchars($mensaje_exito) ?></p>
        </div>
        <?php endif; ?>

        <?php if (!empty($errores['general'])): ?>
        <div class="mb-6 flex items-center gap-3 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm">
            <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5 shrink-0"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"/></svg>
            <p class="font-medium"><?= htmlspecialchars(implode(', ', $errores['general'])) ?></p>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#004e64] to-[#00a5cf] p-8 text-white">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-full border-4 border-white/30 overflow-hidden shrink-0 bg-white/20">
                        <img src="/Proyecto-ong-POO/public/img/<?= htmlspecialchars($fotoPerfil) ?>" alt="Foto de perfil" class="w-full h-full object-cover"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full hidden items-center justify-center text-3xl font-extrabold text-white">
                            <?= mb_strtoupper(mb_substr($usuario['nombre'] ?? 'U', 0, 1)) ?>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold"><?= $nombreCompleto ?></h1>
                        <p class="text-white/70 text-sm"><?= htmlspecialchars($usuario['email'] ?? '') ?></p>
                    </div>
                </div>
            </div>

            <div class="p-8 space-y-10">

                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    <h2 class="text-xl font-extrabold text-[#004e64] flex items-center gap-2">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 text-[#00a5cf]"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                        Información personal
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Nombre</label>
                            <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                            <?php if (!empty($errores['nombre'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(implode(', ', $errores['nombre'])) ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Apellidos</label>
                            <input type="text" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos'] ?? '') ?>"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                            <?php if (!empty($errores['apellidos'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(implode(', ', $errores['apellidos'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Foto de perfil</label>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                <img src="/Proyecto-ong-POO/public/img/<?= htmlspecialchars($fotoPerfil) ?>" alt="Foto"
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <div class="w-full h-full hidden items-center justify-center text-xl font-bold text-gray-400">
                                    <?= mb_strtoupper(mb_substr($usuario['nombre'] ?? 'U', 0, 1)) ?>
                                </div>
                            </div>
                            <input type="file" name="foto_perfil" accept="image/jpeg,image/png,image/gif,image/webp"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-[#00a5cf]/10 file:text-[#00a5cf] hover:file:bg-[#00a5cf]/20 transition">
                        </div>
                        <?php if (!empty($errores['foto'])): ?>
                            <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(implode(', ', $errores['foto'])) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit" name="actualizar_perfil"
                                class="px-8 py-3 bg-[#00a5cf] hover:bg-[#008bb0] text-white font-bold rounded-full shadow-lg transition-all">
                            Guardar cambios
                        </button>
                    </div>
                </form>

                <div class="border-t border-slate-200"></div>

                <form method="POST" class="space-y-6">
                    <h2 class="text-xl font-extrabold text-[#004e64] flex items-center gap-2">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 text-[#00a5cf]"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                        Cambiar contraseña
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Contraseña actual</label>
                            <input type="password" name="password_actual" placeholder="••••••••"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                            <?php if (!empty($errores['password_actual'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(implode(', ', $errores['password_actual'])) ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Nueva contraseña</label>
                            <input type="password" name="nueva_password" placeholder="Mínimo 8 caracteres"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                            <?php if (!empty($errores['nueva_password'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(implode(', ', $errores['nueva_password'])) ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Confirmar contraseña</label>
                            <input type="password" name="confirmar_password" placeholder="Repite la contraseña"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                            <?php if (!empty($errores['confirmar_password'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= htmlspecialchars(implode(', ', $errores['confirmar_password'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit" name="cambiar_password"
                                class="px-8 py-3 bg-[#25a18e] hover:bg-[#1d8a78] text-white font-bold rounded-full shadow-lg transition-all">
                            Cambiar contraseña
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
