<?php

//Cargo el autoload de Composer para usar phpdotenv y otras librerías
require_once __DIR__ . '/../../vendor/autoload.php';

//Cargo las variables del .env (ahí guardamos las credenciales)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
//safeLoad evita que lance error si el .env no existe (ej: hosting con variables de entorno)
$dotenv->safeLoad();

//Definimos la clase
class Db {
    //Atributos
    private PDO $connection;
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $charset;

    //Constructor
    public function __construct() {
        //Leo las credenciales desde .env o variables de entorno del sistema
        //Si no están definidas, uso los valores por defecto de XAMPP local
        $this->host    = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? '127.0.0.1';
        $this->dbname  = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? 'proyecto_ong_poo';
        $this->user    = $_ENV['DB_USER'] ?? getenv('DB_USER') ?? 'root';
        $this->password = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?? '';
        $this->charset = "utf8mb4";

        try {
            //Configurar la conexión a la base de datos
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            //Opciones para la conexión
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            //Creamos la conexión a la base de datos
            $this->connection = new PDO($dsn, $this->user, $this->password, $options);

        //Manejamos errores
        } catch (PDOException $e) {
            throw new RuntimeException("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    //Método para obtener la conexión
    public function getConnection(): PDO {
        return $this->connection;
    }
}