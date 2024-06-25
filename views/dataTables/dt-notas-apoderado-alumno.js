$("#dataTableNotasAlumnoApoderado").on("click", ".btnVisualizarNotaApoderado", function () {
    var codAlumno = $(this).attr("codAlumno");

    // Definición de columnas
    var columnDefsCursosPorGrado = [
        { data: "descripcionCurso" },
        { data: "descripcionCompetencia" },
        { data: "I_BIMESTRE_I_UNIDAD" },
        { data: "I_BIMESTRE_II_UNIDAD" },
        { data: "II_BIMESTRE_III_UNIDAD" },
        { data: "II_BIMESTRE_IV_UNIDAD" },
        { data: "III_BIMESTRE_V_UNIDAD" },
        { data: "III_BIMESTRE_VI_UNIDAD" },
        { data: "IV_BIMESTRE_VII_UNIDAD" },
        { data: "IV_BIMESTRE_VIII_UNIDAD" },
    ];

    // Inicialización de dataTableCursosPorGrado
    var tableCursosPorGrado = $("#dataTableNotasPorAlumnoApoderado").DataTable({
        columns: columnDefsCursosPorGrado,
        retrieve: true,
        paging: false,
        destroy: true, // Permitir reinitialización
        drawCallback: function (settings) {
            mergeTableRows();
        },
    });

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
            tableCursosPorGrado.clear();
            tableCursosPorGrado.rows.add(processedData);
            tableCursosPorGrado.draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText); // Origen del error
            console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
    });

    function processResponse(response) {
        const groupedData = {};

        // Agrupar por curso y descripción de competencia
        response.forEach((item) => {
            const key = item.descripcionCurso;

            if (!groupedData[key]) {
                groupedData[key] = {
                    descripcionCurso: item.descripcionCurso,
                    competencias: {},
                    promedioUnidad: item.notaUnidad,
                    promedioBimestre: item.notaBimestre,
                };
            }

            const competenciaKey = item.descripcionCompetencia;

            if (!groupedData[key].competencias[competenciaKey]) {
                groupedData[key].competencias[competenciaKey] = {
                    descripcionCompetencia: item.descripcionCompetencia,
                    I_BIMESTRE_I_UNIDAD: "",
                    I_BIMESTRE_II_UNIDAD: "",
                    II_BIMESTRE_III_UNIDAD: "",
                    II_BIMESTRE_IV_UNIDAD: "",
                    III_BIMESTRE_V_UNIDAD: "",
                    III_BIMESTRE_VI_UNIDAD: "",
                    IV_BIMESTRE_VII_UNIDAD: "",
                    IV_BIMESTRE_VIII_UNIDAD: "",
                };
            }

            const bimestreKey = item.descripcionBimestre;
            const unidadKey = item.descripcionUnidad;

            const unidadIndex =
                unidadKey === "I UNIDAD"
                    ? "I_BIMESTRE_I_UNIDAD"
                    : unidadKey === "II UNIDAD"
                    ? "I_BIMESTRE_II_UNIDAD"
                    : unidadKey === "III UNIDAD"
                    ? "II_BIMESTRE_III_UNIDAD"
                    : unidadKey === "IV UNIDAD"
                    ? "II_BIMESTRE_IV_UNIDAD"
                    : unidadKey === "V UNIDAD"
                    ? "III_BIMESTRE_V_UNIDAD"
                    : unidadKey === "VI UNIDAD"
                    ? "III_BIMESTRE_VI_UNIDAD"
                    : unidadKey === "VII UNIDAD"
                    ? "IV_BIMESTRE_VII_UNIDAD"
                    : "IV_BIMESTRE_VIII_UNIDAD";

            groupedData[key].competencias[competenciaKey][unidadIndex] = item.notaCompetencia;
        });

        const finalData = [];

        for (let curso in groupedData) {
            const cursoData = groupedData[curso];

            for (let competenciaKey in cursoData.competencias) {
                const competencia = cursoData.competencias[competenciaKey];
                finalData.push({
                    descripcionCurso: cursoData.descripcionCurso,
                    descripcionCompetencia: competencia.descripcionCompetencia,
                    I_BIMESTRE_I_UNIDAD: competencia.I_BIMESTRE_I_UNIDAD,
                    I_BIMESTRE_II_UNIDAD: competencia.I_BIMESTRE_II_UNIDAD,
                    II_BIMESTRE_III_UNIDAD: competencia.II_BIMESTRE_III_UNIDAD,
                    II_BIMESTRE_IV_UNIDAD: competencia.II_BIMESTRE_IV_UNIDAD,
                    III_BIMESTRE_V_UNIDAD: competencia.III_BIMESTRE_V_UNIDAD,
                    III_BIMESTRE_VI_UNIDAD: competencia.III_BIMESTRE_VI_UNIDAD,
                    IV_BIMESTRE_VII_UNIDAD: competencia.IV_BIMESTRE_VII_UNIDAD,
                    IV_BIMESTRE_VIII_UNIDAD: competencia.IV_BIMESTRE_VIII_UNIDAD,
                });
            }

            // Agregar las filas de promedio al final de cada curso
            finalData.push({
                descripcionCurso: cursoData.descripcionCurso,
                descripcionCompetencia: "Promedio Unidad",
                I_BIMESTRE_I_UNIDAD: cursoData.promedioUnidad,
                I_BIMESTRE_II_UNIDAD: "",
                II_BIMESTRE_III_UNIDAD: "",
                II_BIMESTRE_IV_UNIDAD: "",
                III_BIMESTRE_V_UNIDAD: "",
                III_BIMESTRE_VI_UNIDAD: "",
                IV_BIMESTRE_VII_UNIDAD: "",
                IV_BIMESTRE_VIII_UNIDAD: "",
            });

            finalData.push({
                descripcionCurso: cursoData.descripcionCurso,
                descripcionCompetencia: "Promedio Bimestre",
                I_BIMESTRE_I_UNIDAD: "",
                I_BIMESTRE_II_UNIDAD: cursoData.promedioBimestre,
                II_BIMESTRE_III_UNIDAD: "",
                II_BIMESTRE_IV_UNIDAD: "",
                III_BIMESTRE_V_UNIDAD: "",
                III_BIMESTRE_VI_UNIDAD: "",
                IV_BIMESTRE_VII_UNIDAD: "",
                IV_BIMESTRE_VIII_UNIDAD: "",
            });
        }

        return finalData;
    }

    // Function to merge rows in DataTable
    function mergeTableRows() {
        var cursoColumnIndex = 0; // Index of the "descripcionCurso" column

        // Get the DataTable API instance
        var table = $("#dataTableNotasPorAlumnoApoderado").DataTable();
        var rows = table.rows({ search: "applied" }).nodes();

        var lastCurso = null;
        var rowspan = 1;

        table
            .column(cursoColumnIndex, { search: "applied" })
            .data()
            .each(function (curso, i) {
                if (lastCurso === curso) {
                    rowspan++;
                    $(rows).eq(i).find("td:eq(0)").remove();
                    $(rows)
                        .eq(i - rowspan + 1)
                        .find("td:eq(0)")
                        .attr("rowspan", rowspan);
                } else {
                    lastCurso = curso;
                    rowspan = 1;
                }
            });
    }
});