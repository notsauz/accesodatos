<?php

require 'models/Empleados.php';

class EmpleadosController {
    public function apiEmpleados() {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type");

        $method = $_SERVER['REQUEST_METHOD'];

        $request_uri = $_SERVER['REQUEST_URI'];
        //$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
        
        

        // Ejemplo de rutas: /api/users o /api/users/1
        if (preg_match('#/api/empleados(?:/([\w-]+))?/?(?:\?.*)?$#', $request_uri, $matches)) {

        //if (preg_match('#/api/usuarios(?:/([\w-]+))?/?$#', $path, $matches)) {
            $id = null;
            if (isset($matches[1])) {
                $id = $matches[1];
            }

            switch ($method) {
                case 'GET':
                    self::getEmpleados();
                    break;
                case 'POST':
                    if (isset($id))
                        self::obtenerEmpleado($id);
                    elseif (!isset($id))
                        self::crearEmpleado();
                    break;
                case 'PUT':
                    if (isset($id))
                        self::actualizarEmpleado($id);
                    break;
                case 'DELETE':
                    if (isset($id))
                        self::borrarEmpleado($id);
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
    
    public function getEmpleados(){
        $empModel = new Empleado();
        $result = $empModel->getEmpleados();   
        echo json_encode($result);      
    }


    public function obtenerEmpleado($id){
        $empModel = new Empleado();
        $result = $empModel->getEmpleadosId($id);   
        echo json_encode($result);      
    }

    public function borrarEmpleado($id){
        $empModel = new Empleado();
        $result = $empModel->borrarEmpleadoId($id);   
        echo json_encode($result);
    }


    public function crearEmpleado(){
        $empModel = new Empleado();
        $result = $empModel->crearEmpleadoData();
        echo json_encode($result);
    }

    public function actualizarEmpleado($id){
        $empModel = new Empleado();
        $result = $empModel->actualizarEmpleadoData($id);
        echo json_encode($result);
    }

}

?>