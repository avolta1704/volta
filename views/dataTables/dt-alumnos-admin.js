// Definición inicial de dataTableAlumnos
$(document).ready(function () {
	// Iniciar el select #selectAnioEscolarAlumnos change
	$("#selectAnioEscolarAlumnos").trigger("change");

	var columnDefsAlumno = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "apellidosAlumno" },
		{ data: "nombresAlumno" },
		{ data: "codAlumnoCaja" },
		{ data: "dniAlumno" },
		{ data: "sexoAlumno" },
		{ data: "stateAlumno" },
		{ data: "descripcionNivel" },
		{ data: "descripcionGrado" },
		{ data: "buttonsAlumno" },
	];

	var tableAlumno = $("#dataTableAlumnos").DataTable({
		columns: columnDefsAlumno,
	});

	// Titulo dataTableAlumnos
	$(".tituloAlumnos").text("Todos los Alumnos");

	//Estructura de dataTableAlumnos
	$("#dataTableAlumnos thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Nombres</th>
        <th scope="col">Sexo</th>
        <th scope="col">Cod Caja</th>
        <th scope="col">DNI</th>
        <th scope="col">Estado</th>
        <th scope="col">Nivel</th>
        <th scope="col">Grado</th>
        <th scope="col">Acciones</th>
      </tr>
    `);

	tableAlumno.destroy();

	columnDefsAlumno = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "apellidosAlumno" },
		{ data: "nombresAlumno" },
		{ data: "sexoAlumno" },
		{ data: "codAlumnoCaja" },
		{ data: "dniAlumno" },
		{ data: "stateAlumno" },
		{ data: "descripcionNivel" },
		{ data: "descripcionGrado" },
		{ data: "buttonsAlumno" },
	];
	tableAlumno = $("#dataTableAlumnos").DataTable({
		columns: columnDefsAlumno,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
});

// Crear Actualizar dataTableAlumnos
function actualizarAlumnos(response) {
	var tableAlumno = $("#dataTableAlumnos").DataTable();
	var data = new FormData();
	tableAlumno.clear();
	tableAlumno.rows.add(response);
	tableAlumno.draw();
}

// Si se selecciona un año en el select #selectAnioEscolarAlumnos, se actualiza la tabla de alumnos
$("#selectAnioEscolarAlumnos").on("change", function () {
	var idAnioEscolar = $(this).val();
	var data = new FormData();
	data.append("todosLosAlumnosAnio", idAnioEscolar);

	$.ajax({
		url: "ajax/alumnos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			actualizarAlumnos(response);
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
