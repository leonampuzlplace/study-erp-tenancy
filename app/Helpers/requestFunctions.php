<?php
// Como configurar arquivo helper? 
// Adicione o caminho em composer.json na seção autoload, files. 
// Depois rodar comando composer dump-autoload -o

if (!function_exists('getRouteParameter')) {
  function getRouteParameter($route)
  {
    $parameters = $route->parameters ?? [];
    return array_shift($parameters);
  }
}