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
	}).fail(function (jqXHR, textStatus, errorThrown) {
    console.log( jqXHR.responseText );
    console.log(
      "Error en la solicitud AJAX: ",
      textStatus,
      errorThrown
    );

    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: 'No se pudo descargar el reporte de pagos.', 
      showConfirmButton: false,
      timer: 1500      
    })
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


//  Vista para el modal de cronograma de pagos de Reporte de Pensisones Atrasadas
$(".dataTableReportesPensiones").on("click", ".btnVisualizarAdmisionAlumno", function () {
    var idAdmisionAlumno = $(this).attr("idAdmisionAlumno");
    var data = new FormData();
    data.append("codAdAlumCronograma", idAdmisionAlumno);

	
    $.ajax({
        url: "ajax/admisionAlumnos.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
            var modalBody = $("#cronogramaPagoDeuda .modal-body");
            modalBody.empty();

            $.each(response, function (index, item) {
                var div = $("<div>").addClass("mb-3");

                var label2 = $("<label>")
                    .addClass("form-label h5 font-weight-bold")
                    .attr("id", "tipoCronoPago")
                    .attr("name", "tipoCronoPago")
                    .css("margin-left", "8px") // Agrega un margen a la izquierda
                    .html("<strong>" + item.mesPago + "</strong>");

                var inputGroup = $("<div>").addClass("input-group");

                var input1 = $("<input>")
                    .attr("type", "text")
                    .addClass("form-control")
                    .attr("id", "fechaPago")
                    .attr("name", "fechaPago")
                    // uso de la funcion para justar el formato de la fecha
                    .val("Fecha Límite: " + formatFecha(item.fechaLimite))
                    .attr("readonly", true)
                    .css("width", "auto"); // Establecer el ancho automático

                var input2 = $("<input>")
                    .attr("type", "text")
                    .addClass("form-control")
                    .attr("id", "montoPago")
                    .attr("name", "montoPago")
                    .val("Monto: S/ " + item.montoPago)
                    .attr("readonly", true)
                    .css("width", "75px"); // Ajusta este valor según tus necesidades

                var input3 = $("<div>")
                    .addClass("form-control fs-6 text-center")
                    .attr("id", "stadoCronograma")
                    .attr("name", "stadoCronograma")
                    .html(item.estadoCronogramaPago);


                // Agregamos los elementos al div principal
                inputGroup.append(input1, input2, input3);
                div.append(label2, inputGroup);
                modalBody.append(div);
            });

            $("#cronogramaPagoDeuda").modal("show");
        },
        /*  error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
        }, */
    });
}


);

//boton para ir a la vista agregar pago
$(".dataTableReportesPensiones").on("click", ".btnEditarEstadoAdmisionAlumno", function () {

	window.location = "index.php?ruta=registrarPago";
});


//boton para ir a la vista de comunicado de pago
$(".dataTableReportesPensiones").on("click", ".btnEliminarAdmisionAlumno", function () {
	// Obtener el código de pago del atributo del botón
	var codAdAlumCronograma = $(this).attr("codAdAlumCronograma");
	var codAlumno = $(this).attr("codAlumno");

	window.location = "index.php?ruta=registrarComunicadoPago&codAdAlumCronograma=" + codAlumno+"&codAlumno="+codAlumno;
});
