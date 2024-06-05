// Abrir la vista de asistencia de alumnos
$("#dataTableCursosDocente").on(
	"click",
	".btnVisualizarAsistencia",
	function () {
		var idCurso = $(this).attr("idCurso");
		var idGrado = $(this).attr("idGrado");
		var idPersonal = $(this).attr("idPersonal");
		window.location =
			"index.php?ruta=visualizarAsistencia&idCurso=" +
			idCurso +
			"&idGrado=" +
			idGrado +
			"&idPersonal=" +
			idPersonal;
	}
);
