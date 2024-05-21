// Agregar un nuevo curso
$("#btnRegistrarCursoModal").on("click", function () {
	// Toma los valores de los campos de entrada
	var descripcionCurso = $("#descripcionCurso").val();
	var idArea = $("#areaCurso").val();

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

	// Crea un objeto con los datos
	var dataRegistrarCursoModal = {
		descripcionCurso: descripcionCurso,
		idArea: idArea,
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
