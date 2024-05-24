$(document).ready(function () {
  // Agregar el evento click al botón "Asignar Curso" dentro del modal
  $("#seleccionarCursosAsignados").on(
    "click",
    "#btnAsignarCurso",
    function (event) {
      // Agrega el parámetro event aquí
      // Obtener los valores seleccionados
      var gradoSeleccionado = $("#selectGrado").val();
      var cursoSeleccionado = $("#selectCurso").val();

      // Ahora puedes usar los valores seleccionados como desees, por ejemplo, mostrarlos en una alerta
      alert(
        "Grado seleccionado: " +
          gradoSeleccionado +
          "\nCurso seleccionado: " +
          cursoSeleccionado
      );

      // Si deseas realizar alguna acción adicional con los datos seleccionados, puedes hacerlo aquí
    }
/*     SELECT
	curso_grado.idCursoGrado
FROM
	curso_grado
	INNER JOIN
	curso
	ON 
		curso_grado.idCurso = curso.idCurso
	INNER JOIN
	grado
	ON 
		curso_grado.idGrado = grado.idGrado
WHERE
	curso.descripcionCurso = 'Ciencia y tecnologia' AND
	grado.descripcionGrado = '1er Año' */
  );
});
