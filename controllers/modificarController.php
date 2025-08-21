<?php
include "../db/connection.php";

if (!empty($_POST["btnmodificar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $identificacion = $_POST["identificacion"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $foto = $_FILES["foto"];

    // Validar duplicados en email o identificacion (excepto el mismo estudiante)
    $check = $conexion->query("SELECT * FROM students 
                               WHERE (email='$email' OR identificacion='$identificacion') 
                               AND id!=$id");
    if ($check->num_rows > 0) {
        echo "<div class='alert alert-danger'>⚠️ Ya existe un estudiante con ese correo o identificación.</div>";
        exit;
    }
    // Construir el SQL dependiendo de si subieron foto nueva o no
    if ($foto["error"] == 0) {
        $rutaTemporal = $foto["tmp_name"];
        $rutaDestino = "../assets/img/estudiantes/" . $foto["name"];
        move_uploaded_file($rutaTemporal, $rutaDestino);

        $sql = "UPDATE students 
                SET nombre='$nombre', identificacion='$identificacion', telefono='$telefono', email='$email', foto='$foto[name]' 
                WHERE id=$id";

    } else {
        $sql = "UPDATE students 
                SET nombre='$nombre', identificacion='$identificacion', telefono='$telefono', email='$email' 
                WHERE id=$id";
    }
    // Ejecutar la consulta
    if ($conexion->query($sql) === TRUE) {
        header("Location: ../index.php?msg=updated");
    } else {
        echo "<div class='alert alert-danger'>Error al modificar el estudiante: " . $conexion->error . "</div>";
    }
} else {
    header("Location: ../index.php");
    exit;
}