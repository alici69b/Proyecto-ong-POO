<?php
require_once __DIR__ . '/../models/Impacto.php';

$jsonPath = __DIR__ . '/../../public/data/erp_financiero.json';

if (!file_exists($jsonPath)) {
    die('Error: No se encuentra el archivo de datos ERP.');
}

$jsonContent = file_get_contents($jsonPath);
$datos = json_decode($jsonContent, true);

if (!$datos || !isset($datos['ejercicios'])) {
    die('Error: El archivo ERP no tiene un formato válido.');
}

$impacto = new Impacto();
$totalResetsDB     = $impacto->contarResets();
$totalCompletadosDB = $impacto->contarCompletados();
$totalVoluntariosDB = $impacto->contarVoluntarios();
$tasaExitoDB       = $impacto->tasaExito();
$categoriasDB      = $impacto->obtenerCategorias();

$organizacion       = $datos['organizacion'];
$moneda             = $datos['moneda'];
$ultimaActualizacion = $datos['ultima_actualizacion'];
$ejercicios         = $datos['ejercicios'];

$totalIngresos     = array_sum(array_column($ejercicios, 'ingresos_totales'));
$totalGastos       = array_sum(array_column($ejercicios, 'gastos_totales'));
$totalSuperavit    = array_sum(array_column($ejercicios, 'superavit'));

$anios             = array_column($ejercicios, 'año');
$ingresosPorAnio   = array_column($ejercicios, 'ingresos_totales');
$gastosPorAnio     = array_column($ejercicios, 'gastos_totales');
$superavitPorAnio  = array_column($ejercicios, 'superavit');

$ejercicioActual   = $ejercicios[0];

$costePorReset     = $totalResetsDB > 0 ? round($totalGastos / $totalResetsDB) : 0;
$personasAlAno     = $totalResetsDB > 0 ? round($totalResetsDB / count($ejercicios)) : 0;

$tituloPagina = 'Transparencia - RESET';

include __DIR__ . '/../../pages/Transparencia.php';