// Definición inicial de dataTablePersonalInicio
$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();
  // Verificar si la rutaActual contiene "volta/inicio"
  if (ultimoSegmento==="inicio") {
    var columnDefsPersonal = [
      {
        data: "null",
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
      { data: "descripcionGrado" },
      { data: "descripcionCurso" },
      { data: "nombresAlumno" },
      { data: "apellidosAlumno" },
      { data: "descripcionCompetencia" },
      { data: "notaCompetencia" },
    ];

    var tablePersonalInicio = $("#dataTableNotaCompetenciaInicio").DataTable({
      columns: columnDefsPersonal,
    });

    //Solicitud ajx inicial de dataTablePersonalInicio
    var data = new FormData();
    data.append("idUsuarioCompetenciasNotas", true);

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
    $("#dataTableNotaCompetenciaInicio thead").html(`
        <tr>
          <th scope="col">#</th>
          <th scope="col">Grado</th>
          <th scope="col">Curso</th>
          <th scope="col">Nombre Alumno</th>
          <th scope="col">Apellidos Alumno</th>
          <th scope="col">Competencia</th>
          <th scope="col">Nota Competencia</th>
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
      { data: "descripcionGrado" },
      { data: "descripcionCurso" },
      { data: "nombresAlumno" },
      { data: "apellidosAlumno" },
      { data: "descripcionCompetencia" },
      { data: "notaCompetencia" },
    ];
    tablePersonalInicio = $("#dataTableNotaCompetenciaInicio").DataTable({
      columns: columnDefsPersonal,
      language: {
        url: "views/dataTables/Spanish.json",
      },
    });
  }
});
