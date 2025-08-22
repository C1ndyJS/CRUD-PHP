let editMode = false; // false = registrar, true = editar
let tabla; // hacemos global la referencia a DataTable

//Read
$(document).ready(function () {
  tabla = $('#tablaEstudiantes').DataTable({
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
    let nombre = $('#nombre').val().trim();
    let identificacion = $('#identificacion').val().trim();
    let email = $('#email').val().trim();
    let telefono = $('#telefono').val().trim();
    
    // Validaciones
    if (!nombre || !identificacion || !email || !telefono) {
      $('#msg').html(`<div class="alert alert-danger">Los siguientes campos son obligatorios: Nombre Completo, Identificacion, email y telefono</div>`);
      return;
    }

    if (!/^[a-zA-Z\s]+$/.test(nombre)) {
      $('#msg').html(`<div class="alert alert-danger">El nombre solo debe contener letras
      </div>`);
      return;
    }

    if (!/^\d{6,10}$/.test(identificacion)) {
      $('#msg').html(`<div class="alert alert-danger">La identificación debe tener entre 6 y 10 dígitos</div>`);
      return;
    }

    if( !/^\d{7,10}$/.test(telefono)) {
      $('#msg').html(`<div class="alert alert-danger">El teléfono debe tener entre 7 y 10 dígitos</div>`);
        return;
    }
    
    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        $('#msg').html(`<div class="alert alert-danger">⚠️ El correo electrónico no es válido.</div>`);
        return;
    }

    let formData = new FormData(this);
    let action = editMode ? "update" : "create";
    
    $.ajax({
      url: 'controllers/studentControllers.php?action=' + action,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (resp) {
        $('#msg').html(`<div class="alert alert-success">${resp}</div>`);
        $('#formRegistro')[0].reset();
        $('#tablaEstudiantes').DataTable().ajax.reload(null, false); // 👈 recarga sin perder paginación
        
      },
      error: function () {
        $('#msg').html(`<div class="alert alert-danger">❌ Error al registrar</div>`);
      }
    });
});

$('#btnCancel').on('click', function () {
  $('#formRegistro')[0].reset();   // limpiar form
  $('#id').val('');
  $('#formTitulo').text("Registrar Estudiante");
  $('#btnSubmit').text("Registrar").removeClass("btn-success").addClass("btn-primary");
  $(this).addClass("d-none"); // ocultar cancelar
  editMode = false;
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
  $.getJSON("controllers/studentControllers.php?action=get&id=" + id, function (data) {
    $('#id').val(data.id);
    $('#nombre').val(data.nombre);
    $('#identificacion').val(data.identificacion);
    $('#telefono').val(data.telefono);
    $('#email').val(data.email);
    $('#formTitulo').text("Actualizar Estudiante");
    $('#btnSubmit').text("Registrar").removeClass("btn-success").addClass("btn-primary");
    $('#btnCancel').removeClass("d-none");

  });
}

