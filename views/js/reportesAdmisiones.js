// Select de meses
$("#anioLectivo").select2({
	theme: "bootstrap-5",
	width: $(this).data("width")
		? $(this).data("width")
		: $(this).hasClass("w-100")
		? "100%"
		: "style",
	placeholder: $(this).data("placeholder"),
	closeOnSelect: false,
});

$("#btnCerrarSeleccionarAnioLectivo").on("click", function () {
	// limpia el select
	$("#anioLectivo").val(null).trigger("change");
});

$("#btnDescargarAnioLectivo").on("click", function () {
	const anioLectivo = $("#anioLectivo").val();

	// valida si se selecciono un valor
	if (anioLectivo.length == 0) {
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "Seleccione un año lectivo",
		});
		return;
	}

	// crear el formdata para el ajax
	const data = new FormData();
	data.append("anioLectivo", anioLectivo);

	// solicitud ajax
	$.ajax({
		url: "ajax/reportesAdmisiones.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			const dataPorGradoNivel = agruparPorGradoNivel(response);
			const anios = separarAnioLectivo(response.reportesPorAnioLectivo);
			crearExcelPorGradoNivel(dataPorGradoNivel, anios);

			if (response.length == 0) {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "No se encontraron registros",
				});
				return;
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText); // procendecia de error
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});

	// limpiar el select
	$("#anioLectivo").val(null).trigger("change");
});

// Funcion para separar solo los años lectivos
function separarAnioLectivo(data) {
	const anios = [];
	data.forEach((element) => {
		const anio = element.descripcionAnio.split(" ")[1];
		if (!anios.includes(anio)) {
			anios.push(anio);
		}
	});

	return anios;
}

// funcion agrupar por grado y sacar un total de matriculados, retirados y trasladados
function agruparPorGradoNivel(result) {
	const grados = result.grados;
	const data = result.reportesPorAnioLectivo;

	const dataPorGradoNivel = [];
	grados.forEach((grado) => {
		const total = data.filter(
			(element) =>
				element.descripcionGrado == grado.descripcionGrado &&
				element.descripcionNivel == grado.descripcionNivel
		).length;

		const estados = {
			matriculado: data.filter(
				(element) =>
					element.descripcionGrado == grado.descripcionGrado &&
					element.descripcionNivel == grado.descripcionNivel &&
					element.estadoAdmisionAlumno == 2 //"Matriculado"
			).length,
			retirado: data.filter(
				(element) =>
					element.descripcionGrado == grado.descripcionGrado &&
					element.descripcionNivel == grado.descripcionNivel &&
					element.estadoAdmisionAlumno == 4 //"Retirado"
			).length,
			trasladado: data.filter(
				(element) =>
					element.descripcionGrado == grado.descripcionGrado &&
					element.descripcionNivel == grado.descripcionNivel &&
					element.estadoAdmisionAlumno == 3 //"Trasladado"
			).length,
		};

		dataPorGradoNivel.push({
			grado: grado.descripcionGrado,
			nivel: grado.descripcionNivel,
			total: total,
			estados: estados,
		});
	});

	return dataPorGradoNivel;
}

// funcion para crear un excel por grado y nivel
function crearExcelPorGradoNivel(data, anios) {
	const wb = XLSX.utils.book_new();

	const ws_data = [
		[
			`ESTUDIANTES MATRICULADOS, RETIRADOS Y TRASLADADOS ${anios.join(
				"-"
			)} `,
		],
		[],
		["GRADO", "MATRICULADOS", "RETIRADOS", "TRASLADADOS", "TOTAL"],
	];
	data.forEach((element) => {
		ws_data.push([
			element.nivel.substring(0, 4).toUpperCase() +
				" " +
				element.grado.substring(0, 1).padStart(2, "0") +
				" A",
			element.estados.matriculado === 0
				? ""
				: element.estados.matriculado,
			element.estados.retirado === 0 ? "" : element.estados.retirado,
			element.estados.trasladado === 0 ? "" : element.estados.trasladado,
			element.total === 0 ? "" : element.total,
		]);
	});

	// Add the total row to ws_data
	ws_data.push([
		"Total General",
		{ f: `SUM(B4:B${data.length + 3})`, t: "n" },
		{ f: `SUM(C4:C${data.length + 3})`, t: "n" },
		{ f: `SUM(D4:D${data.length + 3})`, t: "n" },
		{ f: `SUM(E4:E${data.length + 3})`, t: "n" },
	]);

	const ws = XLSX.utils.aoa_to_sheet(ws_data);

	// Poner ancho a las columnas
	ws["!cols"] = [
		{ width: 12 },
		{ width: 15 },
		{ width: 11 },
		{ width: 13 },
		{ width: 7 },
	];

	XLSX.utils.book_append_sheet(wb, ws, "Reporte Matriculados");
	XLSX.writeFile(wb, "ReporteMatriculados.xlsx");
}

// limpiar el select si se cierra el modal
$("#modalAnioLectivo").on("hidden.bs.modal", function () {
	$("#anioLectivo").val(null).trigger("change");
});

