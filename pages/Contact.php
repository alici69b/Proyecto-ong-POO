<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/svg+xml" href="../public/img/Logo_RESET.svg">
    <title>Contacto - RESET</title>

     <!-- Link al css -->
    <link rel="stylesheet" href="../public/css/style.css">

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

    -->

</head>
<body class=" bg-[#f4f9fa]" id="inicio">
    <!-- Importamos el Menú de navegación -->
    <?php
    require_once "../src/components/Header.php";
    ?>

    <!-- BOTON DE IR A INICIO -->
    <a href="#inicio" class="fixed bottom-10 right-10 z-[9999] p-3 rounded-full bg-[#25a18e] text-white hover:bg-[#1a7a6b] transition-all shadow-xl flex items-center justify-center border-2 border-white/20" aria-label="Volver al inicio"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
    </a>

    <main class="fade-in fade-in-1 max-w-7xl mx-auto px-4 py-12 pt-40">
   
           
            <!-- Título de la página -->
            <div class="text-center">
             <p class="text-[#00a5cf] font-bold text-sm tracking-[0.2em] uppercase 4 opacity-90">
                        Contacto
                    </p>
            <p class="font-['Domine']  text-slate-800 md:text-6xl lg:text-6xl text-4xl font-bold mb-4"><b>¿Tienes alguna <i class="bg-linear-to-r from-[#00a5cf] to-[#9fffcb] bg-clip-text text-transparent">pregunta</i>?</b></p>
            <p class="text-gray-500 max-w-2xl mx-auto  sm:text-lg sm:p-2 lg:text-lg px-7">Puede ponerse en contacto con nosotros y le responderemos a la mayor brevedad posible.</p>
        </div>

        <!-- Texto de la izquierda -->
        <!-- Informacion sobre nosotros y preguntas frecuentes que hemos recibido -->
        <section class=" pt-10 grid  grid-cols-1 lg:grid-cols-2">
            <div id="InformaciondeContacto" class=" px-5 py-4 focus:outline-none ">
        
            <p class=" text-black font-bold text-lg md:text-xl p-2 lg:text-xl">Información de contacto</p>
            
            <div class="  mx-auto px-4 py-7 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-3 ">
                <div class="bg-white rounded-4xl p-8 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">
                    <!-- Icono email -->
                    <svg width="50px" height="50px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"><path d="M13.025 17H3.707l5.963-5.963L12 12.83l2.33-1.794 1.603 1.603a5.463 5.463 0 0 1 1.004-.41l-1.808-1.808L21 5.9v6.72a5.514 5.514 0 0 1 1 .64V5.5A1.504 1.504 0 0 0 20.5 4h-17A1.504 1.504 0 0 0 2 5.5v11A1.5 1.5 0 0 0 3.5 18h9.525c-.015-.165-.025-.331-.025-.5s.01-.335.025-.5zM3 16.293V5.901l5.871 4.52zM20.5 5c.009 0 .016.005.025.005L12 11.57 3.475 5.005c.009 0 .016-.005.025-.005zm-2 8a4.505 4.505 0 0 0-4.5 4.5 4.403 4.403 0 0 0 .05.5 4.49 4.49 0 0 0 4.45 4h.5v-1h-.5a3.495 3.495 0 0 1-3.45-3 3.455 3.455 0 0 1-.05-.5 3.498 3.498 0 0 1 5.947-2.5H20v.513A2.476 2.476 0 0 0 18.5 15a2.5 2.5 0 1 0 1.733 4.295A1.497 1.497 0 0 0 23 18.5v-1a4.555 4.555 0 0 0-4.5-4.5zm0 6a1.498 1.498 0 0 1-1.408-1 1.483 1.483 0 0 1-.092-.5 1.5 1.5 0 0 1 3 0 1.483 1.483 0 0 1-.092.5 1.498 1.498 0 0 1-1.408 1zm3.5-.5a.5.5 0 0 1-1 0v-3.447a3.639 3.639 0 0 1 1 2.447z"></path></svg>
                    <h4 class="text-xl font-bold mt-6 text-slate-800">Email</h4>
                    <a href="mailto:aliciaantonio@resetong.com" class="text-[#004e64] font-bold block hover:underline">aliciaantonio@resetong.com</a>
                    <p class="text-gray-500 mt-2">Puedes escribirnos cuando quieras, estaremos disponible para ti</p>
                </div>
                
                <div class=" bg-white rounded-4xl p-8 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">
                    <!-- Icono Telefono -->
                    <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.5562 14.5477L15.1007 15.0272C15.1007 15.0272 14.0181 16.167 11.0631 13.0559C8.10812 9.94484 9.1907 8.80507 9.1907 8.80507L9.47752 8.50311C10.1841 7.75924 10.2507 6.56497 9.63424 5.6931L8.37326 3.90961C7.61028 2.8305 6.13596 2.68795 5.26145 3.60864L3.69185 5.26114C3.25823 5.71766 2.96765 6.30945 3.00289 6.96594C3.09304 8.64546 3.81071 12.259 7.81536 16.4752C12.0621 20.9462 16.0468 21.1239 17.6763 20.9631C18.1917 20.9122 18.6399 20.6343 19.0011 20.254L20.4217 18.7584C21.3806 17.7489 21.1102 16.0182 19.8833 15.312L17.9728 14.2123C17.1672 13.7486 16.1858 13.8848 15.5562 14.5477Z" fill="#000000"></path> <path d="M13.2595 1.87983C13.3257 1.47094 13.7122 1.19357 14.1211 1.25976C14.1464 1.26461 14.2279 1.27983 14.2705 1.28933C14.3559 1.30834 14.4749 1.33759 14.6233 1.38082C14.9201 1.46726 15.3347 1.60967 15.8323 1.8378C16.8286 2.29456 18.1544 3.09356 19.5302 4.46936C20.906 5.84516 21.705 7.17097 22.1617 8.16725C22.3899 8.66487 22.5323 9.07947 22.6187 9.37625C22.6619 9.52466 22.6912 9.64369 22.7102 9.72901C22.7197 9.77168 22.7267 9.80594 22.7315 9.83125L22.7373 9.86245C22.8034 10.2713 22.5286 10.6739 22.1197 10.7401C21.712 10.8061 21.3279 10.53 21.2601 10.1231C21.258 10.1121 21.2522 10.0828 21.2461 10.0551C21.2337 9.9997 21.2124 9.91188 21.1786 9.79572C21.1109 9.56339 20.9934 9.21806 20.7982 8.79238C20.4084 7.94207 19.7074 6.76789 18.4695 5.53002C17.2317 4.29216 16.0575 3.59117 15.2072 3.20134C14.7815 3.00618 14.4362 2.88865 14.2038 2.82097C14.0877 2.78714 13.9417 2.75363 13.8863 2.7413C13.4793 2.67347 13.1935 2.28755 13.2595 1.87983Z" fill="#000000"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4857 5.3293C13.5995 4.93102 14.0146 4.7004 14.4129 4.81419L14.2069 5.53534C14.4129 4.81419 14.4129 4.81419 14.4129 4.81419L14.4144 4.81461L14.4159 4.81505L14.4192 4.81602L14.427 4.81834L14.4468 4.8245C14.4618 4.82932 14.4807 4.8356 14.5031 4.84357C14.548 4.85951 14.6074 4.88217 14.6802 4.91337C14.8259 4.97581 15.0249 5.07223 15.2695 5.21694C15.7589 5.50662 16.4271 5.9878 17.2121 6.77277C17.9971 7.55775 18.4782 8.22593 18.7679 8.7154C18.9126 8.95991 19.009 9.15897 19.0715 9.30466C19.1027 9.37746 19.1254 9.43682 19.1413 9.48173C19.1493 9.50418 19.1555 9.52301 19.1604 9.53809L19.1665 9.55788L19.1688 9.56563L19.1698 9.56896L19.1702 9.5705C19.1702 9.5705 19.1707 9.57194 18.4495 9.77798L19.1707 9.57194C19.2845 9.97021 19.0538 10.3853 18.6556 10.4991C18.2607 10.6119 17.8492 10.3862 17.7313 9.99413L17.7276 9.98335C17.7223 9.96832 17.7113 9.93874 17.6928 9.89554C17.6558 9.8092 17.5887 9.66797 17.4771 9.47938C17.2541 9.10264 16.8514 8.53339 16.1514 7.83343C15.4515 7.13348 14.8822 6.73078 14.5055 6.50781C14.3169 6.39619 14.1757 6.32909 14.0893 6.29209C14.0461 6.27358 14.0165 6.26254 14.0015 6.25721L13.9907 6.25352C13.5987 6.13564 13.3729 5.72419 13.4857 5.3293Z" fill="#000000"></path> </g></svg> 
                    <h4 class="text-xl font-bold mt-6 text-slate-800"><b>Teléfono</b></h4>
                    <p class="text-[#004e64] font-bold">+34 625 55 55 55</p>
                    <p class="text-gray-500">Lunes a Viernes, 8-15h</p>
                </div>

                <div class=" bg-white rounded-4xl p-8 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">
                    <!-- Icono ubicacion -->
                    <svg width="55px" height="55px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M309.2 584.776h105.5l-49 153.2H225.8c-7.3 0-13.3-6-13.3-13.3 0-2.6 0.8-5.1 2.2-7.3l83.4-126.7c2.5-3.6 6.7-5.9 11.1-5.9z" fill="#FFFFFF"></path><path d="M404.5 791.276H225.8c-36.7 0-66.5-29.8-66.5-66.5 0-13 3.8-25.7 11-36.6l83.4-126.7c12.3-18.7 33.1-29.9 55.5-29.9h178.4l-83.1 259.7z m-95.3-206.5c-4.5 0-8.6 2.2-11.1 6l-83.4 126.7c-1.4 2.2-2.2 4.7-2.2 7.3 0 7.3 6 13.3 13.3 13.3h139.9l49-153.2H309.2z" fill="#333333"></path><path d="M454.6 584.776h109.6l25.3 153.3H429.3z" fill="#FFFFFF"></path><path d="M652.2 791.276H366.6l42.8-259.6h200l42.8 259.6z m-222.9-53.2h160.2l-25.3-153.3H454.6l-25.3 153.3z" fill="#333333"></path><path d="M618.6 584.776h105.5c4.5 0 8.6 2.2 11.1 6l83.5 126.7c4 6.1 2.3 14.4-3.8 18.4-2.2 1.4-4.7 2.2-7.3 2.2H667.7l-49.1-153.3z" fill="#FFFFFF"></path><path d="M807.6 791.276H628.9l-83.1-259.7h178.4c22.4 0 43.2 11.2 55.5 29.9l83.4 126.7c9.8 14.8 13.2 32.6 9.6 50s-13.7 32.3-28.6 42.1c-10.8 7.2-23.5 11-36.5 11z m-139.9-53.2h139.9c2.6 0 5.1-0.8 7.3-2.2 4-2.6 5.3-6.4 5.7-8.4 0.4-2 0.7-6-1.9-10l-83.4-126.6c-2.5-3.8-6.6-6-11.1-6H618.6l49.1 153.2z" fill="#333333"></path><path d="M534.1 639.7C652.5 537.4 711.7 445.8 711.7 365c0-127-102.7-212.1-195-212.1s-195 85.1-195 212.1c0 80.8 59.2 172.3 177.7 274.7 9.9 8.6 24.7 8.6 34.7 0z" fill="#ff3b30"></path><path d="M516.7 672.7c-12.5 0-24.9-4.3-34.8-12.9C356.2 551.2 295.1 454.7 295.1 365c0-142.8 114.6-238.7 221.6-238.7S738.3 222.2 738.3 365c0 89.7-61.1 186.2-186.9 294.8-9.8 8.6-22.3 12.9-34.7 12.9z m0-493.2c-79.7 0-168.4 76.2-168.4 185.5 0 72.3 56.7 158 168.4 254.6C628.5 523 685.1 437.3 685.1 365c0-109.3-88.7-185.5-168.4-185.5z" fill="#333333"></path><path d="M516.7 348m-97.5 0a97.5 97.5 0 1 0 195 0 97.5 97.5 0 1 0-195 0Z" fill="#FFFFFF"></path><path d="M516.7 472.1c-68.4 0-124.1-55.7-124.1-124.1s55.7-124.1 124.1-124.1S640.8 279.5 640.8 348 585.1 472.1 516.7 472.1z m0-195.1c-39.1 0-70.9 31.8-70.9 70.9 0 39.1 31.8 70.9 70.9 70.9s70.9-31.8 70.9-70.9c0-39.1-31.8-70.9-70.9-70.9z" fill="#333333"></path></g></svg>
                    <h4 class="text-xl font-bold mt-6 text-slate-800"><b>Ubicación</b></h4>
                    <p class="text-[#004e64] font-bold">Lepe, Huelva</p>
                    <!-- Api de google maps de donde nos situamos-->
                    <div class="w-full lg:w-[170px] lg:h-[180px] md:w-[170] md:h-[180]">
                    <iframe class="w-full h-full rounded-lg" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3175.4900009912135!2d-7.211520187600835!3d37.25980607200345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1031db3f21c39d%3A0x25ae42e91b0f6fdb!2sAv.%20Arboleda%2C%2021440%20Lepe%2C%20Huelva!5e0!3m2!1ses!2ses!4v1769950943506!5m2!1ses!2ses"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <div class=" bg-white rounded-4xl p-8 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">
                    <!-- Icono Horario -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="black" d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-7 5h5v5h-5v-5z"/></svg>
                    <h4 class="text-xl font-bold mt-6 text-slate-800"><b>Horario</b></h4>
                    <p class="text-[#004e64] font-bold">Lun - Vie</p>
                    <p class="text-gray-500">8:15 - 14:45 h</p>
                    <p class="text-gray-500">Nuestro horario, para que podais contactar con nosotros si teneis algun problema</p>
                </div>

        </div>
            <!-- Preguntas frecuentes que hemos tenido que solventar-->
            <div class=" mb-4  py-16 ">
                <h3 class=" text-black font-bold text-lg md:text-xl p-2 lg:text-xl">Preguntas Frecuentes</h3><br>
                <div class="max-w-xl mx-auto space-y-4">
                <!-- FAQ 1 -->
                <details class="group rounded-xl border bg-white border-gray-200 p-4">
                    <summary class="flex cursor-pointer items-center justify-between text-lg font-bold text-slate-800">
                    ¿Cuánto cuesta el servicio?
                    <span class="transition group-open:rotate-180">⌄</span>
                    </summary>
                    <p class="m-3 text-gray-500">
                    RESET es una ONG sin animo de lucro. Aunque siempre tienes la opcion de poder donar algo por ayudarte.
                    </p>
                </details>
                <!-- FAQ 2 -->
                <details class="group rounded-xl border bg-white border-gray-200 p-4">
                    <summary class="flex cursor-pointer items-center justify-between text-lg font-bold text-slate-800">
                    ¿Cuánto tiempo tarda el proceso?
                    <span class="transition group-open:rotate-180">⌄</span>
                    </summary>
                    <p class="m-3 text-gray-500">
                    Depende de cada caso. Normalmente contactamos en 48h y el acompañamiento dura entre 1-6 meses.
                    </p>
                </details>

                <!-- FAQ 3 -->
                <details class="group rounded-xl border bg-white border-gray-200 p-4">
                    <summary class="flex cursor-pointer items-center justify-between text-lg font-bold text-slate-800">
                    ¿Puedo se voluntario desde cualquier país?
                    <span class="transition group-open:rotate-180">⌄</span>
                    </summary>
                    <p class="m-3 text-gray-500">
                    ¡Síii! TRabajamos 100% online, así que puedes participar desde cualquier lugar del mundo.
                    </p>
                </details>

                
            </div>
        </div>
        </div>


        <div id="Formulario" class="fade-in fade-in-2 max-w-100% grid">
                
                <form action="../app/controlador/ContactController.php" method="post" class="bg-white rounded-4xl p-8 border border-slate-100">
                        
                    <h3 class=" text-black font-bold text-lg md:text-xl p-2 lg:text-xl">Envíanos un mensaje</h3><br>
                <!-- Nombre y Email -->
                 
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                        <label class="block font-bold text-gray-800 my-5">Nombre *</label>
                        <input type="text" name="nombre_remitente" placeholder="Tu nombre" class="w-full rounded-xl border border-stone-300 px-5 py-4 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] " />
                        </div>

                        <div>
                        <label class="block font-bold text-gray-800 my-5">Email *</label>
                        <input type="email" name="email_remitente" placeholder="tu@email.com" class="w-full rounded-xl border border-stone-300 px-5 py-4 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] "  />
                        </div>
                    </div>

                    <!-- Asunto -->
                    <div>
                        <label class="block font-bold text-gray-800 my-5">Asunto *</label>
                        <input type="text" name="asunto" placeholder="¿De qué quieres hablar?" class="w-full rounded-xl border border-stone-300 px-5 py-4 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] "  />
                    </div>

                    <!-- Mensaje -->
                    <div>
                        <label class="block font-bold text-gray-800 my-5">Mensaje *</label>
                        <textarea rows="5" name="cuerpo_mensaje" placeholder="Hablanos de lo que te ocurre" class="w-full rounded-xl border border-stone-300 px-5 py-4 focus:outline-none focus:ring-2 focus:ring-[#00a5cf]  resize-none" ></textarea>
                    </div>

                    <div class="">
                        <?php if (isset($_SESSION['errores']) && !empty($_SESSION['errores'])): ?>
                                <div class="bg-red-100 border-l-4 border-[#ff3b30] text-[#ff3b30] p-4 mb-6 rounded shadow-sm animate-pulse">
                                    <ul class="text-sm text-red-700 space-y-1">
                                        <?php foreach ($_SESSION['errores'] as $campo => $mensajes): ?>
                                            <?php if (is_array($mensajes)): ?>
                                                <?php foreach ($mensajes as $mensaje): ?>
                                                    <li>• <?= htmlspecialchars($mensaje) ?></li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li>• <?= htmlspecialchars($mensajes) ?></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php unset($_SESSION['errores']); ?>
                            <?php if (isset($_SESSION['exito'])): ?>
                                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                                    <?= htmlspecialchars($_SESSION['exito']) ?>
                                </div>
                                <?php unset($_SESSION['exito']); ?>
                            <?php endif; ?>
                    </div>

                    <!-- Botón -->
                    <input type="submit" name="enviar" class="w-full mt-3 px-4 py-4  bg-[#00a5cf] text-white  hover:bg-black hover:text-white rounded-lg shadow-md  hover:shadow-lg  ">
                    </input>
                </form>

                
            </div>
        </section>

        
                 </main>
    <?php
    require_once "../src/components/footer.php";
    ?>

</body>
</html>