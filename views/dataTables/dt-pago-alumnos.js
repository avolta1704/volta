// Definición inicial de dataTablePagoAlumnos
$(document).ready(function () {
  var columnDefPagoAlumnos = [
    {
      data: "null",
      render: function (data, type, row, meta) {
        return meta.row + 1;
      },
    },
    { data: "codAlumnoCaja" },
    { data: "dniAlumno" },
    { data: "apellidosAlumno" },
    { data: "nombresAlumno" },
    { data: "estadoAlPag" },
    { data: "btnPagoAlumnos" },
  ];

  var tablePagoAlumnos = $("#dataTablePagoAlumnos").DataTable({
    columns: columnDefPagoAlumnos,
  });

  // Titulo dataTablePagoAlumnos
  var data = new FormData();
  $(".tituloPagoAlumnos").text("Registros Alumnos Pago");

  //Solicitud ajx inicial de dataTablePagoAlumnosAdmin
  var data = new FormData();
  data.append("registroPagoAlumnos", true);

  $.ajax({
    url: "ajax/pagoAlumnos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      tablePagoAlumnos.clear();
      tablePagoAlumnos.rows.add(response);
      tablePagoAlumnos.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });

  //Estructura de dataTablePagoAlumnos
  $("#dataTablePagoAlumnos thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Código Caja</th>
        <th scope="col">Dni</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Nombres</th>
        <th scope="col">Estado</th>
        <th scope="col">Aciones</th>
      </tr>
    `);

  tablePagoAlumnos.destroy();

  columnDefPagoAlumnos = [
    {
      data: "null",
      render: function (data, type, row, meta) {
        return meta.row + 1;
      },
    },
    { data: "codAlumnoCaja" },
    { data: "dniAlumno" },
    { data: "apellidosAlumno" },
    { data: "nombresAlumno" },
    { data: "estadoAlPag" },
    { data: "btnPagoAlumnos" },
  ];

  var tablePagoAlumnos = $("#dataTablePagoAlumnos").DataTable({
    columns: columnDefPagoAlumnos,
  });
});
