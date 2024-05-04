//  Create a new order
$("#btnAgregarPostulante").on("click", function () {
  window.location = "index.php?ruta=nuevoPostulante";
});
//  Alert to delete an inside movement
$(".dataTablePostulantes").on("click", ".btnEliminarPostulante", function () {
  var codPostulante = $(this).attr("codPostulante");
  swal
    .fire({
      title: "¿Esta seguro de eliminar a este postulante?",
      text: "¡No podrá revertir el cambio! Se borrarán todos de este postulante",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar postulante!",
    })
    .then((result) => {
      if (result.isConfirmed) {
        window.location =
          "index.php?ruta=listaPostulantes&codPostulanteEliminar=" +
          codPostulante;
      }
    });
});
//  Cerrar vista de nuevo y editar postulante
$(".dataTablePostulantes").on("click", ".btnEditarPostulante", function () {
  var codPostulante = $(this).attr("codPostulante");
  window.location =
    "index.php?ruta=editarPostulante&codPostulanteEditar=" + codPostulante;
});

//  Cerrar vista de nuevo y editar postulante
$(".dataTablePostulantes").on("click", ".btnVisualizarPostulante", function () {
  var codPostulante = $(this).attr("codPostulante");
  window.location =
    "index.php?ruta=visualizarPostulante&codPostulante=" + codPostulante;
});

//  Cerrar vista de nuevo y editar postulante
$(".cerrarCrearPostulante").on("click", function () {
  window.location = "index.php?ruta=listaPostulantes";
});
//modal para actualizar estado del postulante por la lista del modal
$(document).ready(function () {
  $(".dataTablePostulantes").on(
    "click",
    ".btnActualizarEstadoPostulante",
    function () {
      var codPostulante = $(this).attr("codPostulante");
      var estadoPostulante = $(this).attr("codEstado");
      var estadoTexto;
      if (estadoPostulante === "1") {
        estadoTexto = "Registrado";
      } else if (estadoPostulante === "2") {
        estadoTexto = "En revisión";
      } else if (estadoPostulante === "3") {
        estadoTexto = "Admitir";
      } else if (estadoPostulante === "4") {
        estadoTexto = "Desestimar";
      } else {
        estadoTexto = "Sin Estado";
      }
      $("#actualizarEstado #codPostulante").val(codPostulante);
      $(
        '#actualizarEstado #estadoPostulante option[value="' +
          estadoPostulante +
          '"]'
      ).remove();
      $("#actualizarEstado #estadoPostulante").prepend(
        '<option value="' +
          estadoPostulante +
          '" selected>' +
          estadoTexto +
          "</option>"
      );
      $("#actualizarEstado").modal("show");
    }
  );
});

