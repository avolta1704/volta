$(".alumno-item").click(function () {
  // Obtener el idAlumno del elemento clickeado
  var idAlumno = $(this).data("id-alumno");
  /*   datos.setAttribute('data-primer-id-alumno', idAlumno);
  // Recargar la página
  location.reload(); */
  // Actualizar la tabla con el nuevo idAlumno
  actualizarTablaConNuevoIdAlumno(idAlumno);
});
$(document).ready(function () {});

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
      var tablePostulantes = $("#dataTablePagosPendientesApoderadoInicio").DataTable();
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
