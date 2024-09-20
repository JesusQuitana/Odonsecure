<?php
namespace Controllers;
use MVC\Router;
use Model\Cita;
use Model\CitasServicios;
use Model\Usuarios;
use Model\PDF;

abstract class AdminController {

    /*SELECT citas.id, fecha, hora, CONCAT(usuarios.nombre, " ", usuarios.apellido) as cliente, email, telf as telefono, servicios.nombre as servicio, servicios.precio from citasservicios LEFT JOIN citas ON citasservicios.citas_id=citas.id LEFT JOIN servicios ON citasservicios.servicios_id=servicios.id LEFT JOIN usuarios ON citas.usuarios_id=usuarios.id;*/
    
    public static function admin() {

        verificarSesion();

        Router::render("admin/admin", [
            
        ]);
    }
}