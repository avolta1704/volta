// btnDescargarReportePagos
$("#btnDescargarReportePagos").on("click", function () {
	$.ajax({
		url: "ajax/reportesPensiones.ajax.php",
		method: "POST",
		data: { todosLosPagosGeneral: true },
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

// Select de meses
$("#selectMonth").select2({
	theme: "bootstrap-5",
	width: $(this).data("width")
		? $(this).data("width")
		: $(this).hasClass("w-100")
		? "100%"
		: "style",
	placeholder: $(this).data("placeholder"),
	closeOnSelect: false,
});

// Limpiar el select de meses al cerrar el modal
$("#seleccionarRangoFechas").on("hidden.bs.modal", function () {
	const $selectMonth = $("#selectMonth");
	$selectMonth.val(null).trigger("change");
});

// btnDescargarReporteRangoFecha
$("#btnDescargarReporteRangoFecha").on("click", function () {
	$.ajax({
		url: "ajax/reportesPensiones.ajax.php",
		method: "POST",
		data: { todosLosPagosPorRango: true },
		dataType: "json",
	}).done(function (data) {
		const meses = $("#selectMonth").val();

		const dataConMeses = organizarData(data);

		const dataFiltrada = filtrarDatosConMesesSeleccionados(
			dataConMeses,
			meses
		);

		const dataEstadoAlumno = dataFiltrada.map((item) => {
			if (item.Estado === 1) {
				item.Estado = "Activo";
			} else {
				item.Estado = "Inactivo";
			}
			return item;
		});

		crearArchivoExcelConMesesSeleccionados(
			meses,
			dataEstadoAlumno,
			"Reporte de Pagos por Meses",
			"reporte_pagos_" + meses[0] + "_" + meses[meses.length - 1]
		);

		$("#seleccionarRangoFechas").modal("hide");
	});
});

/**
 * Filtra los datos de acuerdo a los meses especificados.
 *
 * @param {Array} dataConMeses - Los datos originales con información de los meses.
 * @param {Array} mes - Los meses a filtrar.
 * @returns {Array} - Los datos filtrados.
 */
const filtrarDatosConMesesSeleccionados = (dataConMeses, mes) => {
	return dataConMeses.map((item) => {
		const filteredItem = {
			Alumno: item.Alumno,
			DNI: item.DNI,
			Grado: item.Grado,
			Nivel: item.Nivel,
			Estado: item.Estado,
		};

		Object.keys(item).forEach((key) => {
			if (mes.includes(key)) {
				filteredItem[key] = item[key];
			}
		});

		return filteredItem;
	});
};

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

/**
 * Crea un archivo Excel con los meses seleccionados.
 *
 * @param {Array<string>} meses - Los meses seleccionados.
 * @param {Array<Object>} data - Los datos a incluir en el archivo Excel.
 * @param {string} nombreHoja - El nombre de la hoja de trabajo en el archivo Excel.
 * @param {string} nombreArchivo - El nombre del archivo Excel.
 */
const crearArchivoExcelConMesesSeleccionados = (
	meses,
	data,
	nombreHoja,
	nombreArchivo
) => {
	// Crear un nuevo libro de trabajo
	var workbook = XLSX.utils.book_new();

	// Crear una hoja de trabajo
	const ws = XLSX.utils.json_to_sheet(data, {
		header: ["Alumno", "DNI", "Grado", "Nivel", "Estado", ...meses],
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
