<?php

require_once __DIR__ . '/Usuario.php';

//creamos la clase hija de usuario Voluntario

class Voluntario extends Usuario
{
    public function __construct()
    {
        parent::__construct();
    }

    //funcion del registro del usuario, lo insertamos en la bbdd
    public function insertarUsuario(array $datos) {

        try {

            //inserto en la tabla usuario para después insertar el la tabla del voluntario
            $hash = password_hash($datos['password'], PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare("
                INSERT INTO usuario (nombre, apellidos, email, password, id_rol, foto_perfil)
                VALUES (:nombre, :apellidos, :email, :password, 2, 'foto_defecto.webp')
            ");
            $stmt->execute([
                ':nombre'    => $datos['nombre'],
                ':apellidos' => $datos['apellidos'],
                ':email'     => $datos['email'],
                ':password'  => $hash
            ]);

            // obtengo el ultimo id insertado para insertarlo en la proxima tabla
            $id_usuario = $this->conn->lastInsertId();

            // Inserto en la tbla voluntario
            $stmt2 = $this->conn->prepare("
                INSERT INTO voluntario (id_usuario, tipo_ayuda, disponibilidad, contacto_extra)
                VALUES (:id_usuario, :tipo_ayuda, :disponibilidad, :contacto_extra)
            ");
            $stmt2->execute([
                ':id_usuario'     => $id_usuario,
                ':tipo_ayuda'     => $datos['tipo_ayuda'],
                ':disponibilidad' => $datos['disponibilidad'],
                ':contacto_extra' => $datos['contacto_extra'] ?? ''
            ]);

            return true;

        } catch (Exception $e) {
            throw new \RuntimeException('No se ha podido insertar al voluntario ' . $e);
        }
    }
    /** Obtiene todos los datos del perfil del voluntario unidos de las dos tablas
     * @param int $id_usuario
     * @return array|false
     */
    public function obtenerPerfil(int $id_usuario): array|false
    {
        $stmt = $this->conn->prepare("
            SELECT u.id, u.nombre, u.apellidos, u.email, u.foto_perfil,
                   v.id AS id_voluntario, v.tipo_ayuda, v.disponibilidad, v.contacto_extra
            FROM usuario u
            INNER JOIN voluntario v ON v.id_usuario = u.id
            WHERE u.id = :id_usuario
        ");
        $stmt->execute([':id_usuario' => $id_usuario]);
        return $stmt->fetch();
    }

    /** Actualiza nombre, apellidos, tipo_ayuda y disponibilidad
     * @param int $id_usuario
     * @param array $datos
     * @return bool
     */
    public function actualizarDatos(int $id_usuario, array $datos): bool
    {
        // Actualizamos la tabla usuario
        $stmt = $this->conn->prepare("
            UPDATE usuario
            SET nombre    = :nombre,
                apellidos = :apellidos
            WHERE id = :id_usuario
        ");
        $stmt->execute([
            ':nombre'     => $datos['nombre'],
            ':apellidos'  => $datos['apellidos'],
            ':id_usuario' => $id_usuario,
        ]);

        // Actualizamos la tabla voluntario
        $stmt2 = $this->conn->prepare("
            UPDATE voluntario
            SET tipo_ayuda      = :tipo_ayuda,
                disponibilidad  = :disponibilidad
            WHERE id_usuario = :id_usuario
        ");
        $stmt2->execute([
            ':tipo_ayuda'     => $datos['tipo_ayuda'],
            ':disponibilidad' => $datos['disponibilidad'],
            ':id_usuario'     => $id_usuario,
        ]);

        return true;
    }

    /** Actualiza la foto de perfil en la tabla usuario
     * @param int $id_usuario
     * @param string $nombre_archivo
     * @return bool
     */
    public function actualizarFoto(int $id_usuario, string $nombre_archivo): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE usuario
            SET foto_perfil = :foto_perfil
            WHERE id = :id_usuario
        ");
        $stmt->execute([
            ':foto_perfil' => $nombre_archivo,
            ':id_usuario'  => $id_usuario,
        ]);
        return $stmt->rowCount() > 0;
    }

    /** Obtiene el id del voluntario a partir del id de usuario
     * @param int $id_usuario
     * @return int|null
     */
    public function obtenerIdPorUsuario(int $id_usuario): ?int
    {
        $stmt = $this->conn->prepare("SELECT id FROM voluntario WHERE id_usuario = :id_usuario");
        $stmt->execute([':id_usuario' => $id_usuario]);
        $fila = $stmt->fetch();
        return $fila ? (int)$fila['id'] : null;
    }

    /** Cambia la contraseña (firma compatible con la clase padre)
     * @param int $id
     * @param string $nueva_password
     * @return bool
     */
    public function cambiarPassword(int $id, string $nueva_password): bool
    {
        try {
            $hash = password_hash($nueva_password, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare("UPDATE usuario SET password = :password WHERE id = :id");
            return $stmt->execute([
                ':password' => $hash,
                ':id' => $id
            ]);
        } catch (Exception $error) {
            throw new RuntimeException("Error al cambiar la contraseña: " . $error->getMessage());
        }
    }

    // Métodos del panel admin

    public function listarVoluntarios(): array
    {
        $stmt = $this->conn->query("
            SELECT u.id, u.nombre, u.apellidos
            FROM usuario u
            JOIN voluntario v ON u.id = v.id_usuario
            ORDER BY u.nombre ASC
        ");
        return $stmt->fetchAll();
    }

    public function listarConNombre(): array
    {
        $stmt = $this->conn->query("
            SELECT v.id AS id_voluntario, u.nombre
            FROM voluntario v
            JOIN usuario u ON v.id_usuario = u.id
            ORDER BY u.nombre
        ");
        return $stmt->fetchAll();
    }

    public function contarPorTipoAyuda(): array
    {
        $stmt = $this->conn->query("SELECT tipo_ayuda, COUNT(*) as total FROM voluntario GROUP BY tipo_ayuda");
        return $stmt->fetchAll();
    }

    public function insertarSoloId(int $id_usuario): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO voluntario (id_usuario) VALUES (:id)");
        return $stmt->execute([':id' => $id_usuario]);
    }

    public function eliminarPorIdUsuario(int $id_usuario): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM voluntario WHERE id_usuario = :id");
        return $stmt->execute([':id' => $id_usuario]);
    }
}
?>
