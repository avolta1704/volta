//  Create a new order
$("#btnAgregarPostulante").on("click", function () {
  window.location = "index.php?ruta=nuevoPostulante";
});

//  Alert to delete an inside movement
$(".table").on("click", ".btnEliminarPostulante", function () {
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
$(".table").on("click", ".btnEditarPostulante", function () {
  var codPostulante = $(this).attr("codPostulante");
  window.location =
    "index.php?ruta=editarPostulante&codPostulanteEditar=" + codPostulante;
});

//  Cerrar vista de nuevo y editar postulante
$(".cerrarCrearPostulante").on("click", function () {
  window.location = "index.php?ruta=listaPostulantes";
});

//  Actualizar estado postulante
$(".tablaActualizrEstado").on("click", ".btnActualizarPostulante", function () {
  swal
    .fire({
      title: "¿Está seguro de realizar esta acción?",
      text: 'El estado pasará al siguiente estado de "Revision"',
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, poner en revisión",
    })
    .then((result) => {
      var codPostulante = $(this).attr("codPostulante");
      var estadoPostulante = $(this).attr("estadoPostulante");
      var data = new FormData();
      data.append("codPostulanteActualizar", codPostulante);
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
              icon: "error",
              title: "Error",
              text: "Error al actualizar el estado",
            }).then(function (result) {
              if (result.value) {
                window.location = "listaPostulantes";
              }
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    });
});
