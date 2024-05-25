//  Agregar un nuevo año escolar
$("#btnRegistrarAnioEscolar").on("click", function () {
	var descripcionAnio = $("#descripcionAnio").val();
  var cuotaIngreso = $("#cuotaIngreso").val();
  var matriculaInicial = $("#matriculaInicial").val();
  var pensionInicial = $("#pensionInicial").val();
  var matriculaPrimaria = $("#matriculaPrimaria").val();
  var pensionPrimaria = $("#pensionPrimaria").val();
  var matriculaSecundaria = $("#matriculaSecundaria").val();
  var pensionSecundaria = $("#pensionSecundaria").val();

	if (descripcionAnio == "") {
		Swal.fire({
			icon: "error",
			title: "Error",
			text: "El campo de descripción no puede estar vacío",
			timer: 2000,
			showConfirmButton: true,
		});
		return;
	}

	// Crea un objeto con los datos
	var dataRegistrarAnio = {
		descripcionAnio: descripcionAnio,
    cuotaIngreso: cuotaIngreso,
    matriculaInicial: matriculaInicial,
    pensionInicial: pensionInicial,
    matriculaPrimaria: matriculaPrimaria,
    pensionPrimaria: pensionPrimaria,
    matriculaSecundaria: matriculaSecundaria,
    pensionSecundaria: pensionSecundaria,
	};

	// Crea un objeto FormData y añade el objeto
	var data = new FormData();
	data.append(
		"dataRegistrarAnio",
		JSON.stringify(dataRegistrarAnio)
	);

	// Envía los datos al servidor con una solicitud AJAX
	$.ajax({
		url: "ajax/anioEscolar.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "ok") {
        //  Ocultar y limpiar campos
				$("#modalAgregarArea").modal("hide");
        $("#descripcionAnio").val("");
        $("#cuotaIngreso").val("");
        $("#matriculaInicial").val("");
        $("#pensionInicial").val("");
        $("#matriculaPrimaria").val("");
        $("#pensionPrimaria").val("");
        $("#matriculaSecundaria").val("");
        $("#pensionSecundaria").val("");

				Swal.fire({
					icon: "success",
					title: "Registrado",
					text: "Año Escolar Registrado",
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
				text: "Error al crear el Año Escolar",
				timer: 2000,
				showConfirmButton: true,
			});
			// Muestra el mensaje de error
			console.error(
				"Error al crear el Año Escolar: ",
				textStatus,
				errorThrown
			);
		},
	});
});