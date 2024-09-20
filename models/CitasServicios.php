<?php
namespace Model;

class CitasServicios extends ActiveRecords {
    protected static $tabla = "citasservicios";
    protected static $atributos = [];
    protected static $columnasDB = [
        "id",
        "citas_id",
        "servicios_id"
    ];

    public $id;
    public $citas_id;
    public $servicios_id;

    public function __construct($datos = [])
    {
        $this->id = $datos["id"] ?? 0;
        $this->citas_id = $datos["citas_id"] ?? "";
        $this->servicios_id = $datos["servicios_id"] ?? "";
    }

    public function setAtributos() {
        foreach(static::$columnasDB as $columna) {
            static::$atributos[$columna] = $this->$columna;
        }
    }
}