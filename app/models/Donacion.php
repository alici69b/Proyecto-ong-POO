<?php

require_once __DIR__ . '/../config/db.php';

class Donacion
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function insertar(array $datos): int
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO donacion (id_usuario, nombre, email, cantidad, moneda, stripe_session_id, estado, mensaje)
             VALUES (:id_usuario, :nombre, :email, :cantidad, :moneda, :stripe_session_id, :estado, :mensaje)"
        );
        $stmt->execute([
            ':id_usuario' => $datos['id_usuario'],
            ':nombre' => $datos['nombre'],
            ':email' => $datos['email'],
            ':cantidad' => $datos['cantidad'],
            ':moneda' => $datos['moneda'] ?? 'eur',
            ':stripe_session_id' => $datos['stripe_session_id'] ?? null,
            ':estado' => $datos['estado'] ?? 'pendiente',
            ':mensaje' => $datos['mensaje'] ?? null,
        ]);
        return (int) $this->conn->lastInsertId();
    }

    public function actualizarEstadoPorSessionId(string $sessionId, string $estado, ?string $paymentIntent = null): bool
    {
        $sql = "UPDATE donacion SET estado = :estado" .
            ($paymentIntent ? ", stripe_payment_intent = :payment_intent" : "") .
            " WHERE stripe_session_id = :session_id";
        $params = [':estado' => $estado, ':session_id' => $sessionId];
        if ($paymentIntent) {
            $params[':payment_intent'] = $paymentIntent;
        }
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function obtenerTodas(): array
    {
        $stmt = $this->conn->query("SELECT * FROM donacion ORDER BY fecha_creacion DESC");
        return $stmt->fetchAll();
    }

    public function contarCompletadas(): int
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM donacion WHERE estado = 'completado'");
        return (int) $stmt->fetchColumn();
    }

    public function totalRecaudado(): float
    {
        $stmt = $this->conn->query("SELECT COALESCE(SUM(cantidad), 0) FROM donacion WHERE estado = 'completado'");
        return (float) $stmt->fetchColumn();
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM donacion WHERE id_donacion = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function obtenerPorSessionId(string $sessionId): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM donacion WHERE stripe_session_id = :session_id");
        $stmt->execute([':session_id' => $sessionId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
