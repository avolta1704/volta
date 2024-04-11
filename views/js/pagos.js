//  crear nuevo pago
$("#btnAgregarNuevoPago").on("click", function () {
  window.location = "index.php?ruta=registrarPago";
});
//  cerrar crear nuevo pago
$(".cerrarRegistroPago").on("click", function () {
  window.location = "index.php?ruta=listaPagos";
});

//vista modal cronograma de pagos de admision alumnos
$(".dataTableAdmisionAlumnos").on(
  "click",
  ".btnVisualizarAdmisionAlumno",
  function () {
    var codAdAlumCronograma = $(this).attr("codAdAlumCronograma");
    var data = new FormData();
    data.append("codAdAlumCronograma", codAdAlumCronograma);
    $.ajax({
      url: "ajax/admisionAlumnos.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        var modalBody = $("#cronogramaAdmisionPago .modal-body");
        modalBody.empty();

        $.each(response, function (index, item) {
          var div = $("<div>").addClass("mb-3");

          var label2 = $("<label>")
            .addClass("form-label h5 font-weight-bold")
            .attr("id", "tipoCronoPago")
            .attr("name", "tipoCronoPago")
            .css("margin-left", "8px") // Agrega un margen a la izquierda
            .html("<strong>" + item.mesPago + "</strong>");

          var inputGroup = $("<div>").addClass("input-group");

          var input1 = $("<input>")
            .attr("type", "text")
            .addClass("form-control")
            .attr("id", "fechaPago")
            .attr("name", "fechaPago")
            .val("Fecha Límite: " + item.fechaLimite)
            .attr("readonly", true)
            .css("width", "133px"); // Ajusta este valor según tus necesidades

          var input2 = $("<input>")
            .attr("type", "text")
            .addClass("form-control")
            .attr("id", "montoPago")
            .attr("name", "montoPago")
            .val("Monto: S/ " + item.montoPago)
            .css("width", "75px"); // Ajusta este valor según tus necesidades

          var input3 = $("<div>")
            .addClass("form-control fs-6 text-center")
            .attr("id", "stadoCronograma")
            .attr("name", "stadoCronograma")
            .html(item.estadoCronogramaPago);

          var button = $("<button>")
            .addClass("btn btn-primary")
            .attr("id", "idCronogramaPago")
            .attr("name", "idCronogramaPago")
            .text("Editar")
            .val(item.idCronogramaPago);

          inputGroup.append(input1, input2, input3, button);
          div.append(label2, inputGroup);
          modalBody.append(div);
        });

        $("#cronogramaAdmisionPago").modal("show");
      },
      /*  error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
      }, */
    });
  }
);

// vista de pagos buscar alumno por el dni
$(".formPagoAlumno").on("click", ".btnBuscarDniAlumno", function () {
  var codCajaAlumno = $("#codCajaAlumno").val();
  var data = new FormData();
  data.append("codCajaAlumno", codCajaAlumno);
  $.ajax({
    url: "ajax/pagos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response !== false) {
        // Llena los campos de entrada con los datos de la respuesta
        $("#apellidoAlumnoPago").val(response.apellidosAlumno);
        $("#nombreAlumnoPago").val(response.nombresAlumno);
        $("#dniCajaArequipa").val(response.dniAlumno);

        $("#anioPago").val(new Date().getFullYear());
        $("#nivelAlumnoPago").val(response.nivelAlumno);
        $("#gradoAlumnoPago").val(response.descripcionGrado);
        // Llena el select con las opciones correspondientes de cada array de cronogramaPago
        var select = $("#cronogramaPago");
        select.empty();

        $.each(response.cronogramaPago, function (index, cronograma) {
          if (cronograma.estadoCronograma == 1) {
            var month = cronograma.mesPago;
            select.append(new Option(month, cronograma.idCronogramaPago)); // Usa cronograma.idCronogramaPago en el value
          }
        });

        // Desvincula los manejadores de eventos existentes
        select.off("change");
        // Cuando se selecciona una opción en el select, llena los  campos con los datos del array correspondiente al mes = arrays en cronogramaPago
        select.change(function () {
          var selectedId = $(this).val();
          var selectedCronograma = response.cronogramaPago.find(function (
            cronograma
          ) {
            return cronograma.idCronogramaPago == selectedId; // Encuentra el array con el id seleccionado
          });
          //$("#FechaInicioPago").val(selectedCronograma.mesPago);
          $("#fechaLimitePago").val(selectedCronograma.fechaLimite);
          $("#tipoPago").val(selectedCronograma.conceptoPago);
          $("#montoPago").val(selectedCronograma.montoPago);
        });
        // Dispara el evento change para llenar los campos con los datos del array en cronogramaPago seleccionado
        select.trigger("change");
      } else {
        Swal.fire({
          icon: "warning",
          title: "Advertencia",
          text: "Alumno sin cronograma de Pagos",
          timer: 3000,
          showConfirmButton: true,
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});
//vista para editar RegistroPago
$(".dataTablePagos").on("click", ".btnEditarPago", function () {
  // Obtener el código de pago del atributo del botón
  var codPago = $(this).attr("codPago");

  window.location = "index.php?ruta=editarPago&codPago=" + codPago;
});
// visualizar dato pago de alumno
$(".dataTablePagos ").on("click", ".btnVisualizarPago", function () {
  var codPago = $(this).attr("codPago");
  var data = new FormData();
  data.append("codPago", codPago);

  $.ajax({
    url: "ajax/pagos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      $("#nombresDetalle").val(response.nombresAlumno);
      $("#apellidosDetalle").val(response.apellidosAlumno);
      $("#gradoDetalle").val(response.descripcionGrado);
      $("#nivelDertalle").val(response.nivelAlumno);
      $("#codigoCajaDetalle").val(response.codAlumnoCaja);
      $("#mesDetalle").val(response.mesPago);
      $("#LimitePagoDetalle").val(response.fechaLimite);

      // Abre el modal después de recibir la respuesta
      $("#modalDetallePago").modal("show");
    },
  });
});
//Eliminar registro de pago y actualizar el estado de cronograma de pago a 1 = pendiente
$(".dataTablePagos ").on("click", ".btnEliminarPago", function () {
  var codPago = $(this).attr("codPago");
  var data = new FormData();
  data.append("codPagoDelet", codPago);

  Swal.fire({
    icon: "warning",
    title: "Advertencia",
    html: "¿Está seguro de eliminar el registro de pago? <br> <br> <strong>¡Esta acción no se podra deshacer!</strong>",
    showCancelButton: true, // Muestra el botón de cancelación
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "ajax/pagos.ajax.php",
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
              text: "Registro Eliminado correctamente",
              timer: 1000,
              showConfirmButton: false,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Error al Eliminar el Registro",
              timer: 1000,
              showConfirmButton: false,
            });
          }
          setTimeout(function () {
            location.reload();
          }, 1000);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
  });
});
