// Definición inicial de dataTablePersonal
$(document).ready(function () {
  var columnDefsPersonal = [
    { data: "idPersonal" },
    { data: "nombrePersonal" },
    { data: "apellidoPersonal" },
    { data: "correoPersonal" },
    { data: "celularPersonal" },
    { data: "fechaContratacion" },
    { data: "tipe" },
    { data: "buttons" },
  ];

  var tablePersonal = $("#dataTablePersonal").DataTable({
    columns: columnDefsPersonal,
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
      tablePersonal.clear();
      tablePersonal.rows.add(response);
      tablePersonal.draw();
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
      <th scope="col">Acciones</th>
    </tr>
    `);

  tablePersonal.destroy();

  columnDefsPersonal = [
    { data: "idPersonal" },
    { data: "nombrePersonal" },
    { data: "apellidoPersonal" },
    { data: "correoPersonal" },
    { data: "celularPersonal" },
    { data: "fechaContratacion" },
    { data: "tipe" },
    { data: "buttons" },
  ];
  tablePersonal = $("#dataTablePersonal").DataTable({
    columns: columnDefsPersonal,
  });
});
