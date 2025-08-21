<?php
include "../db/connection.php";

if (!empty($_POST["btnmodificar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $identificacion = $_POST["identificacion"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $foto = $_FILES["foto"];

    // Validar y procesar la foto
    if ($foto["error"] == 0) {
        $nombreArchivo = $foto["name"];
        $rutaTemporal = $foto["tmp_name"];
        $rutaDestino = "../assets/img/estudiantes/" . $nombreArchivo;

        // Mover la foto a la carpeta de estudiantes
        move_uploaded_file($rutaTemporal, $rutaDestino);
    } else {
        // Si no se subió una nueva foto, mantener la foto actual
        $sql = $conexion->query("SELECT foto FROM students WHERE id=$id");
        $estudiante = $sql->fetch_assoc();
        $rutaDestino = "../assets/img/estudiantes/" . $estudiante["foto"];
    }

    // Actualizar los datos del estudiante en la base de datos
    $sql = "UPDATE students SET nombre='$nombre', identificacion='$identificacion', telefono='$telefono', email='$email', foto='$nombreArchivo' WHERE id=$id";
    if ($conexion->query($sql) === TRUE) {
        header("Location: ../index.php");
    } else {
        echo "<div class='alert alert-danger'>Error al modificar el estudiante: " . $conexion->error . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>⚠️ Debes completar todos los campos.</div>";
}