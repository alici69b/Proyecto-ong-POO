<?php

require_once __DIR__ . '/../config/db.php';

class Impacto
{
    private PDO $conn;

    //creamos el constructor
    public function __construct()
    {
        $Db = new Db();
        $this->conn = $Db->getConnection();
    }
    //contamos los resets totales
    public function contarResets(): int
    {
        try {
            $stmt = $this->conn->query("SELECT COUNT(*) FROM reset");
            return  $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }

    //funcion para contar las historias completadas
    public function contarCompletados(): int
    {
        try {
            $stmt = $this->conn->query("SELECT COUNT(*) FROM reset WHERE id_estado = 3");
            return  $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }

    //funcion para contar a los voluntarios
    public function contarVoluntarios(): int
    {
        try {
            $stmt = $this->conn->query("SELECT COUNT(*) FROM voluntario");
            return  $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }

    //funcion para obtener las categorias de la pagina impacto
    public function obtenerCategorias(): array
    {
        try {
            $stmt = $this->conn->query("
                SELECT cr.nombre_categoria, COUNT(r.id) as total
                FROM categoria_reset cr
                LEFT JOIN reset r ON r.id_categoria = cr.id
                GROUP BY cr.id, cr.nombre_categoria
                ORDER BY cr.id
            ");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    // funcion para obtener la evolucion mensual 
    public function obtenerEvolucionMensual(): array
    {
        try {
            $stmt = $this->conn->query("
                SELECT MONTH(created_at) as mes, COUNT(*) as total
                FROM reset
                GROUP BY MONTH(created_at)
                ORDER BY mes
            ");
            $result = $stmt->fetchAll();
            if (empty($result)) {
                $meses = [8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic', 1 => 'Ene'];
                $result = [];
                foreach ($meses as $num => $label) {
                    $result[] = ['label' => $label, 'total' => 0];
                }
                return $result;
            }
            $mesNombres = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun',
                           7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
            $evolucion = [];
            foreach ($result as $row) {
                $evolucion[] = [
                    'label' => $mesNombres[$row['mes']],
                    'total' =>  $row['total']
                ];
            }
            return $evolucion;
        } catch (Exception $e) {
            return [];
        }
    }

    //funcipn de la tasa de exito 
    public function tasaExito(): int
    {
        $total = $this->contarResets();
        $completados = $this->contarCompletados();
        if ($total > 0) {
            return  round(($completados / $total) * 100);
        }
        return 0;
    }
}
