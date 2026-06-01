<?php
require_once __DIR__ . "/../../config.php";
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Donacion.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// ── Stripe: leer clave desde $_ENV (createImmutable no usa putenv) ──
$stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'] ?? '';

// Detectar placeholder literal (NO bloquear claves sk_test_ reales)
if ($stripeSecretKey === 'sk_test_tu_clave_secreta' || $stripeSecretKey === 'sk_test_pon_aqui_la_clave_secreta') {
    $stripeSecretKey = '';
}
\Stripe\Stripe::setApiKey($stripeSecretKey);

// ── URL absoluta base para Stripe (necesita URL completa, no relativa) ──
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseFull = $protocol . '://' . $host . BASE_URL;

// ── Cancelación ──
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cancel'])) {
    include __DIR__ . '/../views/donacion/cancelado.php';
    exit();
}

// ── Retorno de Stripe (success) ──
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['session_id'])) {
    $sessionId = $_GET['session_id'];

    if (empty($stripeSecretKey)) {
        $error = 'Stripe no está configurado. Define STRIPE_SECRET_KEY en el .env';
        include __DIR__ . '/../views/donacion/cancelado.php';
        exit();
    }

    try {
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            $donacionModel = new Donacion();
            $donacionModel->actualizarEstadoPorSessionId(
                $sessionId,
                'completado',
                $session->payment_intent
            );
        }

        include __DIR__ . '/../views/donacion/exito.php';
    } catch (Exception $e) {
        $error = 'Error al verificar el pago.';
        include __DIR__ . '/../views/donacion/cancelado.php';
    }
    exit();
}

// ── Procesar formulario y crear sesión de Stripe ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donar'])) {

    if (!validarTokenCSRF($_POST['_csrf'] ?? '')) {
        $_SESSION['error_donacion'] = 'Error de seguridad. Inténtalo de nuevo.';
        header('Location: ' . $baseFull . '/app/controllers/controller_donacion.php');
        exit();
    }

    if (empty($stripeSecretKey)) {
        $_SESSION['error_donacion'] = 'Stripe no está configurado. Pide a tu profesor las claves de API.';
        header('Location: ' . $baseFull . '/app/controllers/controller_donacion.php');
        exit();
    }

    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $cantidad = floatval($_POST['cantidad'] ?? 0);
    $moneda = trim($_POST['moneda'] ?? 'eur');
    $mensaje = trim($_POST['mensaje'] ?? '');
    $idUsuario = $_SESSION['user_id'] ?? null;

    $errores = [];

    if (empty($nombre) || strlen($nombre) < 2) {
        $errores['nombre'] = 'El nombre debe tener al menos 2 caracteres.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Introduce un email válido.';
    }
    if ($cantidad < 1 || $cantidad > 99999) {
        $errores['cantidad'] = 'La cantidad debe estar entre 1€ y 99.999€.';
    }

    if (!empty($errores)) {
        $_SESSION['errores_donacion'] = $errores;
        $_SESSION['old_donacion'] = $_POST;
        header('Location: ' . $baseFull . '/app/controllers/controller_donacion.php');
        exit();
    }

    try {
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => strtolower($moneda),
                    'product_data' => [
                        'name' => 'Donación a RESET',
                        'description' => $mensaje ?: 'Donación voluntaria',
                    ],
                    'unit_amount' => intval($cantidad * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $baseFull . '/app/controllers/controller_donacion.php?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $baseFull . '/app/controllers/controller_donacion.php?cancel=1',
            'customer_email' => $email,
            'metadata' => [
                'nombre' => $nombre,
                'email' => $email,
                'mensaje' => $mensaje,
            ],
        ]);

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

        header('Location: ' . $session->url);
        exit();
    } catch (\Stripe\Exception\AuthenticationException $e) {
        $_SESSION['error_donacion'] = 'Clave secreta de Stripe inválida. Revisa el .env';
        header('Location: ' . $baseFull . '/app/controllers/controller_donacion.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error_donacion'] = 'Error al procesar el pago: ' . $e->getMessage();
        header('Location: ' . $baseFull . '/app/controllers/controller_donacion.php');
        exit();
    }
}

// ── Mostrar formulario de donación ──
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include __DIR__ . '/../views/donacion/formulario.php';
    exit();
}
