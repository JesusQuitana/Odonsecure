<?php
namespace Model;

use Exception;
use Model\ActiveRecords;

class Usuarios extends ActiveRecords {
    protected static $atributos = [];
    protected static $columnasDB = [
        "id",
        "nombre",
        "apellido",
        "email",
        "telf",
        "user",
        "passw",
        "confirm",
        "token",
        "admin"
    ];
    protected static $tabla = "usuarios";
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telf;
    public $user;
    public $passw;
    public $confirm;
    public $token;
    public $admin;

    public function __construct(array $datos=[])
    {
        $this->id = $datos["id"] ?? 0;
        $this->nombre = $datos["nombre"] ?? "";
        $this->apellido = $datos["apellido"] ?? "";
        $this->email = $datos["email"] ?? "";
        $this->telf = $datos["telf"] ?? "";
        $this->user = strtolower($datos["user"]) ?? "";
        $this->passw = $datos["passw"] ?? "";
        $this->confirm = 0;
        $this->admin = 0;
    }
    
    public function setAtributos() {
        foreach(static::$columnasDB as $columna) {
            static::$atributos[$columna] = $this->$columna;
        }
    }

    public function setToken() {
        $this->token = uniqid();
    }

    public function setPassword() {
        $passwordHash = password_hash($this->passw, PASSWORD_BCRYPT);
        $this->passw = $passwordHash;
    }

    public function validarCuentaNueva() {
        if($this->nombre=="" || $this->user=="" || $this->telf=="" || $this->email=="" || $this->apellido=="") {
            $this->setAlertas("error", "Todos los Campos son Obligatorios");
        }
        if(strlen($this->passw) < 6 || $this->passw=="") {
            $this->setAlertas("error", "La contraseña debe contener al menos 6 caracteres");
        }
        return self::getAlertas();
    }

    public function validarCambioPassword($password, $password_repeat) {
        if($password=="" || strlen($password)<6 || $password!==$password_repeat) {
            self::setAlertas("error", "La contraseña debe contener al menos 6 caracteres y deben se iguales");
        }
        return self::getAlertas();
    }

    public function cambioPassword($password) {
        $this->passw = $password;
        $this->token = "";
        $this->setPassword();
        $this->setAtributos();
        return $this::actualizar();
    }

    public function confirmarCuenta() {
        $this->token = "";
        $this->confirm = 1;
        $this->setAtributos();
        return $this::actualizar();
    }

    public function guardar() {
        $this->setAtributos();
        return $this::actualizar();
    }
}