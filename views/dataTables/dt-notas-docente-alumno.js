$(document).ready(function () {
  $(".tituloNotaAlumnoDocente").text("Notas");
  var codAlumno = $(this).attr("codAlumno");

  var columnDefsCursosPorGrado = [
    { data: "descripcionCurso", width: "350px" },
    { data: "nota_unidad_i", width: "100px", className: "text-center" },
    { data: "nota_unidad_ii", width: "100px", className: "text-center" },
    { data: "nota_unidad_iii", width: "100px", className: "text-center" },
    { data: "nota_unidad_iv", width: "100px", className: "text-center" },
    { data: "nota_unidad_v", width: "100px", className: "text-center" },
    { data: "nota_unidad_vi", width: "100px", className: "text-center" },
    { data: "nota_unidad_vii", width: "100px", className: "text-center" },
    { data: "nota_unidad_viii", width: "100px", className: "text-center" },
  ];

  var tableCursosPorGrado = $("#dataTableNotasPorAlumnoApoderado").DataTable({
    columns: columnDefsCursosPorGrado,
    retrieve: true,
    paging: false,
    destroy: true,
    ordering: false, // Desactiva el ordenamiento
    language: {
      url: "views/dataTables/Spanish.json",
    },
    rowCallback: function (row, data) {
      if (data.descripcionCurso === "PROMEDIO BIMESTRE") {
        $(row).css("font-weight", "bold");
      }
    },
  });

  var data = new FormData();
  data.append("idCursoAlumnoNotasDocente", 13);
  data.append("idGradoAlumnoNotasDocente", 4);
  data.append("idPersonalAlumnoNotasDocente", 4);

  $.ajax({
    url: "ajax/notas.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      // Actualizar la información del alumno en el modal
      $("#idAlumno").text(response[0]["idCurso"]);
      $("#nombreAlumno").text(
        response[0]["descripcionCurso"]
      );
      $("#nivelAlumno").text(response[0]["descripcionNivel"]);
      $("#gradoAlumno").text(response[0]["descripcionGrado"]);
      var formattedData = [];
      response.forEach(function (item) {
        var cursoData = {
          descripcionCurso: item.nombresAlumno + " " + item.apellidosAlumno,
          nota_unidad_i: item.nota_unidad_i || " ",
          nota_unidad_ii: item.nota_unidad_ii || " ",
          nota_unidad_iii: item.nota_unidad_iii || " ",
          nota_unidad_iv: item.nota_unidad_iv || " ",
          nota_unidad_v: item.nota_unidad_v || " ",
          nota_unidad_vi: item.nota_unidad_vi || " ",
          nota_unidad_vii: item.nota_unidad_vii || " ",
          nota_unidad_viii: item.nota_unidad_viii || " ",
          nota_bimestre_i: item.nota_bimestre_i || " ",
          nota_bimestre_ii: item.nota_bimestre_ii || " ",
          nota_bimestre_iii: item.nota_bimestre_iii || " ",
          nota_bimestre_iv: item.nota_bimestre_iv || " ",
        };
        formattedData.push(cursoData);

        // Asignar promedio al final de cada curso
        var promedioBimestre = {
          descripcionCurso: "PROMEDIO BIMESTRE",
          nota_unidad_i: "",
          nota_unidad_ii: item.nota_bimestre_i || " ",
          nota_unidad_iii: "",
          nota_unidad_iv: item.nota_bimestre_ii || " ",
          nota_unidad_v: "",
          nota_unidad_vi: item.nota_bimestre_iii || " ",
          nota_unidad_vii: "",
          nota_unidad_viii: item.nota_bimestre_iv || " ",
        };
        formattedData.push(promedioBimestre);
      });

      tableCursosPorGrado.clear();
      tableCursosPorGrado.rows.add(formattedData);
      tableCursosPorGrado.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });

  $("#dataTableNotasPorAlumnoApoderado thead").html(`
      <tr>
          <th rowspan="2" width="400px" style="text-align: center;">Alumno</th> <!-- Añadir width y centrar aquí -->
          <th colspan="2" style="text-align: center;">I BIMESTRE</th>
          <th colspan="2" style="text-align: center;">II BIMESTRE</th>
          <th colspan="2" style="text-align: center;">III BIMESTRE</th>
          <th colspan="2" style="text-align: center;">IV BIMESTRE</th>
      </tr>
      <tr>
          <th style="text-align: center;">I UNIDAD</th>
          <th style="text-align: center;">II UNIDAD</th>
          <th style="text-align: center;">III UNIDAD</th>
          <th style="text-align: center;">IV UNIDAD</th>
          <th style="text-align: center;">V UNIDAD</th>
          <th style="text-align: center;">VI UNIDAD</th>
          <th style="text-align: center;">VII UNIDAD</th>
          <th style="text-align: center;">VIII UNIDAD</th>
      </tr>
  `);
});
