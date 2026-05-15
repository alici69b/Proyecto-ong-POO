<?php

class UsuarioNormal extends Usuario
{
    public function __construct()
    {
        parent::__construct();
    }

    //funcion para insertar los usuarios en la bbdd
    public function insertarUsuario(array $datos): bool
    {
        $hash = password_hash($datos['password'], PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("
            INSERT INTO usuario (nombre, apellidos, email, password, id_rol)
            VALUES (:nombre, :apellidos, :email, :password, 1)
        ");
        return $stmt->execute([
            ':nombre'    => $datos['nombre'],
            ':apellidos' => $datos['apellidos'],
            ':email'     => $datos['email'],
            ':password'  => $hash
        ]);
    }

    
}
