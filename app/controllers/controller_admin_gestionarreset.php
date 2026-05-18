<?php
session_start();



require_once __DIR__ . '/../config/db.php';
$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_reset'])) {
    $id_reset = (int)$_POST['id_reset'];
    $id_voluntario = !empty($_POST['id_voluntario']) ? (int)$_POST['id_voluntario'] : null;
    $id_estado = (int)$_POST['id_estado'];

    $stmt = $conn->prepare("UPDATE reset SET id_voluntario = :id_voluntario, id_estado = :id_estado WHERE id = :id");
    $stmt->execute([':id_voluntario' => $id_voluntario, ':id_estado' => $id_estado, ':id' => $id_reset]);

    header('Location: controller_admin_gestionarreset.php?updated=1');
    exit();
}

$sql1 = "SELECT r.id AS id_reset, r.titulo, r.descripcion, r.created_at AS fecha, r.id_voluntario, r.id_estado, u.nombre AS solicitante, c.nombre_categoria, e.nombre_estado FROM reset r JOIN usuario u ON r.id_usuario = u.id LEFT JOIN categoria_reset c ON r.id_categoria = c.id LEFT JOIN estado_maestro e ON r.id_estado = e.id ORDER BY r.created_at DESC";
$resultado1 = $conn->query($sql1);
$resets = $resultado1->fetchAll();

$sql2 = "SELECT v.id AS id_voluntario, u.nombre FROM voluntario v JOIN usuario u ON v.id_usuario = u.id ORDER BY u.nombre";
$resultado2 = $conn->query($sql2);
$voluntarios = $resultado2->fetchAll();

$sql3 = "SELECT id AS id_estado, nombre_estado FROM estado_maestro ORDER BY id";
$resultado3 = $conn->query($sql3);
$estados = $resultado3->fetchAll();

include __DIR__ . '/../views/admin/gestionarreset.php';
