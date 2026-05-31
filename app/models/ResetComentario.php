<?php
class ResetComentario
{
    //Atributos
    private PDO $conn;

    //Constructor
    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    //Metodos
    /** Devuelve todos los comentarios de un reset ordenados del más antiguo al más nuevo
     * Hace JOIN con usuario y voluntario para mostrar el nombre de quien comentó
     * @param int $id_reset
     * @return array
     */
    public function obtenerPorReset(int $id_reset): array
    {
        $stmt = $this->conn->prepare("
        SELECT rc.id, rc.texto, rc.created_at,
               COALESCE(u.nombre,  uv.nombre)           AS nombre_usuario,
               v.id                                      AS es_voluntario,
               COALESCE(u.foto_perfil, uv.foto_perfil)  AS foto_voluntario
        FROM reset_comentario rc
        LEFT JOIN usuario    u  ON rc.id_usuario    = u.id
        LEFT JOIN voluntario v  ON rc.id_voluntario = v.id
        LEFT JOIN usuario    uv ON v.id_usuario     = uv.id
        WHERE rc.id_reset = :id_reset
        ORDER BY rc.created_at ASC
    ");

        $stmt->execute([":id_reset" => $id_reset]);
        return $stmt->fetchAll();
    }

    /** Inserta un comentario nuevo. Solo uno de los dos IDs estará relleno según el rol
     * @param int $id_reset
     * @param int|null $id_usuario
     * @param int|null $id_voluntario
     * @param string $texto
     * @return bool
     */
    public function insertar(int $id_reset, ?int $id_usuario, ?int $id_voluntario, string $texto): bool
    {
        $stmt = $this->conn->prepare("
            INSERT INTO reset_comentario (id_reset, id_usuario, id_voluntario, texto)
            VALUES (:id_reset, :id_usuario, :id_voluntario, :texto)
        ");

        $stmt->execute([
            ":id_reset"      => $id_reset,
            ":id_usuario"    => $id_usuario,
            ":id_voluntario" => $id_voluntario,
            ":texto"         => $texto,
        ]);

        return $stmt->rowCount() > 0;
    }
}
?>