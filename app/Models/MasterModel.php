<?php

namespace Models;
require '../vendor/autoload.php';

use PDOException;
use Exception;
use PDO;
use Connection\Connection;

class MasterModel extends Connection {

    protected $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance()->getPdo();
    }
    public function getLastId($table, $idColumnName = 'id')
    {
        $sql = "SELECT `$idColumnName` FROM `$table` ORDER BY `$idColumnName` DESC LIMIT 1";
        $params = [];
        $result = $this->select($sql, $params);
        $lastId = $result[0][$idColumnName];
        return $lastId;
    }
    
    public function selectById($table, $idColumn, $idValue)
    {
    $sql = "SELECT * FROM $table WHERE $idColumn = :id";
    $params = [':id' => $idValue];
    $result = $this->select($sql, $params);
    return $result;
    }

    public function update($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            if (!$result) {
                //error_log(print_r("La actualización no se ejecutó correctamente", true));
                throw new Exception('La actualización no se ejecutó correctamente');
            }
            return $result;
        } catch (PDOException $e) {
            //error_log(print_r($e->getMessage(), true));
            throw new Exception('Error al ejecutar la consulta: ' . $e->getMessage());
        }
    }

    public function updateNew($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            if ($stmt->rowCount() > 0) {
                return true; // Al menos una fila fue actualizada correctamente
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception('Error al ejecutar la consulta: ' . $e->getMessage());
        }
    }

   public function select($sql, $params = []) {
    try {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        throw new Exception('Error al ejecutar la consulta: ' . $e->getMessage());
    }  
    }

    public function delete($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            if (!$result) {
                throw new Exception('La consulta no se ejecutó correctamente');
            }
            return $stmt->rowCount(); // retorna la cantidad de filas afectadas por la operación
        } catch (PDOException $e) {
            throw new Exception('Error al ejecutar la consulta: ' . $e->getMessage());
        }
    }

    public function insert($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            if (!$result) {
                //error_log(print_r($result, true));
                throw new Exception('La consulta no se ejecutó correctamente');
            }
            //error_log(print_r($this->pdo->lastInsertId(), true));
            return $this->pdo->lastInsertId(); // retorna el ID del último registro insertado
        } catch (PDOException $e) {
            //error_log(print_r($e->getMessage(), true));
            throw new Exception('Error al ejecutar la consulta: ' . $e->getMessage());
        }
    }  
    
    public function updateField($table, $idColumn, $idValue, $field, $value)
{
    $sql = "UPDATE $table SET $field = :value WHERE $idColumn = :id";
    $params = [
        ':value' => $value,
        ':id' => $idValue
    ];
    
    try {
        $result = $this->update($sql, $params);
        return $result;
    } catch (Exception $e) {
        // Manejo de errores
        throw new Exception('Error al actualizar el campo: ' . $e->getMessage());
    }
}

    
    

}
?>


