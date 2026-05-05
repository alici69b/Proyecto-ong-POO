<?php
//Inicializamos sesion
session_start();

//Variables de sesion
$mensajeError = $_SESSION["error_login"] ?? null;

//Unset de las variables de la sesion para evitar errores
if(isset($_SESSION["error_login"])) {
  unset($_SESSION["error_login"]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Inicio Sesión - RESET</title>

  <style>
      @keyframes slideOutLeft {
      from { opacity: 1; transform: translateX(0); }
      to   { opacity: 0; transform: translateX(-60px); }  
      }
      @keyframes slideInRight {
          from { opacity: 0; transform: translateX(60px); } 
          to   { opacity: 1; transform: translateX(0); }
      }
      body { animation: slideInRight 0.4s ease both; }
      body.saliendo { animation: slideOutLeft 0.3s ease both; }
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
  
  <div class="flex w-full flex-col justify-center px-8 md:px-16 lg:w-1/2 xl:px-24 bg-white">
    <div class="mx-auto w-full max-w-md">
      
      <a href="../../../pages/Inicio.php" class="mb-10 flex items-center text-sm text-gray-500 hover:text-gray-700">
        <span class="mr-2">←</span> Volver al inicio
      </a>

     
        <div class="flex items-center gap-2">
            <svg fill="#ff3b30" height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 612.00 612.00" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z"></path> <path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z"></path> </g> </g> </g></svg>
            <h3 class="font-bold text-xl">RESET</h3>
        </div>

      <h1 class="text-3xl font-bold text-gray-900">Bienvenido/a de vuelta</h1>
      <p class="mt-2 mb-8 text-gray-600">Accede a tu cuenta para continuar tu proceso RESET.</p>


      <form action="../../controlador/LoginController.php" method="POST" class="space-y-6">
<!-- Muestro los errores de el error del login  -->
        <?php if (isset($mensajeError)): ?>
          <div class="bg-red-100 border-l-4 border-[#ff3b30] text-[#ff3b30] p-4 mb-6 rounded shadow-sm animate-pulse">
              <p class="font-bold">Atención:</p>
              <p><?= $mensajeError ?></p>
          </div>
        <?php endif; ?>

        <div>
          <label for="email" class="block text-sm  text-gray-700">Email</label>
          <input type="email" name="email" placeholder="tu@email.com" class="mt-1 w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] " />
        </div>

        <div class="relative">
          <label for="pass" class="block text-sm  text-gray-700">Contraseña</label>
          <input type="password" name="pass" placeholder="••••••••" class="mt-1 w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-[#00a5cf] " />
          <button type="button" class="absolute right-3 top-10 text-gray-400 hover:text-gray-600">
          </button>
        </div>

        <div class="flex items-center justify-between">
          <label for="recordarDatos" class="flex items-center text-sm text-gray-600">
            <input name="recordarDatos" type="checkbox" class="mr-2 h-4 w-4 rounded border-gray-300 text-[#00a5cf] " />
            Recordarme
          </label>
          <a href="../auth/Reset_password.php" class="text-sm  text-[#00a5cf] hover:underline">¿Olvidaste tu contraseña?</a>
        </div>
<!-- Muestro los errores de los intentos  -->
        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#00a5cf] p-3 font-semibold text-white transition hover:bg-black" name="iniciar_sesion" id="iniciar_sesion">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
          Iniciar sesión
        </button>
      </form>

      <p class="mt-10 text-center text-sm text-gray-600">
        ¿No tienes cuenta? <a href="../auth/Register.php"  onclick="navegarCon(auth/Register.php)" class=" cursor-pointer font-bold text-[#00a5cf] hover:underline">Regístrate aquí</a>
      </p>
    </div>
  </div>

  <div class="hidden lg:flex lg:w-1/2 bg-linear-to-r from-[#00a5cf] to-[#9fffcb]  min-h-150  py-15 items-center justify-center text-white p-12">
    <div class="max-w-md text-center">
      <div class="mb-8 flex justify-center opacity-40">
        <svg class="animate-spin [animation-duration:10s] -scale-x100 w-32 h-32 " fill="#ff3b30" height="150px" width="150px" viewBox="0 0 612 612" xmlns="http://www.w3.org/2000/svg"><g><path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z"></path><path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z"></path></g></svg>
      </div>
      <h2 class="text-4xl font-extrabold mb-4">Tu proceso RESET te espera</h2>
      <p class="text-lg opacity-90 leading-relaxed">Cada día es una nueva oportunidad para seguir avanzando. Accede y continúa donde lo dejaste.</p>
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