//  Actualizar estado del postulante
$(document).ready(function () {
  $("#btnActualizarEstadoPostulante").on("click", function () {
    var codPostulanteEdit = $("#codPostulante").val();
    var estadoPostulanteEdit = $("#estadoPostulante").val();
    var data = new FormData();
    data.append("codPostulanteEdit", codPostulanteEdit);
    data.append("estadoPostulanteEdit", estadoPostulanteEdit);

    $.ajax({
      url: "ajax/postulantes.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",

      success: function (response) {
        if (response == "ok") {
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Estado actualizado correctamente",
          }).then(function (result) {
            if (result.value) {
              window.location = "listaPostulantes";
            }
          });
        } else {
          Swal.fire({
            icon: "warning",
            title: "Adveterencia",
            text: "No modifico el estado del Postulante",
          }).then(function (result) {
            if (result.value) {
              window.location = "listaPostulantes";
            }
          });
        }
        // Cerrar el modal después de recibir la respuesta
        $("#actualizarEstado").modal("hide");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  });
});

//  Buscar Postulante
$(document).ready(function () {
  $(".busquedaPostulante").select2();

  $(".busquedaPostulante").on("change", function (e) {
    var codPostulante = $(this).val();

    if (codPostulante == "0") {
      limpiarDatosPostulante();
    } else {
      var data = new FormData();
      data.append("codPostulanteBusqueda", codPostulante);

      $.ajax({
        url: "ajax/postulantes.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",

        success: function (response) {
          actualizarDatosPostulante(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText); // procedencia de error
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
  });

  const limpiarDatosPostulante = () => {
    //  Data Alumno
    $("#sexoPostulante").val("");
    $("#dniPostulante").val("");
    $("#nivelPostulante").val("");
    $("#gradoBusqueda").val("");
    $("#fechaPostulacion").val("");
    $("#fechaNacimiento").val("");
    $("#lugarNacimiento").val("");
    $("#domicilioPostulante").val("");
    $("#colegioProcedencia").val("");
    $("#dificultadPostulante").val("");
    $("#obsDificultad").val("");
    $("#tipoAtencion").val("");
    $("#obsTratamiento").val("");

    //  Data Padre
    $("#nombrePadre").val("");
    $("#apellidoPadre").val("");
    $("#dniPadre").val("");
    $("#nacimientoPadre").val("");
    $("#convivePadre").val("");
    $("#gradoPadre").val("");
    $("#profesionPadre").val("");
    $("#correoPadre").val("");
    $("#numeroPadre").val("");
    $("#dependenciaPadre").val("");
    $("#centroPadre").val("");
    $("#tlfTrabajoPadre").val("");
    $("#ingresoPadre").val("");

    //  Data Madre
    $("#nombreMadre").val("");
    $("#apellidoMadre").val("");
    $("#dniMadre").val("");
    $("#nacimientoMadre").val("");
    $("#conviveMadre").val("");
    $("#gradoMadre").val("");
    $("#profesionMadre").val("");
    $("#correoMadre").val("");
    $("#numeroMadre").val("");
    $("#dependenciaMadre").val("");
    $("#centroMadre").val("");
    $("#tlfTrabajoMadre").val("");
    $("#ingresoMadre").val("");
  };

  const actualizarDatosPostulante = (postulante) => {
    //  Actualizar data postulante
    $("#sexoPostulante").val(postulante.sexoPostulante);
    $("#dniPostulante").val(postulante.dniPostulante);
    $("#nivelPostulante").val(postulante.gradoPostulacion);
    $("#gradoBusqueda").val(postulante.gradoPostulacion);
    $("#fechaPostulacion").val(postulante.fechaPostulacion);
    $("#fechaNacimiento").val(postulante.fechaNacimiento);
    $("#lugarNacimiento").val(postulante.lugarNacimiento);
    $("#domicilioPostulante").val(postulante.domicilioPostulante);
    $("#colegioProcedencia").val(postulante.colegioProcedencia);
    $("#dificultadPostulante").val(postulante.dificultadPostulante);
    $("#obsDificultad").val(postulante.dificultadObservacion);
    $("#tipoAtencion").val(postulante.tipoAtencionPostulante);
    $("#obsTratamiento").val(postulante.tratamientoPostulante);
    
    //  Actualizar data padre
    $("#nombrePadre").val(postulante.idPadre.apellidoApoderado);
    $("#apellidoPadre").val(postulante.idPadre.nombreApoderado);
    $("#dniPadre").val(postulante.idPadre.dniApoderado);
    $("#nacimientoPadre").val(postulante.idPadre.fechaNacimiento);
    $("#convivePadre").val(postulante.idPadre.convivenciaAlumno);
    $("#gradoPadre").val(postulante.idPadre.gradoInstruccion);
    $("#profesionPadre").val(postulante.idPadre.profesionApoderado);
    $("#correoPadre").val(postulante.idPadre.correoApoderado);
    $("#numeroPadre").val(postulante.idPadre.celularApoderado);
    $("#dependenciaPadre").val(postulante.idPadre.dependenciaApoderado);
    $("#centroPadre").val(postulante.idPadre.centroLaboral);
    $("#tlfTrabajoPadre").val(postulante.idPadre.telefonoTrabajo);
    $("#ingresoPadre").val(postulante.idPadre.ingresoMensual);

    //  Actualizar data madre 
    $("#nombreMadre").val(postulante.idMadre.apellidoApoderado);
    $("#apellidoMadre").val(postulante.idMadre.nombreApoderado);
    $("#dniMadre").val(postulante.idMadre.dniApoderado);
    $("#nacimientoMadre").val(postulante.idMadre.fechaNacimiento);
    $("#conviveMadre").val(postulante.idMadre.convivenciaAlumno);
    $("#gradoMadre").val(postulante.idMadre.gradoInstruccion);
    $("#profesionMadre").val(postulante.idMadre.profesionApoderado);
    $("#correoMadre").val(postulante.idMadre.correoApoderado);
    $("#numeroMadre").val(postulante.idMadre.celularApoderado);
    $("#dependenciaMadre").val(postulante.idMadre.dependenciaApoderado);
    $("#centroMadre").val(postulante.idMadre.centroLaboral);
    $("#tlfTrabajoMadre").val(postulante.idMadre.telefonoTrabajo);
    $("#ingresoMadre").val(postulante.idMadre.ingresoMensual);
  };
});
