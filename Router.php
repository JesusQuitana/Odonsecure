<?php
namespace MVC;

abstract class Router {
    protected static $rutasGET = [];
    protected static $rutasPOST = [];

    public static function rutasGETValidas($url, $fn) {
        self::$rutasGET[$url] = $fn;
    }
    public static function rutasPOSTValidas($url, $fn) {
        self::$rutasPOST[$url] = $fn;
    }

    public static function validarRuta() {
        $urlActual = strtok($_SERVER["REQUEST_URI"], '?') ?? "/";
        if($_SERVER["REQUEST_METHOD"]=="GET") {
            $fn = self::$rutasGET[$urlActual];
        } else {
            $fn = self::$rutasPOST[$urlActual];
        }
        if($fn===null) {
            echo "<h1>Pagina No Econtrada</h1>";
        } else {
            call_user_func($fn);
        }
    }

    public static function render($view, $datos=[]) {
        ob_start();
        foreach($datos as $key=>$value) {
            $$key = $value;
        }
        include_once "views/".$view.".php";
        $contenido = ob_get_clean();
        include __DIR__ . '/views/layout.php';
    }
}