<?php
include "../db/connection.php";

if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $conexion->query("SELECT * FROM students WHERE id=$id");


    if ($sql->num_rows > 0) {
        $estudiante = $sql->fetch_assoc();
    } else {
        die("Estudiante no encontrado");
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Actualizar</title>
</head>
<body>
    <form class="col-4 p-3 m-auto" method="POST" enctype="multipart/form-data">
      <h4 class="text-center text-secondary ">Actualizar Informacion del Estudiante</h4>
      <input type="text" class="form-control" name="id" value="<?= $_GET['id'] ?>" hidden>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" name="nombre" value="<?= $estudiante['nombre'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">identificacion</label>
            <input type="text" class="form-control" name="identificacion" value="<?= $estudiante['identificacion'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Telefono</label>
            <input type="text" class="form-control" name="telefono" value="<?= $estudiante['telefono'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">email</label>
            <input type="email" class="form-control" name="email" value="<?= $estudiante['email'] ?>">
        </div>
        
        <div class="mb-3">
        <label class="form-label">Foto</label><br>
        <img src="../assets/img/estudiantes/<?= $estudiante['foto'] ?>" 
             alt="Foto actual" width="100" class="mb-2"><br>
        <input type="file" class="form-control" name="foto">
      </div>
        <!-- Para saber a quién actualizar -->
      <input type="hidden" name="id" value="<?= $id ?>">

      <button type="submit" class="btn btn-primary" name="btnmodificar" value="okay">Actualizar</button>
    </form>
</body>
</html>