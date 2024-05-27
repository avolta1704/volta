// Definición inicial de dataTablePostulantes
$(document).ready(function () {
  var columnDefsPostulantes = [
    { data: "idPostulante" },
    { data: "nombrePostulante" },
    { data: "apellidoPostulante" },
    { data: "dniPostulante" },
    { data: "fechaPostulacion" },
    { data: "descripcionGrado" },
    { data: "statePostulante" },
    { data: "pagoMatricula" },
    { data: "buttonsPostulante" },
  ];

  var tablePostulantes = $("#dataTablePostulantes").DataTable({
    columns: columnDefsPostulantes,
  });

  // Titulo dataTablePostulantes
  $(".tituloPostulantes").text("Todos los Postulantes");

  //Solicitud ajx inicial de dataTablePostulantesAdmin
  var data = new FormData();
  data.append("todosLosPostulantesAdmin", true);

  $.ajax({
    url: "ajax/postulantes.ajax.php",
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
  $("#dataTablePostulantes thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">DNI</th>
      <th scope="col">Fecha Postulación</th>
      <th scope="col">Grado Postulación</th>
      <th scope="col">Estado</th>
      <th scope="col">Matricula</th>
      <th scope="col">Acciones</th>
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
    { data: "nombrePostulante" },
    { data: "apellidoPostulante" },
    { data: "dniPostulante" },
    { data: "fechaPostulacion" },
    { data: "descripcionGrado" },
    { data: "statePostulante" },
    { data: "pagoMatricula" },
    { data: "buttonsPostulante" },
  ];
  tablePostulantes = $("#dataTablePostulantes").DataTable({
    columns: columnDefsPostulantes,
  });
});
