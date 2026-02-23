<?php
require 'lib/Router.php';

$uri_dir = "/accesodatos";

// Crear instancia del Router
$router = new Router();

// Definir rutas simples
$router->add("${uri_dir}/index.php", 'MainController@index');
$router->add("${uri_dir}/api/empleados", 'EmpleadosController@apiEmpleados');
$router->add("${uri_dir}/api/departamentos", 'DepartamentoController@apiDepartamento');
$router->add("${uri_dir}/api/departamentos/{id}", 'DepartamentoController@apiDepartamento');
$router->add("${uri_dir}/api/skills", 'SkillsController@apiSkills');
$router->add("${uri_dir}/api/skills/{id}", 'SkillsController@apiSkills');




// Procesar la ruta actual
$router->dispatch($_SERVER['REQUEST_URI']);

?>
