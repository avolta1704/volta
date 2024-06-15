// Definición inicial de dataTablePersonalInicio
$(document).ready(function () {
  var columnDefsPersonal = [
    {
      data: "null",
      render: function (data, type, row, meta) {
        return meta.row + 1;
      },
    },
    { data: "apellidoPersonal" },
    { data: "nombrePersonal" },
    { data: "correoPersonal" },
    { data: "descripcionTipo" },
    { data: "ultimaConexion" },
    { data: "state" },
  ];

  var tablePersonalInicio = $("#dataTablePersonalInicio").DataTable({
    columns: columnDefsPersonal,
  });


  //Solicitud ajx inicial de dataTablePersonalInicio
  var data = new FormData();
  data.append("personalInicio", true);

  $.ajax({
    url: "ajax/inicio.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      tablePersonalInicio.clear();
      tablePersonalInicio.rows.add(response);
      tablePersonalInicio.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // procendecia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });

  //Estructura de dataTablePersonalInicio
  $("#dataTablePersonalInicio thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Nombres</th>
        <th scope="col">Correo</th>
        <th scope="col">Tipo de Personal</th>
        <th scope="col">Ultima Conexión</th>
        <th scope="col">Estado</th>
      </tr>
    `);

  tablePersonalInicio.destroy();

  columnDefsPersonal = [
    {
      data: "null",
      render: function (data, type, row, meta) {
        return meta.row + 1;
      },
    },
    { data: "apellidoPersonal" },
    { data: "nombrePersonal" },
    { data: "correoPersonal" },
    { data: "descripcionTipo" },
    { data: "ultimaConexion" },
    { data: "state" },
  ];
  tablePersonalInicio = $("#dataTablePersonalInicio").DataTable({
    columns: columnDefsPersonal,
    language: {
      url: "views/dataTables/Spanish.json",
    },
  });
});
