<?php

require_once __DIR__ . '/Usuario.php';

class Admin extends Usuario
{
    public function __construct()
    {
        parent::__construct();
    }

    //funcion para insertar el usuario 
    public function insertarUsuario(array $datos): bool
    {
        $hash = password_hash($datos['password'], PASSWORD_BCRYPT);
    
        
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO usuario (nombre, apellidos, email, password, id_rol)
                VALUES (:nombre, :apellidos, :email, :password, 3)
            ");
            $stmt->execute([
                ':nombre'    => $datos['nombre'],
                ':apellidos' => $datos['apellidos'],
                ':email'     => $datos['email'],
                ':password'  => $hash
            ]);

            $id_usuario = $this->conn->lastInsertId();

            $stmt2 = $this->conn->prepare("
                INSERT INTO admin (id_usuario, nivel_permiso)
                VALUES (:id_usuario, :nivel_permiso)
            ");
            $stmt2->execute([
                ':id_usuario'     => $id_usuario,
                ':nivel_permiso'  => $datos['nivel_permiso'] ?? 'moderador'
            ]);

            return true;

        } catch (Exception $e) {
            throw new RuntimeException('No se ha podido insertar al admin: ' . $e->getMessage());
        }
    }

    public function buscarDatosAdmin(int $id_usuario): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT a.*, u.nombre, u.apellidos, u.email, u.foto_perfil
            FROM admin a
            INNER JOIN usuario u ON a.id_usuario = u.id
            WHERE a.id_usuario = :id_usuario
        ");
        $stmt->execute([':id_usuario' => $id_usuario]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result === false ? null : $result;
    }

    public function listarTodosAdmin(): array
    {
        $sql = "SELECT a.*, u.nombre, u.apellidos, u.email, u.foto_perfil, u.created_at
                FROM admin a
                INNER JOIN usuario u ON a.id_usuario = u.id
                ORDER BY u.created_at DESC";
        
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
