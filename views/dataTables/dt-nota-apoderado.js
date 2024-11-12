// Definición inicial de dataTablePersonalInicio
$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();
  if (ultimoSegmento==="notasApoderado") {
    // Titulo dataTablePostulantes
    $(".tituloNotaAlumno").text("Notas Alumno");
    var columnDefsPersonal = [
      {
        data: "null",
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
      { data: "nombre_completo" },
      { data: "descripcionNivel" },
      { data: "descripcionGrado" },
      { data: "status" },
      { data: "acciones" },
    ];

    var tablePersonalInicio = $("#dataTableNotasAlumnoApoderado").DataTable({
      columns: columnDefsPersonal,
    });

    //Solicitud ajx inicial de dataTablePersonalInicio
    var data = new FormData();
    data.append("idUsuarioAlumnoNotasApoderado", ipConfirmacion);

    $.ajax({
      url: "ajax/notas.ajax.php",
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
    $("#dataTableNotasAlumnoApoderado thead").html(`
		<tr>
      <th scope="col">#</th>
      <th scope="col">Nombres Alumno</th>
      <th scope="col">Nivel</th>
      <th scope="col">Grado</th>
      <th scope="col">Estado</th>
      <th scope="col">Acciones</th>
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
      { data: "nombre_completo" },
      { data: "descripcionNivel" },
      { data: "descripcionGrado" },
      { data: "status" },
      { data: "acciones" },
    ];
    tablePersonalInicio = $("#dataTableNotasAlumnoApoderado").DataTable({
      columns: columnDefsPersonal,
      language: {
        url: "views/dataTables/Spanish.json",
      },
    });
  }
});
