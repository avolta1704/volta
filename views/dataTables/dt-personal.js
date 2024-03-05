// Definición inicial de dataTablePersonal
$(document).ready(function () {
  var columnDefs = [
    { data: "idPersonal" },
    { data: "nombrePersonal" },
    { data: "apellidoPersonal" },
    { data: "correoPersonal" },
    { data: "celularPersonal" },
    { data: "fechaContratacion" },
    { data: "tipe" },
    /* { data: "buttons" }, */
  ];

  var table = $("#dataTablePersonal").DataTable({
    columns: columnDefs,
  });

  // Titulo dataTablePersonal
  var data = new FormData();
  $(".tituloPersonal").text("Personal");

  //Solicitud inicial de dataTablePersonal
  var data = new FormData();
  data.append("todoElPersonal", true);

  $.ajax({
    url: "ajax/personal.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      table.clear();
      table.rows.add(response);
      table.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });

  //Estructura de dataTablePersonal
  $("#dataTablePersonal thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Correo</th>
      <th scope="col">Celular</th>
      <th scope="col">Fecha Ingreso</th>
      <th scope="col">Cargo</th>
    </tr>
    `);

  table.destroy();

  columnDefs = [
    { data: "idPersonal" },
    { data: "nombrePersonal" },
    { data: "apellidoPersonal" },
    { data: "correoPersonal" },
    { data: "celularPersonal" },
    { data: "fechaContratacion" },
    { data: "tipe" },
    /* { data: "buttons" }, */
  ];
  table = $("#dataTablePersonal").DataTable({
    columns: columnDefs,
  });
});
