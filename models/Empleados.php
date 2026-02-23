<?php


// models/Empleados.php

class Empleado {

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

    public function getEmpleados() {
        try{
            // Primero consulta 
            $sql = "SELECT id, nombre, apellido, edad FROM empleado";
            // Query
            $stmt = $this->pdo->query($sql);

            // Array para guardar todos los empleados
            $emp = [];
            // Bucle que recorre los empledos
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $emp[] = ["id" => $fila["id"], "nombre" => $fila["nombre"], "apellido" => $fila["apellido"], "edad" => $fila["edad"]];
            }


            // Lo devuelve 
            return ["estado" => "exito", "empleados" => $emp];
        }catch(PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en listar empleados: " . $e->getMessage()];
        }
    }

    public function getEmpleadosId($id){
        try{
            // Consulta para todo menos skills
            $sql = "SELECT e.id, e.nombre, e.apellido, e.edad,e.fecha_alt, e.activo, d.nombre AS departamento, r.nombre AS responsable
            FROM empleado e
            JOIN departamento d ON d.id = e.id_departamento
            LEFT JOIN empleado r ON r.id = e.id_responsable
            WHERE e.id = $id";

            // Query
            $stmt = $this->pdo->query($sql);

            // Coger el resultado con fetch
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            // Validacion
            if(!$res){
                return ["estado" => "error", "mensaje" => "No se ha encontrado el empleado con el id: " . $id];
            }else {
                // Array para guardar el empleado
                $emp = [
                    "id" => $res["id"],
                    "nombre" => $res["nombre"],
                    "apellido" => $res["apellido"],
                    "edad" => $res["edad"],
                    "fecha_alt" => $res["fecha_alt"],
                    "activo" => $res["activo"],
                    "departamento" => $res["departamento"],
                    "responsable" => $res["responsable"]
                ];

                // Consulta para las skills
                $sql = "SELECT s.nombre as skill
                FROM empleado_skill es, skill s
                WHERE es.id_skill = s.id
                AND es.id_empleado = $id";

                // Esto no se porque tiene que ser prepare
                $stmt = $this->pdo->query($sql);

                // Se crea el array
                $skills = [];

                // Se recorren las skills y se añaden al array
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $skills[] = $fila["skill"];
                }

                $emp["skills"] = $skills;

                // Se devuelbe
                return ["estado" => "exito", "empleado" => $emp];
            }

        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error: " . $e->getMessage()];
        }
    }

    public function borrarEmpleadoId($id){
        try{
            // Primero quitamos los empleados responsables
            $sql = "UPDATE empleado 
                    SET id_responsable = NULL 
                    WHERE id_responsable = $id";

            $this->pdo->query($sql);

            // Borramos sus skills en empleado_skill
            $sql = "DELETE FROM empleado_skill 
                    WHERE id_empleado = $id";

            $this->pdo->query($sql);

            // Borramos el empleado
            $sql = "DELETE FROM empleado
                    WHERE id = $id";

            $this->pdo->query($sql);

            return ["estado" => "exito", "mensaje" => "Borrado correctamente"];
        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en borrar: " . $e->getMessage()];
        }


    }

    public function crearEmpleadoData() {
        try {
            // Array para coger los valores que queremos añadir
            $data = json_decode(file_get_contents("php://input"), true);

            // Pasamos a veriables
            $nombre = $data["nombre"];
            $apellido = $data["apellido"];
            $edad = $data["edad"];
            $fecha_alt = $data["fecha_alt"];
            $activo = $data["activo"];
            $id_departamento = $data["id_departamento"];
            $id_responsable = $data["id_responsable"];

            // Insertamos
            $sql = "INSERT INTO empleado (nombre, apellido, edad, fecha_alt, activo, id_departamento, id_responsable) 
            VALUES ('$nombre', '$apellido', '$edad', '$fecha_alt', '$activo', '$id_departamento', '$id_responsable')";

            $stmt = $this->pdo->query($sql);
            
            return ["estado" => "exito", "mensaje" => "Creado correctamente"];
        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en crear el empleado: " . $e->getMessage()];
        }
    }

    public function actualizarEmpleadoData($id) {
        try {
            // Array para coger los valores que queremos añadir
            $data = json_decode(file_get_contents("php://input"), true);

            // Pasamos a veriables
            $nombre = $data["nombre"];
            $apellido = $data["apellido"];
            $edad = $data["edad"];
            $fecha_alt = $data["fecha_alt"];
            $activo = $data["activo"];
            $id_departamento = $data["id_departamento"];
            $id_responsable = $data["id_responsable"];

            // Actualizamos
            $sql = "UPDATE empleado 
                    SET nombre = '$nombre', 
                        apellido = '$apellido', 
                        edad = '$edad', 
                        fecha_alt = '$fecha_alt', 
                        activo = '$activo', 
                        id_departamento = '$id_departamento', 
                        id_responsable = '$id_responsable'
                    WHERE id = $id";

            $stmt = $this->pdo->query($sql);

            return ["estado" => "exito", "mensaje" => "Actualizado correctamente"];
        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en actualizar: " . $e->getMessage()];
        }
    }
}
?>