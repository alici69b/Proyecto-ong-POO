<?php

//creamos la clase hija de usuario

class Reset extends Usuario
{
    protected $conn;

    public function __construct()
    {
        parent::__construct();
    }

    //funcion del registro del usuario, lo insertamos en la bbdd
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

    //la funcion registro hace el request_method y recoge los datos del formulario, void es que no devuelve nada
    public function registro(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('index.php?ruta=registro');
            return;
        }

        // recogemos los datos
        $nombre    = trim($_POST['nombre'] ?? '');
        $apellidos = trim($_POST['apellidos'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';

        // validamos los nmbres vacios
        if (empty($nombre) || empty($apellidos) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Todos los campos son obligatorios";
            $this->redirigir('index.php?ruta=registro');
            return;
        }

        // validamos el formato email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "El email no es válido";
            $this->redirigir('index.php?ruta=registro');
            return;
        }

        // comprobamos si el email existe
        if ($this->buscarPorEmail($email)) {
            $_SESSION['error'] = "Este email ya está registrado";
            $this->redirigir('index.php?ruta=registro');
            return;
        }

        // creamos el usuario para guardarlo 
        $datos = [
            'nombre'    => $nombre,
            'apellidos' => $apellidos,
            'email'     => $email,
            'password'  => $password
        ];

        if ($this->insertarUsuario($datos)) {
            $_SESSION['exito'] = "Registro exitoso, ya puedes iniciar sesión";
            $this->redirigir('index.php?ruta=login');
        } else {
            $_SESSION['error'] = "Error al registrar, inténtalo de nuevo";
            $this->redirigir('index.php?ruta=registro');
        }
    }
}
