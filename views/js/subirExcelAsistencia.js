//boton para subir el archivo de excel
$("#btnSubirExcelAsistencia").click(function () {
	// analizar el archivo excel
	var file = $("#excelAsistencia")[0].files[0];

	// si no se selecciona ningun archivo
	if (file == undefined) {
		swal.fire({
			title: "Error",
			text: "Por favor seleccione un archivo",
			icon: "error",
			button: "Aceptar",
		});
		return;
	}

	// si el archivo no es un excel
	if (file.name.split(".").pop() != "xlsx") {
		swal.fire({
			title: "Error",
			text: "Por favor seleccione un archivo excel",
			icon: "error",
			button: "Aceptar",
		});
		return;
	}

	// si el archivo es muy grande
	if (file.size > 10000000) {
		swal.fire({
			title: "Error",
			text: "El archivo es muy grande",
			icon: "error",
			button: "Aceptar",
		});
		return;
	}

	// leemos el archivo con XLSX
	var reader = new FileReader();
	reader.readAsArrayBuffer(file);
	reader.onload = function (e) {
		var data = new Uint8Array(reader.result);
		var workbook = XLSX.read(data, { type: "array" });
		var sheet_name_list = workbook.SheetNames;
		var xlData = XLSX.utils.sheet_to_json(
			workbook.Sheets[sheet_name_list[0]]
		);

		// si el archivo no tiene la estructura correcta

		const columnsExisten = getDiasLaborables()
			.map((dia) => dia)
			.every((dia) => xlData[0].hasOwnProperty(dia) === true);

		if (
			xlData[0].hasOwnProperty("Nro") === false ||
			xlData[0].hasOwnProperty("IUU") === false ||
			xlData[0].hasOwnProperty("Alumnos") === false ||
			columnsExisten === false
		) {
			swal.fire({
				title: "Error",
				text: "El archivo no tiene la estructura correcta",
				icon: "error",
				button: "Aceptar",
			});
			return;
		}

		console.log(xlData);

		// controlar la data recibida si todos los registros tienen todas las columnas que deberían ser
		const allColumnsExist = xlData.every((row) => {
			return (
				row.hasOwnProperty("Nro") &&
				row.hasOwnProperty("IUU") &&
				row.hasOwnProperty("Alumnos") &&
				getDiasLaborables().every((dia) => row.hasOwnProperty(dia))
			);
		});

		if (!allColumnsExist) {
			swal.fire({
				title: "Error",
				text: "La información del archivo no está estructurada correctamente.",
				icon: "error",
				button: "Aceptar",
			});
			return;
		}
		const urlParams = new URLSearchParams(window.location.search);
		const idCurso = urlParams.get("idCurso");
		const idGrado = urlParams.get("idGrado");
		const idPersonal = urlParams.get("idPersonal");

		const dataAsistencia = {
			idCurso: idCurso,
			idGrado: idGrado,
			idPersonal: idPersonal,
		};

		console.log(dataAsistencia);

		const dataExcel = new FormData();
		dataExcel.append(
			"guardarAsistenciaAlumnosExcel",
			JSON.stringify(dataAsistencia)
		);
		dataExcel.append("asistenciaAlumnosExcel", JSON.stringify(xlData));

		// si el archivo tiene la estructura correcta
		$.ajax({
			url: "ajax/asistenciaAlumnos.ajax.php",
			method: "POST",
			data: dataExcel,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			beforeSend: function () {
				swal.fire({
					title: "Cargando",
					text: "Subiendo archivo...",
					icon: "info",
					showCancelButton: false,
					showConfirmButton: false,
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false,
					onBeforeOpen: () => {
						swal.showLoading();
					},
					onClose: () => {
						const dataDelete = new FormData();
						dataDelete.append(
							"deleteAsistenciaAlumnosExcel",
							JSON.stringify(dataAsistencia)
						);
						dataExcel.append(
							"asistenciaAlumnosExcel",
							JSON.stringify(xlData)
						);

						$.ajax({
							url: "ajax/asistenciaAlumnos.ajax.php",
							method: "POST",
							data: dataExcel,
							cache: false,
							contentType: false,
							processData: false,
							dataType: "json",
							beforeSend: function () {
								swal.fire({
									title: "Cancelando",
									text: "Cancelando los datos de asistencia...",
									icon: "warn",
									showCancelButton: false,
									showConfirmButton: false,
									allowOutsideClick: false,
									allowEscapeKey: false,
									allowEnterKey: false,
									onBeforeOpen: () => {
										swal.showLoading();
									},
									onClose: () => {
										swal.close();
									},
								});
							},
							success: function (response) {
								if (response == "ok") {
									swal.fire({
										title: "Exito",
										text: "Se cancelaron los datos de asistencia",
										icon: "success",
										button: "Aceptar",
									});
								} else {
									swal.fire({
										title: "Error",
										text: "Hubo un error al cancelar los datos de asistencia",
										icon: "error",
										button: "Aceptar",
									});
								}
							},
						});
					},
				});
			},
			success: function (response) {
				if (response == "ok") {
					swal.fire({
						title: "Exito",
						text: "El archivo se subio correctamente",
						icon: "success",
						button: "Aceptar",
					});
				} else {
					swal.fire({
						title: "Error",
						text: "Hubo un error al subir el archivo",
						icon: "error",
						button: "Aceptar",
					});
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			},
			complete: function () {
				$("#excelAsistencia").val("");
			},
		});
	};
	/**
	 * Funcion para obtener los dias laborables del mes actual
	 * @returns {Array} los dias laborables del mes actual
	 */
	function getDiasLaborables() {
		const fecha = new Date();
		const mes = fecha.getMonth();
		const anio = fecha.getFullYear();
		const dias = new Date(anio, mes + 1, 0).getDate();
		const diasLaborables = [];
		for (let i = 1; i <= dias; i++) {
			const fecha = new Date(anio, mes, i);
			const dia = fecha.getDay();
			if (dia !== 0 && dia !== 6) {
				diasLaborables.push(`${i}/${mes + 1}/${anio}`);
			}
		}
		return diasLaborables;
	}
});
