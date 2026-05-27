<?php

require_once __DIR__ . '/../config/db.php';

class Historia
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

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
            ");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function obtenerTodas(): array
    {
        try {
            $stmt = $this->conn->query("
                SELECT id, titulo, solicitante, nombre_categoria, descripcion,
                       descripcion_antes, descripcion_despues, nombre_voluntario,
                       duracion_meses, valoracion, edad, foto, estado, icono,
                       automatica, created_at
                FROM historias
                ORDER BY created_at DESC
            ");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function insertar(array $datos): int
    {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO historias (titulo, solicitante, nombre_categoria, descripcion, descripcion_antes, descripcion_despues, nombre_voluntario, duracion_meses, valoracion, edad, foto, icono, estado, automatica)
                VALUES (:titulo, :solicitante, :nombre_categoria, :descripcion, :descripcion_antes, :descripcion_despues, :nombre_voluntario, :duracion_meses, :valoracion, :edad, :foto, :icono, :estado, :automatica)
            ");
            $stmt->execute([
                ':titulo' => $datos['titulo'],
                ':solicitante' => $datos['solicitante'] ?? '',
                ':nombre_categoria' => $datos['nombre_categoria'] ?? '',
                ':descripcion' => $datos['descripcion'] ?? '',
                ':descripcion_antes' => $datos['descripcion_antes'] ?? '',
                ':descripcion_despues' => $datos['descripcion_despues'] ?? '',
                ':nombre_voluntario' => $datos['nombre_voluntario'] ?? '',
                ':duracion_meses' => (int)($datos['duracion_meses'] ?? 0),
                ':valoracion' => (int)($datos['valoracion'] ?? 5),
                ':edad' => (int)($datos['edad'] ?? 0),
                ':foto' => $datos['foto'] ?? 'foto_defecto.webp',
                ':icono' => $datos['icono'] ?? '',
                ':estado' => $datos['estado'] ?? 'Borrador',
                ':automatica' => (int)($datos['automatica'] ?? 0),
            ]);
            return (int)$this->conn->lastInsertId();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function actualizar(int $id, array $datos): bool
    {
        try {
            $campos = [];
            $params = [':id' => $id];

            $permitidos = ['titulo', 'solicitante', 'nombre_categoria', 'descripcion', 'descripcion_antes', 'descripcion_despues', 'nombre_voluntario', 'duracion_meses', 'valoracion', 'edad', 'foto', 'icono', 'estado'];
            foreach ($permitidos as $c) {
                if (array_key_exists($c, $datos)) {
                    $campos[] = "$c = :$c";
                    $params[":$c"] = $datos[$c];
                }
            }

            if (empty($campos)) return false;

            $sql = "UPDATE historias SET " . implode(', ', $campos) . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function eliminar(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM historias WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function obtenerPorId(int $id): ?array
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT id, titulo, solicitante, nombre_categoria, descripcion,
                       descripcion_antes, descripcion_despues, nombre_voluntario,
                       duracion_meses, valoracion, edad, foto, estado, icono,
                       automatica, created_at
                FROM historias
                WHERE id = :id
            ");
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function crearAutomaticaDesdeReset(int $id_reset): bool
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT r.titulo, r.descripcion, r.necesidades_reset, r.causa_abandono, r.created_at,
                       u.nombre AS user_nombre, u.apellidos AS user_apellidos, u.foto_perfil,
                       v_u.nombre AS vol_nombre, v_u.apellidos AS vol_apellidos,
                       c.nombre_categoria
                FROM reset r
                JOIN usuario u ON r.id_usuario = u.id
                LEFT JOIN voluntario v ON r.id_voluntario = v.id
                LEFT JOIN usuario v_u ON v.id_usuario = v_u.id
                LEFT JOIN categoria_reset c ON r.id_categoria = c.id
                WHERE r.id = :id_reset AND r.id_estado = 3
            ");
            $stmt->execute([':id_reset' => $id_reset]);
            $data = $stmt->fetch();

            if (!$data) return false;

            $antes = !empty($data['necesidades_reset'])
                ? $data['necesidades_reset']
                : (!empty($data['causa_abandono'])
                    ? $data['causa_abandono']
                    : $data['descripcion']);

            $desde = new DateTime($data['created_at']);
            $ahora = new DateTime();
            $duracion = $desde->diff($ahora);
            $meses = ($duracion->y * 12) + $duracion->m;

            $this->insertar([
                'titulo' => $data['titulo'],
                'solicitante' => trim(($data['user_nombre'] ?? '') . ' ' . ($data['user_apellidos'] ?? '')),
                'nombre_categoria' => $data['nombre_categoria'] ?? '',
                'descripcion' => $data['descripcion'] ?? '',
                'descripcion_antes' => $antes,
                'descripcion_despues' => 'Gracias al proceso RESET y al acompañamiento de mi voluntario/a, logré superar esta etapa. Hoy miro atrás y veo todo lo que he avanzado.',
                'nombre_voluntario' => trim(($data['vol_nombre'] ?? '') . ' ' . ($data['vol_apellidos'] ?? '')),
                'duracion_meses' => max(1, $meses),
                'valoracion' => 5,
                'edad' => 0,
                'foto' => $data['foto_perfil'] ?? 'foto_defecto.webp',
                'icono' => '',
                'estado' => 'Borrador',
                'automatica' => 1,
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
