<?php

require_once __DIR__ . '/../config/db.php';

class Historia
{
    private PDO $conn;

    public function __construct()
    {
        $Db = new Db();
        $this->conn = $Db->getConnection();
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

    public function obtenerPaginado(string $buscar = '', string $estado = '', int $pagina = 1, int $porPagina = 3): array
    {
        try {
            $sql = "SELECT id, titulo, solicitante, nombre_categoria, descripcion,
                           descripcion_antes, descripcion_despues, nombre_voluntario,
                           duracion_meses, valoracion, edad, foto, estado, icono,
                           automatica, created_at
                    FROM historias WHERE 1=1";
            $params = [];
            if ($buscar !== '') {
                $sql .= " AND (titulo LIKE :buscar OR solicitante LIKE :buscar2 OR descripcion LIKE :buscar3 OR nombre_categoria LIKE :buscar4 OR nombre_voluntario LIKE :buscar5)";
                $like = "%$buscar%";
                $params[':buscar'] = $like;
                $params[':buscar2'] = $like;
                $params[':buscar3'] = $like;
                $params[':buscar4'] = $like;
                $params[':buscar5'] = $like;
            }
            if ($estado === 'Publicada' || $estado === 'Borrador') {
                $sql .= " AND estado = :estado";
                $params[':estado'] = $estado;
            }
            $sql .= " ORDER BY created_at DESC LIMIT :limite OFFSET :offset";
            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
            $stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
            $stmt->bindValue(':offset', ($pagina - 1) * $porPagina, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function contarConFiltro(string $buscar = '', string $estado = ''): int
    {
        try {
            $sql = "SELECT COUNT(*) FROM historias WHERE 1=1";
            $params = [];
            if ($buscar !== '') {
                $sql .= " AND (titulo LIKE :buscar OR solicitante LIKE :buscar2 OR descripcion LIKE :buscar3 OR nombre_categoria LIKE :buscar4 OR nombre_voluntario LIKE :buscar5)";
                $like = "%$buscar%";
                $params[':buscar'] = $like;
                $params[':buscar2'] = $like;
                $params[':buscar3'] = $like;
                $params[':buscar4'] = $like;
                $params[':buscar5'] = $like;
            }
            if ($estado === 'Publicada' || $estado === 'Borrador') {
                $sql .= " AND estado = :estado";
                $params[':estado'] = $estado;
            }
            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function obtenerUsuariosNormales(): array
    {
        $stmt = $this->conn->query("
            SELECT id, nombre, apellidos
            FROM usuario
            WHERE id_rol = 1
            ORDER BY nombre ASC
        ");
        return $stmt->fetchAll();
    }

    public function obtenerVoluntarios(): array
    {
        $stmt = $this->conn->query("
            SELECT u.id, u.nombre, u.apellidos
            FROM usuario u
            INNER JOIN voluntario v ON u.id = v.id_usuario
            ORDER BY u.nombre ASC
        ");
        return $stmt->fetchAll();
    }

    public function obtenerCategorias(): array
    {
        $stmt = $this->conn->query("
            SELECT nombre_categoria
            FROM categoria_reset
            ORDER BY id ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
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

    /** Crea una historia usando los datos del reset + los datos que rellena el voluntario
     * A diferencia de crearAutomaticaDesdeReset(), aquí el voluntario aporta
     * el título, descripción, antes y después manualmente
     */
    public function crearDesdeResetConDatos(int $id_reset, array $datos_voluntario): bool
    {
        try {
            // Obtenemos los datos del reset para rellenar los campos automáticos
            $stmt = $this->conn->prepare("
                SELECT r.created_at,
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

            // Calculamos la duración en meses desde que se creó el reset
            $desde    = new DateTime($data['created_at']);
            $ahora    = new DateTime();
            $duracion = $desde->diff($ahora);
            $meses    = ($duracion->y * 12) + $duracion->m;

            $this->insertar([
                'titulo'              => $datos_voluntario['titulo'],
                'solicitante'         => trim(($data['user_nombre'] ?? '') . ' ' . ($data['user_apellidos'] ?? '')),
                'nombre_categoria'    => $data['nombre_categoria'] ?? '',
                'descripcion'         => $datos_voluntario['descripcion'],
                'descripcion_antes'   => $datos_voluntario['descripcion_antes'],
                'descripcion_despues' => $datos_voluntario['descripcion_despues'],
                'nombre_voluntario'   => trim(($data['vol_nombre'] ?? '') . ' ' . ($data['vol_apellidos'] ?? '')),
                'duracion_meses'      => max(1, $meses),
                'valoracion'          => 5,
                'edad'                => 0,
                'foto'                => $data['foto_perfil'] ?? 'foto_defecto.webp',
                'icono'               => '',
                'estado'              => 'Borrador', // El admin la revisa antes de publicar
                'automatica'          => 0,          // La ha rellenado el voluntario
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>