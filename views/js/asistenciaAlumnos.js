// Abrir la vista de asistencia de alumnos
$("#dataTableCursosDocente").on(
	"click",
	".btnVisualizarAsistencia",
	function () {
		var idCurso = $(this).attr("idCurso");
		var idGrado = $(this).attr("idGrado");
		var idPersonal = $(this).attr("idPersonal");
		window.location =
			"index.php?ruta=visualizarAsistencia&idCurso=" +
			idCurso +
			"&idGrado=" +
			idGrado +
			"&idPersonal=" +
			idPersonal;
	}
);

// Abrir el modal para registrar la asistencia de los alumnos
$("#btnTomarAsistencia").click(function () {
	// idCurso, idGrado, idPersonal
	const idCurso = $(this).attr("idCurso");
	const idGrado = $(this).attr("idGrado");
	const idPersonal = $(this).attr("idPersonal");

	//Solicitud inicial de dataTableAlumnosCurso

	var columnDefsAlumnosCurso = [
		{ data: "idAlumno" },
		{ data: "nombresAlumno" },
		{ data: "apellidosAlumno" },
		{ data: "acciones" },
	];

	var tableAlumnosCurso = $("#dataTableTomarAsistencia").DataTable({
		columns: columnDefsAlumnosCurso,
		retrieve: true,
		paging: false,
	});

	const dataListaAlumnosCurso = {
		idCurso: idCurso,
		idGrado: idGrado,
		idPersonal: idPersonal,
		todosLosAlumnosCurso: true,
	};
	// crear la formdata con datalistaAlumnosCurso
	var data = new FormData();
	data.append(
		"todosLosAlumnosAsistenciaCursoTomarAsistencia",
		JSON.stringify(dataListaAlumnosCurso)
	);

	$.ajax({
		url: "ajax/asistenciaAlumnos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			tableAlumnosCurso.clear();
			tableAlumnosCurso.rows.add(response);
			tableAlumnosCurso.draw();
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

	//Estructura de dataTableAlumnosCurso
	$("#dataTableTomarAsistencia thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

	tableAlumnosCurso.destroy();

	columnDefsAlumnosCurso = [
		{
			data: null,
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "nombresAlumno" },
		{ data: "apellidosAlumno" },
		{ data: "acciones" },
	];
	tableAlumnosCurso = $("#dataTableTomarAsistencia").DataTable({
		columns: columnDefsAlumnosCurso,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
});

$asistenciaAlumnos = [];
// Tomar la asistencia de los alumnos
$("#dataTableTomarAsistencia").on("change", "#asistenciaAlumno", function () {
	const idAlumno = $(this).attr("idAlumno");
	const idCurso = $(this).attr("idCurso");
	const idGrado = $(this).attr("idGrado");
	const idPersonal = $(this).attr("idPersonal");

	const asistencia = $(this).val();

	// verificar si el alumno ya fue registrado
	const index = $asistenciaAlumnos.findIndex(
		(alumno) => alumno.idAlumno === idAlumno
	);

	if (index === -1) {
		$asistenciaAlumnos.push({
			idAlumno: idAlumno,
			idCurso: idCurso,
			idGrado: idGrado,
			idPersonal: idPersonal,
			estadoAsistencia: asistencia,
		});
	} else {
		$asistenciaAlumnos[index].estadoAsistencia = asistencia;
	}

	console.log($asistenciaAlumnos);
});

// Limpiar la asistencia de los alumnos al cerrar el modal
$("#modalTomarAsistencia").on("hidden.bs.modal", function () {
	$asistenciaAlumnos = [];
});

// Guardar la asistencia de los alumnos
$("#btnGuardarAsistencia").click(function () {
	const idCurso = $(this).attr("idCurso");
	const idGrado = $(this).attr("idGrado");
	const idPersonal = $(this).attr("idPersonal");

	const dataAsistencia = {
		idCurso: idCurso,
		idGrado: idGrado,
		idPersonal: idPersonal,
	};

	const data = new FormData();
	data.append("guardarAsistenciaAlumnos", JSON.stringify(dataAsistencia));
	data.append("asistenciaAlumnos", JSON.stringify($asistenciaAlumnos));

	$.ajax({
		url: "ajax/asistenciaAlumnos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			console.log(response);
			// cerramos el modal
			$("#modalTomarAsistencia").modal("hide");
			if (response === "ok") {
				Swal.fire({
					icon: "success",
					title: "¡Éxito!",
					text: "La asistencia de los alumnos se ha guardado correctamente",
					showConfirmButton: false,
					timer: 1500,
				});
			}

			if (response === "error") {
				Swal.fire({
					icon: "error",
					title: "¡Error!",
					text: "La asistencia de los alumnos no se ha guardado correctamente",
					showConfirmButton: false,
					timer: 1500,
				});
			}
			// limpia el array de asistencia
			$asistenciaAlumnos = [];
			actualizarTabla();
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

	function actualizarTabla() {
		var columnDefsAlumnosCurso = [
			{ data: "idAlumno" },
			{ data: "nombresAlumno" },
			{ data: "apellidosAlumno" },
			{ data: "estadoAsistencia" },
		];
		var tableAlumnosCurso = $("#dataTableAsistenciaAlumnos").DataTable({
			columns: columnDefsAlumnosCurso,
			retrieve: true,
			paging: false,
		});
		const dataListaAlumnosCurso = {
			idCurso: idCurso,
			idGrado: idGrado,
			idPersonal: idPersonal,
			todosLosAlumnosCurso: true,
		};

		// actualizamos la tabla
		var data = new FormData();
		data.append(
			"todosLosAlumnosAsistenciaCurso",
			JSON.stringify(dataListaAlumnosCurso)
		);

		$.ajax({
			url: "ajax/asistenciaAlumnos.ajax.php",
			method: "POST",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",

			success: function (response) {
				tableAlumnosCurso.clear();
				tableAlumnosCurso.rows.add(response);
				tableAlumnosCurso.draw();
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
		//Estructura de dataTableAlumnosCurso
		$("#dataTableAsistenciaAlumnos thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Estado de Asistencia</th>
    </tr>
    `);

		tableAlumnosCurso.destroy();

		columnDefsAlumnosCurso = [
			{
				data: null,
				render: function (data, type, row, meta) {
					return meta.row + 1;
				},
			},
			{ data: "nombresAlumno" },
			{ data: "apellidosAlumno" },
			{ data: "estadoAsistencia" },
		];
		tableAlumnosCurso = $("#dataTableAsistenciaAlumnos").DataTable({
			columns: columnDefsAlumnosCurso,
		});
	}
});

//Descargar un template de la asistencia de los alumnos

$("#btnDescargarTemplateAsistencia").click(function () {
	const idCurso = $(this).attr("idCurso");
	const idGrado = $(this).attr("idGrado");
	const idPersonal = $(this).attr("idPersonal");

	const dataListaAlumnosCurso = {
		idCurso: idCurso,
		idGrado: idGrado,
		idPersonal: idPersonal,
		todosLosAlumnosCurso: true,
	};
	// crear la formdata con datalistaAlumnosCurso
	var data = new FormData();
	data.append(
		"todosLosAlumnosAsistenciaCurso",
		JSON.stringify(dataListaAlumnosCurso)
	);

	$.ajax({
		url: "ajax/asistenciaAlumnos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			const data = orderData(response);
			createXLSXTemplate(data, getDiasLaborables());
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

	/**
	 * Funcion para ordenar la data de los alumnos y los dias laborables vacios
	 * @param {Array} data la data que se va a ordenar
	 */
	function orderData(data) {
		// los dias como keys
		const diasLaborables = getDiasLaborables();
		const dias = diasLaborables.map((dia) => {
			return {
				[dia]: "",
			};
		});

		const orderedData = data.map((alumno, index) => {
			return {
				Nro: index + 1,
				IUU: alumno.idAlumnoAnioEscolar,
				Alumnos: `${alumno.nombresAlumno} ${alumno.apellidosAlumno}`,
				...dias.reduce((acc, dia) => {
					return { ...acc, ...dia };
				}),
			};
		});
		return orderedData;
	}

	/**
	 * Funcion para obtener los dias laborables del mes actual
	 * @returns {Array} los dias laborables del mes actual
	 */
	function getDiasLaborables() {
		const fecha = new Date();
		const mes = fecha.getMonth();
		const anio = fecha.getFullYear();
		const dias = new Date(anio, mes + 1, 0).getDate();
		const diasLaborables = [];
		for (let i = 1; i <= dias; i++) {
			const fecha = new Date(anio, mes, i);
			const dia = fecha.getDay();
			if (dia !== 0 && dia !== 6) {
				diasLaborables.push(`${i}/${mes + 1}/${anio}`);
			}
		}
		return diasLaborables;
	}

	/**
	 * Funcion para crear un archivo xlsx con la plantilla de la asistencia de los alumnos
	 * @param {Array} data la data que se va a convertir en xlsx
	 */
	function createXLSXTemplate(data, diasLaborables) {
		const mesActual = new Date().toLocaleString("es-ES", {
			month: "long",
		});
		const wb = XLSX.utils.book_new();

		const ws = XLSX.utils.json_to_sheet(data, [
			["Nro", "IUU", "Alumnos"],
			...diasLaborables,
		]);

		// ajustar los anchos de la columnas para nro iuu y alumnos y para el resto poner ancho de 5
		const wscols = [
			{ wch: 5 }, // Nro
			{ wch: 5 }, // IUU
			{ wch: 20 }, // Alumnos
			...diasLaborables.map(() => {
				return { wch: 10 };
			}),
		];
		ws["!cols"] = wscols;

		XLSX.utils.book_append_sheet(wb, ws, "Asistencia de " + mesActual);

		// Crear la tabla de leyenda para el docente
		const wsLeyenda = XLSX.utils.aoa_to_sheet([
			["Leyenda"],
			["A", "ASISTIÓ"],
			["F", "FALTÓ"],
			["T", "INASISTENCIA INJUSTIFICADA"],
			["J", "FALTA JUSTIFICADA"],
			["U", "TARDANZA JUSTIFICADA"],
		]);
		XLSX.utils.sheet_add_aoa(wsLeyenda, [["Tipos de Asistencia"]], {
			s: { r: 0, c: 0 },
			e: { r: 0, c: 1 },
		});
		XLSX.utils.sheet_add_aoa(wsLeyenda, [["Código", "Descripción"]], {
			s: { r: 1, c: 0 },
			e: { r: 1, c: 1 },
		});
		const wsLeyendaCols = [
			{ wch: 6 }, // Código
			{ wch: 20 }, // Descripción
		];
		wsLeyenda["!cols"] = wsLeyendaCols;
		XLSX.utils.book_append_sheet(wb, wsLeyenda, "Leyenda");

		const wbout = XLSX.write(wb, { bookType: "xlsx", type: "array" });
		const dataBlob = new Blob([wbout], {
			type: "application/octet-stream",
		});
		const url = URL.createObjectURL(dataBlob);
		const a = document.createElement("a");
		a.href = url;
		a.download = "asistencia_" + mesActual + ".xlsx";
		a.click();
		URL.revokeObjectURL(url);
	}
});
