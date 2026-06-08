<?php

require_once __DIR__ . '/Usuario.php';

class UsuarioNormal extends Usuario
{
    public function __construct()
    {
        parent::__construct();
    }

    // Inserta el usuario en la bbdd (ya lo tenías)
    public function insertarUsuario(array $datos): bool
    {
        $hash = password_hash($datos['password'], PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("
            INSERT INTO usuario (nombre, apellidos, email, password, id_rol, foto_perfil)
            VALUES (:nombre, :apellidos, :email, :password, 1, 'foto_defecto.webp')
        ");
        $exito = $stmt->execute([
            ':nombre'    => $datos['nombre'],
            ':apellidos' => $datos['apellidos'],
            ':email'     => $datos['email'],
            ':password'  => $hash
        ]);

        if ($exito) {
            $id_usuario = $this->conn->lastInsertId();
            $stmt2 = $this->conn->prepare("
                INSERT INTO usuario_normal (id_usuario, tipo_ayuda)
                VALUES (:id_usuario, :tipo_ayuda)
            ");
            $stmt2->execute([
                ':id_usuario' => $id_usuario,
                ':tipo_ayuda' => $datos['tipo_ayuda'] ?? 'otros'
            ]);
        }

        return $exito;
    }

    // Obtiene los datos del perfil uniendo usuario y usuario_normal
    // Igual que obtenerPerfil() en Voluntario
    public function obtenerPerfil(int $id_usuario): array|false
    {
        $stmt = $this->conn->prepare("
            SELECT u.id, u.nombre, u.apellidos, u.email, u.foto_perfil,
                   un.tipo_ayuda
            FROM usuario u
            INNER JOIN usuario_normal un ON un.id_usuario = u.id
            WHERE u.id = :id_usuario
        ");
        $stmt->execute([':id_usuario' => $id_usuario]);
        return $stmt->fetch();
    }

    // Actualiza nombre, apellidos y tipo_ayuda
    // Igual que actualizarDatos() en Voluntario pero sin disponibilidad
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
            ':id_usuario' => $id_usuario
        ]);

        // Actualizamos la tabla usuario_normal
        $stmt2 = $this->conn->prepare("
            UPDATE usuario_normal
            SET tipo_ayuda = :tipo_ayuda
            WHERE id_usuario = :id_usuario
        ");
        $stmt2->execute([
            ':tipo_ayuda' => $datos['tipo_ayuda'],
            ':id_usuario' => $id_usuario
        ]);

        return true;
    }

    // Actualiza la foto de perfil
    // Igual que actualizarFoto() en Voluntario
    public function actualizarFoto(int $id_usuario, string $nombre_archivo): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE usuario
            SET foto_perfil = :foto_perfil
            WHERE id = :id_usuario
        ");
        $stmt->execute([
            ':foto_perfil' => $nombre_archivo,
            ':id_usuario'  => $id_usuario
        ]);
        return $stmt->rowCount() > 0;
    }

    // Cambia la contraseña
    // Igual que cambiarPassword() en Voluntario
    public function cambiarPassword(int $id, string $nueva_password): bool
    {
        try {
            $hash = password_hash($nueva_password, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare("UPDATE usuario SET password = :password WHERE id = :id");
            return $stmt->execute([
                ':password' => $hash,
                ':id'       => $id
            ]);
        } catch (Exception $error) {
            throw new RuntimeException("Error al cambiar la contraseña: " . $error->getMessage());
        }
    }

    // Métodos del panel admin

    public function listarSolicitantes(): array
    {
        $stmt = $this->conn->query("SELECT id, nombre, apellidos FROM usuario WHERE id_rol = 1 ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    public function contarPorTipoAyuda(): array
    {
        $stmt = $this->conn->query("
            SELECT un.tipo_ayuda, COUNT(*) as total
            FROM usuario_normal un
            JOIN usuario u ON u.id = un.id_usuario
            WHERE u.id_rol = 1
            GROUP BY un.tipo_ayuda
        ");
        return $stmt->fetchAll();
    }

    /**
     * Elimina la cuenta de un usuario normal. Antes de eliminar el registro, se cancelan sus resets activos/pendientes.
     * @param int $id El ID del usuario a eliminar.
     * @return bool Devuelve true si la cuenta se eliminó correctamente, false en caso contrario.
     * 
     */
    public function eliminarCuenta(int $id): bool
    {
        // Resets activos/pendientes se cancelan
        $stmt = $this->conn->prepare("
            UPDATE reset
            SET id_estado = 4
            WHERE id_usuario = :id
            AND id_estado IN (1, 2)
        ");
        $stmt->execute([':id' => $id]);

        // Llamamos al padre para borrar el registro
        return parent::eliminarCuenta($id);
    }
}
?>