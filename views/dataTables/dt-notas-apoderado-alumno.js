$("#dataTableNotasAlumnoApoderado").on(
  "click",
  ".btnVisualizarNotaApoderado",
  function () {
    var codAlumno = $(this).attr("codAlumno");

    // Generar encabezados dinámicamente
    var tableHeaderHtml = `
        <thead>
            <tr>
                <th rowspan="2">CURSOS</th>
                <th colspan="2">I BIMESTRE</th>
                <th colspan="2">II BIMESTRE</th>
                <th colspan="2">III BIMESTRE</th>
                <th colspan="2">IV BIMESTRE</th>
            </tr>
            <tr>
                <th>I UNIDAD</th>
                <th>II UNIDAD</th>
                <th>III UNIDAD</th>
                <th>IV UNIDAD</th>
                <th>V UNIDAD</th>
                <th>VI UNIDAD</th>
                <th>VII UNIDAD</th>
                <th>VIII UNIDAD</th>
            </tr>
        </thead>
    `;
    $("#dataTableNotasPorAlumnoApoderado").html(tableHeaderHtml);

    // Verificar si DataTable ya está inicializado
    if (!$.fn.DataTable.isDataTable("#dataTableNotasPorAlumnoApoderado")) {
      // Definición de columnas para DataTable
      var columnDefsCursosPorGrado = [
        { data: "descripcionCurso" },
        { data: "I_UNIDAD" },
        { data: "II_UNIDAD" },
        { data: "III_UNIDAD" },
        { data: "IV_UNIDAD" },
        { data: "V_UNIDAD" },
        { data: "VI_UNIDAD" },
        { data: "VII_UNIDAD" },
        { data: "VIII_UNIDAD" },
      ];

      // Inicialización de dataTableCursosPorGrado
      var tableCursosPorGrado = $(
        "#dataTableNotasPorAlumnoApoderado"
      ).DataTable({
        columns: columnDefsCursosPorGrado,
        retrieve: true,
        paging: false,
        order: [[0, "desc"]], // Ordenar por la primera columna (CURSOS) de forma ascendente por defecto
      });
    }

    var data = new FormData();
    data.append("idAlumnoNotasApoderado", codAlumno);

    $.ajax({
      url: "ajax/notas.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        // Procesar la respuesta a la estructura deseada
        const processedData = processResponse(response);
        tableCursosPorGrado.rows.add(processedData).draw();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText); // Origen del error
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });

    function processResponse(response) {
      const groupedData = {};

      // Agrupar por curso y procesar datos
      response.forEach((item) => {
        const curso = item.descripcionCurso;
        const bimestre = item.descripcionBimestre;

        if (!groupedData[curso]) {
          groupedData[curso] = {
            descripcionCurso: curso,
            unidades: {
              I_UNIDAD: "",
              II_UNIDAD: "",
              III_UNIDAD: "",
              IV_UNIDAD: "",
              V_UNIDAD: "",
              VI_UNIDAD: "",
              VII_UNIDAD: "",
              VIII_UNIDAD: "",
            },
            promedios: {
              "I BIMESTRE": "",
              "II BIMESTRE": "",
              "III BIMESTRE": "",
              "IV BIMESTRE": "",
            },
          };
        }

        // Asignar nota de unidad
        const unidadKey =
          item.descripcionUnidad.replace(" UNIDAD", "") + "_UNIDAD";
        groupedData[curso].unidades[unidadKey] = item.notaUnidad;

        // Asignar promedio bimestral
        if (item.notaBimestre !== null && item.notaBimestre !== undefined) {
          groupedData[curso].promedios[bimestre] = item.notaBimestre;
        }
      });

      // Preparar el array final de datos para DataTable
      const finalData = [];

      // Recorrer los cursos agrupados y generar la estructura final
      for (let curso in groupedData) {
        const cursoData = groupedData[curso];

        finalData.push({
          descripcionCurso: cursoData.descripcionCurso,
          I_UNIDAD: cursoData.unidades.I_UNIDAD,
          II_UNIDAD: cursoData.unidades.II_UNIDAD,
          III_UNIDAD: cursoData.unidades.III_UNIDAD,
          IV_UNIDAD: cursoData.unidades.IV_UNIDAD,
          V_UNIDAD: cursoData.unidades.V_UNIDAD,
          VI_UNIDAD: cursoData.unidades.VI_UNIDAD,
          VII_UNIDAD: cursoData.unidades.VII_UNIDAD,
          VIII_UNIDAD: cursoData.unidades.VIII_UNIDAD,
        });

        // Agregar la fila de promedio bimestral al final de cada curso
        finalData.push({
          descripcionCurso: "<b>Promedio Bimestre</b>",
          I_UNIDAD: `<td colspan="2">${cursoData.promedios["I BIMESTRE"]}</td>`,
          II_UNIDAD: ``,
          III_UNIDAD: `<td colspan="2">${cursoData.promedios["II BIMESTRE"]}</td>`,
          IV_UNIDAD: ``,
          V_UNIDAD: `<td colspan="2">${cursoData.promedios["III BIMESTRE"]}</td>`,
          VI_UNIDAD: "",
          VII_UNIDAD: `<td colspan="2">${cursoData.promedios["IV BIMESTRE"]}</td>`,
          VIII_UNIDAD: "",
        });
      }

      return finalData;
    }
  }
);
