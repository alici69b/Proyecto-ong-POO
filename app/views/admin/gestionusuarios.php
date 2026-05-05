<?php

include_once "../../controlador/AdminControllers/UserController.php";


$buscar = $buscar ?? '';
$usuarios = $usuarios ?? [];
$total_paginas = $total_paginas ?? 1;
$pagina_actual = $pagina_actual ?? 1;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Usuarios - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa;
        }

        /* Ocultar scrollbar pero mantener funcionalidad */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="text-[#004e64] min-h-screen flex flex-col md:flex-row">

    <button onclick="toggleSidebar()" class="md:hidden fixed top-4 right-4 z-[60] bg-[#004e64] text-white p-3 rounded-xl shadow-lg">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

        <aside id="sidebar" class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col gap-8 transition-transform duration-300 transform -translate-x-full md:translate-x-0">
            <div class="flex items-center justify-between mt-10 px-2">
                <div>
                    <p class="font-bold text-white text-sm">Panel Admin</p>
                    <p class="text-[10px] text-[#9fffcb] uppercase tracking-widest font-bold">RESET ONG</p>
                </div>
            </div>

            <nav class="flex flex-col gap-2">
                <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm group">
                    <span><svg fill="currentColor" width="20" height="20" viewBox="0 0 36 36">
                            <path d="M32 5H4c-1.1 0-2 .9-2 2v22c0 1.1.9 2 2 2h28c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zM4 29V7h28v22H4z" />
                            <path d="M15.6 15.2l-6 8.7-4-3.5 1-1.2 2.7 2.4 6.3-9.2 6.7 10 6.8-8.9 1.3 1-8.1 10.7z" />
                        </svg></span>
                    Vista general
                </a>
                <a href="gestionarreset.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm group">
                    <span class="opacity-70"><svg fill="currentColor" width="20" height="20" viewBox="0 0 1920 1920">
                            <path d="M276.9 440.6v565.7c0 422.4 374.2 625.5 674.7 788.7l8 4.3 8.1-4.3c300.5-163.2 674.7-366.3 674.7-788.7V440.6l-682.8-321.7-682.8 321.7z" />
                        </svg></span>
                    Gestionar Resets
                </a>
                <a href="gestionusuarios.php" class="bg-gradient-to-r from-[#00a5cf] to-[#9fffcb] text-[#004e64] flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-extrabold">
                    <span><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                        </svg></span>
                    Usuarios
                </a>
                <a href="gestionarhistorias.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm group">
                    <span class="opacity-70"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></span>
                    Historias
                </a>

                <a href="gestionarcontacto.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm group">
                    <span class="opacity-70"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></span>
                    Mensajes
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-white/10">
                <a href="../auth/Login.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 transition-all text-sm font-bold">
                    <svg fill="currentColor" width="20" height="20" viewBox="0 0 24 24">
                        <path d="M16 17v-4H9v-2h7V7l5 5-5 5M14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z" />
                    </svg>
                    Salir
                </a>
            </div>
        </aside>

        <main class="flex-1 transition-all duration-300 md:ml-64 p-4 sm:p-8 lg:p-12">
            <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2">Gestión de Usuarios</h1>
                    <p class="text-slate-500 ">Supervisión de todos los usuarios registrados</p>
                </div>

                <form method="GET" class="relative w-full lg:w-96">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($buscar); ?>"
                        placeholder="Buscar por nombre o email..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-gray-200 bg-white focus:ring-2 focus:ring-[#25a18e] focus:border-transparent outline-none transition-all shadow-sm">
                    <span class="absolute left-3 top-3 opacity-40">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </span>
                </form>
            </header>

            <div class="bg-white rounded-[2rem] shadow-xl shadow-blue-900/5 border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left border-collapse min-w-full">
                        <thead class="bg-slate-50/50 text-slate-400 text-[11px] font-bold uppercase tracking-[0.15em]">
                            <tr>
                                <th class="px-4 md:px-8 py-5">Usuario</th>
                                <th class="px-4 md:px-8 py-5 hidden md:table-cell">Email</th>
                                <th class="px-4 md:px-8 py-5 text-center hidden sm:table-cell">Registro</th>
                                <th class="px-4 md:px-8 py-5 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm">
                            <?php if (empty($usuarios)): ?>
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-slate-400">No se encontraron usuarios.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($usuarios as $u): ?>
                                    <tr class="hover:bg-slate-50/80 transition-all group">
                                        <td class="px-4 md:px-8 py-4">
                                            <div class="flex items-center gap-3 md:gap-4">
                                                <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-gradient-to-br from-red-300 to-red-700 text-white flex items-center justify-center font-bold text-xs shadow-md">
                                                    <?php echo $u['iniciales']; ?>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-bold text-slate-700 leading-tight truncate"><?php echo htmlspecialchars($u['nombre'] . " " . $u['apellidos']); ?></p>
                                                    <p class="text-[10px] text-slate-400 font-medium italic md:hidden truncate"><?php echo htmlspecialchars($u['email']); ?></p>
                                                    <p class="text-[10px] text-slate-400 font-medium italic">ID: #<?php echo $u['id_usuario']; ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 md:px-8 py-4 text-slate-600 font-medium italic opacity-80 hidden md:table-cell">
                                            <?php echo htmlspecialchars($u['email']); ?>
                                        </td>
                                        <td class="px-4 md:px-8 py-4 text-center text-slate-500 font-medium hidden sm:table-cell">
                                            <span class="bg-slate-100 px-3 py-1 rounded-lg text-[11px] whitespace-nowrap">
                                                <?php echo date('d M, Y', strtotime($u['fecha_registro'])); ?>
                                            </span>
                                        </td>
                                        <td class="px-4 md:px-8 py-4 text-center">
                                            <div class="flex justify-center gap-1 md:gap-2">
                                                <button onclick="abrirModalEditar(<?php echo $u['id_usuario']; ?>, '<?php echo addslashes($u['nombre']); ?>', '<?php echo addslashes($u['apellidos'] ?? ''); ?>', '<?php echo addslashes($u['email']); ?>', <?php echo (int)($u['id_rol'] ?? 1); ?>)"
                                                    class="p-2 hover:bg-blue-50 text-blue-500 rounded-xl transition-all active:scale-90">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                        <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                    </svg>
                                                </button>
                                                <button onclick="abrirModal(<?php echo $u['id_usuario']; ?>)"
                                                    class="p-2 hover:bg-red-50 text-red-400 hover:text-red-600 rounded-xl transition-all active:scale-90">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <polyline points="3 6 5 6 21 6" />
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center border-t border-slate-100 gap-4">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?></p>
                    <div class="flex gap-1.5 overflow-x-auto no-scrollbar">
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <a href="?p=<?php echo $i; ?>&search=<?php echo urlencode($buscar); ?>"
                                class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-xl font-bold text-[13px] transition-all <?php echo ($i == $pagina_actual) ? 'bg-[#004e64] text-white shadow-lg' : 'bg-white border border-slate-200 hover:text-[#004e64]'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="modal-editar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" role="dialog" aria-labelledby="modal-editar-title" aria-modal="true">
        <div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-2xl max-w-lg w-full border border-slate-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 id="modal-editar-title" class="text-2xl font-black text-slate-800">Editar usuario</h3>
                <button type="button" onclick="cerrarModalEditar()" class="text-slate-400 hover:text-slate-600 transition-colors" aria-label="Cerrar modal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form method="POST" class="space-y-4 flex flex-col">
                <input type="hidden" name="id_usuario" id="edit-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label for="edit-nombre" class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre</label>
                        <input type="text" name="nombre" id="edit-nombre" required class="px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] focus:border-transparent outline-none transition-all">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="edit-apellidos" class="text-xs font-bold text-slate-500 uppercase tracking-widest">Apellidos</label>
                        <input type="text" name="apellidos" id="edit-apellidos" class="px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] focus:border-transparent outline-none transition-all">
                    </div>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit-email" class="text-xs font-bold text-slate-500 uppercase tracking-widest">Email</label>
                    <input type="email" name="email" id="edit-email" required class="px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] focus:border-transparent outline-none transition-all">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit-rol" class="text-xs font-bold text-slate-500 uppercase tracking-widest">Rol</label>
                    <select name="id_rol" id="edit-rol" class="px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] focus:border-transparent outline-none transition-all cursor-pointer">
                        <option value="1">Usuario</option>
                        <option value="3">Administrador</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit-password" class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nueva contraseña <span class="text-[10px] lowercase font-normal">(opcional)</span></label>
                    <input type="password" name="password_nuevo" id="edit-password" placeholder="••••••••" class="px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-[#25a18e] focus:border-transparent outline-none transition-all">
                </div>
                <div class="flex gap-3 mt-8">
                    <button type="button" onclick="cerrarModalEditar()" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-3 bg-[#00a5cf] text-white font-bold rounded-2xl shadow-lg hover:bg-[#0088aa] transition-all">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-confirmar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white p-8 rounded-[2rem] shadow-2xl max-w-sm w-full text-center">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-xl font-black mb-2">¿Confirmar borrado?</h3>
            <p class="text-slate-500 text-sm mb-6">Esta acción no se puede deshacer.</p>
            <div class="flex gap-3">
                <button onclick="cerrarModal()" class="flex-1 py-3 bg-slate-100 font-bold rounded-2xl">No, volver</button>
                <a id="btn-confirmar-eliminar" href="#" class="flex-1 py-3 bg-red-500 text-white font-bold rounded-2xl shadow-lg">Sí, borrar</a>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        }

        function abrirModalEditar(id, nombre, apellidos, email, rol) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-apellidos').value = apellidos;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-rol').value = rol;
            document.getElementById('edit-password').value = '';
            const modal = document.getElementById('modal-editar');
            modal.classList.remove('hidden');
            // Enfocar el primer input
            document.getElementById('edit-nombre').focus();
        }

        function cerrarModalEditar() {
            document.getElementById('modal-editar').classList.add('hidden');
        }

        function abrirModal(idUsuario) {
            document.getElementById('btn-confirmar-eliminar').href = 'gestionusuarios.php?action=delete&id=' + idUsuario;
            document.getElementById('modal-confirmar').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modal-confirmar').classList.add('hidden');
        }

        // Cerrar modales al hacer clic fuera o presionar ESC
        window.addEventListener('click', function(event) {
            const modalEditar = document.getElementById('modal-editar');
            const modalConfirmar = document.getElementById('modal-confirmar');
            if (event.target === modalEditar) cerrarModalEditar();
            if (event.target === modalConfirmar) cerrarModal();
        });

        // Cerrar modales con la tecla ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modalEditar = document.getElementById('modal-editar');
                const modalConfirmar = document.getElementById('modal-confirmar');
                if (modalEditar && !modalEditar.classList.contains('hidden')) cerrarModalEditar();
                if (modalConfirmar && !modalConfirmar.classList.contains('hidden')) cerrarModal();
            }
        });
    </script>

</body>

</html>