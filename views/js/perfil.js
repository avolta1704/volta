$("#btnUpdatePassword").on("click", function () {
  var password = $("#currentPassword").val();
  var newPassword = $("#newPassword").val();
  var renewPassword = $("#renewPassword").val();

  var passwordData = {
    password: password,
    newPassword: newPassword,
    renewPassword: renewPassword,
  };

  var data = new FormData();
  data.append("passwordData", JSON.stringify(passwordData));

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
          title: "Editado",
          text: "Datos modificados correctamente",
          showConfirmButton: true,
        }).then((result) => {
          location.reload();
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "La contraseña no coincide",
          showConfirmButton: true,
        }).then((result) => {
          location.reload();
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "La contraseña no coincide",
        timer: 2000,
        showConfirmButton: true,
      });
      console.error(
        "La contraseña no coincide: ",
        textStatus,
        errorThrown
      );
    },
  });
});
