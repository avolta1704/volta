$(document).ready(function () {
  $(".dataTableAdmisionAlumnos").on(
    "click",
    ".btnEditarEstadoAdmisionAlumno",
    function () {
      var btn = $(this);
      btn.prop("disabled", true);

      swal
        .fire({
          title: "¿Está seguro de generar el calendario al alumno?",
          text: "¡No podrá revertir el cambio!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Si, generar calendario!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            var codAdmisionAlumno = $(this).attr("codAdmisionAlumno");
            var data = new FormData();
            data.append("codAdmisionAlumno", codAdmisionAlumno);
            $.ajax({
              url: "ajax/admisionAlumnos.ajax.php",
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
                    timer: 500,
                    showConfirmButton: false,
                  });
                } else {
                  Swal.fire({
                    icon: "warning",
                    title: "Adveterencia",
                    text: "No modifico el estado del Postulante",
                    timer: 500,
                    showConfirmButton: false,
                  });
                }
                // Cerrar el modal después de recibir la respuesta
                $("#actualizarEstado").modal("hide");
                setTimeout(function () {
                  window.location = "listaAdmisionAlumnos";
                }, 500);
                setTimeout(function () {
                  btn.prop("disabled", false); // Habilitar el botón después de 3 segundos posterior ala respuesta del AJAX para evitar clicks repetidos
                }, 3000);
              },
              error: function (jqXHR, textStatus, errorThrown) {
                console.log(
                  "Error en la solicitud AJAX: ",
                  textStatus,
                  errorThrown
                );
              },
            });
          } else {
            btn.prop("disabled", false);
          }
        });
    }
  );
});
//eliminar alumno
$(".dataTableAdmisionAlumnos").on("click", ".btnEliminarAdmisionAlumno", function (event) {
  event.stopPropagation();

  var codAlumno = $(this).attr("codAdmisionAlumno");

  Swal.fire({
    title: "¿Esta seguro?",
    text: "¡De borrar el registro de Matricula del Postulante!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, borrar!",
    cancelButtonText: "No, cancelar!",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = new FormData();
      data.append("codAlumnoEliminar", codAlumno);

      $.ajax({
        url: "ajax/admisionAlumnos.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          // Aquí puedes manejar la respuesta del servidor
          if (response == "ok") {
            Swal.fire({
              icon: "success",
              title: "Registro Matricula eliminado",
              showConfirmButton: false,
              timer: 2000,
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error al eliminar el registro Matricula",
              showConfirmButton: false,
              timer: 2000,
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error(
            "Error en la solicitud AJAX: ",
            textStatus,
            errorThrown
          );
        },
      });
    }
  });
});
