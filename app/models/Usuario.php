<?php



//definimos las clase usuario 
abstract class Usuario
{
    //atributo de la conexion de la bbdd
    protected PDO $conn;

    //constructor 
    public function __construct()
    {
        $Db = new Db();
        $this->conn = $Db->getConnection();
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

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result === false ? null : $result;
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

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result === false ? null : $result;
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

    // Métodos del panel admin 

    public function contarTodos(): int
    {
        return (int)$this->conn->query("SELECT COUNT(*) FROM usuario")->fetchColumn();
    }

    public function existeEmail(string $email): bool
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM usuario WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function insertarBase(array $datos): int
    {
        $hash = password_hash($datos['password'], PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("
            INSERT INTO usuario (nombre, apellidos, email, password, id_rol, foto_perfil)
            VALUES (:nombre, :apellidos, :email, :password, :id_rol, 'foto_defecto.webp')
        ");
        $stmt->execute([
            ':nombre'    => $datos['nombre'],
            ':apellidos' => $datos['apellidos'],
            ':email'     => $datos['email'],
            ':password'  => $hash,
            ':id_rol'    => $datos['id_rol'],
        ]);
        return (int)$this->conn->lastInsertId();
    }

    public function actualizarDatosAdmin(int $id, string $nombre, string $apellidos, string $email, int $id_rol): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE usuario SET nombre = :nombre, apellidos = :apellidos, email = :email, id_rol = :id_rol WHERE id = :id
        ");
        return $stmt->execute([
            ':nombre'    => $nombre,
            ':apellidos' => $apellidos,
            ':email'     => $email,
            ':id_rol'    => $id_rol,
            ':id'        => $id,
        ]);
    }

    public function obtenerUltimos(int $limite = 5): array
    {
        $stmt = $this->conn->prepare("
            SELECT u.id, u.nombre, u.email, u.foto_perfil, u.created_at, r.nombre_rol
            FROM usuario u
            JOIN roles r ON u.id_rol = r.id
            ORDER BY u.created_at DESC
            LIMIT :limite
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function contarConFiltro(string $buscar = ''): int
    {
        $sql = "SELECT COUNT(*) FROM usuario u";
        if ($buscar !== '') {
            $sql .= " WHERE u.nombre LIKE :buscar OR u.apellidos LIKE :buscar2 OR u.email LIKE :buscar3";
        }
        $stmt = $this->conn->prepare($sql);
        if ($buscar !== '') {
            $like = "%$buscar%";
            $stmt->bindValue(':buscar', $like);
            $stmt->bindValue(':buscar2', $like);
            $stmt->bindValue(':buscar3', $like);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function listarPaginado(string $buscar = '', int $pagina = 1, int $porPagina = 10): array
    {
        $sql = "SELECT u.*, r.nombre_rol FROM usuario u JOIN roles r ON u.id_rol = r.id";
        if ($buscar !== '') {
            $sql .= " WHERE u.nombre LIKE :buscar OR u.apellidos LIKE :buscar2 OR u.email LIKE :buscar3";
        }
        $sql .= " ORDER BY u.created_at DESC LIMIT :limite OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        if ($buscar !== '') {
            $like = "%$buscar%";
            $stmt->bindValue(':buscar', $like);
            $stmt->bindValue(':buscar2', $like);
            $stmt->bindValue(':buscar3', $like);
        }
        $stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', ($pagina - 1) * $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
