<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['user_rol'] !== 'admin') {
    header('Location: ../auth/Login.php');
    exit();
}

require_once __DIR__ . '/../../config/db.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_reset'])) {
    $id_reset = (int)$_POST['id_reset'];
    $id_voluntario = !empty($_POST['id_voluntario']) ? (int)$_POST['id_voluntario'] : null;
    $id_estado = (int)$_POST['id_estado'];

    $stmt = $conn->prepare("UPDATE reset SET id_voluntario = :id_voluntario, id_estado = :id_estado WHERE id = :id");
    $stmt->execute([':id_voluntario' => $id_voluntario, ':id_estado' => $id_estado, ':id' => $id_reset]);

    header('Location: gestionarreset.php?updated=1');
    exit();
}

$resets = $conn->query("
    SELECT r.id AS id_reset, r.titulo, r.descripcion, r.created_at AS fecha, r.id_voluntario, r.id_estado,
           u.nombre AS solicitante, c.nombre_categoria, e.nombre_estado
    FROM reset r
    JOIN usuario u ON r.id_usuario = u.id
    LEFT JOIN categoria_reset c ON r.id_categoria = c.id
    LEFT JOIN estado_maestro e ON r.id_estado = e.id
    ORDER BY r.created_at DESC
")->fetchAll();

$voluntarios = $conn->query("
    SELECT v.id AS id_voluntario, u.nombre
    FROM voluntario v
    JOIN usuario u ON v.id_usuario = u.id
    ORDER BY u.nombre
")->fetchAll();

$estados = $conn->query("SELECT id AS id_estado, nombre_estado FROM estado_maestro ORDER BY id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../../../public/img/Logo_RESET.svg">
    <title>Resets - RESET</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;500;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Bricolage Grotesque', sans-serif; }
        body { background-color: #f4f9fa; }
    </style>
</head>
<body class="text-[#004e64] min-h-screen flex">
    <aside class="fixed left-0 top-0 z-50 h-screen w-64 bg-[#004e64] text-blue-100 p-6 flex flex-col">
        <div class="flex items-center gap-3 px-2 mt-8 mb-10">
                <div class="flex items-center gap-3  mb-4">
                    <div class="w-9 h-9 bg-[#00a5cf] rounded-full flex items-center justify-center text-white font-bold text-sm">
                        <?= strtoupper(substr($_SESSION['user_nombre'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="text-xs">
                        <p class="text-white font-bold truncate"><?= htmlspecialchars($_SESSION['user_nombre']) ?></p>
                        <p class="text-[#9fffcb] text-[10px]">Administrador</p>
                    </div>
                </div>
            </div>
        <nav class="flex flex-col gap-1.5 flex-1">
            <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 36 36"><path d="M32 5H4c-1.1 0-2 .9-2 2v22c0 1.1.9 2 2 2h28c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zM4 29V7h28v22H4z"/><path d="M15.6 15.2l-6 8.7-4-3.5 1-1.2 2.7 2.4 6.3-9.2 6.7 10 6.8-8.9 1.3 1-8.1 10.7z"/></svg>
                Vista general
            </a>
            <a href="gestionarreset.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/10 text-white font-bold text-sm shadow-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 1920 1920"><path d="M276.9 440.6v565.7c0 422.4 374.2 625.5 674.7 788.7l8 4.3 8.1-4.3c300.5-163.2 674.7-366.3 674.7-788.7V440.6l-682.8-321.7-682.8 321.7z"/></svg>
                Resets
            </a>
            <a href="gestionusuarios.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Usuarios
            </a>
            <a href="gestionarhistorias.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Historias
            </a>
            <a href="gestionarcontacto.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition-all text-sm">
                <svg class="w-5 h-5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Mensajes
            </a>
        </nav>
        <div class="pt-4 border-t border-white/10">
            
            <a href="../../controllers/controller_logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-300 transition-all text-sm font-bold">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M16 17v-4H9v-2h7V7l5 5-5 5M14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z"/></svg>
                Cerrar sesión
            </a>
        </div>
    </aside>

    <main class="flex-1 ml-64 p-8">
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">Gestionar Resets</h1>
                <p class="text-slate-500"><?= count($resets) ?> solicitudes de reset registradas</p>
            </div>
            <button onclick="location.reload()" class="px-6 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold hover:shadow-md transition-all active:scale-95">Actualizar</button>
        </header>

        <?php if (isset($_GET['updated'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Reset actualizado correctamente
            </div>
        <?php endif; ?>

        <div class="space-y-4">
            <?php if (empty($resets)): ?>
                <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-slate-300">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <p class="text-slate-400 font-bold text-lg">No hay resets registrados</p>
                    <p class="text-slate-300 text-sm">Los resets aparecerán aquí cuando los usuarios soliciten ayuda.</p>
                </div>
            <?php endif; ?>
            <?php foreach ($resets as $r): ?>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col xl:flex-row xl:items-center justify-between gap-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4 flex-1 min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-cyan-50 flex items-center justify-center text-xl flex-shrink-0">
                            <svg class="w-6 h-6 text-cyan-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h2 class="font-bold text-lg text-slate-800 truncate"><?= htmlspecialchars($r['titulo'] ?? 'Sin título') ?></h2>
                            <div class="flex flex-wrap items-center gap-2 mt-1 text-sm text-slate-400">
                                <span class="font-semibold text-slate-600"><?= htmlspecialchars($r['solicitante'] ?? 'Anónimo') ?></span>
                                <span class="hidden sm:inline">•</span>
                                <span class="bg-slate-100 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase"><?= htmlspecialchars($r['nombre_categoria'] ?? 'General') ?></span>
                                <span class="hidden sm:inline">•</span>
                                <span><?= date('d/m/Y', strtotime($r['fecha'])) ?></span>
                                <span class="ml-auto">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold <?= $r['nombre_estado'] === 'Completado' ? 'bg-green-50 text-green-700' : ($r['nombre_estado'] === 'En progreso' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700') ?>">
                                        <span class="h-1.5 w-1.5 rounded-full <?= $r['nombre_estado'] === 'Completado' ? 'bg-green-500' : ($r['nombre_estado'] === 'En progreso' ? 'bg-blue-500' : 'bg-amber-500') ?>"></span>
                                        <?= htmlspecialchars($r['nombre_estado'] ?? 'Nuevo') ?>
                                    </span>
                                </span>
                            </div>
                            <?php if (!empty($r['descripcion'])): ?>
                                <p class="mt-2 text-slate-500 text-sm line-clamp-2 italic">"<?= htmlspecialchars($r['descripcion']) ?>"</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <form method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-shrink-0">
                        <input type="hidden" name="id_reset" value="<?= $r['id_reset'] ?>">
                        <select name="id_voluntario" class="bg-slate-50 text-sm rounded-xl px-4 py-2.5 border border-slate-200 focus:ring-2 focus:ring-[#00a5cf] outline-none">
                            <option value="">Sin voluntario</option>
                            <?php foreach ($voluntarios as $vol): ?>
                                <option value="<?= $vol['id_voluntario'] ?>" <?= ($r['id_voluntario'] == $vol['id_voluntario']) ? 'selected' : '' ?>><?= htmlspecialchars($vol['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="id_estado" class="bg-white text-sm font-bold rounded-xl px-4 py-2.5 border border-slate-200 focus:ring-2 focus:ring-[#00a5cf] outline-none cursor-pointer">
                            <?php foreach ($estados as $est): ?>
                                <option value="<?= $est['id_estado'] ?>" <?= ($r['id_estado'] == $est['id_estado']) ? 'selected' : '' ?>><?= htmlspecialchars($est['nombre_estado']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="actualizar_reset" value="1">
                        <button type="submit" class="bg-[#00a5cf] text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-[#0088aa] transition-all active:scale-95">Guardar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
