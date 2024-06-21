// Definición inicial de dataTablePostulantes
$(document).ready(function () {
	// Titulo dataTablePostulantes
	$(".tituloPostulantes").text("Todos los Postulantes");

	// Lanzar el evento change para que se actualice la tabla de postulantes
	$("#selectAnioEscolarPostulantes").trigger("change");
});

// Crear o actualizar la información de la tabla de postulantes
function crearActualizarTablaPostulantesAdmin(response) {
	var columnDefsPostulantes = [
		{ data: "idPostulante" },
		{ data: "nombrePostulante" },
		{ data: "apellidoPostulante" },
		{ data: "dniPostulante" },
		{ data: "fechaPostulacion" },
		{ data: "descripcionGrado" },
		{ data: "statePostulante" },
		{ data: "pagoMatricula" },
		{ data: "buttonsPostulante" },
	];

	var tablePostulantes = $("#dataTablePostulantes").DataTable({
		columns: columnDefsPostulantes,
		retrieve: true,
		paging: false,
	});

	//Solicitud ajx inicial de dataTablePostulantesAdmin
	var data = new FormData();
	data.append("todosLosPostulantesAdmin", true);

	tablePostulantes.clear();
	tablePostulantes.rows.add(response);
	tablePostulantes.draw();

	//Estructura de dataTablePostulantes
	$("#dataTablePostulantes thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">DNI</th>
      <th scope="col">Fecha Postulación</th>
      <th scope="col">Grado Postulación</th>
      <th scope="col">Estado</th>
      <th scope="col">Matricula</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

	tablePostulantes.destroy();

	columnDefsPostulantes = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "nombrePostulante" },
		{ data: "apellidoPostulante" },
		{ data: "dniPostulante" },
		{ data: "fechaPostulacion" },
		{ data: "descripcionGrado" },
		{ data: "statePostulante" },
		{ data: "pagoMatricula" },
		{ data: "buttonsPostulante" },
	];
	tablePostulantes = $("#dataTablePostulantes").DataTable({
		columns: columnDefsPostulantes,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
}

// Si se selecciona un año en el select #selectAnioEscolarPostulantes, se actualiza la tabla de postulantes
$("#selectAnioEscolarPostulantes").on("change", function () {
	var idAnioEscolar = $(this).val();
	var data = new FormData();
	data.append("todosLosPostulantesAnio", idAnioEscolar);

	$.ajax({
		url: "ajax/postulantes.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			crearActualizarTablaPostulantesAdmin(response);
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
