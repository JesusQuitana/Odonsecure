<?php
namespace Controllers;

use Model\Cita;
use Model\CitasServicios;
use Model\Servicios;
use Model\PDF;
use Model\Email;
use Model\Usuarios;

abstract class APIController {
    public static function getServicios() {
        verificarSesion();

        echo json_encode(Servicios::select());
    }

    public static function resumen() {
        //INICIAR SESSION PARA OBTENER EL ID DEL USUARIO QUE AGENDO LA CITA
        verificarSesion();

        //OBTENER LOS DATOS DE LA CITA JUNTO AL USUARIO
        $datos["fecha"] = $_POST["fecha"];
        $datos["hora"] = $_POST["hora"];
        $datos["usuarios_id"] = $_SESSION["id"];
        $servicios = explode(",", $_POST["servicios"]);

        //CREAR E INSERTAR LA CITA EN LA BASE DE DATOS
        $cita = new Cita($datos);
        $cita->setAtributos();
        $resultadoCita = $cita::registrar();

        //INSERTAR LOS REGISTROS POR CITAS EN LA BASE DE DATOS
        if($resultadoCita["resultado"]) {
            foreach($servicios as $servicio) {
                $array = [
                    "citas_id"=>intval($resultadoCita["id"]),
                    "servicios_id"=>intval($servicio)
                ];
                $citaServicio = new CitasServicios($array);
                $citaServicio->setAtributos();
                $resultado = $citaServicio::registrar();
            }
        //ENVIAR PDF AL USUARIO DEL RESUMEN DE LA CITA
            //ITERAR SOBRE LOS SERVICIOS PARA AÑADIRLO AL PDF
            foreach($servicios as $idServicio) {
                $datosPDF["servicios"][] = Servicios::where("id", $idServicio);
            }
            //ASIGNAR LOS DATOS DE LA CITA PARA AÑADIRLO AL PDF
            $cliente = Usuarios::where("id", $datos["usuarios_id"]);
            $datosPDF["cliente"] = explode(" ", $cliente->nombre)[0] . "_" . explode(" ", $cliente->apellido)[0];
            $datosPDF["fecha"] = $datos["fecha"];
            $datosPDF["hora"] = $datos["hora"];
            $datosPDF["cita"] = $resultadoCita["id"];
            $pdfEnviar = PDF::crearPDFUSER($datosPDF);

            if($pdfEnviar["respuesta"]){
                
                jsonDebug(["resultado"=>Email::enviarResumen(["cliente"=>$datosPDF["cliente"], "email"=>$cliente->email], $pdfEnviar["dir"], $pdfEnviar["nombreArchivo"])]);
            }
        } else {
            $resultadoCita["resultado"] = false;
        }
    }

    public static function allCitas() {
        verificarSesion();

        $citas = Cita::sql('SELECT citas.id, fecha, hora, CONCAT(usuarios.nombre, " ", usuarios.apellido) as cliente, email, telf as telefono, servicios.nombre as servicio, servicios.precio from citasservicios LEFT JOIN citas ON citasservicios.citas_id=citas.id LEFT JOIN servicios ON citasservicios.servicios_id=servicios.id LEFT JOIN usuarios ON citas.usuarios_id=usuarios.id');

        jsonDebug($citas);
    }

    public static function find() {
        verificarSesion();

        $respuesta = $_POST;

        if($respuesta["fecha"]!=="") {
            $citas = Cita::sql('SELECT citas.id, fecha, hora, CONCAT(usuarios.nombre, " ", usuarios.apellido) as cliente, email, telf as telefono, servicios.nombre as servicio, servicios.precio from citasservicios LEFT JOIN citas ON citasservicios.citas_id=citas.id LEFT JOIN servicios ON citasservicios.servicios_id=servicios.id LEFT JOIN usuarios ON citas.usuarios_id=usuarios.id WHERE fecha="'.$respuesta["fecha"].'"');
        } else if($respuesta!=="") {
            $citas = Cita::sql('SELECT citas.id, fecha, hora, CONCAT(usuarios.nombre, " ", usuarios.apellido) as cliente, email, telf as telefono, servicios.nombre as servicio, servicios.precio from citasservicios LEFT JOIN citas ON citasservicios.citas_id=citas.id LEFT JOIN servicios ON citasservicios.servicios_id=servicios.id LEFT JOIN usuarios ON citas.usuarios_id=usuarios.id WHERE CONCAT(usuarios.nombre, " ", usuarios.apellido)="'.$respuesta["user"].'"');
        }

        jsonDebug($citas);
    }

    public static function enviarResumen() {
        verificarSesion();

        $datos = $_POST;

        $respuesta = PDF::crearPDF($datos);

        if(Email::enviarResumen($datos, $respuesta["dir"], $respuesta["nombreArchivo"])) {
            jsonDebug($respuesta["respuesta"]);
        } else {
            jsonDebug(["respuesta"=>false]);
        }        
    }

    public static function eliminarCita() {
        verificarSesion();

        $id = $_POST["id"];

        if(Cita::where("id", $id)) {
            jsonDebug(["resultado"=>Cita::delete($id)]);
        } else {
            jsonDebug(["resultado"=>false]);
        }
    }

    public static function verificarDatos() {
        $datos = $_POST;

        if($datos["email"] || $datos["user"]) {
            $email = Usuarios::where("email", $datos["email"])->email;
            $user = Usuarios::where("user", $datos["user"])->user;
        }

        jsonDebug([$email, $user]);
    }
}