// Redireccionar a la vista de registrarNotas
$("#thirdButtonContainer").on("click", "#btnRegistrarNotas", function () {
	// Obtener idGrado, idCurso, idPersonal de la url
	var url = window.location.href;
	var idGrado = url.split("idGrado=")[1].split("&")[0];
	var idCurso = url.split("idCurso=")[1].split("&")[0];
	var idPersonal = url.split("idPersonal=")[1];

	// Obtener idBimestre y idUnidad del boton
	var idBimestre = $(this).attr("idBimestre");
	var idUnidad = $(this).attr("idUnidad");

	// Redireccionar a la vista de registrarNotas
	window.location = `index.php?ruta=registrarNotas&idGrado=${idGrado}&idCurso=${idCurso}&idPersonal=${idPersonal}&idBimestre=${idBimestre}&idUnidad=${idUnidad}`;
});

// Obtener idGrado, idCurso, idPersonal, idBimestre y idUnidad de la url
function getUrlVars() {
	var url = window.location.href;
	var idGrado = url.split("idGrado=")[1].split("&")[0];
	var idCurso = url.split("idCurso=")[1].split("&")[0];
	var idPersonal = url.split("idPersonal=")[1].split("&")[0];
	var idBimestre = url.split("idBimestre=")[1].split("&")[0];
	var idUnidad = url.split("idUnidad=")[1];

	return { idGrado, idCurso, idPersonal, idBimestre, idUnidad };
}

// Función para obtener el HTML del select
function getSelectHTML(data, idCompetencia, idCriterio) {
	if (
		data.htmlNotas &&
		data.htmlNotas[idCompetencia] &&
		data.htmlNotas[idCompetencia][idCriterio]
	) {
		return data.htmlNotas[idCompetencia][idCriterio];
	} else {
		return (
			"<select class='form-control selectNota' data-id-competencia='" +
			idCompetencia +
			"' data-id-criterio='" +
			idCriterio +
			"'><option value='0'>Seleccione</option></select>"
		);
	}
}

// Crear y actualizar la DataTable
function actualizarDataTable(
	idCurso,
	idGrado,
	idPersonal,
	idUnidad,
	idBimestre
) {
	//Solicitud inicial de notas
	const dataNotas = {
		idCurso: idCurso,
		idGrado: idGrado,
		idPersonal: idPersonal,
		idUnidad: idUnidad,
		idBimestre: idBimestre,
	};
	var data = new FormData();
	data.append("todasLasNotasDeAlumnos", JSON.stringify(dataNotas));

	$.ajax({
		url: "ajax/notas.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "sin criterios") {
				Swal.fire({
					icon: "warning",
					title: "No se encontraron criterios",
					text: "Alguna competencia no se tiene criterios asignados",
				});
			} else {
				// convertir objeto a array
				const dataAlumnosConNotas = Object.values(
					response.alumnosConNotas
				);
				const competencias = Object.values(response.competencias);

				var columnDefsNotas = [
					{ data: "idUsuario" },
					{ data: "nombreUsuario" },
					{ data: "apellidoUsuario" },
				];

				var tableNotas = $("#dataTableNotasAlumnos").DataTable({
					columns: columnDefsNotas,
					retrieve: true,
					paging: false,
				});

				$("#dataTableNotasAlumnos thead").html(`
				<tr>
					<th scope="col" rowspan=2>#</th>
					<th scope="col" rowspan=2>Nombres</th>
					<th scope="col" rowspan=2>Apellidos</th>
					${competencias
						.map(
							(competencia) =>
								`<th scope="col" colspan=${competencia.criterios.length} >${competencia.descripcionCompetencia}</th>`
						)
						.join("")}
					}
				</tr>
				<tr>
					${competencias
						.map((competencia) =>
							competencia.criterios
								.map(
									(criterio, index) =>
										`<th scope="col">
									CRT${(index + 1).toString().padStart(2, "0")} 
									<span class="text-primary"
       							data-bs-toggle="tooltip" data-bs-placement="top"
        						data-bs-custom-class="custom-tooltip"
        						data-bs-title="${criterio.descripcionCriterio}">
  									<i class="bi bi-question-circle" fill="currentColor"></i>
									</span>
									</th>`
								)
								.join("")
						)
						.join("")}
				</tr>`);

				// to enable tooltips with the default configuration
				$('[data-bs-toggle="tooltip"]').tooltip();

				// to initialize tooltips with given configuration
				$('[data-bs-toggle="tooltip"]').tooltip({
					boundary: "clippingParents",
					customClass: "myClass",
				});

				// to trigger the `show` method
				$("#myTooltip").tooltip("show");

				//Se destruye la tabla
				tableNotas.destroy();

				columnDefsNotas = [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + 1;
						},
					},
					{ data: "nombresAlumno" },
					{ data: "apellidosAlumno" },
					// crear las columnas de notas que vienen en dataAlumnosConNotas en htmlNotas
					...competencias
						.map((competencia) =>
							competencia.criterios.map((criterio) => {
								return {
									data: null,
									render: function (data, type, row) {
										const idCompetencia =
											competencia.idCompetencia;
										const idCriterio =
											criterio.idCriterioCompetencia;
										const selectHTML = getSelectHTML(
											data,
											idCompetencia,
											idCriterio
										);
										return selectHTML;
									},
								};
							})
						)
						.flat(),
				];
				tableNotas = $("#dataTableNotasAlumnos").DataTable({
					columns: columnDefsNotas,
					language: {
						url: "views/dataTables/Spanish.json",
					},
				});

				tableNotas.clear();
				tableNotas.rows.add(dataAlumnosConNotas);
				tableNotas.draw();
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

$(document).on("change", ".selectNota", function () {
	var idAlumnoAnioEscolar = $(this).attr("idAlumnoAnioEscolar");
	var idCriterioCompetencia = $(this).attr("idCriterioCompetencia");
	var idNotaCriterio = $(this).attr("idNotaCriterio");
	var nota = $(this).val();

	const dataNotas = {
		idAlumnoAnioEscolar: idAlumnoAnioEscolar,
		idCriterioCompetencia: idCriterioCompetencia,
		idNotaCriterio: idNotaCriterio,
		nota: nota,
	};

	var data = new FormData();
	data.append("crearActualizarNota", JSON.stringify(dataNotas));

	$.ajax({
		url: "ajax/notas.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "ok") {
				Swal.fire({
					position: "top-end",
					toast: true,
					icon: "success",
					text: "Nota registrada!",
					showConfirmButton: false,
					timer: 1500,
				});
				const { idCurso, idGrado, idPersonal, idUnidad, idBimestre } =
					getUrlVars();
				// Actualizar la tabla
				actualizarDataTable(
					idCurso,
					idGrado,
					idPersonal,
					idUnidad,
					idBimestre
				);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			Swal.fire({
				position: "top-end",
				toast: true,
				icon: "error",
				text: "Nota no registrada!",
				showConfirmButton: false,
				timer: 1500,
				timerProgressBar: true,
				background: "#f27474",
				color: "#fff",
				iconColor: "#fff",
			});
			console.log(jqXHR.responseText); // procendecia de error
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});

$(document).ready(function () {
	// Obtener idGrado, idCurso, idPersonal, idBimestre y idUnidad de la url
	const { idGrado, idCurso, idPersonal, idBimestre, idUnidad } = getUrlVars();
	actualizarDataTable(idCurso, idGrado, idPersonal, idUnidad, idBimestre);
});
