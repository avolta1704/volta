$("#dataTableListadoAlumnosCurso").on(
	"click",
	"#btnVisualizarDataAlumnoCurso",
	function () {
		var idAlumno = $(this).attr("idAlumno");

		const data = new FormData();
		data.append("idAlumno", idAlumno);
		$.ajax({
			url: "ajax/alumnosCursoDocente.ajax.php",
			method: "POST",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function (response) {
				$("#nombresAlumnoVisualizar").val(response.nombresAlumno);
				$("#apellidosAlumnoVisualizar").val(response.apellidosAlumno);
				$("#dniAlumnoVisualizar").val(response.dniAlumno);
        $("#fechaNacimientoVisualizar").val(response.fechaNacimiento);
				$("#sexoAlumno").val(response.sexoAlumno);
				$("#telefonoEmergencia").val(response.numeroEmergencia);
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
);

//  Vista para el modal de cronograma de pagos
$("#dataTableListadoAlumnosCurso").on(
	"click",
	"#btnVisualizarCronogramaAlumno",
	function () {
		var codAdAlumCronograma = $(this).attr("codAdAlumCronograma");
		var data = new FormData();
		data.append("codAdAlumCronograma", codAdAlumCronograma);
		$.ajax({
			url: "ajax/admisionAlumnos.ajax.php",
			method: "POST",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function (response) {
				var modalBody = $("#cronogramaAdmisionPago .modal-body");
				modalBody.empty();

				// Crear la tabla y agregarla al cuerpo del modal
				var table = $("<table>").addClass("table");
				modalBody.append(table);

				// Crear la cabecera de la tabla
				var thead = $("<thead>");
				var headerRow = $("<tr>");
				headerRow.append($("<th>").text("Mes"));
				headerRow.append($("<th>").text("Fecha Límite"));
				headerRow.append($("<th>").text("Monto"));
				headerRow.append($("<th>").text("Estado"));
				headerRow.append($("<th>").text("Fecha de Pago"));
				thead.append(headerRow);
				table.append(thead);

				// Crear el cuerpo de la tabla
				var tbody = $("<tbody>");
				table.append(tbody);

				$.each(response, function (index, item) {
					var row = $("<tr>");

					var counterCell = $("<td>");
					if (index == 0) {
						counterCell.text("Matrícula");
					} else if (index == 1) {
						counterCell.text("Cuota Ingreso");
					} else {
						counterCell.text(item.mesPago);
					}

					var fechaLimiteCell = $("<td>").text(
						formatFecha(item.fechaLimite)
					);
					var montoPagoCell = $("<td>").text("S/ " + item.montoPago);

					var estadoCronogramaPagoCell = $("<td>");
					var spanEstado = $("<span>").addClass("badge rounded-pill");
					if (item.estadoCronogramaPago == "Pendiente") {
						spanEstado.addClass("bg-warning").text("Pendiente");
					} else if (item.estadoCronogramaPago == "Cancelado") {
						spanEstado.addClass("bg-success").text("Cancelado");
					} else if (item.estadoCronogramaPago == "Anulado") {
						spanEstado.addClass("bg-danger").text("Anulado");
					}
					estadoCronogramaPagoCell.append(spanEstado);

					// Nueva celda para "Fecha de Pago"
					var fechaPagoCell = $("<td>");
					var spanFechaPago =
						$("<span>").addClass("badge rounded-pill");
					if (/^\d{4}-\d{2}-\d{2}$/.test(item.fechaPago)) {
						spanFechaPago.addClass("bg-info").text(item.fechaPago);
					} else {
						spanFechaPago
							.addClass("bg-danger")
							.text(item.fechaPago);
					}
					fechaPagoCell.append(spanFechaPago);

					row.append(
						counterCell,
						fechaLimiteCell,
						montoPagoCell,
						estadoCronogramaPagoCell,
						fechaPagoCell
					);
					tbody.append(row);
				});
			},
			/*  error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
      }, */
		});
	}
);
