// Definición inicial de dataTableAsignarCursos
$(document).ready(function () {
	var columnDefsAsignarCursos = [
		{ data: "descripcionNivel" },
		{ data: "descripcionGrado" },
		{ data: "botonesGrado" },
	];

	var tableAsignarCursos = $("#dataTableCerrarAnioGrados").DataTable({
		columns: columnDefsAsignarCursos,
	});

	// Titulo dataTableAsignarCursos
	$(".tituloCerraAnioGrado").text("Grados");

	//Solicitud ajx inicial de dataTableAsignarCursosAdmin
	var data = new FormData();
	data.append("todosLosGradosCerrarAnioEscolar", true);

	$.ajax({
		url: "ajax/anioEscolar.ajax.php",
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
	$("#dataTableCerrarAnioGrados thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nivel</th>
      <th scope="col">Grado</th>
      <th scope="col">Acciones</th>
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
		{ data: "botonesGrado" },
	];
	tableAsignarCursos = $("#dataTableCerrarAnioGrados").DataTable({
		columns: columnDefsAsignarCursos,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
});
