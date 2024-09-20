<?php
//###############CONSTANTES Y VARIABLES
define("AUTOLOAD", dirname(__DIR__) . "\\vendor\\autoload.php");

//###############INCLUDES##############
include AUTOLOAD;

//###############LIBRERIAS Y MODELOS###
use Model\ActiveRecords;

//###############VARIABLES DE ENTORNO DEL PROYECTO
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

include __DIR__ . "/functions.php";

//##############CONECTAR BASE DE DATOS#;
ActiveRecords::conectarDB();