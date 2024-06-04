// Definición inicial de dataTableCursosPorGrado
$("#thirdButtonContainer").on("click", "#btnVerCompetencias", function () {
  var idUnidad = $(this).data("idUnidad"); // Obtener idUnidad
  var idBimestre = $(this).data("idBimestre"); // Obtener idBimestre

  // Asignar idGrado a un atributo del btnAsignarNuevoCurso
  $("#btnAgregarCompetencia").attr("idUnidad", idUnidad);
  $("#btnDuplicarCompetencia").attr("idUnidad", idUnidad);

  // Definición de columnas
  var columnDefsCursosPorGrado = [
    { data: "descripcionCompetencia" },
    { data: "buttons" },
  ];

  // Inicialización de dataTableCursosPorGrado
  var tableCursosPorGrado = $("#dataTableCompetencias").DataTable({
    columns: columnDefsCursosPorGrado,
    retrieve: true,
    paging: false,
  });

  var data = new FormData();
  data.append("idUnidad", idUnidad);

  $.ajax({
    url: "ajax/unidad.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      tableCursosPorGrado.clear();
      tableCursosPorGrado.rows.add(response);
      tableCursosPorGrado.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // procendecia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });

  // Estructura de dataTableCursosPorGrado
  $("#dataTableCompetencias thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre Competencia</th>
        <th scope="col">Acciones</th>
      </tr>
    `);

  tableCursosPorGrado.destroy();

  columnDefsCursosPorGrado = [
    {
      data: "null",
      render: function (data, type, row, meta) {
        return meta.row + 1;
      },
    },
    { data: "descripcionCompetencia" },
    { data: "buttons" },
  ];

  tableCursosPorGrado = $("#dataTableCompetencias").DataTable({
    columns: columnDefsCursosPorGrado,
  });
});
