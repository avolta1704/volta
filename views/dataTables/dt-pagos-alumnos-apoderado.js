// Definición inicial de dataTablePagosPendientesApoderadoInicio
$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();
  // Verificar si la rutaActual contiene "volta/inicio"
  if (ultimoSegmento==="inicio") {
    var columnDefsPostulantes = [
      { data: "nombresAlumno" },
      { data: "conceptoPago" },
      { data: "mesPago" },
      { data: "fechaLimite" },
      { data: "montoPago" },
      { data: "status" },
    ];

    var tablePostulantes = $(
      "#dataTablePagosPendientesApoderadoInicio"
    ).DataTable({
      columns: columnDefsPostulantes,
    });

    const datos = document.getElementById("datos");
    var idAlumno = datos.getAttribute("data-primer-id-alumno");

    //Solicitud ajx inicial de dataTablePostulantesAdmin
    var data = new FormData();
    data.append("idAlumnoApoderadoPagosPendientes", idAlumno);

    $.ajax({
      url: "ajax/inicio.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",

      success: function (response) {
        tablePostulantes.clear();
        tablePostulantes.rows.add(response);
        tablePostulantes.draw();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText); // procendecia de error
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });

    //Estructura de dataTablePostulantes
    $("#dataTablePagosPendientesApoderadoInicio thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre Alumno</th>
        <th scope="col">Tipo de Pago</th>
        <th scope="col">Mes de Pago</th>
        <th scope="col">Fecha Limite de Pago</th>
        <th scope="col">Monto</th>
        <th scope="col">Estado</th>
      </tr>
      `);

    tablePostulantes.destroy();

    columnDefsPostulantes = [
      {
        data: "null",
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
      { data: "nombresAlumno" },
      { data: "conceptoPago" },
      { data: "mesPago" },
      { data: "fechaLimite" },
      { data: "montoPago" },
      { data: "status" },
    ];
    tablePostulantes = $("#dataTablePagosPendientesApoderadoInicio").DataTable({
      columns: columnDefsPostulantes,
      language: {
        url: "views/dataTables/Spanish.json",
      },
    });
  }
});
