// Definición inicial de dataTablePagos
$(document).ready(function () {
	// Iniciar el select #selectAnioEscolarPagos change
	$("#selectAnioEscolarPagos").trigger("change");

	var columnDefsPagos = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "dniAlumno" },
		{ data: "nombreCompleto" },
		{ data: "fechaPago" },
		{ data: "metodoPago" },
		{ data: "tipoPago" },
		{ data: "mesPago" },
		{ data: "numeroComprobante" },
		{ data: "cantidadTotal" },
		{ data: "buttonsPago" },
	];

	var tablePagos = $("#dataTablePagos").DataTable({
		columns: columnDefsPagos,
	});

	// Titulo dataTablePagos
	$(".tituloPagos").text("Todos los Pagos");

	//Estructura de dataTablePagos
	$("#dataTablePagos thead").html(`
      <tr>
      <th scope="col">#</th>
      <th scope="col">Dni</th>
      <th scope="col">Nombres y Apellidos</th>
      <th scope="col">Fecha Pago</th>
      <th scope="col">Forma Pago</th>
      <th scope="col">Tipo de Pago</th>
      <th scope="col">Mes Pago</th>
      <th scope="col">Nro Comprobante</th>
      <th scope="col">Monto</th>
      <th scope="col">Acciones</th>
      </tr>
    `);

	tablePagos.destroy();

	columnDefsPagos = [
		{
			data: "null",
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "dniAlumno" },
		{ data: "nombreCompleto" },
		{ data: "fechaPago" },
		{ data: "metodoPago" },
		{ data: "tipoPago" },
		{ data: "mesPago" },
		{ data: "numeroComprobante" },
		{ data: "cantidadTotal" },
		{ data: "buttonsPago" },
	];
	tablePagos = $("#dataTablePagos").DataTable({
		columns: columnDefsPagos,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
});

// Crear Actualizar dataTablePagos
function actualizarPagos(response) {
	var tablePagos = $("#dataTablePagos").DataTable();
	var data = new FormData();
	tablePagos.clear();
	tablePagos.rows.add(response);
	tablePagos.draw();
}

// Si se selecciona un año en el select #selectAnioEscolarPagos, se actualiza la tabla de pagos
$("#selectAnioEscolarPagos").change(function () {
	var idAnioEscolar = $(this).val();
	var data = new FormData();
	data.append("todosLosPagosAnioEscolar", idAnioEscolar);
	$.ajax({
		url: "ajax/pagos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			actualizarPagos(response);
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
