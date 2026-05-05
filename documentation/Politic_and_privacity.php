<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../public/img/Logo_RESET.svg">
    <title>Política de Privacidad - RESET</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&family=Domine:wght@700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background-color: #f4f9fa;
;
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
            Política de Privacidad
        </h1>
    </header>

    <main class="w-full max-w-4xl bg-white rounded-[40px] shadow-2xl shadow-[#004e64]/5 p-8 md:p-16 border border-white relative overflow-hidden">
        
        <section class="mb-16">
            <div class="flex items-center gap-4 mb-8">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#9fffcb]/30 text-[#25a18e] font-bold">1</span>
                <h2 class="text-2xl font-bold">Responsable del Tratamiento</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-[#f4f9fa] p-6 rounded-3xl border border-blue-50">
                    <p class="text-[10px] uppercase tracking-widest text-[#00a5cf] font-bold mb-1">Centro Educativo</p>
                    <p class="font-bold text-lg text-[#004e64]">IES LA ARBOLEDA</p>
                    <p class="text-sm text-gray-500 mt-2 italic">Avenida La Arboleda, Lepe (Huelva)</p>
                </div>
                <div class="bg-[#f4f9fa] p-6 rounded-3xl border border-blue-50">
                    <p class="text-[10px] uppercase tracking-widest text-[#00a5cf] font-bold mb-1">Contacto Privacidad</p>
                    <p class="font-bold text-[#25a18e] underline">aliciantonio@resetong.com</p>
                    <p class="text-sm text-gray-500 mt-2">Atención: Alicia y Antonio</p>
                </div>
            </div>
        </section>

        <section class="mb-16">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#00a5cf]/10 text-[#00a5cf] font-bold">2</span>
                <h2 class="text-2xl font-bold">Finalidad del Tratamiento</h2>
            </div>
            <p class="text-lg leading-relaxed text-gray-600 mb-4">Los datos personales recogidos serán utilizados exclusivamente para:</p>
            <ul class="space-y-3 text-lg text-gray-600 list-disc pl-6">
                <li>Gestionar consultas realizadas a través de la web.</li>
                <li>Organizar la participación en el proyecto <strong class="text-[#004e64]">“Segundas Oportunidades”</strong>.</li>
                <li>Realizar seguimiento educativo y orientación académica.</li>
                <li>Cumplir con las obligaciones legales aplicables.</li>
            </ul>
        </section>

        <section class="mb-16">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#00a5cf]/10 text-[#00a5cf] font-bold">3</span>
                <h2 class="text-2xl font-bold">Legitimación</h2>
            </div>
            <p class="text-lg leading-relaxed text-gray-600">
                La base legal es el consentimiento del interesado al contactar o participar voluntariamente en el proyecto educativo.
            </p>
        </section>

        <section class="mb-16">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#00a5cf]/10 text-[#00a5cf] font-bold">4</span>
                <h2 class="text-2xl font-bold">Conservación de Datos</h2>
            </div>
            <p class="text-lg leading-relaxed text-gray-600">
                Los datos se conservarán únicamente durante el tiempo necesario para la finalidad educativa del proyecto y posteriormente serán eliminados de forma segura.
            </p>
        </section>

        <section class="mb-16">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#00a5cf]/10 text-[#00a5cf] font-bold">5</span>
                <h2 class="text-2xl font-bold">Cesión de Datos</h2>
            </div>
            <p class="text-lg leading-relaxed text-gray-600">
                No se cederán datos a terceros, salvo que exista una obligación legal o sea estrictamente necesario para el desarrollo del proyecto.
            </p>
        </section>

        <section class="mb-16">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#00a5cf]/10 text-[#00a5cf] font-bold">6</span>
                <h2 class="text-2xl font-bold">Sus Derechos</h2>
            </div>
            <p class="text-lg leading-relaxed text-gray-600">
                Puede ejercer sus derechos de acceso, rectificación o supresión enviando una solicitud al correo electrónico indicado en el apartado de contacto.
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