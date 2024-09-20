<?php
namespace Model;

use Exception;
use PDO;

abstract class ActiveRecords {
    protected static $conexionDB;
    protected static $tabla = "";
    protected static $columnasDB = [];
    protected static $alertas = [];

    public static function conectarDB() {
        self::$conexionDB = conectarDB();
    }

    public static function setAlertas($tipo, $mensaje) {
        if($tipo == "error") {
            self::$alertas["error"][] = "<p class='alerta rojo'>".$mensaje."</p>";
        } else if($tipo == "exito") {
            self::$alertas["exito"][] = "<p class='alerta verde'>".$mensaje."</p>";
        }
    }

    public static function getAlertas() {
        return self::$alertas;
    }

    protected static function object($resultado) {
        $object = new static;
        foreach($resultado as $key=>$value) {
            if(property_exists($object, $key)) {
                $object->$key=$value;
            }
        }
        return $object;
    }

    public static function registrar() {
        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(", ", array_keys(static::$atributos)) . ") VALUES (:";
        $query .= join(", :", array_keys(static::$atributos)) . ")";
        try {
            $consulta = self::$conexionDB->prepare($query);
            foreach(static::$atributos as $key=>$value) {
                $consulta->bindValue(":".$key, $value);
            }
            $consulta->execute();
            if($consulta->rowCount()!=0) {
                return ["resultado"=>true, "id"=>self::$conexionDB->lastInsertId()];
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return "Error: ".$e->getMessage();
        }
    }

    public static function select() {
        $query = "SELECT * FROM ". static::$tabla;
        try {
            $consulta = self::$conexionDB->prepare($query);
            $consulta->execute();
            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($resultados)) {
                foreach($resultados as $resultado) {
                    $registros[] = self::object($resultado);
                }
                return $registros;
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return "Error: ".$e->getMessage();
        }
    }

    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE " . $columna . "='" . $valor . "' LIMIT 1";
        try {
            $consulta = self::$conexionDB->prepare($query);
            $consulta->execute();
            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($resultados)) {
                foreach($resultados as $resultado) {
                    $registros[] = self::object($resultado);
                    return array_shift($registros);
                }
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return "Error: ".$e->getMessage();
        }
    }

    public static function sql(string $sql) {
        $query = $sql;
        try {
            $consulta = self::$conexionDB->prepare($query);
            $consulta->execute();
            $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
            return $registros;
        }
        catch(Exception $e) {
            return "Error: ".$e->getMessage();
        }
    }

    public static function actualizar() {
        foreach(static::$atributos as $key=>$value) {
            $array[] = $key."=:".$key;
        }
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(", ", array_values($array));
        $query .= " WHERE id=" . static::$atributos["id"];
        try {
            $consulta = self::$conexionDB->prepare($query);
            foreach(static::$atributos as $key=>$value) {
                $consulta->bindValue(":".$key, $value);
            }
            $consulta->execute();
            if($consulta->rowCount()!=0) {
                return true;
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            echo "Error: ".$e->getMessage();
        }
    }

    public static function delete($id) {
        $query = "DELETE FROM ".static::$tabla." WHERE id=".$id;
        try {
            $consulta = self::$conexionDB->prepare($query);
            $consulta->execute();
            if($consulta->rowCount()!=0) {
                return true;
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return "Error: ".$e->getMessage();
        }
    }
}