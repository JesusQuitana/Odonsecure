<?php
include dirname(__DIR__) . '/includes/app.php';
use MVC\Router;
use Controllers\LogController;
use Controllers\UserController;
use Controllers\AdminController;
use Controllers\APIController;

//#######PAGINAS DE LOG
Router::rutasGETValidas("/", [LogController::class, "login"]);
Router::rutasGETValidas("/register", [LogController::class, "register"]);
Router::rutasGETValidas("/forget", [LogController::class, "forget"]);
Router::rutasGETValidas("/confirm", [LogController::class, "confirm"]);
Router::rutasGETValidas("/change", [LogController::class, "change"]);
Router::rutasGETValidas("/cerrarSession", [LogController::class, "cerrarSession"]);

//#######PAGINAS DE ADMIN
Router::rutasGETValidas("/admin", [AdminController::class, "admin"]);

//#######PAGINAS DE USUARIOS
Router::rutasGETValidas("/user", [UserController::class, "inicio"]);

//#######PAGINAS DE LOG POST
Router::rutasPOSTValidas("/", [LogController::class, "login"]);
Router::rutasPOSTValidas("/register", [LogController::class, "register"]);
Router::rutasPOSTValidas("/confirm", [LogController::class, "confirm"]);
Router::rutasPOSTValidas("/forget", [LogController::class, "forget"]);
Router::rutasPOSTValidas("/change", [LogController::class, "change"]);

//#######RUTAS A USAR CON FETCH API
Router::rutasPOSTValidas("/log/repeat", [APIController::class, "verificarDatos"]);
Router::rutasGETValidas("/user/api", [APIController::class, "getServicios"]);
Router::rutasGETValidas("/admin/all", [APIController::class, "allCitas"]);
Router::rutasPOSTValidas("/resumen", [APIController::class, "resumen"]);
Router::rutasPOSTValidas("/admin/find", [APIController::class, "find"]);
Router::rutasPOSTValidas("/admin/resumen", [APIController::class, "enviarResumen"]);
Router::rutasPOSTValidas("/admin/delete", [APIController::class, "eliminarCita"]);


Router::validarRuta();
?>

