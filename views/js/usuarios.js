//  Show user data
$(".table").on("click", ".btnEditarUsuario", function () {
  var codUsuario = $(this).attr("codUsuario");
  var data = new FormData();

  data.append("codUsuario", codUsuario);
  $.ajax({
    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      $("#correoEditar").val(response["correoUsuario"]);
      $("#nombreEditar").val(response["nombreUsuario"]);
      $("#apellidoEditar").val(response["apellidoUsuario"]);
      $("#dniEditar").val(response["dniUsuario"]);
      $("#tipoEditar").val(response["idTipoUsuario"]);
      $("#codUsuario").val(codUsuario);
    }
  });
});