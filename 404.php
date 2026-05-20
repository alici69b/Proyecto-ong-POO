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
<body class="bg-[#004e64] min-h-screen flex flex-col items-center ">

    <header class="fade-in fade-in-1 w-full flex justify-center pt-6 z-[110]">
        <div class="w-[95%] max-w-7xl">
            <?php require_once "src/components/Header_index.php"; ?>
        </div>
    </header>
        
    <div class="fade-in fade-in-2 text-7xl md:text-9xl  font-black text-white mt-30">Error 404</div>
    
    <main class="fade-in fade-in-3 flex-grow relative flex items-center justify-center overflow-hidden w-full px-4 my-10">
        
        

            <div class="relative z-10 bg-white/10 backdrop-blur-xl border border-white/20 flex flex-col items-center gap-8 rounded-3xl p-8  shadow-2xl text-center max-w-lg w-100 h-100">
                
                <div class="p-5 rounded-3xl bg-[#ff3b30]/20 animate-bounce">
                    <svg class="w-14 h-14 text-[#ff3b30]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <div class="">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-white">¡Te has salido del mapa!</h2>
                    <p class="text-white/70 text-lg ">La página que buscas no existe o ha sido movida a otra dimensión.</p>
                </div>
                
                <a href="index.php" class="w-full md:w-auto px-10 py-4 bg-[#ff3b30] text-white rounded-full font-bold hover:scale-105 transition-all shadow-lg shadow-[#ff3b30]/30">
                    Volver al inicio
                </a>
            </div>
        
    </main>

    <footer class="w-full">
        <?php require_once "src/components/footer_index.php"; ?>
    </footer>

</body>