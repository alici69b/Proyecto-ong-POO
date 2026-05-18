<?php
session_start();



require_once __DIR__ . '/../config/db.php';
$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario'])) {
    $id = (int)$_POST['id_usuario'];
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos'] ?? '');
    $email = trim($_POST['email']);
    $id_rol = (int)$_POST['id_rol'];

    $stmt = $conn->prepare("UPDATE usuario SET nombre = :nombre, apellidos = :apellidos, email = :email, id_rol = :id_rol WHERE id = :id");
    $stmt->execute([':nombre' => $nombre, ':apellidos' => $apellidos, ':email' => $email, ':id_rol' => $id_rol, ':id' => $id]);

    if (!empty($_POST['password_nuevo'])) {
        $hash = password_hash($_POST['password_nuevo'], PASSWORD_BCRYPT);
        $stmt2 = $conn->prepare("UPDATE usuario SET password = :password WHERE id = :id");
        $stmt2->execute([':password' => $hash, ':id' => $id]);
    }

    header('Location: controller_admin_gestionusuarios.php?updated=1');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($id !== (int)$_SESSION['user_id']) {
        $conn->prepare("DELETE FROM voluntario WHERE id_usuario = :id")->execute([':id' => $id]);
        $conn->prepare("DELETE FROM admin WHERE id_usuario = :id")->execute([':id' => $id]);
        $conn->prepare("DELETE FROM usuario WHERE id = :id")->execute([':id' => $id]);
    }
    header('Location: controller_admin_gestionusuarios.php?deleted=1');
    exit();
}

$buscar = trim($_GET['search'] ?? '');
$pagina = max(1, (int)($_GET['p'] ?? 1));
$por_pagina = 10;
$offset = ($pagina - 1) * $por_pagina;

$where = '';
$params = [];
if ($buscar !== '') {
    $where = "WHERE (u.nombre LIKE :q OR u.apellidos LIKE :q2 OR u.email LIKE :q3)";
    $params[':q'] = "%$buscar%";
    $params[':q2'] = "%$buscar%";
    $params[':q3'] = "%$buscar%";
}

$total = $conn->prepare("SELECT COUNT(*) FROM usuario u $where");
$total->execute($params);
$total_usuarios = (int)$total->fetchColumn();
$total_paginas = max(1, (int)ceil($total_usuarios / $por_pagina));

$sql = "SELECT u.*, r.nombre_rol FROM usuario u JOIN roles r ON u.id_rol = r.id $where ORDER BY u.created_at DESC LIMIT $por_pagina OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$usuarios = $stmt->fetchAll();

foreach ($usuarios as &$u) {
    $u['iniciales'] = strtoupper(substr($u['nombre'], 0, 1) . substr($u['apellidos'] ?? $u['nombre'], 0, 1));
    $u['fecha_registro'] = $u['created_at'];
}
unset($u);

include __DIR__ . '/../views/admin/gestionusuarios.php';
