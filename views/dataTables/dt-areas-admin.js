// Definición inicial de dataTableAreas
$(document).ready(function () {
	var columnDefsAreas = [{ data: "descripcion" }, { data: "buttons" }];

	var tableAreas = $("#dataTableAreas").DataTable({
		columns: columnDefsAreas,
	});

	// Titulo dataTableAreas
	$(".tituloAreas").text("Todos los Areas");

	//Solicitud ajx inicial de dataTableAreasAdmin
	var data = new FormData();
	data.append("mostrarTodasLasAreas", true);

	$.ajax({
		url: "ajax/areas.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			tableAreas.clear();
			tableAreas.rows.add(response);
			tableAreas.draw();
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

	//Estructura de dataTableAreas
	$("#dataTableAreas thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Descripción</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

	tableAreas.destroy();

	columnDefsAreas = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "descripcion" },
		{ data: "buttons" },
	];
	tableAreas = $("#dataTableAreas").DataTable({
		columns: columnDefsAreas,
	});
});
