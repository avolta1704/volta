$(document).ready(function () {
	$("#selectCursoToReport").trigger("change");
});

$("#selectCursoToReport").on("change", function () {
	const bimestres = document.getElementById("selectBimestreToReport");
	const value = $(this).val();
	const idCurso = value.split("-")[0];
	const idGrado = value.split("-")[1];

	const data = new FormData();
	data.append("todoslosBimestres", true);
	data.append("idCurso", idCurso);
	data.append("idGrado", idGrado);

	$.ajax({
		url: "ajax/bimestre.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			// Llenar el select de bimestres
			bimestres.innerHTML = "";
			response.forEach((bimestre) => {
				bimestres.innerHTML += `<option value="${bimestre.idBimestre}">${bimestre.descripcionBimestre}</option>`;
			});
			$("#selectBimestreToReport").trigger("change");
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

$("#selectBimestreToReport").on("change", function () {
	const idCurso = $("#selectCursoToReport").val().split("-")[0];
	const value = $(this).val();
	const idBimestre = value;

	obtenerNotasAlumnosBimestre(idBimestre, idCurso);
});

// Obtener todas las notas de los alumnos de un bimestre
function obtenerNotasAlumnosBimestre(idBimestre, idCurso) {
	const data = new FormData();
	data.append("todasLasNotasDeAlumnosBimestre", true);
	data.append("idBimestre", idBimestre);
	data.append("idCurso", idCurso);

	$.ajax({
		url: "ajax/notas.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			const data = agruparDatosPorAlumno(response);
			if (data.resultadoFinal.length > 0) {
				generarTabla(data);
			} else {
				var asistenciaContainer = $("#reporteNotas");
				asistenciaContainer.empty();

				//message no data
				asistenciaContainer.append(
					'<div class="alert alert-warning text-center" role="alert">No se encontraron datos para mostrar</div>'
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

// Agrupar nota bimestre, unidades y sus notas, competencias y sus notas , criterios y sus notas por cada alumno mediante su idAlumno
function agruparDatosPorAlumno(data) {
	const agrupadosPorAlumno = new Map();

	// Estructura para almacenar nombres jerárquicamente como arreglos
	const structure = {
		bimestres: [],
	};

	data.forEach((item) => {
		const {
			idAlumno,
			nombresAlumno,
			apellidosAlumno,
			idGrado,
			descripcionGrado,
			idNivel,
			descripcionNivel,
			idCurso,
			descripcionCurso,
			idBimestre,
			descripcionBimestre,
			idUnidad,
			descripcionUnidad,
			idCompetencia,
			descripcionCompetencia,
			capacidadesCompetencia,
			estandarCompetencia,
			idCriterioCompetencia,
			descripcionCriterio,
			descripcionTecnica,
			codTecnica,
			descripcionInstrumento,
			codInstrumento,
			idNotaBimestre,
			notaBimestre,
			idNotaUnidad,
			notaUnidad,
			idNotaCompetencia,
			notaCompetencia,
			idNotaCriterio,
			notaCriterio,
		} = item;

		// Agregar descripción de bimestre a la estructura si no existe
		if (!structure.bimestres.find((b) => b.idBimestre === idBimestre)) {
			structure.bimestres.push({
				idBimestre,
				descripcion: descripcionBimestre,
				unidades: [],
			});
		}

		// Obtener el índice del bimestre en el arreglo de estructura
		const bimestreIndex = structure.bimestres.findIndex(
			(b) => b.idBimestre === idBimestre
		);

		// Agregar descripción de unidad a la estructura del bimestre si no existe
		if (
			!structure.bimestres[bimestreIndex].unidades.find(
				(u) => u.idUnidad === idUnidad
			)
		) {
			structure.bimestres[bimestreIndex].unidades.push({
				idUnidad,
				descripcion: descripcionUnidad,
				competencias: [],
			});
		}

		// Obtener el índice de la unidad en el arreglo del bimestre
		const unidadIndex = structure.bimestres[
			bimestreIndex
		].unidades.findIndex((u) => u.idUnidad === idUnidad);

		// Agregar descripción de competencia a la estructura de la unidad si no existe
		if (
			!structure.bimestres[bimestreIndex].unidades[
				unidadIndex
			].competencias.find((c) => c.idCompetencia === idCompetencia)
		) {
			structure.bimestres[bimestreIndex].unidades[
				unidadIndex
			].competencias.push({
				idCompetencia,
				descripcion: descripcionCompetencia,
				capacidadesCompetencia,
				estandarCompetencia,
				criterios: [],
			});
		}

		// Obtener el índice de la competencia en el arreglo de la unidad
		const competenciaIndex = structure.bimestres[bimestreIndex].unidades[
			unidadIndex
		].competencias.findIndex((c) => c.idCompetencia === idCompetencia);

		// Agregar descripción de criterio a la estructura de la competencia si no existe
		if (
			!structure.bimestres[bimestreIndex].unidades[
				unidadIndex
			].competencias[competenciaIndex].criterios.find(
				(cr) => cr.idCriterioCompetencia === idCriterioCompetencia
			)
		) {
			structure.bimestres[bimestreIndex].unidades[
				unidadIndex
			].competencias[competenciaIndex].criterios.push({
				idCriterioCompetencia,
				descripcion: descripcionCriterio,
				descripcionTecnica,
				codTecnica,
				descripcionInstrumento,
				codInstrumento,
			});
		}

		// Agregar notas a la estructura de estudiantes
		if (!agrupadosPorAlumno.has(idAlumno)) {
			agrupadosPorAlumno.set(idAlumno, {
				idAlumno,
				nombresAlumno,
				apellidosAlumno,
				grado: { idGrado, descripcionGrado },
				nivel: { idNivel, descripcionNivel },
				curso: { idCurso, descripcionCurso },
				bimestres: new Map(),
			});
		}

		const alumno = agrupadosPorAlumno.get(idAlumno);

		if (!alumno.bimestres.has(idBimestre)) {
			alumno.bimestres.set(idBimestre, {
				idBimestre,
				descripcionBimestre,
				notaBimestre,
				unidades: new Map(),
			});
		}

		const bimestre = alumno.bimestres.get(idBimestre);

		if (!bimestre.unidades.has(idUnidad)) {
			bimestre.unidades.set(idUnidad, {
				idUnidad,
				descripcionUnidad,
				notaUnidad,
				competencias: new Map(),
			});
		}

		const unidad = bimestre.unidades.get(idUnidad);

		if (!unidad.competencias.has(idCompetencia)) {
			unidad.competencias.set(idCompetencia, {
				idCompetencia,
				descripcionCompetencia,
				notaCompetencia,
				criterios: new Map(),
			});
		}

		const competencia = unidad.competencias.get(idCompetencia);

		competencia.criterios.set(idCriterioCompetencia, {
			idCriterioCompetencia,
			descripcionCriterio,
			notaCriterio,
		});
	});

	const resultadoFinal = Array.from(agrupadosPorAlumno.values()).map(
		(alumno) => ({
			...alumno,
			bimestres: Array.from(alumno.bimestres.values()).map(
				(bimestre) => ({
					...bimestre,
					unidades: Array.from(bimestre.unidades.values()).map(
						(unidad) => ({
							...unidad,
							competencias: Array.from(
								unidad.competencias.values()
							).map((competencia) => ({
								...competencia,
								criterios: Array.from(
									competencia.criterios.values()
								),
							})),
						})
					),
				})
			),
		})
	);

	return { resultadoFinal, structure };
}

// Generar la tabla para mostrar los datos de los alumnos y todas sus notas del bimestre
function generarTabla(data) {
	const { structure, resultadoFinal: students } = data;
	var asistenciaContainer = $("#reporteNotas");
	asistenciaContainer.empty(); // Limpiar el contenedor antes de agregar la nueva tabla

	// Crear la tabla con estilo en línea
	var tabla = $(
		'<table style="border: 1px solid black; border-collapse: collapse; width: 100%;"></table>'
	);
	var encabezadoBimestres = $("<tr></tr>");
	var encabezadoUnidades = $("<tr></tr>");
	var encabezadoCompetencias = $("<tr></tr>");
	var encabezadoCapacidades = $("<tr></tr>");
	var encabezadoEstandar = $("<tr></tr>");
	var encabezadoCriterios = $("<tr></tr>");
	var encabezadoTecnicas = $("<tr></tr>");
	var encabezadoInstrumentos = $("<tr></tr>");
	encabezadoBimestres.append(
		'<td class="text-uppercase" style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center; min-width: 300px;">Bimestres</td>'
	);
	for (let i = 0; i < structure.bimestres.length; i++) {
		const bimestre = structure.bimestres[i];
		const totalCriterios = bimestre.unidades.reduce(
			(acc, unidad) =>
				acc +
				unidad.competencias.reduce(
					(acc, comp) => acc + comp.criterios.length,
					0
				),
			0
		);
		const totalUnidades = bimestre.unidades.reduce(
			(acc, unidad) => acc + unidad.competencias.length,
			0
		);

		encabezadoBimestres.append(
			'<td colspan="' +
				(totalCriterios + [2 * totalUnidades]) +
				'" style="text-align: center; font-weight: bold; background-color: #00bfbf; border: 1px solid">' +
				bimestre.descripcion +
				"</td>"
		);
	}
	tabla.append(encabezadoBimestres);

	encabezadoUnidades.append(
		'<td class="text-uppercase" style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center; width: 300px;">Unidades</td>'
	);
	for (let i = 0; i < structure.bimestres.length; i++) {
		const bimestre = structure.bimestres[i];
		for (let j = 0; j < bimestre.unidades.length; j++) {
			const unidad = bimestre.unidades[j];
			const totalCriterios = unidad.competencias.reduce(
				(acc, comp) => acc + comp.criterios.length,
				0
			);
			encabezadoUnidades.append(
				'<td colspan="' +
					(totalCriterios + 2) +
					'" style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #00bfbf;">' +
					unidad.descripcion +
					"</td>"
			);
		}
		encabezadoUnidades.append(
			'<td rowspan="7" class="text-uppercase" style="border: 1px solid black; font-weight: bold; background-color: #ccffcc; text-align: center; max-width: 50px;writing-mode: vertical-rl; transform: rotate(180deg); padding: 10px 0px;">Promedio Bimestre</td>'
		);
	}

	tabla.append(encabezadoUnidades);

	encabezadoCompetencias.append(
		'<td class="text-uppercase" style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center; width: 300px;">Competencias</td>'
	);

	for (let i = 0; i < structure.bimestres.length; i++) {
		const bimestre = structure.bimestres[i];
		for (let j = 0; j < bimestre.unidades.length; j++) {
			const unidad = bimestre.unidades[j];
			for (let k = 0; k < unidad.competencias.length; k++) {
				const competencia = unidad.competencias[k];
				encabezadoCompetencias.append(
					'<td colspan="' +
						(competencia.criterios.length + 1) +
						'" style="border: 1px solid black; text-align: center; font-weight: bold; background-color: #00bfbf;">' +
						"CPT" +
						(k + 1) +
						". " +
						competencia.descripcion +
						"</td>"
				);
			}
			encabezadoCompetencias.append(
				'<td rowspan="6" class="text-uppercase" style="border: 1px solid black; font-weight: bold; background-color: #dce6f1; text-align: center; max-width: 60px; writing-mode: vertical-rl; transform: rotate(180deg); padding: 10px 0px;">Promedio Unidad</td>'
			);
		}
	}

	tabla.append(encabezadoCompetencias);

	encabezadoCapacidades.append(
		'<td class="text-uppercase" style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center; width: 300px;">Capacidades</td>'
	);

	for (let i = 0; i < structure.bimestres.length; i++) {
		const bimestre = structure.bimestres[i];
		for (let j = 0; j < bimestre.unidades.length; j++) {
			const unidad = bimestre.unidades[j];
			for (let k = 0; k < unidad.competencias.length; k++) {
				const competencia = unidad.competencias[k];
				encabezadoCapacidades.append(
					'<td colspan="' +
						(competencia.criterios.length + 1) +
						'" style="border: 1px solid black; background-color: #00bfbf; padding: 10px;font-size: 12px;">' +
						competencia.capacidadesCompetencia +
						"</td>"
				);
			}
		}
	}
	tabla.append(encabezadoCapacidades);

	encabezadoEstandar.append(
		'<td class="text-uppercase" style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center; width: 300px;">Estándar</td>'
	);

	for (let i = 0; i < structure.bimestres.length; i++) {
		const bimestre = structure.bimestres[i];
		for (let j = 0; j < bimestre.unidades.length; j++) {
			const unidad = bimestre.unidades[j];
			for (let k = 0; k < unidad.competencias.length; k++) {
				const competencia = unidad.competencias[k];
				encabezadoEstandar.append(
					'<td colspan="' +
						(competencia.criterios.length + 1) +
						'" style="border: 1px solid black; background-color: #00bfbf; padding: 10px; font-size: 12px;">' +
						competencia.estandarCompetencia +
						"</td>"
				);
			}
		}
	}
	tabla.append(encabezadoEstandar);

	encabezadoCriterios.append(
		'<td class="text-uppercase" style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center; width: 300px;">Capacidades</td>'
	);

	for (let i = 0; i < structure.bimestres.length; i++) {
		const bimestre = structure.bimestres[i];
		for (let j = 0; j < bimestre.unidades.length; j++) {
			const unidad = bimestre.unidades[j];
			for (let k = 0; k < unidad.competencias.length; k++) {
				const competencia = unidad.competencias[k];
				for (let l = 0; l < competencia.criterios.length; l++) {
					const criterio = competencia.criterios[l];
					encabezadoCriterios.append(
						'<td style="border: 1px solid black; font-size: 12px; writing-mode: vertical-rl; max-height:150px; max-width: 80px;transform: rotate(180deg); padding: 10px 0px;white-space: wrap; text-overflow: ellipsis; overflow: hidden;">' +
							criterio.descripcion +
							"</td>"
					);
				}
			}
			encabezadoCriterios.append(
				'<td rowspan="3" style="border: 1px solid black; background-color: #fde9d9 ; font-size: 12px; writing-mode: vertical-rl; max-height:150px; max-width: 80px;transform: rotate(180deg); padding: 10px 0px; font-weight: bold; " class="text-uppercase">Nivel de logro</td>'
			);
		}
	}

	tabla.append(encabezadoCriterios);

	encabezadoTecnicas.append(
		'<td class="text-uppercase" style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center; width: 300px;">Técnicas</td>'
	);

	for (let i = 0; i < structure.bimestres.length; i++) {
		const bimestre = structure.bimestres[i];
		for (let j = 0; j < bimestre.unidades.length; j++) {
			const unidad = bimestre.unidades[j];
			for (let k = 0; k < unidad.competencias.length; k++) {
				const competencia = unidad.competencias[k];
				for (let l = 0; l < competencia.criterios.length; l++) {
					const criterio = competencia.criterios[l];
					encabezadoTecnicas.append(
						'<td style="border: 1px solid black; font-size: 12px;  max-height:150px; min-width: 100px; padding: 0px 10px; text-align: center;">' +
							criterio.codTecnica +
							"</td>"
					);
				}
			}
		}
	}
	tabla.append(encabezadoTecnicas);

	encabezadoInstrumentos.append(
		'<td class="text-uppercase" style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center; width: 300px;">Instrumentos</td>'
	);

	for (let i = 0; i < structure.bimestres.length; i++) {
		const bimestre = structure.bimestres[i];
		for (let j = 0; j < bimestre.unidades.length; j++) {
			const unidad = bimestre.unidades[j];
			for (let k = 0; k < unidad.competencias.length; k++) {
				const competencia = unidad.competencias[k];
				for (let l = 0; l < competencia.criterios.length; l++) {
					const criterio = competencia.criterios[l];
					encabezadoInstrumentos.append(
						'<td style="border: 1px solid black; font-size: 12px; max-height:150px; min-width: 100px; padding: 0px 10px; text-align: center;">' +
							criterio.codInstrumento +
							"</td>"
					);
				}
			}
		}
	}

	tabla.append(encabezadoInstrumentos);

	// Iterar todos los alumnos
	for (let i = 0; i < students.length; i++) {
		const alumno = students[i];
		var filaNota = $("<tr></tr>");

		filaNota.append(
			'<td style="border: 1px solid black; min-width: 350px;">' +
				alumno.nombresAlumno +
				" " +
				alumno.apellidosAlumno +
				"</td>"
		);
		for (let j = 0; j < alumno.bimestres.length; j++) {
			const bimestre = alumno.bimestres[j];
			for (let k = 0; k < bimestre.unidades.length; k++) {
				const unidad = bimestre.unidades[k];
				for (let l = 0; l < unidad.competencias.length; l++) {
					const competencia = unidad.competencias[l];
					for (let m = 0; m < competencia.criterios.length; m++) {
						const criterio = competencia.criterios[m];
						const nota = criterio.notaCriterio;
						filaNota.append(
							'<td style="border: 1px solid black; text-align: center;">' +
								nota +
								"</td>"
						);
					}
					const notaCompetencia = competencia.notaCompetencia;
					filaNota.append(
						'<td style="border: 1px solid black; text-align: center; background-color: #fde9d9; font-weight: bold;">' +
							notaCompetencia +
							"</td>"
					);
				}
				const notaUnidad = unidad.notaUnidad;
				filaNota.append(
					'<td style="border: 1px solid black; text-align: center; background-color: #dce6f1;font-weight: bold;">' +
						notaUnidad +
						"</td>"
				);
			}
			const notaBimestre = bimestre.notaBimestre;
			filaNota.append(
				'<td style="border: 1px solid black; text-align: center; background-color: #ccffcc;font-weight: bold;">' +
					notaBimestre +
					"</td>"
			);
		}
		tabla.append(filaNota);
	}

	asistenciaContainer.append(tabla);
}

$("#btnDescargarReporteNotas").click(function () {
	// Descargar un excel de la tabla de asistencias con XLSX
	const tabla = document.querySelector("#reporteNotas table");

	// Verificar si la tabla existe
	if (!tabla) {
		Swal.fire({
			icon: "warning",
			title: "Advertencia",
			text: "No se ha generado la tabla de notas",
		});
		return;
	}

	const fecha = new Date().toISOString().split("T")[0];
	const nombreArchivo = "Reporte_Notas_" + fecha + ".xlsx";
	const ws = XLSX.utils.table_to_sheet(tabla);
	const wb = XLSX.utils.book_new();
	// en ancho de la primera columna
	ws["!cols"] = [{ wpx: 350 }];
	XLSX.utils.book_append_sheet(wb, ws, "Notas");
	XLSX.writeFile(wb, nombreArchivo);
});
