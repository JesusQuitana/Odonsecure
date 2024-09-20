<?php
namespace Model;

class Cita extends ActiveRecords {
    protected static $tabla = "citas";
    protected static $atributos = [];
    protected static $columnasDB = [
        "id",
        "fecha",
        "hora",
        "usuarios_id"
    ];

    public $id;
    public $fecha;
    public $hora;
    public $usuarios_id;

    public function __construct($datos = [])
    {
        $this->id = $datos["id"] ?? null;
        $this->fecha = $datos["fecha"] ?? "";
        $this->hora = $datos["hora"] ?? "";
        $this->usuarios_id = $datos["usuarios_id"] ?? 0;
    }

    public function setAtributos() {
        foreach(static::$columnasDB as $columna) {
            static::$atributos[$columna] = $this->$columna;
        }
    }
}