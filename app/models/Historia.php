<?php

require_once __DIR__ . '/../config/db.php';

class Historia
{
    private PDO $conn;

    //consturimos el constictor
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    //obtnermos mediante una funcion las historias publicadas
    public function obtenerPublicadas(): array
    {
        try {
            $stmt = $this->conn->query("
                SELECT id, titulo, solicitante, nombre_categoria, descripcion,
                       descripcion_antes, descripcion_despues, nombre_voluntario,
                       duracion_meses, valoracion, edad, foto, icono, created_at
                FROM historias
                WHERE estado = 'Publicada'
                ORDER BY created_at DESC
                LIMIT 5
            ");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    //obtenemos mediante una funcion todas las historias
    public function obtenerTodas(): array
    {
        try {
            $stmt = $this->conn->query("
                SELECT id, titulo, solicitante, nombre_categoria, descripcion,
                       descripcion_antes, descripcion_despues, nombre_voluntario,
                       duracion_meses, valoracion, edad, foto, estado, icono, created_at
                FROM historias
                ORDER BY created_at DESC
            ");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}
