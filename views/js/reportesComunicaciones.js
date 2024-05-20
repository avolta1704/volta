$(".dataTableReportesComunicaciones").on(
	"click",
	".btnVerComunicadosAlumno",
	function () {
		var codAlumnoComunicado = $(this).attr("codAlumnoComunicado");
		var codAlumno = $(this).attr("codAlumno");
		window.location =
			"index.php?ruta=registrarComunicadoPago&codAdAlumCronograma=" +
			codAlumnoComunicado +
			"&codAlumno=" +
			codAlumno;
	}
);

// Reporte de comunicaciones
$("#btnDescargarReporteComunicados").on("click", function () {
	var data = new FormData();
	data.append("comunicadosPorAlumno", true);
	$.ajax({
		url: "ajax/reportesComunicados.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			if (respuesta) {
				const data = respuesta.map((comunicado) => {
					delete comunicado["idAlumno"];
					return comunicado;
				});

				crearComunicadoExcel(
					data,
					"Comunicados",
					"Reporte de Comunicados"
				);
			}
		},
		error: function (error) {
			console.error("error", error);
		},
	});
});

/**
 * Crea un archivo Excel a partir de los datos proporcionados.
 *
 * @param {Array} data - Los datos que se utilizarán para crear el archivo Excel.
 * @param {string} nombreHoja - El nombre de la hoja de trabajo en el archivo Excel.
 * @param {string} nombreArchivo - El nombre del archivo Excel.
 */
const crearComunicadoExcel = (data, nombreHoja, nombreArchivo) => {
	// Crear un nuevo libro de trabajo
	var workbook = XLSX.utils.book_new();

	// Crear una hoja de trabajo
	const ws = XLSX.utils.json_to_sheet(data);

	const date = new Date().toLocaleDateString().replaceAll("/", "-");

	// Agregar estilo a la columna A
	ws["!cols"] = [{ wpx: 100 }, { wpx: 100 }, { wpx: 100 }, { wpx: 100 }];

	// Agregar la hoja de trabajo al libro de trabajo
	XLSX.utils.book_append_sheet(workbook, ws, nombreHoja);

	// Generar el archivo Excel
	var excelBuffer = XLSX.write(workbook, {
		bookType: "xlsx",
		type: "array",
	});

	// Convertir el archivo Excel en un Blob
	var blob = new Blob([excelBuffer], {
		type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
	});

	// Crear un enlace de descarga
	var url = URL.createObjectURL(blob);
	var link = document.createElement("a");
	link.href = url;
	link.download = nombreArchivo + ".xlsx";
	link.click();

	// Liberar el enlace de descarga
	URL.revokeObjectURL(url);
};
