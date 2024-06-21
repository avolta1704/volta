// Definición inicial de dataTableAdmisionAlumnos
$(document).ready(function () {
	// Ejecutar el evento change para que se actualice la tabla de admisionAlumnos
	$("#selectAnioEscolarAdmisionAlumnos").trigger("change");

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

// Crear Actualizar dataTableAdmisionAlumnos
function actualizarAdmisionAlumnos(response) {
	var tableAdmisionAlumno = $("#dataTableAdmisionAlumnos").DataTable();
	var data = new FormData();
	tableAdmisionAlumno.clear();
	tableAdmisionAlumno.rows.add(response);
	tableAdmisionAlumno.draw();
}

// Si se selecciona un año en el select #selectAnioEscolarAdmisionAlumnos, se actualiza la tabla de admisionAlumnos
$("#selectAnioEscolarAdmisionAlumnos").on("change", function () {
	var idAnioEscolar = $(this).val();
	var data = new FormData();
	data.append("todosLosAdmisionAlumnosAnio", idAnioEscolar);

	$.ajax({
		url: "ajax/admisionAlumnos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			actualizarAdmisionAlumnos(response);
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
