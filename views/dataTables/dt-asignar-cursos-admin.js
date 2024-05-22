// Definición inicial de dataTableAsignarCursos
$(document).ready(function () {
	var columnDefsAsignarCursos = [
		{ data: "descripcionNivel" },
		{ data: "descripcionGrado" },
		{ data: "listaCursos" },
	];

	var tableAsignarCursos = $("#dataTableAsignarCursos").DataTable({
		columns: columnDefsAsignarCursos,
	});

	// Titulo dataTableAsignarCursos
	$(".tituloAsignarCursos").text("Asignar Cursos");

	//Solicitud ajx inicial de dataTableAsignarCursosAdmin
	var data = new FormData();
	data.append("todosLosAsignarCursosAdmin", true);

	$.ajax({
		url: "ajax/asignarCursos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			tableAsignarCursos.clear();
			tableAsignarCursos.rows.add(response);
			tableAsignarCursos.draw();
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

	//Estructura de dataTableAsignarCursos
	$("#dataTableAsignarCursos thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nivel</th>
      <th scope="col">Grado</th>
      <th scope="col">Lista Cursos</th>
    </tr>
    `);

	tableAsignarCursos.destroy();

	columnDefsAsignarCursos = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "descripcionNivel" },
		{ data: "descripcionGrado" },
		{ data: "listaCursos" },
	];
	tableAsignarCursos = $("#dataTableAsignarCursos").DataTable({
		columns: columnDefsAsignarCursos,
	});
});
