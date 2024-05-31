$("#btnAsignarNuevoCurso").on("click", function () {
	// Obtener idGrado del btnAsignarNuevoCurso
	const idGrado = $(this).attr("idGrado");

	// Obtener el select para asignar cursos
	const selectCursos = $("#selectCursos");

	//ajax para obtener cursos no asignados
	var data = new FormData();
	data.append("idGradoAsignar", idGrado);
	data.append("btnAsignarNuevoCurso", true);

	$.ajax({
		url: "ajax/asignarCursos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			// Limpiar selectCursos
			selectCursos.empty();

			// Agregar cursos no asignados al select
			$.each(response, function (index, curso) {
				selectCursos.append(
					$("<option>", {
						value: curso.idCurso,
						text: curso.descripcionCurso,
					})
				);
			});
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

$("#btnGuardarAsignacionCurso").on("click", function () {
	// Obtener idGrado del btnAsignarNuevoCurso
	const idGrado = $("#btnAsignarNuevoCurso").attr("idGrado");

	// Obtener el select para asignar cursos
	const selectCursos = $("#selectCursos");

	// Obtener el idCurso seleccionado
	const idCurso = selectCursos.val();

	const dataAsignarCurso = {
		idGradoAsignar: idGrado,
		idCursoAsignar: idCurso,
		btnGuardarAsignacionCurso: true,
	};

	//ajax para guardar asignacion de curso
	var data = new FormData();
	data.append("dataAsignarCurso", JSON.stringify(dataAsignarCurso));

	$.ajax({
		url: "ajax/asignarCursos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "ok") {
				// Limpiar selectCursos
				selectCursos.empty();

				// Cerrar modal
				$("#modalAsignarNuevoCurso").modal("hide");

				// Mostrar mensaje de exito
				Swal.fire({
					icon: "success",
					title: "¡Asignación de curso exitosa!",
					showConfirmButton: false,
					timer: 1500,
				});
			} else {
				// Mostrar mensaje de error
				Swal.fire({
					icon: "error",
					title: "¡Error al asignar curso!",
					showConfirmButton: false,
					timer: 1500,
				});
			}
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

// Eliminar asignacion de curso
$("#dataTableCursosPorGrado").on(
	"click",
	"#btnEliminarCursoAsignado",
	function () {
		// Obtener idCursoGrado del btnEliminarCursoAsignado
		const idCursoGrado = $(this).attr("idCursoGrado");

		const dataEliminarCurso = {
			idCursoGrado: idCursoGrado,
			btnEliminarCursoAsignado: true,
		};

		Swal.fire({
			title: "¿Estás seguro de eliminar la asignación de este curso?",
			text: "¡Esta acción no se puede revertir!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Sí, eliminar",
		}).then((result) => {
			if (result.isConfirmed) {
				//ajax para eliminar asignacion de curso
				var data = new FormData();
				data.append(
					"dataEliminarCurso",
					JSON.stringify(dataEliminarCurso)
				);

				$.ajax({
					url: "ajax/asignarCursos.ajax.php",
					method: "POST",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function (response) {
						if (response == "ok") {
							// Cerrar modal
							$("#modalListarCursos").modal("hide");

							// Mostrar mensaje de exito
							Swal.fire({
								icon: "success",
								title: "¡Eliminación de curso exitosa!",
								showConfirmButton: false,
								timer: 1500,
							}).then((result) => {
								location.reload();
							});
						} else {
							// Mostrar mensaje de error
							Swal.fire({
								icon: "error",
								title: "¡Error al eliminar curso!",
								showConfirmButton: false,
								timer: 1500,
							});
						}
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
			}
		});
	}
);


