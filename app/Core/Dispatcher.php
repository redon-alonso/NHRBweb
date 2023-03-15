<?php

namespace App\Core;

use App\Core\Interfaces\IRequest;
use App\Core\Interfaces\IRoutes;

class Dispatcher
{
  private IRequest $currentRequest;
  private IRoutes $routeCollection;

  private $routeList;

  public function __construct(IRequest $request, IRoutes $routeCollection)
  {
    $this->currentRequest = $request;
    $this->routeCollection = $routeCollection;

    $this->routeList = $this->routeCollection->getRoutes();

    $this->dispatch();
  }

  private function action($method, $route, $param = null)
  {
    /* Si la ruta es protegida solo se puede acceder estando logeado */
    if (
      isset($this->routeList[$method][$route]["protected"]) &&
      $this->routeList[$method][$route]["protected"] === true &&
      !isset($_SESSION["user_id"])
    ) {
      header("Location: /login");
      return;
    }

    $controllerClass = "App\\Controllers\\" . $this->routeList[$method][$route]["controller"];
    $controller =  new $controllerClass;
    $action = $this->routeList[$method][$route]["action"];

    /* Si llega petición POST obtiene el body */
    /* y lo pasa como primer parámetro despues resto */
    /* para peticiones PUT u otras deberia crear elfeif */
    if ($method == "POST") {
      $body = $this->currentRequest->getPostBody();
      $controller->$action($body, $param);
      /* sino pasa los parametros normalmente */
    } else $controller->$action($param);
  }

  private function dispatch()
  {
    $method = $this->currentRequest->getMethod();
    $currentRoute = $this->currentRequest->getRoute();
    $uri = $this->currentRequest->getUri();

    /* en caso de /:id y cosas así... tengo que manejar al final */

    /* Antes de empezar obtiene variables desde la uri */
    $uriArray = explode('?', $uri);
    if (isset($uriArray[1])) {
      $param["GET"] = $_GET;
      $uri = $uriArray[0];
    }

    /* Primero compureba si ruta que a visitar */
    /* está separada en un include */
    if (isset($this->routeList["includes"][$currentRoute])) {
      $jsonFile = $this->routeList["includes"][$currentRoute];
      /* Actualiza ruta relativa sustrayendo parte de la ruta */
      $uri = str_replace($currentRoute, "", $uri);
      $uri = ($uri === "") ? "/" : $uri;
      $currentRoute = "/";

      $this->routeList = $this->routeCollection->getRoutesFromFile($jsonFile);
    }

    /* Itera por el array para cotejar */
    $uriArray = array_filter(explode("/", $uri));
    foreach ($this->routeList[$method] as $route => $object) {

      /* la ruta es completa y no tiene varibales */
      if ($uri === $route) {
        $this->action($method, $route, isset($param) ? $param : null);

        return;
      }

      /* mejora performance */
      /* evita comprobar rutas no relacionadas */
      if (!str_contains($route, $currentRoute)) continue;

      $routeArray = array_filter(explode("/", $route));
      if (count($uriArray) === count($routeArray)) {
        for ($i = 1; $i <= count($routeArray); $i++) {

          /* mejora performance */
          /* Si no coincide evita entrar en cada uno */
          if ($routeArray[$i] !== $uriArray[$i]) break;

          if (isset($routeArray[$i + 1]) && str_contains($routeArray[$i + 1], ":")) {
            $paramName = substr($routeArray[$i + 1], 1);

            if (isset($param)) $param[$paramName] = $uriArray[$i + 1];
            else $param["$paramName"] = $uriArray[$i + 1];

            $this->action($method, $route, $param);

            return;
          }
        }
      }
    }

    header("Location: /");
    return;
  }
}
