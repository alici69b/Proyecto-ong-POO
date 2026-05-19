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
            ORDER BY r.created_at DESC
        ");

        //Ejecutamos con el id_voluntario
        $stmt->execute([":id_voluntario" => $id_voluntario]);
        return $stmt->fetchAll();
    }
}
?>