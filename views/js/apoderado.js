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

$(".dataTableApoderado").on("click", ".btnCrearApoderadoUsuario", function () {
  var codApoderado = $(this).attr("codApoderado");
  var correoApoderado = $(this).attr("correoApoderado");
  var nombreApoderado = $(this).attr("nombreApoderado");
  var apellidoApoderado = $(this).attr("apellidoApoderado");
  var dniApoderado = $(this).attr("dniApoderado");
  Swal.fire({
    title: "¿Estás seguro?",
    html: "El correo <u style='color: blue;'>" + correoApoderado + "</u> se usará para crear la cuenta.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, asignar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $("#agregarUsuarioApoderado").modal("show");

      // Asignar los valores a los campos del formulario
      $("#usuarioCorreoApoderado").val(correoApoderado);
      $("#nombreUsuarioApoderado").val(nombreApoderado);
      $("#apellidoUsuarioApoderado").val(apellidoApoderado);
      $("#dniUsuarioApoderado").val(dniApoderado);
      $(".btnCrearUsuarioApoderadoMdl").on("click", function () {
        var correoUsuarioApoderado = $("#usuarioCorreoApoderado").val();
        var nombreUsuarioApoderado = $("#nombreUsuarioApoderado").val();
        var apellidoUsuarioApoderado = $("#apellidoUsuarioApoderado").val();
        var dniUsuarioApoderado = $("#dniUsuarioApoderado").val();
        var contrasenaUsuarioApoderado = $("#passwordUsuarioApoderado").val();
        var tipoUsuarioApoderado = 4;
        let datosApoderado = {
          codApoderado: codApoderado,
          correoUsuarioApoderado: correoUsuarioApoderado,
          nombreUsuarioApoderado: nombreUsuarioApoderado,
          apellidoUsuarioApoderado: apellidoUsuarioApoderado,
          dniUsuarioApoderado: dniUsuarioApoderado,
          contrasenaUsuarioApoderado: contrasenaUsuarioApoderado,
          tipoUsuarioApoderado: tipoUsuarioApoderado,
        };
        var data = new FormData();
        data.append("datosApoderado", JSON.stringify(datosApoderado));

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
                title: "¡El usuario ha sido creado con éxito!",
                text: "Correo para acceder: <u style='color: blue;'>" + correoApoderado + "</u>",
                icon: "success",
                confirmButtonText: "Cerrar",
              }).then(function (result) {
                if (result.isConfirmed) {
                  window.location = "index.php?ruta=apoderado";
                }
              });
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText); // procendecia de error
            console.log(
              "Error en la solicitud AJAX: ",
              textStatus,
              errorThrown
            );
          },
        });
      });
    }
  });
});
