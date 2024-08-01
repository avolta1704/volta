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
    },
  });
});

//  Mostrar data del usuario para actualizar
$(".dataTableUsuarios").on("click", ".btnActualizarUsuario", function () {
  var codUsuario = $(this).attr("codUsuario");
  Swal.fire({
    icon: "warning",
    title: "¿Desea actualizar el estado del usuario?",
  }).then(function (result) {
    var data = new FormData();
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
        if (response == "ok") {
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Estado actualizado correctamente",
          }).then(function (result) {
            if (result.value) {
              window.location = "usuarios";
            }
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Error al actualizar el estado",
          }).then(function (result) {
            if (result.value) {
              window.location = "usuarios";
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

$("#usuarioCorreo").on("change", function () {
  validarCorreo = $("#usuarioCorreo").val();

  var data = new FormData();
  data.append("validarCorreo", validarCorreo);
  $.ajax({
    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      if (response["validacion"] == "1") {
        Swal.fire({
          icon: "warning",
          title: "Correo en Uso",
          text: "El correo ya se encuentra en uso, por favor ingrese otro",
        }).then(function (result) {
          $("#usuarioCorreo").val("");
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

//  Eliminar usuarios
$(".dataTableUsuarios").on("click", ".btnDeleteUsuario", function () {
  var codUsuario = $(this).attr("codUsuario");
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡El usuario será eliminado!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = new FormData();
      data.append("codUsuarioEliminar", codUsuario);
      $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (response == "ok") {
            Swal.fire(
              "Eliminado",
              "El usuario ha sido eliminado.",
              "success"
            ).then(() => {
              location.reload();
            });
          } else {
            Swal.fire(
              "Error",
              "El usuario tiene registros asociados, no se puede eliminar.",
              "warning"
            ).then(() => {
              location.reload();
            });
          }
        },
      });
    }
  });
});
