// Definición inicial de dataTablePagos
$(document).ready(function () {
  var columnDefsPagos = [
    { data: "idAlumno" },
    { data: "nombresAlumno" },
    { data: "apellidosAlumno" },
    { data: "sexoAlumno" },
    { data: "stateAlumno" },
    { data: "descripcionGrado" },
    { data: "descripcionNivel" },
    { data: "buttonsAlumno" },
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
        <th scope="col">Apellidos</th>
        <th scope="col">Nombres</th>
        <th scope="col">Sexo</th>
        <th scope="col">Estado</th>
        <th scope="col">Nivel</th>
        <th scope="col">Grado</th>
        <th scope="col">Acciones</th>
      </tr>
    `);

  table.destroy();

  columnDefsPagos = [
    { data: "idAlumno" },
    { data: "nombresAlumno" },
    { data: "apellidosAlumno" },
    { data: "sexoAlumno" },
    { data: "stateAlumno" },
    { data: "descripcionGrado" },
    { data: "descripcionNivel" },
    { data: "buttonsAlumno" },
  ];
  tablePagos = $("#dataTablePagos").DataTable({
    columns: columnDefsPagos,
  });
});
