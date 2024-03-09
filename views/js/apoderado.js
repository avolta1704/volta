//   editar Apoderado
$(".dataTableApoderado").on("click", ".btnEditarApoderado", function () {
  var codApoderado = $(this).attr("codApoderado");
  window.location =
    "index.php?ruta=editarApoderado&codApoderadoEditar=" + codApoderado;
});

//  Cerrar vista de editar Apoderado
$(".cerrarEditarApoderado").on("click", function () {
  window.location = "index.php?ruta=apoderado";
});