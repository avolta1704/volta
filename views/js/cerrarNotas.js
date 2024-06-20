// Btn para cerrar notas criterios
$("#btnCerrarNotasCriterios").click(function () {
	// Ids en los atributos del boton
	var idGrado = $(this).attr("idGrado");
	var idCurso = $(this).attr("idCurso");
	var idPersonal = $(this).attr("idPersonal");
	var idBimestre = $(this).attr("idBimestre");
	var idUnidad = $(this).attr("idUnidad");

	const dataCriterios = {
		idGrado: idGrado,
		idCurso: idCurso,
		idPersonal: idPersonal,
		idBimestre: idBimestre,
		idUnidad: idUnidad,
	};
	Swal.fire({
		title: "¿Está seguro de cerrar las notas?",
		text: "Una vez cerradas las notas de los criterios, no podrá modificarlas",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Cerrar notas",
		cancelButtonText: "Cancelar",
	}).then((result) => {
		if (result.isConfirmed) {
			var data = new FormData();
			data.append("cerrarNotasCriterios", JSON.stringify(dataCriterios));
			$.ajax({
				url: "ajax/cerrarNotas.ajax.php",
				method: "POST",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (response) {
					if (response == "ok") {
						Swal.fire({
							title: "¡Notas cerradas!",
							text: "Las notas de los criterios han sido cerradas",
							icon: "success",
							showCancelButton: false,
							timer: 1500,
						});
						// Redireccionar a la vista de notas
						window.location =
							"index.php?ruta=notasCursoDocente&idCurso=" +
							idCurso +
							"&idGrado=" +
							idGrado +
							"&idPersonal=" +
							idPersonal;
					} else if (response == "sin notas") {
						Swal.fire({
							title: "¡Error!",
							text: "Ingresar todas las notas de los criterios",
							icon: "error",
							showCancelButton: false,
							timer: 1500,
						});
					} else if (response == "sin competencias") {
						Swal.fire({
							title: "¡Error!",
							text: "Ingresar todas las competencias",
							icon: "error",
							showCancelButton: false,
							timer: 1500,
						});
						setTimeout(() => {
							window.location =
								"index.php?ruta=notasCursoDocente&idCurso=" +
								idCurso +
								"&idGrado=" +
								idGrado +
								"&idPersonal=" +
								idPersonal;
						}, 2000);
					} else if (response == "error") {
						Swal.fire({
							title: "¡Error!",
							text: "No se pudo cerrar las notas",
							icon: "error",
							showCancelButton: false,
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
});
