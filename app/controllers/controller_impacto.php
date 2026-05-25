<?php
require_once __DIR__ . '/../models/Impacto.php';

try {
    $impacto = new Impacto();
    $totalResets = $impacto->contarResets();
    $totalCompletados = $impacto->contarCompletados();
    $totalVoluntarios = $impacto->contarVoluntarios();
    $categorias = $impacto->obtenerCategorias();
    $evolucion = $impacto->obtenerEvolucionMensual();
    $tasaExito = $impacto->tasaExito();

    $maxCat = 1;
    foreach ($categorias as $cat) {
        if ((int) $cat['total'] > $maxCat) $maxCat = (int) $cat['total'];
    }

    $catLabels = [
        'estudio' => 'Estudios',
        'proyecto' => 'Proyectos',
        'salud' => 'Salud',
        'creatividad' => 'Creatividad',
        'otros' => 'Otros sueños',
    ];

    $catIconos = [
        'estudio' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00a5cf] bg-[#d6f3ee] p-2 rounded-lg"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0"/><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0"/><path d="M3 6l0 13"/><path d="M12 6l0 13"/><path d="M21 6l0 13"/></svg>',
        'proyecto' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00a5cf] bg-[#d6f3ee] p-2 rounded-lg"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/><path d="M9 5a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2"/><path d="M9 12l.01 0"/><path d="M13 12l2 0"/><path d="M9 16l.01 0"/><path d="M13 16l2 0"/></svg>',
        'salud' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00a5cf] bg-[#d6f3ee] p-2 rounded-lg"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/></svg>',
        'creatividad' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00a5cf] bg-[#d6f3ee] p-2 rounded-lg"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4v3m-4 -3v6m8 -6v6"/><path d="M12 18.5l-3 1.5l.5 -3.5l-2 -2l3 -.5l1.5 -3l1.5 3l3 .5l-2 2l.5 3.5l-3 -1.5"/></svg>',
        'otros' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00a5cf] bg-[#d6f3ee] p-2 rounded-lg"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12c-2 0-4-1-4-3s2-3 4-3 4 1 4 3-2 3-4 3zm0 0v6"/><path d="M9 15c-3 1-5 2-5 4 0 2 8 2 8 0s-2-3-5-4z"/></svg>',
    ];
} catch (Exception $e) {
    $totalResets = 0;
    $totalCompletados = 0;
    $totalVoluntarios = 0;
    $categorias = [];
    $evolucion = [];
    $tasaExito = 70;
    $maxCat = 1;
    $catLabels = [];
    $catIconos = [];
}

include __DIR__ . '/../../pages/Impact.php';
