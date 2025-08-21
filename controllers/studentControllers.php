<?php
include "../db/connection.php";

$action = $_GET['action'] ?? '';

switch ($action) {
    //  CREAR ESTUDIANTE
    case 'create':
        $nombre = $_POST['nombre'] ?? '';
        $identificacion = $_POST['identificacion'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $email = $_POST['email'] ?? '';

        // Validar duplicados
        $check = $conexion->query("SELECT * FROM students WHERE email='$email' OR identificacion='$identificacion'");
        if ($check->num_rows > 0) {
            echo "⚠️ Ya existe un estudiante con ese correo o identificación.";
            exit;
        }

        // Procesar foto
        $foto = "";
        if (!empty($_FILES['foto']['name'])) {
            $foto = time() . "_" . basename($_FILES['foto']['name']);
            $rutaDestino = "../assets/img/estudiantes/" . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino);
        }

        $sql = "INSERT INTO students (nombre, identificacion, telefono, email, foto) 
                VALUES ('$nombre', '$identificacion', '$telefono', '$email', '$foto')";
        
        if ($conexion->query($sql)) {
            echo "✅ Estudiante registrado correctamente.";
        } else {
            echo "❌ Error al registrar: " . $conexion->error;
        }
        break;
    // LISTAR ESTUDIANTES (para DataTables)
    case 'read':
        $result = $conexion->query("SELECT * FROM students");
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode(["data" => $rows]);
        break;
        
    case 'update':
        $id = $_POST['id'] ?? 0;
        $nombre = $_POST['nombre'] ?? '';
        $identificacion = $_POST['identificacion'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $email = $_POST['email'] ?? '';

        // Verificar duplicados (excepto el mismo ID)
        $check = $conexion->query("SELECT * FROM students WHERE (email='$email' OR identificacion='$identificacion') AND id!=$id");
        if ($check->num_rows > 0) {
            echo "⚠️ Ya existe otro estudiante con ese correo o identificación.";
            exit;
        }

        // Procesar foto
        $fotoSql = "";
        if (!empty($_FILES['foto']['name'])) {
            $foto = time() . "_" . basename($_FILES['foto']['name']);
            $rutaDestino = "../assets/img/estudiantes/" . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino);
            $fotoSql = ", foto='$foto'";
        }

        $sql = "UPDATE students SET nombre='$nombre', identificacion='$identificacion', telefono='$telefono', email='$email' $fotoSql WHERE id=$id";
        
        if ($conexion->query($sql)) {
            echo "✅ Estudiante actualizado.";
        } else {
            echo "❌ Error al actualizar: " . $conexion->error;
        }
        break;

    // ELIMINAR ESTUDIANTE
    case 'delete':
        $id = $_POST['id'] ?? 0;

        // Borrar foto asociada si existe
        $sql = $conexion->query("SELECT foto FROM students WHERE id=$id");
        if ($sql && $sql->num_rows > 0) {
            $est = $sql->fetch_assoc();
            if (!empty($est['foto']) && file_exists("../assets/img/estudiantes/" . $est['foto'])) {
                unlink("../assets/img/estudiantes/" . $est['foto']);
            }
        }

        $delete = $conexion->query("DELETE FROM students WHERE id=$id");
        if ($delete) {
            echo "🗑️ Estudiante eliminado correctamente.";
        } else {
            echo "❌ Error al eliminar: " . $conexion->error;
        }
        break;
    
    case 'get':
        $id = $_GET['id'] ?? 0;
        $res = $conexion->query("SELECT * FROM students WHERE id=$id");
        echo json_encode($res->fetch_assoc());
        break;

    default:
        echo "Acción no válida.";
}
?>
