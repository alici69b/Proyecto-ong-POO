<?php
//Modelo Reset
class Reset
{
    //Atributos
    private PDO $conn;

    //Constructor
    public function __construct(PDO $conn)
    {
        //Guardamos la conexión PDO para usarla en los métodos
        $this->conn = $conn;
    }

    /** Devuelve los resets disponibles sin voluntario asignado
     * Si se pasa una categoría, filtra por esa categoría
     * @param int|null $id_categoria
     * @return array
     */
    public function obtenerDisponibles(?int $id_categoria = null): array
    {
        $sql = "
            SELECT r.id, r.titulo, r.descripcion, r.causa_abandono, r.necesidades_reset, r.nombre_contacto,
                   r.email_contacto, r.created_at, r.id_categoria, c.nombre_categoria, e.nombre_estado
            FROM reset r
            INNER JOIN categoria_reset c ON r.id_categoria = c.id
            INNER JOIN estado_maestro e ON r.id_estado = e.id
            WHERE r.id_voluntario IS NULL
              AND r.id_estado = 1
        ";

        if ($id_categoria !== null) {
            $sql .= " AND r.id_categoria = :id_categoria";
        }

        $sql .= " ORDER BY r.created_at DESC";

        $stmt = $this->conn->prepare($sql);

        if ($id_categoria !== null) {
            $stmt->bindValue(":id_categoria", $id_categoria, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Asigna un voluntario a un reset solo si todavía no tiene voluntario
     * También cambia el estado a activo
     * @param int $id_reset
     * @param int $id_voluntario
     * @return bool
     */
    public function asignarVoluntario(int $id_reset, int $id_voluntario): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE reset
            SET id_voluntario = :id_voluntario,
                id_estado = 2
            WHERE id = :id_reset
              AND id_voluntario IS NULL
        ");
        $stmt->execute([
            ":id_voluntario" => $id_voluntario,
            ":id_reset"      => $id_reset,
        ]);
        return $stmt->rowCount() > 0;
    }

    /** Actualiza la asignación de un reset desde el administrador
     * @param int $id_reset
     * @param int|null $id_voluntario
     * @param int $id_estado
     * @return bool
     */
    public function actualizarAsignacionYEstado(int $id_reset, ?int $id_voluntario, int $id_estado): bool
    {
        if ($id_voluntario !== null && in_array($id_estado, [1, 2], true)) {
            $id_estado = 2;
        }

        $stmt = $this->conn->prepare("
            UPDATE reset
            SET id_voluntario = :id_voluntario,
                id_estado = :id_estado
            WHERE id = :id_reset
        ");
        $stmt->execute([
            ':id_voluntario' => $id_voluntario,
            ':id_estado'     => $id_estado,
            ':id_reset'      => $id_reset,
        ]);
        return $stmt->rowCount() > 0;
    }

    /** Obtiene las estadísticas del voluntario para mostrar en el dashboard
     * @param int $id_voluntario
     * @return array
     */
    public function obtenerStatsVoluntario(int $id_voluntario): array
    {
        $stmt = $this->conn->prepare("
            SELECT
                COUNT(*) AS total,
                SUM(id_estado = 2) AS en_progreso,
                SUM(id_estado = 3) AS completados
            FROM reset
            WHERE id_voluntario = :id_voluntario
        ");
        $stmt->execute([":id_voluntario" => $id_voluntario]);
        return $stmt->fetch();
    }

    /** Recupera los resets asignados a un voluntario para su dashboard
     * @param int $id_voluntario
     * @param int|null $id_estado Si se pasa, filtra por ese estado
     * @return array
     */
    public function obtenerMisResets(int $id_voluntario, ?int $id_estado = null): array
    {
        $sql = "SELECT r.id, r.titulo, r.descripcion, r.causa_abandono, r.necesidades_reset, r.nombre_contacto,
                    r.created_at, r.id_categoria, c.nombre_categoria, e.nombre_estado, e.id AS id_estado
                FROM reset r
                INNER JOIN categoria_reset c ON r.id_categoria = c.id
                INNER JOIN estado_maestro e ON r.id_estado = e.id
                WHERE r.id_voluntario = :id_voluntario";

        if ($id_estado !== null) {
            $sql .= " AND r.id_estado = :id_estado";
        }

        $sql .= " ORDER BY 
                    CASE e.id 
                        WHEN 2 THEN 1
                        WHEN 1 THEN 2
                        WHEN 3 THEN 3
                        WHEN 4 THEN 4
                    END,
                r.created_at DESC";

        $params = array(':id_voluntario' => $id_voluntario);

        if ($id_estado !== null) {
            $params[':id_estado'] = $id_estado;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** Devuelve un reset por su ID, solo si pertenece al voluntario indicado
     * @param int $id_reset
     * @param int $id_voluntario
     * @return array|false
     */
    public function obtenerPorId(int $id_reset, int $id_voluntario): array|false
    {
        $stmt = $this->conn->prepare("
            SELECT r.id, r.titulo, r.descripcion, r.causa_abandono,
                   r.necesidades_reset, r.nombre_contacto, r.email_contacto,
                   r.created_at, r.id_estado,
                   c.nombre_categoria, e.nombre_estado
            FROM reset r
            INNER JOIN categoria_reset c ON r.id_categoria = c.id
            INNER JOIN estado_maestro  e ON r.id_estado    = e.id
            WHERE r.id = :id_reset
              AND r.id_voluntario = :id_voluntario
        ");
        $stmt->execute([
            ':id_reset'      => $id_reset,
            ':id_voluntario' => $id_voluntario,
        ]);
        return $stmt->fetch();
    }

    /** Cambia el estado de un reset desde el lado del voluntario (3=resuelto, 4=cancelado)
     * Solo lo permite si el reset pertenece al voluntario y está activo (estado 2)
     * @param int $id_reset
     * @param int $id_voluntario
     * @param int $nuevo_estado
     * @return bool
     */
    public function cambiarEstado(int $id_reset, int $id_voluntario, int $nuevo_estado): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE reset
            SET id_estado = :nuevo_estado
            WHERE id = :id_reset
              AND id_voluntario = :id_voluntario
              AND id_estado = 2
        ");
        $stmt->execute([
            ':nuevo_estado'  => $nuevo_estado,
            ':id_reset'      => $id_reset,
            ':id_voluntario' => $id_voluntario,
        ]);
        return $stmt->rowCount() > 0;
    }

    /** Reactiva un reset resuelto o cancelado, volviéndolo a estado activo (2)
     * @param int $id_reset
     * @param int $id_voluntario
     * @return bool
     */
    public function reactivar(int $id_reset, int $id_voluntario): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE reset
            SET id_estado = 2
            WHERE id = :id_reset
              AND id_voluntario = :id_voluntario
              AND id_estado IN (3, 4)
        ");
        $stmt->execute([
            ':id_reset'      => $id_reset,
            ':id_voluntario' => $id_voluntario,
        ]);
        return $stmt->rowCount() > 0;
    }

    // ── Métodos para el usuario normal ──────────────────────────────────────

    /** Devuelve todos los resets de un usuario normal
     * Si se pasa una categoría, filtra por ella
     * @param int $id_usuario
     * @param int|null $id_categoria
     * @param int|null $id_estado
     * @return array
     */
    public function obtenerPorUsuario(int $id_usuario, ?int $id_categoria = null, ?int $id_estado = null): array
    {
        $sql = "
            SELECT r.id, r.titulo, r.descripcion, r.created_at, r.id_estado, r.id_categoria,
                   c.nombre_categoria,
                   e.nombre_estado,
                   CONCAT(u.nombre, ' ', u.apellidos) AS nombre_voluntario
            FROM reset r
            INNER JOIN categoria_reset c ON r.id_categoria = c.id
            INNER JOIN estado_maestro  e ON r.id_estado    = e.id
            LEFT JOIN  voluntario      v ON r.id_voluntario = v.id
            LEFT JOIN  usuario         u ON v.id_usuario    = u.id
            WHERE r.id_usuario = :id_usuario
        ";

        if ($id_categoria !== null) {
            $sql .= " AND r.id_categoria = :id_categoria";
        }

        if ($id_estado !== null) {
            $sql .= " AND r.id_estado = :id_estado";
        }

        $sql .= " ORDER BY r.created_at DESC";

        // Construimos el array de parámetros según los filtros activos
        $params = array(':id_usuario' => $id_usuario);

        if ($id_categoria !== null) {
            $params[':id_categoria'] = $id_categoria;
        }

        if ($id_estado !== null) {
            $params[':id_estado'] = $id_estado;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** Devuelve un reset por su ID comprobando que pertenece al usuario
     * @param int $id_reset
     * @param int $id_usuario
     * @return array|false
     */
    public function obtenerPorIdUsuario(int $id_reset, int $id_usuario): array|false
    {
        $stmt = $this->conn->prepare("
            SELECT r.id, r.titulo, r.descripcion, r.causa_abandono,
                   r.necesidades_reset, r.created_at, r.id_estado,
                   c.nombre_categoria,
                   e.nombre_estado,
                   CONCAT(u.nombre, ' ', u.apellidos) AS nombre_voluntario
            FROM reset r
            INNER JOIN categoria_reset c ON r.id_categoria = c.id
            INNER JOIN estado_maestro  e ON r.id_estado    = e.id
            LEFT JOIN  voluntario      v ON r.id_voluntario = v.id
            LEFT JOIN  usuario         u ON v.id_usuario    = u.id
            WHERE r.id = :id_reset
              AND r.id_usuario = :id_usuario
            LIMIT 1
        ");
        $stmt->execute([
            ':id_reset'   => $id_reset,
            ':id_usuario' => $id_usuario,
        ]);
        return $stmt->fetch();
    }

    /** Cambia el estado de un reset desde el lado del usuario
     * El usuario SOLO puede cancelar (estado 4), nunca finalizar
     * @param int $id_reset
     * @param int $id_usuario
     * @param int $nuevo_estado
     * @return bool
     */
    public function cambiarEstadoUsuario(int $id_reset, int $id_usuario, int $nuevo_estado): bool
    {
        // Seguridad: el usuario solo puede cancelar
        if ($nuevo_estado !== 4) {
            return false;
        }

        $stmt = $this->conn->prepare("
            UPDATE reset
            SET id_estado = :nuevo_estado
            WHERE id = :id_reset
              AND id_usuario = :id_usuario
              AND id_estado IN (1, 2)
        ");
        $stmt->execute([
            ':nuevo_estado' => $nuevo_estado,
            ':id_reset'     => $id_reset,
            ':id_usuario'   => $id_usuario,
        ]);
        return $stmt->rowCount() > 0;
    }

    /** Crea un nuevo reset con estado 1 (pendiente) por defecto
     * @param string $titulo
     * @param int $id_categoria
     * @param int $id_usuario
     * @param string $descripcion
     * @param string $necesidades_reset
     * @param string $causa_abandono
     * @param string $nombre_contacto
     * @param string $email_contacto
     * @return bool
     */
    public function crear(string $titulo, int $id_categoria, int $id_usuario, string $descripcion, string $necesidades_reset, string $causa_abandono, string $nombre_contacto, string $email_contacto): bool
    {
        $stmt = $this->conn->prepare("
            INSERT INTO reset (titulo, descripcion, causa_abandono, necesidades_reset,
                               id_categoria, id_usuario, nombre_contacto, email_contacto, id_estado)
            VALUES (:titulo, :descripcion, :causa_abandono, :necesidades_reset,
                    :id_categoria, :id_usuario, :nombre_contacto, :email_contacto, 1)
        ");
        $stmt->execute([
            ':titulo'            => $titulo,
            ':descripcion'       => $descripcion,
            ':causa_abandono'    => $causa_abandono,
            ':necesidades_reset' => $necesidades_reset,
            ':id_categoria'      => $id_categoria,
            ':id_usuario'        => $id_usuario,
            ':nombre_contacto'   => $nombre_contacto,
            ':email_contacto'    => $email_contacto,
        ]);
        return $stmt->rowCount() > 0;
    }

    /** Actualiza la fecha de última visita del usuario a un reset
     * Se llama cada vez que el usuario abre el detalle del reset
     */
    public function actualizarVisitaUsuario(int $id_reset): void
    {
        $stmt = $this->conn->prepare("
            UPDATE reset
            SET ultima_visita_usuario = NOW()
            WHERE id = :id_reset
        ");
        $stmt->execute([':id_reset' => $id_reset]);
    }

    /** Comprueba si un usuario tiene mensajes sin leer en un reset
     * Hay notificación si el último comentario es de un voluntario
     * y su fecha es posterior a ultima_visita_usuario
     */
    public function tieneNotificacionUsuario(int $id_reset): bool
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) FROM reset_comentario rc
            INNER JOIN reset r ON rc.id_reset = r.id
            WHERE rc.id_reset = :id_reset
              AND rc.id_voluntario IS NOT NULL
              AND (
                  r.ultima_visita_usuario IS NULL
                  OR rc.created_at > r.ultima_visita_usuario
              )
        ");
        $stmt->execute([':id_reset' => $id_reset]);
        return $stmt->fetchColumn() > 0;
    }

    /** Actualiza la fecha de última visita del voluntario a un reset
     * Se llama cada vez que el voluntario abre el detalle del reset
     */
    public function actualizarVisitaVoluntario(int $id_reset): void
    {
        $stmt = $this->conn->prepare("
            UPDATE reset
            SET ultima_visita_voluntario = NOW()
            WHERE id = :id_reset
        ");
        $stmt->execute([':id_reset' => $id_reset]);
    }

    /** Comprueba si un voluntario tiene mensajes sin leer en un reset
     * Hay notificación si el último comentario es de un usuario normal
     * y su fecha es posterior a ultima_visita_voluntario
     */
    public function tieneNotificacionVoluntario(int $id_reset): bool
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) FROM reset_comentario rc
            INNER JOIN reset r ON rc.id_reset = r.id
            WHERE rc.id_reset = :id_reset
              AND rc.id_usuario IS NOT NULL
              AND (
                  r.ultima_visita_voluntario IS NULL
                  OR rc.created_at > r.ultima_visita_voluntario
              )
        ");
        $stmt->execute([':id_reset' => $id_reset]);
        return $stmt->fetchColumn() > 0;
    }
    // ── Métodos para el panel admin ────────────────────────────────────

    public function actualizarAsignacion(int $id_reset, ?int $id_voluntario, int $id_estado): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE reset SET id_voluntario = :id_voluntario, id_estado = :id_estado WHERE id = :id
        ");
        return $stmt->execute([
            ':id_voluntario' => $id_voluntario,
            ':id_estado'     => $id_estado,
            ':id'            => $id_reset,
        ]);
    }

    public function obtenerEstado(int $id_reset): ?int
    {
        $stmt = $this->conn->prepare("SELECT id_estado FROM reset WHERE id = :id");
        $stmt->execute([':id' => $id_reset]);
        $val = $stmt->fetchColumn();
        return $val !== false ? (int)$val : null;
    }

    public function obtenerTodosConDetalles(): array
    {
        $stmt = $this->conn->query("
            SELECT r.id AS id_reset, r.titulo, r.descripcion, r.necesidades_reset, r.causa_abandono,
                   r.nombre_contacto, r.email_contacto, r.created_at AS fecha,
                   r.id_voluntario, r.id_estado,
                   u.nombre AS solicitante,
                   c.nombre_categoria,
                   e.nombre_estado
            FROM reset r
            JOIN usuario u ON r.id_usuario = u.id
            LEFT JOIN categoria_reset c ON r.id_categoria = c.id
            LEFT JOIN estado_maestro e ON r.id_estado = e.id
            ORDER BY r.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function obtenerCategorias(): array
    {
        $stmt = $this->conn->query("SELECT * FROM categoria_reset ORDER BY id");
        return $stmt->fetchAll();
    }
}
?>