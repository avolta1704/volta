// Definición inicial de dataTableUsuarios
$(document).ready(function () {
	// Obtener el idCurso de la URL
	const urlParams = new URLSearchParams(window.location.search);
	const idCurso = urlParams.get("idCurso");
	const idGrado = urlParams.get("idGrado");
	const idPersonal = urlParams.get("idPersonal");

	var columnDefsAlumnosCurso = [
		{ data: "idAlumno" },
		{ data: "nombresAlumno" },
		{ data: "apellidosAlumno" },
		{ data: "descripcionBimestre" }, // nueva columna
		{ data: "descripcionUnidad" }, // nueva columna
		{ data: "acciones" },
	];

	var tableAlumnosCurso = $("#dataTableNotasCursoDocente").DataTable({
		columns: columnDefsAlumnosCurso,
		retrieve: true,
		paging: false,
	});

	$("#secondButtonContainer").on("click", "#btnUnidad", function () {
		var idUnidad = $(this).data("idUnidad"); // Obtener idUnidad
		var idBimestre = $(this).data("idBimestre"); // Obtener idBimestre
		crearButtons(idUnidad, idBimestre);

		const dataListaAlumnosCurso = {
			idCurso: idCurso,
			idGrado: idGrado,
			idPersonal: idPersonal,
			idUnidad: idUnidad,
			idBimestre: idBimestre,
			todosLosAlumnosCurso: true,
		};

		// crear la formdata con datalistaAlumnosCurso
		var data = new FormData();
		data.append(
			"todosLosAlumnosCursoNotas",
			JSON.stringify(dataListaAlumnosCurso)
		);

		$.ajax({
			url: "ajax/alumnos.ajax.php",
			method: "POST",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",

			success: function (response) {
				// Limpiar el DataTable
				tableAlumnosCurso.clear().draw();
				tableAlumnosCurso.rows.add(response);
				tableAlumnosCurso.draw();
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

	//Estructura de dataTableAlumnosCurso
	$("#dataTableNotasCursoDocente thead").html(`
	<tr>
	  <th scope="col">#</th>
	  <th scope="col">Nombre</th>
	  <th scope="col">Apellido</th>
	  <th scope="col">Bimestre</th> <!-- nuevo encabezado de columna -->
	  <th scope="col">Unidad</th> <!-- nuevo encabezado de columna -->
	  <th scope="col">Acciones</th>
	</tr>
	`);

	tableAlumnosCurso.destroy();

	columnDefsAlumnosCurso = [
		{
			data: null,
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "nombresAlumno" },
		{ data: "apellidosAlumno" },
		{ data: "descripcionBimestre" }, // nueva columna
		{ data: "descripcionUnidad" }, // nueva columna
		{ data: "acciones" },
	];
	tableAlumnosCurso = $("#dataTableNotasCursoDocente").DataTable({
		columns: columnDefsAlumnosCurso,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
});

function crearButtons(idUnidad, idBimestre) {
	var buttonNames = [
		{
			text: "Ver Competencias",
			class: "btn btn-secondary",
			id: "btnVerCompetencias",
		},
		{
			text: "Registrar Notas",
			class: "btn btn-success",
			id: "btnRegistrarNotas",
		},
		{ text: "Cerrar Notas", class: "btn btn-danger", id: "btnCerrarNotas" },
	];

	const buttonContainer = $("#thirdButtonContainer");
	buttonContainer.empty(); // Limpiar el contenedor de botones

	buttonNames.forEach((button) => {
		const btn = $("<button></button>")
			.attr("type", "button")
			.attr("id", button.id)
			.attr("idUnidad", idUnidad)
			.attr("idBimestre", idBimestre)
			.addClass(button.class)
			.text(button.text)
			.css("margin-right", "10px") // Añadir margen a cada botón
			.data("idUnidad", idUnidad) // Guardar idUnidad en data
			.data("idBimestre", idBimestre); // Guardar idBimestre en data
		buttonContainer.append(btn);
	});
}
