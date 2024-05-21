// Agregar un evento personalizado después de registrar un dato
$(".btnRegistrarAreaModal").on("click", function () {
	// Toma los valores de los campos de entrada
	var descripcionArea = $("#descripcionArea").val();

	if (descripcionArea == "") {
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "El campo de descripción no puede estar vacío",
			timer: 2000,
			showConfirmButton: true,
		});
		return;
	}

	// Guarda los valores en los atributos 'value' de los campos de entrada
	$("#descripcionArea").attr("value", descripcionArea);

	// Crea un objeto con los datos
	var dataRegistrarAreaModal = {
		descripcionArea: descripcionArea,
		btnRegistrarAreaModal: btnRegistrarAreaModal,
	};

	// Crea un objeto FormData y añade el objeto
	var data = new FormData();
	data.append(
		"dataRegistrarAreaModal",
		JSON.stringify(dataRegistrarAreaModal)
	);

	// Envía los datos al servidor con una solicitud AJAX
	$.ajax({
		url: "ajax/areas.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "ok") {
				// Limpia los campos de entrada

				$("#descripcionArea").val("");
				// Cierra el modal
				$("#modalAgregarArea").modal("hide");

				// Muestra el mensaje de "Registrado"
				Swal.fire({
					icon: "success",
					title: "Registrado",
					text: "Área Registrada",
					showConfirmButton: true,
				}).then((result) => {
					location.reload();
				});
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			Swal.fire({
				icon: "error",
				title: "Error",
				text: "Error en la solicitud AJAX",
				timer: 2000,
				showConfirmButton: true,
			});
			// Muestra el mensaje de error
			console.error(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});
//eliminar area
$(".dataTableAreas").on("click", ".btnEliminarArea", function (event) {
	event.stopPropagation();

	var idArea = $(this).attr("idArea");

	Swal.fire({
		title: "¿Estás seguro de eliminar el área?",
		text: "¡Si no lo está, puedes cancelar la acción!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "¡Sí, eliminar área!",
		cancelButtonText: "Cancelar",
	}).then((result) => {
		if (result.isConfirmed) {
			var data = new FormData();
			data.append("idArea", idArea);
			data.append("btnEliminarArea", true);

			$.ajax({
				url: "ajax/areas.ajax.php",
				method: "POST",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (response) {
					if (response == "ok") {
						Swal.fire(
							"¡Eliminado!",
							"El área ha sido eliminada.",
							"success"
						).then((result) => {
							location.reload();
						});
					} else if (response == "error") {
						Swal.fire(
							"Error",
							"El área no pudo ser eliminada. Está siendo utilizada en un registro.",
							"error"
						);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.error(
						"Error en la solicitud AJAX: ",
						textStatus,
						errorThrown
					);
				},
			});
		}
	});
});

// modal editar area
$(".dataTableAreas").on("click", ".btnEditarArea", function () {
	const modalEditarArea = $("#modalEditarArea");
	var idArea = $(this).attr("idArea");

	var data = new FormData();
	data.append("idAreaEditar", idArea);
	data.append("btnEditarArea", true);

	$.ajax({
		url: "ajax/areas.ajax.php",
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
					text: "El área no pudo ser encontrada",
					timer: 2000,
					showConfirmButton: true,
				});
				return;
			}
			// Coloca el valor de response.descripcionArea en un input
			$("#descripcionAreaEditar").val(response.descripcionArea);
			$("#idAreaEditar").val(response.idArea);
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

// editar area
$(".btnEditarAreaModal").on("click", function () {
	const modalEditarArea = $("#modalEditarArea");
	var idArea = $("#idAreaEditar").val();

	var descripcionArea = $("#descripcionAreaEditar").val();

	if (descripcionArea == "") {
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "El campo de descripción no puede estar vacío",
			timer: 2000,
			showConfirmButton: true,
		});
		return;
	}

	var dataEditarAreaModal = {
		idArea: idArea,
		descripcionArea: descripcionArea,
		btnEditarAreaModal: true,
	};

	var data = new FormData();
	data.append("dataEditarAreaModal", JSON.stringify(dataEditarAreaModal));

	$.ajax({
		url: "ajax/areas.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "ok") {
				$("#descripcionAreaEditar").val("");
				$("#modalEditarArea").modal("hide");

				Swal.fire({
					icon: "success",
					title: "Editado",
					text: "Área Editada",
					showConfirmButton: true,
				}).then((result) => {
					location.reload();
				});
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			Swal.fire({
				icon: "error",
				title: "Error",
				text: "Error en la solicitud AJAX",
				timer: 2000,
				showConfirmButton: true,
			});
			console.error(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});
