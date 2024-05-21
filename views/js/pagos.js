//  crear nuevo pago
$("#btnAgregarNuevoPago").on("click", function () {
	window.location = "index.php?ruta=registrarPago";
});
//  cerrar crear nuevo pago
$(".cerrarRegistroPago").on("click", function () {
	window.location = "index.php?ruta=listaPagos";
});

// cerrar crear nuevo pago de postulante
$(".cerrarRegistroPagoPostulante").on("click", function () {
	window.location = "index.php?ruta=listaPostulantes";
});

// Funcion para obtener la fecha en formato "dia de mes del año"
function formatFecha(fecha) {
    // Obtenemos los elementos de la fecha
    var partesFecha = fecha.split('-');
    var año = partesFecha[0];
    var mes = partesFecha[1];
    var dia = partesFecha[2];

    // Creamos un objeto de fecha para obtener el nombre del mes
    var fechaObj = new Date(fecha);
    var meses = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];
    var nombreMes = meses[fechaObj.getMonth()];

    // Formateamos la fecha
    var fechaFormateada = dia + ' de ' + nombreMes + ' del ' + año;
    
    return fechaFormateada;
}

//  Vista para el modal de cronograma de pagos
$(".dataTableAdmisionAlumnos").on(
	"click",
	".btnVisualizarCronograma",
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

				$.each(response, function (index, item) {
					var div = $("<div>").addClass("mb-3");

					var label2 = $("<label>")
						.addClass("form-label h5 font-weight-bold")
						.attr("id", "tipoCronoPago")
						.attr("name", "tipoCronoPago")
						.css("margin-left", "8px") // Agrega un margen a la izquierda
						.html("<strong>" + item.mesPago + "</strong>");

					var inputGroup = $("<div>").addClass("input-group");

					var input1 = $("<input>")
						.attr("type", "text")
						.addClass("form-control")
						.attr("id", "fechaPago")
						.attr("name", "fechaPago")
						// uso de la funcion para justar el formato de la fecha
						.val("Fecha Límite: " + formatFecha(item.fechaLimite))
						.attr("readonly", true)
						.css("width", "auto"); // Establecer el ancho automático

					var input2 = $("<input>")
						.attr("type", "text")
						.addClass("form-control")
						.attr("id", "montoPago")
						.attr("name", "montoPago")
						.val("Monto: S/ " + item.montoPago)
						.attr("readonly", true)
						.css("width", "75px"); // Ajusta este valor según tus necesidades

					var input3 = $("<div>")
						.addClass("form-control fs-6 text-center")
						.attr("id", "stadoCronograma")
						.attr("name", "stadoCronograma")
						.html(item.estadoCronogramaPago);

					var button = $("<button>")
						.addClass(
							"btn btn-primary btnEditarCronogramaPagoModal"
						)
						.attr("data-bs-toggle", "modal")
						.attr("data-bs-target", "#modalEditCronoPago")
						.attr("id", "idCronogramaPagoModal")
						.attr("name", "idCronogramaPagoModal")
						.text("Editar")
						.val(item.idCronogramaPago)
						.on("click", function () {
							// Establece los valores en los campos de entrada del modal
							$("#mesEditCrono")
								.val(item.mesPago)
								.attr("value", item.mesPago);
							$("#fechaLimtEditCrono")
								.val(item.fechaLimite)
								.attr("fechaLimtEditCrono", item.fechaLimite);
							$("#montoEditCrono")
								.val(item.montoPago)
								.attr("montoEditCrono", item.montoPago);
							$("#btnEditCronoModal")
								.val(item.idCronogramaPago)
								.attr(
									"btnEditCronoModal",
									item.idCronogramaPago
								);

              // Oculta el modal 'cronogramaAdmisionPago'
              $("#cronogramaAdmisionPago").modal("hide");
            });
            
            // Deshabilitar el botón si el estado del cronograma es "Cancelado" (es igual a "Cancelado")
            if (item.estadoCronogramaPago == '<span class="badge rounded-pill bg-success">Cancelado</span>') {
              button.prop("disabled", true);
            }

           
          /* bien funciona ayudame con otra cosa necesito una funcion js  que al escuchar el btoon de editar tome el valor de  fechaLimtEditCrono,montoEditCrono  */
          inputGroup.append(input1, input2, input3, button);
          div.append(label2, inputGroup);
          modalBody.append(div);
          // Establece el manejador de eventos para el botón 'Editar' y 'Cerrar'
          var lastButtonClicked = null;
          // Cuando haces clic en el botón 'Editar'
          $(".btnEditCronoModal").on("click", function () {
            lastButtonClicked = "edit";
            // Oculta el modal 'modalEditCronoPago'
            $("#modalEditCronoPago").modal("hide");
          });
          // Cuando haces clic en el botón 'Cerrar'
          $(".btnCerrarEditCronoModal").on("click", function () {
            lastButtonClicked = "close";
            // Oculta el modal 'modalEditCronoPago'
            $("#modalEditCronoPago").modal("hide");
          });
          // Cuando el modal 'modalEditCronoPago' se oculta
          $("#modalEditCronoPago").on("hidden.bs.modal", function () {
            if (lastButtonClicked === "edit") {
              // Cierra el modal 'cronogramaAdmisionPago'
              $("#cronogramaAdmisionPago").modal("hide");
            } else if (lastButtonClicked === "close") {
              // Abre el modal 'cronogramaAdmisionPago'
              $("#cronogramaAdmisionPago").modal("show");
            }
          });
        });

				$("#cronogramaAdmisionPago").modal("show");
			},
			/*  error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
      }, */
		});
	}
);
//editar cronograma de pagos de pago modal editar
$(".btnEditCronoModal").on("click", function () {
	// Toma los valores de los campos de entrada
	var fechaLimtEditCrono = $("#fechaLimtEditCrono").val();
	var montoEditCrono = $("#montoEditCrono").val();
	var btnEditCronoModal = $("#btnEditCronoModal").val();

	// Guarda los valores en los atributos 'value' de los campos de entrada
	$("#fechaLimtEditCrono").attr("value", fechaLimtEditCrono);
	$("#montoEditCrono").attr("value", montoEditCrono);
	$("#btnEditCronoModal").attr("value", btnEditCronoModal);

	// Crea un objeto con los datos
	var dataEditCronoModal = {
		fechaLimtEditCrono: fechaLimtEditCrono,
		montoEditCrono: montoEditCrono,
		btnEditCronoModal: btnEditCronoModal,
	};

	// Crea un objeto FormData y añade el objeto
	var data = new FormData();
	data.append("dataEditCronoModal", JSON.stringify(dataEditCronoModal));

	// Envía los datos al servidor con una solicitud AJAX
	$.ajax({
		url: "ajax/pagos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response == "ok") {
				// Cierra el modal
				$("#modalEditCronoPago").modal("hide");

				// Muestra el mensaje de "Actualizado"
				Swal.fire({
					icon: "success",
					title: "Actualizado",
					text: "Cronograma de Pago Actualizado",
					timer: 2000,
					showConfirmButton: true,
				});
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
});

//vista para editar RegistroPago
$(".dataTablePagos").on("click", ".btnEditarPago", function () {
	// Obtener el código de pago del atributo del botón
	var codPago = $(this).attr("codPago");

	window.location = "index.php?ruta=editarPago&codPago=" + codPago;
});
// visualizar dato pago de alumno
$(".dataTablePagos ").on("click", ".btnVisualizarPago", function () {
	var codPago = $(this).attr("codPago");
	var data = new FormData();
	data.append("codPago", codPago);

	$.ajax({
		url: "ajax/pagos.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			$("#nombresDetalle").val(response.nombresAlumno);
			$("#apellidosDetalle").val(response.apellidosAlumno);
			$("#gradoDetalle").val(response.descripcionGrado);
			$("#nivelDertalle").val(response.nivelAlumno);
			$("#codigoCajaDetalle").val(response.codAlumnoCaja);
			$("#mesDetalle").val(response.mesPago);
			$("#LimitePagoDetalle").val(response.fechaLimite);

			// Abre el modal después de recibir la respuesta
			$("#modalDetallePago").modal("show");
		},
	});
});
//Eliminar registro de pago y actualizar el estado de cronograma de pago a 1 = pendiente
$(".dataTablePagos ").on("click", ".btnEliminarPago", function () {
	var codPago = $(this).attr("codPago");
	var data = new FormData();
	data.append("codPagoDelet", codPago);

	Swal.fire({
		icon: "warning",
		title: "Advertencia",
		html: "¿Está seguro de eliminar el registro de pago? <br> <br> <strong>¡Esta acción no se podra deshacer!</strong>",
		showCancelButton: true, // Muestra el botón de cancelación
		confirmButtonText: "Sí",
		cancelButtonText: "No",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: "ajax/pagos.ajax.php",
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
							title: "Correcto",
							text: "Registro Eliminado correctamente",
							timer: 1000,
							showConfirmButton: false,
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "Error",
							text: "Error al Eliminar el Registro",
							timer: 1000,
							showConfirmButton: false,
						});
					}
					setTimeout(function () {
						location.reload();
					}, 1000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
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

//  Buscar postulante por Apellidos y Nombres
$(document).ready(function () {
	$(".busquedaAlumPago").select2();

	$(".busquedaAlumPago").on("change", function () {
		var codAlumnoPago = $(this).val();

		if (codAlumnoPago == "0") {
			limpiarDatosAlumnoPago();
		} else {
			var data = new FormData();
			data.append("codAlumnoPago", codAlumnoPago);

			$.ajax({
				url: "ajax/alumnos.ajax.php",
				method: "POST",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",

				success: function (response) {
					actualizarDatosAlumnoPago(response);
					actualizarMesPago(response.calendario);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(jqXHR.responseText); // procedencia de error
					console.log(
						"Error en la solicitud AJAX: ",
						textStatus,
						errorThrown
					);
				},
			});
		}
	});

	const actualizarDatosAlumnoPago = (data) => {
		$("#dniCajaArequipa").val(data.dniAlumno);
		$("#anioPago").val(data.descripcionAnio);
		$("#nivelAlumnoPago").val(data.descripcionNivel);
		$("#gradoAlumnoPago").val(data.descripcionGrado);
	};

	const limpiarDatosAlumnoPago = () => {
		$("#dniCajaArequipa").val("");
		$("#anioPago").val("");
		$("#nivelAlumnoPago").val("");
		$("#gradoAlumnoPago").val("");
	};

	const actualizarMesPago = (calendarioPagos) => {
		let opciones = "<option value=''>Selecione Mes: </option>";
		calendarioPagos.forEach((pago) => {
			opciones += `<option value="${pago.idCronogramaPago}" concepto="${pago.conceptoPago}" fechaLimite="${pago.fechaLimite}" monto="${pago.montoPago}">${pago.mesPago}</option>`;
		});
		let cronograma = $("#cronogramaPago");
		cronograma.html(opciones);
	};

	//  Cambiar mes de pago
	$("#cronogramaPago").on("change", function () {
		var codCronograma = $(this).val();
		if (codCronograma == "") {
			limpiarDatosCronogramaPago();
		} else {
			var monto = $(this).find(":selected").attr("monto");
			var concepto = $(this).find(":selected").attr("concepto");
			var fechaLimite = $(this).find(":selected").attr("fechaLimite");

			//  Actualizar los valores con los datos del cronograma
			$("#montoPago").val(monto);
			$("#tipoPago").val(concepto);
			$("#fechaLimitePago").val(fechaLimite);
		}
	});

	const limpiarDatosCronogramaPago = () => {
		$("#montoPago").val("");
		$("#tipoPago").val("");
		$("#fechaLimitePago").val("");
	};
});
