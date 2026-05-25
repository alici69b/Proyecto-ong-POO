<?php
require_once __DIR__ . '/../models/Impacto.php';

try {
    $impacto = new Impacto();
    $totalResets = $impacto->contarResets();
    $totalCompletados = $impacto->contarCompletados();
    $totalVoluntarios = $impacto->contarVoluntarios();
} catch (Exception $e) {
    $totalResets = 0;
    $totalCompletados = 0;
    $totalVoluntarios = 0;
}

include __DIR__ . '/../../pages/Inicio.php';
