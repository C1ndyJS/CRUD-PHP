<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title class="text-center">CRUD Estudiantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
<div class="container-fluid row">
  <h1 class="text-center p-3">Gestión de Estudiantes</h1>

    <form class="col-4 p-3" method="POST" enctype="multipart/form-data">
      <h3 class="text-center text-secondary ">Registrar Estudiante</h3>
      <?php
      include "db/connection.php";
      include "controllers/registroController.php";
      ?>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Nombre Completo</label>
        <input type="text" class="form-control" name="nombre">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">identificacion</label>
        <input type="text" class="form-control" name="identificacion">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Telefono</label>
        <input type="text" class="form-control" name="telefono">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">email</label>
        <input type="email" class="form-control" name="email">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Foto</label>
        <input type="file" class="form-control" name="foto">
      </div>
      <button type="submit" class="btn btn-primary" name="btnregistrar" value="okay">Registrar</button>
    </form>

    <div class="col-8">
      <h3 class="text-center text-secondary">Lista de Estudiantes</h3>
        <table class="table table-striped mt-3">
          <thead class="bg-info">
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">identificacion</th>
              <th scope="col">Teléfono</th>
              <th scope="col">email</th>
              <th scope="col">Foto</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Juan Pérez</td>
              <td>123456</td>
              <td>555-1234</td>
              <td>juan@example.com</td>
              <td><img src="assets/img/estudiantes/juan.jpg" alt="Foto de Juan" class="img-fluid" width="100"></td>
              <td>
                <button class="btn btn-warning btn-sm">Editar</button>
                <button class="btn btn-danger btn-sm">Eliminar</button>
              </td>
              
            </tr>
          </tbody>
          <?php
          // Aquí se agregarán los estudiantes
          include "db/connection.php";

          $sql = "SELECT * FROM students  ";
          $resultado = $conexion->query($sql);

          if ($resultado->num_rows > 0) {
              while ($fila = $resultado->fetch_assoc()) { 
                  echo "<tr>";
                  echo "<td>" . $fila["nombre"] . "</td>";
                  echo "<td>" . $fila["identificacion"] . "</td>";
                  echo "<td>" . $fila["telefono"] . "</td>";
                  echo "<td>" . $fila["email"] . "</td>";
                  echo "<td><img src='assets/img/estudiantes/" . $fila["foto"] . "' alt='Foto de " . $fila["nombre"] . "' class='img-fluid' width='100'>Editar</td>";                
                  echo "</ul>";
                  echo "</td>";
                  echo "<td>";
                  echo "<a href='controllers/modificar.php?id=" . $fila["id"] . "' class='btn btn-warning btn-sm me-1 '><i class='fa-solid fa-pen-to-square'></i>Editar</a>";
                  echo "<a on-click=\"return controllers/eliminar.php?id=" . $fila["id"] . "\" class='btn btn-small btn-danger'><i class='fa-solid fa-trash'></i>Eliminar</a>";
                  echo "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='7' class='text-center'>No hay estudiantes registrados</td></tr>";
          }

          $conexion->close();
          ?>
        </table>
    
  </div>

<!-- <script src="assets/js/jquery.min.js"></script>
<script src="assets/js/datatables.min.js"></script>
<script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/buttons.html5.min.js"></script>
<script src="assets/js/jszip.min.js"></script>
<script src="assets/js/main.js"></script> -->
</body>
</html>
