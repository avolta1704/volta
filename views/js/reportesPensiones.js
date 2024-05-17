//TODO:
// btnDescargarReporteInicial
// btnDescargarReportePrimaria
// btnDescargarReporteSecundaria
// btnDescargarReporteRangoFecha

// btnDescargarReportePagos
$("#btnDescargarReportePagos").on("click", function () {
	$.ajax({
		url: "ajax/reportesPensiones.ajax.php",
		method: "POST",
		data: { todosLosPensionesPendientesPorAlumno: true },
		dataType: "json",
	}).done(function (data) {
		const dataConMeses = data.map((item) => {
			item.meses.forEach((mes) => {
				if (mes.estadoCronograma === 1) {
					mes.estadoCronograma = 0;
				} else if (mes.estadoCronograma === 2) {
					mes.estadoCronograma = 1;
				}
				item[mes.mesPago] = mes.estadoCronograma;
			});
			delete item.meses;
			return item;
		});

		// Crear un nuevo libro de trabajo
		var workbook = XLSX.utils.book_new();

		// Crear una hoja de trabajo
		const ws = XLSX.utils.json_to_sheet(dataConMeses, {
			header: [
				"Alumno",
				"DNI",
				"Grado",
				"Nivel",
				"Matricula",
				"Marzo",
				"Abril",
				"Mayo",
				"Junio",
				"Julio",
				"Agosto",
				"Septiembre",
				"Octubre",
				"Noviembre",
				"Diciembre",
			],
		});

		const date = new Date().toLocaleDateString().replaceAll("/", "-");

		// Agregar estilo a la columna A

		// Agregar la hoja de trabajo al libro de trabajo
		XLSX.utils.book_append_sheet(
			workbook,
			ws,
			// "Reporte Pagos General (" + date + ")"
			"Reporte Pagos General"
		);

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
		link.download = "reporte_pagos_general.xlsx";
		link.click();

		// Liberar el enlace de descarga
		URL.revokeObjectURL(url);
	});
});
