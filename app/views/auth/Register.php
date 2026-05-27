<?php
$rol = $_GET["rol"] ?? "usuario";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title> Registro - RESET</title>

    <style>
        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }

            to {
                opacity: 0;
                transform: translateX(60px);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-60px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        body {
            animation: slideInLeft 0.4s ease both;
        }

        body.saliendo {
            animation: slideOutRight 0.3s ease both;
        }
    </style>

    <!-- Link del Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<!--
    font-family: font-serif
    colores
        -azul oscuro: #004e64
        -azul: #00a5cf
        - verdeagua  #9fffcb
        -verde : #25a18e
        -verde vivo: #7ae582
        -coral: #ff3b30
        -poner letras con el degradado del inicio: bg-linear-to-r from-[#00a5cf] to-[#9fffcb] bg-clip-text text-transparent 
        -color del  bg-[#f4f9fa]

    -->

<body class="">

    <div class="flex min-h-screen ">

        <!-- Parte izquierda donde sale el fondo gradiant con el logo dando vueltas -->
        <div class="hidden lg:flex lg:w-1/2 bg-linear-to-r from-[#9fffcb] to-[#00a5cf]  min-h-200   items-center justify-center text-white  ">
            <div class="max-w-md text-center">
                <div class="mb-8 flex justify-center opacity-40">
                    <svg class="animate-spin [animation-duration:10s] -scale-x100 w-32 h-32 " fill="#ff3b30" height="230px" width="200px" viewBox="0 0 612 612" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z"></path>
                            <path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z"></path>
                        </g>
                    </svg>
                </div>
                <h2 class="text-4xl font-extrabold mb-4">Aquí empieza tu segunda oportunidad</h2>
                <p class="text-lg opacity-90 leading-relaxed">No tienes que hacerlo solo/a. Únete a una comunidad que cree en las segundas oportunidades.</p>
            </div>
        </div>

        <!-- boton de volver al inicio con el logo y el nombre de la ong -->
        <div class="flex w-full flex-col justify-center px-8 md:px-16 lg:w-1/2 xl:px-24 bg-white">
            <div class="mx-auto w-full max-w-md">
                <a href="/Proyecto-ong-POO/index.php" class="mb-10 flex items-center text-sm text-gray-500 hover:text-gray-700"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5l-7.5-7.5 7.5-7.5"/></svg> Volver al inicio</a>
                <div class="flex items-center gap-2">
                    <svg fill="#ff3b30" height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 612.00 612.00" xml:space="preserve">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z"></path>
                                    <path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <h3 class="font-bold text-xl">RESET</h3>
                </div>

                <!-- Pequeño resumen de lo que vamos a hacer, crear la cuenta en la ong -->
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Crea tu cuenta</h1>
                <p class="text-slate-500 mb-8">Únete a RESET y empieza tu camino hacia una nueva oportunidad.</p>
                <div class="mb-4">
                    <?php if (isset($_SESSION['errores']) && !empty($_SESSION['errores'])): ?>
                        <div class="bg-red-100 border-l-4 border-[#ff3b30] text-[#ff3b30] p-4 mb-6 rounded shadow-sm animate-pulse">

                            <ul class="text-sm text-red-700 space-y-1">
                                <?php
                                foreach ($_SESSION['errores'] as $campo => $mensajes) {
                                    if (is_array($mensajes)) {
                                        foreach ($mensajes as $mensaje) {
                                            echo "<li>• " . htmlspecialchars($mensaje) . "</li>";
                                        }
                                    } else {
                                        echo "<li>• " . htmlspecialchars($mensajes) . "</li>";
                                    }
                                }
                                unset($_SESSION['errores']);
                                ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Formulario con los campos: nombre, email, contraseña y el boton -->
                <form id="registerForm" class="space-y-5" method="post" action="/Proyecto-ong-POO/app/controllers/controller_register.php" novalidate>

                    <!--  El value inicial es 'soy-usuario', que coincide con el botón que arranca activo -->
                    <input type="hidden" name="tipo" id="input-rol" value="<?= $rol; ?>">

                    <div class="flex w-full flex-col mx-auto mb-5">
                        <div class="flex gap-2 mb-8 bg-[#004e64] p-1 rounded-xl">

                            <!--  btn-usuario arranca con bg-[#00a5cf] (activo) -->
                            <button type="button" id="btn-usuario" onclick="cambiarRol('soy-usuario')"
                                class="flex-1 py-2.5 px-4 rounded-lg font-medium transition-all text-white bg-[#00a5cf]">
                                Necesito ayuda
                            </button>

                            <!--  btn-voluntario arranca SIN bg-[#00a5cf] (inactivo) -->
                            <button type="button" id="btn-voluntario" onclick="cambiarRol('soy-voluntario')"
                                class="flex-1 py-2.5 px-4 rounded-lg font-medium transition-all text-white">
                                Quiero ayudar
                            </button>
                        </div>

                        <!--  bloque-usuario visible por defecto (sin hidden) -->
                        <div id="bloque-usuario" class="animate-in fade-in duration-300">
                            <label class="block text-sm font-medium text-slate-700 mb-2">¿Qué quieres reiniciar?</label>
                            <select name="tipo_ayuda_usuario" id="tipo_ayuda_usuario" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                                <option value="">Selecciona una categoría</option>
                                <option value="estudio">Estudios</option>
                                <option value="salud">Salud</option>
                                <option value="creatividad">Creatividad</option>
                                <option value="proyecto">Proyecto</option>
                                <option value="otros">Otros</option>
                            </select>
                            <p id="tipo_ayuda_usuario-error" class="hidden text-red-500 text-sm mt-1"></p>
                        </div>

                        <!--  bloque-voluntario oculto por defecto (con hidden) -->
                        <div id="bloque-voluntario" class="hidden animate-in fade-in duration-300">
                            <label class="block text-sm font-medium text-slate-700 mb-2">¿Cómo puedes ayudar?</label>
                            <select name="tipo_ayuda_voluntario" id="tipo_ayuda_voluntario" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                                <option value="">Selecciona una ayuda</option>
                                <option value="estudio">Mentoría en estudios</option>
                                <option value="salud">Coaching de salud</option>
                                <option value="creatividad">Guía creativa</option>
                                <option value="proyecto">Asesoría de emprendimiento</option>
                                <option value="otros">Otro</option>
                            </select>
                            <p id="tipo_ayuda_voluntario-error" class="hidden text-red-500 text-sm mt-1"></p>
                        </div>
                    </div>

                    <div id="nombre-group">
                        <label for="nombre" class="block text-sm font-medium text-slate-700 mb-2">Tu nombre</label>
                        <input name="nombre" id="nombre" type="text" placeholder="¿Cómo te llamas?" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                        <p id="nombre-error" class="hidden text-red-500 text-sm mt-1"></p>
                    </div>

                    <div id="apellidos-group">
                        <label for="apellidos" class="block text-sm font-medium text-slate-700 mb-2">Tus apellidos</label>
                        <input name="apellidos" id="apellidos" type="text" placeholder="¿Cuáles son tus apellidos?" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                        <p id="apellidos-error" class="hidden text-red-500 text-sm mt-1"></p>
                    </div>

                    <div id="email-group">
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input name="email" id="email" type="email" placeholder="tu@email.com" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                        <p id="email-error" class="hidden text-red-500 text-sm mt-1"></p>
                    </div>

                    <div id="contrasena-group">
                        <label for="contrasena" class="block text-sm font-medium text-slate-700 mb-2">Contraseña</label>
                        <input name="contrasena" id="contrasena" type="password" placeholder="Mínimo 8 caracteres" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] transition-all">
                        <p id="contrasena-error" class="hidden text-red-500 text-sm mt-1"></p>
                    </div>

                    <button name="crear_cuenta" id="crear_cuenta" type="submit" class="w-full bg-[#00a5cf] hover:bg-black text-white font-semibold py-4 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <line x1="19" y1="8" x2="19" y2="14" />
                            <line x1="16" y1="11" x2="22" y2="11" />
                        </svg>
                        Crear mi cuenta
                    </button>

                    <div class="mb-4">
                        <?php if (isset($_SESSION['mensaje_exito'])): ?>
                            <div class="mb-6 rounded shadow-sm animate-pulse flex border-l-4 border-green-500 bg-green-50 p-4 text-green" role="alert">
                                <svg class="flex w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3 font-medium">
                                    <?php
                                    echo $_SESSION['mensaje_exito'];
                                    unset($_SESSION['mensaje_exito']);
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm text-gray-600">
                    ¿Ya tienes cuenta? <a href="/Proyecto-ong-POO/app/controllers/controller_login.php" class="cursor-pointer font-bold text-[#00a5cf] hover:underline">Inicia Sesión</a>
                </p>

            </div>
        </div>

        <script>
            const form = document.getElementById('registerForm');
            const nombre = document.getElementById('nombre');
            const apellidos = document.getElementById('apellidos');
            const email = document.getElementById('email');
            const contrasena = document.getElementById('contrasena');
            const tipoAyudaUsuario = document.getElementById('tipo_ayuda_usuario');
            const tipoAyudaVoluntario = document.getElementById('tipo_ayuda_voluntario');

            const campos = [
                { el: nombre, error: 'nombre-error', val: () => validarTexto(nombre, 'El nombre') },
                { el: apellidos, error: 'apellidos-error', val: () => validarTexto(apellidos, 'Los apellidos') },
                { el: email, error: 'email-error', val: () => validarEmail() },
                { el: contrasena, error: 'contrasena-error', val: () => validarContrasena() },
            ];

            function mostrarError(input, errorId, mensaje) {
                const errorEl = document.getElementById(errorId);
                input.classList.add('border-red-500', 'ring-red-500');
                input.classList.remove('border-slate-200');
                errorEl.textContent = mensaje;
                errorEl.classList.remove('hidden');
            }

            function limpiarError(input, errorId) {
                const errorEl = document.getElementById(errorId);
                input.classList.remove('border-red-500', 'ring-red-500');
                input.classList.add('border-slate-200');
                errorEl.classList.add('hidden');
                errorEl.textContent = '';
            }

            function validarTexto(input, label) {
                const v = input.value.trim();
                if (v === '') {
                    mostrarError(input, input.id + '-error', label + ' es obligatorio.');
                    return false;
                }
                if (v.length < 2) {
                    mostrarError(input, input.id + '-error', label + ' debe tener al menos 2 caracteres.');
                    return false;
                }
                if (/[0-9]/.test(v)) {
                    mostrarError(input, input.id + '-error', label + ' no puede contener números.');
                    return false;
                }
                limpiarError(input, input.id + '-error');
                return true;
            }

            function validarEmail() {
                const v = email.value.trim();
                if (v === '') {
                    mostrarError(email, 'email-error', 'El email es obligatorio.');
                    return false;
                }
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
                    mostrarError(email, 'email-error', 'Introduce un email válido (ej. usuario@dominio.com).');
                    return false;
                }
                limpiarError(email, 'email-error');
                return true;
            }

            function validarContrasena() {
                const v = contrasena.value.trim();
                if (v === '') {
                    mostrarError(contrasena, 'contrasena-error', 'La contraseña es obligatoria.');
                    return false;
                }
                if (v.length < 8) {
                    mostrarError(contrasena, 'contrasena-error', 'La contraseña debe tener al menos 8 caracteres.');
                    return false;
                }
                limpiarError(contrasena, 'contrasena-error');
                return true;
            }

            function validarTipoAyuda() {
                const rol = document.getElementById('input-rol').value;
                const select = rol === 'soy-voluntario' ? tipoAyudaVoluntario : tipoAyudaUsuario;
                const errorId = rol === 'soy-voluntario' ? 'tipo_ayuda_voluntario-error' : 'tipo_ayuda_usuario-error';
                const errorEl = document.getElementById(errorId);
                if (select.value === '') {
                    select.classList.add('border-red-500', 'ring-red-500');
                    select.classList.remove('border-slate-200');
                    errorEl.textContent = 'Selecciona una opción.';
                    errorEl.classList.remove('hidden');
                    return false;
                }
                select.classList.remove('border-red-500', 'ring-red-500');
                select.classList.add('border-slate-200');
                errorEl.classList.add('hidden');
                errorEl.textContent = '';
                return true;
            }

            campos.forEach(c => {
                c.el.addEventListener('blur', c.val);
                c.el.addEventListener('input', () => {
                    if (!document.getElementById(c.error).classList.contains('hidden')) c.val();
                });
            });

            form.addEventListener('submit', function(e) {
                const valNombre = validarTexto(nombre, 'El nombre');
                const valApellidos = validarTexto(apellidos, 'Los apellidos');
                const valEmail = validarEmail();
                const valPass = validarContrasena();
                const valAyuda = validarTipoAyuda();
                if (!valNombre || !valApellidos || !valEmail || !valPass || !valAyuda) {
                    e.preventDefault();
                    if (!valNombre) nombre.focus();
                    else if (!valApellidos) apellidos.focus();
                    else if (!valEmail) email.focus();
                    else if (!valPass) contrasena.focus();
                }
            });

            function cambiarRol(rol) {
                const btnU = document.getElementById('btn-usuario');
                const btnV = document.getElementById('btn-voluntario');
                const bloqueU = document.getElementById('bloque-usuario');
                const bloqueV = document.getElementById('bloque-voluntario');
                const inputHidden = document.getElementById('input-rol');

                inputHidden.value = rol;

                if (rol === 'soy-usuario') {
                    btnU.classList.add('bg-[#00a5cf]');
                    btnV.classList.remove('bg-[#00a5cf]');
                    bloqueU.classList.remove('hidden');
                    bloqueV.classList.add('hidden');
                } else {
                    btnV.classList.add('bg-[#00a5cf]');
                    btnU.classList.remove('bg-[#00a5cf]');
                    bloqueV.classList.remove('hidden');
                    bloqueU.classList.add('hidden');
                }

                document.getElementById('tipo_ayuda_usuario-error').classList.add('hidden');
                document.getElementById('tipo_ayuda_voluntario-error').classList.add('hidden');
            }

            function navegarCon(url) {
                document.body.classList.add('saliendo');
                setTimeout(() => window.location.href = url, 300);
            }

            document.addEventListener('DOMContentLoaded', () => {
                const rol = "<?= $rol ?>";
                if (rol === 'voluntario') {
                    cambiarRol('soy-voluntario');
                } else {
                    cambiarRol('soy-usuario');
                }
            });
        </script>

</body>

</html>