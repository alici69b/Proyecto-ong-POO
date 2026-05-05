<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../public/img/Logo_RESET.svg">
    <title>Historias - RESET</title>

     
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
    color: coral principal #ff3b30
    color regundario #ffe7e5
    color: beige #f6f6f2
    color footer gray-900 
    color numeros conectados con la base de datos #1441a5
    -->

</head>
<!-- Script para efecto Sticky Stack -->
<!-- <script>
    window.addEventListener('scroll', () => {
        const cards = document.querySelectorAll('.story-card');
        
        cards.forEach((card) => {
            const rect = card.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            
            const scrollProgress = 1 - (rect.top / windowHeight);
            
            if (rect.top < windowHeight && rect.top > -rect.height) {
                // Solo escala, SIN opacidad (100% opaco siempre)
                const scale = Math.max(0.92, 1 - (scrollProgress * 0.03));
                
                card.style.transform = `scale(${scale})`;
                card.style.opacity = 1; // ✅ SIEMPRE opaco
            }
        });
    });
</script> -->
<body class=" bg-[#f4f9fa]" id="inicio">
    <!-- Importamos el Menú de navegación -->
    <?php
    require_once "../src/components/Header.php";
    ?>

    <!-- BOTON DE IR A INICIO -->
    <a href="#inicio" class="fixed bottom-10 right-10 z-[9999] p-3 rounded-full bg-[#25a18e] text-white hover:bg-[#1a7a6b] transition-all shadow-xl flex items-center justify-center border-2 border-white/20" aria-label="Volver al inicio"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
    </a>

    <main class="fade-in fade-in-1 max-w-7xl mx-auto px-4 py-12 pt-25">
        
        <div>

            <!-- Título -->
             <div class="text-center pt-15 pb-15">
                <p class="text-[#00a5cf] font-bold text-sm tracking-[0.2em] uppercase 4 opacity-90">
                        Historias de reset
                    </p>
                <h1 class="font-['Domine']  text-slate-800 md:text-6xl lg:text-6xl text-4xl font-bold mb-4">
                    El antes y después de no  <i class="bg-linear-to-r from-[#00a5cf] to-[#9fffcb] bg-clip-text text-transparent">rendirse</i>
                </h1>
                <p class="text-gray-500 max-w-2xl mx-auto  sm:text-lg sm:p-2 lg:text-lg px-7">Personas reales que decidieron darse otra oportunidad. Lee sus historias y encuentra inspiración para la tuya.</p>
            </div>
            
            <!-- Contenedor Sticky -->
             <!-- relative min-h-[300vh] -->
            <div class="">
                <!-- Historias de Éxito ( Contenido Principal ) -->
                <!-- Primera Historia -->
                <!-- He quitado story-card sticky de cada card -->
                <div class="top-24 flex flex-col lg:flex-row gap-12 items-center mb-12 transition-all duration-300 bg-white rounded-3xl shadow-2xl p-6 z-10">
                    <!-- Foto -->
                    <div class="w-full lg:w-auto shrink-0 flex justify-center lg:justify-end"> 
                        <div class="relative inline-block"> 
                            <img src="../public/img/MariaGarcia.jpg" alt="María García" class="w-100 h-100 aspect-square object-cover rounded-3xl shadow-medium">
                            <!-- Etiqueta Foto -->
                            <div class="absolute -bottom-4 -right-4 px-4 py-2 rounded-xl text-sm font-medium shadow-lg text-white bg-teal-600">
                                Estudios
                            </div>
                        </div>
                    </div>  
                    <!-- Card -->
                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col lg:flex-row gap-6">
                        <!-- Card Historia -->
                        <div class="lg:w-auto p-8 lg:p-12 flex flex-col">
                            <div class="relative mb-8">
                                <!-- Icono Comillas -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-quote text-teal-600 opacity-30"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" /><path d="M18 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" /></svg>
                                <!--Titulo-->
                                <h1 class="text-2xl lg:text-3xl font-bold ml-0">De abandonar Enfermería a estar en mi último año</h1>
                            </div>
                            <!-- Card Antes y Despues -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Card Antes -->
                                <div class="bg-red-50 rounded-2xl p-6">
                                    <p class="text-sm font-semibold text-orange-600 mb-2">ANTES</p>
                                    <p class="text-gray-700 text-sm leading-relaxed">Dejé la carrera en segundo año cuando murió mi padre. No podía concentrarme, no tenía fuerzas. Los años pasaron y cada vez me parecía más imposible volver.</p>
                                </div>
                                <!-- Card Después -->
                                <div class="bg-teal-50 rounded-2xl p-6">
                                    <p class="text-sm font-semibold text-teal-600 mb-2">DESPUÉS</p>
                                    <p class="text-gray-700 text-sm leading-relaxed">Gracias a RESET y a mi voluntaria Ana, que también había pasado por algo similar, encontré la forma de retomarlo. Hoy estoy en mi último año y me graduaré con honores.</p>
                                </div>
                            </div>
                            <!-- Card Footer -->
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <!--Nombre-->
                                <div class="flex items-center gap-3">
                                    <img src="../public/img/MariaGarcia.jpg" class="h-10 rounded-full object-cover">
                                    <div>
                                        <p class="font-semibold">María García</p>
                                        <p class="text-gray-500 text-sm">28 años</p> 
                                    </div>
                                </div>
                                <!--Separador-->
                                <div class="h-8 w-px bg-gray-300"></div>
                                <!--Voluntario-->
                                <div class="flex items-center gap-1">
                                    <p>
                                        <span class="text-gray-500">Voluntario:</span>
                                        <span class="font-medium text-gray-800"> Ana López</span>
                                    </p>
                                </div>
                                <!--Separador-->
                                <div class="h-8 w-px bg-gray-300"></div>
                                <!--Duración-->
                                <div class="flex items-center gap-1">
                                    <p>
                                        <span class="text-gray-500">Duración:</span>
                                        <span class="font-medium text-gray-800"> 8 meses</span>
                                    </p>
                                </div>
                            </div>
                            <!-- Valoración -->
                            <div class="flex gap-1 text-yellow-400 ml-auto cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                            </div> 
                        </div> 
                    </div>
                </div>

                <!-- Segunda Historia -->
                <div class="top-32 flex flex-col lg:flex-row-reverse gap-12 items-center mb-12 transition-all duration-300 bg-white rounded-3xl shadow-2xl p-6 z-20">
                    <!-- Foto -->
                    <div class="w-full lg:w-auto shrink-0 flex justify-center lg:justify-end"> 
                        <div class="relative"> 
                            <img src="../public/img/CarlosRuiz.jpg" alt="María García" class="w-100 h-100 aspect-square object-cover rounded-3xl shadow-medium">
                            <!-- Etiqueta Foto -->
                            <div class="absolute -bottom-4 -right-4 px-4 py-2 rounded-xl text-sm font-medium shadow-lg text-white bg-teal-600">
                                Proyecto
                            </div>
                        </div>
                    </div>  
                    <!-- Card -->
                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col lg:flex-row gap-6">
                        <!-- Card Historia -->
                        <div class="lg:w-auto p-8 lg:p-12 flex flex-col">
                            <div class="relative mb-8">
                                <!-- Icono Comillas -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-quote text-teal-600 opacity-30"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" /><path d="M18 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" /></svg>
                                <!--Titulo-->
                                <h1 class="text-2xl lg:text-3xl font-bold ml-0">Mi tienda online que llevaba 2 años en un cajón</h1>
                            </div>
                            <!-- Card Antes y Despues -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Card Antes -->
                                <div class="bg-red-50 rounded-2xl p-6">
                                    <p class="text-sm font-semibold text-orange-600 mb-2">ANTES</p>
                                    <p class="text-gray-700 text-sm leading-relaxed">Tenía el proyecto, el producto, los proveedores... pero el miedo al fracaso me paralizaba. Cada día que pasaba era más difícil empezar.</p>
                                </div>
                                <!-- Card Después -->
                                <div class="bg-teal-50 rounded-2xl p-6">
                                    <p class="text-sm font-semibold text-teal-600 mb-2">DESPUÉS</p>
                                    <p class="text-gray-700 text-sm leading-relaxed">Mi mentor Pablo me ayudó a ver que el único obstáculo era yo mismo. Lanzamos juntos en 3 meses. Hoy facturo 4.000€ mensuales vendiendo artesanía local.</p>
                                </div>
                            </div>
                            <!-- Card Footer -->
                            <div class="flex flex-wrap items-center gap-6 text-sm">
                                <!--Contenido-->
                                <div class="flex items-center gap-3">
                                    <img src="../public/img/CarlosRuiz.jpg" class="h-10 rounded-full object-cover">
                                    <div>
                                        <p class="font-semibold ">Carlos Ruiz</p>
                                        <p class="text-gray-500 text-sm">34 años</p> 
                                    </div>
                                </div>
                                <!--Separador-->
                                <div class="h-8 w-px bg-gray-300"></div>
                                <!--Contenido-->
                                <div class="hidden sm:block">
                                    <p>
                                        <span class="text-gray-500">Voluntario:</span>
                                        <span class="font-medium text-gray-800"> Pablo Fernández</span>
                                    </p>
                                </div>
                                <!--Separador-->
                                <div class="h-8 w-px bg-gray-300"></div>
                                <!--Contenido-->
                                <div class="hidden sm:block">
                                    <p>
                                        <span class="text-gray-500">Duración:</span>
                                        <span class="font-medium text-gray-800"> 4 meses</span>
                                    </p>
                                </div>
                            </div>
                            <!-- Valoración -->
                            <div class="flex gap-1 text-yellow-400 ml-auto cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                            </div> 
                        </div> 
                    </div>
                </div>

                <!-- Tercera Historia -->
                <div class="top-40 flex flex-col lg:flex-row gap-12 items-center mb-12 transition-all duration-300 bg-white rounded-3xl shadow-2xl p-6 z-30">
                    <!-- Foto -->
                    <div class="w-full lg:w-auto shrink-0 flex justify-center lg:justify-end"> 
                        <div class="relative inline-block"> 
                            <img src="../public/img/LauraMartinez.jpg" alt="María García" class="w-100 h-100 aspect-square object-cover rounded-3xl shadow-medium">
                            <!-- Etiqueta Foto -->
                            <div class="absolute -bottom-4 -right-4 px-4 py-2 rounded-xl text-sm font-medium shadow-lg text-white bg-teal-600">
                                Creatividad
                            </div>
                        </div>
                    </div>  
                    <!-- Card -->
                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col lg:flex-row gap-6">
                        <!-- Card Historia -->
                        <div class="lg:w-auto p-8 lg:p-12 flex flex-col">
                            <div class="relative mb-8">
                                <!-- Icono Comillas -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-quote text-teal-600 opacity-30"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" /><path d="M18 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" /></svg>
                                <!--Titulo-->
                                <h1 class="text-2xl lg:text-3xl font-bold ml-0">Volver a pintar después de ser madre</h1>
                            </div>
                            <!-- Card Antes y Despues -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Card Antes -->
                                <div class="bg-red-50 rounded-2xl p-6">
                                    <p class="text-sm font-semibold text-orange-600 mb-2">ANTES</p>
                                    <p class="text-gray-700 text-sm leading-relaxed">Dejé de pintar cuando nació mi hijo. Creía que era egoísta dedicarme tiempo a mí. 5 años sin tocar un pincel.</p>
                                </div>
                                <!-- Card Después -->
                                <div class="bg-teal-50 rounded-2xl p-6">
                                    <p class="text-sm font-semibold text-teal-600 mb-2">DESPUÉS</p>
                                    <p class="text-gray-700 text-sm leading-relaxed">RESET me conectó con una artista que había pasado por lo mismo. Me ayudó a ver que cuidarme también era cuidar a mi familia. Ahora tengo mi propia exposición en una galería local.</p>
                                </div>
                            </div>
                            <!-- Card Footer -->
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <!--Nombre-->
                                <div class="flex items-center gap-3">
                                    <img src="../public/img/LauraMartinez.jpg" class="h-10 rounded-full object-cover">
                                    <div>
                                        <p class="font-semibold">María García</p>
                                        <p class="text-gray-500 text-sm">29 años</p> 
                                    </div>
                                </div>
                                <!--Separador-->
                                <div class="h-8 w-px bg-gray-300"></div>
                                <!--Voluntario-->
                                <div class="flex items-center gap-1">
                                    <p>
                                        <span class="text-gray-500">Voluntario:</span>
                                        <span class="font-medium text-gray-800"> Elena Santos</span>
                                    </p>
                                </div>
                                <!--Separador-->
                                <div class="h-8 w-px bg-gray-300"></div>
                                <!--Duración-->
                                <div class="flex items-center gap-1">
                                    <p>
                                        <span class="text-gray-500">Duración:</span>
                                        <span class="font-medium text-gray-800"> 6 meses</span>
                                    </p>
                                </div>
                            </div>
                            <!-- Valoración -->
                            <div class="flex gap-1 text-yellow-400 ml-auto cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                            </div> 
                        </div> 
                    </div>
                </div>

                <!-- Cuarta Historia -->
                <div class="top-40 flex flex-col lg:flex-row-reverse gap-12 items-center mb-12 transition-all duration-300 bg-white rounded-3xl shadow-2xl p-6 z-40">
                    <!-- Foto -->
                    <div class="w-full lg:w-auto shrink-0 flex justify-center lg:justify-end"> 
                        <div class="relative"> 
                            <img src="../public/img/JavierMoreno.jpg" alt="María García" class="w-100 h-100 aspect-square object-cover rounded-3xl shadow-medium">
                            <!-- Etiqueta Foto -->
                            <div class="absolute -bottom-4 -right-4 px-4 py-2 rounded-xl text-sm font-medium shadow-lg text-white bg-teal-600">
                                Salud
                            </div>
                        </div>
                    </div>  
                    <!-- Card -->
                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col lg:flex-row gap-6">
                        <!-- Card Historia -->
                        <div class="lg:w-auto p-8 lg:p-12 flex flex-col">
                            <div class="relative mb-8">
                                <!-- Icono Comillas -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-quote text-teal-600 opacity-30"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" /><path d="M18 5a2 2 0 0 1 2 2v6c0 3.13 -1.65 5.193 -4.757 5.97a1 1 0 1 1 -.486 -1.94c2.227 -.557 3.243 -1.827 3.243 -4.03v-1h-3a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-3a2 2 0 0 1 2 -2z" /></svg>
                                <!--Titulo-->
                                <h1 class="text-2xl lg:text-3xl font-bold ml-0">Del sofá a mi primera media maratón</h1>
                            </div>
                            <!-- Card Antes y Despues -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Card Antes -->
                                <div class="bg-red-50 rounded-2xl p-6">
                                    <p class="text-sm font-semibold text-orange-600 mb-2">ANTES</p>
                                    <p class="text-gray-700 text-sm leading-relaxed">La pandemia me destruyó físicamente. Gané 15 kilos, dejé todo tipo de ejercicio. Me daba vergüenza hasta salir a la calle.</p>
                                </div>
                                <!-- Card Después -->
                                <div class="bg-teal-50 rounded-2xl p-6">
                                    <p class="text-sm font-semibold text-teal-600 mb-2">DESPUÉS</p>
                                    <p class="text-gray-700 text-sm leading-relaxed">Mi coach de RESET, que había perdido 40 kilos, me entendía perfectamente. Paso a paso, sin presiones. Hace un mes corrí mi primera media maratón.</p>
                                </div>
                            </div>
                            <!-- Card Footer -->
                            <div class="flex flex-wrap items-center gap-6 text-sm">
                                <!--Contenido-->
                                <div class="flex items-center gap-3">
                                    <img src="../public/img/JavierMoreno.jpg" class="h-10 rounded-full object-cover">
                                    <div>
                                        <p class="font-semibold ">Javier Moreno</p>
                                        <p class="text-gray-500 text-sm">31 años</p> 
                                    </div>
                                </div>
                                <!--Separador-->
                                <div class="h-8 w-px bg-gray-300"></div>
                                <!--Contenido-->
                                <div class="hidden sm:block">
                                    <p>
                                        <span class="text-gray-500">Voluntario:</span>
                                        <span class="font-medium text-gray-800"> Roberto Silva</span>
                                    </p>
                                </div>
                                <!--Separador-->
                                <div class="h-8 w-px bg-gray-300"></div>
                                <!--Contenido-->
                                <div class="hidden sm:block">
                                    <p>
                                        <span class="text-gray-500">Duración:</span>
                                        <span class="font-medium text-gray-800"> 12 meses</span>
                                    </p>
                                </div>
                            </div>
                            <!-- Valoración -->
                            <div class="flex gap-1 text-yellow-400 ml-auto cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" /></svg>
                            </div> 
                        </div> 
                    </div>
                </div> 
            </div>  

            <!-- Card para Solicitar RESET -->
            <div class="pt-12 text-center relative z-50">
                <div class="bg-linear-to-r from-[#00a5cf] to-[#78d4a1] rounded-3xl p-12 text-white shadow-lg">
                    <h1 class="text-3xl lg:text-4xl font-bold mb-4">Tu historia puede ser la próxima</h1>
                    <p class="text-lg lg:text-xl mb-8 leading-relaxed">Cada una de estas personas estuvo donde tú estás ahora. El primer paso es siempre el más difícil, pero no tienes que darlo solo/a.</p>
                    <a href="RequestReset.php" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-red-600/80 font-bold rounded-xl shadow-md hover:bg-red-600/80 hover:text-white transition-colors duration-300">
                        Solicitar mi RESET 
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-right-dashed"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12h.5m3 0h1.5m3 0h6" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </main>
    <!-- Importamos el footer -->
    <footer>
    <?php
    require_once "../src/components/footer.php";
    ?>    
    </footer>
    
</body>
</html>