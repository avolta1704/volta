$(document).ready(function () {
	// valores de los parametros de la URL
	const urlParams = new URLSearchParams(window.location.search);
	const idCurso = urlParams.get("idCurso");
	const idGrado = urlParams.get("idGrado");
	const idPersonal = urlParams.get("idPersonal");

	//Solicitud inicial de dataTableAlumnosCurso

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
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
});
