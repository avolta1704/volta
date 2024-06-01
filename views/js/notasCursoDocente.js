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
$(document).ready(function () {
  // Solicitud AJAX inicial
  const idCurso = $(this).attr("idCurso");
  const idGrado = $(this).attr("idGrado");
  var data = new FormData();
  data.append("todoslosBimestres", true);
  data.append("idCurso", true);
  data.append("idGrado", true);

  // Define los nombres de los botones con texto, clases e ids como marcadores de posición
  var buttonNames = [
    { text: "Placeholder 1", class: "btn btn-primary", id: "" },
    { text: "Placeholder 2", class: "btn btn-secondary", id: "" },
    { text: "Placeholder 3", class: "btn btn-success", id: "" },
    { text: "Placeholder 4", class: "btn btn-danger", id: "" },
  ];

  $.ajax({
    url: "ajax/bimestre.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      // Actualiza el texto y el id de los botones basándose en la respuesta AJAX
      response.forEach((value, index) => {
        if (buttonNames[index]) {
          buttonNames[index].text = value.descripcionBimestre;
          buttonNames[index].id = "btnBimestre";
        }
      });

      const buttonContainer = $("#buttonContainer");

      buttonNames.forEach((button) => {
        const btn = $("<button></button>")
          .attr("type", "button")
          .attr("id", button.id)
          .addClass(button.class)
          .text(button.text)
          .css("margin-right", "10px") // Añadir margen a cada botón
          .click(function () {
            // Definir una variable igual a la descripción del bimestre al hacer clic en el botón
            var descripcionBimestre = button.text;
          });
        buttonContainer.append(btn);
      });
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // Procedencia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});
// Funcionalidad para los Botones de Bimestres
$("#buttonContainer").on("click", "#btnBimestre", function () {
  var descripcionBimestre = $(this).text();
  // Define los nombres de los botones con texto, clases e ids como marcadores de posición
  var buttonNames = [
    { text: "Placeholder 1", class: "btn btn-warning", id: "" },
    { text: "Placeholder 2", class: "btn btn-info", id: "" },
  ];
  // Solicitud AJAX inicial
  var data = new FormData();
  data.append("descripcionBimestre", descripcionBimestre);

  $.ajax({
    url: "ajax/unidad.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      $("#secondButtonContainer").empty();
      // Actualiza el texto y el id de los botones basándose en la respuesta AJAX
      response.forEach((value, index) => {
        if (buttonNames[index]) {
          buttonNames[index].text = value.descripcionUnidad;
          buttonNames[index].id = "btnUnidad";
        }
      });

      const buttonContainer = $("#secondButtonContainer");

      buttonNames.forEach((button) => {
        const btn = $("<button></button>")
          .attr("type", "button")
          .attr("id", button.id)
          .addClass(button.class)
          .text(button.text)
          .css("margin-right", "10px") // Añadir margen a cada botón
          .click(function () {
            // Definir una variable igual a la descripción de la unidad al hacer clic en el botón
            var descripcionUnidad = button.text;
          });
        buttonContainer.append(btn);
      });
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // Procedencia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});
