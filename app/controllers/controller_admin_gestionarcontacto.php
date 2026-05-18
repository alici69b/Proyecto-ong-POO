<?php
session_start();


require_once __DIR__ . '/../config/db.php';
$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM mensaje WHERE id = :id");
    $stmt->execute([':id' => (int)$_GET['id']]);
    header('Location: controller_admin_gestionarcontacto.php?deleted=1');
    exit();
}

$resultado = $conn->query("SELECT * FROM mensaje ORDER BY created_at DESC");
$mensajes = $resultado->fetchAll();
$total_mensajes = count($mensajes);

include __DIR__ . '/../views/admin/gestionarcontacto.php';
