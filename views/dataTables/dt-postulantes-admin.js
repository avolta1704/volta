// Definición inicial de dataTablePostulantes
$(document).ready(function () {
  var columnDefs = [
    { data: "idPostulante" },
    { data: "nombrePostulante" },
    { data: "apellidoPostulante" },
    { data: "dniPostulante" },
    { data: "fechaPostulacion" },
    { data: "descripcionGrado" },
    { data: "statePostulante" },
    { data: "buttonsPostulante" },
  ];

  var table = $("#dataTablePostulantes").DataTable({
    columns: columnDefs,
  });

  // Titulo dataTablePostulantes
  var data = new FormData();
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
      table.clear();
      table.rows.add(response);
      table.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
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
      <th scope="col">Acciones</th>
    </tr>
    `);

  table.destroy();

  columnDefs = [
    { data: "idPostulante" },
    { data: "nombrePostulante" },
    { data: "apellidoPostulante" },
    { data: "dniPostulante" },
    { data: "fechaPostulacion" },
    { data: "descripcionGrado" },
    { data: "statePostulante" },
    { data: "buttonsPostulante" },
  ];
  table = $("#dataTablePostulantes").DataTable({
    columns: columnDefs,
  });
});
