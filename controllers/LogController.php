<?php
namespace Controllers;
use MVC\Router;
use Model\Usuarios;
use Model\Email;

abstract class LogController {

//###################LOG USUARIOS
    public static function login() {
        if($_SERVER["REQUEST_METHOD"]==="POST") {
            $usuario = Usuarios::where("user", strtolower($_POST["user"]));
            
            if($usuario==false) {
                Usuarios::setAlertas("error", "Usuario Invalido");
            } else {
                if(password_verify($_POST["passw"], $usuario->passw) && $usuario->confirm==1) {
                session_start();
                $_SESSION["id"] = $usuario->id;
                $_SESSION["user"] = $usuario->user;
                $_SESSION["nombre"] = $usuario->nombre." ".$usuario->apellido;
                $_SESSION["admin"] = $usuario->admin;
                $_SESSION["login"] = true;
                if($_SESSION["admin"]==1) {
                    header("Location: /admin");
                } else {
                    header("Location: /user");
                }
                } else {
                Usuarios::setAlertas("error", "Contraseña Invalida o No Confirmada");
                }
            }
        }
        $alertas = Usuarios::getAlertas();
        Router::render("login/login", [
            "alertas"=>$alertas
        ]);
    }

//#############################CERRAR SESSION##############
    public static function cerrarSession() {
        session_start();
        $_SESSION = [];
        $_SESSION["login"] = false;
        header("Location: ./");
    }

//#############################REGISTAR NUVO USUARIO
    public static function register() {
        
        if($_SERVER["REQUEST_METHOD"]==="POST") {
            $usuario = new Usuarios($_POST);
            if($usuario->passw !== $_POST["passw_confirm"]) {
                Usuarios::setAlertas("error", "Las Contraseñas deben ser iguales");
                $validacion = Usuarios::getAlertas();
            }
            $validacion = $usuario->validarCuentaNueva();

            if(empty($validacion)) {
                $usuario->setToken();
                $usuario->setPassword();
                $usuario->setAtributos();
                $registro = $usuario::registrar();

                if( $registro["resultado"] ) {
                    Email::enviarConfirmacion($usuario->token, $usuario->email);
                    header("Location: /confirm");
                } else {
                    $usuario::setAlertas("error", "Error al Registrar Usuario");
                }
            }
            $alertas = $usuario->getAlertas();
        }
        Router::render("login/register", [
            "alertas"=>$alertas
        ]);
    }

//###################CONFIRMAR USUARIOS
    public static function confirm() {
        $token = $_GET["token"] ?? "";
        
        if($token=="") {
            Usuarios::setAlertas("exito", "Hemos Enviado un correo con las instrucciones para validar tu cuenta");
        } 
        else {
            $usuario = Usuarios::where("token", $token);
            if($usuario==false) {
                Usuarios::setAlertas("error", "Token Invalido");
            } else {
                if( $usuario->confirmarCuenta() ) {
                    Usuarios::setAlertas("exito", "Tu cuenta ha sido Validada");
                }
            }
        }
        $alertas = Usuarios::getAlertas();
        Router::render("login/confirm", [
            "alertas"=>$alertas
        ]);
    }

    public static function forget() {
        if($_SERVER["REQUEST_METHOD"]==="POST") {
            $email = $_POST["email"];
            $usuario = Usuarios::where("email", $email);
            if($usuario==false) {
                Usuarios::setAlertas("error", "Usuario no Existe");
            } else if($usuario->confirm==0)  {
                Usuarios::setAlertas("error", "Usuario no Confirmado");
            } else {
                $usuario->setToken();
                $usuario->guardar();
                Email::enviarReestablecer($usuario->token, $usuario->email);
                Usuarios::setAlertas("exito", "Hemos Enviado un correo con las instrucciones para reestablecer tu cuenta");
            }
        }
        $alertas=Usuarios::getAlertas();
        Router::render("login/forget", [
            "alertas"=>$alertas
        ]);
    }

    public static function change() {
        $token = $_GET["token"];
        $usuario = Usuarios::where("token", $token);

        if($usuario!==false) {
            if($_SERVER["REQUEST_METHOD"]==="POST") {
                $validacion = $usuario->validarCambioPassword($_POST["password"], $_POST["repeat_password"]);
                
                if(empty($validacion)) {
                    if($usuario->cambioPassword($_POST["password"])) {
                        header("Location: ./");
                    } else {
                        Usuarios::setAlertas("error", "Error al Reestablecer Contraseña");
                    }
                }
            }
        }
        else {
            header("Location: ./");
        }

        $alertas = Usuarios::getAlertas();
        Router::render("login/change", [
            "alertas"=>$alertas
        ]);
    }
}