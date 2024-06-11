// Definición inicial de dataTableApoderado
$(document).ready(function () {
  var columnDefsApoderado = [
    { data: "nombreApoderado" },
    { data: "apellidoApoderado" },
    { data: "tipoApoderado" },
    { data: "celularApoderado" },
    { data: "correoApoderado" },
    { data: "convivenciaAlumno" },
    { data: "buttons" },
  ];

  var tableApoderado = $("#dataTableApoderado").DataTable({
    columns: columnDefsApoderado,
  });

  // Titulo dataTableApoderado
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
      console.log(jqXHR.responseText); // procendecia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });

  //Estructura de dataTableApoderado
  $("#dataTableApoderado thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Tipo</th>
      <th scope="col">Celular</th>
      <th scope="col">Correo</th>
      <th scope="col">Convivencia Alumno</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

  tableApoderado.destroy();

  columnDefsApoderado = [
    {
      data: null,
      render: function (data, type, row, meta) {
        return meta.row + meta.settings._iDisplayStart + 1;
      },
    },
    { data: "nombreApoderado" },
    { data: "apellidoApoderado" },
    { data: "tipoApoderado" },
    { data: "celularApoderado" },
    { data: "correoApoderado" },
    { data: "convivenciaAlumno" },
    { data: "buttons" },
  ];
  tableApoderado = $("#dataTableApoderado").DataTable({
		columns: columnDefsApoderado,
		language: {
			url: "views/dataTables/Spanish.json",
		},
  });
});
