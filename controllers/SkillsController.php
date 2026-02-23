<?php

require 'models/Skills.php';

class SkillsController
{
    public function apiSkills()
    {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type");

        $method = $_SERVER['REQUEST_METHOD'];

        $request_uri = $_SERVER['REQUEST_URI'];
        //$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));



        // Ejemplo de rutas: /api/users o /api/users/1
        if (preg_match('#/api/skills(?:/([\w-]+))?/?(?:\?.*)?$#', $request_uri, $matches)) {

            //if (preg_match('#/api/usuarios(?:/([\w-]+))?/?$#', $path, $matches)) {
            $id = null;
            if (isset($matches[1])) {
                $id = $matches[1];
            }

            switch ($method) {
                case 'GET':
                    if (isset($id))
                        self::obtenerSkillId($id);
                    elseif (!isset($id))
                        self::getSkills();
                    break;
                case 'POST':
                    self::crearSkill();
                    break;
                case 'PUT':
                    if (isset($id))
                        self::actualizarSkill($id);
                    break;
                case 'DELETE':
                    if (isset($id))
                        self::borrarSkillId($id);
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

    public function crearSkill()
    {
        $empModel = new Skills();
        $result = $empModel->crearSkill();
        echo json_encode($result);
    }

    public function getSkills()
    {
        $empModel = new Skills();
        $result = $empModel->getSkills();
        echo json_encode($result);
    }

    public function obtenerSkillId($id)
    {
        $empModel = new Skills();
        $result = $empModel->obtenerSkillId($id);
        echo json_encode($result);
    }

    public function actualizarSkill($id)
    {
        $empModel = new Skills();
        $result = $empModel->actualizarSkill($id);
        echo json_encode($result);
    }

    public function borrarSkillId($id)
    {
        $empModel = new Skills();
        $result = $empModel->borrarSkillId($id);
        echo json_encode($result);
    }



}

?>