<?php
//###############LIBREARIAS A USAR#####
use PDO;
use PDOException;

//###############DB####################
function conectarDB() :PDO {
    try {
        $conexion = new PDO("mysql:host={$_ENV["DB_HOST"]}; dbname={$_ENV["DB_NAME"]}", "{$_ENV["DB_USERNAME"]}", "{$_ENV["DB_PASSWORD"]}");
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    }
    catch(Exception $e) {
        echo "Error: ".$e->getMessage();
    }
}


//###############HELPERS###############
function debugear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function scripts(string $script) {
    echo "<script src='build/js/".$script.".js'></script>";
}

function mostrarAlertas($alertas) {
    foreach($alertas["error"] as $alerta) {
        echo $alerta;
    }
    foreach($alertas["exito"] as $alerta) {
        echo $alerta;
    }
}

function verificarSesion() {
    session_start();
    if(!$_SESSION["login"]) {
        header("Location: ./");
    }
}

function verificarSesionAdmin() {
    session_start();
    if(!$_SESSION["login"] || $_SESSION["admin"]===0) {
        header("Location: ./");
    }
}

function jsonDebug($variable) {
    echo json_encode($variable);
    exit;
}

