// Definición inicial de dataTableTecnicas
$(document).ready(function () {
	var columnDefsTecnicas = [
		{ data: "descripcionTecnica" },
    { data: "codTecnica" },
		{ data: "botonesTecnica" },
	];

	var tableTecnicas = $("#dataTableTecnicas").DataTable({
		columns: columnDefsTecnicas,
	});

	// Titulo dataTableTecnicas
	$(".tituloTecnica").text("Todas las Tecnicas");

	//  Solicitud ajax para listar los años escolares
	var data = new FormData();
	data.append("todaslasTecnicas", true);

	$.ajax({
		url: "ajax/tecnicaseInstrumentos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			tableTecnicas.clear();
			tableTecnicas.rows.add(response);
			tableTecnicas.draw();
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

	//Estructura de dataTableTecnicas
	$("#dataTableTecnicas thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Descripción Tecnica</th>
      <th scope="col">Código Tecnica</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

	tableTecnicas.destroy();

	columnDefsTecnicas = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "descripcionTecnica" },
    { data: "codTecnica" },
		{ data: "botonesTecnica" },
	];
	tableTecnicas = $("#dataTableTecnicas").DataTable({
		columns: columnDefsTecnicas,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
});
