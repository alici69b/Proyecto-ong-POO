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
            SELECT r.id, r.titulo, r.descripcion, r.nombre_contacto,
                   r.created_at, r.id_categoria, c.nombre_categoria, e.nombre_estado
            FROM reset r
            INNER JOIN categoria_reset c ON r.id_categoria = c.id
            INNER JOIN estado_maestro e ON r.id_estado = e.id
            WHERE r.id_voluntario IS NULL
              AND r.id_estado = 1
        ";

        if ($id_categoria !== null) {
            // Agregamos el filtro por categoría solo si se ha pedido
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
     * También cambia el estado a activo + cambiar el estado
     * @param int $id_reset
     * @param int $id_voluntario
     * @return bool
     */
    public function asignarVoluntario(int $id_reset, int $id_voluntario): bool
    {
        //Preparamos la consulta
        $stmt = $this->conn->prepare("
            UPDATE reset
            SET id_voluntario = :id_voluntario,
                id_estado = 2
            WHERE id = :id_reset
              AND id_voluntario IS NULL
        ");

        //Ejecutamos con los datos de entrada
        $stmt->execute([
            ":id_voluntario" => $id_voluntario,
            ":id_reset" => $id_reset,
        ]);

        //Devolvemos true si se ha actualizado un registro, false si no (ya tenía voluntario asignado)
        return $stmt->rowCount() > 0;
    }

    /** Obtiene las estadísticas del voluntario para mostrar en el dashboard 
     * @param int $id_voluntario
     * @return array
     */
    public function obtenerStatsVoluntario(int $id_voluntario): array
    {
        //Preparamos la consulta
        $stmt = $this->conn->prepare("
            SELECT
                COUNT(*) AS total,
                SUM(id_estado = 2) AS en_progreso,
                SUM(id_estado = 3) AS completados
            FROM reset
            WHERE id_voluntario = :id_voluntario
        ");

        //Ejecutamos con el id_voluntario
        $stmt->execute([":id_voluntario" => $id_voluntario]);
        return $stmt->fetch();
    }

    /** Recupera los resets que ya tiene asignados este voluntario para mostrarlos en su dashboard, junto con la categoría y el estado actual de cada uno. 
     * @param int $id_voluntario
     * @return array
     */
    public function obtenerMisResets(int $id_voluntario): array
    {
        //Preparamos la consulta
        $stmt = $this->conn->prepare("
            SELECT r.id, r.titulo, r.descripcion, r.nombre_contacto,
                   r.created_at, r.id_categoria, c.nombre_categoria, e.nombre_estado, e.id AS id_estado
            FROM reset r
            INNER JOIN categoria_reset c ON r.id_categoria = c.id
            INNER JOIN estado_maestro e ON r.id_estado = e.id
            WHERE r.id_voluntario = :id_voluntario
            ORDER BY 
                CASE e.id 
                    WHEN 2 THEN 1  -- activo → primero
                    WHEN 1 THEN 2  -- pendiente → segundo
                    WHEN 3 THEN 3  -- resuelto → al final
                    WHEN 4 THEN 4  -- cancelado → al final del todo
                END,
            r.created_at DESC
        ");

        //Ejecutamos con el id_voluntario
        $stmt->execute([":id_voluntario" => $id_voluntario]);
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

    /** Cambia el estado de un reset (3 = resuelto, 4 = cancelado)
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
     * Solo lo permite si pertenece al voluntario
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

}
?>