<?php



//definimos las clase usuario 
abstract class Usuario
{
    //atributo de la conexion de la bbdd
    protected $conn;

    //constructor 
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    //fdunciones donde los hijos van a heredar y no cambian para ellos
    //mostrare solo una fila por lo tanto tendre que mostrarlo con el fetch
    public function buscarPorEmail(string $email): ?array
    {
        try {
            $sql = "SELECT u.*, r.nombre_rol FROM usuario u
                INNER JOIN roles r ON u.id_rol = r.id
                WHERE u.email = :email;";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':email' => $email,
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $error) {
            throw new RuntimeException("Error al buscar por email: " . $error->getMessage());
        }
    }

    //funcion buscar por id 
    public function buscarPorId(int $id): ?array
    {
        try {
            $sql = "SELECT u.*, r.nombre_rol FROM usuario u
                INNER JOIN roles r ON u.id_rol = r.id
                WHERE u.id = :id;";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $error) {
            throw new RuntimeException("Error al buscar por id: " . $error->getMessage());
        }
    }

    //funcion erificar contraseña, para que pueda entrar a su panel correspondiente
    //utilizaremos la  funcion que hemos creado anteriormente para biuscar el email que exista y verificar la contrseña
    public function verificarPassword(string $email, string $password): bool
    {
        try {
            $usuario = $this->buscarPorEmail($email);
            if (!$usuario) {
                return false;
            }
            return password_verify($password, $usuario['password']);
        } catch (Exception $error) {
            throw new RuntimeException("Error verificar la contraseña: " . $error->getMessage());
        }
    }

    //functio que hará que podamos cambiar la contraseña
    public function cambiarPassword(int $id, string $nueva_password): bool
    {
        try {
            $hash = password_hash($nueva_password, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare("
            UPDATE usuario SET password = :password WHERE id = :id
        ");
            return $stmt->execute([
                ':password' => $hash,
                ':id' => $id
            ]);
        } catch (Exception $error) {
            throw new RuntimeException("Error verificar la contraseña: " . $error->getMessage());
        }
    }

    //function para eliminar el usuario, dentro del panel admin tendremos para eliminar el usuario 
    public function eliminar(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM usuario WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    //function para actualizar el usuario, dentro del panel admin tendremos para actualizar los usuarios
    public function actualizar(int $id, string $nombre, string $apellidos, string $foto_perfil): bool
    {

        try {

            $stmt = $this->conn->prepare("
            UPDATE usuario 
            SET nombre = :nombre, apellidos = :apellidos, foto_perfil = :foto_perfil 
            WHERE id = :id
        ");
            return $stmt->execute([
                ':nombre'      => $nombre,
                ':apellidos'   => $apellidos,
                ':foto_perfil' => $foto_perfil,
                ':id'          => $id
            ]);
        } catch (Exception $error) {
            throw new RuntimeException("Error al actualizar: " . $error->getMessage());
        }
    }


    //metodo abstracto, que heredarn los hijos y cada uno tendran 
    //el array de $datos, se recoge a traves del registro de cada uno de los usuarios
    abstract public function insertarUsuario(array $datos);
}
