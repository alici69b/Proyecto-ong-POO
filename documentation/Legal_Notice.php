<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../public/img/Logo_RESET.svg">
    <title>Aviso Legal - RESET</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&family=Domine:wght@700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa;
        }
        h1, h2 { font-family: 'Domine', serif; }
    </style>
</head>

<body class="min-h-screen lg:mt-40 flex flex-col items-center p-6 md:p-12 text-[#004e64]">

<!-- Importamos el Menú de navegación -->
    <?php
    require_once "../src/components/Header_documentation.php";
    ?>

    <header class="text-center mb-10">
        <h1 class="text-5xl md:text-6xl font-extrabold bg-linear-to-r from-[#00a5cf] to-[#9fffcb] bg-clip-text text-transparent inline-block pb-2">
            Aviso Legal
        </h1>
        
        
    </header>

    <main class="w-full max-w-4xl bg-white rounded-[40px] shadow-2xl shadow-[#004e64]/5 p-8 md:p-16 border border-white relative overflow-hidden">
        
        <section class="mb-16">
            <div class="flex items-center gap-4 mb-8">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#9fffcb]/30 text-[#25a18e] font-bold">1</span>
                <h2 class="text-2xl font-bold">Datos Identificativos</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-[#f4f9fa] p-6 rounded-3xl border border-blue-50">
                    <p class="text-[10px] uppercase tracking-widest text-[#00a5cf] font-bold mb-1">Titular</p>
                    <p class="font-bold text-lg">Alicia ALonso Aguaded</p>
                    <p class="font-bold text-lg">Antonio Jesús Carrasco Prieto</p>
                    <p class="text-sm text-gray-500 mt-2">Ies La Arboleda</p>
                    
                </div>
                <div class="bg-[#f4f9fa] p-6 rounded-3xl border border-blue-50">
                    <p class="text-[10px] uppercase tracking-widest text-[#00a5cf] font-bold mb-1">Contacto</p>
                    <p class="font-bold text-[#25a18e] underline">aliciantonio@resetong.com</p>
                    <p class="text-sm text-gray-500 mt-2">+34 625 55 55 55 | Lepe, Huelva | AV. La Arboleda</p>
                </div>
            </div>
        </section>

        <section class="mb-16">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#00a5cf]/10 text-[#00a5cf] font-bold">2</span>
                <h2 class="text-2xl font-bold">Finalidad del Sitio Web</h2>
            </div>
            <p class="text-lg leading-relaxed text-gray-600">
                Informar sobre el proyecto educativo <strong class="text-[#004e64]">“Segundas Oportunidades”</strong>, orientado al acompañamiento, motivación y orientación académica y profesional de personas que desean retomar su desarrollo formativo o laboral.
            </p>
        </section>

        <section class="mb-16">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#00a5cf]/10 text-[#00a5cf] font-bold">3</span>
                <h2 class="text-2xl font-bold">Condiciones de Uso</h2>
            </div>
            <p class="text-lg leading-relaxed text-gray-600">
                El usuario se compromete a hacer un uso adecuado de los contenidos y a no emplearlos para actividades ilícitas o contrarias a la buena fe.
            </p>
        </section>


        <section class="mb-16">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#00a5cf]/10 text-[#00a5cf] font-bold">4</span>
                <h2 class="text-2xl font-bold">Propiedad Intelectual</h2>
            </div>
            <p class="text-lg leading-relaxed text-gray-600">
                Contenidos propiedad del centro o autorizados. Queda prohibida su reproducción sin autorización expresa.
            </p>
        </section>


        <section class="mb-16">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#00a5cf]/10 text-[#00a5cf] font-bold">5</span>
                <h2 class="text-2xl font-bold">Responsabilidad</h2>
            </div>
            <p class="text-lg leading-relaxed text-gray-600">
                El centro no se responsabiliza del uso indebido ni garantiza la ausencia de errores técnicos, aunque trabaja para evitarlos.
            </p>
        </section>

        <section class="mb-16">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#00a5cf]/10 text-[#00a5cf] font-bold">6</span>
                <h2 class="text-2xl font-bold">Enlaces Externos</h2>
            </div>
            <p class="text-lg leading-relaxed text-gray-600">
                No nos responsabilizamos de los contenidos o políticas de privacidad de páginas externas enlazadas.
            </p>
        </section>
    
        <footer class="mt-16 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-300">Reset © 2026</p>
        
        </footer>
    </main>

    <a href="../index.php" class="mt-12 group flex items-center gap-3 text-[#004e64] font-bold hover:text-[#00a5cf] transition-all">
        <span class="bg-white w-10 h-10 flex items-center justify-center rounded-full shadow-md group-hover:scale-110 transition-transform">←</span>
        Volver al inicio
    </a>

</body>
</html>