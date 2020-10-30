<?php

include_once 'src/parameters.php';

function render(string $controller, string $action): void
{
  $c = new $controller();
  $data = $c->$action();
  $action = $data[0];
  $path = $data[1];
  $data = isset($data[2]) ? $data[2] : null;

  $c->$action($path, $data);
  exit();
}

if (isset(parameters()['r'])) {
  $route = parameters()['r'];
  if ('default') {
    list($controller, $action) = ['home', 'error'];
  }
  if (strpos($route, '/') == false) {
    list($controller, $action) = [$route, 'index'];
  } else {
    list($controller, $action) = explode('/', $route);
  }

  $controller = ucfirst($controller) . 'Controller';

  if (isset($_SESSION['userId']) || new $controller() instanceof LoginController || new $controller() instanceof RegistrationController) {
    render($controller, $action);
  } else {
    header('Location: ?r=login');
  }
} elseif (!isset($_SESSION['userId'])) {
  header('Location: ?r=login');
} else {
  header('Location: ?r=home');
}
