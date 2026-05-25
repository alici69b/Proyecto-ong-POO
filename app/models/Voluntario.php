<?php

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

}
