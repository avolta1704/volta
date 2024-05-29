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
			crearExcelPorGradoNivel(dataPorGradoNivel);

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
					element.estadoAdmisionAlumno == 1 //"Retirado"
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
function crearExcelPorGradoNivel(data) {
	const wb = XLSX.utils.book_new();
	const ws_data = [
		["Grado", "Nivel", "Matriculados", "Retirados", "Trasladados", "Total"],
	];
	data.forEach((element) => {
		ws_data.push([
			element.grado,
			element.nivel,
			element.estados.matriculado,
			element.estados.retirado,
			element.estados.trasladado,
			element.total,
		]);
	});

	// Add the total row to ws_data
	ws_data.push([
		"Total General",
		"",
		{ f: `SUM(C2:C${data.length + 1})`, t: "n" },
		{ f: `SUM(D2:D${data.length + 1})`, t: "n" },
		{ f: `SUM(E2:E${data.length + 1})`, t: "n" },
		{ f: `SUM(F2:F${data.length + 1})`, t: "n" },
	]);

	const ws = XLSX.utils.aoa_to_sheet(ws_data);

	XLSX.utils.book_append_sheet(wb, ws, "Reporte Matriculados");
	XLSX.writeFile(wb, "ReporteMatriculados.xlsx");
}

// limpiar el select si se cierra el modal
$("#modalAnioLectivo").on("hidden.bs.modal", function () {
	$("#anioLectivo").val(null).trigger("change");
});
