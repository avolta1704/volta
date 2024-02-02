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
