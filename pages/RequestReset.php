<?php
//Inicializamos sesion
session_start();

//Variables
$errorNombre = $_SESSION["error_nombre"] ?? null;
$errorEmail = $_SESSION["error_email"] ?? null;
$errorCategoria = $_SESSION["error_categoria"] ?? null;
$errorDescripcion = $_SESSION["error_descripcionProblema"] ?? null;
$errorAbandono = $_SESSION["error_causaAbandono"] ?? null;
$errorNecesidad = $_SESSION["error_necesidadesReset"] ?? null;
$mensajeExito = $_SESSION["exito"] ?? null;
$errorCrearSolicitud = $_SESSION["errorSolicitud"] ?? null;

//unset de las sesiones para evitar errores
if (isset($_SESSION["error_nombre"]) || isset($_SESSION["error_email"]) || isset($_SESSION["error_categoria"]) || isset($_SESSION["error_descripcionProblema"]) || isset($_SESSION["error_causaAbandono"]) || isset($_SESSION["error_necesidadesReset"]) || isset($_SESSION["exito"]) || isset($_SESSION["errorSolicitud"])) {
    unset($_SESSION["error_nombre"], $_SESSION["error_email"], $_SESSION["error_categoria"], $_SESSION["error_descripcionProblema"], $_SESSION["error_causaAbandono"], $_SESSION["error_necesidadesReset"], $_SESSION["exito"], $_SESSION["errorSolicitud"]);
}
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../public/img/Logo_RESET.svg">
    <title>Solicitar RESET</title>
    <!-- Link css -->
    <link rel="stylesheet" href="../public/styles.css">

    <!-- Link del Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  
      <!-- Fuentes de google fonts  -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Domine">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bricolage Grotesque">


    <style>
        body {
            font-family: 'Bricolage Grotesque';
        }

        html {
            scroll-behavior: smooth; 
        }

        @keyframes shimmer {
            0%, 100% { background-position: 0% 50%; }
            50%       { background-position: 100% 50%; }
        }

        .fade-in { animation: fadeIn 0.5s ease both; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-1 { animation-delay: 0.05s; }
        .fade-in-2 { animation-delay: 0.15s; }
        .fade-in-3 { animation-delay: 0.25s; }
        .fade-in-4 { animation-delay: 0.35s; }
        .fade-in-5 { animation-delay: 0.45s; }
        .fade-in-6 { animation-delay: 0.55s; }
    </style>
   <!--font-family: font-serif
    colores
        -azul oscuro: #004e64
        -azul: #00a5cf
        - verdeagua  #9fffcb
        -verde : #25a18e
        -verde vivo: #7ae582
        -coral: #ff3b30
        -poner letras con el degradado del inicio: bg-linear-to-r from-[#00a5cf] to-[#9fffcb] bg-clip-text text-transparent 
        -color del  bg-[#f4f9fa]
        -color verde medio traslucido bg-[#2BB39A]

    -->

</head>
<body class="bg-[#f4f9fa]" id="inicio">
    
    <!-- Importamos el Menú de navegación -->
    <?php
    require_once "../src/components/Header.php";
    ?>

    <!-- BOTON DE IR A INICIO -->
    <div  class="scroll-smooth ">
        <a href="#inicio" class="fixed bottom-10 right-20 z-50 p-3 rounded-full bg-[#25a18e] text-white hover:bg-[#1a7a6b] transition shadow-lg flex items-center justify-center" aria-label="Volver al inicio">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg></a>
    </div>
   
    <!-- Formulario -->
    <main class="pt-40 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col align-middle text-center items-center justify-center space-y-4">
            <div class="flex flex-row space-x-1 bg-teal-600/10 rounded-full text-teal-600 w-full max-w-xs mx-auto p-1 justify-center text-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-sparkles"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 18a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2m0 -12a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2m-7 12a6 6 0 0 1 6 -6a6 6 0 0 1 -6 -6a6 6 0 0 1 -6 6a6 6 0 0 1 6 6" /></svg>
                <div class="">
                    Tu segunda oportunidad
                </div>
            </div>
            <div class="font-['Domine'] font-semibold md:text-5xl text-4xl">
                Solicitar mi RESET
            </div>
            <div class="text-xl text-gray-500/70">
                Cuéntanos tu historia. Sin juicios, solo comprensión y ganas de ayudarte.
            </div>
            <div class="max-w-3xl mx-auto mb-6 p-4 bg-[#e8fbff] border-l-4 border-[#00a5cf] text-[#004e64] rounded shadow-sm text-center">
                Este formulario <strong>no requiere registro</strong>. Si prefieres crear una cuenta para llevar un seguimiento de tus solicitudes, 
                <a href="../app/vista/auth/Register.php" class="text-[#25a18e] font-semibold hover:underline">haz clic aquí para registrarte</a>.
            </div>
        </div>
        <form action="../app/controlador/ResetController.php" method="POST" class="">
            <?php if (isset($errorCrearSolicitud)): ?>
                <div class="bg-red-100 border-l-4 border-[#ff3b30] text-[#ff3b30] p-4 mb-6 rounded shadow-sm animate-pulse">
                    <p class="font-bold">Atención:</p>
                    <p><?= $errorCrearSolicitud ?></p>
                </div>
            <?php endif; ?>
            <?php if (isset($mensajeExito) && $mensajeExito): ?>
                <div class="bg-green-100 border-l-4 border-[#37ff30] text-[#37ff30] p-4 mb-6 rounded shadow-sm animate-pulse">
                    <p class="font-bold">Atención:</p>
                    <p><?= $mensajeExito ?></p>
                </div>
            <?php endif; ?>
            <div class="bg-white rounded-xl shadow-lg text-start flex flex-col w-full max-w-3xl mx-auto pb-8 px-6 sm:px-8 md:px-10 pt-8 gap-7">
                <div class="flex flex-row gap-4 w-full">
                    <div class="flex flex-col flex-1 space-y-2">
                        <label for="name">Tu nombre o alias</label>
                        <input type="text" name="name" placeholder="¿Cómo te llamas?" class="bg-[#f4f9fa] border border-[#e1e6e7] p-2 rounded-lg pl-3 w-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25a18e] focus-visible:ring-offset-2 transiti duration-300 ease-in-out focus:border-[#25a18e]">
                        <?php if(isset($errorNombre)) :?>
                            <p class="text-red-600 font-medium"><?= $errorNombre; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="flex flex-col flex-1 space-y-2">
                        <label for="email">Tu email</label>
                        <input type="email" name="email" placeholder="Para contactarte" class="bg-[#f4f9fa] border border-[#e1e6e7] p-2 rounded-lg pl-3 w-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25a18e] focus-visible:ring-offset-2 transiti duration-300 ease-in-out focus:border-[#25a18e]">
                        <?php if(isset($errorEmail)) :?>
                            <p class="text-red-600 font-medium"><?= $errorEmail; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex flex-col gap-4 w-full">
                    <label for="categoria" class="">¿Qué quieres reiniciar?</label>
                    <select name="categoria" class="bg-[#f4f9fa] border border-[#e1e6e7] p-2 rounded-lg pl-3 w-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25a18e] focus-visible:ring-offset-2 transiti duration-300 ease-in-out focus:border-[#25a18e]">
                        <option>Selecciona una categoría</option>
                        <option value="estudio">Estudios</option>
                        <option value="salud">Salud</option>
                        <option value="creatividad">Creatividad</option>
                        <option value="proyecto">Proyecto</option>
                        <option value="otros">Otros</option>
                    </select>
                    <?php if(isset($errorCategoria)) :?>
                        <p class="text-red-600 font-medium"><?= $errorCategoria; ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col flex-1 space-y-2">
                    <label for="descripcion-problema">¿Qué abandonaste?</label>
                    <textarea type="text" name="descripcion-problema" placeholder="Cuéntanos qué proyecto, sueño o hábito dejaste atrás..." class="bg-[#f4f9fa] border border-[#e1e6e7] p-2 rounded-lg pl-3 w-full min-h-[120px] resize-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25a18e] focus-visible:ring-offset-2 transiti duration-300 ease-in-out focus:border-[#25a18e]"></textarea>
                    <?php if(isset($errorDescripcion)) :?>
                        <p class="text-red-600 font-medium"><?= $errorDescripcion; ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col flex-1 space-y-2">
                    <label for="causa-abandono">¿Por qué lo dejaste?</label>
                    <textarea type="text" name="causa-abandono" placeholder="No hay respuestas incorrectas.A veces la vida simplemente pasa..." class="bg-[#f4f9fa] border border-[#e1e6e7] p-2 rounded-lg pl-3 w-full min-h-[120px] resize-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25a18e] focus-visible:ring-offset-2 transiti duration-300 ease-in-out focus:border-[#25a18e]"></textarea>
                    <?php if(isset($errorAbandono)) :?>
                        <p class="text-red-600 font-medium"><?= $errorAbandono; ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col flex-1 space-y-2">
                    <label for="necesidades-reset">¿Qué necesitas para volver a empezar?</label>
                    <textarea type="text" name="necesidades-reset" placeholder="Apoyo emocional, ayuda técnica, alguien que te acompañe..." class="bg-[#f4f9fa] border border-[#e1e6e7] p-2 rounded-lg pl-3 w-full min-h-[120px] resize-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25a18e] focus-visible:ring-offset-2 transiti duration-300 ease-in-out focus:border-[#25a18e]"></textarea>
                    <?php if(isset($errorNecesidad)) :?>
                        <p class="text-red-600 font-medium"><?= $errorNecesidad; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex flex-col justify-center items-center mt-5 m-12 space-y-5">
                <button type="submit" class="flex flex-row bg-[#25a18e] rounded-xl p-3 px-8 text-white space-x-3 cursor-pointer hover:bg-[#2ebda5] transition duration-300 hover:shadow-lg hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-telegram"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" /></svg> 
                    <div class="text-lg">Enviar mi solicitud</div>
                </button>
                <div class="flex flex-row space-x-3">
                    <div class="text-base text-gray-500">Te responderemos en menos de 48 horas.</div>
                </div>
            </div>
        </form>
    </main>
    
    <!-- Importamos el footer -->
    <footer>
    <?php
    require_once "../src/components/Footer.php";
    ?>    
    </footer>
</body>
