//  Agregar un nuevo año escolar
$("#btnRegistrarAnioEscolar").on("click", function () {
  var descripcionAnio = $("#descripcionAnio").val();
  var cuotaIngreso = $("#cuotaIngreso").val();
  var matriculaInicial = $("#matriculaInicial").val();
  var pensionInicial = $("#pensionInicial").val();
  var matriculaPrimaria = $("#matriculaPrimaria").val();
  var pensionPrimaria = $("#pensionPrimaria").val();
  var matriculaSecundaria = $("#matriculaSecundaria").val();
  var pensionSecundaria = $("#pensionSecundaria").val();

  if (descripcionAnio == "") {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "El campo de descripción no puede estar vacío",
      timer: 2000,
      showConfirmButton: true,
    });
    return;
  }

  // Crea un objeto con los datos
  var dataRegistrarAnio = {
    descripcionAnio: descripcionAnio,
    cuotaIngreso: cuotaIngreso,
    matriculaInicial: matriculaInicial,
    pensionInicial: pensionInicial,
    matriculaPrimaria: matriculaPrimaria,
    pensionPrimaria: pensionPrimaria,
    matriculaSecundaria: matriculaSecundaria,
    pensionSecundaria: pensionSecundaria,
  };

  // Crea un objeto FormData y añade el objeto
  var data = new FormData();
  data.append("dataRegistrarAnio", JSON.stringify(dataRegistrarAnio));

  // Envía los datos al servidor con una solicitud AJAX
  $.ajax({
    url: "ajax/anioEscolar.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response == "ok") {
        //  Ocultar y limpiar campos
        $("#modalAgregarArea").modal("hide");
        $("#descripcionAnio").val("");
        $("#cuotaIngreso").val("");
        $("#matriculaInicial").val("");
        $("#pensionInicial").val("");
        $("#matriculaPrimaria").val("");
        $("#pensionPrimaria").val("");
        $("#matriculaSecundaria").val("");
        $("#pensionSecundaria").val("");

        Swal.fire({
          icon: "success",
          title: "Registrado",
          text: "Año Escolar Registrado",
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
        text: "Error al crear el Año Escolar",
        timer: 2000,
        showConfirmButton: true,
      });
      // Muestra el mensaje de error
      console.error("Error al crear el Año Escolar: ", textStatus, errorThrown);
    },
  });
});

//  Obtener los datos del anioEscolar para editar
$(".dataTableAnios").on("click", ".btnEditarAnio", function (e) {
  var codAnio = $(this).attr("codAnio");

  var data = new FormData();
  data.append("codAnioBuscar", codAnio);

  $.ajax({
    url: "ajax/anioEscolar.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response == "error") {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "El año no se encontró",
          timer: 2000,
          showConfirmButton: true,
        });
        return;
      } else {
        $("#editarDescripcionAnio").val(response.descripcionAnio);
        $("#editarCuotaIngreso").val(response.cuotaInicial);
        $("#editarMatriculaInicial").val(response.matriculaInicial);
        $("#editarPensionInicial").val(response.pensionInicial);
        $("#editarMatriculaPrimaria").val(response.matriculaPrimaria);
        $("#editarPensionPrimaria").val(response.pensionPrimaria);
        $("#editarMatriculaSecundaria").val(response.matriculaSecundaria);
        $("#editarPensionSecundaria").val(response.pensionSecundaria);
        $("#editarPensionSecundaria").val(response.pensionSecundaria);
        $("#codAnioEscolar").val(response.idAnioEscolar);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

//  Editar Año Escolar
$(".btnEditarAnioEscolar").on("click", function () {
  var idAnioEscolar = $("#codAnioEscolar").val();
  var descripcionAnio = $("#editarDescripcionAnio").val();
  var cuotaIngreso = $("#editarCuotaIngreso").val();
  var matriculaInicial = $("#editarMatriculaInicial").val();
  var pensionInicial = $("#editarPensionInicial").val();
  var matriculaPrimaria = $("#editarMatriculaPrimaria").val();
  var pensionPrimaria = $("#editarPensionPrimaria").val();
  var matriculaSecundaria = $("#editarMatriculaSecundaria").val();
  var pensionSecundaria = $("#editarPensionSecundaria").val();

  if (descripcionAnio == "") {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "El campo de descripción no puede estar vacío",
      timer: 2000,
      showConfirmButton: true,
    });
    return;
  }
  var dataEditarAnioEscolar = {
    idAnioEscolar: idAnioEscolar,
    descripcionAnio: descripcionAnio,
    cuotaIngreso: cuotaIngreso,
    matriculaInicial: matriculaInicial,
    pensionInicial: pensionInicial,
    matriculaPrimaria: matriculaPrimaria,
    pensionPrimaria: pensionPrimaria,
    matriculaSecundaria: matriculaSecundaria,
    pensionSecundaria: pensionSecundaria,
  };

  var data = new FormData();
  data.append("dataEditarAnioEscolar", JSON.stringify(dataEditarAnioEscolar));

  $.ajax({
    url: "ajax/anioEscolar.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response == "ok") {
        //  Ocultar y limpiar campos
        $("#modalEditarCurso").modal("hide");

        Swal.fire({
          icon: "success",
          title: "Editado",
          text: "Curso Editado",
          showConfirmButton: true,
        }).then((result) => {
          location.reload();
        });
      }
    },
  });
});

