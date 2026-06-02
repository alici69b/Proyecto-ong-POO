<?php
require_once __DIR__ . "/../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

// Cargo Stripe, el modelo Donacion y las validaciones
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Donacion.php';
require_once __DIR__ . '/../Helpers/Validaciones.php';

// Cargo las variables del .env (ahí guardamos STRIPE_SECRET_KEY, que es la clave secreta)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Leo la clave secreta de Stripe desde el .env
// Si no está definida, queda como cadena vacía
$stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'] ?? '';

// Si la persona dejó el placeholder del tutorial, lo tratamos como "no configurado"
// Esto evita que se intente conectar con una clave falsa
if ($stripeSecretKey === 'sk_test_tu_clave_secreta' || $stripeSecretKey === 'sk_test_pon_aqui_la_clave_secreta') {
    $stripeSecretKey = '';
}
// Le decimos a Stripe cuál es nuestra clave secreta (la del .env)
\Stripe\Stripe::setApiKey($stripeSecretKey);


//Stripe necesita una URL absoluta para redirigir al usuario,
//no vale con rutas relativas
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseFull = $protocol . '://' . $host . BASE_URL;

// si el usuario vuelve de Stripe y pulse "cancel" O si viene con ?cancel=1 en la URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cancel'])) {
    include __DIR__ . '/../views/donacion/cancelado.php';
    exit();
}

// Stripe redirige aquí después del pago
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['session_id'])) {
    $sessionId = $_GET['session_id'];

    // Si Stripe no está configurado, mostramos error
    if (empty($stripeSecretKey)) {
        $error = 'Stripe no está configurado. Define STRIPE_SECRET_KEY en el .env';
        include __DIR__ . '/../views/donacion/cancelado.php';
        exit();
    }

    try {
        // Pregunto a Stripe: "Esta sesión, ¿se pagó realmente?"
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        // payment_status puede ser 'paid' (pagado), 'unpaid' (no pagado)
        if ($session->payment_status === 'paid') {
            //Sí, se pagó -> actualizo la donación en mi BBDD
            $donacionModel = new Donacion();
            $donacionModel->actualizarEstadoPorSessionId(
                $sessionId,
                'completado',
                $session->payment_intent // Guardo el ID del cobro en Stripe
            );
        }

        // Muestro la vista de éxito
        include __DIR__ . '/../views/donacion/exito.php';
    } catch (Exception $e) {
        // Si algo falla (sesión inválida, error de conexión...)
        $error = 'Error al verificar el pago.';
        include __DIR__ . '/../views/donacion/cancelado.php';
    }
    exit();
}


//     El formulario envía POST con los datos: nombre, email, cantidad...
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donar'])) {


    // CSRF(tipo de ataque) evita que un atacante desde otra web engañe al usuario
    // para que done sin querer. Cada formulario tiene un token único
    // que solo nosotros conocemos (guardado en la sesión)
    if (!validarTokenCSRF($_POST['_csrf'] ?? '')) {
        $_SESSION['error_donacion'] = 'Error de seguridad. Inténtalo de nuevo.';
        header('Location: ' . $baseFull . '/app/controllers/controller_donacion.php');
        exit();
    }

    // Comprobamos que Stripe este configurado
    if (empty($stripeSecretKey)) {
        $_SESSION['error_donacion'] = 'Stripe no está configurado. Pide a tu profesor las claves de API.';
        header('Location: ' . $baseFull . '/app/controllers/controller_donacion.php');
        exit();
    }

    // Recogemos los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $cantidad = floatval($_POST['cantidad'] ?? 0);
    $moneda = trim($_POST['moneda'] ?? 'eur');
    $mensaje = trim($_POST['mensaje'] ?? '');
    $idUsuario = $_SESSION['user_id'] ?? null; 

    // Validamos los datos usando el helper Validaciones 
    $errores = Validaciones::validarDonacion($_POST);

    // Si hay errores, guardo los errores en sesión y redirijo al formulario
    // para que los vea y los corrija
    if (!empty($errores)) {
        $_SESSION['errores_donacion'] = $errores;
        $_SESSION['old_donacion'] = $_POST; // Para rellenar el formulario con lo que ya puso
        header('Location: ' . $baseFull . '/app/controllers/controller_donacion.php');
        exit();
    }

    try {
        // Le pido a Stripe que cree una sesión de pago
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => strtolower($moneda),
                    'product_data' => [
                        'name' => 'Donación a RESET',
                        'description' => $mensaje ?: 'Donación voluntaria',
                    ],
                    // Stripe trabaja en centimos 
                    'unit_amount' => intval($cantidad * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            // {CHECKOUT_SESSION_ID} Stripe lo reemplaza automáticamente
            // por el ID real de la sesión al redirigir
            'success_url' => $baseFull . '/app/controllers/controller_donacion.php?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $baseFull . '/app/controllers/controller_donacion.php?cancel=1',
            'customer_email' => $email,
            'metadata' => [
                'nombre' => $nombre,
                'email' => $email,
                'mensaje' => $mensaje,
            ],
        ]);

        //  Guardar la donacion como "pendiente" 
        $donacionModel = new Donacion();
        $donacionModel->insertar([
            'id_usuario' => $idUsuario,
            'nombre' => $nombre,
            'email' => $email,
            'cantidad' => $cantidad,
            'moneda' => $moneda,
            'stripe_session_id' => $session->id,
            'estado' => 'pendiente', 
            'mensaje' => $mensaje,
        ]);

        // Redirigimos al usuario a la pagina de Stripe para que pague 
        header('Location: ' . $session->url);
        exit();

    } catch (\Stripe\Exception\AuthenticationException $e) {
        // La clave secreta es inválida
        $_SESSION['error_donacion'] = 'Clave secreta de Stripe inválida. Revisa el .env';
        header('Location: ' . $baseFull . '/app/controllers/controller_donacion.php');
        exit();
    } catch (Exception $e) {
        // Cualquier otro error
        $_SESSION['error_donacion'] = 'Error al procesar el pago: ' . $e->getMessage();
        header('Location: ' . $baseFull . '/app/controllers/controller_donacion.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include __DIR__ . '/../views/donacion/formulario.php';
    exit();
}
