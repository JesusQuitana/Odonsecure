<?php
namespace Controllers;

use MVC\Router;
use Controllers\APIController;
use Model\Servicios;

abstract class UserController {
    public static function inicio() {
        verificarSesion();

        $alertas = Servicios::getAlertas();
        Router::render("user/inicio", [
            "alertas" => $alertas
        ]);
    }
}