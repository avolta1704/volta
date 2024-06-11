// Definición inicial de dataTableReportesPensiones
$(document).ready(function () {
	var columnDefsPagos = [
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
		{ data: "mesPendientePago" },
		{ data: "montoDeuda" },
		{ data: "fechaLimitePago" },
		{ data: "acciones" },
	];

	var tableReportesPensiones = $("#dataTableReportesPensiones").DataTable({
		columns: columnDefsPagos,
	});

	//Estructura de dataTableReportesPensiones
	$("#dataTableReportesPensiones thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Alumno</th>
        <th scope="col">DNI</th>
        <th scope="col">Grado</th>
        <th scope="col">Nivel</th>
        <th scope="col">Mes Pendiente</th>
        <th scope="col">Monto Deuda</th>
        <th scope="col">Fecha Limite</th>        
        <th scope="col">Acciones</th>
      </tr>
    `);

	tableReportesPensiones.destroy();

	columnDefsPagos = [
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
		{ data: "mesPendientePago" },
		{ data: "montoDeuda" },
		{ data: "fechaLimitePago" },
		{ data: "acciones" },
	];
	tableReportesPensiones = $("#dataTableReportesPensiones").DataTable({
		columns: columnDefsPagos,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});

	// Titulo dataTableReportesPensiones
	$(".tituloReportesPensiones").text("Reportes de Pensiones Retrasadas");

	//Solicitud ajx inicial de dataTableReportesPensionesAdmin
	var data = new FormData();
	data.append("todosLosPensionesPendientes", true);
	$.ajax({
		url: "ajax/reportesPensiones.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			tableReportesPensiones.clear();
			tableReportesPensiones.rows.add(response);
			tableReportesPensiones.draw();
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
