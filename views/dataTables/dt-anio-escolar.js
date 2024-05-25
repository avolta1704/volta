// Definición inicial de dataTableAnios
$(document).ready(function () {
	var columnDefsAnios = [
		{ data: "descripcionAnio" },
    { data: "estadoAnio" },
		{ data: "cuotaInicial" },
		{ data: "botonesAnio" },
	];

	var tableAnio = $("#dataTableAnios").DataTable({
		columns: columnDefsAnios,
	});

	// Titulo dataTableAnios
	$(".tituloAnio").text("Todos los Años Escolares");

	//  Solicitud ajax para listar los años escolares
	var data = new FormData();
	data.append("todoslosAnios", true);

	$.ajax({
		url: "ajax/anioEscolar.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			tableAnio.clear();
			tableAnio.rows.add(response);
			tableAnio.draw();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText);
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});

	//Estructura de dataTableAnios
	$("#dataTableAnios thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Descripción Año</th>
      <th scope="col">Estado</th>
      <th scope="col">Cuota de Ingreso</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

	tableAnio.destroy();

	columnDefsAnios = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "descripcionAnio" },
    { data: "estadoAnio" },
		{ data: "cuotaInicial" },
		{ data: "botonesAnio" },
	];
	tableAnio = $("#dataTableAnios").DataTable({
		columns: columnDefsAnios,
	});
});
