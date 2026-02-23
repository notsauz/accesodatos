<?php

require 'models/Departamento.php';

class DepartamentoController
{
    public function apiDepartamento()
    {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type");

        $method = $_SERVER['REQUEST_METHOD'];

        $request_uri = $_SERVER['REQUEST_URI'];
        //$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));



        // Ejemplo de rutas: /api/users o /api/users/1
        if (preg_match('#/api/departamentos(?:/([\w-]+))?/?(?:\?.*)?$#', $request_uri, $matches)) {

            //if (preg_match('#/api/usuarios(?:/([\w-]+))?/?$#', $path, $matches)) {
            $id = null;
            if (isset($matches[1])) {
                $id = $matches[1];
            }

            switch ($method) {
                case 'GET':

                    if (isset($id))
                        self::obtenerDepartamentoId($id);
                    elseif (!isset($id))
                        self::getDepartamentos();
                    break;
                case 'POST':
                    self::crearDepartamento();
                    break;
                case 'PUT':
                    if (isset($id))
                        self::actualizarDepartamento($id);
                    break;
                case 'DELETE':
                    if (isset($id))
                        self::borrarDepartamentoId($id);
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["error" => "Método no permitido"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Ruta no encontrada"]);
        }

    }

    public function crearDepartamento()
    {
        $empModel = new Departamento();
        $result = $empModel->crearDepartamentoData();
        echo json_encode($result);
    }

    public function getDepartamentos()
    {
        $empModel = new Departamento();
        $result = $empModel->getDepartamentos();
        echo json_encode($result);
    }

    public function obtenerDepartamentoId($id)
    {
        $empModel = new Departamento();
        $result = $empModel->obtenerDepartamentoId($id);
        echo json_encode($result);
    }

    public function actualizarDepartamento($id)
    {
        $empModel = new Departamento();
        $result = $empModel->actualizarDepartamento($id);
        echo json_encode($result);
    }

    public function borrarDepartamentoId($id)
    {
        $empModel = new Departamento();
        $result = $empModel->borrarDepartamentoId($id);
        echo json_encode($result);
    }



}

?>