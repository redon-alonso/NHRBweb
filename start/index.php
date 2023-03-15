<?php

require_once "../vendor/autoload.php";

// session_start();

/* Debería crear una clase para manejar la sesión */

/* Comprueba estado de la sesión */
/* sesión caduca pasados 30 minutos */
// if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
//   // last request was more than 30 minutes ago
//   App\Controllers\AuthController::logout();
// }
// $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

use App\Core\Request;
use App\Core\RouteCollection;
use App\Core\Dispatcher;

$request = new Request();
$routes = new RouteCollection();
$dispatcher = new Dispatcher($request, $routes);
