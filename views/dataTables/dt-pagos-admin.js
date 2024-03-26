// Definición inicial de dataTablePagos
$(document).ready(function () {
  var columnDefsPagos = [
    {
      data: "null",
      render: function (data, type, row, meta) {
        return meta.row + 1;
      },
    },
    { data: "dniAlumno" },
    { data: "tipoPago" },
    { data: "fechaPago" },
    { data: "metodoPago" },
    { data: "cantidadTotal" },
    { data: "statePago" },
    { data: "buttonsPago" },
  ];

  var tablePagos = $("#dataTablePagos").DataTable({
    columns: columnDefsPagos,
  });

  // Titulo dataTablePagos
  var data = new FormData();
  $(".tituloPagos").text("Todos los Pagos");

  //Solicitud ajx inicial de dataTablePagosAdmin
  var data = new FormData();
  data.append("todosLosPagosAdmin", true);
  $.ajax({
    url: "ajax/pagos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      tablePagos.clear();
      tablePagos.rows.add(response);
      tablePagos.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });

  //Estructura de dataTablePagos
  $("#dataTablePagos thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Dni</th>
        <th scope="col">Tipo Pago</th>
        <th scope="col">Fecha Pago</th>
        <th scope="col">Forma Pago</th>
        <th scope="col">Monto</th>
        <th scope="col">Estado</th>
        <th scope="col">Acciones</th>
      </tr>
    `);

  tablePagos.destroy();

  columnDefsPagos = [
    {
      data: "null",
      render: function (data, type, row, meta) {
        return meta.row + 1;
      },
    },
    { data: "dniAlumno" },
    { data: "tipoPago" },
    { data: "fechaPago" },
    { data: "metodoPago" },
    { data: "cantidadTotal" },
    { data: "statePago" },
    { data: "buttonsPago" },
  ];
  tablePagos = $("#dataTablePagos").DataTable({
    columns: columnDefsPagos,
  });
});
