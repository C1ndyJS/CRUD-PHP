<?php
    if(!empty($_GET["id"])){
        include "../db/connection.php";

        $id = $_GET["id"];
        $sql = "DELETE FROM students WHERE id=$id";

        if ($conexion->query($sql) === TRUE) {
            header("Location: ../index.php?msg=deleted");
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el estudiante: " . $conexion->error . "</div>";
        }
    }

?>