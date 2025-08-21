<?php
class StudentModel {
    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    public function getAll() {
        $sql = "SELECT e.*, GROUP_CONCAT(c.nombre SEPARATOR ', ') as cursos 
                FROM estudiantes e 
                LEFT JOIN estudiante_curso ec ON e.id = ec.estudiante_id 
                LEFT JOIN cursos c ON ec.curso_id = c.id 
                GROUP BY e.id";
        $result = $this->conexion->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function create($nombre, $identificacion, $telefono, $email, $foto, $cursos) {
        $stmt = $this->conexion->prepare("INSERT INTO estudiantes(nombre, identificacion, telefono, email, foto) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $identificacion, $telefono, $email, $foto);
        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            foreach ($cursos as $curso) {
                $this->conexion->query("INSERT INTO estudiante_curso (estudiante_id, curso_id) VALUES ($id, $curso)");
            }
            return true;
        }
        return false;
    }

    public function update($id, $nombre, $identificacion, $telefono, $email, $foto, $cursos) {
        $stmt = $this->conexion->prepare("UPDATE estudiantes SET nombre=?, identificacion=?, telefono=?, email=?, foto=? WHERE id=?");
        $stmt->bind_param("sssssi", $nombre, $identificacion, $telefono, $email, $foto, $id);
        if ($stmt->execute()) {
            $this->conexion->query("DELETE FROM estudiante_curso WHERE estudiante_id=$id");
            foreach ($cursos as $curso) {
                $this->conexion->query("INSERT INTO estudiante_curso (estudiante_id, curso_id) VALUES ($id, $curso)");
            }
            return true;
        }
        return false;
    }

    public function delete($id) {
        return $this->conexion->query("DELETE FROM estudiantes WHERE id=$id");
    }
}
?>
