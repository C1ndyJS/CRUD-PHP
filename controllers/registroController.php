<?php
if (!empty($_POST["btnregistrar"])) {
    if (!empty($_POST["nombre"]) && !empty($_POST["identificacion"]) && !empty($_POST["telefono"]) && !empty($_POST["email"]) && !empty($_FILES["foto"]["name"])) {

        $nombre = $_POST["nombre"];
        $identificacion = $_POST["identificacion"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $foto = $_FILES["foto"]["name"];
        
        $check = $conexion->query("SELECT * FROM students WHERE email='$email' OR identificacion='$identificacion'");
        if ($check->num_rows > 0) {
            echo "<div class='alert alert-danger'>⚠️ Ya existe un estudiante con ese correo o identificación.</div>";
        } else {
            move_uploaded_file($_FILES["foto"]["tmp_name"], "assets/img/estudiantes/" . $foto);
        
            $sql = $conexion->query("INSERT INTO students (nombre, identificacion, telefono, email, foto) 
                                    VALUES ('$nombre', '$identificacion', '$telefono', '$email', '$foto')");

            if ($sql) {
                echo "<div class='alert alert-success'>Estudiante registrado correctamente</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al registrar: " . $conexion->error . "</div>";
            }
        }
    } else {
        echo "<div class='alert alert-warning'>Debes completar todos los campos</div>";
    }
}
?>
