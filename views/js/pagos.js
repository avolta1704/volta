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
        // Limpia el cuerpo del modal
        var modalBody = $("#cronogramaAdmisionPago .modal-body");
        modalBody.empty();
        // Por cada elemento en la respuesta
        $.each(response, function (index, item) {
          // Crea un nuevo div
          var div = $("<div>").addClass("mb-3");
          // Crea las etiquetas
          var date = new Date(item.mesPago);
          var month = date.toLocaleString("es-ES", { month: "long" });
          month = month.charAt(0).toUpperCase() + month.slice(1);
          var label1 = $("<label>")
            .addClass("form-label h5 font-weight-bold")
            .attr("id", "mesCronoPago")
            .attr("name", "mesCronoPago")
            .text(month + " - ");
          var label2 = $("<label>")
            .addClass("form-label h5 font-weight-bold")
            .attr("id", "tipoCronoPago")
            .attr("name", "tipoCronoPago")
            .text(" - " + item.conceptoPago);
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
          div.append(label1, label2, inputGroup);
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

// vista de pagos buscar alumno por el dni
$(".formPagoAlumno").on("click", ".btnBuscarDniAlumno", function () {
  var dniAlumno = $("#dniAlumno").val();
  var data = new FormData();
  data.append("dniAlumno", dniAlumno);
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
        $("#codCajaPago").val(response.codAlumnoCaja);
        $("#anioPago").val(new Date().getFullYear());
        $("#nivelAlumnoPago").val(response.nivelAlumno);
        $("#gradoAlumnoPago").val(response.descripcionGrado);
        // Llena el select con las opciones correspondientes de cada array de cronogramaPago
        var select = $("#cronogramaPago");
        select.empty();
        $.each(response.cronogramaPago, function (index, cronograma) {
          if (cronograma.estadoCronograma == 1) {
            // Solo agrega la opción si el estado es 1=pendiente
            var date = new Date(cronograma.mesPago);
            var monthNames = [
              "Enero",
              "Febrero",
              "Marzo",
              "Abril",
              "Mayo",
              "Junio",
              "Julio",
              "Agosto",
              "Septiembre",
              "Octubre",
              "Noviembre",
              "Diciembre",
            ];
            var month = monthNames[date.getMonth()];
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
          title: "Adveterencia",
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
      $("#mesDetalle").val(response.mesPagoDet);
      $("#LimitePagoDetalle").val(response.fechaLimite);

      // Abre el modal después de recibir la respuesta
      $("#modalDetallePago").modal('show');
    },
  });
});

//Eliminar registro de pago
$(document).ready(function () {
  $(".dataTableAdmisionAlumnos").on(
    "click",
    ".btnEditarEstadoAdmisionAlumno",
    function () {
      var btn = $(this);
      btn.prop("disabled", true); // Deshabilitar el botón
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
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
  );
});

/* 
// Verifica si los datos existen y, de ser así, los encripta y guarda
var codPago = $(".btnEditarPago").attr("codPago");
var dniAlumno = $(".btnEditarPago").attr("dniAlumno");
var tipoPago = $(".btnEditarPago").attr("tipoPago");
var estadoPago = $(".btnEditarPago").attr("estadoPago");
var metodoPago = $(".btnEditarPago").attr("metodoPago");
if (codPago && dniAlumno && tipoPago && estadoPago && metodoPago) {
  encriptarYGuardar(codPago, dniAlumno, tipoPago, estadoPago, metodoPago);
}
// Vista de pagos editar alumno por el DNI
$(document).ready(function () {
  // Obtiene los valores codificados de localStorage
  var codPagoCodificado = localStorage.getItem("codPago");
  var dniAlumnoCodificado = localStorage.getItem("dniAlumno");
  var tipoPagoCodificado = localStorage.getItem("tipoPago");
  var estadoPagoCodificado = localStorage.getItem("estadoPago");
  var metodoPagoCodificado = localStorage.getItem("metodoPago");

  // Decodifica los valores
  var codPago = atob(codPagoCodificado);
  var dniAlumno = atob(dniAlumnoCodificado);
  var tipoPago = atob(tipoPagoCodificado);
  var estadoPago = atob(estadoPagoCodificado);
  var metodoPago = atob(metodoPagoCodificado);
  // Verifica si los valores existen
  if (codPago && dniAlumno) {
    // Inicia la solicitud AJAX
    var data = new FormData();
    data.append("dniAlumno", dniAlumno);

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
          $("#apellidoAlumnoPagoEdit").val(response.apellidosAlumno);
          $("#nombreAlumnoPagoEdit").val(response.nombresAlumno);
          $("#dniAlumnoEdit").val(response.dniAlumno);
          $("#codCajaPagoEdit").val(response.codAlumnoCaja);
          $("#anioPago").val(new Date().getFullYear());
          $("#nivelAlumnoPagoEdit").val(response.nivelAlumno);
          $("#gradoAlumnoPagoEdit").val(response.descripcionGrado);
          $("#btnIdRegistroEdir").val(codPago);
          $("#formatipoPagoEditEdit").val(tipoPago);
          $("#estadoPagoEdit").val(estadoPago);
          $("#metodoPagoEdit").val(metodoPago);

          // Llena el select con las opciones correspondientes de cada array de cronogramaPago
          var select = $("#cronogramaPagoEdit");
          select.empty();
          $.each(response.cronogramaPago, function (index, cronograma) {
            if (cronograma.estadoCronograma) {
              // Solo agrega la opción si el estado es 1=pendiente
              var date = new Date(cronograma.mesPago);
              var monthNames = [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
              ];
              var month = monthNames[date.getMonth()];
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
            $("#fechaLimitePagoEdit").val(selectedCronograma.fechaLimite);
            $("#tipoPagoEdit").val(selectedCronograma.conceptoPago);
            $("#montoPagoEdit").val(selectedCronograma.montoPago);
          });
          // Dispara el evento change para llenar los campos con los datos del array en cronogramaPago seleccionado
          select.trigger("change");
        } else {
          Swal.fire({
            icon: "warning",
            title: "Adveterencia",
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
  }
});
 */
