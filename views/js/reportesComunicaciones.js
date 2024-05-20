$(".dataTableReportesComunicaciones").on(
	"click",
	".btnVerComunicadosAlumno",
	function () {
		var codAlumnoComunicado = $(this).attr("codAlumnoComunicado");
		var codAlumno = $(this).attr("codAlumno");
		window.location =
			"index.php?ruta=registrarComunicadoPago&codAdAlumCronograma=" +
			codAlumnoComunicado +
			"&codAlumno=" +
			codAlumno;
	}
);
