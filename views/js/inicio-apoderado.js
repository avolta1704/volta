$(".alumno-item").click(function () {
  // Obtener el idAlumno del elemento clickeado
  var idAlumno = $(this).data("id-alumno");
  datos.setAttribute('data-primer-id-alumno', idAlumno);
  // Recargar la página
  location.reload();
});
$(document).ready(function () {});
