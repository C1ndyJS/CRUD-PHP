<?php
require_once("../db/connection.php");
require_once("../models/studentModel.php");

$model = new StudentModel($conexion);
$action = $_GET['action'] ?? '';

switch($action) {
    case 'read':
        echo json_encode(['data' => $model->getAll()]);
        break;

    case 'create':
        $nombre = $_POST['nombre'];
        $identificacion = $_POST['identificacion'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $cursos = $_POST['cursos'] ?? [];

        // Subida de imagen
        $foto = "";
        if (!empty($_FILES['foto']['name'])) {
            $targetDir = "../uploads/";
            $fileName = time() . "_" . basename($_FILES["foto"]["name"]);
            $targetFile = $targetDir . $fileName;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile);
            $foto = $fileName;
        }

        echo $model->create($nombre, $identificacion, $telefono, $email, $foto, $cursos) ? "ok" : "error";
        break;

    case 'update':
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $identificacion = $_POST['identificacion'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $cursos = $_POST['cursos'] ?? [];

        $foto = $_POST['fotoActual']; // foto anterior
        if (!empty($_FILES['foto']['name'])) {
            $targetDir = "../uploads/";
            $fileName = time() . "_" . basename($_FILES["foto"]["name"]);
            $targetFile = $targetDir . $fileName;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile);
            $foto = $fileName;
        }

        echo $model->update($id, $nombre, $identificacion, $telefono, $email, $foto, $cursos) ? "ok" : "error";
        break;

    case 'delete':
        $id = $_POST['id'];
        echo $model->delete($id) ? "ok" : "error";
        break;
}
?>
