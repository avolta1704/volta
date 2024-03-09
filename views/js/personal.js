//   data para editar Personal
$(".dataTablePersonal").on("click", ".btnEditarPersonal", function () {
  var codPersonal = $(this).attr("codPersonal");
  window.location =
    "index.php?ruta=editarPersonal&codPersonal=" + codPersonal;
});
//  Cerrar vista de editar Personal
$(".cerrarEditarPersonal").on("click", function () {
  window.location = "index.php?ruta=personal";
});
