$(document).ready(function () {
	$("#selectGradoToReport").trigger("change");
});

// Select de meses
$("#selectMonthToReportA").select2({
	theme: "bootstrap-5",
	width: $(this).data("width")
		? $(this).data("width")
		: $(this).hasClass("w-100")
		? "100%"
		: "style",
	placeholder: $(this).data("placeholder"),
	closeOnSelect: false,
});

$("#selectGradoToReport").change(function () {});

$("#selectMonthToReportA").change(function () {
	const idGrado = $("#selectGradoToReport").val();
	const año = new Date().getFullYear();
	const meses = $("#selectMonthToReportA").val();
	let fechas = [];
	for (let i = 0; i < meses.length; i++) {
		const mes = meses[i];
		const { primerDia, ultimoDia } = getRangeDatesMoth(mes, año);
		fechas.push({ mes, primerDia, ultimoDia });
	}

	const dataGradoAsistencia = {
		idGrado: idGrado,
		fechaInicial: fechas[0]?.primerDia,
		fechaFinal: fechas[fechas?.length - 1]?.ultimoDia,
	};

	var data = new FormData();
	data.append("gradoAsistencia", JSON.stringify(dataGradoAsistencia));

	$.ajax({
		url: "ajax/asistenciaAlumnos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			generarTablaAsistenciaReporte(response, meses, año);

			const totales = obtenerTotalesAsistencias(response, meses, año);
			generarGraficoAsistencias(totales);
		},
		error: function (error) {
			console.log(error);
		},
	});
});

function generarTablaAsistenciaReporte(data, meses, año) {
	const daysMonths = obtenerDiasLaborables(meses, año);

	var asistenciaContainer = $("#reporteAsistencias");
	asistenciaContainer.empty(); // Limpiar el contenedor antes de agregar la nueva tabla

	// Crear la tabla con estilo en línea
	var tabla = $(
		'<table style="border: 1px solid black; border-collapse: collapse; width: 100%;"></table>'
	);
	var encabezadoMeses = $("<tr></tr>");
	var encabezadoDiasSemana = $("<tr></tr>");
	var encabezadoDias = $("<tr></tr>");
	encabezadoMeses.append(
		'<td rowspan="3" style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center;">Alumnos</td>'
	);
	// Fila del mes
	for (let i = 0; i < daysMonths.length; i++) {
		const { mes, diasLaborables } = daysMonths[i];
		encabezadoMeses.append(
			'<td colspan="' +
				diasLaborables.length +
				'" style="text-align: center; font-weight: bold; background-color: #00bfbf; border: 1px solid">' +
				mes +
				"</td>"
		);
	}
	tabla.append(encabezadoMeses);

	// Fila de los nombres de los días de la semana

	// Iterar sobre los días de la semana
	for (let i = 0; i < daysMonths.length; i++) {
		const { mes, diasLaborables } = daysMonths[i];
		for (let j = 0; j < diasLaborables.length; j++) {
			const dia = diasLaborables[j];
			encabezadoDiasSemana.append(
				'<td style="border: 1px solid black; text-align: center; padding: 0px 10px; font-weight: bold; font-size:12px;">' +
					dia.diaSemana +
					"</td>"
			);
		}
	}
	tabla.append(encabezadoDiasSemana);
	// Fila de los números de los días
	for (let i = 0; i < daysMonths.length; i++) {
		const { mes, diasLaborables } = daysMonths[i];
		for (let j = 0; j < diasLaborables.length; j++) {
			const dia = diasLaborables[j];
			encabezadoDias.append(
				'<td style="border: 1px solid black; text-align: center; font-weight: bold; font-size:12px;">' +
					dia.dia +
					"</td>"
			);
		}
	}
	tabla.append(encabezadoDias);

	const dataAlumnosAsistencia = agruparAlumnosAsistencias(data);

	// Iterar sobre los días de la semana y los alumnos
	for (let i = 0; i < dataAlumnosAsistencia.length; i++) {
		const alumno = dataAlumnosAsistencia[i];
		var filaAsistencia = $("<tr></tr>");

		filaAsistencia.append(
			'<td style="border: 1px solid black; min-width: 350px;">' +
				alumno.nombreAlumno +
				"</td>"
		);
		for (let j = 0; j < daysMonths.length; j++) {
			const { mes, diasLaborables } = daysMonths[j];
			for (let k = 0; k < diasLaborables.length; k++) {
				const dia = diasLaborables[k];
				const asistenciaDia = alumno.asistencias.find(
					(asistencia) => asistencia.fecha === dia.fecha
				);
				if (asistenciaDia) {
					filaAsistencia.append(
						'<td style="border: 1px solid black; text-align: center; color: ' +
							getColorAsistencia(asistenciaDia.asistencia) +
							'">' +
							asistenciaDia.asistencia +
							"</td>"
					);
				} else {
					filaAsistencia.append(
						'<td style="border: 1px solid black; text-align: center;"></td>'
					);
				}
			}
		}
		tabla.append(filaAsistencia);
	}

	asistenciaContainer.append(tabla);
}

