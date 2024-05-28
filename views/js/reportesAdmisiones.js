// Select de meses
$("#anioLectivo").select2({
	theme: "bootstrap-5",
	width: $(this).data("width")
		? $(this).data("width")
		: $(this).hasClass("w-100")
		? "100%"
		: "style",
	placeholder: $(this).data("placeholder"),
	closeOnSelect: false,
});

$("#btnCerrarSeleccionarAnioLectivo").on("click", function () {
	// limpia el select
	$("#anioLectivo").val(null).trigger("change");
});

$("#btnDescargarAnioLectivo").on("click", function () {
	$("#anioLectivo").val(null).trigger("change");
	// obtiene el valor seleccionado
});
