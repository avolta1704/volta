// Definición inicial de dataTableReportesComunicaciones
$(document).ready(function () {
	var columnDefsComunicaciones = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "nombreAlumno" },
		{ data: "dniAlumno" },
		{ data: "gradoAlumno" },
		{ data: "nivelAlumno" },
		{ data: "acciones" },
	];

	var tableReportesComunicaciones = $(
		"#dataTableReportesComunicaciones"
	).DataTable({
		columns: columnDefsComunicaciones,
	});

	//Estructura de dataTableReportesComunicaciones
	$("#dataTableReportesComunicaciones thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Alumno</th>
        <th scope="col">DNI</th>
        <th scope="col">Grado</th>
        <th scope="col">Nivel</th>
        <th scope="col">Acciones</th>
      </tr>
    `);

	tableReportesComunicaciones.destroy();

	columnDefsComunicaciones = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "nombreAlumno" },
		{ data: "dniAlumno" },
		{ data: "gradoAlumno" },
		{ data: "nivelAlumno" },
		{ data: "acciones" },
	];
	tableReportesComunicaciones = $(
		"#dataTableReportesComunicaciones"
	).DataTable({
		columns: columnDefsComunicaciones,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});

	// Titulo dataTableReportesComunicaciones
	$(".tituloReportesComunicaciones").text("Reportes de Comunicaciones");

	//Solicitud ajx inicial de dataTableReportesComunicacionesAdmin
	var data = new FormData();
	data.append("todosLosComunicados", true);
	$.ajax({
		url: "ajax/reportesComunicados.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			tableReportesComunicaciones.clear();
			tableReportesComunicaciones.rows.add(response);
			tableReportesComunicaciones.draw();
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
