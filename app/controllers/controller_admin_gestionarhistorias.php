<?php
session_start();



$historias = [
    ['id_historia' => 1, 'titulo' => 'De abandonar Medicina a ser cirujana', 'solicitante' => 'Elena M.', 'nombre_categoria' => 'Estudios', 'fecha' => '2026-04-21 12:00:00', 'descripcion' => 'Una historia increíble de superación y cambio de rumbo profesional.', 'estado' => 'Publicada', 'icono' => '📚'],
    ['id_historia' => 2, 'titulo' => 'Un sueño congelado que volvió a arder', 'solicitante' => 'Javier R.', 'nombre_categoria' => 'Proyecto', 'fecha' => '2026-04-21 12:00:00', 'descripcion' => 'Cómo retomar una pasión estancada y convertirla en realidad.', 'estado' => 'Publicada', 'icono' => '💡'],
    ['id_historia' => 3, 'titulo' => 'Correr otra vez después de 5 años', 'solicitante' => 'Carmen S.', 'nombre_categoria' => 'Hábitos', 'fecha' => '2026-04-21 12:00:00', 'descripcion' => 'El camino de vuelta a la salud física y la disciplina deportiva.', 'estado' => 'Publicada', 'icono' => '👟'],
    ['id_historia' => 4, 'titulo' => 'Recuperar la confianza después del fracaso', 'solicitante' => 'Ana L.', 'nombre_categoria' => 'Mental', 'fecha' => '2026-04-20 10:30:00', 'descripcion' => 'Aprender a levantarse y empezar de nuevo con más fuerza.', 'estado' => 'Borrador', 'icono' => '🧠'],
    ['id_historia' => 5, 'titulo' => 'De la adicción al emprendimiento', 'solicitante' => 'Miguel G.', 'nombre_categoria' => 'Laboral', 'fecha' => '2026-04-19 08:15:00', 'descripcion' => 'Transformar una experiencia difícil en una oportunidad de negocio.', 'estado' => 'Borrador', 'icono' => '🚀'],
];

include __DIR__ . '/../views/admin/gestionarhistorias.php';
