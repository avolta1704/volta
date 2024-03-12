// Definición inicial de dataTableApoderado
$(document).ready(function () {
  var columnDefsApoderado = [
    { data: "idApoderado" },
    { data: "nombreApoderado" },
    { data: "apellidoApoderado" },
    { data: "tipe" },
    { data: "numeroApoderado" },
    { data: "correoApoderado" },
    { data: "listaAlumnos" },
    { data: "convivenciaAlumno" },
    { data: "buttons" },
  ];

  var tableApoderado = $("#dataTableApoderado").DataTable({
    columns: columnDefsApoderado,
  });

  // Titulo dataTableApoderado
  var data = new FormData();
  $(".tituloApoderado").text("Apoderados");

  //Solicitud inicial de dataTableApoderado
  var data = new FormData();
  data.append("todosLosApoderados", true);

  $.ajax({
    url: "ajax/apoderado.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      tableApoderado.clear();
      tableApoderado.rows.add(response);
      tableApoderado.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });

  //Estructura de dataTableApoderado
  $("#dataTableApoderado thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Apoderado</th>
      <th scope="col">Celular</th>
      <th scope="col">Correo</th>
      <th scope="col">Lista Alumno</th>
      <th scope="col">Comvivencia Alumno</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

  tableApoderado.destroy();

  columnDefsApoderado = [
    { data: "idApoderado" },
    { data: "nombreApoderado" },
    { data: "apellidoApoderado" },
    { data: "tipe" },
    { data: "numeroApoderado" },
    { data: "correoApoderado" },
    { data: "listaAlumnos" },
    { data: "convivenciaAlumno" },
    { data: "buttons" },
  ];
  tableApoderado = $("#dataTableApoderado").DataTable({
    columns: columnDefsApoderado,
  });
});
