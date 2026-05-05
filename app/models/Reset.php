<?php 

//creamos la clase hija de usuario

class Reset extends Usuario {
    //  //creamos el usuario, cada uno de los atributos que le pasamos tiene el tipo que es. Esta function es tipo : bool porque solo nos devolvera un true o un false
    // public function registrarUsuario(string $nombre,string $apellidos, string $email,string  $password,int  $id_rol ) {
    //     try {
    //         $hash = password_hash($password, PASSWORD_BCRYPT);      
    //         $sql = "INSERT INTO usuario( nombre, apellidos, email, password, id_rol ) VALUES (:nombre, :apellidos, :email, :password, :id_rol);";
    //         $stmt = $this->conn->prepare($sql);
    //         return $stmt->execute([
    //             ':nombre' => $nombre,
    //             ':apellidos' => $apellidos,
    //             ':email' => $email,
    //             ':password' => $hash,
    //             ':id_rol' => $id_rol,

    //         ]);
    //     //si no functiona, manda una excepcion al creaqr el usuario
    //     } catch (Exception $error) {
    //          throw new RuntimeException("Error al registrarse: " . $error->getMessage());
    //     }
    // }
}
