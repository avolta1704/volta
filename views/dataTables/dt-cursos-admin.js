// Definición inicial de dataTableCursos
$(document).ready(function () {
	var columnDefsCursos = [
		{ data: "idCurso" },
		{ data: "areaCurso" },
		{ data: "nombreCurso" },
		{ data: "estadoCurso" },
		{ data: "buttonsCurso" },
	];

	var tableCursos = $("#dataTableCursos").DataTable({
		columns: columnDefsCursos,
	});

	// Titulo dataTableCursos
	$(".tituloCursos").text("Todos los Cursos");

	//Solicitud ajx inicial de dataTableCursosAdmin
	var data = new FormData();
	data.append("todosLosCursosAdmin", true);

	$.ajax({
		url: "ajax/cursos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			tableCursos.clear();
			tableCursos.rows.add(response);
			tableCursos.draw();
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

	//Estructura de dataTableCursos
	$("#dataTableCursos thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Área</th>
      <th scope="col">Curso</th>
      <th scope="col">Estado</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

	tableCursos.destroy();

	columnDefsCursos = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "areaCurso" },
		{ data: "nombreCurso" },
		{ data: "estadoCurso" },
		{ data: "buttonsCurso" },
	];
	tableCursos = $("#dataTableCursos").DataTable({
		columns: columnDefsCursos,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
});
