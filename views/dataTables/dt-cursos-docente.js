// Definición inicial de dataTableCursosDocente
$(document).ready(function () {
	var columnDefsDocente = [
		{ data: "idDocente" },
		{ data: "descripcionGrado" },
		{ data: "descripcionCurso" },
		{ data: "acciones" },
	];

	var tableDocente = $("#dataTableCursosDocente").DataTable({
		columns: columnDefsDocente,
	});

	// Titulo dataTableCursosDocente
	$(".tituloCursosDocente").text("Todos los cursos del Docente");

	//Solicitud inicial de dataTableCursosDocente
	var data = new FormData();
	data.append("todosLosCursosAsignados", true);

	$.ajax({
		url: "ajax/docentes.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			tableDocente.clear();
			tableDocente.rows.add(response);
			tableDocente.draw();
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

	//Estructura de dataTableCursosDocente
	$("#dataTableCursosDocente thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Grado</th>
      <th scope="col">Curso</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

	tableDocente.destroy();

	columnDefsDocente = [
		{
			data: null,
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "descripcionGrado" },
		{ data: "descripcionCurso" },
		{ data: "acciones" },
	];
	tableDocente = $("#dataTableCursosDocente").DataTable({
		columns: columnDefsDocente,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
});
