// Definición inicial de dataTableReportesAdmisiones
$(document).ready(function () {
	var columnDefsAdmisiones = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "apellidosAlumno" },
		{ data: "nombresAlumno" },
		{ data: "estadoAdmisionAlumno" },
		{ data: "acciones" },
	];

	var tableReportesAdmisiones = $("#dataTableReportesAdmisiones").DataTable({
		columns: columnDefsAdmisiones,
	});

	//Estructura de dataTableReportesAdmisiones
	$("#dataTableReportesAdmisiones thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Nombres</th>
        <th scope="col">Estado</th>
        <th scope="col">Acciones</th>
      </tr>
    `);

	tableReportesAdmisiones.destroy();

	columnDefsAdmisiones = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "apellidosAlumno" },
		{ data: "nombresAlumno" },
		{ data: "estadoAdmisionAlumno" },
		{ data: "acciones" },
	];
	tableReportesAdmisiones = $("#dataTableReportesAdmisiones").DataTable({
		columns: columnDefsAdmisiones,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});

	// Titulo dataTableReportesAdmisiones
	$(".tituloReportesAdmisiones").text("Reportes de Admisiones");

	//Solicitud ajx inicial de dataTableReportesAdmisionesAdmin
	var data = new FormData();
	data.append("todosLasAdmisiones", true);
	$.ajax({
		url: "ajax/reportesAdmisiones.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			tableReportesAdmisiones.clear();
			tableReportesAdmisiones.rows.add(response);
			tableReportesAdmisiones.draw();
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