// reportes por antiguedad
$("#btnDescargarReporteNuevosAntiguos").on("click", function () {
	const data = new FormData();
	data.append("reportesNuevosAntiguos", true);

	$.ajax({
		url: "ajax/reportesAdmisiones.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			const dataPorAntiguedad = agruparPorAntiguedad(response);
			crearExcelPorAntiguedad(dataPorAntiguedad);

			if (response.length == 0) {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "No se encontraron registros",
				});
				return;
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText); // procendecia de error
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});

// agrupar alumnos por antiguedad por el campo de alumno nuevoAlumno , 1 => nuevo, 0 => antiguo
function agruparPorAntiguedad(result) {
	const grados = result.grados;
	const data = result.reporteNuevosAntiguos;

	const dataPorGradoAntiguedad = [];
	grados.forEach((grado) => {
		const nuevos = data.filter(
			(element) =>
				element.descripcionGrado == grado.descripcionGrado &&
				element.descripcionNivel == grado.descripcionNivel &&
				element.nuevoAlumno == 1
		).length;

		const antiguos = data.filter(
			(element) =>
				element.descripcionGrado == grado.descripcionGrado &&
				element.descripcionNivel == grado.descripcionNivel &&
				element.nuevoAlumno == 0
		).length;

		dataPorGradoAntiguedad.push({
			grado: grado.descripcionGrado,
			nivel: grado.descripcionNivel,
			nuevos: nuevos,
			antiguos: antiguos,
		});
	});

	return dataPorGradoAntiguedad;
}

// funcion para crear un excel por antiguedad
function crearExcelPorAntiguedad(data) {
	const wb = XLSX.utils.book_new();
	const ws_data = [
		["ESTUDIANTES ANTIGUOS Y NUEVOS"],
		[""],
		["CUENTA", "ANTIGUOS", "NUEVOS", "Total"]
	];
	data.forEach((element) => {
		ws_data.push([
			element.nivel.substring(0, 4).toUpperCase() +
				" " +
				element.grado.substring(0, 1).padStart(2, "0") +
				" A",
				element.antiguos === 0 ? "":element.antiguos,
				element.nuevos === 0 ? "" : element.nuevos,
			(element.nuevos + element.antiguos) === 0 ? "":element.nuevos + element.antiguos,
		]);
	});

	// Add the total row to ws_data
	ws_data.push([
		"Total General",
		{ f: `SUM(B4:B${data.length + 3})`, t: "n" },
		{ f: `SUM(C4:C${data.length + 3})`, t: "n" },
		{ f: `SUM(D4:D${data.length + 3})`, t: "n" },
	]);

	const ws = XLSX.utils.aoa_to_sheet(ws_data);

	XLSX.utils.book_append_sheet(wb, ws, "Reporte Antiguos Nuevos");
	XLSX.writeFile(wb, "ReporteAntiguosNuevos.xlsx");
}

// reportes por edad/sexo
$("#btnDescargarReporteEdadSexo").on("click", function () {
	const data = new FormData();
	data.append("reportesPorEdadSexo", true);

	$.ajax({
		url: "ajax/reportesAdmisiones.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			const dataPorSexo = agruparPorSexo(response);
			crearExcelPorSexo(dataPorSexo);

			if (response.length == 0) {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "No se encontraron registros",
				});
				return;
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText); // procendecia de error
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});

// agrupar alumnos por sexo
function agruparPorSexo(result) {
	const grados = result.grados;
	const data = result.reportePorEdadSexo;

	const dataPorGradoSexo = [];
	grados.forEach((grado) => {
		const hombres = data.filter(
			(element) =>
				element.descripcionGrado == grado.descripcionGrado &&
				element.descripcionNivel == grado.descripcionNivel &&
				element.sexoAlumno == "Masculino"
		).length;

		const mujeres = data.filter(
			(element) =>
				element.descripcionGrado == grado.descripcionGrado &&
				element.descripcionNivel == grado.descripcionNivel &&
				element.sexoAlumno == "Femenino"
		).length;

		dataPorGradoSexo.push({
			grado: grado.descripcionGrado,
			nivel: grado.descripcionNivel,
			hombres: hombres,
			mujeres: mujeres,
		});
	});

	return dataPorGradoSexo;
}

// funcion para crear un excel por sexo
function crearExcelPorSexo(data) {
	const wb = XLSX.utils.book_new();
	const ws_data = [
		["ESTUDIANTES MUJERES Y HOMBRES"],
		[""],
		["CUENTA", "MUJERES", "HOMBRES", "Total"]];
	data.forEach((element) => {
		ws_data.push([
			element.nivel.substring(0, 4).toUpperCase() +
				" " +
				element.grado.substring(0, 1).padStart(2, "0") +
				" A",
			element.mujeres === 0 ? "" : element.mujeres,
			element.hombres === 0 ? "" : element.hombres,
			element.hombres + element.mujeres === 0 ? "" : element.hombres + element.mujeres,
		]);
	});

	// Add the total row to ws_data
	ws_data.push([
		"Total General",
		{ f: `SUM(B4:B${data.length + 3})`, t: "n" },
		{ f: `SUM(C4:C${data.length + 3})`, t: "n" },
		{ f: `SUM(D4:D${data.length + 3})`, t: "n" },
	]);

	const ws = XLSX.utils.aoa_to_sheet(ws_data);

	XLSX.utils.book_append_sheet(wb, ws, "Reporte Por Sexo");
	XLSX.writeFile(wb, "ReportePorSexo.xlsx");
}
