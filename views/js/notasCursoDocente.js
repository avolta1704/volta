// Redireccionar a la vista de notas de un curso en específico
$("#dataTableCursosDocente").on("click", "#btnNotasCursoDocente", function () {
	const idCurso = $(this).attr("idCurso");
	const idGrado = $(this).attr("idGrado");
	const idPersonal = $(this).attr("idPersonal");
	window.location =
		"index.php?ruta=notasCursoDocente&idCurso=" +
		idCurso +
		"&idGrado=" +
		idGrado +
		"&idPersonal=" +
		idPersonal;
});
$(document).ready(function () {
	// Obtener la URL actual
	var urlParams = new URLSearchParams(window.location.search);

	// Obtener el valor de los parámetros de la URL
	var ruta = urlParams.get("ruta");
	var idCurso = urlParams.get("idCurso");
	var idGrado = urlParams.get("idGrado");
	var idPersonal = urlParams.get("idPersonal");
	var data = new FormData();
	data.append("todoslosBimestres", true);
	data.append("idCurso", idCurso);
	data.append("idGrado", idGrado);

	// Define los nombres de los botones con texto, clases e ids como marcadores de posición
	var buttonNames = [
		{ text: "Placeholder 1", class: "btn btn-primary", id: "" },
		{ text: "Placeholder 2", class: "btn btn-secondary", id: "" },
		{ text: "Placeholder 3", class: "btn btn-success", id: "" },
		{ text: "Placeholder 4", class: "btn btn-danger", id: "" },
	];

	$.ajax({
		url: "ajax/bimestre.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			// Actualiza el texto y el id de los botones basándose en la respuesta AJAX
			response.forEach((value, index) => {
				if (buttonNames[index]) {
					buttonNames[index].text = value.descripcionBimestre;
					buttonNames[index].id = "btnBimestre";
					buttonNames[index].data = {
						idBimestre: value.idBimestre,
						estadoBimestre: value.estadoBimestre,
					}; // Almacenar idBimestre y estado del bimestre en data
				}
			});

			const buttonContainer = $("#buttonContainer");

			buttonNames.forEach((button) => {
				const btn = $("<button></button>")
					.attr("type", "button")
					.attr("id", button.id)
					.addClass(button.class)
					.text(button.text)
					.css("margin-right", "10px") // Añadir margen a cada botón
					.data("idBimestre", button.data.idBimestre) // Guardar idBimestre en data
					.prop("disabled", button.data.estadoBimestre == 0); // Deshabilitar botón si estadoUnidad es 0
				buttonContainer.append(btn);
			});
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText); // Procedencia de error
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});
// Funcionalidad para los Botones de Bimestres
$("#buttonContainer").on("click", "#btnBimestre", function () {
	var idBimestre = $(this).data("idBimestre"); // Obtener idBimestre
	// Define los nombres de los botones con texto, clases e ids como marcadores de posición
	var buttonNames = [
		{ text: "Placeholder 1", class: "btn btn-warning", id: "" },
		{ text: "Placeholder 2", class: "btn btn-info", id: "" },
	];
	// Solicitud AJAX inicial
	var data = new FormData();
	data.append("idBimestre", idBimestre);

	$.ajax({
		url: "ajax/unidad.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",

		success: function (response) {
			$("#secondButtonContainer").empty();
			$("#thirdButtonContainer").empty();
			// Limpiar el DataTable
			$("#dataTableNotasCursoDocente").DataTable().clear().draw();
			// Actualiza el texto y el id de los botones basándose en la respuesta AJAX
			response.forEach((value, index) => {
				if (buttonNames[index]) {
					buttonNames[index].text = value.descripcionUnidad;
					buttonNames[index].id = "btnUnidad";
					buttonNames[index].data = {
						idUnidad: value.idUnidad,
						estadoUnidad: value.estadoUnidad,
						idBimestre: idBimestre,
					}; // Almacenar idUnidad y estadoUnidad en data
				}
			});

			const buttonContainer = $("#secondButtonContainer");

			buttonNames.forEach((button) => {
				const btn = $("<button></button>")
					.attr("type", "button")
					.attr("id", button.id)
					.addClass(button.class)
					.text(button.text)
					.css("margin-right", "10px") // Añadir margen a cada botón
					.data("idUnidad", button.data.idUnidad) // Guardar idUnidad en data
					.data("idBimestre", button.data.idBimestre) // Guardar idBimestre en data
					.prop("disabled", button.data.estadoUnidad == 0); // Deshabilitar botón si estadoUnidad es 0
				buttonContainer.append(btn);
			});
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText); // Procedencia de error
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});

// Funcionalidad para el boton Ver Competencias
$("#thirdButtonContainer").on("click", "#btnVerCompetencias", function () {
	$("#modalCompetenciaUnidad").modal("show");
});
//Funcionalidad para el boton cerrar el modal de crear competencia
$("#modalIngresarCompetencia").on(
	"click",
	"#btnCerrarModalCompetencia",
	function () {
		$("#modalIngresarCompetencia").modal("hide");
		$("#modalCompetenciaUnidad").modal("show");
	}
);
// Funcionalidad para asignarle un idUnidad al botón btnAgregarCompetencia
$("#btnAgregarCompetencia").on("click", function () {
	var idUnidad = $(this).attr("idUnidad"); // Obtén el valor de idUnidad del botón btnAgregarCompetencia
	$("#btnCrearCompetencia").attr("idUnidad", idUnidad); // Establece el valor de idUnidad en el botón btnCrearCompetencia
	// Limpiar el contenido de notaText
	$("#notaText").val("");
	// Limpiar el contenido de capacidadesCompetencia
	$("#capacidadesCompetencia").val("");
	// Limpiar el contenido de estandarCompetencia
	$("#estandarCompetencia").val("");
});
// Funcionalidad para el botón de crear competencia
$("#modalIngresarCompetencia").on("click", "#btnCrearCompetencia", function () {
	var idUnidad = $(this).attr("idUnidad"); // Obtén el valor de idUnidad del botón btnCrearCompetencia
	var notaText = $("#notaText").val(); // Obtén el valor del elemento con id notaText
	var capacidades = $("#capacidadesCompetencia").val(); // Obtén el valor del elemento con id capacidadesCompetencia
	var estandar = $("#estandarCompetencia").val(); // Obtén el valor del elemento con id estandarCompetencia

	const dataCompetencia = {
		descripcionCompetenciaCrear: notaText,
		capacidades: capacidades,
		estandar: estandar,
	};
	var data = new FormData();
	data.append("idUnidadCrear", idUnidad);
	data.append("descripcionCompetenciaCrear", JSON.stringify(dataCompetencia));
	$.ajax({
		url: "ajax/competencia.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "ok") {
				Swal.fire({
					title: "Competencia Creada",
					text: "La competencia se ha creado con éxito.",
					icon: "success",
					confirmButtonText: "Aceptar",
				}).then((result) => {
					if (result.isConfirmed) {
						$("#modalIngresarCompetencia").modal("hide");
						$("#modalCompetenciaUnidad").modal("hide");
					}
				});
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText); // Procedencia de error
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});

// Funcionalidad para el modal de editar competencia
$("#dataTableCompetencias").on("click", ".btnEditarCompetencias", function () {
	idCompetencia = $(this).attr("idCompetencia"); // Obtén el idCompetencia del botón
	descripcionCompetencia = $(this).attr("descripcionCompetencia"); // Obtén la descripción de la competencia
	capacidadesCompetencia = $(this).attr("capacidadesCompetencia"); // Obtén las capacidades de la competencia
	estandarCompetencia = $(this).attr("estandarCompetencia"); // Obtén el estandar de la competencia

	const notaText = $("#notaTextEditar");
	notaText.val(descripcionCompetencia); // Establece el valor del campo de entrada con la descripción de la competencia
	const capacidadesText = $("#capacidadesCompetenciaEditar");
	capacidadesText.val(capacidadesCompetencia); // Establece el valor del campo de entrada con las capacidades de la competencia
	const estandarText = $("#estandarCompetenciaEditar");
	estandarText.val(estandarCompetencia); // Establece el valor del campo de entrada con el estandar de la competencia

	// Funcionalidad del boton Guardar Competencia
	$("#modalEditarCompetencia").on(
		"click",
		"#btnGuardarCompetencia",
		function () {
			const currentValue = notaText.val();
			const capacidadesValue = capacidadesText.val();
			const estandarValue = estandarText.val();
			if (
				currentValue != descripcionCompetencia ||
				capacidadesValue != capacidadesCompetencia ||
				estandarValue != estandarCompetencia
			) {
				const dataCompetenciaEditar = {
					descripcionCompetenciaEditar: currentValue,
					capacidadesCompetenciaEditar: capacidadesValue,
					estandarCompetenciaEditar: estandarValue,
				};

				var data = new FormData();
				data.append("idCompetencia", idCompetencia);
				data.append(
					"notaTextModificada",
					JSON.stringify(dataCompetenciaEditar)
				);
				// Modificar la competencia
				$.ajax({
					url: "ajax/competencia.ajax.php",
					method: "POST",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function (response) {
						if (response == "ok") {
							Swal.fire({
								title: "Competencia Modificada",
								text: "La competencia se ha modificado con éxito.",
								icon: "success",
								confirmButtonText: "Aceptar",
							}).then((result) => {
								if (result.isConfirmed) {
									$("#modalEditarCompetencia").modal("hide");
									$("#modalCompetenciaUnidad").modal("hide");
								}
							});
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(jqXHR.responseText); // Procedencia de error
						console.log(
							"Error en la solicitud AJAX: ",
							textStatus,
							errorThrown
						);
					},
				});
			} else {
				Swal.fire({
					title: "Sin Cambios",
					text: "No se han realizado cambios en la competencia.",
					icon: "info",
					confirmButtonText: "Aceptar",
				});
			}
		}
	);
});
//Funcionalidad para el boton cerrar el modal de editar competencia
$("#modalEditarCompetencia").on(
	"click",
	"#btnCerrarModalEditarCompetencia",
	function () {
		$("#modalEditarCompetencia").modal("hide");
		$("#modalCompetenciaUnidad").modal("show");
	}
);

// Funcionalidad para el modal de duplicar competencia
$("#modalCompetenciaUnidad").on(
	"click",
	"#btnDuplicarCompetencia",
	function () {
		var idUnidad = $(this).attr("idUnidad"); // Obtén el valor de idUnidad del botón btnAgregarCompetencia
		// Limpiar el contenedor
		$("#competenciasContainer").empty();
		// Contenedor donde se agregarán las opciones
		var competenciasContainer = $("#competenciasContainer");
		// Obtener la URL actual
		var urlParams = new URLSearchParams(window.location.search);

		// Obtener el valor de los parámetros de la URL
		var ruta = urlParams.get("ruta");
		var idCurso = urlParams.get("idCurso");
		var idGrado = urlParams.get("idGrado");
		var idPersonal = urlParams.get("idPersonal");

		var data = new FormData();
		data.append("competenciasDuplicar", true);
		data.append("idCurso", idCurso);
		data.append("idGrado", idGrado);
		data.append("idPersonal", idPersonal);
		// Modificar la competencia
		$.ajax({
			url: "ajax/competencia.ajax.php",
			method: "POST",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function (response) {
				// Iterar sobre el array de opciones y agregarlas al contenedor
				response.forEach(function (competencia, index) {
					var checkboxId = "competencia" + (index + 1);
					var checkboxInput = $("<input>")
						.addClass("form-check-input")
						.attr({ type: "checkbox", id: checkboxId });
					var checkboxLabel = $("<label>")
						.addClass("btn btn-outline-primary")
						.text(competencia.descripcionCompetencia)
						.attr({
							for: checkboxId,
							role: "button",
							capacidades: competencia.capacidadesCompetencia,
							estandar: competencia.estandarCompetencia,
						});
					var formCheck = $("<div>")
						.addClass("form-check")
						.append(checkboxInput, checkboxLabel);
					competenciasContainer.append(formCheck);
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.responseText); // Procedencia de error
				console.log(
					"Error en la solicitud AJAX: ",
					textStatus,
					errorThrown
				);
			},
		});
		//Funcionalidad para Duplicar las Competencias Seleccionadas
		$("#modalDuplicarCompetencia")
			.off("click", "#btnDuplicarCompetenciaModal")
			.on("click", "#btnDuplicarCompetenciaModal", function () {
				// Obtener todos los checkboxes marcados
				var selectedCheckboxes = $(
					"#competenciasContainer input[type='checkbox']:checked"
				);
				// Inicializar el array
				var checkboxValues = [];

				// Iterar sobre los checkboxes marcados y obtener sus valores
				selectedCheckboxes.each(function () {
					const dataCompetencia = {
						descripcionCompetenciaCrear: $(this)
							.next("label")
							.text(),
						capacidades: $(this).next("label").attr("capacidades"),
						estandar: $(this).next("label").attr("estandar"),
					};
					checkboxValues.push(dataCompetencia);
				});

				var data = new FormData();
				data.append("checkboxValues", JSON.stringify(checkboxValues));
				data.append("idUnidadModificado", idUnidad);
				$.ajax({
					url: "ajax/competencia.ajax.php",
					method: "POST",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function (response) {
						// Mostrar el Swal correspondiente
						if (response == "ok") {
							Swal.fire({
								title: "Competencias Duplicadas",
								text: "Se han insertado con éxito.",
								icon: "success",
								confirmButtonText: "Aceptar",
							}).then((result) => {
								if (result.isConfirmed) {
									$("#modalDuplicarCompetencia").modal(
										"hide"
									);
									$("#modalCompetenciaUnidad").modal("hide");
								}
							});
						} else if (response == "duplicado") {
							Swal.fire({
								title: "Competencias Duplicadas",
								text: "No se han insertado esos datos porque ya están creados.",
								icon: "info",
								confirmButtonText: "Aceptar",
							});
						} else {
							// Manejar cualquier otra respuesta
							Swal.fire({
								title: "Error",
								text: "Ha ocurrido un error inesperado.",
								icon: "error",
								confirmButtonText: "Aceptar",
							});
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(
							"Error en la solicitud AJAX: ",
							textStatus,
							errorThrown
						);
					},
				});
			});
	}
);

$("#modalDuplicarCompetencia").on(
	"click",
	"#btnCerrarmodalDuplicarCompetencia",
	function () {
		$("#modalDuplicarCompetencia").modal("hide");
		$("#modalCompetenciaUnidad").modal("show");
	}
);
$("#dataTableCompetencias").on("click", ".btnEliminarCompetencia", function () {
	var idCompetencia = $(this).attr("idCompetencia"); // Obtén el idCompetencia del botón}
	Swal.fire({
		title: "¿Estás seguro de que deseas eliminar la competencia?",
		text: "¡Se eliminará la competencia seleccionada!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Si",
		cancelButtonText: "No",
	}).then((result) => {
		if (result.isConfirmed) {
			var data = new FormData();
			data.append("idCompetenciaEliminar", idCompetencia);
			$.ajax({
				url: "ajax/competencia.ajax.php",
				method: "POST",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (response) {
					if (response == "ok") {
						Swal.fire({
							title: "¡Competencia Eliminada!",
							text: "La competencia ha sido eliminada con éxito.",
							icon: "success",
						}).then(function (result) {
							if (result.isConfirmed) {
								$("#modalCompetenciaUnidad").modal("hide");
							}
						});
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(jqXHR.responseText); // Procedencia de error
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

// Funcionalidad para cerrar Unidad
$("#thirdButtonContainer").on("click", "#btnCerrarNotas", function () {
	// Obtener la URL actual
	var urlParams = new URLSearchParams(window.location.search);
	// Obtener el valor de los parámetros de la URL
	var ruta = urlParams.get("ruta");
	var idCurso = urlParams.get("idCurso");
	var idGrado = urlParams.get("idGrado");
	var idUnidad = $(this).data("idUnidad"); //Obtener idUnidad
	var idBimestre = $(this).data("idBimestre"); //Obtener idBimestre

	Swal.fire({
		title: "¿Estás seguro de que deseas cerrar la unidad?",
		text: "¡Asegúrese de subir todas las notas!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sí",
		cancelButtonText: "No",
	}).then((result) => {
		if (result.isConfirmed) {
			var data = new FormData();
			data.append("idUnidadCerrar", idUnidad);
			data.append("idBimestreCerrar", idBimestre);
			data.append("idCursoCerrar", idCurso);
			data.append("idGradoCerrar", idGrado);

			// Mostrar barra de progreso de carga
			Swal.fire({
				title: "Cargando...",
				html: `
          <div style="margin-top: 20px;">
            <div style="width: 100%; background-color: #f3f3f3; border-radius: 5px; overflow: hidden;">
              <div id="progress-bar" style="height: 20px; background-color: #4caf50; width: 0%; transition: width 0.3s;"></div>
            </div>
          </div>
        `,
				allowEscapeKey: false,
				allowOutsideClick: false,
				showConfirmButton: false,
				didOpen: () => {
					let progressBar = document.getElementById("progress-bar");

					// Hacer la solicitud AJAX
					$.ajax({
						url: "ajax/unidad.ajax.php",
						method: "POST",
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						xhr: function () {
							var xhr = new window.XMLHttpRequest();
							// Progreso de la carga
							xhr.upload.addEventListener(
								"progress",
								function (evt) {
									if (evt.lengthComputable) {
										var percentComplete =
											evt.loaded / evt.total;
										percentComplete = percentComplete * 100;
										progressBar.style.width =
											Math.min(percentComplete, 90) + "%"; // Límite al 90% para la simulación
									}
								},
								false
							);
							return xhr;
						},
						success: function (response) {
							// Completar la barra de progreso al finalizar la solicitud
							progressBar.style.width = "100%";
							setTimeout(() => {
								Swal.close(); // Cerrar el Swal de la barra de progreso
								if (response == "ok") {
									Swal.fire({
										title: "Unidad Cerrada",
										text: "La unidad se ha cerrado con éxito.",
										icon: "success",
										confirmButtonText: "Aceptar",
									}).then((result) => {
										if (result.isConfirmed) {
											location.reload();
										}
									});
								} else {
									Swal.fire({
										title: "Error",
										text: "¡Valide la asignación de notas de los alumnos!",
										icon: "error",
										confirmButtonText: "Aceptar",
									});
								}
							}, 300); // Pequeño retardo para mostrar el progreso completo antes de cerrar
						},
						error: function (jqXHR, textStatus, errorThrown) {
							// Completar la barra de progreso al finalizar la solicitud
							progressBar.style.width = "100%";
							setTimeout(() => {
								Swal.close(); // Cerrar el Swal de la barra de progreso
								Swal.fire({
									title: "Error",
									text: "Hubo un problema con la petición AJAX.",
									icon: "error",
									confirmButtonText: "Aceptar",
								});
							}, 300); // Pequeño retardo para mostrar el progreso completo antes de cerrar
							console.log(jqXHR.responseText); // Procedencia de error
							console.log(
								"Error en la solicitud AJAX: ",
								textStatus,
								errorThrown
							);
						},
					});
				},
			});
		}
	});
});

$("#btnCerrarModalCriteriosCompetencia").on("click", function () {
	$("#modalCompetenciaUnidad").modal("show");
});

$("#dataTableCompetencias").on("click", "#btnAbrirModalCriterios", function () {
	const idCompetencia = $(this).attr("idCompetencia");

	// añadir el idCompetencia al boton de crear criterio
	$("#btnCrearCriterio").attr("idCompetencia", idCompetencia);

	const descripcionCompetencia = $(this).attr("descripcionCompetencia");
	if (!!descripcionCompetencia) {
		$("#modalCriteriosCompetenciaLabel").text(
			"Criterios de la Competencia " +
				descripcionCompetencia.toString().toUpperCase()
		);
	}

	crearDataTableCriterios(idCompetencia);
});

// Crear la dataTableCriteriosCompetencias
function crearDataTableCriterios(idCompetencia) {
	// Definición de columnas
	var columnDefsCriterios = [
		{ data: "descripcionCriterio" },
		{ data: "codTecnica" },
		{ data: "codInstrumento" },
		{ data: "acciones" },
	];

	// Inicialización de dataTableCursosPorGrado
	var tableCriterios = $("#dataTableCriteriosCompetencias").DataTable({
		columns: columnDefsCriterios,
		retrieve: true,
		paging: false,
	});

	var data = new FormData();
	data.append("idCompetencia", idCompetencia);

	$.ajax({
		url: "ajax/criterios.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			tableCriterios.clear();
			tableCriterios.rows.add(response);
			tableCriterios.draw();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText); // Procedencia de error
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});

	$("#dataTableCriteriosCompetencias thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Criterio</th>
      <th scope="col">Técnica</th>
      <th scope="col">Instrumento</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

	tableCriterios.destroy();

	columnDefsCriterios = [
		{
			data: null,
			render: function (data, type, row, meta) {
				return meta.row + 1;
			},
		},
		{ data: "descripcionCriterio" },
		{ data: "codTecnica" },
		{ data: "codInstrumento" },
		{ data: "acciones" },
	];
	tableCriterios = $("#dataTableCriteriosCompetencias").DataTable({
		columns: columnDefsCriterios,
		language: {
			url: "views/dataTables/Spanish.json",
		},
	});
}

// crear Criterios
$("#btnAgregarCriterio").on("click", function () {
	// cerrar modal de competencias
	$("#modalCompetenciaUnidad").modal("hide");

	// Limpiar los select de técnicas e instrumentos
	$("#selectTecnicas").empty();
	$("#selectInstrumentos").empty();

	// crear un select con las técnicas
	var data = new FormData();
	data.append("allTecnicas", true);
	$.ajax({
		url: "ajax/criterios.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			$("#selectTecnicas").empty();
			$("#selectTecnicas").append(
				`<option value="" selected>Seleccione una técnica</option>`
			);
			response.forEach((value) => {
				$("#selectTecnicas").append(
					`<option value="${value.idTecnicaEvaluacion}">${value.codTecnica} - ${value.descripcionTecnica}</option>`
				);
			});

			// crear un select con los instrumentos segun la técnica seleccionada
			$("#selectTecnicas").on("change", function () {
				var idTecnica = $(this).val();
				var data = new FormData();
				data.append("idTecnicaEvaluacion", idTecnica);
				$.ajax({
					url: "ajax/criterios.ajax.php",
					method: "POST",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function (response) {
						$("#selectInstrumentos").empty();
						$("#selectInstrumentos").append(
							`<option value="" selected>Seleccione un instrumento</option>`
						);
						response.forEach((value) => {
							$("#selectInstrumentos").append(
								`<option value="${value.idInstrumento}">${value.codInstrumento} - ${value.descripcionInstrumento} </option>`
							);
						});
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(jqXHR.responseText); // Procedencia de error
						console.log(
							"Error en la solicitud AJAX: ",
							textStatus,
							errorThrown
						);
					},
				});
			});
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText); // Procedencia de error
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});

// Funcionalidad para el botón de crear criterio
$("#modalIngresarCriterio").on("click", "#btnCrearCriterio", function () {
	var idCompetencia = $(this).attr("idCompetencia");
	var descripcionCriterio = $("#descripcionCriterio").val();
	var idInstrumento = $("#selectInstrumentos").val();
	var idTecnica = $("#selectTecnicas").val();

	// Validar que los campos no estén vacíos
	if (descripcionCriterio == "" || idInstrumento == "" || idTecnica == "") {
		Swal.fire({
			title: "Campos Vacíos",
			text: "Por favor, complete todos los campos.",
			icon: "warning",
			confirmButtonText: "Aceptar",
		});
		return;
	}

	const dataCriterio = {
		descripcionCriterio: descripcionCriterio,
		idInstrumento: idInstrumento,
		idTecnicaEvaluacion: idTecnica,
	};

	var data = new FormData();
	data.append("idCompetenciaNuevoCriterio", idCompetencia);
	data.append("nuevoCriterio", JSON.stringify(dataCriterio));

	$.ajax({
		url: "ajax/criterios.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "ok") {
				// Alerta de swal con timer
				Swal.fire({
					icon: "success",
					title: "Creado",
					text: "El criterio se ha creado con éxito.",
					timer: 1500,
					showConfirmButton: false,
				});
				$("#modalIngresarCriterio").modal("hide");
				$("#modalCompetenciaUnidad").modal("hide");
				// abrir modal de los criterios
				$("#modalCriteriosCompetencia").modal("show");

				crearDataTableCriterios(idCompetencia);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText); // Procedencia de error
			console.log(
				"Error en la solicitud AJAX: ",
				textStatus,
				errorThrown
			);
		},
	});
});

// Funcionalidad para el botón de cerrar crear criterio
$("#modalIngresarCriterio").on(
	"click",
	"#btnCerrarModalCrearCriterio",
	function () {
		$("#modalIngresarCriterio").modal("hide");
		$("#modalCriteriosCompetencia").modal("show");
	}
);
