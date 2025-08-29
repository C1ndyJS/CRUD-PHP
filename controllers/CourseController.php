<?php
require_once("../db/connection.php");

class Course {
    private $db;
    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function read() {
        $result = $this->db->query("SELECT * FROM courses");
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode(["data" => $data]);
    }

    public function create($nombre, $descripcion, $codigo) {
        $stmt = $this->db->prepare("INSERT INTO courses (nombre, descripcion, codigo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $descripcion, $codigo);
        if ($stmt->execute()) {
            echo "✅ Curso registrado correctamente";
        } else {
            echo "❌ Error: " . $stmt->error;
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "🗑️ Curso eliminado";
        } else {
            echo "❌ Error: " . $stmt->error;
        }
    }
}

$course = new Course($conexion);

$action = $_GET['action'] ?? '';
switch ($action) {
    case 'read':
        $course->read();
        break;
    case 'create':
        $course->create($_POST['nombre'], $_POST['descripcion'], $_POST['codigo']);
        break;
    case 'delete':
        $course->delete($_POST['id']);
        break;
}
