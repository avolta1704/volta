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
  // Obtener la URL actual
  var urlParams = new URLSearchParams(window.location.search);

  // Obtener el valor de los parámetros de la URL
  var ruta = urlParams.get("ruta");
  var idCurso = urlParams.get("idCurso");
  var idGrado = urlParams.get("idGrado");
  var idPersonal = urlParams.get("idPersonal");
  var data = new FormData();
  data.append("todoslosBimestres", true);
  data.append("idCurso", idCurso);
  data.append("idGrado", idGrado);

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
          buttonNames[index].data = {
            idBimestre: value.idBimestre,
            estadoBimestre: value.estadoBimestre,
          }; // Almacenar idBimestre y estado del bimestre en data
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
          .data("idBimestre", button.data.idBimestre) // Guardar idBimestre en data
          .prop("disabled", button.data.estadoBimestre == 0); // Deshabilitar botón si estadoUnidad es 0
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
  var idBimestre = $(this).data("idBimestre"); // Obtener idBimestre
  // Define los nombres de los botones con texto, clases e ids como marcadores de posición
  var buttonNames = [
    { text: "Placeholder 1", class: "btn btn-warning", id: "" },
    { text: "Placeholder 2", class: "btn btn-info", id: "" },
  ];
  // Solicitud AJAX inicial
  var data = new FormData();
  data.append("idBimestre", idBimestre);

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
      $("#thirdButtonContainer").empty();
      // Limpiar el DataTable
      $("#dataTableNotasCursoDocente").DataTable().clear().draw();
      // Actualiza el texto y el id de los botones basándose en la respuesta AJAX
      response.forEach((value, index) => {
        if (buttonNames[index]) {
          buttonNames[index].text = value.descripcionUnidad;
          buttonNames[index].id = "btnUnidad";
          buttonNames[index].data = {
            idUnidad: value.idUnidad,
            estadoUnidad: value.estadoUnidad,
            idBimestre: idBimestre,
          }; // Almacenar idUnidad y estadoUnidad en data
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
          .data("idUnidad", button.data.idUnidad) // Guardar idUnidad en data
          .data("idBimestre", button.data.idBimestre) // Guardar idBimestre en data
          .prop("disabled", button.data.estadoUnidad == 0); // Deshabilitar botón si estadoUnidad es 0
        buttonContainer.append(btn);
      });
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // Procedencia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

// Funcionalidad para el boton Ver Competencias
$("#thirdButtonContainer").on("click", "#btnVerCompetencias", function () {
  $("#modalCompetenciaUnidad").modal("show");
});
//Funcionalidad para el boton cerrar el modal de crear competencia
$("#modalIngresarCompetencia").on(
  "click",
  "#btnCerrarModalCompetencia",
  function () {
    $("#modalIngresarCompetencia").modal("hide");
    $("#modalCompetenciaUnidad").modal("show");
  }
);
// Funcionalidad para asignarle un idUnidad al botón btnAgregarCompetencia
$("#btnAgregarCompetencia").on("click", function () {
  var idUnidad = $(this).attr("idUnidad"); // Obtén el valor de idUnidad del botón btnAgregarCompetencia
  $("#btnCrearCompetencia").attr("idUnidad", idUnidad); // Establece el valor de idUnidad en el botón btnCrearCompetencia
  // Limpiar el contenido de notaText
  $("#notaText").val("");
});
// Funcionalidad para el botón de crear competencia
$("#modalIngresarCompetencia").on("click", "#btnCrearCompetencia", function () {
  var idUnidad = $(this).attr("idUnidad"); // Obtén el valor de idUnidad del botón btnCrearCompetencia
  var notaText = $("#notaText").val(); // Obtén el valor del elemento con id notaText
  var data = new FormData();
  data.append("idUnidadCrear", idUnidad);
  data.append("descripcionCompetenciaCrear", notaText);
  $.ajax({
    url: "ajax/competencia.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response == "ok") {
        Swal.fire({
          title: "Competencia Creada",
          text: "La competencia se ha creado con éxito.",
          icon: "success",
          confirmButtonText: "Aceptar",
        }).then((result) => {
          if (result.isConfirmed) {
            $("#modalIngresarCompetencia").modal("hide");
            $("#modalCompetenciaUnidad").modal("hide");
          }
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // Procedencia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

// Funcionalidad para el modal de editar competencia
$("#dataTableCompetencias").on("click", ".btnEditarCompetencias", function () {
  var idCompetencia = $(this).attr("idCompetencia"); // Obtén el idCompetencia del botón
  descripcionCompetencia = $(this).attr("descripcionCompetencia"); // Obtén la descripción de la competencia
  const notaText = $("#notaTextEditar");
  notaText.val(descripcionCompetencia); // Establece el valor del campo de entrada con la descripción de la competencia
  // Funcionalidad del boton Guardar Competencia
  $("#modalEditarCompetencia").on(
    "click",
    "#btnGuardarCompetencia",
    function () {
      const currentValue = notaText.val();
      if (currentValue != descripcionCompetencia) {
        var data = new FormData();
        data.append("idCompetencia", idCompetencia);
        data.append("notaTextModificada", currentValue);
        // Modificar la competencia
        $.ajax({
          url: "ajax/competencia.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            if (response == "ok") {
              Swal.fire({
                title: "Competencia Modificada",
                text: "La competencia se ha modificado con éxito.",
                icon: "success",
                confirmButtonText: "Aceptar",
              }).then((result) => {
                if (result.isConfirmed) {
                  $("#modalEditarCompetencia").modal("hide");
                  $("#modalCompetenciaUnidad").modal("hide");
                }
              });
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText); // Procedencia de error
            console.log(
              "Error en la solicitud AJAX: ",
              textStatus,
              errorThrown
            );
          },
        });
      } else {
        Swal.fire({
          title: "Sin Cambios",
          text: "No se han realizado cambios en la competencia.",
          icon: "info",
          confirmButtonText: "Aceptar",
        });
      }
    }
  );
});
//Funcionalidad para el boton cerrar el modal de editar competencia
$("#modalEditarCompetencia").on(
  "click",
  "#btnCerrarModalEditarCompetencia",
  function () {
    $("#modalEditarCompetencia").modal("hide");
    $("#modalCompetenciaUnidad").modal("show");
  }
);

$("#modalCompetenciaUnidad").on(
  "click",
  "#btnDuplicarCompetencia",
  function () {
    var idUnidad = $(this).attr("idUnidad"); // Obtén el valor de idUnidad del botón btnAgregarCompetencia
    // Limpiar el contenedor
    $("#competenciasContainer").empty();
    // Contenedor donde se agregarán las opciones
    var competenciasContainer = $("#competenciasContainer");
    // Obtener la URL actual
    var urlParams = new URLSearchParams(window.location.search);

    // Obtener el valor de los parámetros de la URL
    var ruta = urlParams.get("ruta");
    var idCurso = urlParams.get("idCurso");
    var idGrado = urlParams.get("idGrado");
    var idPersonal = urlParams.get("idPersonal");

    var data = new FormData();
    data.append("competenciasDuplicar", true);
    data.append("idCurso", idCurso);
    data.append("idGrado", idGrado);
    data.append("idPersonal", idPersonal);
    // Modificar la competencia
    $.ajax({
      url: "ajax/competencia.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        // Iterar sobre el array de opciones y agregarlas al contenedor
        response.forEach(function (competencia, index) {
          var checkboxId = "competencia" + (index + 1);
          var checkboxInput = $("<input>")
            .addClass("form-check-input")
            .attr({ type: "checkbox", id: checkboxId });
          var checkboxLabel = $("<label>")
            .addClass("btn btn-outline-primary")
            .text(competencia.descripcionCompetencia)
            .attr({ for: checkboxId, role: "button" });
          var formCheck = $("<div>")
            .addClass("form-check")
            .append(checkboxInput, checkboxLabel);
          competenciasContainer.append(formCheck);
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText); // Procedencia de error
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
    $("#modalDuplicarCompetencia").on(
      "click",
      "#btnDuplicarCompetenciaModal",
      function () {
        // Obtener todos los checkboxes marcados
        var selectedCheckboxes = $(
          "#competenciasContainer input[type='checkbox']:checked"
        );
        // Inicializar los contadores
        var countZero = 0;
        var countOne = 0;

        // Iterar sobre los checkboxes marcados y obtener sus valores
        selectedCheckboxes.each(function () {
          var checkboxValue = $(this).next("label").text();
          var data = new FormData();
          data.append("checkboxValue", checkboxValue);
          data.append("idUnidad", idUnidad);
          // Modificar la competencia
          $.ajax({
            url: "ajax/competencia.ajax.php",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
              if (response == "ok") {
                countZero++;
              } else if (response == "creado") {
                countOne++;
              }
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText); // Procedencia de error
              console.log(
                "Error en la solicitud AJAX: ",
                textStatus,
                errorThrown
              );
            },
          });
        });
        Swal.fire({
          title: "Competencias Duplicadas",
          text: "Se han insertado con éxito.",
          icon: "success",
          confirmButtonText: "Aceptar",
        }).then((result) => {
          if (result.isConfirmed) {
            $("#modalDuplicarCompetencia").modal("hide");
            $("#modalCompetenciaUnidad").modal("hide");
          }
        });
      }
    );
  }
);
$("#modalDuplicarCompetencia").on(
  "click",
  "#btnCerrarmodalDuplicarCompetencia",
  function () {
    $("#modalDuplicarCompetencia").modal("hide");
    $("#modalCompetenciaUnidad").modal("show");
  }
);
$("#dataTableCompetencias").on("click", ".btnEliminarCompetencia", function () {
  var idCompetencia = $(this).attr("idCompetencia"); // Obtén el idCompetencia del botón}
  Swal.fire({
    title: "¿Estás seguro de que deseas eliminar la competencia?",
    text: "¡Se eliminará la competencia seleccionada!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      var data = new FormData();
      data.append("idCompetenciaEliminar", idCompetencia);
      $.ajax({
        url: "ajax/competencia.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (response == "ok") {
            Swal.fire({
              title: "¡Competencia Eliminada!",
              text: "La competencia ha sido eliminada con éxito.",
              icon: "success",
            }).then(function (result) {
              if (result.isConfirmed) {
                $("#modalCompetenciaUnidad").modal("hide");
              }
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText); // Procedencia de error
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
  });
});
