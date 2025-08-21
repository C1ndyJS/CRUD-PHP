//Read
$(document).ready(function () {
  let tabla = $('#tablaEstudiantes').DataTable({
    ajax: "controllers/studentControllers.php?action=read",
    columns: [
      { data: "nombre" },
      { data: "identificacion" },
      { data: "telefono" },
      { data: "email" },
      {
        data: "foto",
        render: function (data) {
          return data ? `<img src="assets/img/estudiantes/${data}" width="50">` : '';
        }
      },
      {
        data: "id",
        render: function (id) {
          return `
            <button class="btn btn-warning btn-sm" onclick="editar(${id})">Editar</button>
            <button class="btn btn-danger btn-sm" onclick="eliminar(${id})">Eliminar</button>
          `;
        }
      }
    ],
    dom: 'Bfrtip',
    buttons: ['excel']
  });
});

//Create
$('#formRegistro').on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
      url: 'controllers/studentControllers.php?action=create',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (resp) {
        $('#msg').html(`<div class="alert alert-success">${resp}</div>`);
        $('#formRegistro')[0].reset();
        tabla.ajax.reload();
      },
      error: function () {
        $('#msg').html(`<div class="alert alert-danger">❌ Error al registrar</div>`);
      }
    });
});

function eliminar(id) {
  if (confirm("¿Seguro de eliminar este estudiante?")) {
    $.post("controllers/studentControllers.php?action=delete", { id: id }, function (resp) {
        alert(resp);
        $('#msg').html(`<div class="alert alert-info">${resp}</div>`);
        $('#tablaEstudiantes').DataTable().ajax.reload();
    });
  }
}

// Editar estudiante (abrir modal)
function editar(id) {
  $.get("controllers/studentControllers.php?action=get&id=" + id, function (data) {
      let est = JSON.parse(data);

      // Ejemplo simple: llenar el form de registro con datos del estudiante
      $('#nombre').val(est.nombre);
      $('#identificacion').val(est.identificacion);
      $('#telefono').val(est.telefono);
      $('#email').val(est.email);

      // Guardar el id oculto
      if (!$('#formRegistro input[name=id]').length) {
        $('#formRegistro').append('<input type="hidden" name="id" id="id">');
      }
      $('#id').val(est.id);

      // Cambiar acción del form
      $('#formRegistro').off('submit').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
          url: 'controllers/studentControllers.php?action=update',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (resp) {
            $('#msg').html(`<div class="alert alert-success">${resp}</div>`);
            $('#formRegistro')[0].reset();
            $('#id').remove(); // quitar hidden
            $('#tablaEstudiantes').DataTable().ajax.reload();
          }
        });
      });
  });
}

