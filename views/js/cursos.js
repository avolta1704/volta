// Agregar un nuevo curso
$("#btnRegistrarCursoModal").on("click", function () {
	// Toma los valores de los campos de entrada
	var descripcionCurso = $("#descripcionCurso").val();
	var idArea = $("#areaCurso").val();
	var estadoCurso = $("#estadoCurso").val();

	if (descripcionCurso == "") {
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "El campo de descripción no puede estar vacío",
			timer: 2000,
			showConfirmButton: true,
		});
		return;
	}

	if (idArea == "") {
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "Selecciona un área para el curso",
			timer: 2000,
			showConfirmButton: true,
		});
		return;
	}

	// Guarda los valores en los atributos 'value' de los campos de entrada
	$("#descripcionCurso").attr("value", descripcionCurso);
	$("#idArea").attr("value", idArea);
	$("#estadoCurso").attr("value", estadoCurso);

	// Crea un objeto con los datos
	var dataRegistrarCursoModal = {
		descripcionCurso: descripcionCurso,
		idArea: idArea,
		estadoCurso: estadoCurso,
		btnRegistrarCursoModal: btnRegistrarCursoModal,
	};

	// Crea un objeto FormData y añade el objeto
	var data = new FormData();
	data.append(
		"dataRegistrarCursoModal",
		JSON.stringify(dataRegistrarCursoModal)
	);

	// Envía los datos al servidor con una solicitud AJAX
	$.ajax({
		url: "ajax/cursos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "ok") {
				// Limpia los campos de entrada

				$("#descripcionCurso").val("");
				$("#idArea").val("");
				$("#estadoCurso").val("");
				// Cierra el modal
				$("#modalAgregarCurso").modal("hide");

				// Muestra el mensaje de "Registrado"
				Swal.fire({
					icon: "success",
					title: "Registrado",
					text: "Curso Registrado",
					showConfirmButton: true,
				}).then((result) => {
					location.reload();
				});
			}
		},
	});
});

// Eliminar un curso
$(".dataTableCursos").on("click", ".btnEliminarCurso", function (event) {
	event.stopPropagation();

	var idCurso = $(this).attr("idCurso");

	Swal.fire({
		title: "¿Estás seguro de eliminar el curso?",
		text: "¡Si no lo está, puede cancelar la acción!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "¡Sí, eliminar curso!",
	}).then((result) => {
		if (result.isConfirmed) {
			var data = new FormData();
			data.append("idCurso", idCurso);

			$.ajax({
				url: "ajax/cursos.ajax.php",
				method: "POST",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (response) {
					if (response == "ok") {
						Swal.fire({
							icon: "success",
							title: "¡El curso ha sido eliminado!",
							showConfirmButton: true,
							timer: 2000,
						}).then((result) => {
							location.reload();
						});
					} else if (response == "error") {
						Swal.fire({
							icon: "error",
							title: "No se pudo eliminar el curso. Es posible que esté en uso.",
							showConfirmButton: true,
							timer: 2000,
						});
					}
				},
			});
		}
	});
});

// Obtener datos a editar
$(".dataTableCursos").on("click", ".btnEditarCurso", function (event) {
	const modalEditarCurso = $("#modalEditarCurso");
	var idCurso = $(this).attr("idCurso");

	var data = new FormData();
	data.append("idCursoEditar", idCurso);
	data.append("btnEditarCurso", true);

	$.ajax({
		url: "ajax/cursos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "error") {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "El curso no pudo ser encontrada",
					timer: 2000,
					showConfirmButton: true,
				});
				return;
			}
			// Coloca el valor de response.descripcionCurso en un input
			$("#descripcionCursoEditar").val(response.descripcionCurso);
			$("#areaCursoEditar").val(response.idArea);
			$("#idCursoEditar").val(response.idCurso);
			$("#estadoCursoEditar").val(response.estadoCurso == 1 ? 1 : 0);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.error(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});

// Editar curso
$(".btnEditarCursoModal").on("click", function () {
	var idCurso = $("#idCursoEditar").val();
	var descripcionCurso = $("#descripcionCursoEditar").val();
	var idArea = $("#areaCursoEditar").val();
	var estadoCurso = $("#estadoCursoEditar").val();

	if (descripcionCurso == "") {
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "El campo de descripción no puede estar vacío",
			timer: 2000,
			showConfirmButton: true,
		});
		return;
	}

	if (idArea == "") {
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "Selecciona un área para el curso",
			timer: 2000,
			showConfirmButton: true,
		});
		return;
	}

	$("#descripcionCursoEditar").attr("value", descripcionCurso);
	$("#areaCursoEditar").attr("value", idArea);
	$("#estadoCursoEditar").attr("value", estadoCurso);

	var dataEditarCursoModal = {
		idCurso: idCurso,
		descripcionCurso: descripcionCurso,
		idArea: idArea,
		estadoCurso: estadoCurso,
		btnEditarCursoModal: true,
	};

	var data = new FormData();
	data.append("dataEditarCursoModal", JSON.stringify(dataEditarCursoModal));

	$.ajax({
		url: "ajax/cursos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "ok") {
				$("#descripcionCursoEditar").val("");
				$("#areaCursoEditar").val("");
				$("#idCursoEditar").val("");
				$("#estadoCursoEditar").val("");
				$("#modalEditarCurso").modal("hide");

				Swal.fire({
					icon: "success",
					title: "Editado",
					text: "Curso Editado",
					showConfirmButton: true,
				}).then((result) => {
					location.reload();
				});
			}
		},
	});
});
