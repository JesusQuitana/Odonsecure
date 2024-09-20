<?php
namespace Model;

class Servicios extends ActiveRecords {
    protected static $tabla = "servicios";
    protected static $columnasDB = [
        "id",
        "nombre",
        "precio"
    ];
    public $id;
    public $nombre;
    public $precio;

    public function __construct($datos = [])
    {
        $this->nombre = $datos["nombre"] ?? "";
        $this->precio = $datos["precio"] ?? floatval(0);
    }

    public function validarServicioNuevo() {
        if($this->nombre == "") {
            self::setAlertas("error", "El servicio debe tener un nombre");
        }
        if($this->precio == floatval(0)) {
            self::setAlertas("error", "El servicio debe tener un precio");
        }
        return self::$alertas;
    }
}