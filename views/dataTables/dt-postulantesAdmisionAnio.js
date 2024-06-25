// Definición inicial de dataTablePostulantesReporteAnio
$(document).ready(function () {
	var columnDefsPostulantesReport = [
		{ data: "apellidoNombre" },
		{ data: "dniPostulante" },
		{ data: "fechaPostulacion" },
		{ data: "nivelAnioPostulante" },
		{ data: "GradoAnioPostulante" },
		{ data: "statePostulante" },
	];

	var tablePostulantesReport = $(
		"#dataTablePostulantesReporteAnio"
	).DataTable({
		columns: columnDefsPostulantesReport,
	});

	// Titulo dataTablePostulantesReporteAnio
	$(".tituloPostulantesReportAnio").text(
		"Reporte Todos los Postulantes Registrados Anual y Mensualmente"
	);

	//Solicitud ajx inicial de dataTablePostulantesReporteAnioAdmin
	var data = new FormData();
	data.append("todosLosPostulantesReportesAnio", true);

	$.ajax({
		url: "ajax/postulantes.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			tablePostulantesReport.clear();
			tablePostulantesReport.rows.add(response);
			tablePostulantesReport.draw();
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

	//Estructura de dataTablePostulantesReporteAnio
	$("#dataTablePostulantesReporteAnio thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Apellidos Nombres</th>
      <th scope="col">DNI</th>
      <th scope="col">Fecha Postulación</th>
      <th scope="col">Nivel Postulación</th>
      <th scope="col">Grado Postulación</th>
      <th scope="col">Estado</th>
    </tr>
    `);

	tablePostulantesReport.destroy();

	columnDefsPostulantesReport = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "apellidoNombre" },
		{ data: "dniPostulante" },
		{ data: "fechaPostulacion" },
		{ data: "nivelAnioPostulante" },
		{ data: "GradoAnioPostulante" },
		{ data: "statePostulante" },
	];
	tablePostulantesReport = $("#dataTablePostulantesReporteAnio").DataTable({
		columns: columnDefsPostulantesReport,
	});
});
