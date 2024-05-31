// Definición inicial de dataTableUsuarios
$(document).ready(function () {
	// Obtener el idCurso de la URL
	const urlParams = new URLSearchParams(window.location.search);
	const idCurso = urlParams.get("idCurso");
	const idGrado = urlParams.get("idGrado");
	const idPersonal = urlParams.get("idPersonal");

	var columnDefsAlumnosCurso = [
		{ data: "idAlumno" },
		{ data: "nombresAlumno" },
		{ data: "apellidosAlumno" },
		{ data: "acciones" },
	];

	var tableAlumnosCurso = $("#dataTableNotasCursoDocente").DataTable({
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
	data.append("todosLosAlumnosCurso", JSON.stringify(dataListaAlumnosCurso));

	$.ajax({
		url: "ajax/alumnos.ajax.php",
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
	$("#dataTableNotasCursoDocente thead").html(`
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
	tableAlumnosCurso = $("#dataTableNotasCursoDocente").DataTable({
		columns: columnDefsAlumnosCurso,
	});
});
