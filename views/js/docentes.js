$(document).ready(function () {
  // Agregar el evento click al botón "Asignar Curso"
  $("#btnAsignarCurso").on("click", function () {
    // Obtener los valores seleccionados
    var gradoSeleccionado = $("#selectGrado").find(":selected").text();
    var cursoSeleccionado = $("#selectCurso").find(":selected").text();
    var idPersonal = $("#codPersonal").val();

    var data = new FormData();
    data.append("gradoSeleccionado", gradoSeleccionado);
    data.append("cursoSeleccionado", cursoSeleccionado);
    data.append("idPersonal", idPersonal);
    
    $.ajax({
        url: "ajax/docentes.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {

          if (response == "ok") {
            Swal.fire({
              title: "¡Éxito!",
              text: "Curso asignado correctamente",
              icon: "success",
              confirmButtonText: "Aceptar",
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
            });
          } else {
            Swal.fire({
              title: "¡Error!",
              text: "No se pudo asignar el curso",
              icon: "error",
              confirmButtonText: "Aceptar",
            });
          }

        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText); // procendecia de error
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
    });
  });
});

$(".dataTableDocentes").on("click", ".btnVisualizarDocente", function () {
  // Obtener los valores seleccionados
  var tipoDocente = $(this).attr("codTipoPersonal");
  var codPersonal = $(this).attr("codPersonal");

  // Mostrar los valores en una alerta de SweetAlert
  var data = new FormData();
  data.append("tipoDocente", tipoDocente);
  $.ajax({
    url: "ajax/docentes.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      console.log(response);
      var opciones = "";
      //listaGrados = JSON.parse(response);
      response.forEach((grado) => {
        opciones +=
          '<option value="' +
          grado.idGrado +
          '" data-tipo-docente="' +
          tipoDocente +
          '">' +
          grado.descripcionGrado +
          "</option>";
      });

      selectDiv = document.getElementById("selectGrado");
      select =
        '<label for="selectGrado" class="form-label">Selecciona el Grado:</label>' +
        '<select class="form-select selectGrado" id="selectGrado" data-placeholder="Elegir grado">' +
        '<option value="">Selecciona un grado...</option>' +
        opciones +
        "</select>";
      selectDiv.innerHTML = select;
      $("#codPersonal").val(codPersonal);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // procendecia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

$(".selectGrado").on("change", ".selectGrado", function () {
  // Obtener los valores seleccionados

  var idGrado = $(this).val();
  var tipoDocente = $(this).find(":selected").data("tipoDocente");
  var idPersonal = $("#codPersonal").val();

  // Limpiar el selectCurso
  var selectDiv = document.getElementById("selectCurso");
  selectDiv.innerHTML = "";

  if (tipoDocente == "1" || tipoDocente == "2") {
    console.log("Docente de Primaria y Secundaria");
  } else {
    // Mostrar los valores en una alerta de SweetAlert
    var data = new FormData();
    data.append("todosloscursos", true);
    $.ajax({
      url: "ajax/docentes.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        var opciones = "";
        var select = "";

        response.forEach((curso) => {
          if (idGrado == curso.idGrado) {
            opciones +=
              '<option value="' +
              curso.idGrado +
              '" data-tipo-docente="' +
              tipoDocente +
              '">' +
              curso.descripcionCurso +
              "</option>";
          }
        });

        selectDiv = document.getElementById("selectCurso");
        select =
          '<label for="selectCurso" class="form-label">Selecciona el Curso:</label>' +
          '<select class="form-select selectCurso" id="selectCurso" data-placeholder="Elegir curso">' +
          '<option value="">Selecciona curso...</option>' +
          opciones +
          "</select>";

        selectDiv.innerHTML = select;
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText); // procendecia de error
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }
});

//Desactivar Docente
$("#dataTableDocentes").on("click", "#btnDesactivarDocente", function () {
  var idUsuario = $(this).attr("idUsuario");

  Swal.fire({
      title: '¿Estás seguro?',
      text: "¡El Docente será desactivado!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, desactivar',
      cancelButtonText: 'Cancelar'
  }).then((result) => {
      if (result.isConfirmed) {
          var docenteEstado = 2;
          var data = new FormData();
          data.append("idUsuarioEstado", idUsuario);
          data.append("docenteEstado", docenteEstado);
          
          $.ajax({
              url: "ajax/docentes.ajax.php",
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
                          'El Docente ha sido desactivado.',
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

//Activar Docente
$("#dataTableDocentes").on("click", "#btnActivarDocente", function () {
var idUsuario = $(this).attr("idUsuario");

Swal.fire({
    title: '¿Estás seguro?',
    text: "¡El Docente será activado!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, activar',
    cancelButtonText: 'Cancelar'
}).then((result) => {
    if (result.isConfirmed) {
        var docenteEstado = 1;
        var data = new FormData();
        data.append("idUsuarioEstado", idUsuario);
        data.append("docenteEstado", docenteEstado);
        
        $.ajax({
            url: "ajax/docentes.ajax.php",
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
                        'El Docente ha sido activado.',
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

// Funcionalidad para el botón Registrar Pago de Matrícula
$("#btnPagoMatricula").click(function (event) {

  // Obtener el codgio de postulante de pago del atributo del botón
  var codPostulante = $(this).data("codpostulante");
	window.location = "index.php?ruta=registrarPago&codPostulante=" + codPostulante;

});
