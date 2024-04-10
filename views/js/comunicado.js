//  crear nuevo Comunicadopago
$(".dataTableComunicadoPago").on("click", ".btnComunicadoPago", function () {
  var codAdAlumCronograma = $(this).attr("codAdAlumCronograma");
  var codAlumno = $(this).attr("codAlumno");
  Swal.fire({
    icon: "info",
    title: "Registrara un comunicado de Pago",
    html: "<strong>Continuar</strong>",
    showCancelButton: true, // Muestra el botón de cancelación
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location =
        "index.php?ruta=registrarComunicadoPago&codAdAlumCronograma=" +
        codAdAlumCronograma +
        "&codAlumno=" +
        codAlumno;
    }
  });
});

/* <!-- registrar modal comunicado --> */
// Escucha el evento de clic en el botón .btnCronoCumunicado
$(document).on("click", ".btnCronoCumunicado", function (event) {
  event.stopPropagation();
  var codComunicado = $(this).attr("codComunicado");
  // Desvincula cualquier controlador de eventos existente del botón .btnRegistrarComunicacion
  $(".btnRegistrarComunicacion").off("click");
  // Escucha el evento de clic en el botón de registro del modal
  $(".btnRegistrarComunicacion").click(function () {
    var fechaComuni = $("#fechaComuni").val();
    var asuntoComuni = $("#asuntoComuni").val();
    var comunicado = $("#comunicado").val();

    var datosDeComunicado = {
      codComunicado: codComunicado,
      fechaComuni: fechaComuni,
      asuntoComuni: asuntoComuni,
      comunicado: comunicado,
    };
    var jsonDatosComunicado = JSON.stringify({ datos: datosDeComunicado });
    $.ajax({
      url: "ajax/comunicado.ajax.php",
      method: "POST",
      data: jsonDatosComunicado, // Envía el JSON
      contentType: "application/json", // Indica que estás enviando datos JSON
      dataType: "json",

      success: function (response) {
        if (response == "ok") {
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Comunicado registrado correctamente",
            timer: 2000,
            showConfirmButton: false,
          }).then(function () {
            // Recargar la página después de cerrar el modal
            location.reload();
          });
        } else {
          Swal.fire({
            icon: "warning",
            title: "Advertencia",
            text: "No se registró el comunicado",
            timer: 2000,
            showConfirmButton: false,
          }).then(function () {
            // Recargar la página después de cerrar el modal
            location.reload();
          });
        }
        // Cerrar el modal después de recibir la respuesta
        $("#comunicadoModal").modal("hide");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  });
});

//vista modal cronograma de pagos de pagoalumnos
$(".dataTableComunicadoPago").on(
  "click",
  ".btnVisualizarAdmisionAlumno",
  function () {
    var codAdAlumCronograma = $(this).attr("codAdAlumCronograma");
    var data = new FormData();
    data.append("codAdAlumCronograma", codAdAlumCronograma);
    $.ajax({
      url: "ajax/comunicado.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        // Limpia el cuerpo del modal
        var modalBody = $("#cronogramaAdmisionPago .modal-body");
        modalBody.empty();

        // Por cada elemento en la respuesta
        $.each(response, function (index, item) {
          // Crea un nuevo div
          var div = $("<div>").addClass("mb-3");

          // Crea las etiquetas

          var label2 = $("<label>")
            .addClass("form-label h5 font-weight-bold")
            .attr("id", "tipoCronoPago")
            .attr("name", "tipoCronoPago")
            .text("  " + item.conceptoPago);
          // Crea un nuevo div para el grupo de entrada
          var inputGroup = $("<div>").addClass("input-group");
          // Crea los campos de entrada
          var input1 = $("<input>")
            .attr("type", "text")
            .addClass("form-control")
            .attr("id", "fechaPago")
            .attr("name", "fechaPago")
            .val(item.mesPago)
            .attr("readonly", true);
          var input2 = $("<div>")
            .addClass("form-control form-control-sm fs-6 text-center")
            .attr("id", "stadoCronograma")
            .attr("name", "stadoCronograma")
            .html(item.estadoCronogramaPago);
          // Añade los campos de entrada al grupo de entrada
          inputGroup.append(input1, input2);
          // Añade las etiquetas y el grupo de entrada al div
          div.append(label2, inputGroup);
          // Añade el div al cuerpo del modal
          modalBody.append(div);
        });
        // Muestra el modal
        $("#cronogramaAdmisionPago").modal("show");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }
);
// editar comunicado  de pago
$(document).on("click", ".btnEditarComunicado", function (event) {
  event.stopPropagation();

  var codComunicadoEdit = $(this).attr("codComunicadoEdit");
  var contador = $(this).attr("id"); // Obtén el valor del id del botón

  // Usa el contador para obtener los valores de los campos
  var tituloComunicado = $("#tituloComunicado" + contador).val();
  var fechaComunicado = $("#fechaComunicado" + contador).val();
  var textoComunicado = $("#textoComunicado" + contador).val();

  Swal.fire({
    title: "¿Ha modificado el Registro?",
    text: "¡Editar el Comunicado!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, editar!",
    cancelButtonText: "No, cancelar!",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = new FormData();
      data.append("codComunicadoEdit", codComunicadoEdit);
      data.append("tituloComunicado", tituloComunicado);
      data.append("fechaComunicado", fechaComunicado);
      data.append("textoComunicado", textoComunicado);

      $.ajax({
        url: "ajax/comunicado.ajax.php",
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
              title: "Comunicado editado",
              showConfirmButton: false,
              timer: 2000,
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error al editar el comunicado",
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
// borrar comunicado de pago
$(document).on("click", ".btnBorraraComunicado", function (event) {
  event.stopPropagation();

  var codComunicadoDelet = $(this).attr("codComunicadoDelet");
  var codDetallComunicadoDelet = $(this).attr("codDetallComunicadoDelet");

  Swal.fire({
    title: "¿Esta seguro?",
    text: "¡De borrar el registro!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, borrar!",
    cancelButtonText: "No, cancelar!",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = new FormData();
      data.append("codComunicadoDelet", codComunicadoDelet);
      data.append("codDetallComunicadoDelet", codDetallComunicadoDelet);

      $.ajax({
        url: "ajax/comunicado.ajax.php",
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
              title: "Comunicado eliminado",
              showConfirmButton: false,
              timer: 2000,
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error al eliminar el comunicado",
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
