<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title class="text-center">CRUD Estudiantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">

</head>

<body>
  <div class="container-fluid row">
    <h1 class="text-center p-3">Gestión de Estudiantes</h1>

      <form class="col-4 p-3" id="formRegistro" method="POST" enctype="multipart/form-data">
        <h3 id="formTitulo" class="text-center text-secondary ">Registrar Estudiante</h3>
          <input type="hidden" name="id" id="id">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre Completo</label>
          <input type="text" id="nombre" class="form-control" name="nombre">
        </div>
        <div class="mb-3">
          <label for="identificacion" class="form-label">identificacion</label>
          <input type="text" id="identificacion" class="form-control" name="identificacion" >
        </div>
        <div class="mb-3">
          <label for="telefono" class="form-label">Telefono</label>
          <input type="text" id="telefono" class="form-control" name="telefono">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">email</label>
          <input type="email" id="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
          <label for="foto" class="form-label">Foto</label>
          <input type="file" id="foto" class="form-control" name="foto">
        </div>
        <button type="submit" id="btnSubmit" class="btn btn-primary" name="btnregistrar" value="okay">Registrar</button>
        <button type="button" id="btnCancel" class="btn btn-secondary d-none">Cancelar</button>

      </form>
      <div class="col-8">
        <h3 class="text-center text-secondary">Lista de Estudiantes</h3>
        <div id="msg"></div>
        <table id="tablaEstudiantes" class="table table-striped mt-3">
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
        </table>
      </div>
  <div>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

  <!-- Botones de exportación -->
  <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  
  <script src="assets/js/main.js"></script>

</body>
</html>
