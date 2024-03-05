//  Mostrar data del usuario para editar
$(".dataTableUsuarios").on("click", ".btnEditarUsuario", function () {
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
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    }
  });
});

//  Mostrar data del usuario para actualizar
$(".dataTableUsuarios").on("click", ".btnActualizarUsuario", function () {
  var codUsuario = $(this).attr("codUsuario");
  var data =  new FormData();
  data.append("codUsuarioActualizar", codUsuario);
  $.ajax({
    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      if(response == "ok") {
        Swal.fire({
          icon: "success",
          title: "Correcto",
          text: "Estado actualizado correctamente",
        }).then(function(result){
          if(result.value){
            window.location = "usuarios";
          }
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error al actualizar el estado",
        }).then(function(result){
          if(result.value){
            window.location = "usuarios";
          }
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    }
  });
});
