<?php


// models/Skills.php

class Skills {

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

    public function getSkills() {
        try{
            // Primero consulta 
            $sql = "SELECT id, nombre FROM skill";
            // Query
            $stmt = $this->pdo->query($sql);

            // Array para guardar todos las skills
            $skill = [];
            // Bucle que recorre las skills
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $skill[] = ["id" => $fila["id"], "nombre" => $fila["nombre"]];
            }

            // Lo devuelve 
            return ["estado" => "exito", "skills" => $skill];
        }catch(PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en listar skills: " . $e->getMessage()];
        }
    }

    public function obtenerSkillId($id){
        try{
            // Consulta
            $sql = "SELECT id, nombre FROM skill WHERE id = $id";

            // Query
            $stmt = $this->pdo->query($sql);

            // Coger el resultado con fetch
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            // Validacion
            if(!$res){
                return null;
            }else {
                // Array para guardar el empleado
                $skill = [
                    "id" => $res["id"],
                    "nombre" => $res["nombre"],
                ];

                // Se devuelbe
                return ["estado" => "exito", "skill" => $skill];
            }

        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error: " . $e->getMessage()];
        }
    }

    public function borrarSkillId($id){
        try{

            // Borramos el departamento
            $sql = "DELETE FROM skill
                    WHERE id = $id";

            $this->pdo->query($sql);

            return ["estado" => "exito", "mensaje" => "Borrada correctamente la skill con el id " . $id];
        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en borrar: " . $e->getMessage()];
        }


    }

    public function crearSkill() {
        try {
            // Array para coger los valores que queremos añadir
            $data = json_decode(file_get_contents("php://input"), true);

            // Pasamos a veriables
            $nombre = $data["nombre"];

            // Insertamos
            $sql = "INSERT INTO skill (nombre) 
            VALUES ('$nombre')";

            $stmt = $this->pdo->query($sql);
            
            return ["estado" => "exito", "mensaje" => "Creada la skill correctamente ". $nombre];
        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en crear la skill: " . $e->getMessage()];
        }
    }

    public function actualizarSkill($id) {
        try {
            // Array para coger los valores que queremos añadir
            $data = json_decode(file_get_contents("php://input"), true);

            // Pasamos a veriables
            $nombre = $data["nombre"];

            // Actualizamos
            $sql = "UPDATE skill 
                    SET nombre = '$nombre'
                    WHERE id = $id";

            $stmt = $this->pdo->query($sql);

            return ["estado" => "exito", "mensaje" => "Actualizada correctamente la skill " . $nombre];
        } catch (PDOException $e) {
            return ["estado" => "error", "mensaje" => "Error en actualizar: " . $e->getMessage()];
        }
    }
}
?>