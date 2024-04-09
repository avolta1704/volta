
//  crear nuevo Comunicadopago
$(".dataTableComunicadoPago").on("click", ".btnComunicadoPago", function () {
    var codAdAlumCronograma = $(this).attr('codAdAlumCronograma');
    var codAlumno = $(this).attr('codAlumno');
    Swal.fire({
        icon: "info",
        title: "Registrara un comunicado de Pago",
        html: "<strong>Continuar</strong>",
        showCancelButton: true, // Muestra el botón de cancelación
        confirmButtonText: "Sí",
        cancelButtonText: "No",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "index.php?ruta=registrarComunicadoPago&codAdAlumCronograma=" + codAdAlumCronograma + "&codAlumno=" + codAlumno;
        }
    });
});
/* <!-- registrar modal comunicado --> */
/* echo '<button class="btn btn-warning btnCronoCumunicado" data-bs-toggle="modal" data-bs-target="#comunicadoModal" cronogramaPago="' . $idCronogramaPago . '">Registrar Comunicado</button>'; */
$(".dataTableComunicadoPago").on("click", ".btnCronoCumunicado", function (event) {
  event.stopPropagation();
  var cronogramaPago = $(this).attr("cronogramaPago");
  var data = new FormData();

  data.append("cronogramaPago", cronogramaPago);
  $.ajax({
    url: "ajax/alumnoss.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {

  
    },
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
