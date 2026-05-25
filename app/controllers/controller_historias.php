<?php
require_once __DIR__ . '/../models/Historia.php';

try {
    $historiaModel = new Historia();
    $historias = $historiaModel->obtenerPublicadas();
} catch (Exception $e) {
    $historias = [];
}

include __DIR__ . '/../../pages/Historys.php';
