<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// haremos que la session se cierre a la hora si esta insactivo 
$sessionTimeout = 3600;
//
if (!empty($_SESSION['logged_in']) && isset($_SESSION['LAST_ACTIVITY'])) {
    $inactiveTime = time() - $_SESSION['LAST_ACTIVITY'];
    if ($inactiveTime > $sessionTimeout) {
        $_SESSION = [];
        session_destroy();
        header('Location: /Proyecto-ong-POO/index.php');
        exit();
    }
}
if (!empty($_SESSION['logged_in'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
}

$loggedIn = !empty($_SESSION['logged_in']);
$nombre = $_SESSION['user_nombre'] ?? '';
$inicial = mb_strtoupper(mb_substr($nombre, 0, 1));
$rol = $_SESSION['user_rol'] ?? '';

if ($rol === 'admin') {
    $dashboard_url = '/Proyecto-ong-POO/app/controllers/controller_admin_dashboard.php';
} elseif ($rol === 'soy-voluntario') {
    $dashboard_url = '/Proyecto-ong-POO/app/controllers/controller_volunteer_dashboard.php';
} else {
    $dashboard_url = '/Proyecto-ong-POO/app/controllers/controller_user_dashboard.php';
}
?>
<nav class="absolute top-6 left-1/2 -translate-x-1/2 w-[95%] max-w-7xl bg-white/60 backdrop-blur-md border border-white/10 shadow-lg rounded-full z-[100] px-6 py-3 flex items-center justify-between">

    <div class="flex-1 flex justify-start">
        <a href="/Proyecto-ong-POO/index.php" class="flex items-center gap-2 hover:opacity-80 transition group">
            <svg fill="#ff3b30" class="w-8 h-8 md:w-9 md:h-9 transition-transform group-hover:rotate-12" viewBox="0 0 612.00 612.00">
                <path d="M44.563,250.179l237.89,41.871c0.485,0.085,0.964,0.118,1.451,0.118c4.33-0.027,7.831-3.545,7.831-7.88 c0-1.831-0.624-3.516-1.672-4.853l-39.919-61.25c24.027-10.024,64.762-23.283,112.095-23.283c24.594,0,48.118,3.69,69.918,10.972 c19.861,6.631,47.495,24.447,70.4,45.389c16.415,15.01,31.403,32.073,45.896,48.573c3.34,3.802,6.682,7.607,10.048,11.396 c1.521,1.713,3.677,2.648,5.894,2.648c0.788,0,1.581-0.116,2.357-0.361c2.961-0.928,5.101-3.508,5.468-6.588l0.116-0.991 c6.506-56.017-7.174-114.855-37.531-161.427c-32.502-49.852-84.035-85.972-145.111-101.71 c-24.353-6.275-49.973-9.456-76.149-9.456c-34.717,0-69.827,5.501-104.373,16.35c-18.876,5.971-37.136,13.429-54.376,22.198 L110.264,3.574c-1.714-2.631-4.832-3.978-7.921-3.467c-3.096,0.526-5.584,2.838-6.333,5.887L38.278,240.535 c-0.521,2.118-0.142,4.359,1.05,6.186C40.519,248.549,42.415,249.802,44.563,250.179z"></path>
                <path d="M572.67,365.274c-1.191-1.827-3.087-3.08-5.236-3.458l-237.888-41.872c-3.094-0.54-6.212,0.8-7.942,3.419 c-1.73,2.619-1.74,6.017-0.027,8.648l40.278,61.802c-24.027,10.024-64.762,23.283-112.093,23.283 c-24.594,0-48.118-3.692-69.92-10.974c-19.864-6.632-47.498-24.449-70.4-45.389c-16.415-15.01-31.403-32.071-45.896-48.568 c-3.34-3.803-6.684-7.608-10.049-11.398c-2.065-2.323-5.301-3.219-8.265-2.282c-2.964,0.935-5.101,3.526-5.456,6.612l-0.111,0.962 c-6.508,56.021,7.172,114.855,37.532,161.42c32.5,49.855,84.034,85.977,145.109,101.712c24.358,6.275,49.982,9.456,76.16,9.456 c0.003,0,0.002,0,0.007,0c34.71,0,69.819-5.499,104.355-16.35c18.876-5.971,37.136-13.427,54.375-22.196l44.53,68.321 c1.47,2.255,3.967,3.578,6.6,3.578c0.438,0,0.88-0.036,1.321-0.109c3.096-0.526,5.583-2.838,6.335-5.887l57.734-234.541 C574.242,369.342,573.863,367.103,572.67,365.274z"></path>
            </svg>
            <h3 class="font-black text-xl tracking-tighter">RESET</h3>
        </a>
    </div>

    <div class="hidden md:flex flex-none items-center justify-center gap-6">
        <a class="text-gray-600 hover:text-[#25a18e] font-medium transition" href="/Proyecto-ong-POO/pages/Inicio.php">Inicio</a>
        <a class="text-gray-600 hover:text-[#25a18e] font-medium transition" href="/Proyecto-ong-POO/pages/Historys.php">Historias</a>
        <a class="text-gray-600 hover:text-[#25a18e] font-medium transition" href="/Proyecto-ong-POO/pages/Impact.php">Impacto</a>
        <a class="text-gray-600 hover:text-[#25a18e] font-medium transition" href="/Proyecto-ong-POO/pages/Contact.php">Contacto</a>
    </div>

    <div class="flex-1 flex justify-end items-center gap-3">
        <div class="hidden md:flex items-center gap-3">
            <?php if ($loggedIn): ?>
            <a href="<?= $dashboard_url ?>" class="flex items-center gap-2 text-sm font-bold text-[#004e64] hover:text-[#00a5cf] transition mr-1 bg-white/60 px-2 py-1 rounded-full backdrop-blur-sm">
                <span class="w-7 h-7 rounded-full bg-[#004e64] flex items-center justify-center text-white text-xs font-bold"><?= $inicial ?></span>
                <?= htmlspecialchars($nombre) ?>
            </a>
            <a class="px-3 py-2 text-[#004e64] hover:text-[#00a5cf] transition font-bold text-sm" href="/Proyecto-ong-POO/app/controllers/controller_profile.php" title="Configuración">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
            </a>
            <a class="px-5 py-2 bg-[#25a18e] text-white rounded-full hover:bg-[#1a7a6b] transition font-bold text-sm shadow-md" href="/Proyecto-ong-POO/app/controllers/controller_logout.php">Cerrar Sesión</a>
            <?php else: ?>
            <a class="px-5 py-2 border-2 border-[#25a18e] text-[#25a18e] rounded-full hover:bg-[#25a18e] hover:text-white transition font-bold text-sm" href="/Proyecto-ong-POO/app/controllers/controller_login.php">Iniciar Sesión</a>
            <a class="px-5 py-2 bg-[#25a18e] text-white rounded-full hover:bg-[#1a7a6b] transition font-bold text-sm shadow-md" href="/Proyecto-ong-POO/app/controllers/controller_register.php">Registro</a>
            <?php endif; ?>
        </div>

        <div class="md:hidden flex items-center">
            <input type="checkbox" id="menu-toggle" class="peer hidden" />
            <label for="menu-toggle" class="cursor-pointer p-2 rounded-lg hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#004e64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </label>
            <div class="absolute top-full left-0 right-0 mt-4 mx-2 bg-white rounded-2xl shadow-2xl border border-gray-100 flex-col hidden peer-checked:flex overflow-hidden animate-in fade-in slide-in-from-top-4 duration-300">
                <a class="px-6 py-4 hover:bg-gray-50 text-gray-700 border-b border-gray-50" href="/Proyecto-ong-POO/pages/Inicio.php">Inicio</a>
                <a class="px-6 py-4 hover:bg-gray-50 text-gray-700 border-b border-gray-50" href="/Proyecto-ong-POO/pages/Historys.php">Historias</a>
                <a class="px-6 py-4 hover:bg-gray-50 text-gray-700 border-b border-gray-50" href="/Proyecto-ong-POO/pages/Impact.php">Impacto</a>
                <a class="px-6 py-4 hover:bg-gray-50 text-gray-700 border-b border-gray-50" href="/Proyecto-ong-POO/pages/Contact.php">Contacto</a>
                <div class="bg-gray-50 flex flex-col gap-1 p-4">
                    <?php if ($loggedIn): ?>
                    <a class="w-full py-3 text-center border-2 border-[#00a5cf] text-[#00a5cf] rounded-xl font-bold" href="/Proyecto-ong-POO/app/controllers/controller_profile.php">Configuración</a>
                    <a class="w-full py-3 text-center bg-[#25a18e] text-white rounded-xl font-bold" href="/Proyecto-ong-POO/app/controllers/controller_logout.php">Cerrar Sesión</a>
                    <?php else: ?>
                    <a class="w-full py-3 text-center border-2 border-[#25a18e] text-[#25a18e] rounded-xl font-bold" href="/Proyecto-ong-POO/app/controllers/controller_login.php">Iniciar Sesión</a>
                    <a class="w-full py-3 text-center bg-[#25a18e] text-white rounded-xl font-bold" href="/Proyecto-ong-POO/app/controllers/controller_register.php">Registro</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>
