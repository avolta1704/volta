// Definición inicial de dataTableCursosPorGrado
$("#dataTableAsignarCursos").on(
	"click",
	".btnListarCursosPorGrado",
	function () {
		const idGrado = $(this).attr("idGrado");

		// Asignar idGrado a un atributo del btnAsignarNuevoCurso
		$("#btnAsignarNuevoCurso").attr("idGrado", idGrado);

		// Definición de columnas
		var columnDefsCursosPorGrado = [
			{ data: "idCurso" },
			{ data: "descripcionCurso" },
			{ data: "buttons" },
		];

		// Inicialización de dataTableCursosPorGrado
		var tableCursosPorGrado = $("#dataTableCursosPorGrado").DataTable({
			columns: columnDefsCursosPorGrado,
			retrieve: true,
			paging: false,
		});

		var data = new FormData();
		data.append("idGrado", idGrado);
		data.append("btnListarCursosPorGrado", true);

		$.ajax({
			url: "ajax/asignarCursos.ajax.php",
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
		$("#dataTableCursosPorGrado thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Curso</th>
        <th scope="col">Acciones</th>
      </tr>
    `);

		tableCursosPorGrado.destroy();

		columnDefsCursosPorGrado = [
			{ data: "idCurso" },
			{ data: "descripcionCurso" },
			{ data: "buttons" },
		];

		tableCursosPorGrado = $("#dataTableCursosPorGrado").DataTable({
			columns: columnDefsCursosPorGrado,
		});
	}
);
