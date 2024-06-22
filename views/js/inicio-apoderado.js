$(".alumno-item").click(function () {
  // Obtener el idAlumno del elemento clickeado
  var idAlumno = $(this).data("id-alumno");
  /*   datos.setAttribute('data-primer-id-alumno', idAlumno);
  // Recargar la página
  location.reload(); */
  // Actualizar la tabla con el nuevo idAlumno
  actualizarTablaConNuevoIdAlumno(idAlumno);
  obtenerProximaFechaPagoApoderado(idAlumno);
});
$(document).ready(function () {
  const datos = document.getElementById("datos");
  var idAlumno = datos.getAttribute("data-primer-id-alumno");
  var fechaLimitePago = [];
  var mesPago = [];
  // Función para obtener la fecha de pago proxima
  function obtenerProximaFechaPagoApoderado(idAlumno) {
    var data = new FormData();
    data.append("idAlumnoApoderadoFechaPago", idAlumno);

    $.ajax({
      url: "ajax/inicio.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        response.forEach(function (fila) {
          fechaLimitePago.push(fila.proximaFechaPago);
          mesPago.push(fila.mesPago);
        });
        actualizarDatosProximaFechaPago(0);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }

  // Función para actualizar los datos de fecha de pago
  function actualizarDatosProximaFechaPago(indice) {
    const filtroSeleccionado = $(".filtro-seleccionado-mes-pago-apoderado");
    const fechaPago = $(".proxima-fecha");

    filtroSeleccionado.text("| " + mesPago[indice]);

    // Parsear la fecha desde el formato yy-mm-dd
    const fecha = new Date(fechaLimitePago[indice]);
    const opciones = { year: "numeric", month: "long", day: "numeric" };
    const fechaFormateada = fecha.toLocaleDateString("es-ES", opciones);

    fechaPago.text(fechaFormateada);
  }
  obtenerProximaFechaPagoApoderado(idAlumno);
});

function actualizarTablaConNuevoIdAlumno($idAlumno) {
  // Preparar los datos para la solicitud AJAX
  var data = new FormData();
  data.append("idAlumnoApoderadoPagosPendientes", $idAlumno);

  // Realizar la solicitud AJAX
  $.ajax({
    url: "ajax/inicio.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      // Obtener la instancia de DataTable
      var tablePostulantes = $(
        "#dataTablePagosPendientesApoderadoInicio"
      ).DataTable();
      // Limpiar los datos actuales de la tabla
      tablePostulantes.clear();
      // Añadir los nuevos datos a la tabla
      tablePostulantes.rows.add(response);
      // Redibujar la tabla con los nuevos datos
      tablePostulantes.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // Procedencia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
}
