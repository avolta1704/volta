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
