// Definición inicial de dataTableAdmisionAlumnos
$(document).ready(function () {
	var columnDefsAdmisionAlumno = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "codAlumnoCaja" },
		{ data: "apellidosAlumno" },
		{ data: "nombresAlumno" },
		{ data: "fechaAdmision" },
		{ data: "estadoAdmisionAlumno" },
		{ data: "buttonsAdmisionAlumno" },
	];

	var tableAdmisionAlumno = $("#dataTableAdmisionAlumnos").DataTable({
		columns: columnDefsAdmisionAlumno,
	});

	// Titulo dataTableAdmisionAlumnos
	$(".tituloAdmisionAlumnos").text("Lista de Matriculados");

	//Solicitud ajx inicial de dataTableAdmisionAlumnosAdmin
	var data = new FormData();
	data.append("registrosAdmisionAlumnos", true);

	$.ajax({
		url: "ajax/admisionAlumnos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			tableAdmisionAlumno.clear();
			tableAdmisionAlumno.rows.add(response);
			tableAdmisionAlumno.draw();
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

	//Estructura de dataTableAdmisionAlumnos
	$("#dataTableAdmisionAlumnos thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Código Caja</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Nombres</th>
        <th scope="col">Fecha Admision</th>
        <th scope="col">Estado</th>
        <th scope="col">Acciones</th
      </tr>
    `);

	tableAdmisionAlumno.destroy();

	columnDefsAdmisionAlumno = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "codAlumnoCaja" },
		{ data: "apellidosAlumno" },
		{ data: "nombresAlumno" },
		{ data: "fechaAdmision" },
		{ data: "estadoAdmisionAlumno" },
		{ data: "buttonsAdmisionAlumno" },
	];

	var tableAdmisionAlumno = $("#dataTableAdmisionAlumnos").DataTable({
		columns: columnDefsAdmisionAlumno,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
});
