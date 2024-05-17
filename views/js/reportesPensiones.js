//TODO: btnDescargarReporteInicial
//TODO: btnDescargarReportePrimaria
//TODO: btnDescargarReporteSecundaria
//TODO: btnDescargarReporteRangoFecha

// btnDescargarReportePagos
$("#btnDescargarReportePagos").on("click", function () {
	$.ajax({
		url: "ajax/reportesPensiones.ajax.php",
		method: "POST",
		data: { todosLosPensionesPendientesPorAlumno: true },
		dataType: "json",
	}).done(function (data) {
		const dataConMeses = organizarData(data);
		crearArchivoExcel(
			dataConMeses,
			"Reporte de Pagos General",
			"reporte_pagos_general"
		);
	});
});

// btnDescargarReporteInicial
$("#btnDescargarReporteInicial").on("click", function () {
	$.ajax({
		url: "ajax/reportesPensiones.ajax.php",
		method: "POST",
		data: { todosLosPensionesPendientesPorAlumno: true },
		dataType: "json",
	}).done(function (data) {
		const dataOrganizada = organizarData(data);
		const dataSoloInicial = dataOrganizada.filter(
			(item) => item.Nivel === "Inicial"
		);

		const dataFormateado = formatoDataReporteIndividual(dataSoloInicial);
		crearArchivoExcelSinNivel(
			dataFormateado,
			"Reporte Inicial",
			"reporte_pagos_inicial"
		);
	});
});

// btnDescargarReportePrimaria
$("#btnDescargarReportePrimaria").on("click", function () {
	$.ajax({
		url: "ajax/reportesPensiones.ajax.php",
		method: "POST",
		data: { todosLosPensionesPendientesPorAlumno: true },
		dataType: "json",
	}).done(function (data) {
		const dataOrganizada = organizarData(data);

		const dataSoloPrimaria = dataOrganizada.filter(
			(item) => item.Nivel === "Primaria"
		);

		const dataFormateado = formatoDataReporteIndividual(dataSoloPrimaria);
		crearArchivoExcelSinNivel(
			dataFormateado,
			"Reporte Primaria",
			"reporte_pagos_primaria"
		);
	});
});

// btnDescargarReporteSecundaria
$("#btnDescargarReporteSecundaria").on("click", function () {
	$.ajax({
		url: "ajax/reportesPensiones.ajax.php",
		method: "POST",
		data: { todosLosPensionesPendientesPorAlumno: true },
		dataType: "json",
	}).done(function (data) {
		const dataOrganizada = organizarData(data);
		const dataSoloSecundaria = dataOrganizada.filter(
			(item) => item.Nivel === "Secundaria"
		);
		const dataFormateado = formatoDataReporteIndividual(dataSoloSecundaria);

		crearArchivoExcelSinNivel(
			dataFormateado,
			"Reporte Secundaria",
			"reporte_pagos_secundaria"
		);
	});
});

/**
 * Formatea los datos de un reporte individual eliminando la propiedad "Nivel" de cada objeto.
 * @param {Array} data - Los datos a formatear.
 * @returns {Array} - Los datos formateados.
 */
const formatoDataReporteIndividual = (data) => {
	return data.map((item) => {
		delete item.Nivel;
		return item;
	});
};

/**
 * Organiza los datos de acuerdo a ciertas condiciones.
 * @param {Array} data - Los datos a organizar.
 * @returns {Array} - Los datos organizados.
 */
const organizarData = (data) => {
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
	return dataConMeses;
};

/**
 * Crea un archivo Excel a partir de los datos proporcionados.
 *
 * @param {Array} data - Los datos que se utilizarán para crear el archivo Excel.
 * @param {string} nombreHoja - El nombre de la hoja de trabajo en el archivo Excel.
 * @param {string} nombreArchivo - El nombre del archivo Excel.
 */
const crearArchivoExcel = (data, nombreHoja, nombreArchivo) => {
	// Crear un nuevo libro de trabajo
	var workbook = XLSX.utils.book_new();

	// Crear una hoja de trabajo
	const ws = XLSX.utils.json_to_sheet(data, {
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

/**
 * Crea un archivo Excel sin nivel a partir de los datos proporcionados.
 *
 * @param {Array} data - Los datos que se utilizarán para crear el archivo Excel.
 * @param {string} nombreHoja - El nombre de la hoja de trabajo en el archivo Excel.
 * @param {string} nombreArchivo - El nombre del archivo Excel.
 */
const crearArchivoExcelSinNivel = (data, nombreHoja, nombreArchivo) => {
	// Crear un nuevo libro de trabajo
	var workbook = XLSX.utils.book_new();

	// Crear una hoja de trabajo
	const ws = XLSX.utils.json_to_sheet(data, {
		header: [
			"Alumno",
			"DNI",
			"Grado",
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
