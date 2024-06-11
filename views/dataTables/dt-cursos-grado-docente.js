// Definición inicial de dataTableCursosPorGrado

$("#dataTableDocentes").on(
	"click",
	".btnVisualizarAsignaciones",
	function () {
		
		const codPersonal = $(this).attr("codPersonal");


		// Definición de columnas
		var columnDefsCursosPorGrado = [
			{ data: "descripcionCurso" },
			{ data: "descripcionNivelGrado" },
			{ data: "buttons" },
		];

		// Inicialización de dataTableCursosPorGrado
		var tableCursosPorGrado = $("#dataTableCursosPorGradoPersonal").DataTable({
			columns: columnDefsCursosPorGrado,
			retrieve: true,
			paging: false,
		});

		var data = new FormData();
		data.append("codPersonal", codPersonal);
		data.append("btnListarCursosPorGrado", true);

		$.ajax({
			url: "ajax/docentes.ajax.php",
			method: "POST",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function (response) {
				tableCursosPorGrado.clear();
				tableCursosPorGrado.rows.add(response);
				tableCursosPorGrado.draw();
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

		// Estructura de dataTableCursosPorGrado
		$("#dataTableCursosPorGradoPersonal thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Curso</th>
		<th scope="col">Nivel y Grado</th>
        <th scope="col">Acciones</th>
      </tr>
    `);

		tableCursosPorGrado.destroy();

		columnDefsCursosPorGrado = [
			{
				data: "null",
				render: function (data, type, row, meta) {
					return meta.row + 1;
				},
			},
			{ data: "descripcionCurso" },
			{ data: "descripcionNivelGrado" },
			{ data: "buttons" },
		];

		tableCursosPorGrado = $("#dataTableCursosPorGradoPersonal").DataTable({
			columns: columnDefsCursosPorGrado,
			language: {
				url: "views/dataTables/Spanish.json",
			},
		});
	}
);