//  Obtener los datos del anioEscolar para visualizar
$(".dataTableAnios").on("click", ".btnVisualizarAnio", function (e) {
  var codAnio = $(this).attr("codAnio");

  var data = new FormData();
  data.append("codAnioBuscar", codAnio);

  //  Reutilizamos la función de obtener los datos para editar
  $.ajax({
    url: "ajax/anioEscolar.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response == "error") {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "El año no se encontró",
          timer: 2000,
          showConfirmButton: true,
        });
        return;
      } else {
        var estadoAnio = response.estadoAnio == 1 ? "Activo" : "Inactivo";
        $("#visualizarDescripcionAnio").val(response.descripcionAnio);
        $("#visualizarEstadoAnio").val(estadoAnio);
        $("#visualizarCuotaIngreso").val(response.cuotaInicial);
        $("#visualizarMatriculaInicial").val(response.matriculaInicial);
        $("#visualizarPensionInicial").val(response.pensionInicial);
        $("#visualizarMatriculaPrimaria").val(response.matriculaPrimaria);
        $("#visualizarPensionPrimaria").val(response.pensionPrimaria);
        $("#visualizarMatriculaSecundaria").val(response.matriculaSecundaria);
        $("#visualizarPensionSecundaria").val(response.pensionSecundaria);
        $("#visualizarPensionSecundaria").val(response.pensionSecundaria);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

//  Actualizar el estado del año escolar
$(".dataTableAnios").on("click", ".btnActualizarEstado", function (e) {
  var codAnio = $(this).attr("codAnio");
  var estadoAnio = $(this).attr("codEstado");

  var descripcion = estadoAnio == "1" ? "Desactivar" : "Activar";
  swal
    .fire({
      title: "¿Esta seguro de " + descripcion + "?",
      text: "¡El estado del año cambiará!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, " + descripcion + "!",
    })
    .then((result) => {
      var dataActivarAnioEscolar = {
        codAnio: codAnio,
        estadoAnio: estadoAnio,
      };
      var data = new FormData();
      data.append(
        "dataActivarAnioEscolar",
        JSON.stringify(dataActivarAnioEscolar)
      );
      $.ajax({
        url: "ajax/anioEscolar.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (response == "error") {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Error al actualizar el estado del Año Escolar",
              timer: 2000,
              showConfirmButton: true,
            });
            return;
          } else {
            Swal.fire({
              icon: "success",
              title: "Actualizado",
              text: "Estado del Año Escolar Actualizado",
              showConfirmButton: true,
            }).then((result) => {
              location.reload();
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
    });
});

// Eliminar un Año Escolar
$(".dataTableAnios").on("click", ".btnEliminarAnio", function (e) {
  var codAnio = $(this).attr("codAnio");

  Swal.fire({
    title: "¿Estás seguro de eliminar el este Año Escolar ?",
    text: "¡Si no lo está, puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí, eliminar Año Escolar !",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = new FormData();
      data.append("codAnioEliminar", codAnio);

      $.ajax({
        url: "ajax/anioEscolar.ajax.php",
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
              title: "¡El Año Escolar ha sido eliminado!",
              showConfirmButton: true,
              timer: 2000,
            }).then((result) => {
              location.reload();
            });
          } else if (response == "error") {
            Swal.fire({
              icon: "error",
              title:
                "No se pudo eliminar el curso. Es posible que esté en uso.",
              showConfirmButton: true,
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
$("#btnCerrarAñoEscolar").on("click", function () {
  window.location = "cerrarAnioGrado";
});
$("#btnCerrarAñoEscolarActualFinal").on("click", function () {
  swal
    .fire({
      title: "¿Está seguro de cerrar el año Escolar?",
      text: "¡No podrá revertir el cambio! Se cerrarán todos los grados",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Sí, cerrar el año!",
    })
    .then((result) => {
      var data = new FormData();
      data.append("cerrarAnioEscolarFinalDesactivar", true);

      $.ajax({
        url: "ajax/anioEscolar.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (response == "Error Activos") {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "¡Solo debe estar activo un año escolar!",
            });
          } else {
            if (response == "ok") {
              Swal.fire({
                icon: "success",
                title: "¡El Año Escolar ha sido cerrado!",
                showConfirmButton: true,
                timer: 2000,
              }).then((result) => {
                window.location = "anioEscolar";
              });
            } else if (response == "error") {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "¡Existen grados sin asignación de estado!",
              });
            }
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
    });
});
