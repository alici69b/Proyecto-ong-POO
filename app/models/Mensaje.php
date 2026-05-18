<?php

require_once __DIR__ . '/../config/db.php';

class Mensaje
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    //funcion para obtener todo los mensajes
    public function obtenerTodos(): array
    {
        try {
            $stmt = $this->conn->query("SELECT * FROM mensaje ORDER BY created_at DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new RuntimeException("Error al obtener mensajes: " . $e->getMessage());
        }
    }

    //contar todos los mensjes
    public function contarTodos(): int
    {
        try {
            $stmt = $this->conn->query("SELECT COUNT(*) FROM mensaje");
            return (int) $stmt->fetchColumn();
        } catch (Exception $e) {
            throw new RuntimeException("Error al contar mensajes: " . $e->getMessage());
        }
    }

    //marcar como leido
    public function marcarComoLeido(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("UPDATE mensaje SET leido = 1 WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            throw new RuntimeException("Error al marcar como leído: " . $e->getMessage());
        }
    }

    //contar mensajes no leidos
    public function contarNoLeidos(): int
    {
        try {
            $stmt = $this->conn->query("SELECT COUNT(*) FROM mensaje WHERE leido = 0");
            return (int) $stmt->fetchColumn();
        } catch (Exception $e) {
            throw new RuntimeException("Error al contar no leídos: " . $e->getMessage());
        }
    }

    //funcion para insertar mesanjes desde la pagina de contactos
    public function insertar(array $datos): bool
    {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO mensaje (nombre_remitente, email_remitente, asunto, cuerpo_mensaje)
                VALUES (:nombre_remitente, :email_remitente, :asunto, :cuerpo_mensaje)
            ");
            return $stmt->execute([
                ':nombre_remitente' => $datos['nombre_remitente'],
                ':email_remitente'  => $datos['email_remitente'],
                ':asunto'           => $datos['asunto'],
                ':cuerpo_mensaje'   => $datos['cuerpo_mensaje'],
            ]);
        } catch (Exception $e) {
            throw new RuntimeException("Error al insertar mensaje: " . $e->getMessage());
        }
    }

    //eliminar mensajes
    public function eliminar(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM mensaje WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            throw new RuntimeException("Error al eliminar mensaje: " . $e->getMessage());
        }
    }
}
