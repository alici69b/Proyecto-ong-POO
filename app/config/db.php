<?php
//Definimos la clase
class Db {
    //Atributos
    private PDO $connection;
    private string $host;
    private string $dbname;
    private string $user;
    private string $password;
    private string $charset;

    //Constructor
    public function __construct() {
        $this->host = "localhost";
        $this->dbname = "proyecto_ong_poo";
        $this->user = "root";
        $this->password = "";
        $this->charset = "utf8mb4";

        try {
            //Confugurar la conexión a la base de datos
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