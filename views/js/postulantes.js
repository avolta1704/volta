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
        estadoTexto = "Aprobado";
      } else if (estadoPostulante === "4") {
        estadoTexto = "Rechazado";
      } else {
        estadoTexto = "Sin Estado";
      }
      $("#actualizarEstado #codPostulante").val(codPostulante);
      $('#actualizarEstado #estadoPostulante option[value="' + estadoPostulante + '"]').remove();
      $('#actualizarEstado #estadoPostulante').prepend('<option value="' + estadoPostulante + '" selected>' + estadoTexto + '</option>');
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
        $('#actualizarEstado').modal('hide');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  });
});