//Optener el primer y ultimo dia de un segun su nombre
function getRangeDatesMoth(nombreMes, año) {
	var meses = {
		Enero: 1,
		Febrero: 2,
		Marzo: 3,
		Abril: 4,
		Mayo: 5,
		Junio: 6,
		Julio: 7,
		Agosto: 8,
		Septiembre: 9,
		Octubre: 10,
		Noviembre: 11,
		Diciembre: 12,
	};
	var mesNum = meses[nombreMes];
	// format: yyyy-mm-dd
	var primerDia = new Date(año, mesNum - 1, 1).toISOString().split("T")[0];
	var ultimoDia = new Date(año, mesNum, 0).toISOString().split("T")[0];
	return { primerDia, ultimoDia };
}
// Funcion para obtener los dias laborables de un mes
function obtenerDiasLaborables(months, year) {
	const diasLaborablesPorMes = [];

	// Mapeo de nombres de meses a números de mes (0-indexed)
	const meses = {
		enero: 0,
		febrero: 1,
		marzo: 2,
		abril: 3,
		mayo: 4,
		junio: 5,
		julio: 6,
		agosto: 7,
		septiembre: 8,
		octubre: 9,
		noviembre: 10,
		diciembre: 11,
	};
	// Iterar sobre los nombres de los meses
	months.forEach((nombreMes) => {
		const mesIndex = meses[nombreMes.toLowerCase()];
		if (mesIndex !== undefined && mesIndex >= 0 && mesIndex <= 11) {
			// Obtener la fecha inicial y final del mes
			const fechaInicio = new Date(year, mesIndex, 1);
			const fechaFin = new Date(year, mesIndex + 1, 0);

			// Array para almacenar los días laborables
			const diasLaborables = [];

			// Iterar sobre cada día del mes
			const dia = new Date(fechaInicio);
			while (dia <= fechaFin) {
				const diaSemana = dia.getDay();
				if (diaSemana !== 0 && diaSemana !== 6) {
					// Excluir sábados (6) y domingos (0)
					const diaObj = {
						dia: dia.getDate(),
						fecha: dia.toISOString().split("T")[0],
						diaSemana: dia
							.toLocaleDateString("es-ES", {
								weekday: "short",
							})
							.toUpperCase(),
					};
					diasLaborables.push(diaObj);
				}
				dia.setDate(dia.getDate() + 1);
			}

			// Agregar el objeto del mes al array de resultados
			diasLaborablesPorMes.push({
				mes: nombreMes,
				diasLaborables: diasLaborables,
			});
		}
	});

	return diasLaborablesPorMes;
}

// Agrupar los alumnos por su idAlumno y obtener las asistencias
function agruparAlumnosAsistencias(data) {
	const alumnos = [];
	data.forEach((asistencia) => {
		const { idAlumno, nombresAlumno, apellidosAlumno } = asistencia;
		const alumnoIndex = alumnos.findIndex(
			(alumno) => alumno.idAlumno === idAlumno
		);
		if (alumnoIndex === -1) {
			alumnos.push({
				idAlumno,
				nombreAlumno: nombresAlumno + " " + apellidosAlumno,
				asistencias: [
					{
						fecha: asistencia.fechaAsistencia,
						asistencia: asistencia.estadoAsistencia,
					},
				],
			});
		} else {
			alumnos[alumnoIndex].asistencias.push({
				fecha: asistencia.fechaAsistencia,
				asistencia: asistencia.estadoAsistencia,
			});
		}
	});

	return alumnos;
}

// Dependiendo del estado de la asistencia, se cambia el color de la celda
function getColorAsistencia(estado) {
	switch (estado) {
		case "A":
			return "green";
		case "F":
			return "red";
		case "T":
			return "orange";
		case "J":
			return "blue";
		case "U":
			return "purple";
		default:
			return "#ffffff";
	}
}

