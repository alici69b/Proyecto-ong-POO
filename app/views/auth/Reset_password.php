<?php
//Inicializamos sesion
session_start();

//Variables de sesion
$mensajeError = $_SESSION["error_login"] ?? null;

//Unset de las variables de la sesion para evitar errores
if (isset($_SESSION["error_login"])) {
  unset($_SESSION["error_login"]);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
  <title>Resetear Contraseña - RESET</title>

  <style>
    @keyframes shimmer {

      0%,
      100% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }
    }

    .fade-in {
      animation: fadeIn 0.5s ease both;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(16px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in-1 {
      animation-delay: 0.05s;
    }

    .fade-in-2 {
      animation-delay: 0.15s;
    }

    .fade-in-3 {
      animation-delay: 0.25s;
    }

    .fade-in-4 {
      animation-delay: 0.35s;
    }

    .fade-in-5 {
      animation-delay: 0.45s;
    }

    .fade-in-6 {
      animation-delay: 0.55s;
    }
  </style>

  <!-- Link del Tailwind -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
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

<body class="">

  <div class="flex min-h-screen">

    <div class=" fade-in fade-in-1 flex w-full items-center justify-center bg-white">
      <div class="mx-auto w-full max-w-md">

        <a href="../../../index.php" class="mb-5 flex items-center text-sm text-gray-500 hover:text-gray-700">
          <span class="mr-2">←</span> Volver al inicio
        </a>


        <div class="flex  items-center gap-2">
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

        <h1 class="text-3xl font-bold text-gray-900">Restablece tu contraseña</h1>
        <p class="mt-2 mb-8 text-gray-600">Aquí puedes restablecer tu contraseña si no te acuerdas.</p>



        <form action="/app/controlador/Reset_passwordController.php" method="POST">
          <label for="email">Introduce tu email</label><br>
          <input type="email" name="email_restablecer_contrasena" class="mt-1 w-full rounded-lg border mb-4 border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] " placeholder="ejemplo@gmail.com"><br>



          <input type="submit" class="flex mt-2 w-full items-center justify-center gap-2 rounded-lg bg-[#00a5cf] p-3 font-semibold text-white transition hover:bg-black" value="Restablecer" name="restablecer">
        </form>
        <?php if (isset($_GET['enviado'])): ?>
          <p style="color: green;">¡Revisa tu correo electrónico!</p>
        <?php endif; ?>


      </div>
    </div>



  </div>

  <script>
    function navegarCon(url) {
      document.body.classList.add('saliendo');
      setTimeout(() => window.location.href = url, 300); // espera a que termine la animación
    }
  </script>
</body>

</html>