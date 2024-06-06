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