// Sacar totales de los estados de asistencias por cada dia de cada mes y devolver el dia , y los totales
function obtenerTotalesAsistencias(datos, meses, año) {
	const resultado = [];

	// Crear un arreglo de meses
	const fechas = obtenerDiasLaborables(meses, año);

	// Crear un mapa de fechas para acceso rápido
	const fechasMap = fechas.reduce((map, fecha) => {
		fecha.diasLaborables.forEach((dia) => {
			map[dia.fecha] = {
				fecha: dia.fecha,
				asistencia: {
					asistio: 0,
					falto: 0,
					inasistencia: 0,
					faltaj: 0,
					tardanza: 0,
				},
			};
		});
		return map;
	}, {});

	// Iterar sobre los datos
	datos.forEach((item) => {
		const { fechaAsistencia, estadoAsistencia } = item;

		// Si la fecha está en la lista de fechas dadas, contar el estado
		if (fechasMap[fechaAsistencia]) {
			switch (estadoAsistencia) {
				case "A":
					fechasMap[fechaAsistencia].asistencia["asistio"]++;
					break;
				case "F":
					fechasMap[fechaAsistencia].asistencia["falto"]++;
					break;
				case "T":
					fechasMap[fechaAsistencia].asistencia["inasistencia"]++;
					break;
				case "J":
					fechasMap[fechaAsistencia].asistencia["faltaj"]++;
					break;
				case "U":
					fechasMap[fechaAsistencia].asistencia["tardanza"]++;
					break;
			}
		}
	});

	// Convertir el mapa de fechas en un arreglo
	for (const fechaAsistencia in fechasMap) {
		resultado.push({
			fecha: fechasMap[fechaAsistencia].fecha,
			asistencia: fechasMap[fechaAsistencia].asistencia,
		});
	}

	return resultado;
}

// Grafico de asistencias
function generarGraficoAsistencias(resultado) {
	var chartElement = document.querySelector("#reporteAsistenciasChart");

	if (chartElement.chart) {
		chartElement.chart.destroy();
	}

	// Preparar los datos para el gráfico
	const categories = resultado.map((item) => item.fecha);
	const asistio = resultado.map((item) => item.asistencia["asistio"]);
	const falto = resultado.map((item) => item.asistencia["falto"]);
	const inasistenciaInjustificada = resultado.map(
		(item) => item.asistencia["inasistencia"]
	);
	const faltaJustificada = resultado.map((item) => item.asistencia["faltaj"]);
	const tardanzaJustificada = resultado.map(
		(item) => item.asistencia["tardanza"]
	);

	// Crear el gráfico
	var chart = new ApexCharts(chartElement, {
		series: [
			{
				name: "# Asistencias",
				data: asistio,
			},
			{
				name: "# Faltas",
				data: falto,
			},
			{
				name: "# Inasistencias Injustificadas",
				data: inasistenciaInjustificada,
			},
			{
				name: "# Faltas Justificadas",
				data: faltaJustificada,
			},
			{
				name: "# Tardanzas Justificadas",
				data: tardanzaJustificada,
			},
		],
		chart: {
			height: 350,
			type: "area",
			toolbar: {
				show: false,
			},
		},
		markers: {
			size: 4,
		},
		colors: ["#4154f1", "#2eca6a", "#ff771d", "#a47bff", "#ffd05b"],
		fill: {
			type: "gradient",
			gradient: {
				shadeIntensity: 1,
				opacityFrom: 0.3,
				opacityTo: 0.4,
				stops: [0, 90, 100],
			},
		},
		dataLabels: {
			enabled: false,
		},
		stroke: {
			curve: "smooth",
			width: 2,
		},
		xaxis: {
			categories: categories,
			labels: {
				rotate: -45,
				maxHeight: 80,
			},
			tickPlacement: "on",
			range: 22,
		},
		tooltip: {
			x: {
				format: "dd/MM/yy HH:mm",
			},
		},
		noData: {
			text: "No hay datos disponibles",
		},
	});

	// Renderizar el gráfico
	chart.render();

	// Guardar el gráfico en el elemento para poder destruirlo luego
	chartElement.chart = chart;
}

$("#btnDescargarReporteAsistencias").click(function () {
	// Descargar un excel de la tabla de asistencias con XLSX
	const tabla = document.querySelector("#reporteAsistencias table");

	// Verificar si la tabla existe
	if (!tabla) {
		Swal.fire({
			icon: "warning",
			title: "Advertencia",
			text: "No se ha generado la tabla de asistencias",
		});
		return;
	}

	const fecha = new Date().toISOString().split("T")[0];
	const nombreArchivo = "Reporte_Asistencias_" + fecha + ".xlsx";
	const ws = XLSX.utils.table_to_sheet(tabla);
	const wb = XLSX.utils.book_new();
	// en ancho de la primera columna
	ws["!cols"] = [{ wpx: 350 }];
	XLSX.utils.book_append_sheet(wb, ws, "Asistencias");
	XLSX.writeFile(wb, nombreArchivo);
});
