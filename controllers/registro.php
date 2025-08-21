<?php
if (!empty($_POST["btnregistrar"])) {
    if (!empty($_POST["nombre"]) && !empty($_POST["identificacion"]) && !empty($_POST["telefono"]) && !empty($_POST["email"]) && !empty($_FILES["foto"]["name"])) {

        $nombre = $_POST["nombre"];
        $identificacion = $_POST["identificacion"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $foto = $_FILES["foto"]["name"];

        move_uploaded_file($_FILES["foto"]["tmp_name"], "assets/img/estudiantes/" . $foto);
        echo "<pre>";
        print_r($_POST);
        print_r($_FILES);
        echo "</pre>";
        $sql = $conexion->query("INSERT INTO students (nombre, identificacion, telefono, email, foto) 
                                 VALUES ('$nombre', '$identificacion', '$telefono', '$email', '$foto')");

        if ($sql) {
            echo "<div class='alert alert-success'>Estudiante registrado correctamente</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al registrar: " . $conexion->error . "</div>";
        }

    } else {
        echo "<div class='alert alert-warning'>Debes completar todos los campos</div>";
    }
}
?>
