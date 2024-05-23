//  Create a new order
$("#btnAgregarNuevoAlumno").on("click", function () {
  window.location = "index.php?ruta=admisionExtraordinaria";
});

//  Visualizar alumno
$("#btnAgregarNuevoAlumno").on("click", function () {
  window.location = "index.php?ruta=admisionExtraordinaria";
});

//  Add Apoderado
$(".formNuevoApoderado").on("click", ".btnAgregarApoderado", function () {
  var nombres = $("#nombreApoderado").val();
  var apellidos = $("#apellidoApoderado").val();
  var correo = $("#correoApoderado").val();
  var celular = $("#celularApoderado").val();
  var tipoApoderado = $("#tipoApoderado").val();

  $(".nuevoApoderado").append(
    '<div class="row">' +
      "<!-- Nombres -->" +
      '<div class="col-lg-3">' +
      '<label for="nombreApoderado" class="col-form-label">Nombres</label>' +
      '<input type="text" class="form-control nombreApoderado" name="nombreApoderado" value="' +
      nombres +
      '" readonly>' +
      "</div>" +
      "<!-- Apellidos -->" +
      '<div class="col-lg-3 apellidos">' +
      '<label for="apellidosApoderado" class="col-form-label">Apellidos</label>' +
      '<input type="text" class="form-control apellidosApoderado" name="apellidosApoderado" value="' +
      apellidos +
      '" readonly>' +
      "</div>" +
      "<!-- Correo -->" +
      '<div class="col-lg-2 correo">' +
      '<label for="correoApoderado" class="col-form-label">Correo</label>' +
      '<input type="text" class="form-control correoApoderado" name="correoApoderado" value="' +
      correo +
      '" readonly>' +
      "</div>" +
      "<!-- Celular -->" +
      '<div class="col-lg-2 celular">' +
      '<label for="celularApoderado" class="col-form-label">Celular</label>' +
      '<input type="text" class="form-control celularApoderado" name="celularApoderado" value="' +
      celular +
      '" readonly>' +
      "</div>" +
      "<!-- Tipo Apoderado -->" +
      '<div class="col-lg-2 tipo">' +
      '<label for="tipoApoderado" class="col-form-label">Tipo</label>' +
      '<input type="text" class="form-control tipoApoderado" name="tipoApoderado" value="' +
      tipoApoderado +
      '" readonly>' +
      "</div>" +
      "</div>"
  );
  listarApoderados();
  document.getElementById("nombreApoderado").value = "";
  document.getElementById("apellidoApoderado").value = "";
  document.getElementById("correoApoderado").value = "";
  document.getElementById("celularApoderado").value = "";
  document.getElementById("tipoApoderado").value = "";
});

function listarApoderados() {
  var listaApoderados = [];
  var nombres = $(".nombreApoderado");
  var apellidos = $(".apellidosApoderado");
  var correos = $(".correoApoderado");
  var celular = $(".celularApoderado");
  var tipoApoderado = $(".tipoApoderado");

  for (var i = 0; i < nombres.length; i++) {
    listaApoderados.push({
      nombreApoderado: $(nombres[i]).val(),
      apellidoApoderado: $(apellidos[i]).val(),
      correoApoderado: $(correos[i]).val(),
      numeroApoderado: $(celular[i]).val(),
      tipoApoderado: $(tipoApoderado[i]).val(),
    });
  }

  $("#listaApoderados").val(JSON.stringify(listaApoderados));
}

//  Cerrar vista de nuevo y editar postulante
$(".dataTableAlumnos").on("click", ".btnEditarAlumno", function () {
  var codAlumno = $(this).attr("codAlumno");
  window.location = "index.php?ruta=editarAlumno&codAlumnoEditar=" + codAlumno;
});

//  Cerrar editar alumno
$(".cerrarEditarAlumno").on("click", function () {
  window.location = "index.php?ruta=listaAlumnos";
});

$(".dataTableAlumnos").on("click", ".btnVisualizarAlumno", function () {
  var codAlumno = $(this).attr("codAlumno");
  var data = new FormData();

  data.append("codAlumnoVisualizar", codAlumno);
  $.ajax({
    url: "ajax/alumnos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      $("#codeProduct").val(response["CodProduct"]);
      $("#descriptionProduct").val(response["DescriptionModel"]);
      $("#makerProduct").val(response["MakerFullName"]);
      $("#priceProduct").val(response["PriceProduct"]);
      $("#stateProduct").val(response["StateDescription"]);
      $("#clientProduct").val(response["NameClient"]);
      $("#nroOrden").val(response["OrderNumber"]);
      $("#nroComprobante").val(response["PayNumber"]);
      $("#dateOrder").val(response["DateOrder"]);
      $("#dateSend").val(response["DateEnd"]);
    },
  });


});

  //Desactivar Alumno
  $(".dataTableAlumnos").on("click", ".btnDesactivarAlumno", function () {
    var codAlumno = $(this).attr("codAlumno");

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡El alumno será desactivado!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            var estadoAlumno = 2;
            var data = new FormData();
            data.append("codAlumnoEstado", codAlumno);
            data.append("AlumnoEstado", estadoAlumno);
            
            $.ajax({
                url: "ajax/alumnos.ajax.php",
                method: "POST",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    if (response == "ok") {
                        Swal.fire(
                            'Desactivado',
                            'El alumno ha sido desactivado.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }
                }
            });
        }
    });
});

//Activar Alumno
$(".dataTableAlumnos").on("click", ".btnActivarAlumno", function () {
  var codAlumno = $(this).attr("codAlumno");

  Swal.fire({
      title: '¿Estás seguro?',
      text: "¡El alumno será activado!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, activar',
      cancelButtonText: 'Cancelar'
  }).then((result) => {
      if (result.isConfirmed) {
          var estadoAlumno = 1;
          var data = new FormData();
          data.append("codAlumnoEstado", codAlumno);
          data.append("AlumnoEstado", estadoAlumno);
          
          $.ajax({
              url: "ajax/alumnos.ajax.php",
              method: "POST",
              data: data,
              cache: false,
              contentType: false,
              processData: false,
              dataType: "json",
              success: function (response) {
                  if (response == "ok") {
                      Swal.fire(
                          'Activado',
                          'El alumno ha sido activado.',
                          'success'
                      ).then(() => {
                          location.reload();
                      });
                  }
              }
          });
      }
  });
});