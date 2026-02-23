<?php


// models/Departamento.php

class Departamento {

    private $pdo; 
    
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;port=3307;dbname=empresa", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode(["estado" => "error", "mensaje" => "Error de conexion: " . $e->getMessage()]);
        }
    }

    public function getDepartamentos() {
        try{
            // Primero consulta 
            $sql = "SELECT id, nombre FROM departamento";
            // Query
            $stmt = $this->pdo->query($sql);

            // Array para guardar todos los departamentos
            $dep = [];
            // Bucle que recorre los departamentos
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $dep[] = ["id" => $fila["id"], "nombre" => $fila["nombre"]];
            }


            // Lo devuelve 
            return ["estado" => "exito", "departamentos" => $dep];
        }catch(PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en listar departamentos: " . $e->getMessage()];
        }
    }

    public function obtenerDepartamentoId($id){
        try{
            // Consulta
            $sql = "SELECT id, nombre FROM departamento WHERE id = $id";

            // Query
            $stmt = $this->pdo->query($sql);

            // Coger el resultado con fetch
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            // Validacion
            if(!$res){
                return ["estado" => "error", "mensaje" => "No se ha encontrado el departamento con el id: " . $id];
            }else {
                // Array para guardar el empleado
                $dep = [
                    "id" => $res["id"],
                    "nombre" => $res["nombre"],
                ];

                // Se devuelbe
                return ["estado" => "exito", "departamento" => $dep];
            }

        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error: " . $e->getMessage()];
        }
    }

    public function borrarDepartamentoId($id){
        try{

            // Borramos el departamento
            $sql = "DELETE FROM departamento
                    WHERE id = $id";

            $this->pdo->query($sql);

            return ["estado" => "exito", "mensaje" => "Borrado correctamente el departamento con el id " . $id];
        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en borrar: " . $e->getMessage()];
        }


    }

    public function crearDepartamentoData() {
        try {
            // Array para coger los valores que queremos añadir
            $data = json_decode(file_get_contents("php://input"), true);

            // Pasamos a veriables
            $departamento = $data["departamento"];

            // Insertamos
            $sql = "INSERT INTO departamento (nombre) 
            VALUES ('$departamento')";

            $stmt = $this->pdo->query($sql);
            
            return ["estado" => "exito", "mensaje" => "Creado  el departamento correctamente el departamento: ". $departamento];
        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error al crear el departamento: " . $e->getMessage()];
        }
    }


    public function actualizarDepartamento($id) {
        try {
            // Array para coger los valores que queremos añadir
            $data = json_decode(file_get_contents("php://input"), true);

            // Pasamos a veriables
            $departamento = $data["departamento"];

            // Actualizamos
            $sql = "UPDATE departamento 
                    SET nombre = '$departamento'
                    WHERE id = $id";

            $stmt = $this->pdo->query($sql);

            return ["estado" => "exito", "mensaje" => "Actualizado correctamente el departamento " . $departamento];
        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en actualizar: " . $e->getMessage()];
        }
    }
}
?>